<?php

namespace App\Models\Tests;

use Illuminate\Database\Eloquent\Model;

class TestText extends Model {
	
	public function test() {
		return $this->belongsTo(Test::class);
	}
	
	
}