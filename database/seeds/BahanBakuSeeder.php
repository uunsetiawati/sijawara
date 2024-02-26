<?php

use Illuminate\Database\Seeder;
use App\Models\BahanBaku;

class BahanBakuSeeder extends Seeder
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
			["name" => "IMPOR"],
        ];

        foreach ($datas as $value) {
        	BahanBaku::create($value);
        }
    }
}
