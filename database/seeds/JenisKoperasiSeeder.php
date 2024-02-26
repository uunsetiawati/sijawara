<?php

use Illuminate\Database\Seeder;
use App\Models\JenisKoperasi;

class JenisKoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "PRODUSEN"],
			["name" => "PEMASARAN"],
			["name" => "KONSUMEN"],
			["name" => "JASA"],
			["name" => "SIMPAN PINJAM"],
        ];

        foreach ($datas as $value) {
        	JenisKoperasi::create($value);
        }
    }
}
