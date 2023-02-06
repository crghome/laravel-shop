<?php
namespace Crghome\Shop\Http\Controllers\Admin;

use Crghome\Shop\Http\Controllers\Admin\Controller;
use Illuminate\Support\Facades\Redirect;

class ShopController extends Controller
{
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
            'index' => array('text' => config('crghome-shop.name', 'Магазин'))
        );
        $this->_title = (object)[
            'index' => config('crghome-shop.name', 'Магазин'),
            'show' => config('crghome-shop.name', 'Магазин'),
            'create' => 'Создание ' . config('crghome-shop.name', 'Магазин'),
            'update' => 'Обновление ' . config('crghome-shop.name', 'Магазин'),
        ];
        $this->_subtitle = (object)[
            'index' => 'Список ' . config('crghome-shop.name', 'Магазин')
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
        $title = $this->_title->index??config('crghome-shop.name', 'Магазин');
        $subtitle = $this->_subtitle->index??config('crghome-shop.name', 'Магазин');
        $pageBtnAction = [
            (object)[
                'type' => 'dropdown',
                'class' => 'btn-primary',
                'icon' => 'fas fa-plus-square',
                'text' => 'гипер',
                'menu' => [
                    (object)[
                        'type' => 'link',
                        'class' => 'btn-primary',
                        'text' => 'Создать категорию',
                        'href' => route(config('crghome-shop.prefix') . '.shop.category.create')
                    ],
                    (object)[
                        'type' => 'link',
                        'class' => 'btn-primary',
                        'text' => 'Создать продукт',
                        'href' => route(config('crghome-shop.prefix') . '.shop.product.create')
                    ],
                ]
            ],
        ];
        return view('crghome-shop::admin.index', compact('title', 'subtitle', 'pageBtnAction', 'breadcrumbs', 'arrData'));
    }
}