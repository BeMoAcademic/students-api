<?php

namespace App\Models\Users;

use App\Events\Grader\GraderDeleted;
use App\Models\Comment;
use App\Models\Meeting;
use App\Models\StudentComment;
use App\Models\StudentFile;
use App\Models\StudentFileResponse;
use App\Models\Tests\Answer;
use App\Models\Tests\Grade;
use App\Models\Tests\Question;
use App\Models\Tests\Test;
use App\Models\Tests\TestTake;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestGrader extends Model {
	
	use SoftDeletes;
	public $loginPage = "grade";
	protected $dates = ['deleted_at'];
	
	protected static function boot() {
		parent::boot();
		static::deleting(function ($grader) {
			$grader->testTake()->update(['test_grader_id' => null]);
			$grader->files()->update(['test_grader_id' => null]);
		});
	}
	
	public function user() {
		return $this->morphOne(User::class, 'user');
	}
	
	public function test() {
		return $this->belongsTo(Test::class);
	}
	
	public function question() {
		return $this->belongsTo(Question::class);
	}
	
	public function grades() {
		return $this->hasMany(Grade::class);
	}
	
	public function comments() {
		return $this->morphMany(Comment::class, 'commenter');
	}
	
	public function meetings() {
		return $this->hasMany(Meeting::class);
	}
	
	public function files() {
		return $this->hasMany(StudentFile::class);
	}
	
	public function fileResponses() {
		return $this->morphMany(StudentFileResponse::class, 'owner');
	}
	
	
	public function testTake() {
		return $this->hasOne(TestTake::class);
	}

    public function activeTestTake()
    {
        return $this->hasOne(TestTake::class)->whereHas('test', function($q) {
            $q->whereNull('deleted_at');
        })->whereHas('student', function($q) {
            $q->whereHas('user');
        });
	}
}
