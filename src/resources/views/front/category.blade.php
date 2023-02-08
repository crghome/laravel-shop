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
                <h2>CATEGORY: "{{ $data->category->name }}"</h2>
                @if(!empty($data->category->category??''))
                    <p><a href="{{ route('site.shop.category', $data->category->category) }}">Назад</a></p>
                @else
                    <p><a href="{{ route('site.shop.main') }}">Назад корень</a></p>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        @include('crghome-shop::front.fragments.categories', ['categories' => $data->categories])
        @include('crghome-shop::front.fragments.products', ['products' => $data->products])
        <x-package-crghome-shop-category-products-component :collectProducts="$data->products" />
    </div>
    @if(!empty(trim($data->category->prevText)))
        <div class="container">
            <div class="row">
                <div class="col-12 pageContent" style="margin-bottom: 40px;">
                    <div class="h4">Интро текст <code>{{ ($data->category?->showPrevText??false) ? 'показывается' : 'не показывается' }}</code></div>
                </div>
                <div class="col-12 pageContent" style="margin-bottom: 40px;">
                    {!! $data->category->prevText !!}
                </div>
            </div>
        </div>
    @endif
    @if(!empty(trim($data->category->fullText)))
        <div class="container">
            <div class="row">
                <div class="col-12 pageContent" style="margin-bottom: 40px;">
                    <div class="h4">Полный текст</div>
                </div>
                <div class="col-12 pageContent" style="margin-bottom: 40px;">
                    {!! $data->category->fullText !!}
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="h2">Все продукты</div>
        this no
    </div>
</div>
@endsection