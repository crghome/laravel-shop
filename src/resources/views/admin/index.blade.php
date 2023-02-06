@section('title', $title)
@section('subtitle', ($subtitle??''))
@extends('admin.layouts.master')
@section('content')
    @include('admin.fragments.subheader.subheader-general', ['arrBtnsGlobalPage' => ($arrBtnsGlobalPage??[])])
    <x-keen.page-layout >
        <x-alert-flush-component  />
        <x-keen.page-card-layout title="{{ $title }}" :arrBtns="$pageBtnAction??[]" >
            <h4 class="mb-6">Blank empty</h4>
        </x-keen.page-card-layout>
    </x-keen.page-layout >
@endsection
