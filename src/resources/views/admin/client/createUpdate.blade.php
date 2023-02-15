@section('title', $title)
@section('subtitle', ($subtitle??''))
@extends('admin.layouts.master')
@section('content')
    @include('admin.fragments.subheader.subheader-general', ['arrBtnsGlobalPage' => ($arrBtnsGlobalPage??[])])
    <x-keen.page-layout >
        <x-alert-flush-component />
        <x-form-component name="admin-form" method="{{ $arrData->method }}" action="{{ $arrData->route }}" enctype="multipart/form-data">
            {{-- arrBtns="[['idtab'=>'tabIndex_global','active'=>true,'icon'=>'fas fa-bars','title'=>'Общее'],['idtab'=>'tabIndex_text','active'=>false,'icon'=>'fab fa-wpforms','title'=>'Текст'],['idtab'=>'tabIndex_img','active'=>false,'icon'=>'fas fa-file-image','title'=>'Изображения'],['idtab'=>'tabIndex_public','active'=>false,'icon'=>'far fa-calendar-check','title'=>'Публикация'],['idtab'=>'tabIndex_seo','active'=>false,'icon'=>'fas fa-chalkboard','title'=>'SEO'],['idtab'=>'tabIndex_system','active'=>false,'icon'=>'fas fa-cogs','title'=>'Настройки']] --}}
            <x-keen.page-card-tabs-layout :arrBtnsCardToolbar="[['idtab'=>'tabIndex_global','active'=>true,'icon'=>'fas fa-bars','title'=>'Общее'],['idtab'=>'tabIndex_text','active'=>false,'icon'=>'fab fa-wpforms','title'=>'Юр'],['idtab'=>'tabIndex_img','active'=>false,'icon'=>'fas fa-file-image','title'=>'Изображения'],['idtab'=>'tabIndex_system','active'=>false,'icon'=>'fas fa-cogs','title'=>'Настройки']]" :arrBtns="$pageBtnAction??[]">
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_global" :active="true">
                    <x-keen.forms.input-component layout="default.inline" classLayout="mb-0" attribute="id" type="hidden" value="{{ $arrData->client?->id??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Login" attribute="login" :required="true" type="text" value="{{ old('login')??$arrData->client?->login??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Имя" attribute="name" :required="true" type="text" value="{{ old('name')??$arrData->client?->name??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Телефон" attribute="phone" :required="true" type="text" value="{{ old('phone')??$arrData->client?->phone??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Email" attribute="email" :required="false" type="text" value="{{ old('email')??$arrData->client?->email??'' }}"/>
                        <div class="form-group row"><label class="col-form-label col-sm-4 text-lg-right text-left"><?= !empty($arrData->client??false) ? 'Изменение' : 'Создание'; ?> пароля</label><div class="col-sm-8"><hr></div></div>
                    <x-keen.forms.input-component layout="default.horizontal" label="Пароль" attribute="password" :required="false" type="password" value=""/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Пароль подтверждение" attribute="password_confirmation" :required="false" type="password" value=""/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_text" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Компания" attribute="company" :required="false" type="text" value="{{ old('company')??$arrData->client?->company??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Адрес" attribute="address" :required="false" type="textarea" value="{{ old('address')??$arrData->client?->address??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_img" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Logo" attribute="images[prev]" :required="false" type="img-filemanager" value="{{ old('images.prev')??$arrData->client?->images?->prev??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Детальное изображение" attribute="images[full]" :required="false" type="img-filemanager" value="{{ old('images.full')??$arrData->client?->images?->full??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_system" :active="false">
                    <x-keen.forms.input-component layout="default.horizontal" label="Разрешить доступ" class="switch-success" attribute="accessed" type="switch" :value="[(old('accessed')??$arrData->client?->accessed??1)]" :listsel="[1 => '']" />
                    <x-keen.forms.input-component layout="default.horizontal" label="Клиент промодерирован" class="switch-success" attribute="moderated" type="switch" :value="[(old('moderated')??$arrData->client?->moderated??1)]" :listsel="[1 => '']" />
                    <x-keen.forms.input-component layout="default.horizontal" label="Подписка на новости" class="switch-master" attribute="subs_news" type="switch" :value="[(old('subs_news')??$arrData->client?->subs_news??0)]" :listsel="[1 => '']" />
                    <x-keen.forms.input-component layout="default.horizontal" label="Подписка на акции" class="switch-master" attribute="subs_actions" type="switch" :value="[(old('subs_actions')??$arrData->client?->subs_actions??0)]" :listsel="[1 => '']" />
                </x-keen.page-card-tabs-content-layout>
            </x-keen.page-card-layout >
        </x-form-component>
    </x-keen.page-layout >
@endsection

