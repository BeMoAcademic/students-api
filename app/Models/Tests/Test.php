<?php

namespace App\Models\Tests;

use App\Models\BaseModel;
use App\Models\Plan;
use App\Models\Users\Student;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Test extends BaseModel {
	use SoftDeletes;
	
	protected $dates = ['deleted_at'];
	protected $appends = ['logoPreview'];

    /**
     * @var string
     */
    protected static $logName = 'test';
	
	public function testTakers() {
		return $this->belongsToMany(Student::class)->withTimestamps();
	}
	
	public function plans() {
		return $this->belongsToMany(Plan::class)->withPivot('takes', 'needs_grading', 'plan_id')->withTimestamps();
	}
	
	public function questions() {
		return $this->hasMany(Question::class);
	}
	
	public function testTakes() {
		return $this->hasMany(TestTake::class);
	}
	
	public function fixQuestionOrder() {
		$questions = $this->questions()->orderBy('order')->get();
		$i = 0;
		foreach ($questions as $question) {
			$question->order = $i++;
			$question->save();
		}
	}

	public function logoUrl() {
		if ($this->logo) {
			return url('/') . Storage::disk('local')->url($this->logo);
		} 
		else return null;
	}

	public function getLogoPreviewAttribute() {
		if ($this->logo) {
			if (Storage::disk('local')->exists($this->logo)) {
				return "<div class=\"file-preview-logo\"><img src=\"" . $this->logoUrl() . "\" /></div>";
			}
		}	
		return null;
	}

	public function texts() {
		return $this->hasMany(TestText::class);
	}
}