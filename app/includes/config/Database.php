<?php
	namespace App\Includes\Config;

	abstract class Database
	{
		const DRIVER    = 'mysql';
		const HOST      = 'localhost';
		const DATABASE  = ''; 
		const USERNAME  = '';
		const PASSWORD  = '';
		const CHARSET   = 'utf8mb4';
		const COLLATION = 'utf8mb4_unicode_ci';
		const PREFIX    = '';
	}