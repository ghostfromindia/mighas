<?php

namespace App\Http\Controllers\Client;

use App\Models\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SearchController extends Controller
{
     public function view($keyword){
        $keyword = preg_replace("/[^A-Za-z0-9]/", '', $keyword);
         $search = collect(DB::table('search as s')
            ->join('product_variants as p', 'p.id', '=', 's.variant_id')
            ->join('products as pro', 'pro.id', '=', 'p.products_id')
            ->leftjoin('media_library as m', 'p.image_id', '=', 'm.id')
            ->join('categories as c', 'c.id', '=', 'pro.category_id')
            ->join('product_inventory_by_vendor as pr', 'pr.variant_id', '=', 'p.id')
            ->where('s.type','=','variant')
            ->where('p.deleted_at',null)
            ->where('pro.deleted_at',null)
            ->where('pro.is_active',1)
            ->where('s.keyword','LIKE','%'.$keyword.'%')
            ->distinct()->orderby('s.priority','DESC')->select('s.id as variant_id','s.name as name','s.slug as slug','pr.sale_price as price','m.file_path as image','s.type as type')->get(['variant_id','name','slug','price','image','type']));
            $search = $search->unique('name');
            $search = $search->values()->all();
        return view('client.pages.search',compact('search'));
    }
    
  
}
