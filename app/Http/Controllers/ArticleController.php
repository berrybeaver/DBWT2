<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articles;
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

    public function newarticle(){
        return view('articles.addnew');
    }
}
