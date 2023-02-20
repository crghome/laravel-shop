<?php

namespace Crghome\Shop\Http\Controllers\Admin;

use Crghome\Shop\Enum\TypeOrderStatus;
use Crghome\Shop\Http\Controllers\Admin\Controller;
use Crghome\Shop\Http\Controllers\Api\Datatable\Shop\OrderStatusDatatableController;
use Crghome\Shop\Http\Requests\OrderStatusFormRequest;
use Crghome\Shop\Models\Shop\OrderStatus;
use Crghome\Shop\Services\ShopOrderStatusService;
use Crghome\Shop\Services\ShopSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ShopOrderStatusController extends Controller
{
    protected $_breadcrumbs;
    protected $_listRoute;
    protected $_backRoute;
    protected $_pageBtnAction;

    protected Object $_title;
    protected Object $_subtitle;

    public function __construct()
    {
        $this->_listRoute = route(config('crghome-shop.prefix') . '.shop.order-status.index');
        $this->_backRoute = $this->_listRoute;
        $this->_pageBtnAction = array(
            (object)['type' => 'link', 'class' => 'btn-light-primary', 'icon' => 'ki ki-long-arrow-back icon-sm', 'text' => 'Назад', 'href' => $this->_listRoute],
            (object)['type' => 'button', 'class' => 'btn-primary', 'icon' => 'ki ki-check icon-sm', 'text' => 'Сохранить', 'action' => 'onClick="adminForm.submitAction(\'save\')"']
        );
        $this->_breadcrumbs = array(
            array('text' => 'Главная', 'href' => '/'),
            array('text' => config('crghome-shop.name', 'Магазин'), 'href' => route(config('crghome-shop.prefix') . '.shop.index')),
            'index' => array('text' => 'Статусы заказа')
        );
        $this->_title = (object)[
            'index' => 'Статусы заказа',
            'show' => 'Статус заказа',
            'create' => 'Создание статуса заказа',
            'update' => 'Обновление статуса заказа',
        ];
        $this->_subtitle = (object)[
            'index' => 'Список статусов заказа'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(\Crghome\Shop\Enum\TypeOrderStatus::fromLike(label: 'дос'));
        $breadcrumbs = $this->_breadcrumbs;
        $configDataAjax = OrderStatusDatatableController::getFields();
        $title = $this->_title->index??config('crghome-shop.name');
        $subtitle = $this->_subtitle->index??config('crghome-shop.name');
        $pageBtnAction = [
            (object)[
                'type' => 'link',
                'class' => 'btn-primary',
                'text' => 'Создать',
                'href' => route(config('crghome-shop.prefix') . '.shop.order-status.create')
            ],
        ];
        return view('crghome-shop::admin._base.index', compact('title', 'subtitle', 'configDataAjax', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\Shop\OrderStatus  $orderStatus
     */
    // public function show(OrderStatus $orderStatus)
    // {
    //     $arrData = (object)array(
    //         'orderStatus' => $orderStatus,
    //         'categories' => ($orderStatus->categories??[]),
    //     );
    //     // dd($arrData);

    //     $title = $orderStatus->label;
    //     $breadcrumbs = $this->_breadcrumbs;
    //     $breadcrumbs['index']['href'] = $this->_listRoute;
    //     $breadcrumbs[] = array('text' => 'Просмотр Статуса заказа магазина "' . $orderStatus->name . '"');
    //     $pageBtnAction = [
    //         (object)[
    //             'type' => 'link',
    //             'class' => 'btn-light-primary',
    //             'icon' => 'ki ki-long-arrow-back icon-sm',
    //             'text' => 'Назад',
    //             'href' => $this->_listRoute,
    //         ],
    //         (object)[
    //             'type' => 'link',
    //             'class' => 'btn-primary',
    //             'icon' => 'la la-edit',
    //             'text' => 'Редактировать',
    //             'href' => route(config('crghome-shop.prefix') . '.shop.order-status.edit', $orderStatus),
    //         ],
    //     ];
    //     return view('crghome-shop::admin.order-status.show', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrData = (object)array(
            'typeStatus' => ShopOrderStatusService::getTypesOrderStatuses(),
            'route' => route(config('crghome-shop.prefix') . '.shop.order-status.store'),
            'method' => 'POST'
        );
        //dd(\Auth::user()->hasRole('superadmin|admin|manager'));

        $title = $this->_title->create??config('crghome-shop.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Создание статуса заказа');
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::admin.order-status.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\OrderStatusFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStatusFormRequest $request)
    {
        $data = $request->except(['id']);
        $save = ShopOrderStatusService::saveUpdateOrderStatus($data);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\Shop\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderStatus $orderStatus)
    {
        $arrData = (object)array(
            'orderStatus' => $orderStatus,
            'typeStatus' => ShopOrderStatusService::getTypesOrderStatuses(),
            'route' => route(config('crghome-shop.prefix') . '.shop.order-status.update', $orderStatus),
            'method' => 'PATCH'
        );
        // dd(isset($arrData->OrderStatus->suffixPrice) || is_null($arrData->OrderStatus->suffixPrice));
        // dd($arrData->OrderStatus?->toArray());

        $title = ($this->_title->update??config('crghome-shop.name')) . ' "' . $orderStatus->name . '"';
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Редактирование статуса заказа "' . $orderStatus->name . '"');
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::admin.order-status.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\OrderStatusFormRequest  $request
     * @param  \Crghome\Shop\Models\Shop\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function update(OrderStatusFormRequest $request, OrderStatus $orderStatus)
    {
        $data = $request->except(['id']);
        $save = ShopOrderStatusService::saveUpdateOrderStatus($data, $orderStatus);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderStatus $orderStatus)
    {
        $res = ShopOrderStatusService::deleteOrderStatus($orderStatus);
        return Redirect::to($this->_backRoute);
    }
}
