<?php

use Illuminate\Database\Seeder;
use App\Models\LegalitasUsaha;

class LegalitasUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "SIUP"],
			["name" => "TDP"],
			["name" => "IUMK"],
			["name" => "IJIN USAHA INDUSTRI"],
			["name" => "AKTA PENDIRIAN USAHA"],
			["name" => "IJIN PRINSIP"],
			["name" => "SKU/DOMISILI"],
			["name" => "BELUM ADA"],
			["name" => "LAINNYA"],
        ];


        foreach ($datas as $value) {
        	LegalitasUsaha::create($value);
        }
    }
}
