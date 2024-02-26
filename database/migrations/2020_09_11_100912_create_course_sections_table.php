<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade');

            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id')->references('id')->on('courses')
                  ->onDelete('cascade');

            $table->integer('section')->nullable();
            $table->enum('is_finish', ['Y', 'N'])->default('N');
            $table->integer('course_other_id')->unsigned()->nullable();
            $table->foreign('course_other_id')->references('id')->on('course_others')
                  ->onDelete('cascade');

            $table->enum('status', ['0', '1', '2', '3', '4'])->default('0');
            $table->integer('nilai')->nullable();
            $table->enum('is_remidi', ['0', '1', '2', '3', '4'])->default('0');
            $table->timestamp('finished_at')->nullable();
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
        Schema::dropIfExists('course_sections');
    }
}
