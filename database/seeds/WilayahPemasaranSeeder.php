<?php

use Illuminate\Database\Seeder;
use App\Models\WilayahPemasaran;

class WilayahPemasaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "KAB/KOTA SETEMPAT"],
			["name" => "KAB/KOTA DALAM PROVINSI"],
			["name" => "ANTAR PROVINSI"],
			["name" => "EKSPOR"],
        ];

        foreach ($datas as $value) {
        	WilayahPemasaran::create($value);
        }
    }
}
