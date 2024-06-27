@extends('layouts.layout')

@section('title', 'Welcome to Abalo')


@section('header')
    <div id="header">
        <siteheader></siteheader>
        <navbar></navbar>
    </div>
@endsection

@section('content')<!-- body-->
    <div id="body">
        <sitebody></sitebody>
    </div>
    <div id="app">
        <vue-scroll-up
            tag="div"
            custom-class="vue-scroll-up"
            :scroll-duration="1000"
            :scroll-y="250"
            :always-show="true">
            ^
        </vue-scroll-up>
    </div>
@endsection

@section('footer')
    <div id="footer">
        <sitefooter @toggle-impressum="toggleImpressum"></sitefooter>
    </div>
@endsection

