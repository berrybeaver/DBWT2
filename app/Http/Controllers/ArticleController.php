<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articles;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller{
    public function index(Request $request){
        $search = $request->input('search');

        if($search) //wenn ein Suchbegriff vorhanden, such nach Artikel
        {
            $articles = Articles::where('ab_name','ilike','%'.$search.'%')->get();
        }else{  //ansonsten alle anzeigen
            $articles = Articles::all();
        }
        return view('articles.index', ['articles' => $articles]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg', // 'image' ist der Name des Formularfeldes, das den Dateiupload enthält
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        //phpinfo($request->input('_token'));

        // Persistieren Sie die Daten in der Datenbank
        $article = new Articles();
        $idmax = DB::table('ab_article')->max('id');
        $article->id = $idmax + 1;
        $article->ab_name = $validatedData['name'];
        $article->ab_price = $validatedData['price'];
        $article->ab_description = $validatedData['description'];
        $article->ab_creator_id = 1;
        $article->ab_createdate = date('Y-m-d H:i:s');
        $article->save();

        //trigger the created event
        Articles::created($validatedData);

        if (array_key_exists('image', $validatedData)) {
            $file = $validatedData['image'];
            $filePath = public_path('/img');
            $fileName = $article->getKey() . '.' . $file->getClientOriginalExtension();
            $file->move($filePath, $fileName);
        }

        return redirect('/articles')->with('success', 'Artikel erfolgreich gespeichert!');
    }

}
