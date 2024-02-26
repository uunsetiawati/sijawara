<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use App\Models\User;

class UserSeeder extends Seeder
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
                'name' => 'Administrator',
                'email' => 'admin@mcflyon.co.id',
                'password' => bcrypt('12345678'),
                'phone' => '085895784355',
                'level' => 'admin',
                'province_id' => 15,
                'city_id' => 3578,
                'active' => '1'
            ],
            [
                'name' => 'User',
                'email' => 'user@mcflyon.co.id',
                'password' => bcrypt('12345678'),
                'phone' => '085895784354',
                'level' => 'user',
                'province_id' => 15,
                'city_id' => 3578,
                'active' => '1'
            ],
            [
                'name' => 'Widyaswara',
                'email' => 'widyaswara@mcflyon.co.id',
                'password' => bcrypt('12345678'),
                'phone' => '085895784353',
                'level' => 'widyaswara',
                'province_id' => 15,
                'city_id' => 3578,
                'active' => '1'
            ]
        ];

        foreach ($datas as $value) {
            User::create($value);
        }
    }
}
