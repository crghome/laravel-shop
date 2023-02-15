@section('title', $title)
@section('subtitle', ($subtitle??''))
@extends('admin.layouts.master')
@section('content')
    @include('admin.fragments.subheader.subheader-general', ['arrBtnsGlobalPage' => ($arrBtnsGlobalPage??[])])
    <x-keen.page-layout >
        <x-alert-flush-component />
        <x-form-component name="admin-form" method="{{ $arrData->method }}" action="{{ $arrData->route }}" enctype="multipart/form-data">
            {{-- arrBtns="[['idtab'=>'tabIndex_global','active'=>true,'icon'=>'fas fa-bars','title'=>'Общее'],['idtab'=>'tabIndex_text','active'=>false,'icon'=>'fab fa-wpforms','title'=>'Текст'],['idtab'=>'tabIndex_img','active'=>false,'icon'=>'fas fa-file-image','title'=>'Изображения'],['idtab'=>'tabIndex_public','active'=>false,'icon'=>'far fa-calendar-check','title'=>'Публикация'],['idtab'=>'tabIndex_seo','active'=>false,'icon'=>'fas fa-chalkboard','title'=>'SEO'],['idtab'=>'tabIndex_system','active'=>false,'icon'=>'fas fa-cogs','title'=>'Настройки']] --}}
            <x-keen.page-card-tabs-layout :arrBtnsCardToolbar="[['idtab'=>'tabIndex_global','active'=>true,'icon'=>'fas fa-bars','title'=>'Общее'],['idtab'=>'tabIndex_text','active'=>false,'icon'=>'fab fa-wpforms','title'=>'Текст'],['idtab'=>'tabIndex_img','active'=>false,'icon'=>'fas fa-file-image','title'=>'Изображения'],['idtab'=>'tabIndex_seo','active'=>false,'icon'=>'fas fa-chalkboard','title'=>'SEO'],['idtab'=>'tabIndex_system','active'=>false,'icon'=>'fas fa-cogs','title'=>'Настройки']]" :arrBtns="$pageBtnAction??[]">
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_global" :active="true">
                    <x-keen.forms.input-component layout="default.inline" classLayout="mb-0" attribute="id" type="hidden" value="{{ $arrData->settings?->id??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Суфикс цены" attribute="suffixPrice" :required="false" type="text" value="{{ old('suffixPrice')??$arrData->settings?->suffixPrice??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_text" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.inline" label="Предварительный текст" attribute="prevText" :required="false" type="ckeditor" value="{{ old('prevText')??$arrData->settings?->prevText??'' }}"/>
                    <x-keen.forms.input-component layout="default.inline" label="Полный текст" attribute="fullText" :required="false" type="ckeditor" value="{{ old('fullText')??$arrData->settings?->fullText??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_img" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Предварительное изображение" attribute="images[prev]" :required="false" type="img-filemanager" value="{{ old('images.prev')??$arrData->settings?->images?->prev??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Детальное изображение" attribute="images[full]" :required="false" type="img-filemanager" value="{{ old('images.full')??$arrData->settings?->images?->full??'' }}"/>

                    <div class="separator separator-dashed my-8"></div>
                    <div id="repeater-gallery-container">
                        <div class="row">
                            <label class="col-form-label col-md-3 col-sm-2 text-lg-right text-left">Картинки</label>
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
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_seo" :active="false" :isFullWidth="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Title магазина" attribute="title" :required="false" type="text" value="{{ old('title')??$arrData->settings?->title??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Description магазина" attribute="meta[description]" :required="false" type="text" value="{{ old('meta.description')??$arrData->settings?->meta->description??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Keywords магазина" attribute="meta[keywords]" :required="false" type="text" value="{{ old('meta.keywords')??$arrData->settings?->meta->keywords??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_system" :active="false">
                    <x-keen.forms.input-component layout="default.horizontal" label="Покупка без авторизации" class="switch-success" disabled="disabled" attribute="noAuthOfBuy" type="switch" :value="[(old('noAuthOfBuy')??$arrData->settings?->noAuthOfBuy??1)]" :listsel="[1 => '']" />
                    <x-keen.forms.input-component layout="default.horizontal" label="Не учитывать наличие" class="switch-success" disabled="disabled" attribute="countNullProductOfBuy" type="switch" :value="[(old('countNullProductOfBuy')??$arrData->settings?->countNullProductOfBuy??1)]" :listsel="[1 => '']" />
                    <x-keen.forms.input-component layout="default.horizontal" label="Показывать суфикс цены" class="switch-success" attribute="showSuffixPrice" type="switch" :value="[(old('showSuffixPrice')??$arrData->settings?->showSuffixPrice??0)]" :listsel="[1 => '']" />
                    <x-keen.forms.input-component layout="default.horizontal" label="Показывать предварительный текст в продукте" class="switch-success" attribute="showPrevText" type="switch" :value="[(old('showPrevText')??$arrData->settings?->showPrevText??0)]" :listsel="[1 => '']" />
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
    @php $oldGallery = old('pictures')??(array_map(function($it){ return ['image' => $it]; }, ($arrData->settings?->pictures??[])))??[]; @endphp
    @if(!empty($oldGallery))
        window.galleryRepeater.setList(<?=json_encode($oldGallery)?>);
        reGallery();
    @endif
});
</script>
@endPush

