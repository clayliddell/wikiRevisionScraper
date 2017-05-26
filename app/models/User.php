<?php
	namespace App\Models;

	use \Illuminate\Database\Eloquent\Model;

	class User extends Model
	{
		public $timestamps = false;
		
		protected $table = 'Users';
		protected $fillable = ['id','name'];
		
		public function page()
		{
			$this->belongsTo('Models\Revision');
		}
	}