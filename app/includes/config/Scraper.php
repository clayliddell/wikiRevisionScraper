<?php
	namespace App\Includes\Config;

	abstract class WIKI
	{
		const SUB_CATEGORY_URL = 'https://en.wikipedia.org/w/api.php?action=query&list=categorymembers&cmlimit=max&format=json&cmpageid=';
		
		const PAR_CATEGORY_URL = 'https://en.wikipedia.org/w/api.php?action=query&prop=categories&format=json&cllimit=max&pageids=';

		const REVISION_URL = 'https://en.wikipedia.org/w/api.php?action=query&prop=revisions&format=json&rvlimit=max&rvprop=user%7Cuserid%7Ctimestamp%7Csize%7Cids&pageids=';

		const CATEGORY_ROOT = 'Politicians';

		const CATEGORY_ROOT_ID = 693747;
		
		const PAGE_NS = 0;
		
		const CATEGORY_NS = 14;
		
		const CATEGORY_PREFIX = 'Category:';

		const CATEGORY_REQUEST = 1;

		const REVISION_REQUEST = 2;
	}