<?php

namespace Crghome\Shop\Http\Controllers\Api\Datatable\Shop;

use Crghome\Shop\Http\Controllers\Api\Datatable\AbstractDatatableController;
use Crghome\Shop\Models\Shop\OrderStatus;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

class OrderStatusDatatableController extends AbstractDatatableController
{
    public static function getFields(){
        return (object)[
            'id' => 'datatable-crghome-shop-order-statuses',
            'getRoute' => route(config('crghome-shop.prefix') . '.resource.datatable.shop.order-statuses') . '?' . http_build_query($_GET, '', '&'),
            'columns' => [
                ['name' => 'id', 'label' => '#'],
                ['name' => 'pic', 'label' => 'Icon', 'orderable' => false],
                ['name' => 'name', 'label' => 'Название'],
                ['name' => 'type_status', 'label' => 'Тип'],
                ['name' => 'order', 'label' => 'Сортировка'],
            ],
            // 'order' => '[[4, "asc"]]'
        ];
    }

    public function getArrData(){
        $result = ['data' => [], "recordsTotal" => 0, "recordsFiltered" => 0];
        $getCategory = request()->get('f_category','');
        $orderStatuses = OrderStatus::select();
        $result['recordsTotal'] = $orderStatuses->count();
        if (request()->search['value']){
            $orderStatuses = $orderStatuses
                ->where('name', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('code', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('css_class', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('remark', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('order', 'LIKE', "%" . request()->search['value'] . "%");
            $arrEn = \Crghome\Shop\Enum\TypeOrderStatus::fromLike(label: request()->search['value']);
            if(!empty($arrEn)){
                $arrEnVal = Arr::pluck($arrEn, 'value');
                $orderStatuses = $orderStatuses->orWhereIn('type_status', $arrEnVal);
            }
        }
        $sortColumnID = request()->order[0]['column'];
        $sortDir = request()->order[0]['dir'];
        $sortColumn = request()->columns[$sortColumnID]['data'];
        $result['recordsFiltered'] = $orderStatuses->count();
        $orderStatuses = $orderStatuses->limit(request()->length)->orderBy($sortColumn, $sortDir)->offset(request()->start)->get();

        foreach ($orderStatuses as $item) {
            $actions = array(
                // array('id' => $item->id, 'title' => 'Просмотр', 'route' => route(config('crghome-shop.prefix') . '.shop.order-status.show', $item,), 'icon' => 'la la-eye'),
                array('id' => $item->id, 'title' => 'Редактировать', 'route' => route(config('crghome-shop.prefix') . '.shop.order-status.edit', $item,), 'icon' => 'la la-edit'),
                array('id' => $item->id, 'title' => 'Удалить', 'route' => route(config('crghome-shop.prefix') . '.shop.order-status.destroy', $item,), 'icon' => 'la la-trash', 'form' => true,
                    'formDelete' => Blade::render('<x-form-component style="display: none" method="DELETE" action="' . route(config('crghome-shop.prefix') . '.shop.order-status.destroy', $item,) . '"></x-form-component>'))
            );
            $dt = [
                'id' => $item->id,
                'pic' => '<i class="' . $item->icon_class . '"></i>',
                'name' => $item->name . '<br>' . $item->code,
                'type_status' => $item->type_status?->name??'---',
                'order' => $item->order,
                'classNameTR' => $item->css_class,
                'actions' => $actions,
            ];
            $result['data'][] = $dt;
        }
        return $result;
    }
}
