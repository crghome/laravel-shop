<?php

namespace Database\Seeders\Crghome\Shop;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('crghome-shop.db.tables.statuses'))->insert([
            [
                'type_status' => 'order',
                'code' => 'NO',
                'name' => 'Принят, ожидается оплата',
                'icon_class' => '',
                'icon_base' => '',
                'order' => 100,
                'remark' => 'Заказ принят, но пока не обрабатывается (например, заказ только что создан или ожидается оплата заказа)',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'order',
                'code' => 'NB',
                'name' => 'Принят и оплачен',
                'icon_class' => '',
                'icon_base' => '',
                'order' => 100,
                'remark' => 'Заказ принят с предварительной оплатой, но пока не обрабатывается (например, заказ только что создан)',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'order',
                'code' => 'OS',
                'name' => 'Сбор заказа',
                'icon_class' => '',
                'icon_base' => '',
                'order' => 100,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'delivery',
                'code' => 'OPD',
                'name' => 'Подготовка к отправке',
                'icon_class' => '',
                'icon_base' => '',
                'order' => 100,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'delivery',
                'code' => 'OD',
                'name' => 'Доставка',
                'icon_class' => '',
                'icon_base' => '',
                'order' => 100,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'feedback',
                'code' => 'EC',
                'name' => 'Спор',
                'icon_class' => '',
                'icon_base' => '',
                'order' => 100,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'done',
                'code' => 'D',
                'name' => 'Выполнен',
                'icon_class' => '',
                'icon_base' => '',
                'order' => 100,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
