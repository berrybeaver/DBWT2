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
    <div id="app">
        <articlesearch></articlesearch>
    </div>
    <div>
        <h1 style="font-weight: bolder;">Search</h1>
        <form METHOD="get" action="{{ url('/api/articles') }}">
            <label for="search">Search: </label>
            <input type="text" id="search" name="search" value="{{ request('search') }}">
            <input type="submit" value="Search">
        </form>
        <a href="/newarticle">
            <button>Add new article</button>
        </a>
    </div>

    <br>

    <div>
        <h1 style="font-weight: bolder;">Article List</h1>

    </div>
@endsection


