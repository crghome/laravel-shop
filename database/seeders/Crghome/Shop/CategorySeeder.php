<?php

namespace Database\Seeders\Crghome\Shop;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
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
        DB::table(config('crghome-shop.db.tables.categories'))->insert([
            [
                'id' => 1,
                'category_id' => null,
                'name' => 'Печати и штампы',
                'title' => 'Печати и штампы',
                'alias' => Str::slug('Печати и штампы'),
                'path' => Str::slug('Печати и штампы'),
                'prevText' => $prevText,
                'fullText' => $fullText,
                'images' => null,
                'dateBeginPub' => date('Y-m-d 00:00:00'),
                'order' => 100,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id' => 2,
                'category_id' => null,
                'name' => 'ИП и ООО',
                'title' => 'ИП и ООО',
                'alias' => Str::slug('ИП и ООО'),
                'path' => Str::slug('ИП и ООО'),
                'prevText' => $prevText,
                'fullText' => $fullText,
                'images' => null,
                'dateBeginPub' => date('Y-m-d 00:00:00'),
                'order' => 200,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id' => 3,
                'category_id' => null,
                'name' => 'Кассовое оборудование',
                'title' => 'Кассовое оборудование',
                'alias' => Str::slug('Кассовое оборудование'),
                'path' => Str::slug('Кассовое оборудование'),
                'prevText' => $prevText,
                'fullText' => $fullText,
                'images' => null,
                'dateBeginPub' => date('Y-m-d 00:00:00'),
                'order' => 300,
                'created_at' => date("Y-m-d H:i:s"),
            ],

            [
                'id' => 4,
                'category_id' => 1,
                'name' => 'Автоматические печати',
                'title' => 'Автоматические печати',
                'alias' => Str::slug('Автоматические печати'),
                'path' => Str::slug('Печати и штампы') . '/' . Str::slug('Автоматические печати'),
                'prevText' => $prevText,
                'fullText' => $fullText,
                'images' => null,
                'dateBeginPub' => date('Y-m-d 00:00:00'),
                'order' => 100,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id' => 5,
                'category_id' => 1,
                'name' => 'Полуавтоматические печати',
                'title' => 'Полуавтоматические печати',
                'alias' => Str::slug('Полуавтоматические печати'),
                'path' => Str::slug('Печати и штампы') . '/' . Str::slug('Полуавтоматические печати'),
                'prevText' => $prevText,
                'fullText' => $fullText,
                'images' => null,
                'dateBeginPub' => date('Y-m-d 00:00:00'),
                'order' => 200,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id' => 6,
                'category_id' => 1,
                'name' => 'Ручные печати',
                'title' => 'Ручные печати',
                'alias' => Str::slug('Ручные печати'),
                'path' => Str::slug('Печати и штампы') . '/' . Str::slug('Ручные печати'),
                'prevText' => $prevText,
                'fullText' => $fullText,
                'images' => null,
                'dateBeginPub' => date('Y-m-d 00:00:00'),
                'order' => 300,
                'created_at' => date("Y-m-d H:i:s"),
            ],

            [
                'id' => 7,
                'category_id' => 2,
                'name' => 'Тест ООО',
                'title' => 'Тест ООО',
                'alias' => Str::slug('Тест ООО'),
                'path' => Str::slug('ИП и ООО') . '/' . Str::slug('Тест ООО'),
                'prevText' => $prevText,
                'fullText' => $fullText,
                'images' => null,
                'dateBeginPub' => date('Y-m-d 00:00:00'),
                'order' => 100,
                'created_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
