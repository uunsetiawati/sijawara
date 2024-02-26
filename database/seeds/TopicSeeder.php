<?php

use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topics')->delete();

        Topic::create([
            'name' => 'Semua User',
            'slug' => 'all',
        ]);
    }
}
