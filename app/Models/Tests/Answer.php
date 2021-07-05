<?php

namespace App\Models\Tests;

use App\Models\Users\Institution;
use App\Models\User;
use App\Models\Tests\TestTake;
use const Grpc\STATUS_OK;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Answer extends Model {
	
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $appends = ['url'];
	
	public function question() {
		return $this->belongsTo(Question::class);
	}
	
	public function getUrlAttribute() {
		if ($this->resource) {
			return Storage::url($this->resource, now()->addMinutes(5));
		}
		
		return false;
	}
	
	public function testTake() {
		return $this->belongsTo(TestTake::class);
	}
	
	public function grade() {
		return $this->hasOne(Grade::class);
	}
	
	public function getTestAttribute() {
		return Test::find($this->question->test_id);
	}
	
	public function scopeUngraded($query) {
		return $query->doesntHave('grade');
	}
	
	public function skipperInstitution() {
		return $this->belongsToMany(Institution::class, 'answer_institution_skipped');
	}
	
	public function skipperGraders() {
		return $this->belongsToMany(User::class, 'answer_grader_skipped');
	}
	
	public function scopeUnskipped($query, $user) {
		return $query->whereDoesntHave('skipperGraders', function ($query) use ($user) {
			return $query->where('answer_grader_skipped.user_id', $user->id);
		});
	}
	
	public function scopeNeedsGrading($query) {
		return $query->whereHas('testTake', function ($query) {
			$query->where('test_takes.needs_grading', 1);
		});
	}
}
