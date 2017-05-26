<?php
	namespace App\Models;

	use \Illuminate\Database\Eloquent\Model;

	class Revision extends Model
	{
		public $timestamps = false;
		
		protected $table = 'Revisions';
		protected $fillable = ['id', 'parent_id', 'page_id', 'user_id', 'timestamp', 'size'];

		public function category()
		{
			$this->belongsTo('Models\Page');
		}

		public function user()
		{
			$this->hasOne('Models\User');
		}
	}