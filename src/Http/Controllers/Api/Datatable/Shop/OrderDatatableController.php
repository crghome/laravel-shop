<?php

namespace Crghome\Shop\Http\Controllers\Api\Datatable\Shop;

use Crghome\Shop\Http\Controllers\Api\Datatable\AbstractDatatableController;
use Crghome\Shop\Models\Shop\Order;
use Crghome\Shop\Models\Shop\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

class OrderDatatableController extends AbstractDatatableController
{
    public static function getFields(){
        return (object)[
            'id' => 'datatable-crghome-shop-orders',
            'getRoute' => route(config('crghome-shop.prefix') . '.resource.datatable.shop.orders') . '?' . http_build_query($_GET, '', '&'),
            'columns' => [
                ['name' => 'id', 'label' => '#'],
                ['name' => 'number', 'label' => 'Номер'],
                ['name' => 'client_name', 'label' => 'Покупатель', 'orderable' => false],
                ['name' => 'products', 'label' => 'Товары', 'orderable' => false],
                ['name' => 'amount', 'label' => 'Сумма'],
                ['name' => 'dates', 'label' => 'Даты', 'orderable' => false],
            ],
            'order' => '[[0, "desc"]]',
            'noAction' => true
        ];
    }

    public function getArrData(){
        $result = ['data' => [], "recordsTotal" => 0, "recordsFiltered" => 0];
        // $getCategory = request()->get('f_category','');
        $orders = Order::with(['client', 'status']);
        // $orders = Order::select();
        $result['recordsTotal'] = $orders->count();
        if (request()->search['value']) {
            $orders = $orders
                ->where('number', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('client_name', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('client_phone', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('client_email', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('address', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('amount', 'LIKE', "%" . request()->search['value'] . "%");
        }
        $sortColumnID = request()->order[0]['column'];
        $sortDir = request()->order[0]['dir'];
        $sortColumn = request()->columns[$sortColumnID]['data'];
        $result['recordsFiltered'] = $orders->count();
        $orders = $orders->limit(request()->length)->orderBy($sortColumn, $sortDir)->offset(request()->start)->get();

        foreach ($orders as $item) {
            $actions = array(
                // array('id' => $item->id, 'title' => 'Просмотр', 'route' => route(config('crghome-shop.prefix') . '.shop.order.show', $item,), 'icon' => 'la la-eye'),
                // array('id' => $item->id, 'title' => 'Редактировать', 'route' => route(config('crghome-shop.prefix') . '.shop.order.edit', $item,), 'icon' => 'la la-edit'),
                // array('id' => $item->id, 'title' => 'Удалить', 'route' => route(config('crghome-shop.prefix') . '.shop.order.destroy', $item,), 'icon' => 'la la-trash', 'form' => true, 'formDelete' => Blade::render('<x-form-component style="display: none" method="DELETE" action="' . route(config('crghome-shop.prefix') . '.shop.order.destroy', $item,) . '"></x-form-component>'))
            );
            $client = '';
            if(!empty($item->client)){
                $client .= '<strong><a href="' . route(config('crghome-shop.prefix') . '.shop.client.edit', ($item->client?->id??0)) . '" target="_blank">' . $item->client?->name . '</a></strong>';
                $item->client?->phone ? $client .= '<br>' . preg_replace('/^(.+)(\d{3})(\d{3})(\d{2})(\d{2})$/', "$1 ($2) $3-$4-$5", $item->client?->phone) : false;
                $item->client?->email ? $client .= '<br>' . $item->client?->email : false;
            }
            $stat = $item->id . '<br>'; 
            $stat .= !empty($item->status?->icon_class) 
                ? '<i class = "' . $item->status->icon_class . '" data-container="body" data-toggle="tooltip" data-theme="dark" data-placement="right" title="' . $item->status->name . '"></i><br><div style="max-width: 100px; font-size: 12px;">' . $item->status->name . '</div>' 
                : '<i class = "fas fa-border-none" data-container="body" data-toggle="tooltip" data-theme="dark" data-placement="right" title="Нет статуса"></i><br>';
            $number = '<small><strong>' . $item->number . '</strong></small>';
            !empty($client) ? $number .= '<br>' . $client : false;
            $customer = '<strong>' . $item->client_name . '</strong><br>';
            $customer .= $item->client_phone . '<br>';
            $customer .= $item->client_email . '<br>';
            $customer .= '<small>' . $item->address . '</small>';
            $products = [];
            foreach(($item->products??[]) AS $prod){
                $pr = Product::find($prod['id']);
                $am = !empty($prod['amount']) ? $prod['amount'] : 0;
                if(!empty($pr)){
                    $products[] = '<span><strong style="white-space: nowrap;"><a href="' . route(config('crghome-shop.prefix') . '.shop.product.show', ($pr?->id??0)) . '" target="_blank">' 
                    . ($pr?->name??'--') . '</a></strong><br>' 
                    . '<span style="white-space: nowrap;">(' . $prod['count'] . ' ед : ' . number_format($am, 0, '.', ' ') . ' р/ед)</span>'
                    . '</span>';
                } else {
                    $products[] = '<span><strong style="white-space: nowrap;">' 
                    . ($prod['name']??'--') . '</strong><br>' 
                    . '<span style="white-space: nowrap;">(' . $prod['count'] . ' ед : ' . number_format($am, 0, '.', ' ') . ' р/ед)</span>'
                    . '</span>';
                }
            }
            $dt = [
                'id' => $stat,
                'number' => $number,
                'client_name' => $customer,
                'amount' => $item->amount,
                'products' => implode('<br>', $products),
                'dates' => date('d.m.Y H:i', strtotime($item->created_at)) . '<br>' . (!empty($item->updated_at) ? date('d.m.Y H:i', strtotime($item->updated_at)) : '---'),
                'actions' => $actions,
                'classNameTR' => !empty($item->status?->css_class) ? $item->status->css_class : '',
            ];
            $result['data'][] = $dt;
        }
        return $result;
    }
}
