<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('questions', function (Blueprint $table) {
			$table->id();
			$table->integer('test_id')->unsigned();
			$table->integer('order')->unsigned();
			$table->string('resource')->nullable();
			$table->text('instructions');
			$table->integer('instructions_time');
			$table->text('text');
			$table->boolean('question_buzzer')->default(false);
			$table->integer('questions_number');
			for ($i = 1; $i < 4; $i++) {
				$table->text('question' . $i);
			}
			$table->integer('question_time');
			$table->string('answer_type');
			$table->boolean('show_text_recording')->default(true);
			$table->integer('answer_time');
			for ($i = 1; $i < 10; $i++) {
				$table->string('scale_label' . $i)->nullable();
			}
			$table->boolean('buzzer')->default(false);
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
		Schema::dropIfExists('questions');
	}
}
