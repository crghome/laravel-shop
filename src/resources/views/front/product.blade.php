@section('title', $title??config('app.name'))
@section('description', $meta->description??$title)
@section('keywords', $meta->keywords??$title)
@section('ogimage', $ogimage??config('app.ogimage'))
@extends('main.layouts.master')

@section('content')
<div class="wrapperPage" style="padding: 150px 0 100px;">
    <div class="container">
        <div class="row">
            <div class="col-12" style="margin-bottom: 40px;">
                <h2>PRODUCT: "{{ $data->product->name }}"</h2>
                @if($data->product->categories->isNotEmpty()??false)
                    <p><a href="{{ route('site.shop.category', $data->product->categories->first()) }}">Назад</a></p>
                @else
                    <p><a href="{{ route('site.shop.main') }}">Назад корень</a></p>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        <x-package-crghome-shop-categories-of-product-component :collectCategories="$data->categories" />
    </div>
    @if(!empty(trim($data->product->prevText)))
        <div class="container">
            <div class="row">
                <div class="col-12 pageContent" style="margin-bottom: 40px;">
                    <div class="h4">Интро текст <code>{{ ($data->product?->showPrevText??false) ? 'показывается' : 'не показывается' }}</code></div>
                </div>
                <div class="col-12 pageContent" style="margin-bottom: 40px;">
                    {!! $data->product->prevText !!}
                </div>
            </div>
        </div>
    @endif
    @if(!empty(trim($data->product->fullText)))
        <div class="container">
            <div class="row">
                <div class="col-12 pageContent" style="margin-bottom: 40px;">
                    <div class="h4">Полный текст</div>
                </div>
                <div class="col-12 pageContent" style="margin-bottom: 40px;">
                    {!! $data->product->fullText !!}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection