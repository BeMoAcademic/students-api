<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentFilesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('student_files', function (Blueprint $table) {

			$table->id();
			$table->unsignedBigInteger('student_id')->unsigned();
			$table->string('name');
			$table->string('resource')->nullable();
			$table->unsignedBigInteger('test_grader_id')->nullable()->unsigned();
			$table->unsignedBigInteger('conversation_id')->nullable()->unsigned();
			$table->softDeletes();
			$table->timestamps();

			$table->foreign('student_id')->references('id')->on('students')
				->onDelete('cascade');


		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('student_files');
	}
}
