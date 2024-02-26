<?php

use Illuminate\Database\Seeder;
use App\Models\BentukKoperasi;

class BentukKoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "PRIMER NASIONAL"],
			["name" => "PRIMER PROVINSI"],
			["name" => "PRIMER KABUPATEN/KOTA"],
			["name" => "SEKUNDER NASIONAL"],
			["name" => "SEKUNDER PROVINSI"],
			["name" => "SEKUNDER KABUPATEN/KOTA"],
        ];

        foreach ($datas as $value) {
        	BentukKoperasi::create($value);
        }
    }
}
