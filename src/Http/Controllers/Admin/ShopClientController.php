<?php

namespace Crghome\Shop\Http\Controllers\Admin;

use Crghome\Shop\Http\Controllers\Admin\Controller;
use Crghome\Shop\Http\Controllers\Api\Datatable\Shop\ClientDatatableController;
use Crghome\Shop\Http\Requests\ClientFormRequest;
use Crghome\Shop\Models\Shop\Client;
use Crghome\Shop\Services\ShopClientService;
use Illuminate\Support\Facades\Redirect;

class ShopClientController extends Controller
{
    protected $_breadcrumbs;
    protected $_listRoute;
    protected $_backRoute;
    protected $_pageBtnAction;

    protected Object $_title;
    protected Object $_subtitle;

    public function __construct()
    {
        $this->_listRoute = route(config('crghome-shop.prefix') . '.shop.client.index');
        $this->_backRoute = $this->_listRoute;
        $this->_pageBtnAction = array(
            (object)['type' => 'link', 'class' => 'btn-light-primary', 'icon' => 'ki ki-long-arrow-back icon-sm', 'text' => 'Назад', 'href' => $this->_listRoute],
            (object)['type' => 'button', 'class' => 'btn-primary', 'icon' => 'ki ki-check icon-sm', 'text' => 'Сохранить', 'action' => 'onClick="adminForm.submitAction(\'save\')"']
        );
        $this->_breadcrumbs = array(
            array('text' => 'Главная', 'href' => '/'),
            array('text' => config('crghome-shop.name', 'Магазин'), 'href' => route(config('crghome-shop.prefix') . '.shop.index')),
            'index' => array('text' => 'Клиенты')
        );
        $this->_title = (object)[
            'index' => 'Клиенты',
            'show' => 'Клиент',
            'create' => 'Создание клиента',
            'update' => 'Обновление клиента',
        ];
        $this->_subtitle = (object)[
            'index' => 'Список клиентов'
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
        $configDataAjax = ClientDatatableController::getFields();
        $title = $this->_title->index??config('crghome-shop.name');
        $subtitle = $this->_subtitle->index??config('crghome-shop.name');
        $pageBtnAction = [
            (object)[
                'type' => 'link',
                'class' => 'btn-primary',
                'text' => 'Создать',
                'href' => route(config('crghome-shop.prefix') . '.shop.client.create')
            ],
        ];
        return view('crghome-shop::admin._base.index', compact('title', 'subtitle', 'configDataAjax', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\Shop\Client  $client
     */
    public function show(Client $client)
    {
        $arrData = (object)array(
            'client' => $client,
            'categories' => ($client->categories??[]),
        );
        // dd($arrData);

        $title = $client->label;
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Просмотр продукта магазина "' . $client->name . '"');
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
                'href' => route(config('crghome-shop.prefix') . '.shop.client.edit', $client),
            ],
        ];
        return view('crghome-shop::admin.client.show', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrData = (object)array(
            // 'categories' => Category::orderBy('name')->get()->pluck('name', 'id')->prepend('-- Корневая директория --', null)->toArray(),
            // 'config' => ShopSettingsService::getConfiguration(),
            'route' => route(config('crghome-shop.prefix') . '.shop.client.store'),
            'method' => 'POST'
        );
        //dd(\Auth::user()->hasRole('superadmin|admin|manager'));

        $title = $this->_title->create??config('crghome-shop.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Создание клиента');
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::admin.client.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\ClientFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientFormRequest $request)
    {
        $data = $request->except(['id']);
        $save = ShopClientService::saveUpdateClient($data);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\Shop\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $arrData = (object)array(
            'client' => $client,
            // 'categories' => Category::orderBy('name')->get()->pluck('name', 'id')->prepend('-- Корневая директория --', null)->toArray(),
            // 'config' => ShopSettingsService::getConfiguration(),
            'route' => route(config('crghome-shop.prefix') . '.shop.client.update', $client),
            'method' => 'PATCH'
        );

        $title = ($this->_title->update??config('crghome-shop.name')) . ' "' . $client->name . '"';
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Редактирование клиента "' . $client->name . '"');
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::admin.client.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\ClientFormRequest  $request
     * @param  \Crghome\Shop\Models\Shop\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientFormRequest $request, Client $client)
    {
        $data = $request->except(['id']);
        $save = ShopClientService::saveUpdateClient($data, $client);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $res = ShopClientService::deleteClient($client);
        return Redirect::to($this->_backRoute);
    }
}
