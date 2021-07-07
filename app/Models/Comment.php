<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
	
	public function commenter() {
		return $this->morphTo();
	}
	
	
	public function resource() {
		return $this->morphTo();
	}
}
