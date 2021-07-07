<?php

namespace App\Models;

use App\Models\Users\Student;
use App\Models\Users\TestGrader;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentFile extends BaseModel {
	use SoftDeletes;

    /**
     * @var string[]
     */
	protected $dates = ['deleted_at', 'taken_at'];

    /**
     * @var string[]
     */
	protected $appends = [
		'link',
	];

    /**
     * @var string[]
     */
    protected static $recordEvents = ['deleted'];


    /**
     * @var string
     */
    protected static $logName = 'studentFile';
	
	public function student() {
		return $this->belongsTo(Student::class);
	}
	
	public function getLinkAttribute() {
		return action('Resources\ResourceController@studentFile', $this);
	}
	
	public function comments() {
		return $this->morphMany(Comment::class, 'resource');
	}
	
	public function grader() {
		return $this->belongsTo(TestGrader::class, 'test_grader_id');
	}
	
	public function markAsTaken(TestGrader $grader) {
        $this->taken_at = Carbon::now();
		$grader->files()->save($this);
	}
	
	public function responses() {
		return $this->hasMany(StudentFileResponse::class, 'student_file_id');
	}
	
	public function latestResponse() {
		return $this->hasOne(StudentFileResponse::class, 'student_file_id')->latest();
	}
	
	public function scopeApproved($query) {
		return $query->where('approved', true);
	}
	
	public function scopeNeedsResponse($query) {
		return $query->whereHas('student', function ($query) {
			return $query->where('deleted_at', null);
		})->where(function ($query) {
			$query->whereDoesntHave('latestResponse')
				->orWhereHas('latestResponse', function ($query) {
					return $query->where('owner_type', Student::class);
				});
		});
	}
	
	/**
	 *  Added student response with the student files
	 *
	 * @param $query
	 * @param $studentClass
	 *
	 * @return mixed
	 */
	public function scopeStudentFileInfo($query, $studentClass) {
		return $query->leftJoin('student_file_responses', function ($join) {
			$join->on('student_file_responses.student_file_id', 'student_files.id')
			     ->on('student_file_responses.created_at', DB::raw("(SELECT max(student_file_responses.created_at) from student_file_responses WHERE student_file_responses.student_file_id = student_files.id)"));
		})->leftJoin('users', function ($join) {
			$join->on('student_files.student_id', 'users.user_id')->where('users.user_type', 'Student');
		})->select(
			'student_files.id as id',
			'student_files.*',
			DB::raw('IF (student_file_responses.created_at IS NULL,student_files.created_at,student_file_responses.created_at) as latest_response'),
			DB::raw("IF (student_file_responses.owner_type IS NULL OR student_file_responses.owner_type = '{$studentClass}',0,1) as needs_response")
		)->whereHas('student')->with(['student.user', 'responses' => function ($query) {
			return $query->latest();
		}, 'responses.owner.user', 'grader.user'])
        ->with(['comments' => function ($query) {
            $query->latest();
        }]);
	}
	
	/**
	 * Get files days ago
	 *
	 * @param $query
	 * @param $day
	 */
	public function scopeSinceDaysAgo($query, $day = 1) {
		$query->where('created_at', '>=', Carbon::now()->subDay($day));
	}
}
