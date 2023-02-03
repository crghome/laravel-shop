<?php

namespace Crghome\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Crghome\Shop\Http\Controllers\Api\Datatable\Shop\ProductDatatableController;
use Crghome\Shop\Http\Requests\ProductFormRequest;
use Crghome\Shop\Models\Shop\Category;
use Crghome\Shop\Models\Shop\Product;
use Crghome\Shop\Services\ShopProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ShopProductController extends Controller
{
    protected $_breadcrumbs;
    protected $_listRoute;
    protected $_backRoute;
    protected $_pageBtnAction;

    protected Object $_title;
    protected Object $_subtitle;

    public function __construct()
    {
        $this->_listRoute = route(config('crghome-shop.prefix') . '.shop.product.index');
        $this->_backRoute = $this->_listRoute;
        $this->_pageBtnAction = array(
            (object)['type' => 'link', 'class' => 'btn-light-primary', 'icon' => 'ki ki-long-arrow-back icon-sm', 'text' => 'Назад', 'href' => $this->_listRoute],
            (object)['type' => 'button', 'class' => 'btn-primary', 'icon' => 'ki ki-check icon-sm', 'text' => 'Сохранить', 'action' => 'onClick="adminForm.submitAction(\'save\')"']
        );
        $this->_breadcrumbs = array(
            array('text' => 'Главная', 'href' => '/'),
            array('text' => 'Магазин'),
            'index' => array('text' => 'Продукты')
        );
        $this->_title = (object)[
            'index' => 'Товары',
            'show' => 'Товар',
            'create' => 'Создание товара',
            'update' => 'Обновление товара',
        ];
        $this->_subtitle = (object)[
            'index' => 'Список товаров'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = $this->_breadcrumbs;
        $configDataAjax = ProductDatatableController::getFields();
        $title = $this->_title->index??config('crghome-shop.name');
        $subtitle = $this->_subtitle->index??config('crghome-shop.name');
        $pageBtnAction = [
            (object)[
                'type' => 'link',
                'class' => 'btn-primary',
                'text' => 'Создать',
                'href' => route(config('crghome-shop.prefix') . '.shop.product.create')
            ],
        ];
        return view('crghome-shop::_base.index', compact('title', 'subtitle', 'configDataAjax', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\Shop\Product  $product
     */
    public function show(Product $product)
    {
        $arrData = (object)array(
            'product' => $product,
            'categories' => ($product->categories??[]),
        );
        // dd($arrData);

        $title = $product->label;
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Просмотр продукта магазина "' . $product->name . '"');
        $pageBtnAction = [
            (object)[
                'type' => 'link',
                'class' => 'btn-light-primary',
                'icon' => 'ki ki-long-arrow-back icon-sm',
                'text' => 'Назад',
                'href' => $this->_listRoute,
            ],
            (object)[
                'type' => 'link',
                'class' => 'btn-primary',
                'icon' => 'la la-edit',
                'text' => 'Редактировать',
                'href' => route(config('crghome-shop.prefix') . '.shop.product.edit', $product),
            ],
        ];
        return view('crghome-shop::product.show', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrData = (object)array(
            'categories' => Category::orderBy('name')->get()->pluck('name', 'id')->prepend('-- Корневая директория --', null)->toArray(),
            'route' => route(config('crghome-shop.prefix') . '.shop.product.store'),
            'method' => 'POST'
        );
        //dd(\Auth::user()->hasRole('superadmin|admin|manager'));

        $title = $this->_title->create??config('crghome-shop.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Создание продукта');
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::product.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\ProductFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormRequest $request)
    {
        $data = $request->except(['id']);
        $save = ShopProductService::saveUpdateProduct($data);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\Shop\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $arrData = (object)array(
            'product' => $product,
            'categories' => Category::orderBy('name')->get()->pluck('name', 'id')->prepend('-- Корневая директория --', null)->toArray(),
            'route' => route(config('crghome-shop.prefix') . '.shop.product.update', $product),
            'method' => 'PATCH'
        );
        // dd($arrData->product?->categories?->pluck('id')?->toArray());

        $title = ($this->_title->update??config('crghome-shop.name')) . ' "' . $product->name . '"';
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Редактирование продукта "' . $product->name . '"');
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::product.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\ProductFormRequest  $request
     * @param  \Crghome\Shop\Models\Shop\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormRequest $request, Product $product)
    {
        $data = $request->except(['id']);
        $save = ShopProductService::saveUpdateProduct($data, $product);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $res = ShopProductService::deleteProduct($product);
        return Redirect::to($this->_backRoute);
    }
}
