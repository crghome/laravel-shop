<?php

namespace Crghome\Shop\Http\Controllers\Admin;

use Crghome\Shop\Http\Controllers\Admin\Controller;
use Crghome\Shop\Http\Controllers\Api\Datatable\Shop\OrderDatatableController;
use Crghome\Shop\Models\Shop\Client;
use Crghome\Shop\Models\Shop\Order;
use Crghome\Shop\Models\Shop\Product;
use Crghome\Shop\Services\ShopOrderService;
use Illuminate\Support\Facades\Redirect;

class ShopOrderController extends Controller
{
    protected $_breadcrumbs;
    protected $_listRoute;
    protected $_backRoute;
    protected $_pageBtnAction;

    protected Object $_title;
    protected Object $_subtitle;

    public function __construct()
    {
        $this->_listRoute = route(config('crghome-shop.prefix') . '.shop.order.index');
        $this->_backRoute = $this->_listRoute;
        $this->_pageBtnAction = array(
            (object)['type' => 'link', 'class' => 'btn-light-primary', 'icon' => 'ki ki-long-arrow-back icon-sm', 'text' => 'Назад', 'href' => $this->_listRoute],
            (object)['type' => 'button', 'class' => 'btn-primary', 'icon' => 'ki ki-check icon-sm', 'text' => 'Сохранить', 'action' => 'onClick="adminForm.submitAction(\'save\')"']
        );
        $this->_breadcrumbs = array(
            array('text' => 'Главная', 'href' => '/'),
            array('text' => config('crghome-shop.name', 'Магазин'), 'href' => route(config('crghome-shop.prefix') . '.shop.index')),
            'index' => array('text' => 'Заказы')
        );
        $this->_title = (object)[
            'index' => 'Заказы',
            'show' => 'Заказ',
            'create' => 'Создание заказа',
            'update' => 'Обновление заказа',
        ];
        $this->_subtitle = (object)[
            'index' => 'Список заказов'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $order = [];
        // $clients = Client::all();
        // $productsAll = Product::all()->keyBy('id');
        // for($i = 0; $i <= 5; $i++){
        //     $client = $clients->random();
        //     $products = [];
        //     $cart = rand(3,8);
        //     for($j = 1; $j <= $cart; $j++){
        //         $k = rand(1,3); $c = rand(1,8);
        //         $p = isset($productsAll[$k]) ? $productsAll[$k] : [];
        //         !empty($p) ? $products[] = ['id' => $k, 'count' => $c, 'amount' => $p->price * $c] : false;
        //     }
        //     $order[] = [
        //         'client_id' => $client->id,
        //         'status_id' => 1,
        //         'client_name' => $client->name,
        //         'client_phone' => $client->phone,
        //         'client_email' => $client->email,
        //         'client_company' => $client->company,
        //         'address' => $client->address,
        //         'amount' => array_sum(array_column($products,'amount')),
        //         'products' => $products,
        //     ];
        // }
        // dd($order);
        $breadcrumbs = $this->_breadcrumbs;
        $configDataAjax = OrderDatatableController::getFields();
        $title = $this->_title->index??config('crghome-shop.name');
        $subtitle = $this->_subtitle->index??config('crghome-shop.name');
        $pageBtnAction = [
            (object)[
                'type' => 'link',
                'class' => 'btn-primary',
                'text' => 'Создать',
                'href' => route(config('crghome-shop.prefix') . '.shop.order.create')
            ],
        ];
        return view('crghome-shop::admin._base.index', compact('title', 'subtitle', 'configDataAjax', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\Shop\Order  $order
     */
    public function show(Order $order)
    {
        $arrData = (object)array(
            'order' => $order,
        );
        // dd($arrData);

        $title = $order->label;
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Просмотр заказа магазина "' . $order->number . '"');
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
                'href' => route(config('crghome-shop.prefix') . '.shop.order.edit', $order),
            ],
        ];
        return view('crghome-shop::admin.order.show', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrData = (object)array(
            'products' => Product::select(['name', 'id'])->orderBy('name')->get()->pluck('name', 'id')->toArray(),
            // 'config' => ShopSettingsService::getConfiguration(),
            'route' => route(config('crghome-shop.prefix') . '.shop.order.store'),
            'method' => 'POST'
        );
        //dd(\Auth::user()->hasRole('superadmin|admin|manager'));

        $title = $this->_title->create??config('crghome-shop.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Создание заказа');
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::admin.order.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\OrderFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderFormRequest $request)
    {
        $data = $request->except(['id']);
        $save = ShopOrderService::saveUpdateOrder($data);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\Shop\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $arrData = (object)array(
            'Order' => $order,
            // 'categories' => Category::orderBy('name')->get()->pluck('name', 'id')->prepend('-- Корневая директория --', null)->toArray(),
            // 'config' => ShopSettingsService::getConfiguration(),
            'route' => route(config('crghome-shop.prefix') . '.shop.order.update', $order),
            'method' => 'PATCH'
        );

        $title = ($this->_title->update??config('crghome-shop.name')) . ' "' . $order->name . '"';
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Редактирование заказа "' . $order->name . '"');
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::admin.order.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\OrderFormRequest  $request
     * @param  \Crghome\Shop\Models\Shop\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderFormRequest $request, Order $order)
    {
        $data = $request->except(['id']);
        $save = ShopOrderService::saveUpdateOrder($data, $order);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        // $res = ShopOrderService::deleteOrder($order);
        // return Redirect::to($this->_backRoute);
    }
}
