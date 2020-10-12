<?php

namespace App\Http\Controllers\Migas;

use App\Http\Controllers\BaseController;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Products;
use App\Models\Products\Variants;
use App\Models\Slider;
use App\Models\Specification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use DB;

class HomeController extends BaseController
{

    public function home(){
        $slider = Slider::where('code','home-page-desktop-slider')->first();
        return view('migas.pages.home',compact('slider'));
    }

    public function category($category){
        $category = Category::where('slug',$category)->first();
        if(!$category){
            abort(404);
        }
        $category_by_type =  Category::where('parent_category_id',$category->id)->get();
        if(count($category_by_type)==0){return redirect($category->slug.'/products');}
        return view('hykon.pages.category',compact('category','category_by_type'));
    }

    public function category_by_type($category,$type){
        $category = Category::where('slug',$category)->first();
        if(Input::get('category')){
            $cat_array = Input::get('category');
        }else{
            $cat_array = [];
        }
        if(Input::get('from')){
            $from = Input::get('from');
        }else{
            $from = null;
        }
        if(Input::get('to')){
            $to = Input::get('to');
        }else{
            $to = null;
        }

        if(!$category){
            abort(404);
        }

        if($type != 'products'){
            $category_by_type =  Category::where('parent_category_id',$category->id)->where('slug',$type)->get();
            $list_category = Category::where('parent_category_id',$category->id)->get();
        }else{
            $category_by_type =  Category::where('parent_category_id',$category->id)->get();
            $list_category = Category::where('id',$category->id)->get();
        }





         $products = Products::where(function($query) use ($category_by_type,$category,$cat_array) {
                $query->where('category_id', $category->id);
            if(count($cat_array)>0) {
                foreach ($cat_array as $obj){
                    $query->orWhere('category_id', $obj);
                }
            }else{
                foreach ($category_by_type as $obj){
                    $query->orWhere('category_id', $obj->id);
                }
            }


        });

        $prices = clone  $products;

        $min = $max = 0;
        foreach ($prices->get() as $obj){ $obj = $obj->default;
            if(!empty($obj->inventory)){
                if($obj->inventory->sale_price < $min || $min == 0){
                    $min = $obj->inventory->sale_price;
                }
                if($obj->inventory->sale_price > $max || $max == 0) {
                    $max = $obj->inventory->sale_price;
                }
            }

        }
        if($max < $to){
            $to = $max;
        }
        if($min > $from){
            $from = $min;
        }

        if($from == null || $to == null){
            $from = $min;
            $to = $max;
             $products = $products->get();
        }else {
            $products = $products->whereHas('variants.inventory',function ($query) use ($from,$to){
                return $query->where('sale_price', '>=',$from)->where('sale_price', '<=',$to);
            })->get();

        }





        return view('hykon.pages.category_store',compact('from','to','type','min','max','products','category','list_category','category_by_type'));
    }

    public function singe_product($product){
        $product = Products::where('slug',$product)->first();
        if(Input::get('variant')){
            $variant_slug = Input::get('variant');
            $variant = Variants::where('products_id',$product->id)->where('slug',$variant_slug)->first();
        }else{
            $variant = Variants::where('products_id',$product->id)->where('is_default',1)->first();
            if(!$variant){
                $variant = Variants::where('products_id',$product->id)->first();
            }
        }
        if(!$variant){
            abort(404);
        }
        $related  = Products::where('category_id',$product->category_id)->get();

        $pro = DB::table('product_variants as pro')
            ->leftjoin('products as p', 'p.id', '=', 'pro.products_id')
            ->leftjoin('product_attributes as pat', 'p.id', '=', 'pat.products_id')
            ->leftjoin('product_cateory_attributes as cat', 'cat.id', '=', 'pat.attribute_id')
            ->leftjoin('product_cateory_attribute_groups as cgat', 'cgat.id', '=', 'cat.group_id')
            ->leftjoin('product_cateory_attribute_values as avi', 'avi.id', '=', 'pat.attribute_value_id')
            ->where('pro.id', $variant->id);

        $attributes = $pro->select('pat.id as idd','cat.attribute_name','cat.attribute_type','avi.value','cgat.group_name as group','pat.attribute_value')->get()->groupby('group');

        $specification  = Specification::where('variant_id',$variant->id)->get()->groupby('group');

        return view('hykon.pages.single_product',compact('variant','product','related','attributes','specification'));
    }

    public function products(){
                $products = Products::paginate(18);
                $list_category = Category::where('parent_category_id',0)->where('status',1)->get();
                return view('hykon.pages.products',compact('products','list_category'));

    }
}
