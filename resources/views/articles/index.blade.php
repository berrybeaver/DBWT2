<form METHOD="get" action="{{ url('/articles') }}">
    <label for="search">Search: </label>
    <input type="text" id="search" name="search" value="{{ request('search') }}">
    <input type="submit" value="Search">

</form>

<table>
    <th >Article</th>
    <th >Description</th>
    <th >Price</th>
    <th >Images</th>
    <th >created at</th>
    @foreach ($articles as $article)
        <tr >
            <th>{{ $article->ab_name }}</th>
            <td>{{ $article->ab_description }}</td>
            <td>{{ $article->ab_price / 100 }} €</td>
            <td style="text-align: center;"> <img style="width: 30%;height:auto;" src="{{ asset($article->getImagePath($article->id)) }}" alt="{{ $article->ab_name }}"></td>
            <td>{{ $article->ab_createdate }}</td>
        </tr>
    @endforeach
</table>
