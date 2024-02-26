<?php

use Illuminate\Database\Seeder;
use App\Models\SektorUsaha;

class SektorUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "PERTANIAN, KEHUTANAN DAN PERIKANAN"],
			["name" => "PERTAMBANGAN DAN PENGGALIAN"],
			["name" => "INDUSTRI PENGOLAHAN"],
			["name" => "PENGADAAN LISTRIK DAN GAS"],
			["name" => "PENGADAAN AIR, PENGOLAHAN SAMPAH, LIMBAH DAN DAUR ULANG"],
			["name" => "KONSTRUKSI"],
			["name" => "PERDAGANGAN BESAR DAN ECERAN - REPARASI MOBIL DAN MOTOR"],
			["name" => "TRANSPORTASI DAN PERGUDANGAN"],
			["name" => "PENYEDIAAN AKOMODASI DAN MAKAN MINUM"],
			["name" => "INFORMASI DAN KOMUNIKASI"],
			["name" => "JASA KEUANGAN DAN ASURANSI"],
			["name" => "REAL ESTATE"],
			["name" => "JASA PERUSAHAAN"],
			["name" => "ADMINISTRASI PEMERINTAH, PERTAHANAN DAN JAMINAN SOSIAL"],
			["name" => "JASA LAINNYA"],
        ];

        foreach ($datas as $value) {
        	SektorUsaha::create($value);
        }
    }
}
