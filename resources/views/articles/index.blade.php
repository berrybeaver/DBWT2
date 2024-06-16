@extends('layouts.layout')

@section('title', 'Article Page')

@section('content')
    @vite('resources/js/addBasket.js')
    @vite('resources/js/articlesearch.vue')
    <div>
        <h1 style="font-weight: bolder;"> My Basket</h1>
        <div id="myBasket" class="flex dark:text-gray-800">

        </div>
    </div>

    <br>
    <a href="/newarticle">
        <button>Add new article</button>
    </a>
    <div id="app">
        <articlesearch></articlesearch>
    </div>
@endsection


