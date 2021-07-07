<?php

namespace App\Models\Users;

use App\Models\Comment;
use App\Models\Tests\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuperUser extends Model {
	
	use SoftDeletes;
	
	protected $dates = ['deleted_at'];
	
	public $loginPage = "/super/home";
	
	
	public function user() {
		return $this->morphOne(User::class, 'user');
	}
	
	public function test() {
		return $this->belongsTo(Test::class);
	}
	
	public function comments() {
		return $this->morphMany(Comment::class, 'commenter');
	}
}
