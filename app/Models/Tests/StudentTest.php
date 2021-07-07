<?php

namespace App\Models\Tests;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Student;

class StudentTest extends Model {
	
	protected $dates = ['created_at', 'updated_at'];
	
	public function test() {
		return $this->belongsTo('App\Models\Tests\Test');
	}

	public function student() {
		return $this->belongsTo('App\Models\Users\Student');
	}
}
