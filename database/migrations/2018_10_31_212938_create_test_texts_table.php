<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_texts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id')->unsigned();
            $table->string('type');
            $table->string('title')->default('');
            $table->text('content');
            $table->string('button')->default('');
            $table->string('button_link')->nullable();
            $table->string('button_bg_color')->nullable();
            $table->string('button_color')->nullable();
            //Second button
            $table->string('button_2')->nullable();
            $table->string('button_2_link')->nullable();
            $table->string('button_2_bg_color')->nullable();
            $table->string('button_2_color')->nullable();

            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('test_id')->references('id')->on('tests')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_texts');
    }
}
