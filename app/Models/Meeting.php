<?php

namespace App\Models;

use App\Models\Users\Student;
use App\Models\Users\TestGrader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model {
	
	use SoftDeletes;
	
	protected $dates = [
		'date_time',
	];
	
	public function grader() {
		return $this->belongsTo(TestGrader::class);
	}
	
	public function student() {
		return $this->belongsTo(Student::class);
	}
	
	public function comments() {
		return $this->morphMany(Comment::class, 'resource');
	}
	
}
