<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalitasUsahaTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legalitas_usaha_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('ukm_id')->unsigned();
            $table->foreign('ukm_id')->references('id')->on('ukms')
                          ->onDelete('cascade');
                          
            $table->integer('legalitas_usaha_id')->unsigned();
            $table->foreign('legalitas_usaha_id')->references('id')->on('legalitas_usahas')
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
        Schema::dropIfExists('legalitas_usaha_temps');
    }
}
