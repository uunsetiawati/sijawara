<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBahanBakuTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_baku_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('ukm_id')->unsigned();
            $table->foreign('ukm_id')->references('id')->on('ukms')
                          ->onDelete('cascade');
                          
            $table->integer('bahan_baku_id')->unsigned();
            $table->foreign('bahan_baku_id')->references('id')->on('bahan_bakus')
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
        Schema::dropIfExists('bahan_baku_temps');
    }
}
