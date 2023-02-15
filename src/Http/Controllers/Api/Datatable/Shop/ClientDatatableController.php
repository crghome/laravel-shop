<?php

namespace Crghome\Shop\Http\Controllers\Api\Datatable\Shop;

use Crghome\Shop\Http\Controllers\Api\Datatable\AbstractDatatableController;
use Crghome\Shop\Models\Shop\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

class ClientDatatableController extends AbstractDatatableController
{
    public static function getFields(){
        return (object)[
            'id' => 'datatable-crghome-shop-clients',
            'getRoute' => route(config('crghome-shop.prefix') . '.resource.datatable.shop.clients') . '?' . http_build_query($_GET, '', '&'),
            'columns' => [
                ['name' => 'id', 'label' => '#'],
                ['name' => 'name', 'label' => 'Клиент'],
                // ['name' => 'products', 'label' => 'products', 'orderable' => false],
                ['name' => 'subs', 'label' => 'Подписки', 'orderable' => false],
                ['name' => 'dates', 'label' => 'Даты', 'orderable' => false],
            ],
            'order' => '[[0, "desc"]]'
        ];
    }

    public function getArrData(){
        $result = ['data' => [], "recordsTotal" => 0, "recordsFiltered" => 0];
        // $getCategory = request()->get('f_category','');
        // $clients = Client::with(['categories']);
        $clients = Client::select();
        $result['recordsTotal'] = $clients->count();
        if (request()->search['value']) {
            $clients = $clients
                ->where('name', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('alias', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('order', 'LIKE', "%" . request()->search['value'] . "%");
        }
        $sortColumnID = request()->order[0]['column'];
        $sortDir = request()->order[0]['dir'];
        $sortColumn = request()->columns[$sortColumnID]['data'];
        $result['recordsFiltered'] = $clients->count();
        $clients = $clients->limit(request()->length)->orderBy($sortColumn, $sortDir)->orderBy('name', 'asc')->offset(request()->start)->get();

        foreach ($clients as $item) {
            $actions = array(
                // array('id' => $item->id, 'title' => 'Просмотр', 'route' => route(config('crghome-shop.prefix') . '.shop.client.show', $item,), 'icon' => 'la la-eye'),
                array('id' => $item->id, 'title' => 'Редактировать', 'route' => route(config('crghome-shop.prefix') . '.shop.client.edit', $item,), 'icon' => 'la la-edit'),
                // array('id' => $item->id, 'title' => 'Удалить', 'route' => route(config('crghome-shop.prefix') . '.shop.client.destroy', $item,), 'icon' => 'la la-trash', 'form' => true, 'formDelete' => Blade::render('<x-form-component style="display: none" method="DELETE" action="' . route(config('crghome-shop.prefix') . '.shop.client.destroy', $item,) . '"></x-form-component>'))
            );
            $name = '<strong>' . $item->name . '</strong>';
            $name .= ' <span class="label label-lg font-weight-bold label-light-' . ($item->accessed?'success':'error') . ' label-inline"><i class="fas fa-unlock-alt" style="font-size: 12px; color: ' . ($item->accessed?'blue':'red') . ';"></i></span>';
            $name .= ' <span class="label label-lg font-weight-bold label-light-' . ($item->moderated?'success':'error') . ' label-inline"><i class="fas fa-user-check" style="font-size: 12px; color: ' . ($item->moderated?'blue':'red') . ';"></i></span>';
            $item->phone ? $name .= '<br>' . preg_replace('/^(.+)(\d{3})(\d{3})(\d{2})(\d{2})$/', "$1 ($2) $3-$4-$5", $item->phone) : false;
            $item->email ? $name .= '<br>' . $item->email : false;
            $subs = [];
            !empty($item->subs_news) ? $subs[] = '<span class="label label-lg font-weight-bold label-light-success label-inline">Новости</span>' : false;
            !empty($item->subs_actions) ? $subs[] = '<span class="label label-lg font-weight-bold label-light-success label-inline">Акции</span>' : false;
            $dt = [
                'id' => $item->id,
                'name' => $name,
                // 'products' => '<a class="label label-lg font-weight-bolder label-rounded label-primary pulse pulse-success" href="' . route(config('crghome-shop.prefix') . '.shop.product.index', ['f_product' => $item->id]) . '">' . $item->articles->count() . '<span class="pulse-ring"></span></a>',
                'subs' => !empty($subs) ? implode('<br>', $subs) : '-----',
                'dates' => date('d.m.Y H:i', strtotime($item->created_at)) . '<br>' . (!empty($item->updated_at) ? date('d.m.Y H:i', strtotime($item->updated_at)) : '---'),
                'actions' => $actions,
            ];
            $result['data'][] = $dt;
        }
        return $result;
    }
}
