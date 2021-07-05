<?php

namespace App\Models\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestCreator extends Model {
	use SoftDeletes;
	public $loginPage = "create";

	protected $dates = ['deleted_at'];

	public function user() {
		return $this->morphOne(User::class, 'user');
	}

	public function institution() {
		return $this->belongsTo(Institution::class);
	}
}
