<?php
	namespace App\Controllers;

	use \App\Models\User;

	class Users
	{
		public static function create($id, $name)
		{
			User::create(['id'   => $id,
						  'name' => $name]);
		}

		public static function exists ($id)
		{
			return User::find($id);
		}
	}