<?php

namespace Crghome\Shop\Http\Controllers\Api\Datatable\Shop;

use Crghome\Shop\Http\Controllers\Api\Datatable\AbstractDatatableController;
use Crghome\Shop\Models\Shop\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

class ProductDatatableController extends AbstractDatatableController
{
    public static function getFields(){
        return (object)[
            'id' => 'datatable-crghome-shop-product',
            'getRoute' => route(config('crghome-shop.prefix') . '.resource.datatable.shop.product') . '?' . http_build_query($_GET, '', '&'),
            'columns' => [
                ['name' => 'id', 'label' => '#'],
                ['name' => 'category', 'label' => 'Категории', 'orderable' => false],
                ['name' => 'name', 'label' => 'Название'],
                // ['name' => 'products', 'label' => 'Товаров', 'orderable' => false],
                ['name' => 'hide', 'label' => 'Показ'],
                ['name' => 'order', 'label' => 'Сортировка'],
                ['name' => 'dates', 'label' => 'Даты', 'orderable' => false],
            ],
            // 'order' => '[[4, "asc"]]'
        ];
    }

    public function getArrData(){
        $result = ['data' => [], "recordsTotal" => 0, "recordsFiltered" => 0];
        $getCategory = request()->get('f_category','');
        // $product = Product::with(['categories'])->withCount();
        $product = Product::with(['categories']);
        // $product = Product::select();
        $result['recordsTotal'] = $product->count();
        if (request()->search['value']) {
            $product = $product
                ->where('name', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('alias', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('order', 'LIKE', "%" . request()->search['value'] . "%");
        }
        $sortColumnID = request()->order[0]['column'];
        $sortDir = request()->order[0]['dir'];
        $sortColumn = request()->columns[$sortColumnID]['data'];
        $getCategory 
            // ? $product = $product->whereRelation('categories', 'shop_category.id', $getCategory) 
            ? $product = $product->whereHas('categories', function($q)use($getCategory){
                $q->where('shop_categories.id', $getCategory);
            }) 
            : false;
        $result['recordsFiltered'] = $product->count();
        $product = $product->limit(request()->length)->orderBy($sortColumn, $sortDir)->orderBy('name', 'asc')->orderBy('order', 'asc')->offset(request()->start)->get();

        foreach ($product as $item) {
            $actions = array(
                array('id' => $item->id, 'title' => 'Просмотр', 'route' => route(config('crghome-shop.prefix') . '.shop.product.show', $item,), 'icon' => 'la la-eye'),
                array('id' => $item->id, 'title' => 'Редактировать', 'route' => route(config('crghome-shop.prefix') . '.shop.product.edit', $item,), 'icon' => 'la la-edit'),
                array('id' => $item->id, 'title' => 'Удалить', 'route' => route(config('crghome-shop.prefix') . '.shop.product.destroy', $item,), 'icon' => 'la la-trash', 'form' => true,
                    'formDelete' => Blade::render('<x-form-component style="display: none" method="DELETE" action="' . route(config('crghome-shop.prefix') . '.shop.product.destroy', $item,) . '"></x-form-component>'))
            );
            $dt = [
                'id' => $item->id,
                'category' => implode('<br>', Arr::sort(($item->categories?->pluck('name')?->toArray()??[]))),
                'name' => $item->name . '<br>' . $item->alias,
                // 'products' => '<a class="label label-lg font-weight-bolder label-rounded label-primary pulse pulse-success" href="' . route(config('crghome-shop.prefix') . '.shop.product.index', ['f_product' => $item->id]) . '">' . $item->articles->count() . '<span class="pulse-ring"></span></a>',
                'hide' => '<span class="label label-lg font-weight-bold label-light-' . ($item->hide?'error':'success') . ' label-inline">' . ($item->hide?'скрыто':'показ') . '</span>',
                'order' => $item->order,
                'dates' => date('d.m.Y H:i', strtotime($item->created_at)) . '<br>' . (!empty($item->updated_at) ? date('d.m.Y H:i', strtotime($item->updated_at)) : '---'),
                'actions' => $actions,
            ];
            $result['data'][] = $dt;
        }
        return $result;
    }
}
