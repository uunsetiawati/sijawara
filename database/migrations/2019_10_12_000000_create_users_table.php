<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            // $table->string('username')->unique()->nullable();
            $table->string('name')->nullable();
            $table->enum('gender', ['0', '1', '2'])->nullable(); // 0 => Perempuan // 1 => Laki - Laki
            $table->string('position')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('image')->nullable();

            $table->integer('province_id')->unsigned()->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')
                  ->onDelete('restrict');

            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')
                  ->onDelete('restrict');

            $table->string('level');
            $table->enum('active', ['0', '1', '2'])->default('0'); // 0 => Belum Aktif // 1 => Aktif // 2 => BANNED
            $table->string('otp')->nullable();
            $table->string('otp_expire')->nullable();
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
        Schema::dropIfExists('users');
    }
}
