<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKoperasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koperasis', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                          ->onDelete('cascade');

            // PEMILIK
            $table->string('nik');
            $table->string('nm_koperasi');

            $table->text('alamat_koperasi');
            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('provinces')
                          ->onDelete('restrict');

            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')
                          ->onDelete('restrict');

            $table->string('phone', 15)->nullable();
            $table->string('no_badan_hukum')->nullable();
            $table->date('tgl_badan_hukum')->nullable();

            $table->string('no_pad')->nullable();
            $table->date('tgl_pad')->nullable();

            $table->enum('status', ['0', '1'])->default('1');

            $table->integer('cabang')->nullable();
            $table->date('tgl_rat')->nullable();

            $table->string('nm_ketua')->nullable();
            $table->string('phone_ketua', 15)->nullable();

            $table->string('nm_sekretaris')->nullable();
            $table->string('phone_sekretaris', 15)->nullable();

            $table->string('nm_bendahara')->nullable();
            $table->string('phone_bendahara', 15)->nullable();

            $table->integer('anggota_pria')->nullanle();
            $table->integer('anggota_wanita')->nullanle();

            $table->integer('manager_pria')->nullanle();
            $table->integer('manager_wanita')->nullanle();

            $table->integer('karyawan_pria')->nullanle();
            $table->integer('karyawan_wanita')->nullanle();

            $table->integer('bentuk_koperasi_id')->unsigned();
            $table->foreign('bentuk_koperasi_id')->references('id')->on('bentuk_koperasis')
                          ->onDelete('restrict');

            $table->integer('jenis_koperasi_id')->unsigned();
            $table->foreign('jenis_koperasi_id')->references('id')->on('jenis_koperasis')
                          ->onDelete('restrict');

            $table->integer('kelompok_koperasi_id')->unsigned();
            $table->foreign('kelompok_koperasi_id')->references('id')->on('kelompok_koperasis')
                          ->onDelete('restrict');

            $table->integer('sektor_usaha_id')->unsigned();
            $table->foreign('sektor_usaha_id')->references('id')->on('sektor_usahas')
                          ->onDelete('restrict');

            $table->integer('volume_usaha');
            $table->integer('asset');

            $table->integer('unit_usaha_id')->unsigned();
            $table->foreign('unit_usaha_id')->references('id')->on('unit_usahas')
                          ->onDelete('restrict');

            $table->integer('modal_sendiri');
            $table->integer('modal_luar');
            $table->integer('sisa_hasil_usaha');

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
        Schema::dropIfExists('koperasis');
    }
}
