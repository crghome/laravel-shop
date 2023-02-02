<?php
namespace Crghome\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Crghome\Shop\Http\Controllers\Api\Datatable\Shop\ProductDatatableController;
use Illuminate\Support\Facades\Redirect;

class ShopController extends Controller{
    protected $_breadcrumbs;
    protected $_listRoute;
    protected $_backRoute;
    protected $_pageBtnAction;

    protected Object $_title;
    protected Object $_subtitle;

    public function __construct()
    {
        // $this->_listRoute = route(config('crghome-shop.prefix') . '.shop.index');
        $this->_backRoute = $this->_listRoute;
        $this->_pageBtnAction =[
            (object)['type' => 'link', 'class' => 'btn-light-primary', 'icon' => 'ki ki-long-arrow-back icon-sm', 'text' => 'Назад', 'href' => $this->_listRoute],
            (object)['type' => 'button', 'class' => 'btn-primary', 'icon' => 'ki ki-check icon-sm', 'text' => 'Сохранить', 'action' => 'onClick="adminForm.submitAction(\'save\')"']
        ];
        $this->_breadcrumbs = array(
            array('text' => 'Главная', 'href' => '/'),
            array('text' => config('crghome-shop.name', 'Магазин')),
            'index' => array('text' => 'Товары')
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
    protected function index()
    {
        $arrData = (object)array();
        $breadcrumbs = $this->_breadcrumbs;
        $configDataAjax = ProductDatatableController::getFields();
        $title = $this->_title->index??config('desc-panel.name');
        $subtitle = $this->_subtitle->index??config('desc-panel.name');
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
}