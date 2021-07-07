<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('grades', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('answer_id')->unsigned();
			$table->text('comment')->nullable();
			$table->integer('score');
			$table->text('technical_issue')->nullable();
			$table->text('red_flag')->nullable();
			$table->integer('user_id')->unsigned();
			$table->softDeletes();
			$table->timestamps();
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('grades');
	}
}
