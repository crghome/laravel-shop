<?php

namespace Crghome\Shop\Http\Controllers\Api\Datatable\Shop;

use Crghome\Shop\Http\Controllers\Api\Datatable\AbstractDatatableController;
use Crghome\Shop\Models\Shop\Category;
use Crghome\Shop\Services\ShopCategoryService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Arr;

class CategoryDatatableController extends AbstractDatatableController
{
    public static function getFields(){
        return (object)[
            'id' => 'datatable-crghome-shop-category',
            'getRoute' => route(config('crghome-shop.prefix') . '.resource.datatable.shop.category') . '?' . http_build_query($_GET, '', '&'),
            'columns' => [
                ['name' => 'id', 'label' => '#'],
                ['name' => 'name', 'label' => 'Название'],
                ['name' => 'products', 'label' => 'Товаров', 'orderable' => false],
                ['name' => 'hide', 'label' => 'Показ'],
                ['name' => 'order', 'label' => 'Сортировка'],
                ['name' => 'dates', 'label' => 'Даты', 'orderable' => false],
            ],
            'order' => '[[4, "asc"]]'
        ];
    }

    public function getArrData(){
        $result = ['data' => [], "recordsTotal" => 0, "recordsFiltered" => 0];
        // $getType = request()->get('f_type','');
        $sortColumnID = request()->order[0]['column'];
        $sortDir = request()->order[0]['dir'];
        $sortColumn = request()->columns[$sortColumnID]['data'];
        $category = Category::with(['category', 'products', 'categoriesAllChildren' => function($q)use($sortColumn, $sortDir){
            return $q->orderBy($sortColumn, $sortDir)->orderBy('order', 'asc');
        }]);
        $result['recordsTotal'] = Category::all()->count();
        if (request()->search['value']){
            $category = $category
                ->where('name', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('alias', 'LIKE', "%" . request()->search['value'] . "%")
                ->orWhere('order', 'LIKE', "%" . request()->search['value'] . "%");
        } else {
            $category = $category->whereNull('category_id');
        }
        // $getType ? $category = $category->where('type', $getType) : false;
        $category = $category->orderBy($sortColumn, $sortDir)->orderBy('order', 'asc')->get();

        $objResult = ShopCategoryService::eloquentCategoryToArrayList($category);
        $result['recordsFiltered'] = count($objResult);
        $objResult = array_slice($objResult, (request()->start??0), (request()->length??10));

        foreach (($objResult??[]) as $item) {
            $actions = array(
                array('id' => $item->id, 'title' => 'Просмотр', 'route' => route(config('crghome-shop.prefix') . '.shop.category.show', $item,), 'icon' => 'la la-eye'),
                array('id' => $item->id, 'title' => 'Редактировать', 'route' => route(config('crghome-shop.prefix') . '.shop.category.edit', $item,), 'icon' => 'la la-edit'),
                array('id' => $item->id, 'title' => 'Удалить', 'route' => route(config('crghome-shop.prefix') . '.shop.category.destroy', $item,), 'icon' => 'la la-trash', 'form' => true,
                    'formDelete' => Blade::render('<x-form-component style="display: none" method="DELETE" action="' . route(config('crghome-shop.prefix') . '.shop.category.destroy', $item,) . '"></x-form-component>'))
            );
            $name = '<div style="display: flex; align-items: center;">';
            if(($item->level??0) >= 1){
                $name .= str_repeat('<div style="flex: 0 0 auto; width: 20px;"></div><div style="flex: 0 0 auto; width: 20px;">│</div>', ($item->level - 1));
                $name .= '<div style="flex: 0 0 auto; width: 20px;"></div><div style="flex: 0 0 auto; width: 20px;">└</div>';
            }
            $name .= '<div>' . $item->name . '<br>' . $item->alias . '<div>';
            $name .= '</div>';
            $dt = [
                'id' => $item->id,
                'name' => $name,
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
