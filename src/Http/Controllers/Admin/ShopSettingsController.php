<?php
namespace Crghome\Shop\Http\Controllers\Admin;

use Crghome\Shop\Http\Controllers\Admin\Controller;
use Crghome\Shop\Http\Requests\SettingsFormRequest;
use Crghome\Shop\Models\Shop\OrderStatus;
use Crghome\Shop\Models\Shop\Settings;
use Crghome\Shop\Services\ShopSettingsService;
use Illuminate\Support\Facades\Redirect;

class ShopSettingsController extends Controller
{
    protected $_breadcrumbs;
    protected $_listRoute;
    protected $_backRoute;
    protected $_pageBtnAction;

    protected Object $_title;
    protected Object $_subtitle;

    public function __construct()
    {
        $this->_listRoute = route(config('crghome-shop.prefix') . '.shop.settings.index');
        $this->_backRoute = $this->_listRoute;
        $this->_pageBtnAction =[
            (object)['type' => 'link', 'class' => 'btn-light-primary', 'icon' => 'ki ki-long-arrow-back icon-sm', 'text' => 'Назад', 'href' => $this->_listRoute],
            (object)['type' => 'button', 'class' => 'btn-primary', 'icon' => 'ki ki-check icon-sm', 'text' => 'Сохранить', 'action' => 'onClick="adminForm.submitAction(\'save\')"']
        ];
        $this->_breadcrumbs = array(
            array('text' => 'Главная', 'href' => '/'),
            'index' => array('text' => 'Настройки')
        );
        $this->_title = (object)[
            'index' => 'Настройки',
        ];
        $this->_subtitle = (object)[
            'index' => 'Список настроек'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function index()
    {
        $settings = Settings::firstOrCreate();
        $status = OrderStatus::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $arrData = (object)array(
            'settings' => $settings,
            'status' => $status,
            'route' => route(config('crghome-shop.prefix') . '.shop.settings.update', $settings),
            'method' => 'PATCH'
        );
        $breadcrumbs = $this->_breadcrumbs;
        $title = $this->_title->index??'Настройки';
        $subtitle = $this->_subtitle->index??'Список настроек';
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::admin.settings.createUpdate', compact('title', 'subtitle', 'pageBtnAction', 'breadcrumbs', 'arrData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\SettingsFormRequest  $request
     * @param  \Crghome\Shop\Models\Shop\Settings  $settings
     */
    public function update(SettingsFormRequest $request, Settings $settings)
    {
        $data = $request->except(['id']);
        $save = ShopSettingsService::saveUpdateSettings($data, $settings);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }
}