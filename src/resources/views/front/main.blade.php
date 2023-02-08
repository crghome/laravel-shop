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
    </div>
</div>
@endsection