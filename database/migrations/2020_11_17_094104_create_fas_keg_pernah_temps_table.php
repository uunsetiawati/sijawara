<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFasKegPernahTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fas_keg_pernah_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('ukm_id')->unsigned();
            $table->foreign('ukm_id')->references('id')->on('ukms')
                          ->onDelete('cascade');
                          
            $table->integer('fas_keg_pernah_id')->unsigned();
            $table->foreign('fas_keg_pernah_id')->references('id')->on('fas_keg_pernahs')
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
        Schema::dropIfExists('fas_keg_pernah_temps');
    }
}
