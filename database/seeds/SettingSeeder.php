<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();

        Setting::create([
        	'name' => 'SIJAWARA', 
        	'background' => 'BACKGROUND_1599121648.jpg', 
        	'logo_dark' => 'LOGO_DARK_1599121280.png', 
        	'logo_white' => 'LOGO_WHITE_1599121280.png', 
        	'description' => 'SIJAWARA adalah suatu Sistem Informasi Pembelajaran dan Peningkatan Wawasan Perkoperasian yang digunakan untuk menciptakan lingkungan belajar yang fleksibel. SIJAWARA sangat Flesksibel dengan perkembangan Teknologi'
        ]);
    }
}
