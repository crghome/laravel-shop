@section('title', $title)
@section('subtitle', ($subtitle??''))
@extends('admin.layouts.master')
@section('content')
    @include('admin.fragments.subheader.subheader-general', ['arrBtnsGlobalPage' => ($arrBtnsGlobalPage??[])])
    <x-keen.page-layout >
        <x-alert-flush-component  />
        <x-keen.datatable.ajax-data-component :configDataAjax="$configDataAjax" :setBtnTable="true" :arrBtns="$pageBtnAction??[]" />
    </x-keen.page-layout >
@endsection
