<?php

use Illuminate\Database\Seeder;
use App\Models\MasalahUkm;

class MasalahUkmSeeder extends Seeder
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
        	MasalahUkm::create($value);
        }
    }
}
