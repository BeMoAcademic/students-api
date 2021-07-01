<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanUserResourceTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('plan_user_resource', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_resource_id')->unsigned();
			$table->unsignedBigInteger('plan_id')->unsigned();
			$table->timestamps();

			$table->foreign('user_resource_id')->references('id')->on('user_resources')
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
		Schema::dropIfExists('plan_resource');
	}
}
