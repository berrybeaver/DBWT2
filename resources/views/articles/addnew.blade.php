@extends('layouts.layout')

@section('title', 'Add NewArticle Page')

@section('header')
    <div id="header">
        <siteheader></siteheader>
        <navbar></navbar>
    </div>
@endsection

@section('content')
    <div id="app">
        <!-- Content specific to the article page -->
        <newarticle></newarticle>
    </div>

@endsection

@section('footer')
    <div id="footer">
        <sitefooter @toggle-impressum="toggleImpressum"></sitefooter>
    </div>
@endsection



