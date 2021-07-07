<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('meetings', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('student_id')->unsigned();
			$table->integer('grader_id')->unsigned();
			$table->string('type');
			$table->timestamp('date_time');
			$table->softDeletes();
			$table->timestamps();
			
			$table->foreign('student_id')->references('id')->on('students')
				->onDelete('cascade');
			$table->foreign('grader_id')->references('id')->on('test_graders')
				->onDelete('cascade');
			
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('meetings');
	}
}
