<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTakesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('test_takes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('test_id')->unsigned();
			$table->integer('student_id')->unsigned();
			$table->integer('plan_id')->unsigned()->nullable();
			$table->boolean('finished')->default(false);
			$table->float('score')->nullable();
			$table->boolean('needs_grading')->default(true);
			$table->integer('test_grader_id')->unsigned()->nullable();
			$table->boolean('show_notification')->default(true);
			$table->timestamps();
			
			$table->foreign('test_id')->references('id')->on('tests')
				->onDelete('cascade');
			
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
		Schema::dropIfExists('test_takes');
	}
}
