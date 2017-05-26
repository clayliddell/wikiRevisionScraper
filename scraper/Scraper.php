<?php
	namespace Scraper;

	require_once('Callables.php');

	use RollingCurl\RollingCurl;
	use RollingCurl\Request;

	use App\Models\Database;

	use App\Includes\Config\WIKI as SCRAPE_CONFIG;

	new Database();

	$rollingCurl = new RollingCurl();

	$rollingCurl
			->get(SCRAPE_CONFIG::SUB_CATEGORY_URL . SCRAPE_CONFIG::CATEGORY_ROOT_ID, null, null, ['id' => SCRAPE_CONFIG::CATEGORY_ROOT_ID, 'request_type' => SCRAPE_CONFIG::CATEGORY_REQUEST])
			->setCallback(['Scraper\WIKI_SCRAPE_CALLBACKS', 'DISTRIBUTOR_CALLBACK'])
			->setSimultaneousLimit(5)
			->execute();
	echo "DONE!\n";
