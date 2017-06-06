<?php
	namespace App\Models;

	use \Illuminate\Database\Capsule\Manager as Capsule;
	
	use \App\Includes\Config\Database as DB;
	
	class Database
	{
		function __construct()
		{
			$capsule = new Capsule;

			$capsule->addConnection([
				'driver'    => DB::DRIVER,
				'host'      => DB::HOST,
				'database'  => DB::DATABASE,
				'username'  => DB::USERNAME,
				'password'  => DB::PASSWORD,
				'charset'   => DB::CHARSET,
				'collation' => DB::COLLATION,
				'prefix'    => DB::PREFIX
			]);

			// Setup the Eloquent ORM... 
			$capsule->bootEloquent();
		}
	}