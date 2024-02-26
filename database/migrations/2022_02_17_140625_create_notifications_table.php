<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();

            $table->string('judul');
            $table->text('isi');
            $table->string('image')->nullable();
            $table->enum('onclick', ['SHOW_DETAIL', 'SHOW_COURSE', 'SHOW_COURSE_OTHER'])->default('SHOW_DETAIL');
            $table->string('target')->nullable(); // Digunakan jika onclick = SHOW_COURSE
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
        Schema::dropIfExists('notifications');
    }
}
