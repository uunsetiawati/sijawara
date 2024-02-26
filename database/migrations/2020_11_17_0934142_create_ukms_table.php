<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUkmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ukms', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                          ->onDelete('cascade');

            // PEMILIK
            $table->string('nik');
            $table->string('nm_pemilik');
            $table->text('alamat_pemilik');
            $table->string('tempat_lahir_pemilik');
            $table->date('tanggal_lahir_pemilik');
            $table->enum('jenis_kelamin_pemilik', ['L', 'P']);
            $table->string('pendidikan_terakhir_pemilik');
            $table->string('phone', 15);

            // UKM
            $table->string('nm_ukm');
            $table->text('alamat_ukm');
            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('provinces')
                          ->onDelete('restrict');

            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')
                          ->onDelete('restrict');

            $table->string('kegiatan_usaha');
            $table->string('produk_dihasilkan');

            $table->integer('kategori_ukm_id')->unsigned();
            $table->foreign('kategori_ukm_id')->references('id')->on('kategori_ukms')
                          ->onDelete('restrict');

            $table->integer('tahun_mulai');

            $table->integer('kapasitas_produksi');
            $table->integer('volume_usaha');

            // $table->integer('SUMBER_BAHAN_BAKU => USE TEMP TABLE');

            $table->integer('tenaga_pria');
            $table->integer('tenaga_wanita');

            $table->integer('badan_usaha_id')->unsigned();
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usahas')
                          ->onDelete('restrict');

            // $table->integer('LEGALITAS_USAHA => USE TEMP TABLE');
            // $table->integer('STANDARISASI_PRODUK => USE TEMP TABLE');

            $table->string('npwp')->nullable();

            // $table->integer('WILAYAH_PEMASARAN => USE TEMP TABLE');

            $table->string('lokasi_pemasaran')->nullable();

            // $table->integer('FAS_KEG_PERNAH => USE TEMP TABLE');

            $table->integer('nilai_realisasi');
            $table->integer('tahun_realisasi');

            // $table->integer('MASALAH_UKM => USE TEMP TABLE');

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
        Schema::dropIfExists('ukms');
    }
}
