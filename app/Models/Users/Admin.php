<?php

namespace App\Models\Users;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model {
	use SoftDeletes;
	
	protected $dates = ['deleted_at'];
	
	public $loginPage = "/super/home";
	
	
	public function user() {
		return $this->morphOne(User::class, 'user');
	}

    public function comments() {
        return $this->morphMany(Comment::class, 'commenter');
    }
}
