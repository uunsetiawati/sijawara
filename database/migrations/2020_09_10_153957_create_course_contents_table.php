<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses')
                  ->onDelete('cascade');

            $table->string('title');
            $table->text('content');

            $table->string('module')->nullable();
            $table->string('video')->nullable();
            // $table->string('image')->nullable();
            $table->integer('no_urut')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_contents');
    }
}
