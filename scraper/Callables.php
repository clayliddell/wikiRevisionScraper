<?php
	namespace Scraper;

	use \RollingCurl\RollingCurl;
	use \RollingCurl\Request;

	use \App\Controllers\Categories;
	use \App\Controllers\Pages;
	use \App\Controllers\Revisions;
	use \App\Controllers\Users;

	use App\Includes\Config\Scraper As SCRAPE_CONFIG;

	abstract class WIKI_SCRAPE_CALLBACKS
	{
		private static $proxyHostIndex = 0;

		public static function GET_REQUEST_CONFIG ()
		{
			if (!empty(SCRAPE_CONFIG::CURL_OPTS))
				$options = SCRAPE_CONFIG::CURL_OPTS;
			else
				$options = array();

			if (!empty(SCRAPE_CONFIG::PROXY_HOST))
			{
				if (!empty(SCRAPE_CONFIG::PROXY_TYPE))
					$options[CURLOPT_PROXYTYPE] = SCRAPE_CONFIG::PROXY_TYPE;
				else
					$options[CURLOPT_PROXYTYPE] = CURLPROXY_SOCKS5;

				if (is_array(SCRAPE_CONFIG::PROXY_HOST))
					$options[CURLOPT_PROXY] = SCRAPE_CONFIG::PROXY_HOST[(self::$proxyHostIndex++ % 5)];
				else
					$options[CURLOPT_PROXY] = SCRAPE_CONFIG::PROXY_HOST;
			}

			return $options;
		}

		private static function GET_CATEGORY_NAME ($category)
		{
			if (substr($category, 0, strlen(SCRAPE_CONFIG::CATEGORY_PREFIX)) == SCRAPE_CONFIG::CATEGORY_PREFIX)
				$category = substr($category, strlen(SCRAPE_CONFIG::CATEGORY_PREFIX));

			return $category;
		}

		private static function GET_CONTINUE_URL ($url, $requestType, $continueArray)
		{
			if ($requestType == SCRAPE_CONFIG::REVISION_REQUEST)
				$continueParameter = 'rvcontinue';
			elseif ($requestType == SCRAPE_CONFIG::CATEGORY_REQUEST)
				$continueParameter = 'cmcontinue';
			else
				$continueParameter = false;

			if ($continueParameter)
			{
				$position = strpos($url, "&$continueParameter=");
				
				if ($position)
					$url = substr($url, 0, $position) . "&$continueParameter=" . $continueArray[$continueParameter];
				else
					$url = $url . "&$continueParameter=" . $continueArray[$continueParameter];
			}

			return $url;
		}

		public static function DISTRIBUTOR_CALLBACK (Request $request, RollingCurl $rollingCurl)
		{
			$info = $request->getExtraInfo();
			
			if ($info['request_type'] == SCRAPE_CONFIG::CATEGORY_REQUEST)
				self::CATEGORY_CALLBACK($request, $rollingCurl, $info['id']);
			elseif ($info['request_type'] == SCRAPE_CONFIG::REVISION_REQUEST)
				self::REVISION_CALLBACK($request, $rollingCurl, $info['id']);

			$rollingCurl->clearCompleted();
			$rollingCurl->prunePendingRequestQueue();
		}

		public static function CATEGORY_CALLBACK (Request $request, RollingCurl $rollingCurl, $categoryID)
		{
			$result = json_decode($request->getResponseText(), true);

			if (isset($result['continue']))
			{
				$continueURL = self::GET_CONTINUE_URL($request->getUrl(), SCRAPE_CONFIG::CATEGORY_REQUEST, $result['continue']);

				$rollingCurl->get($continueURL, null, WIKI_SCRAPE_CALLBACKS::GET_REQUEST_CONFIG(), ['id' => $categoryID, 'request_type' => SCRAPE_CONFIG::CATEGORY_REQUEST]);
			}

			$records = $result['query']['categorymembers'];

			foreach ($records as $record)
			{
				$rollingCurl->get(SCRAPE_CONFIG::REVISION_URL . $record['pageid'], null, WIKI_SCRAPE_CALLBACKS::GET_REQUEST_CONFIG(), ['id' => $record['pageid'], 'request_type' => SCRAPE_CONFIG::REVISION_REQUEST]);
				
				if ($record['ns'] == SCRAPE_CONFIG::PAGE_NS)
				{
					if (!Pages::exists($record['pageid']))
						Pages::create($record['pageid'], $record['title'], $categoryID);

					$rollingCurl->get(SCRAPE_CONFIG::REVISION_URL . $record['pageid'], null, WIKI_SCRAPE_CALLBACKS::GET_REQUEST_CONFIG(), ['id' => $record['pageid'], 'request_type' => SCRAPE_CONFIG::REVISION_REQUEST]);

				} elseif ($record['ns'] == SCRAPE_CONFIG::CATEGORY_NS)
				{
					if (!Categories::exists($record['pageid']))
						Categories::create($record['pageid'], self::GET_CATEGORY_NAME($record['title']), $categoryID);
					
					$rollingCurl->get(SCRAPE_CONFIG::SUB_CATEGORY_URL . $record['pageid'], null, WIKI_SCRAPE_CALLBACKS::GET_REQUEST_CONFIG(), ['id' => $record['pageid'], 'request_type' => SCRAPE_CONFIG::CATEGORY_REQUEST]);
				}
			}
		}

		public static function REVISION_CALLBACK (Request $request, RollingCurl $rollingCurl, $pageID)
		{
			$result = json_decode($request->getResponseText(), true);
			if (isset($result['continue']))
			{
				$continueURL = self::GET_CONTINUE_URL($request->getUrl(), SCRAPE_CONFIG::REVISION_REQUEST, $result['continue']);

				$rollingCurl->get($continueURL, null, WIKI_SCRAPE_CALLBACKS::GET_REQUEST_CONFIG(), ['id' => $pageID, 'request_type' => SCRAPE_CONFIG::REVISION_REQUEST]);
			}

			$records = $result['query']['pages'][$pageID]['revisions'];

			foreach ($records as $record)
			{
				if (!Revisions::exists($record['revid']))
					Revisions::create($record['revid'], $record['parentid'], $pageID, ($record['userid'] ?? 0), date("Y-m-d H:i:s", strtotime($record['timestamp'])), $record['size']);

				if (!Users::exists($record['userid']))
					Users::create($record['userid'], $record['user']);
			}
		}
	}