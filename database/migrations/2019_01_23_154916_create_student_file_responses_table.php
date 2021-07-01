<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentFileResponsesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('student_file_responses', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('student_file_id')->unsigned();
			$table->morphs('owner');
			$table->text('comment')->nullable();
			$table->string('resource')->nullable();
			$table->string('file_name');

			$table->timestamps();

			$table->foreign('student_file_id')->references('id')->on('student_files')
				->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('student_file_responses');
	}
}
