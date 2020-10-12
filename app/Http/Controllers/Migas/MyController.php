<?php

namespace App\Http\Controllers\Migas;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Category;


class MyController extends Controller
{
    public function category_without_products(){
        $title = 'Products';
        $products = Products::all();
        $category_wo_thump= Category::where('thumbnail_image',null)->get();

        return view('dev.pages.page',compact('title','products','category_wo_thump'));
    }
}
