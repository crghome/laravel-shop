<?php

namespace Database\Seeders\Crghome\Shop;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('crghome-shop.db.tables.category_products'))->insert([
            ['category_id' => 1, 'product_id' => 1],
            ['category_id' => 2, 'product_id' => 1],
            ['category_id' => 3, 'product_id' => 1],
            ['category_id' => 2, 'product_id' => 2],
            ['category_id' => 3, 'product_id' => 3],
        ]);
    }
}
