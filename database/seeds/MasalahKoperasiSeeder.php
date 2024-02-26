<?php

use Illuminate\Database\Seeder;
use App\Models\MasalahKoperasi;

class MasalahKoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "TEKNOLOGI INFORMASI"],
			["name" => "KELEMBAGAAN"],
			["name" => "PEMBIAYAAN"],
			["name" => "PEMASARAN"],
			["name" => "PRODUKSI"],
			["name" => "SDM"],
			["name" => "LAINNYA"],
        ];

        foreach ($datas as $value) {
        	MasalahKoperasi::create($value);
        }
    }
}
