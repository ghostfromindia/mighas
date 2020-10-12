<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Products\Variants;
use App\Models\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use View;

class SearchController extends BaseController
{

    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Search();

        $this->route .= '.search';
        $this->views .= '.search';
        $this->url = "admin/search";
        $this->breadcrumbs = 'search';
        $this->resourceConstruct();

    }

    protected function getCollection()
    {
        return $this->model->select('id', 'name' ,'keyword');
    }



    public function home(Request $request, $parent=null){
        if ($request->ajax()) {
            $collection = $this->getCollection();
            $parent_id = null;
            if($parent)
                $parent_id = $parent;
            $route = $this->route;
            return $this->setDTData($collection)->make(true);
        } else {
            $parent_data = null;
            if($parent)
                $parent_data = $this->model->find($parent);
            return View::make($this->views . '.index', ['parent'=>$parent, 'parent_data'=>$parent_data]);
        }
    }

    public function edit(){
        return view('admin.search.form');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_delete']);
    }

    public function sync(){
        $keywords = Search::all();
        if(count($keywords) == 0){
              $variants = DB::table('product_variants as v')
                ->join('products as p','v.products_id','=','p.id')
                ->where('p.is_active','=','1')
                ->where('p.product_code','!=',null)
                ->where('p.deleted_at','=',null)->select('v.name as name','v.id as id')->get();

            foreach ($variants as $obj){

                         $name = preg_replace("/[^A-Za-z0-9]/", '', $obj->name);
                        $this->create_variant_entry($obj->id,strtolower($name),1,'variant');
                 
            }

            $variants = Category::where('status',1)->where('category_name','!=',null)->get();
            foreach ($variants as $obj){
                $name = preg_replace('/\PL/u', '', $obj->category_name);
                $this->create_category_entry($obj->id,strtolower($name),1,'category');
            }

        }
        return redirect('admin/search/create');
    }

    public function products_save(Request $request){
        if(count($request->products) == 0){
            abort(500);
        }
        $a = [];
        $a = explode(',',$request->keywords);
        foreach ($request->products as $products){

                foreach ($a as $b){
                    $this->create_variant_entry($products,strtolower($b),$request->priority,'variant');
                }

        }
        return redirect('admin/search/create');
    }


    public function categories_save(Request $request){
        if(count($request->category) == 0){
            abort(500);
        }
        $a = [];
        $a = explode(',',$request->keywords);
        foreach ($request->category as $category){
             $variants = DB::table('product_variants as v')
                            ->join('products as p','v.products_id','=','p.id')
                            ->where('p.is_active',1)
                            ->where('p.category_id',$category)->select('v.id as id')->get();

            foreach ($variants as $obj){
                foreach ($a as $b){
                    $this->create_variant_entry($obj->id,strtolower($b),$request->priority,'variant');
                }
            }
        }
        return redirect('admin/search/create');
    }

    public function create_variant_entry($vid,$keyword,$priority,$type){
            $search = New Search();
            $keyword = str_replace(' ', '', $keyword);
            $search->variant_id	= $vid;
            $variant = DB::table('product_variants as v')
                ->join('products as p','v.products_id','=','p.id')
                ->leftjoin('media_library as media', 'v.image_id', '=', 'media.id')
                ->join('product_inventory_by_vendor as price', 'price.variant_id', '=', 'v.id')
                ->where('p.is_active','=','1')
                ->where('p.deleted_at','=',null)
//                ->where('p.product_code','!=',null)
                ->where('v.id',$vid)->select('v.name as name','v.slug as slug','v.id as id','media.file_path as file_path','price.sale_price as sale_price')->first();


            if(!$variant){
                return;
            }else{
                $v = Search::where('variant_id',$vid)->where('keyword',$keyword)->first();
                if($v){
                    return;
                }
            }
        $search->name = $variant->name;

                $search->image = $variant->file_path;



                $search->price = $variant->sale_price;




            $search->keyword = $keyword;
            $search->slug =  $variant->slug;
            $search->priority = $priority;
            $search->type = $type;

            if($search->price !== null){
                $search->save();
            }

    }

    public function create_category_entry($vid,$keyword,$priority,$type){
        $search = New Search();

        $search->variant_id	= $vid;
        $variant = Category::where('deleted_at',null)->where('id',$vid)->first();

        if(!$variant){
            return;
        }

        $search->name = $variant->category_name;
        if($variant->primary){
            $search->image = $variant->primary->file_path;
        }

        $search->price = 0;
        $search->keyword = $keyword;
        $search->slug =  $variant->slug;
        $search->priority = $priority;
        $search->type = $type;
        $search->save();
    }


}
