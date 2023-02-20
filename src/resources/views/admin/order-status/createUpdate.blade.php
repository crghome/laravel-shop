@section('title', $title)
@section('subtitle', ($subtitle??''))
@extends('admin.layouts.master')
@section('content')
    @include('admin.fragments.subheader.subheader-general', ['arrBtnsGlobalPage' => ($arrBtnsGlobalPage??[])])
    <x-keen.page-layout >
        <x-alert-flush-component />
        <x-form-component name="admin-form" method="{{ $arrData->method }}" action="{{ $arrData->route }}" enctype="multipart/form-data">
            {{-- arrBtns="[['idtab'=>'tabIndex_global','active'=>true,'icon'=>'fas fa-bars','title'=>'Общее'],['idtab'=>'tabIndex_text','active'=>false,'icon'=>'fab fa-wpforms','title'=>'Текст'],['idtab'=>'tabIndex_img','active'=>false,'icon'=>'fas fa-file-image','title'=>'Изображения'],['idtab'=>'tabIndex_public','active'=>false,'icon'=>'far fa-calendar-check','title'=>'Публикация'],['idtab'=>'tabIndex_seo','active'=>false,'icon'=>'fas fa-chalkboard','title'=>'SEO'],['idtab'=>'tabIndex_system','active'=>false,'icon'=>'fas fa-cogs','title'=>'Настройки']] --}}
            <x-keen.page-card-tabs-layout :arrBtnsCardToolbar="[['idtab'=>'tabIndex_global','active'=>true,'icon'=>'fas fa-bars','title'=>'Общее'],['idtab'=>'tabIndex_img','active'=>false,'icon'=>'fas fa-file-image','title'=>'Изображения']]" :arrBtns="$pageBtnAction??[]">
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_global" :active="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Тип статуса" attribute="type_status" :required="true" type="select2" :value="old('type_status')??$arrData->orderStatus?->typeStatus??''" :listsel="$arrData->typeStatus"/>
                    <x-keen.forms.input-component layout="default.inline" classLayout="mb-0" attribute="id" type="hidden" value="{{ $arrData->orderStatus?->id??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Код" placeholder="NB" attribute="code" :required="true" type="text" value="{{ old('code')??$arrData->orderStatus?->code??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Название" attribute="name" :required="true" type="text" value="{{ old('name')??$arrData->orderStatus?->name??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="CSS Class" attribute="css_class" :required="false" type="text" value="{{ old('css_class')??$arrData->orderStatus?->css_class??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Сортировка" placeholder="Чем ниже тем выше" attribute="order" class="numberInput" :required="true" type="text" value="{{ old('order')??$arrData->orderStatus?->order??'999' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Пометка" attribute="remark" :required="false" type="textarea" value="{{ old('remark')??$arrData->orderStatus?->remark??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_img" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Font Awesome Class" attribute="icon_class" :required="false" type="text" value="{{ old('icon_class')??$arrData->orderStatus?->icon_class??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Icon base" attribute="icon_base" :required="false" type="textarea" value="{{ old('icon_base')??$arrData->orderStatus?->icon_base??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Предварительное изображение" attribute="images[prev]" :required="false" type="img-filemanager" value="{{ old('images.prev')??$arrData->orderStatus?->images?->prev??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Детальное изображение" attribute="images[full]" :required="false" type="img-filemanager" value="{{ old('images.full')??$arrData->orderStatus?->images?->full??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_public" :active="false">
                    @php
                        $dateEnd = !empty($arrData->orderStatus->dateEndPub) ? date('Y-m-d H:i', strtotime($arrData->orderStatus->dateEndPub)) : '';
                    @endphp
                    <x-keen.forms.input-component layout="default.horizontal" label="Дата начала публикации" placeholder="--.--.----" attribute="dateBeginPub" :required="false" type="datetime" value="{{ old('dateBeginPub')??$arrData->orderStatus?->dateBeginPub??date('Y-m-d 00:00') }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Дата окончания публикации" placeholder="--.--.----" attribute="dateEndPub" :required="false" type="datetime" value="{{ old('dateEndPub')??$arrData->orderStatus?->dateEndPub??$dateEnd }}"/>
                </x-keen.page-card-tabs-content-layout>
            </x-keen.page-card-layout >
        </x-form-component>
    </x-keen.page-layout >
@endsection
