<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTestTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('plan_test', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('test_id')->unsigned();
			$table->unsignedBigInteger('plan_id')->unsigned();
			$table->integer('takes')->unsigned();
			$table->boolean('needs_grading')->default(true);
			$table->timestamps();

			$table->foreign('test_id')->references('id')->on('tests')
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
		Schema::dropIfExists('plan_test');
	}
}
