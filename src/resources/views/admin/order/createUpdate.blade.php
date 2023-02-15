@section('title', $title)
@section('subtitle', ($subtitle??''))
@extends('admin.layouts.master')
@section('content')
    @include('admin.fragments.subheader.subheader-general', ['arrBtnsGlobalPage' => ($arrBtnsGlobalPage??[])])
    <x-keen.page-layout >
        <x-alert-flush-component />
        <x-form-component name="admin-form" method="{{ $arrData->method }}" action="{{ $arrData->route }}" enctype="multipart/form-data">
            {{-- arrBtns="[['idtab'=>'tabIndex_global','active'=>true,'icon'=>'fas fa-bars','title'=>'Общее'],['idtab'=>'tabIndex_text','active'=>false,'icon'=>'fab fa-wpforms','title'=>'Текст'],['idtab'=>'tabIndex_img','active'=>false,'icon'=>'fas fa-file-image','title'=>'Изображения'],['idtab'=>'tabIndex_public','active'=>false,'icon'=>'far fa-calendar-check','title'=>'Публикация'],['idtab'=>'tabIndex_seo','active'=>false,'icon'=>'fas fa-chalkboard','title'=>'SEO'],['idtab'=>'tabIndex_system','active'=>false,'icon'=>'fas fa-cogs','title'=>'Настройки']] --}}
            <x-keen.page-card-tabs-layout :arrBtnsCardToolbar="[['idtab'=>'tabIndex_global','active'=>true,'icon'=>'fas fa-bars','title'=>'Общее'],['idtab'=>'tabIndex_user','active'=>false,'icon'=>'far fa-user','title'=>'Покупатель'],['idtab'=>'tabIndex_products','active'=>false,'icon'=>'fab fa-product-hunt','title'=>'Товары']]" :arrBtns="$pageBtnAction??[]">
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_global" :active="true">
                    <x-keen.forms.input-component layout="default.horizontal" label="Номер заказа" attribute="number" :required="false" type="text" value="{{ old('number')??$arrData->order?->number??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_user" :active="false">
                    <x-keen.forms.input-component layout="default.horizontal" label="Имя" attribute="name" :required="true" type="text" value="{{ old('name')??$arrData->order?->name??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Телефон" attribute="phone" :required="true" type="text" value="{{ old('phone')??$arrData->order?->phone??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Email" attribute="email" :required="false" type="text" value="{{ old('email')??$arrData->order?->email??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Компания" attribute="company" :required="false" type="text" value="{{ old('company')??$arrData->order?->company??'' }}"/>
                    <x-keen.forms.input-component layout="default.horizontal" label="Адрес" attribute="address" :required="false" type="textarea" value="{{ old('address')??$arrData->order?->address??'' }}"/>
                </x-keen.page-card-tabs-content-layout>
                <x-keen.page-card-tabs-content-layout tabId="tabIndex_products" :active="false" :isFullWidth="true">
                    @php 
                        $setProdCat = !empty($arrData->product) ? $arrData->product?->categories?->pluck('id')?->toArray() : []; 
                    @endphp
                    <x-keen.forms.input-component layout="default.horizontal" label="Продукт" attribute="product_id" :required="false" :multiple="true" type="select2" :value="old('product_id')??$setProdCat" :listsel="$arrData->products"/>

                    <div id="repeater-product-container">
                        <div class="row">
                            <label class="col-form-label col-md-3 col-sm-2 text-lg-right text-left">Позиция</label>
                            <div class="col-md-9 col-sm-10 my-2" data-repeater-list="products">
                                
                                <div data-repeater-item class="form-group row mb-0 itemRepeator_product">
                                    <div class="col-sm-9">
                                        <x-keen.forms.input-component layout="default.index" attribute="id" :required="false" :multiple="false" type="select" :value="old('product.id')??0" :listsel="$arrData->products"/>
                                        <x-keen.forms.input-component layout="default.index" attribute="count" :required="false" type="number" :value="old('product.count')??1"/>
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
            </x-keen.page-card-layout >
        </x-form-component>
    </x-keen.page-layout >
@endsection

@push('script')
<script defer>
jQuery(document).ready(function() {
    // GALLERY
    function reGallery(){
        $.each($('#repeater-product-container .itemRepeator_product'), function(ind, val){
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
    window.galleryRepeater = $('#repeater-product-container').repeater({
        initEmpty: false,
        defaultValues: {},
        show: function () {
            $(this).slideDown();
            // reGallery();
        },
        ready: function (setIndexes) {
            // reGallery();
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },
        // isFirstItemUndeletable: true
    });
    @php $oldProduct = old('products')??(array_map(function($it){ return ['product' => $it]; }, ($arrData->order?->products??[])))??[]; @endphp
    @if(!empty($oldProduct))
        window.productRepeater.setList(<?=json_encode($oldProduct)?>);
        // reGallery();
    @endif
});
</script>
@endPush

