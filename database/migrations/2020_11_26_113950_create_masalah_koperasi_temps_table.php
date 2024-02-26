<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasalahKoperasiTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masalah_koperasi_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('koperasi_id')->unsigned();
            $table->foreign('koperasi_id')->references('id')->on('koperasis')
                          ->onDelete('cascade');
                          
            $table->integer('masalah_koperasi_id')->unsigned();
            $table->foreign('masalah_koperasi_id')->references('id')->on('masalah_koperasis')
                          ->onDelete('restrict');
            $table->string('isi')->nullable();
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
        Schema::dropIfExists('masalah_koperasi_temps');
    }
}
