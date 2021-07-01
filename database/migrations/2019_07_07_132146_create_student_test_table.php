<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTestTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('student_test', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('test_id')->unsigned();
			$table->unsignedBigInteger('student_id')->unsigned();
			$table->integer('takes')->unsigned();
			$table->boolean('needs_grading')->default(true);
			$table->unsignedBigInteger('plan_id')->unsigned()->nullable();
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
		Schema::dropIfExists('student_test');
	}
}
