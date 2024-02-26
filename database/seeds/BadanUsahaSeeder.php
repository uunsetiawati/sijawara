<?php

use Illuminate\Database\Seeder;
use App\Models\BadanUsaha;

class BadanUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "PERSEORANGAN"],
			["name" => "UD"],
			["name" => "CV"],
			["name" => "PT"],
			["name" => "KOPERASI"],
			["name" => "FIRMA"],
			["name" => "IUMK"],
			["name" => "DALAM PROSES"],
			["name" => "LAINNYA"],
        ];

        foreach ($datas as $value) {
        	BadanUsaha::create($value);
        }
    }
}
