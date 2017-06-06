<?php
	namespace App\Includes\Config;

	abstract class Scraper
	{
		/**
	     * @var string
	     *
	     * Wiki URL used to retrieve all sub-categories.
	     *
		 * @required true
	     */
		const SUB_CATEGORY_URL = 'https://en.wikipedia.org/w/api.php?action=query&list=categorymembers&cmlimit=max&format=json&cmpageid=';
		
		/**
	     * @var string
	     *
	     * Wiki URL used to retrieve parent-categories.
	     *
		 * @required false
	     */
		const PAR_CATEGORY_URL = 'https://en.wikipedia.org/w/api.php?action=query&prop=categories&format=json&cllimit=max&pageids=';

		/**
	     * @var string
	     *
	     * Wiki URL used to retrieve all revisions for a page.
	     *
		 * @required true
	     */
		const REVISION_URL = 'https://en.wikipedia.org/w/api.php?action=query&prop=revisions&format=json&rvlimit=max&rvprop=user%7Cuserid%7Ctimestamp%7Csize%7Cids&pageids=';

		/**
	     * @var string
	     *
	     * Name of root category being scraped recursively.
	     *
		 * @required true
	     */
		const CATEGORY_ROOT = ''; // E.g. 'Politicians'

		/**
	     * @var int
	     *
	     * ID of root category being scraped recursively.
	     *
		 * @required true
	     */
		const CATEGORY_ROOT_ID = 693747;
		
		/**
	     * @var int
	     *
	     * Wiki Page Namespace
	     *
		 * @required true
	     */
		const PAGE_NS = 0;

		/**
	     * @var int
	     *
	     * Wiki Category Namespace
	     *
		 * @required true
	     */		
		const CATEGORY_NS = 14;
		
		/**
	     * @var int
	     *
	     * Prefix removed from all categories before being stored in database.
	     *
		 * @required false
	     */
		const CATEGORY_PREFIX = 'Category:';
		
		/**
	     * @var int
	     *
	     * Unique identifier for all category requests.
	     *
		 * @required true
	     */
		const CATEGORY_REQUEST = 1;

		/**
	     * @var int
	     *
	     * Unique identifier for all revision requests.
	     *
		 * @required true
	     */
		const REVISION_REQUEST = 2;

		/**
	     * @var array
	     * 
	     * CURL options to be used in all requests.
	     *
		 * @required false
	     */

		const CURL_OPTS = [CURLOPT_RETURNTRANSFER => 1,
                           CURLOPT_FOLLOWLOCATION => 1,
                           CURLOPT_MAXREDIRS      => 5,
                           CURLOPT_CONNECTTIMEOUT => 30,
                           CURLOPT_TIMEOUT        => 30];

		/**
	     * @var int
		 * 
	     * Option CURLOPT_PROXYTYPE in all requests made.
	     *
		 * @required false
	     */

		const PROXY_TYPE = CURLPROXY_SOCKS5;

		/**
		 * @var mixed
		 *
		 * Either an array or a string.
		 * If a string is provided, a single host is used for every connection.
		 * If an array is provided, more than one host is assumed and hosts are used roundrobin.
		 * 
		 * @required false
		 * 
		 * @syntax
		 *    singlehost:    'host:port'
		 *    multiplehosts: ['host1:port1', 'host2:port2',...]
		 */

		const PROXY_HOST = '';
	}