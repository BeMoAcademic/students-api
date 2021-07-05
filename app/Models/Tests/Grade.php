<?php

namespace App\Models\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model {
	use SoftDeletes;
	protected $dates = ['deleted_at'];


	public function user() {
		return $this->belongsTo('App\Models\Users\TestGrader');
	}

	public function answer() {
		return $this->belongsTo('App\Models\Test\Answer');
	}

}
