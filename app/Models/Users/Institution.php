<?php

namespace App\Models\Users;

use App\Models\Tests\Answer;
use App\Models\Tests\Test;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model {

	use SoftDeletes;

	protected $dates = ['deleted_at'];


	public function getLoginPageAttribute() {
		return $this->password_changed == 0 ? '/admin/password' : 'admin';
	}

	public function user() {
		return $this->morphOne(User::class, 'user');
	}

	public function tests() {
		return $this->hasMany(Test::class);
	}


	public function test() {
		return $this->belongsTo(Test::class);
	}

	public function graders() {
		return $this->hasManyThrough(TestGrader::class, Test::class);
	}

	public function creators() {
		return $this->hasMany(TestCreator::class);
	}

	public function applicants() {
		return $this->hasManyThrough(Student::class, Test::class);
	}

	public function students() {
		$query = DB::table('super_users')->join('tests', function ($join) {
			$join->on('super_users.test_id', '=', 'tests.id')
				->where('tests.institution_id', $this->id);
		})->join('users', function ($join) {
			$join->on('super_users.id', '=', 'users.user_id')
				->where('users.user_type', 'Super User');
		})->select('users.email', 'users.name', 'tests.name as testName', 'super_users.score');

		$query1 = DB::table('test_takers')->join('tests', function ($join) {
			$join->on('test_takers.test_id', '=', 'tests.id')
				->where('tests.institution_id', $this->id);
		})->join('users', function ($join) {
			$join->on('test_takers.test_id', '=', 'users.user_id')
				->where('users.user_type', 'Test Taker');
		})->select('users.email', 'users.name', 'tests.name as testName', 'test_takers.score');

		return $query->union($query1);
	}

	public function skipped() {
		return $this->belongsToMany(Answer::class, 'answer_institution_skipped');
	}
}
