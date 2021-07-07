<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanStudentTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('plan_student', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('student_id')->unsigned();
			$table->integer('plan_id')->unsigned();
			$table->timestamps();
			
			$table->foreign('student_id')->references('id')->on('students')
				->onDelete('cascade');
			
			$table->foreign('plan_id')->references('id')->on('plans')
				->onDelete('cascade');
			
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('plan_student');
	}
}
