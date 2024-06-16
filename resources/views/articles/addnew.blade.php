@extends('layouts.layout')

@section('title', 'Add NewArticle Page')

@section('content')
    @vite('resources/js/newArticle.vue')
    <div id="app">
        <!-- Content specific to the article page -->
        <newarticle></newarticle>
    </div>

@endsection



