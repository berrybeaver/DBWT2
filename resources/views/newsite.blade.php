@extends('layouts.layout')

@section('title', 'Welcome to Abalo')
@vite('resources/js/echo.js')

    @section('content')
        <div id="app">
            <siteheader></siteheader>
            <navbar></navbar>
            <br>
            <sitebody :show-impressum="showImpressum"></sitebody>
            <vue-scroll-up
                tag="div"
                custom-class="vue-scroll-up"
                :scroll-duration="1000"
                :scroll-y="250"
                :always-show="true">
                ^
            </vue-scroll-up>
            <sitefooter @toggle-impressum="toggleImpressum"></sitefooter>
        </div>
    @endsection

