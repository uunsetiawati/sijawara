<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade');

            $table->integer('course_content_id')->unsigned()->nullable();
            $table->foreign('course_content_id')->references('id')->on('course_contents')
                  ->onDelete('cascade');

            $table->integer('course_question_id')->unsigned()->nullable();
            $table->foreign('course_question_id')->references('id')->on('course_questions')
                  ->onDelete('cascade');

            $table->enum('answer', ['a', 'b', 'c', 'd'])->nullable();

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
        Schema::dropIfExists('question_answers');
    }
}
