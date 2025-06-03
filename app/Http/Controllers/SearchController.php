<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $products = Product::where('name', 'like', '%' . $query . '%')->get();

            $view = view('partials.search-result', compact('products'))->render();
            return response()->json(['html' => $view]);
        }

        return abort(404);

    }
}
