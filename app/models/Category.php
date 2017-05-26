<?php
	namespace App\Models;

	use \Illuminate\Database\Eloquent\Model;

	class Category extends Model
	{
		public $timestamps = false;
		
		protected $table = 'Categories';
		protected $fillable = ['id','name','parent_id'];

		public function parent()
		{
			$this->belongsTo('Models\Category', 'parent_id');
		}

		public function children()
		{
			$this->hasMany('Models\Category');
		}

		public function pages()
		{
			$this->hasMany('Models\Page');
		}
	}