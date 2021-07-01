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
			$table->id();
			$table->unsignedBigInteger('test_id');
			$table->unsignedBigInteger('student_id');
			$table->unsignedBigInteger('plan_id')->nullable();
			$table->boolean('finished')->default(false);
			$table->float('score')->nullable();
			$table->boolean('needs_grading')->default(true);
			$table->unsignedBigInteger('test_grader_id')->nullable();
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
