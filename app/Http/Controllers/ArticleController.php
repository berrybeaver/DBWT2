<?php

namespace App\Http\Controllers;

use App\Events\Angebotsevent;
use App\Events\VerkaufsMeldung;
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
        if (empty($validatedData['name']) || empty($validatedData['price']) || empty($validatedData['description'])) {
            return redirect()->back()->withErrors(['message' => 'Bitte füllen Sie alle erforderlichen Felder aus.'])->withInput();
        }

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

    public function create_api(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:1', // Ensure price is greater than 0
            'description' => 'required',
        ]);

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

        if (array_key_exists('image', $validatedData)) {
            $file = $request['image'];
            $filePath = public_path('/img');
            $fileName = $article->id . '.' . $file->getClientOriginalExtension();
            $file->move($filePath, $fileName);
        }

        // Return the ID of the created article in the JSON response
        return response()->json(['id' => $article->id]);
    }

    public function search_api(Request $request)
    {
        $page = $request->get('page',1);
        $perpage = $request->get('perpage', 5);
        $search = $request->input('search');

        $results = Articles::where('ab_name','ilike','%'.$search.'%')->paginate($perpage);
        foreach ($results as $result) {
            $result->image_url = asset($this->getImagePath($result->id));
        }

        return response()->json($results, 200);
    }
    public function getImagePath($id)
    {
        $jpgImagePath = "/img/{$id}.jpg";
        $pngImagePath = "/img/{$id}.png";

        if (file_exists(public_path($jpgImagePath))) {
            return $jpgImagePath;
        } elseif (file_exists(public_path($pngImagePath))) {
            return $pngImagePath;
        }

        return "/img/default.png";
    }

    public function soldArticle_api($id){
        $article = Articles::find($id);
        $CreatorId = $article->ab_creator_id;

        \Illuminate\Support\Facades\Log::info("ArticleController:markAsSold: Article found: " . $article->ab_name);

        if ($article && $article->ab_name) {
            event(new VerkaufsMeldung("Großartig! Ihr Artikel {$article->ab_name} wurde erfolgreich verkauft!", $CreatorId, $article->ab_name));
            return response()->json(['message' => 'Article marked as sold and event dispatched.']);
        }
        return response()->json(['message' => 'Article not found.'], 404);
    }

    public function offer_api(Request $request, $articleId)
    {
        $article = Articles::find($articleId);
        \Illuminate\Support\Facades\Log::info("ArticleController:setOffer: Article found: " . $article->ab_name  );
        event(new Angebotsevent("{$article->ab_name} ist noch verfuegbar! jetzt kaufen!!!", $article));

        return response()->json(['message' => 'Article offer processed.']);
    }


}
