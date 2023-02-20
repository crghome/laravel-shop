<?php

namespace Database\Seeders\Crghome\Shop;

use Crghome\Shop\Models\Shop\Client;
use Crghome\Shop\Models\Shop\OrderStatus;
use Crghome\Shop\Models\Shop\Product;
use Crghome\Shop\Services\ShopOrderService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(empty(OrderStatus::count())){ $this->call(StatusSeeder::class); }
        if(empty(Product::count())){ $this->call(ProductSeeder::class); }
        if(empty(Client::count())){ $this->call(ClientSeeder::class); }

        $order = [];
        $clients = Client::all();
        $productsAll = Product::all()->keyBy('id');
        $statuses = OrderStatus::all();
        for($i = 0; $i <= 5; $i++){
            $client = $clients->random();
            $products = [];
            $cart = rand(1,5);
            for($j = 1; $j <= $cart; $j++){
                $k = rand(1,3); $c = rand(1,8);
                $p = isset($productsAll[$k]) ? $productsAll[$k] : [];
                !empty($p) 
                    ? $products[] = [
                        'id' => $k, 
                        'name' => $p->name, 
                        'image' => $p->image, 
                        'attrib' => [], 
                        'count' => $c, 
                        'amount' => $p->price * $c
                    ] 
                    : false;
            }
            $order[] = [
                'number' => ShopOrderService::getNumberOrder('FD', rand(1000, 9999)),
                'client_id' => $client->id,
                'status_id' => $statuses->random()->id,
                'client_name' => $client->name,
                'client_phone' => $client->phone,
                'client_email' => $client->email,
                'client_company' => $client->company,
                'address' => $client->address,
                'amount' => array_sum(array_column($products,'amount')),
                'products' => json_encode($products),
            ];
        }
        DB::table(config('crghome-shop.db.tables.orders'))->insert($order);
    }
}
