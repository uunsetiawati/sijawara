<?php

use Illuminate\Database\Seeder;
use App\Models\KategoriUkm;

class KategoriUkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "BATIK"],
			["name" => "CRAFT DAN ACCESSORIS"],
			["name" => "INDUSTRI PENGOLAHAN MAKANAN DAN MINUMAN"],
			["name" => "JAMU"],
			["name" => "JASA KEUANGAN, SIMPAN PINJAM KONVENSIONAL, SIMPAN PINJAM SYARIAH"],
			["name" => "JASA PEMBUATAN VIDEO, FILM, FOTOGRAFI"],
			["name" => "JASA LAINNYA"],
			["name" => "KULINER, RESTAURANT, DEPOT"],
			["name" => "MAINAN ANAK-ANAK"],
			["name" => "MEUBELAIR"],
			["name" => "PAKAIAN, KONVEKSI, BUTIK"],
			["name" => "PERDAGANGAN, DISTRIBUTOR, AGEN, RESELLER, TOKO"],
			["name" => "PERTANIAN, PERKEBUNAN, DAN ATAU KEHUTANAN"],
			["name" => "PETERNAKAN DAN PERIKANAN"],
			["name" => "TAS DAN SEPATU"],
			["name" => "LAINNYA"],
        ];

        foreach ($datas as $value) {
        	KategoriUkm::create($value);
        }
    }
}
