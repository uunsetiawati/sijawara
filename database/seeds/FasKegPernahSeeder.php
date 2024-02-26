<?php

use Illuminate\Database\Seeder;
use App\Models\FasKegPernah;

class FasKegPernahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "MAGANG"],
			["name" => "STANDARISASI"],
			["name" => "PAMERAN"],
			["name" => "CTH"],
			["name" => "GALERI"],
			["name" => "VOKASIONAL"],
			["name" => "PELATIHAN MANAJEMEN"],
			["name" => "KEMITRAAN PEMASARAN"],
			["name" => "DANA BERGULIR"],
			["name" => "KUR"],
			["name" => "PEMBIAYAAN DARI CSR"],
			["name" => "BELUM PERNAH"],
			["name" => "LAINNYA"],
        ];

        foreach ($datas as $value) {
        	FasKegPernah::create($value);
        }
    }
}
