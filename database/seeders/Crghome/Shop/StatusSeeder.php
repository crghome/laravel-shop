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
                'css_class' => 'table-danger',
                'icon_class' => 'fas fa-exclamation-triangle text-danger',
                'icon_base' => '',
                'order' => 100,
                'remark' => 'Заказ принят, но пока не обрабатывается (например, заказ только что создан или ожидается оплата заказа)',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'order',
                'code' => 'NB',
                'name' => 'Принят и оплачен',
                'css_class' => 'table-danger',
                'icon_class' => 'fas fa-exclamation-circle text-danger',
                'icon_base' => '',
                'order' => 150,
                'remark' => 'Заказ принят с предварительной оплатой, но пока не обрабатывается (например, заказ только что создан)',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'order',
                'code' => 'OS',
                'name' => 'Сбор заказа',
                'css_class' => 'table-primary',
                'icon_class' => 'fas fa-hammer text-primary',
                'icon_base' => '',
                'order' => 200,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'delivery',
                'code' => 'DN',
                'name' => 'Подготовка к отправке',
                'css_class' => 'table-primary',
                'icon_class' => 'fab fa-dropbox text-primary',
                'icon_base' => '',
                'order' => 300,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'delivery',
                'code' => 'DP',
                'name' => 'Передано в доставку',
                'css_class' => 'table-warning',
                'icon_class' => 'fas fa-shipping-fast text-warning',
                'icon_base' => '',
                'order' => 320,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'delivery',
                'code' => 'DD',
                'name' => 'Доставка',
                'css_class' => 'table-warning',
                'icon_class' => 'fas fa-shipping-fast text-warning',
                'icon_base' => '',
                'order' => 340,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'delivery',
                'code' => 'DC',
                'name' => 'Передано курьеру',
                'css_class' => 'table-warning',
                'icon_class' => 'fas fa-skating text-warning',
                'icon_base' => '',
                'order' => 360,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'feedback',
                'code' => 'SN',
                'name' => 'Спор',
                'css_class' => 'table-danger',
                'icon_class' => 'fas fa-project-diagram text-danger',
                'icon_base' => '',
                'order' => 400,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'feedback',
                'code' => 'SF',
                'name' => 'Возврат',
                'css_class' => 'table-danger',
                'icon_class' => 'fas fa-reply text-danger',
                'icon_base' => '',
                'order' => 450,
                'remark' => '',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'done',
                'code' => 'FN',
                'name' => 'Выполнен, ожидается подтверждение',
                'css_class' => 'table-success',
                'icon_class' => 'fas fa-user-check text-success',
                'icon_base' => '',
                'order' => 900,
                'remark' => 'Заказ доставлен, но еще доставка не подтверждена',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'type_status' => 'done',
                'code' => 'FF',
                'name' => 'Выполнен',
                'css_class' => 'table-success',
                'icon_class' => 'fas fa-check text-success',
                'icon_base' => '',
                'order' => 950,
                'remark' => 'Заказ полностью выполнен',
                'created_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
