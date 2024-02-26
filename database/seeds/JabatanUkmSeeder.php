<?php

use Illuminate\Database\Seeder;
use App\Models\JabatanUkm;

class JabatanUkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "PEMILIK"],
			["name" => "KARYAWAN"],
			["name" => "KETUA KELOMPOK"],
			["name" => "ANGGOTA KELOMPOK"],
        ];

        foreach ($datas as $value) {
        	JabatanUkm::create($value);
        }
    }
}
