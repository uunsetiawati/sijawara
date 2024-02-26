<?php

use Illuminate\Database\Seeder;
use App\Models\StandarisasiProduk;

class StandarisasiProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "P-IRT"],
			["name" => "SERTIFIKAT HALAL"],
			["name" => "ISO"],
			["name" => "SNI"],
			["name" => "MEREK"],
			["name" => "HAK CIPTA"],
			["name" => "HAK PATEN"],
			["name" => "SNI PRODUK/JASA"],
			["name" => "UJI NUTRISI"],
			["name" => "HACCP"],
			["name" => "BELUM ADA"],
			["name" => "LAINNYA"],
        ];


        foreach ($datas as $value) {
        	StandarisasiProduk::create($value);
        }
    }
}
