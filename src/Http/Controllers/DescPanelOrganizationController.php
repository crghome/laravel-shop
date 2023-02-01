<?php

namespace Crghome\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Crghome\Shop\Http\Controllers\Api\Datatable\DPOrganizationDatatableController;
use Crghome\Shop\Http\Requests\DpOrganizationFormRequest;
use Crghome\Shop\Models\DptOrganization;
use Crghome\Shop\Services\DpOrganizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ShopOrganizationController extends Controller
{
    protected $_breadcrumbs = array(
        array('text' => 'Главная', 'href' => '/'),
        array('text' => 'Desc Panel'),
        'index' => array('text' => 'Организации')
    );
    protected $_listRoute;
    protected $_backRoute;
    protected $_pageBtnAction;

    protected Object $_title;
    protected Object $_subtitle;

    public function __construct()
    {
        $this->_listRoute = route('desc-panel.organization.index');
        $this->_backRoute = $this->_listRoute;
        $this->_pageBtnAction =[
            (object)['type' => 'link', 'class' => 'btn-light-primary', 'icon' => 'ki ki-long-arrow-back icon-sm', 'text' => 'Назад', 'href' => $this->_listRoute],
            (object)['type' => 'button', 'class' => 'btn-primary', 'icon' => 'ki ki-check icon-sm', 'text' => 'Сохранить', 'action' => 'onClick="adminForm.submitAction(\'save\')"']
        ];
        $this->_title = (object)[
            'index' => 'Организации',
            'show' => 'Карточка организации',
            'create' => 'Создание организации',
            'update' => 'Обновление организации',
        ];
        $this->_subtitle = (object)[
            'index' => 'Список организаций'
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
        $configDataAjax = DPOrganizationDatatableController::getFields();
        $title = $this->_title->index??config('desc-panel.name');
        $subtitle = $this->_subtitle->index??config('desc-panel.name');
        $pageBtnAction = [
            (object)[
                'type' => 'link',
                'class' => 'btn-primary',
                'text' => 'Создать',
                'href' => route('desc-panel.organization.create')
            ],
        ];
        return view('desc-panel::_base.index', compact('title', 'subtitle', 'configDataAjax', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\DptOrganization  $mapPoint
     */
    public function show(DptOrganization $dptOrganization)
    {
        $arrData = (object)array(
            'organization' => $dptOrganization,
        );
        // dd($arrData->mapPoint);

        $title = $this->_title->show??config('desc-panel.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'карточка организации');
        $arrBtnsGlobalPage = [
            (object)[
                'type' => 'link',
                'class' => 'btn-secondary',
                'text' => 'Назад',
                'href' => route('desc-panel.organization.index')
            ],
        ];
        $pageBtnAction = [
            (object)[
                'type' => 'link',
                'class' => 'btn-primary',
                'text' => 'Редактировать',
                'href' => route('desc-panel.organization.edit', $dptOrganization)
            ],
        ];

        return view('desc-panel::organization.show', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrData = (object)array(
            'route' => route('desc-panel.organization.store'),
            'method' => 'POST'
        );

        $title = $this->_title->create??config('desc-panel.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Создание организации');
        $pageBtnAction = $this->_pageBtnAction;

        return view('desc-panel::organization.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\DpOrganizationFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DpOrganizationFormRequest $request)
    {
        $data = $request->except(['id']);
        $save = DpOrganizationService::saveUpdateDptOrganization($data);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\DptOrganization $dptOrganization
     * @return \Illuminate\Http\Response
     */
    public function edit(DptOrganization $dptOrganization)
    {
        $arrData = (object)array(
            'organization' => $dptOrganization,
            'route' => route('desc-panel.organization.update', $dptOrganization),
            'method' => 'PATCH'
        );
        // dd($arrData->mapPoint);

        $title = $this->_title->update??config('desc-panel.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Редактирование организации ' . $dptOrganization->name);
        $pageBtnAction = $this->_pageBtnAction;

        return view('desc-panel::organization.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\DpOrganizationFormRequest $request
     * @param  \Crghome\Shop\Models\DptOrganization $dptOrganization
     * @return \Illuminate\Http\Response
     */
    public function update(DpOrganizationFormRequest $request, DptOrganization $dptOrganization)
    {
        $data = $request->except(['id']);
        $save = DpOrganizationService::saveUpdateDptOrganization($data, $dptOrganization);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Crghome\Shop\Models\DptOrganization $dptOrganization
     * @return \Illuminate\Http\Response
     */
    public function destroy(DptOrganization $dptOrganization)
    {
        $res = DpOrganizationService::deleteDptOrganization($dptOrganization);
        return Redirect::to($this->_backRoute);
    }
}
