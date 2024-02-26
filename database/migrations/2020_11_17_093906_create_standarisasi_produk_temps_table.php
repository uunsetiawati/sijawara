<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandarisasiProdukTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standarisasi_produk_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('ukm_id')->unsigned();
            $table->foreign('ukm_id')->references('id')->on('ukms')
                          ->onDelete('cascade');
                          
            $table->integer('standarisasi_produk_id')->unsigned();
            $table->foreign('standarisasi_produk_id')->references('id')->on('standarisasi_produks')
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
        Schema::dropIfExists('standarisasi_produk_temps');
    }
}
