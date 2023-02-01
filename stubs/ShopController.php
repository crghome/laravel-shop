<?php

namespace App\Http\Controllers\Admin\Shop;

use Crghome\Shop\Http\Controllers\ShopController as ParentShopController;
use Illuminate\Http\Request;

class ShopController extends ParentShopController
{
    // protected $_breadcrumbs = array(
    //     array('text' => 'Главная', 'href' => '/'),
    //     array('text' => 'CRM'),
    //     'index' => array('text' => 'Types')
    // );

    public function __construct()
    {
        parent::__construct();
        // $this->_listRoute = route('navigation.menu.index');
        // $this->_backRoute = $this->_listRoute;
        // $this->_pageBtnAction =[
        //     (object)['type' => 'link', 'class' => 'btn-light-primary', 'icon' => 'ki ki-long-arrow-back icon-sm', 'text' => 'Назад', 'href' => $this->_listRoute],
        //     (object)['type' => 'button', 'class' => 'btn-primary', 'icon' => 'ki ki-check icon-sm', 'text' => 'Сохранить', 'action' => 'onClick="adminForm.submitAction(\'save\')"']
        // ];
        $this->_title->index = 'CRM';
    }

    // public function index()
    // {
    //     return parent::index();
    // }

}
