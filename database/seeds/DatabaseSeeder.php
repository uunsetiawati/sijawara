<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(WidyaiswaraSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(CourseContentSeeder::class);
        $this->call(QuestionSeeder::class);
        // MASTER
        $this->call(JenisKoperasiSeeder::class);
        $this->call(BentukKoperasiSeeder::class);
        $this->call(KelompokKoperasiSeeder::class);
        $this->call(BadanUsahaSeeder::class);
        $this->call(JabatanUkmSeeder::class);
        $this->call(KategoriUkmSeeder::class);
        $this->call(MasalahKoperasiSeeder::class);
        $this->call(SektorUsahaSeeder::class);
        $this->call(UnitUsahaSeeder::class);
        $this->call(TopicSeeder::class);
    }
}
