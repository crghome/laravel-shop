@section('title', $title)
@section('subtitle', ($subtitle??''))
@extends('admin.layouts.master')
@section('content')
    @include('admin.fragments.subheader.subheader-general', ['arrBtnsGlobalPage' => ($arrBtnsGlobalPage??[])])
    <x-keen.page-layout >
        <x-alert-flush-component />
        <x-form-component name="admin-form" method="{{ $arrData->method }}" action="{{ $arrData->route }}" enctype="multipart/form-data">
            {{-- arrBtns="[['idtab'=>'tabIndex_global','active'=>true,'icon'=>'fas fa-bars','title'=>'Общее'],['idtab'=>'tabIndex_text','active'=>false,'icon'=>'fab fa-wpforms','title'=>'Текст'],['idtab'=>'tabIndex_img','active'=>false,'icon'=>'fas fa-file-image','title'=>'Изображения'],['idtab'=>'tabIndex_public','active'=>false,'icon'=>'far fa-calendar-check','title'=>'Публикация'],['idtab'=>'tabIndex_seo','active'=>false,'icon'=>'fas fa-chalkboard','title'=>'SEO'],['idtab'=>'tabIndex_system','active'=>false,'icon'=>'fas fa-cogs','title'=>'Настройки']] --}}
            <x-keen.page-card-tabs-layout :arrBtnsCardToolbar="[['idtab'=>'tabIndex_global','active'=>true,'icon'=>'fas fa-bars','title'=>'Общее'],['idtab'=>'tabIndex_text','active'=>false,'icon'=>'fab fa-wpforms','title'=>'Текст'],['idtab'=>'tabIndex_img','active'=>false,'icon'=>'fas fa-file-image','title'=>'Изображения'],['idtab'=>'tabIndex_public','active'=>false,'icon'=>'far fa-calendar-check','title'=>'Публикация'],['idtab'=>'tabIndex_seo','active'=>false,'icon'=>'fas fa-chalkboard','title'=>'SEO'],['idtab'=>'tabIndex_system','active'=>false,'icon'=>'fas fa-cogs','title'=>'Настройки']]" :arrBtns="$pageBtnAction??[]">
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_global" :active="true">
                    <x-keen.forms.input-component layout="default.inline" classLayout="mb-0" attribute="id" type="hidden" value="{{ $arrData->category?->id??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Название" attribute="name" :required="true" type="text" value="{{ old('name')??$arrData->category?->name??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Алиас" placeholder="Может сгенерироваться с названия админу" attribute="alias" :required="false" type="text" value="{{ old('alias')??$arrData->category?->alias??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Родительская категория" attribute="category_id" :required="false" type="select2" value="{{ old('category_id')??$arrData->category?->category_id??'' }}" :listsel="$arrData->categories"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Сортировка" placeholder="Чем ниже тем выше" attribute="order" class="numberInput" :required="true" type="text" value="{{ old('order')??$arrData->category?->order??'999' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_text" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.inline" label="Предварительный текст" attribute="prevText" :required="false" type="ckeditor" value="{{ old('prevText')??$arrData->category?->prevText??'' }}"/>
                    <x-keen.forms.input-component layout="default.inline" label="Полный текст" attribute="fullText" :required="false" type="ckeditor" value="{{ old('fullText')??$arrData->category?->fullText??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_img" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Предварительное изображение" attribute="images[prev]" :required="false" type="img-filemanager" value="{{ old('images.prev')??$arrData->category?->images?->prev??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Детальное изображение" attribute="images[full]" :required="false" type="img-filemanager" value="{{ old('images.full')??$arrData->category?->images?->full??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_public" :active="false">
                    @php
                        $dateEnd = !empty($arrData->category->dateEndPub) ? date('Y-m-d H:i', strtotime($arrData->category->dateEndPub)) : '';
                    @endphp
                    <x-keen.forms.input-component layout="default.horizontal" label="Дата начала публикации" placeholder="--.--.----" attribute="dateBeginPub" :required="false" type="datetime" value="{{ old('dateBeginPub')??$arrData->category?->dateBeginPub??date('Y-m-d 00:00') }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Дата окончания публикации" placeholder="--.--.----" attribute="dateEndPub" :required="false" type="datetime" value="{{ old('dateEndPub')??$arrData->category?->dateEndPub??$dateEnd }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_seo" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Title категории" attribute="title" :required="false" type="text" value="{{ old('title')??$arrData->category?->title??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Description категории" attribute="meta[description]" :required="false" type="text" value="{{ old('meta.description')??$arrData->category?->meta->description??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Keywords категории" attribute="meta[keywords]" :required="false" type="text" value="{{ old('meta.keywords')??$arrData->category?->meta->keywords??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_system" :active="false">
                    <x-keen.forms.input-component layout="default.horizontal" label="Скрыть категорию" class="switch-danger" attribute="hide" type="switch" :value="[(old('hide')??$arrData->category?->hide??0)]" :listsel="[1 => '']" />
                    <x-keen.forms.input-component layout="default.horizontal" label="Показывать предварительный текст в категории" class="switch-success" attribute="showPrevText" type="switch" :value="[(old('showPrevText')??$arrData->category?->showPrevText??1)]" :listsel="[1 => '']" />
                </x-keen.page-card-tabs-content-layout>
            </x-keen.page-card-layout >
        </x-form-component>
    </x-keen.page-layout >
@endsection
