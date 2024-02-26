<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWilayahPemasaranTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wilayah_pemasaran_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('ukm_id')->unsigned();
            $table->foreign('ukm_id')->references('id')->on('ukms')
                          ->onDelete('cascade');
                          
            $table->integer('wilayah_pemasaran_id')->unsigned();
            $table->foreign('wilayah_pemasaran_id')->references('id')->on('wilayah_pemasarans')
                          ->onDelete('restrict');
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
        Schema::dropIfExists('wilayah_pemasaran_temps');
    }
}
