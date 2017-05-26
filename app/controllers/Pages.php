<?php
	namespace App\Controllers;

	use \App\Models\Page;

	class Pages
	{
		public static function create($id, $name, $categoryID)
		{
			Page::create(['id'			=> $id,
						  'name'		=> $name,
						  'category_id' => $categoryID]);
		}

		public static function exists ($id)
		{
			return Page::find($id);
		}
	}