<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCategoryTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_category_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('blog_id')->unsigned()->nullable();
            $table->foreign('blog_id')->references('id')->on('blogs')
                  ->onDelete('cascade');
            $table->integer('blog_category_id')->unsigned()->nullable();
            $table->foreign('blog_category_id')->references('id')->on('blog_categories')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('blog_category_temps');
    }
}
