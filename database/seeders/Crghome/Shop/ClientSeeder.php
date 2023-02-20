<?php

namespace Database\Seeders\Crghome\Shop;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        for($i = 0; $i <= 15; $i++){
            $phone = '880055' . $i . rand(1000, 9999);
            $data[] = [
                'login' => $phone,
                'name' => 'Fake ' . $phone,
                'phone' => $phone,
                'email' => 'crghome@mail.ru',
                'password' => 'Jfh' . $phone,
                'accessed' => true,
            ];
        }
        DB::table(config('crghome-shop.db.tables.clients'))->insert($data);
    }
}
