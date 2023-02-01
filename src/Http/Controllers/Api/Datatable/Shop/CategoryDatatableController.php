<?php

namespace Crghome\Shop\Http\Controllers\Api\Datatable\Shop;

use App\Http\Controllers\Api\Datatable\AbstractDatatableController;
use Crghome\Shop\Models\Shop\Category;
use Illuminate\Support\Facades\Blade;

class CategoryDatatableController extends AbstractDatatableController
{
    public static function getFields(){
        return (object)[
            'id' => 'datatable-crghome-shop-category',
            'getRoute' => route(config('crghome-shop.prefix') . '.resource.datatable.shop.category') . '?' . http_build_query($_GET, '', '&'),
            'columns' => [
                ['name' => 'id', 'label' => '#'],
                ['name' => 'parent', 'label' => 'Родитель', 'orderable' => false],
                ['name' => 'name', 'label' => 'Название'],
                ['name' => 'products', 'label' => 'Товаров', 'orderable' => false],
                ['name' => 'hide', 'label' => 'Показ'],
                ['name' => 'order', 'label' => 'Сортировка'],
                ['name' => 'dates', 'label' => 'Даты', 'orderable' => false],
            ],
            'order' => '[[5, "asc"]]'
        ];
    }

    public function getArrData(){
        $result = ['data' => [], "recordsTotal" => 0, "recordsFiltered" => 0];
        // $getType = request()->get('f_type','');
        // $category = Category::with(['category'])->withCount();
        $category = Category::with(['category', 'products']);
        $result['recordsTotal'] = $category->count();
        if (request()->search['value']) {
            $category = $category
                ->where('name', 'LIKE', "%" . request()->search['value'] . "%")
                ->where('alias', 'LIKE', "%" . request()->search['value'] . "%")
                ->where('order', 'LIKE', "%" . request()->search['value'] . "%");
        }
        $sortColumnID = request()->order[0]['column'];
        $sortDir = request()->order[0]['dir'];
        $sortColumn = request()->columns[$sortColumnID]['data'];
        // $getType ? $category = $category->where('type', $getType) : false;
        $result['recordsFiltered'] = $category->count();
        $category = $category->limit(request()->length)->orderBy('category_id', 'asc')->orderBy($sortColumn, $sortDir)->orderBy('name', 'asc')->orderBy('order', 'asc')->offset(request()->start)->get();

        foreach ($category as $item) {
            $actions = array(
                array('id' => $item->id, 'title' => 'Просмотр', 'route' => route(config('crghome-shop.prefix') . '.shop.category.show', $item,), 'icon' => 'la la-eye'),
                array('id' => $item->id, 'title' => 'Редактировать', 'route' => route(config('crghome-shop.prefix') . '.shop.category.edit', $item,), 'icon' => 'la la-edit'),
                array('id' => $item->id, 'title' => 'Удалить', 'route' => route(config('crghome-shop.prefix') . '.shop.category.destroy', $item,), 'icon' => 'la la-trash', 'form' => true,
                    'formDelete' => Blade::render('<x-form-component style="display: none" method="DELETE" action="' . route(config('crghome-shop.prefix') . '.shop.category.destroy', $item,) . '"></x-form-component>'))
            );
            $dt = [
                'id' => $item->id,
                'parent' => $item->category->name??'---',
                'name' => $item->name . '<br>' . $item->alias,
                // 'products' => '<a class="label label-lg font-weight-bolder label-rounded label-primary pulse pulse-success" href="#">0<span class="pulse-ring"></span></a>',
                'products' => '<a class="label label-lg font-weight-bolder label-rounded label-primary pulse pulse-success" href="' . route(config('crghome-shop.prefix') . '.shop.product.index', ['f_category' => $item->id]) . '">' . $item->products->count() . '<span class="pulse-ring"></span></a>',
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
