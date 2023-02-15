<?php

namespace Database\Seeders\Crghome\Shop;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prevText = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
        $fullText = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
        DB::table(config('crghome-shop.db.tables.products'))->insert([
            [
                'name' => 'Продукт 1',
                'title' => 'Продукт 1',
                'alias' => Str::slug('Продукт 1'),
                'prevText' => $prevText,
                'fullText' => $fullText,
                'images' => json_encode(['prev' => '/images/test/1.jpg', 'full' => '/images/test/2.jpg']),
                'pictures' => json_encode(['/images/test/1.jpg', '/images/test/2.jpg', '/images/test/3.jpg']),
                'price' => 4400,
                'count' => 5,
                'dateBeginPub' => date('Y-m-d 00:00:00'),
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Продукт 2',
                'title' => 'Продукт 2',
                'alias' => Str::slug('Продукт 2'),
                'prevText' => $prevText,
                'fullText' => $fullText,
                'images' => json_encode(['prev' => '', 'full' => '/images/test/2.jpg']),
                'pictures' => null,
                'price' => 16000,
                'count' => 350,
                'dateBeginPub' => date('Y-m-d 00:00:00'),
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Продукт 3',
                'title' => 'Продукт 3',
                'alias' => Str::slug('Продукт 3'),
                'prevText' => $prevText,
                'fullText' => $fullText,
                'images' => null,
                'pictures' => null,
                'price' => 8000,
                'count' => 0,
                'dateBeginPub' => date('Y-m-d 00:00:00'),
                'created_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
