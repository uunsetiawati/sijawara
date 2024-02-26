<?php

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
        	['nm_category' => 'Koperasi'],
        	['nm_category' => 'UKM'],
        ];

        foreach ($datas as $value) {
        	BlogCategory::create($value);
        }
    }
}
