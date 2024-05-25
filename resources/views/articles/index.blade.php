@extends('layouts.layout')

@section('title', 'Article Page')

@section('content')
    <div>
        <h1 style="font-weight: bolder;"> My Basket</h1>
        <div id="myBasket" class="flex dark:text-gray-800">

        </div>
    </div>
    <script src="{{ asset('js/addBasket.js') }}"></script>

    <br>

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
    <table>
        <thead>
        <tr>
            <th >Article</th>
            <th >Description</th>
            <th >Price</th>
            <th >Images</th>
            <th >created at</th>
            <th >Add to Basket</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($articles as $article)
            <tr >
                <th>{{ $article->ab_name }}</th>
                <td>{{ $article->ab_description }}</td>
                <td>{{ $article->ab_price / 100 }} €</td>
                <td style="text-align: center;"> <img style="width: 30%;height:auto;" src="{{ asset($article->getImagePath($article->id)) }}" alt="{{ $article->ab_name }}"></td>
                <td>{{ $article->ab_createdate }}</td>
                <td style="text-align:center; background-color: black;" onclick=" updateCart({{ $article->id}})"><button style=text-align:center;">+</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@endsection


