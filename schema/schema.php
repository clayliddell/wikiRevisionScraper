<?php
	require('../vendor/autoload.php');

	use \App\Includes\Config;

	system('mysql -u ' . DATABASE::USERNAME . ' -p ' . Database::PASSWORD . ' ' . DATABASE::DATABASE ' < schema.sql');