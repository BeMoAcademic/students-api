<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentUserResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_user_resource', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('student_id')->unsigned();
			$table->integer('user_resource_id')->unsigned();
			$table->timestamps();

			$table->foreign('student_id')->references('id')->on('students')
				->onDelete('cascade');

			$table->foreign('user_resource_id')->references('id')->on('user_resources')
				->onDelete('cascade');        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_user_resource');
    }
}
