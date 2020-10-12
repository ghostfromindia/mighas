<?php

namespace App\Http\Controllers\Migas;

use App\Models\Category;
use App\Models\Products\Variants;
use App\Models\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    public function make_search(){
        $keyword = preg_replace("/[^A-Za-z0-9]/", '', Input::get('search'));
        return redirect('search/'.$keyword);
    }
    public function search($slug){
        $keyword = preg_replace("/[^A-Za-z0-9]/", '', $slug);
        if(!$keyword){abort(404);}
        $products = Search::where('keyword','LIKE','%'.$keyword.'%');


        $products = $products->groupby('variant_id')->limit(10)->get();
        return view('hykon.pages.search',compact('products','keyword'));
    }
}
