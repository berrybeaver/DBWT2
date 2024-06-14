<?php

namespace App\Http\Controllers;

use App\Models\shoppingcart;
use App\Models\shoppingcartItem;
use App\Models\Articles;
use Illuminate\Http\Request;

class ShoppingcartController extends Controller
{
    function init_cart(Request $request)
    {
        // Get the shopping cart from the database
        $shoppingCart = Shoppingcart::where('ab_creator_id', 1)->first();

        // If the shopping cart does not exist, create a new one
        if (!$shoppingCart) {
            $shoppingCart = Shoppingcart::create([
                'ab_creator_id' => 1, //$request->session()->get('id'),
                'ab_createdate' => date('Y-m-d H:i:s')
            ]);
        }

        // Get the items in the shopping cart
        $items = ShoppingcartItem::where('ab_shoppingcart_id', 1)->get();
        // $articles = Articles::where('', '1'])->get();
        $articles = [];

        foreach ($items as $item) {
            $article = Articles::where('id', $item->ab_article_id)->first();
            if ($article) {
                $articles[] = $article;
            }
        }

        return response()->json($articles);
    }




    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'article_id' => 'required|numeric|min:0',
        ]);

        // Get the shopping cart from the session or create a new one if it doesn't exist
        $shoppingCart = shoppingcart::find(1);
        if (!$shoppingCart) {
            $shoppingCart = new shoppingcart();
            $shoppingCart->ab_creator_id = 1; // Set this to the actual user ID
            $shoppingCart->ab_createdate = date('Y-m-d H:i:s');
            $shoppingCart->save();
        }

        if( ShoppingcartItem::where('ab_shoppingcart_id', $shoppingCart->id)->where('ab_article_id', $validatedData['article_id'])->exists()){
            return response()->json($shoppingCart);
        }
        // Add the item to the shopping cart
        $shoppingCartItem = new ShoppingcartItem();
        $shoppingCartItem->ab_article_id = $validatedData['article_id'];
        $shoppingCartItem->ab_createdate = date('Y-m-d H:i:s');
        $shoppingCartItem->ab_shoppingcart_id = $shoppingCart->id;
        $shoppingCartItem->save();

        return response()->json($shoppingCart);
    }

    public function removeItem(Request $request)
    {
        $validatedData = $request->validate([
            'article_id' => 'required|numeric|min:0',
            'shoppingcartid' => 'required|numeric|min:0'
        ]);
        // Get the shopping cart from the session
        $shoppingCart = shoppingcart::find($validatedData['shoppingcartid']);

        // Remove the item from the shopping cart
        ShoppingcartItem::where('ab_shoppingcart_id', $validatedData['shoppingcartid'])
            ->where('ab_article_id', $validatedData['article_id'])
            ->delete();

        return response()->json($shoppingCart);
    }


}
