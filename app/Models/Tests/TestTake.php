<?php

namespace App\Models\Tests;

use App\Models\User;
use App\Models\Users\Student;
use App\Models\Users\TestGrader;
use Illuminate\Database\Eloquent\Model;

class TestTake extends Model {
	
	protected $casts = [
		'finished' => 'boolean',
		'needs_grading' => 'boolean',
		'show_notification' => 'boolean',
	];
	
	public function user() {
		return $this->belongsTo(User::class);
	}
	
	public function answers() {
		return $this->hasMany(Answer::class);
	}
	
	public function test() {
		return $this->belongsTo(Test::class);
	}
	
	public function student() {
		return $this->belongsTo(Student::class);
	}
	
	public function testGrader() {
		return $this->belongsTo(TestGrader::class);
	}
	
	public function gradedBy() {
        return $this->belongsTo(TestGrader::class, 'graded_by');
    }
	
	public function isToBeGraded() {
		return $this->test_grader_id == null && $this->needs_grading && $this->score == null;
	}
	
}
