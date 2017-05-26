<?php
	namespace App\Controllers;

	use \App\Models\Revision;

	class Revisions
	{
		public static function create($id, $parentID, $pageID, $userID, $timestamp, $size)
		{
			echo $parentID . "\n";
			Revision::create(['id'			  => $id,
							  'parent_id'	  => $parentID,
						  	  'page_id'		  => $pageID,
						  	  'user_id'		  => $userID,
						  	  'timestamp'	  => $timestamp,
						  	  'size'		  => $size]);
		}

		public static function exists ($id)
		{
			return Revision::find($id);
		}
	}