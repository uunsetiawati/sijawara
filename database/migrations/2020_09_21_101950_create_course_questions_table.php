<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->integer('course_content_id')->unsigned();
            $table->foreign('course_content_id')->references('id')->on('course_contents')
                  ->onDelete('cascade');

            $table->text('question');
            $table->text('a_answer')->nullable();
            $table->text('b_answer')->nullable();
            $table->text('c_answer')->nullable();
            $table->text('d_answer')->nullable();
            $table->enum('answer', ['a', 'b', 'c', 'd'])->nullable();
            $table->text('description')->nullable();

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
        Schema::dropIfExists('course_questions');
    }
}
