@section('title', $title)
@section('subtitle', ($subtitle??''))
@extends('admin.layouts.master')
@section('content')
    @include('admin.fragments.subheader.subheader-general', ['arrBtnsGlobalPage' => ($arrBtnsGlobalPage??[])])
    <x-keen.page-layout >
        <x-alert-flush-component />
        <x-keen.page-card-layout title="Продукт: {{ $arrData->product->name }}" :arrBtns="$pageBtnAction??[]" >
            <h4 class="mb-6">Предварительный текст</h4>
            <div class="mb-4 p-3">{!! $arrData->product->prevText??'---' !!}</div>
            <hr>

            <h4 class="mb-6">Полный текст</h4>
            <div class="mb-4 p-3">{!! $arrData->product->fullText??'---' !!}</div>
            <hr>

            <h4 class="mb-6">Категории</h4>
            <div class="row mb-7">
            @foreach (($arrData->categories??[]) as $item)
                @php 
                    $img = !empty($item->images->prev) ? $item->images?->prev : $item->images?->full;
                    empty($img) ? $img = '/images/noImg.jpg' : false;
                @endphp
                <div class="col-lg-4 col-sm-6 mb-6">
                    <div class="card card-custom">
                        <div class="card-header ribbon ribbon-clip ribbon-right">
                            <div class="ribbon-target" style="top: 10px;"><span class="ribbon-inner bg-warning"></span>{{ $item->order }}</div>
                            <h3 class="card-title">{{ $item->name }}</h3>
                        </div>
                        <img src="{{ $img }}" style="height: 150px; width: 100%; background-color: gray; object-fit: cover; " />
                        <div class="card-body">
                            <div>{!! $item->prevText??'---' !!}</div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route(config('crghome-shop.prefix') . '.shop.category.edit', $item) }}" class="btn btn-light-primary font-weight-bold">Редактировать</a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            <hr>

            @if(!empty($arrData->product->pictures??[]))
                @include('crghome-shop::fragments.shop.slider-pictures', ['pictures' => ($arrData->product->pictures??[])])
                <hr>
            @endif

            {{-- <x-keen.tree-component layout="basic" :items="$arrData->treeMenu??[]" /> --}}

        </x-keen.page-card-layout>
    </x-keen.page-layout >
@endsection
