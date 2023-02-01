<?php

namespace Crghome\DescPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Crghome\DescPanel\Http\Controllers\Api\Datatable\DPCustomerDatatableController;
use Crghome\DescPanel\Http\Requests\DpCustomerFormRequest;
use Crghome\DescPanel\Models\DptClient;
use Crghome\DescPanel\Models\DptCustomer;
use Crghome\DescPanel\Services\DpClientService;
use Crghome\DescPanel\Services\DpCustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DescPanelCustomerController extends Controller
{
    protected $_breadcrumbs = array(
        array('text' => 'Главная', 'href' => '/'),
        array('text' => 'Desc Panel'),
        'index' => array('text' => 'Заказчики')
    );
    protected $_listRoute;
    protected $_backRoute;
    protected $_pageBtnAction;

    protected Object $_title;
    protected Object $_subtitle;

    public function __construct()
    {
        $this->_listRoute = route('desc-panel.customer.index');
        $this->_backRoute = $this->_listRoute;
        $this->_pageBtnAction =[
            (object)['type' => 'link', 'class' => 'btn-light-primary', 'icon' => 'ki ki-long-arrow-back icon-sm', 'text' => 'Назад', 'href' => $this->_listRoute],
            (object)['type' => 'button', 'class' => 'btn-primary', 'icon' => 'ki ki-check icon-sm', 'text' => 'Сохранить', 'action' => 'onClick="adminForm.submitAction(\'save\')"']
        ];
        $this->_title = (object)[
            'index' => 'Заказчики',
            'show' => 'Карточка заказчика',
            'create' => 'Создание заказчика',
            'update' => 'Обновление заказчика',
        ];
        $this->_subtitle = (object)[
            'index' => 'Список заказчиков'
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
        $configDataAjax = DPCustomerDatatableController::getFields();
        $title = $this->_title->index??config('desc-panel.name');
        $subtitle = $this->_subtitle->index??config('desc-panel.name');
        $pageBtnAction = [
            (object)[
                'type' => 'link',
                'class' => 'btn-primary',
                'text' => 'Создать',
                'href' => route('desc-panel.customer.create')
            ],
        ];
        // dd(DptCustomer::all());
        return view('desc-panel::_base.index', compact('title', 'subtitle', 'configDataAjax', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\DescPanel\Models\DptCustomer  $mapPoint
     */
    public function show(DptCustomer $dptCustomer)
    {
        $arrData = (object)array(
            'organization' => $dptCustomer,
        );
        // dd($arrData->mapPoint);

        $title = $this->_title->show??config('desc-panel.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'карточка заказчика');
        $arrBtnsGlobalPage = [
            (object)[
                'type' => 'link',
                'class' => 'btn-secondary',
                'text' => 'Назад',
                'href' => route('desc-panel.customer.index')
            ],
        ];
        $pageBtnAction = [
            (object)[
                'type' => 'link',
                'class' => 'btn-primary',
                'text' => 'Редактировать',
                'href' => route('desc-panel.customer.edit', $dptCustomer)
            ],
        ];

        return view('desc-panel::customer.show', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrData = (object)array(
            'type' => DpCustomerService::getTypesCustomer(),
            'clients' => DpClientService::getListClients(),
            'route' => route('desc-panel.customer.store'),
            'method' => 'POST'
        );
        // dd(DpCustomerService::getTypesCustom());

        $title = $this->_title->create??config('desc-panel.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Создание заказчика');
        $pageBtnAction = $this->_pageBtnAction;

        return view('desc-panel::customer.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Crghome\DescPanel\Http\Requests\DpCustomerFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpCustomerFormRequest $request)
    {
        $data = $request->except(['id']);
        $save = DpCustomerService::saveUpdateDptCustomer($data);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\DescPanel\Models\DptCustomer $dptCustomer
     * @return \Illuminate\Http\Response
     */
    public function edit(DptCustomer $dptCustomer)
    {
        $arrData = (object)array(
            'customer' => $dptCustomer,
            'type' => DpCustomerService::getTypesCustomer(),
            'clients' => DpClientService::getListClients(),
            'route' => route('desc-panel.customer.update', $dptCustomer),
            'method' => 'PATCH'
        );
        // dd($arrData->customer?->pluck('id')->toArray());
        // dd($arrData->customer?->clients?->pluck('id')->toArray());

        $title = $this->_title->update??config('desc-panel.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Редактирование заказчика ' . $dptCustomer->name);
        $pageBtnAction = $this->_pageBtnAction;

        return view('desc-panel::customer.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Crghome\DescPanel\Http\Requests\DpCustomerFormRequest $request
     * @param  \Crghome\DescPanel\Models\DptCustomer $dptCustomer
     * @return \Illuminate\Http\Response
     */
    public function update(DpCustomerFormRequest $request, DptCustomer $dptCustomer)
    {
        $data = $request->except(['id']);
        $save = DpCustomerService::saveUpdateDptCustomer($data, $dptCustomer);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Crghome\DescPanel\Models\DptCustomer $dptCustomer
     * @return \Illuminate\Http\Response
     */
    public function destroy(DptCustomer $dptCustomer)
    {
        $res = DpCustomerService::deleteDptCustomer($dptCustomer);
        return Redirect::to($this->_backRoute);
    }
}
