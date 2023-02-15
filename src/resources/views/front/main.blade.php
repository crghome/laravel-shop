@section('title', $title??config('app.name'))
@section('description', $meta->description??$title)
@section('keywords', $meta->keywords??$title)
@section('ogimage', $ogimage??config('app.ogimage'))
@extends('main.layouts.master')

@section('content')
<div class="wrapperPage" style="padding: 150px 0 100px;">
    <div class="container">
        <div class="row">
            <div class="col-12" style="margin-bottom: 30px;">
                <h2>MAIN</h2>
            </div>
        </div>
    </div>
    <div class="container">
        @include('crghome-shop::front.fragments.categories', ['categories' => $data->categories])
        @include('crghome-shop::front.fragments.products', ['products' => $data->products])
    </div>
    <div class="container">
        <div class="h2">Все продукты</div>
        <x-package-crghome-shop-category-products-component :collectProducts="null" :recursive="true" />
    </div>
</div>
@endsection