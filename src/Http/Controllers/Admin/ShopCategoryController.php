<?php

namespace Crghome\Shop\Http\Controllers\Admin;

use Crghome\Shop\Http\Controllers\Admin\Controller;
use Crghome\Shop\Models\Shop\Category;
use Crghome\Shop\Http\Controllers\Api\Datatable\Shop\CategoryDatatableController;
use Crghome\Shop\Http\Requests\CategoryFormRequest;
use Crghome\Shop\Services\ShopCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ShopCategoryController extends Controller
{
    protected $_breadcrumbs;
    protected $_listRoute;
    protected $_backRoute;
    protected $_pageBtnAction;

    protected Object $_title;
    protected Object $_subtitle;

    public function __construct()
    {
        $this->_listRoute = route(config('crghome-shop.prefix') . '.shop.category.index');
        $this->_backRoute = $this->_listRoute;
        $this->_pageBtnAction =[
            (object)['type' => 'link', 'class' => 'btn-light-primary', 'icon' => 'ki ki-long-arrow-back icon-sm', 'text' => 'Назад', 'href' => $this->_listRoute],
            (object)['type' => 'button', 'class' => 'btn-primary', 'icon' => 'ki ki-check icon-sm', 'text' => 'Сохранить', 'action' => 'onClick="adminForm.submitAction(\'save\')"']
        ];
        $this->_breadcrumbs = array(
            array('text' => 'Главная', 'href' => '/'),
            array('text' => config('crghome-shop.name', 'Магазин'), 'href' => route(config('crghome-shop.prefix') . '.shop.index')),
            'index' => array('text' => 'Категории')
        );
        $this->_title = (object)[
            'index' => 'Категории',
            'show' => 'Категория',
            'create' => 'Создание категории',
            'update' => 'Обновление категории',
        ];
        $this->_subtitle = (object)[
            'index' => 'Список категорий'
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
        $configDataAjax = CategoryDatatableController::getFields();
        $title = $this->_title->index??config('crghome-shop.name');
        $subtitle = $this->_subtitle->index??config('crghome-shop.name');
        $pageBtnAction = [
            (object)[
                'type' => 'link',
                'class' => 'btn-primary',
                'text' => 'Создать',
                'href' => route(config('crghome-shop.prefix') . '.shop.category.create')
            ],
        ];
        return view('crghome-shop::admin._base.index', compact('title', 'subtitle', 'configDataAjax', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\Shop\Category  $category
     */
    public function show(Category $category)
    {
        $arrData = (object)array(
            'category' => $category,
            'categories' => ($category->categories??[]),
            'products' => ($category->products??[]),
        );
        // dd($arrData);

        $title = $category->label;
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Просмотр категории магазина "' . $category->label . '"');
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
                'text' => 'Список',
                'href' => route(config('crghome-shop.prefix') . '.shop.product.index', ['f_category' => $category->id]),
            ],
        ];
        return view('crghome-shop::admin.category.show', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
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
            'route' => route(config('crghome-shop.prefix') . '.shop.category.store'),
            'method' => 'POST'
        );
        //dd(\Auth::user()->hasRole('superadmin|admin|manager'));

        $title = $this->_title->create??config('crghome-shop.name');
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Создание категории');
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::admin.category.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\CategoryFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryFormRequest $request)
    {
        $data = $request->except(['id']);
        $save = ShopCategoryService::saveUpdateCategory($data);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Crghome\Shop\Models\Shop\Category  $mapPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $arrData = (object)array(
            'category' => $category,
            'categories' => Category::where('id', '!=', $category->id)->orderBy('name')->get()->pluck('name', 'id')->prepend('-- Корневая директория --', null)->toArray(),
            'route' => route(config('crghome-shop.prefix') . '.shop.category.update', $category),
            'method' => 'PATCH'
        );
        // dd($category);

        $title = ($this->_title->update??config('crghome-shop.name')) . ' "' . $category->name . '"';
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs['index']['href'] = $this->_listRoute;
        $breadcrumbs[] = array('text' => 'Редактирование категории "' . $category->name . '"');
        $pageBtnAction = $this->_pageBtnAction;
        return view('crghome-shop::admin.category.createUpdate', compact('title', 'arrData', 'pageBtnAction', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Crghome\Shop\Http\Requests\CategoryFormRequest  $request
     * @param  \Crghome\Shop\Models\Shop\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryFormRequest $request, Category $category)
    {
        $data = $request->except(['id']);
        $save = ShopCategoryService::saveUpdateCategory($data, $category);
        return $save ? Redirect::to($this->_backRoute) : Redirect::back()->withInput($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Crghome\Shop\Models\Shop\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $res = ShopCategoryService::deleteCategory($category);
        return Redirect::to($this->_backRoute);
    }
}
