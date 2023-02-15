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
                    <x-keen.forms.input-component layout="default.inline" classLayout="mb-0" attribute="id" type="hidden" value="{{ $arrData->product?->id??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Название" attribute="name" :required="true" type="text" value="{{ old('name')??$arrData->product?->name??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Алиас" placeholder="Может сгенерироваться с названия админу" attribute="alias" :required="false" type="text" value="{{ old('alias')??$arrData->product?->alias??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" class="numberInput" label="Цена" attribute="price" :required="false" type="text" value="{{ old('price')??$arrData->product?->price??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" class="numberInput" label="Старая цена" attribute="price_old" :required="false" type="text" value="{{ old('price_old')??$arrData->product?->price_old??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" class="numberInput" label="Количество" attribute="count" :required="false" type="text" value="{{ old('count')??$arrData->product?->count??'' }}"/>
                    @php 
                        $setSufixPrice = !empty($arrData->product??[]) && ($arrData->product?->count()??[]) 
                            ? ($arrData->product->suffixPrice??'') 
                            : ($arrData->config?->suffixPrice??'');
                    @endphp
                    {{-- <x-keen.forms.input-component layout="default.horizontal" label="Суфикс цены" attribute="suffixPrice" :required="false" type="text" value="{{ old('suffixPrice')??$arrData->product?->suffixPrice??$arrData->config?->suffixPrice??'' }}"/> --}}
                    <x-keen.forms.input-component layout="default.horizontal" label="Суфикс цены" attribute="suffixPrice" :required="false" type="text" value="{{ old('suffixPrice')??$setSufixPrice }}"/>
                    @php 
                        $setProdCat = !empty($arrData->product) ? $arrData->product?->categories?->pluck('id')?->toArray() : []; 
                    @endphp
                    <x-keen.forms.input-component layout="default.horizontal" label="Родительская категория" attribute="category_id" :required="false" :multiple="true" type="select2" :value="old('category_id')??$setProdCat" :listsel="$arrData->categories"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Сортировка" placeholder="Чем ниже тем выше" attribute="order" class="numberInput" :required="true" type="text" value="{{ old('order')??$arrData->product?->order??'999' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_text" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.inline" label="Предварительный текст" attribute="prevText" :required="false" type="ckeditor" value="{{ old('prevText')??$arrData->product?->prevText??'' }}"/>
                    <x-keen.forms.input-component layout="default.inline" label="Полный текст" attribute="fullText" :required="false" type="ckeditor" value="{{ old('fullText')??$arrData->product?->fullText??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_img" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Предварительное изображение" attribute="images[prev]" :required="false" type="img-filemanager" value="{{ old('images.prev')??$arrData->product?->images?->prev??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Детальное изображение" attribute="images[full]" :required="false" type="img-filemanager" value="{{ old('images.full')??$arrData->product?->images?->full??'' }}"/>

                    <div class="separator separator-dashed my-8"></div>
                    <div id="repeater-gallery-container">
                        <div class="row">
                            <label class="col-form-label col-md-3 col-sm-2 text-lg-right text-left">Фото</label>
                            <div class="col-md-9 col-sm-10 my-2" data-repeater-list="pictures">
                                        
                                <div data-repeater-item class="form-group row itemRepeator_gallery">
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input id="imgfilemanager_gallery" class="form-control form-control-lg form-control-solid setIdGallery" name="image" type="text" value="" aria-describedby="button-addon" placeholder="Выберите картинку" autocomplete="off">
                                            <div class="input-group-append"><button class="btn btn-primary gallery setGalleryBtn" data-input="imgfilemanager_gallery" data-preview="holder_gallery" type="button"><i class="far fa-image"></i> Выбрать</button></div>
                                        </div>
                                        <div id="holder_gallery" class="mt-2 setGalleryHolder" style="max-height:100px; flex: 0 0 100%;"></div>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="col-sm-2"><a href="javascript:;" data-repeater-delete="" class="btn font-weight-bold btn-danger btn-icon"><i class="la la-remove"></i></a></div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right"></label>
                            <div class="col-lg-4"><a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary"><i class="la la-plus"></i>Добавить</a></div>
                        </div>
                    </div>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_public" :active="false">
                    @php
                        $dateEnd = !empty($arrData->product->dateEndPub) ? date('Y-m-d H:i', strtotime($arrData->product->dateEndPub)) : '';
                    @endphp
                    <x-keen.forms.input-component layout="default.horizontal" label="Дата начала публикации" placeholder="--.--.----" attribute="dateBeginPub" :required="false" type="datetime" value="{{ old('dateBeginPub')??$arrData->product?->dateBeginPub??date('Y-m-d 00:00') }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Дата окончания публикации" placeholder="--.--.----" attribute="dateEndPub" :required="false" type="datetime" value="{{ old('dateEndPub')??$arrData->product?->dateEndPub??$dateEnd }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_seo" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Title категории" attribute="title" :required="false" type="text" value="{{ old('title')??$arrData->product?->title??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Description категории" attribute="meta[description]" :required="false" type="text" value="{{ old('meta.description')??$arrData->product?->meta->description??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Keywords категории" attribute="meta[keywords]" :required="false" type="text" value="{{ old('meta.keywords')??$arrData->product?->meta->keywords??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_system" :active="false">
                    <x-keen.forms.input-component layout="default.horizontal" label="Скрыть продукт" class="switch-danger" attribute="hide" type="switch" :value="[(old('hide')??$arrData->product?->hide??0)]" :listsel="[1 => '']" />
                    <x-keen.forms.input-component layout="default.horizontal" label="Показывать суфикс цены" class="switch-success" attribute="showSuffixPrice" type="switch" :value="[(old('showSuffixPrice')??$arrData->product?->showSuffixPrice??$arrData->config?->showSuffixPrice??0)]" :listsel="[1 => '']" />
                    <x-keen.forms.input-component layout="default.horizontal" label="Показывать предварительный текст в продукте" class="switch-success" attribute="showPrevText" type="switch" :value="[(old('showPrevText')??$arrData->product?->showPrevText??$arrData->config?->showPrevText??0)]" :listsel="[1 => '']" />
                </x-keen.page-card-tabs-content-layout>
            </x-keen.page-card-layout >
        </x-form-component>
    </x-keen.page-layout >
@endsection

@push('script')
<script defer>
jQuery(document).ready(function() {
    // GALLERY
    function reGallery(){
        $.each($('#repeater-gallery-container .itemRepeator_gallery'), function(ind, val){
            $(val).find('.setIdGallery').attr('id', 'fileManager_gallery' + ind);
            $(val).find('.setGalleryBtn').attr('data-input', 'fileManager_gallery' + ind);
            $(val).find('.setGalleryBtn').attr('data-preview', 'holder_gallery' + ind);
            $(val).find('.setGalleryHolder').attr('id', 'holder_gallery' + ind);
            $(val).find('.setGalleryHolder').html() == '' 
                ? $(val).find('.setGalleryHolder').html('<img src="' + $(val).find('.setIdGallery').val() + '" style="height: 5rem;" />')
                : false;
        });
        $('.gallery').filemanager('image', {prefix: '/laravel-filemanager'});
    }
    window.galleryRepeater = $('#repeater-gallery-container').repeater({
        initEmpty: false,
        defaultValues: {},
        show: function () {
            $(this).slideDown();
            reGallery();
        },
        ready: function (setIndexes) {
            reGallery();
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },
        // isFirstItemUndeletable: true
    });
    @php $oldGallery = old('pictures')??(array_map(function($it){ return ['image' => $it]; }, ($arrData->product?->pictures??[])))??[]; @endphp
    @if(!empty($oldGallery))
        window.galleryRepeater.setList(<?=json_encode($oldGallery)?>);
        reGallery();
    @endif
});
</script>
@endPush

