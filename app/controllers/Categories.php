<?php
	namespace App\Controllers;

	use \App\Models\Category;

	class Categories
	{
		public static function create($id, $name, $parentID)
		{
			Category::create(['id'			=> $id,
							  'name'		=> $name,
							  'parent_id'   => $parentID]);
		}

		public static function exists ($id)
		{
			return Category::find($id);
		}
	}