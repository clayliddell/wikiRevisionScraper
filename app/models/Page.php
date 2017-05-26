<?php
	namespace App\Models;

	use \Illuminate\Database\Eloquent\Model;

	class Page extends Model
	{
		public $timestamps = false;
		
		protected $table = 'Pages';
		protected $fillable = ['id','name','category_id'];

		public function category()
		{
			$this->belongsTo('Models\Category');
		}

		public function revisions()
		{
			$this->hasMany('Models\Revision');
		}
	}