<?php

use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->delete();

        $data = [
            ['id' => 1, 'nm_province' => 'ACEH'],
            ['id' => 2, 'nm_province' => 'SUMATERA UTARA'],
            ['id' => 3, 'nm_province' => 'SUMATERA BARAT'],
            ['id' => 4, 'nm_province' => 'RIAU'],
            ['id' => 5, 'nm_province' => 'JAMBI'],
            ['id' => 6, 'nm_province' => 'SUMATERA SELATAN'],
            ['id' => 7, 'nm_province' => 'BENGKULU'],
            ['id' => 8, 'nm_province' => 'LAMPUNG'],
            ['id' => 9, 'nm_province' => 'KEPULAUAN BANGKA BELITUNG'],
            ['id' => 10, 'nm_province' => 'KEPULAUAN RIAU'],
            ['id' => 11, 'nm_province' => 'DKI JAKARTA'],
            ['id' => 12, 'nm_province' => 'JAWA BARAT'],
            ['id' => 13, 'nm_province' => 'JAWA TENGAH'],
            ['id' => 14, 'nm_province' => 'DI YOGYAKARTA'],
            ['id' => 15, 'nm_province' => 'JAWA TIMUR'],
            ['id' => 16, 'nm_province' => 'BANTEN'],
            ['id' => 17, 'nm_province' => 'BALI'],
            ['id' => 18, 'nm_province' => 'NUSA TENGGARA BARAT'],
            ['id' => 19, 'nm_province' => 'NUSA TENGGARA TIMUR'],
            ['id' => 20, 'nm_province' => 'KALIMANTAN BARAT'],
            ['id' => 21, 'nm_province' => 'KALIMANTAN TENGAH'],
            ['id' => 22, 'nm_province' => 'KALIMANTAN SELATAN'],
            ['id' => 23, 'nm_province' => 'KALIMANTAN TIMUR'],
            ['id' => 24, 'nm_province' => 'KALIMANTAN UTARA'],
            ['id' => 25, 'nm_province' => 'SULAWESI UTARA'],
            ['id' => 26, 'nm_province' => 'SULAWESI TENGAH'],
            ['id' => 27, 'nm_province' => 'SULAWESI SELATAN'],
            ['id' => 28, 'nm_province' => 'SULAWESI TENGGARA'],
            ['id' => 29, 'nm_province' => 'GORONTALO'],
            ['id' => 30, 'nm_province' => 'SULAWESI BARAT'],
            ['id' => 31, 'nm_province' => 'MALUKU'],
            ['id' => 32, 'nm_province' => 'MALUKU UTARA'],
            ['id' => 33, 'nm_province' => 'PAPUA BARAT'],
            ['id' => 34, 'nm_province' => 'PAPUA']
        ];

        foreach($data as $value) {
            Province::create($value);
        }
    }
}