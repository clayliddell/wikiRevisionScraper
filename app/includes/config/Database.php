<?php
	namespace App\Includes\Config;

	abstract class DB
	{
		const DRIVER 	= 'mysql';
		const HOST 		= 'localhost';
		const DATABASE 	= 'wikiScrape';
		const USERNAME 	= 'root';
		const PASSWORD 	= '';
		const CHARSET 	= 'utf8';
		const COLLATION = 'utf8_unicode_ci';
		const PREFIX    = '';
	}