<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFileResponse extends Model {
	protected $appends = [
		'link',
	];
	
	public function owner() {
		return $this->morphTo();
	}
	
	public function getLinkAttribute() {
		return action('Resources\ResourceController@studentFileResponse', $this);
	}
	
	public function file() {
		return $this->belongsTo(StudentFile::class, 'student_file_id');
	}
}
