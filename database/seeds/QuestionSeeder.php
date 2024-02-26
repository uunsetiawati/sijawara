<?php

use Illuminate\Database\Seeder;
use App\Models\CourseQuestion;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
        	[
        		'question' => 'Di Pasal berapa kah disebutkan Empat Fungsi dan Peran Koperasi?',
        		'course_content_id' => '1',
        		'a_answer' => 'Pasal 3 UU Nomor 55/2001', 
        		'b_answer' => 'Pasal 4 UU Nomor 22/1990', 
        		'c_answer' => 'Pasal 4 UU Nomor 25/1992',
        		'd_answer' => 'Pasal 6 UU Nomor 25/1992',
        		'answer' => 'c',
        		'description' => 'Di Pasal 4 UU Nomor 25/1992 menyebut, empat fungsi dan peran koperasi.'
        	],
        	[
        		'question' => 'Ada Berapa Prinsip Dasar Koperasi?',
        		'course_content_id' => '4',
        		'a_answer' => '2', 
        		'b_answer' => '5', 
        		'c_answer' => '9',
        		'd_answer' => '13',
        		'answer' => 'b',
        		'description' => 'Prinsip dasar koperasi hanya ada 5'
        	],
        ];

        foreach ($datas as $result) {
        	CourseQuestion::create($result);
        }
    }
}
