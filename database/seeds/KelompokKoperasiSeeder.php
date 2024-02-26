<?php

use Illuminate\Database\Seeder;
use App\Models\KelompokKoperasi;

class KelompokKoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
			["name" => "KOPERASI UNIT DESA (KUD)"],
			["name" => "KOPERASI SERBA USAHA"],
			["name" => "KOPERASI SIMPAN PINJAM"],
			["name" => "KOPERASI PEGAWAI NEGERI (KPRI)"],
			["name" => "KOPERASI WANITA"],
			["name" => "KOPERASI PONDOK PESANTREN (KOPPONTREN)"],
			["name" => "KOPERASI SIMPAN PINJAM POLA SYARIAH (KSPPS)"],
			["name" => "KOPERASI KARYAWAN (KOPKAR)"],
			["name" => "KOPERASI ANGKATAN DARAT"],
			["name" => "KOPERASI ANGKATAN LAUT"],
			["name" => "KOPERASI ANGKATAN UDARA"],
			["name" => "KOPERASI KEPOLISIAN"],
			["name" => "KOPERASI PEPABRI"],
			["name" => "KOPERASI PERTANIAN"],
			["name" => "KOPERASI PERKEBUNAN"],
			["name" => "KOPERASI PETERNAKAN"],
			["name" => "KOPERASI NELAYAN"],
			["name" => "KOPERASI KEHUTANAN"],
			["name" => "KOPERASI PRODUSEN TAHU TEMPE INDONESIA (KOPTI)"],
			["name" => "KOPERASI RAKYAT (KOPRA)"],
			["name" => "KOPERASI INDUSTRI KERAJINAN (KOPINKARA)"],
			["name" => "KOPERASI PEDAGANG PASAR (KOPPAS)"],
			["name" => "KOPERASI ANGKUTAN DARAT"],
			["name" => "KOPERASI ANGKUTAN LAUT"],
			["name" => "KOPERASI ANGKUTAN UDARA"],
			["name" => "KOPERASI ANGKUTAN SUNGAI"],
			["name" => "KOPERASI ANGKUTAN PENYEBRANGAN"],
			["name" => "KOPERASI WISATA"],
			["name" => "KOPERASI TELKOM"],
			["name" => "KOPERASI PERUMAHAN"],
			["name" => "KOPERASI BANK PERKREDITAN RAKYAT (KBPR)"],
			["name" => "KOPERASI LISTRIK PEDESAAN"],
			["name" => "KOPERASI ASURANSI INDONESIA"],
			["name" => "KOPERASI PROFESI"],
			["name" => "KOPERASI VETERAN"],
			["name" => "KOPERASI WREDATAMA"],
			["name" => "KOPERASI MAHASISWA"],
			["name" => "KOPERASI PEMUDA"],
			["name" => "KOPERASI PERTAMBANGAN"],
			["name" => "KOPERASI PEDAGANG KAKI LIMA"],
			["name" => "KOPERASI JAMU GENDONG"],
			["name" => "KOPERASI SEKUNDER"],
			["name" => "KOPERASI LAINNYA"]
		];

		foreach ($datas as $value) {
        	KelompokKoperasi::create($value);
        }
    }
}
