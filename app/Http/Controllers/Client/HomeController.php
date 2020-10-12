<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\SendOtp;
use App\Mail\Message;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Category\CategoryAttributes;
use App\Models\Category\CategoryAttributeGroups;
use App\Models\Coupon;
use App\Models\ExtendedWarranty;
use App\Models\FrontendPage;
use App\Models\Offers;
use App\Models\Offers\OfferView;
use App\Models\Orders;
use App\Models\Orders\OrderDetails;
use App\Models\Orders\OrderTracking;
use App\Models\Pincode;
use App\Models\Products;
use App\Models\Products\Variants;
use App\Models\Products\Review;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config, Route, View;

use App\Models\Products\Variants\Images;

use App\Models\Address;
use App\Models\Products\Views;
use App\Models\SearchHistory;


class HomeController extends Controller
{
    public function __construct() {
        $name = Route::currentRouteName();
        $meta_details = FrontendPage::where('slug',$name)->first();
        View::share(['meta_details' => $meta_details]);
    }
    
    public function home(){
        $products = Category::all();
           $meta = FrontendPage::where('slug','home')->first();
        return view('client.pages.home',compact('meta'));
    }

    public function cart_total(){
        return $cart = Cart::where('user_id',$this->user_id())->count();
    }

    public function DBops(){
//        $offers = Offers::all();
//        foreach ($offers as $obj){
//            echo $obj->slug = $this->slug($obj->offer_name); echo '<br>';
//            $obj->save();
//        }
        return 'success';

//        $variants = Variants::all();
//        foreach ($variants as $obj){
//            $keyword = $obj->name;
//
//            if($obj->product)
//                 $keyword .= $obj->product->product_name;
//            if(!empty($obj->product->brand))
//                 $keyword .= $obj->product->brand->brand_name;
//            if(!empty($obj->product->category))
//                $keyword .= $obj->product->category->category_name;
//
//            $obj->search = $this->clean($keyword);
////            $obj->save();
//        }
//        return 'done';
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9]/', '', $string); // Removes special chars.
        return strtolower($string);
    }

    public function add_coupon_to_cart(Request $request){
         $coupon = Coupon::where('coupon_code',$request->coupon)->first();
         $cart = Cart::where('user_id',$this->user_id())->get();

        foreach ($cart as $obj){
            $obj->cart_offer_id = $coupon->id;
            $obj->save();
        }

        $data =  Cart::total($this->user_id());
        $data['status'] = true;
        return json_encode($data);
    }

    public function remove_coupon(Request $request){
        $cart = Cart::where('user_id',$this->user_id())->get();

        foreach ($cart as $obj){
            $obj->cart_offer_id = null;
            $obj->save();
            $data['status'] = true;
        }
        return json_encode($data);
    }

    public function recommended_products($id){
        $variant =  Variants::find($id);


        $data = DB::table('product_variants as variant')
            ->join('products as parent', 'parent.id', '=', 'variant.products_id')
            ->leftjoin('media_library as media', 'variant.image_id', '=', 'media.id')
            ->join('product_inventory_by_vendor as price', 'price.variant_id', '=', 'variant.id');


        if($variant->inventory){
            $price = $variant->inventory->sale_price;
            $data->where('price.sale_price','<',$price+5000);
        }
        $category = $variant->product->category_id;
        if($category){
            $data->where('parent.category_id',$category);
        }

        return $data->select('variant.name','variant.slug','media.file_path','price.sale_price')->get();



    }

    public function related_products($id){
        $variant =  Variants::find($id);

         $data = DB::table('product_variants as variant')
            ->join('products as parent', 'parent.id', '=', 'variant.products_id')
            ->leftjoin('media_library as media', 'variant.image_id', '=', 'media.id')
            ->join('product_inventory_by_vendor as price', 'price.variant_id', '=', 'variant.id')->where('parent.is_active',1)
             ->where('parent.deleted_at',null)
             ->where('variant.deleted_at',null);;


        if($variant->inventory){
            $price = $variant->inventory->sale_price;
            $data->where('price.sale_price','<',$price+5000);
        }
        $category = $variant->product->category_id;
        if($category){
            $data->where('parent.category_id',$category);
        }

        return $data->select('variant.name','variant.slug','media.file_path','price.sale_price')->get();



    }

    public function productReviews($id){
        return $data = DB::table('product_reviews as pr')
            ->join('users as u','u.id','=','pr.user_id')
            ->where('pr.products_id',$id)
            ->select('pr.title','pr.created_at as time','pr.review','pr.rating',DB::raw('concat(u.first_name," ",u.last_name) as name'))->paginate(10);
    }

    public function offer_view(){
        $o1 = DB::table('offers as o')
            ->where('o.type',"Free")
            ->join('offer_combo_products as ocp','offers_id','=','o.id')
            ->select('ocp.products_id as product','o.id as offer','o.type as type');

        $group_offers = DB::table('offers as o')
            ->where('o.type',"Group")
            ->join('offer_groups as og','og.offers_id','=','o.id')
            ->join('groups as g','og.groups_id','=','g.id')
            ->join('group_products as gp','gp.groups_id','=','g.id')
            ->select('gp.products_id as product','o.id as offer',DB::raw('"Group" as type'));

        $categories_offers = DB::table('offers as o')
            ->join('offer_categories as oc','oc.offers_id','=','o.id')
            ->join('categories as c','oc.categories_id','=','c.id')
            ->join('products as p','p.category_id','=','c.id')
            ->select('p.id as product','o.id as offer',DB::raw('"Category" as type'));

        $offers = DB::table('offers as o')
            ->where('o.type',"Combo")
            ->join('offer_combo_products as ocp','offers_id','=','o.id')
            ->select('ocp.products_id as product','o.id as offer','o.type as type')
            ->union($o1)
            ->union($group_offers)
            ->union($categories_offers); echo $offers->toSql();


       echo vsprintf(str_replace(['?'], ['\'%s\''], $offers->toSql()), $offers->getBindings());

        dd($offers->toSql(), $offers->getBindings());

    }

    public function shop(){
        return view('client.pages.shop');
    }

    public function slug($slug){
        $text = preg_replace('~[^\pL\d]+~u', '-', $slug);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = preg_replace('~-+~', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    public function category_slug_generator(){
        $ca = Category::all();
        foreach ($ca as $c){
            $c->slug = $this->slug($c->category_name); $c->save();
        }

        $ca = Products::all();
        foreach ($ca as $c){
            $c->slug = $this->slug($c->product_name); $c->save();
        }

        $ca = Variants::all();
        foreach ($ca as $c){
            $c->slug = $this->slug($c->name); $c->save();
        }

    }

    public function variant_offers($id){
        $product = DB::table('offers_data as od')
            ->join('offers as o', 'o.id', '=', 'od.offer')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product')
            ->where('pv.id', $id)
            ->whereDate('o.validity_end_date','>',Carbon::now())
            ->select('o.id as id','o.offer_name as title','o.validity_start_date as from','o.validity_end_date as to')->get();
        return json_encode($product);
    }

    public function productvariant($id){

         $input = Input::get();

         $all_levels = DB::table('product_variants as p')
            ->leftjoin('product_cateory_attribute_values as l1', 'l1.id', '=', 'p.level1_attribute_value_id')
            ->leftjoin('product_cateory_attribute_values as l2', 'l2.id', '=', 'p.level2_attribute_value_id')
            ->leftjoin('product_cateory_attribute_values as l3', 'l3.id', '=', 'p.level3_attribute_value_id')
            ->select('l1.value as level1','l2.value as level2','l3.value as level3','p.id as id')->where('products_id',$id)->get();




         $product = DB::table('product_variants as p')
            ->leftjoin('media_library as m', 'p.image_id', '=', 'm.id')
            ->leftjoin('products as pro', 'pro.id', '=', 'p.products_id')
            ->leftjoin('brands as b', 'b.id', '=', 'pro.brand_id')
            ->leftjoin('categories as c', 'c.id', '=', 'pro.category_id')
            ->join('product_inventory_by_vendor as pr', 'pr.variant_id', '=', 'p.id')
            ->leftjoin('product_cateory_attribute_values as l1', 'l1.id', '=', 'p.level1_attribute_value_id')
            ->leftjoin('product_cateory_attribute_values as l2', 'l2.id', '=', 'p.level2_attribute_value_id')
            ->leftjoin('product_cateory_attribute_values as l3', 'l3.id', '=', 'p.level3_attribute_value_id');

        if (!empty($input['lvl1'])||!empty($input['lvl2'])||!empty($input['lvl3'])){


            switch (Input::get('level')){
                case 1:
                    $keys= $this->level_array($all_levels,$input,3,1,1);
                    break;

                case 2:
                    $keys= $this->level_array($all_levels,$input,1,3,1);
                    break;

                case 3:
                    $keys= $this->level_array($all_levels,$input,1,1,3);
                    break;
            }

            $product =   $product->where('p.id', $keys[0]);

        }else{
            $product =   $product->where('p.id', $id);
        }

        $product = $product->select('p.slug as slug','p.name as product_name','p.short_description as short_description', 'p.id as id', 'pro.id as pid', 'pro.summary as summary', 'pr.retail_price as mrp', 'pr.sale_price as sale_price', 'm.file_path as image_url', 'c.category_name as category', 'c.slug as category_slug','b.brand_name as brand','pr.barcode as sku',
            'l1.value as level1','l2.value as level2','l3.value as level3','pr.available_quantity as stock','c.policies')->first();

        return json_encode($product);
    }

    function level_array($all_levels,$input,$l1,$l2,$l3){


        if(array_key_exists('lvl1',$input)){$level1= $input['lvl1'];}else{$level1=null;}
        if(array_key_exists('lvl2',$input)){$level2= $input['lvl2'];}else{$level2=null;}
        if(array_key_exists('lvl3',$input)){$level3= $input['lvl3'];}else{$level3=null;}


        $pid = null;$flag=[];
        foreach ($all_levels as $a){
            $pid = $a->id;$flag[$pid]=0;
            if($a->level3 == $level3){
                $flag[$pid]=$l3;
            }
            if($a->level1 == $level1) {
                $flag[$pid]=$flag[$pid]+$l1;
            }
            if($a->level2 == $level2) {
                $flag[$pid]=$flag[$pid]+$l2;
            }
        }
        return $keys= array_keys($flag,max($flag));
    }

    public function productlevels($id){
        $data = [];

        function query_level($level,$id){
             $q = DB::table('product_variants as p')
                 ->join('products as pro', 'pro.id', '=', 'p.products_id')
                ->leftjoin('product_cateory_attribute_values as level', 'level.id', '=', 'p.'.$level.'_attribute_value_id')
                ->leftjoin('product_cateory_attributes as attributes', 'level.attribute_id', '=', 'attributes.id')
                 ->groupBy('p.'.$level.'_attribute_value_id')
                ->where($level.'_attribute_value_id','>',0)
                ->where('p.products_id','=',$id)
                ->select('level.value','p.id','attributes.attribute_name as level')->get();
             if(count($q)>0){
                 return $q;
             }else{
                 return null;
             }
        }

        $data['level1'] = query_level('level1',$id);
        $data['level2'] = query_level('level2',$id);
        $data['level3'] = query_level('level3',$id);

        return json_encode($data);
    }

      public function specification($id){
        $product = DB::table('product_variants as pro')
            ->leftjoin('products as p', 'p.id', '=', 'pro.products_id')
            ->leftjoin('product_attributes as pat', 'p.id', '=', 'pat.products_id')
            ->leftjoin('product_cateory_attributes as cat', 'cat.id', '=', 'pat.attribute_id')
            ->leftjoin('product_cateory_attribute_groups as cgat', 'cgat.id', '=', 'cat.group_id')
            ->leftjoin('product_cateory_attribute_values as avi', 'avi.id', '=', 'pat.attribute_value_id')
            ->where('pro.id', $id);

        $attributes = $product->select('pat.id as idd','cat.attribute_name','cat.attribute_type','avi.value','cgat.group_name','pat.attribute_value')->get();
        $data=[];
        foreach ($attributes as $a){
            if(!isset($data[$a->group_name])){$data[$a->group_name]=[];}

                if($a->group_name == 'Selectable'){
                    array_push($data[$a->group_name],[$a->attribute_name,$a->value]);
                }else{
                    array_push($data[$a->group_name],[$a->attribute_name,$a->attribute_value]);
                }
  
        }

        return json_encode($data);
    }


    public function parseslug($slug){
         $product = DB::table('product_variants as p')
            ->leftjoin('media_library as m', 'p.image_id', '=', 'm.id')
            ->leftjoin('products as pro', 'pro.id', '=', 'p.products_id')
            ->leftjoin('product_cateory_attribute_values as level1', 'level1.id', '=', 'p.level1_attribute_value_id')
            ->leftjoin('product_cateory_attribute_values as level2', 'level2.id', '=', 'p.level2_attribute_value_id')
            ->leftjoin('product_cateory_attribute_values as level3', 'level3.id', '=', 'p.level3_attribute_value_id')
            ->leftjoin('product_reviews as review', 'review.products_id', '=', 'pro.id')
            ->join('categories as c', 'c.id', '=', 'pro.category_id')
            ->join('product_inventory_by_vendor as pr', 'pr.variant_id', '=', 'p.id')
            ->where(function($query) use($slug){
                $query->where('p.slug', $slug)->orWhere('p.code', $slug);
            })->where('pro.is_active',1)
             ->where('pro.deleted_at',null)
             ->where('p.deleted_at',null)
            //->where('p.slug', $slug)
            ->select('pro.id as pid',
                'pro.top_description as top_description',
                'pro.bottom_description as bottom_description',
                'pro.browser_title',
                'pro.meta_keywords',
                'pro.meta_description',
                'p.slug as slug',
                'p.name as product_name',
                'p.short_description as short_description',
                'p.id as id',
                'pr.retail_price as mrp',
                'pr.sale_price as sale_price',
                'm.file_path as url',
                'c.category_name as category',
                'c.slug as category_slug',
                'level1.value as level1',
                'level2.value as level2',
                'level3.value as level3',
                DB::raw('AVG(review.rating) as rating'),
                DB::raw('count(review.rating) as rating_count'))->first();
                
 

        if(!$product->pid){abort(404);}

        $reviews = Review::where('products_id',$product->pid)->first();


        $viewed_products = [];
        if(session()->has('session_viewed_products'))
            $viewed_products = session()->get('session_viewed_products');

        if(!in_array($product->id, $viewed_products))
        {
            $user_id = (Auth::user())?Auth::user()->id:null;
            $product_views = Views::where('products_id', $product->id)->where('user_id', $user_id)->first();
            if($product_views)
                $product_views->count = $product_views->count+1;
            else
            {
                $product_views = new Views;
                $product_views->products_id = $product->id;
                $product_views->user_id = $user_id;
                $product_views->count = 1;
            }
            $product_views->save();

            $viewed_products[] = $product->id;
            session()->put('session_viewed_products',$viewed_products);
        }
        if(isset($_GET['keyword']) && trim($_GET['keyword']) != '')
            $this->save_search_terms($_GET['keyword']);
        
        return view('client.pages.single',['product'=>$product,'reviews'=>$reviews]);
    }
    
    
    public function save_search_terms($term)
    {
        $searched_terms = [];
        if(session()->has('session_searched_terms'))
            $searched_terms = session()->get('session_searched_terms');

        if(!in_array($term, $searched_terms))
        {
            $user_id = (Auth::user())?Auth::user()->id:null;
            $searches = SearchHistory::where('search_term', $term)->where('user_id', $user_id)->first();
            if($searches)
                $searches->count = $searches->count+1;
            else
            {
                $searches = new SearchHistory;
                $searches->search_term = $term;
                $searches->user_id = $user_id;
                $searches->count = 1;
            }
            $searches->save();

            $searched_terms[] = $term;
            session()->put('session_searched_terms',$searched_terms);
        }
        return true;
    }

    public function productsapi($type,$category=0){

        $data = [];
        $q = DB::table('product_variants as p')
            ->leftjoin('media_library as m', 'p.image_id', '=', 'm.id')
            ->leftjoin('products as pro', 'pro.id', '=', 'p.products_id')
            ->join('categories as c', 'c.id', '=', 'pro.category_id')
            ->join('product_inventory_by_vendor as pr', 'pr.variant_id', '=', 'p.id')->where('p.image_id','!=',null);

        if($type !==0) {
            $q = $q->where('pro.'.$type,1);
        }
        $q1 = clone $q;

        if($category !=0){
            $q = $q->where('pro.category_id',$category);
        }
        $data['products'] = $q->select('p.slug as slug','p.name as product_name', 'p.id as id', 'pr.retail_price as mrp', 'pr.sale_price as sale_price', 'm.file_name as url', 'c.category_name as category','pr.available_quantity as stock')->limit(12)->orderby('sale_price','ASC')->get();
        $data['categories'] = $q1->select('c.id as id','c.category_name as name')->groupBy('pro.category_id')->limit(4)->get();
        return json_encode($data);

    }

    public function stores($slug){

         $products = DB::table('product_variants as p')
             ->leftjoin('media_library as m', 'p.image_id', '=', 'm.id')
             ->leftjoin('products as pro', 'pro.id', '=', 'p.products_id')
             ->join('categories as c', 'c.id', '=', 'pro.category_id')
             ->join('product_inventory_by_vendor as pr', 'pr.variant_id', '=', 'p.id')
             ->where('pro.is_active',1)
             ->where('pro.deleted_at',null)
             ->where('p.deleted_at',null);

         if($slug != 'search'){
             $search = null;
             $category = Category::where('slug',$slug)->first();
             $products->where('c.slug', $slug);
         }else{
             $category = new Category;
             $category->id = '0';
             $category->slug = 'search';
             $search = Input::get('keyword');
             $products->where('p.search', 'LIKE',$search);
         }
            
         if(isset($_GET['keyword']) && trim($_GET['keyword']) != '')
            $this->save_search_terms($_GET['keyword']);
            
         $products->select('pro.id as pid','p.slug as slug','p.name as product_name','p.short_description as short_description', 'p.id as id', 'pr.retail_price as mrp', 'pr.sale_price as sale_price', 'm.file_path as url', 'c.category_name as category',DB::raw('MAX(pr.sale_price) as max'))->paginate(5);
         $brands = Input::get('brand');
         $attributes = Input::get('attributes');
         $from = Input::get('from');
         $to = Input::get('to');
         $page = Input::get('page');
         return view('client.pages.stores',['obj'=>$products,'keyword'=>$search,'category'=>$category,'from'=>$from,'to'=>$to,'brands'=>$brands,'page'=>$page,'attributes'=>$attributes]);
    }

    public function review(Request $request){
        $od = OrderDetails::find(decrypt($request->id));

        $review = Review::where('products_id',$od->parent->id)->where('user_id',Auth::user()->id)->first();
        if(!$review){
            $review = new Review();
        }
        $review->products_id = $od->parent->id;
        $review->title =  $request->title;
        $review->review = $request->description;
        $review->rating = $request->rating;
        $review->is_verified = 1;
        $review->user_id = Auth::user()->id;
        $review->save();

        return $review->toJson();
    }

    public function fetchreview(Request $request){
        $data = [];
        $od = OrderDetails::find(decrypt($request->id));
        $review = Review::select()->where('products_id',$od->parent->id)->where('user_id',Auth::user()->id)->first();
        if($review){
            $data['status'] = true;
            $data['title'] = $review->title;
            $data['description'] = $review->review;
            $data['rating'] = $review->rating;
        }else{
            $data['status'] = false;
        }
        return json_encode($data);
    }

    public function categories($id){
        $keyword = Input::get('keyword');
        $q = DB::table('categories as c');
        if($id == 0){

        }else{
            $q->where(function ($que) use ($id) {
                $que->where('c.parent_category_id','=',$id)->orWhere('c.id','=',$id);
            });
        }



        $q->join('products as pro', 'pro.category_id', '=', 'c.id');
        $q->leftJoin('product_variants as p', 'p.products_id', '=', 'pro.id')->where('pro.is_active',1)
             ->where('pro.deleted_at',null)
             ->where('p.deleted_at',null);;
        if($keyword){
            $q->where('p.search','LIKE','%'.str_replace(' ', '%', $keyword).'%');
        }

        $data =[];

        $q2 = DB::table('product_variants as p')
                ->join('products as pro', 'pro.id', '=', 'p.products_id')
                ->leftjoin('brands as b', 'pro.brand_id', '=', 'b.id')
                ->leftjoin('categories as c', 'c.id', '=', 'pro.category_id')
                ->leftjoin('product_inventory_by_vendor as pr', 'pr.variant_id', '=', 'p.id')->where('pro.is_active',1)
             ->where('pro.deleted_at',null)
             ->where('p.deleted_at',null);;


        if($id == 0){

        }else{
            $q2->where('c.id', $id);
        }
        $q3 =  clone $q2;
         $data['categories'] = $q->select('c.id','c.category_name as name')->groupBy('c.category_name')->get();
         $data['minmax'] = $q2->select(DB::raw('MIN(pr.sale_price) as min'),DB::raw('MAX(pr.sale_price) as max'))->first();
         $brands = explode(",",Input::get('brands'));
         $data['brands'] = $q3->select('b.id as id','b.brand_name as name',DB::raw('false as status'))->groupBy('id')->get()->map(function($b)use ($brands) {
             if(in_array($b->id,$brands))
                 $b->status = true;
             else
                 $b->status = false;
             return $b;
         });
         $data['brands_selected']=Input::get('brands');
         $data['attributes_selected']=Input::get('attributes');

        return json_encode($data);
    }

    public function getBrands(){
        $q = DB::table('categories as c');
    }

    public function getGroupAttribute($string){
        $attrs = explode(',',$string);
        $data = [];
        foreach ($attrs as $obj){
            $value = Category\CategoryAttributeValues::find($obj);
            $data[$value->attribute->id][] = $obj;


        }


        return $data;
    }

    public function products_list(){
        $from = Input::get('from');
        $to = Input::get('to');
        $category = Input::get('category');
        $brands = Input::get('brand');
        $keyword = Input::get('keyword');
        $sort_alphabets = Input::get('sort_alphabets');
        $sort_price = Input::get('sort_price');
        $limit = Input::get('limit');
        $attributes = Input::get('attributes');




        $products = DB::table('product_variants as p')
            ->leftjoin('media_library as m', 'p.image_id', '=', 'm.id')
            ->leftjoin('products as pro', 'pro.id', '=', 'p.products_id')
            ->join('categories as c', 'c.id', '=', 'pro.category_id')
            ->leftjoin('product_attributes as pa', 'pa.products_id', '=', 'pro.id')
            ->join('product_inventory_by_vendor as pr', 'pr.variant_id', '=', 'p.id')->where('p.deleted_at',null)->where('pro.deleted_at',null)->where('pro.is_active',1);

        if($from){
            $products->where('pr.sale_price','>=',$from);
        }
        if($to){
            $products->where('pr.sale_price','<=',$to);
        }

        if($attributes && $attributes!= "undefined"){
            $attribute_in_array = $this->getGroupAttribute($attributes);

            foreach ($attribute_in_array as $key=>$obj) {
                $products->join('product_attributes AS product_attributes'.$key, function($join) use($key, $obj){
                    $join->on('pro.id', '=', 'product_attributes'.$key.'.products_id');
                    $join->where('product_attributes'.$key.'.attribute_id','=', $key);
                    $join->whereIn('product_attributes'.$key.'.attribute_value_id', $obj);
                });
            }
        }

        if($brands && $brands!= "undefined"){
            $brans = [];
            $brans = explode(',',$brands);

            $products->where(function ($que) use ($brans) { $i=0;
                foreach ($brans as $b){
                    if($i==0){
                        $que->where('pro.brand_id','=',$b);
                    }else{
                        $que->orWhere('pro.brand_id','=',$b);
                    } $i++;

                }
            });

        }



        if($category && $category!=0){
             $categories = Category::find($category)->childs;

             if(count($categories)){
                 $products->where(function ($query) use($categories,$category) {
                     $query->where('pro.category_id', '=',$category);
                     foreach ($categories as $obj){
                         $query->orWhere('pro.category_id', '=', $obj->id);
                     }
                 });
             }else{
                 $products->where('pro.category_id','=',$category);
             }
        }

        if($keyword){
             $products->where('p.search','LIKE','%'.str_replace(' ', '%', $keyword).'%');

        }
        if($sort_alphabets){
            $products->orderBy('p.name',$sort_alphabets);
        }
        if($sort_price){
            $products->orderBy('pr.sale_price',$sort_price);
        }

        // if($brands && $brands!= "undefined"){
        //     $brans = [];
        //     $brans = explode(',',$brands);

        //         $products->where(function ($que) use ($brans) { $i=0;
        //             foreach ($brans as $b){
        //                 if($i==0){
        //                     $que->where('pro.brand_id','=',$b);
        //                 }else{
        //                     $que->orWhere('pro.brand_id','=',$b);
        //                 } $i++;

        //             }
        //         });

        // }





        $products->select('pro.id as pid','p.slug as slug','p.name as product_name', 'p.id as id', 'pr.retail_price as mrp', 'pr.sale_price as sale_price', 'm.file_path as url', 'c.category_name as category','pr.available_quantity as stock,pcav.id as pcavid')->groupBy('p.id');




        return json_encode($products->paginate($limit));
    }

    public function cart(){
        $cart = Cart::where('user_id',$this->user_id())->orderBy('product_offer_id')->orderBy('offer_parent')->get();

        // STEP 1, Checking the offer is Valid.
        foreach ($cart as $obj){
            if($obj->product_offer_id){
               $offer = Offers::isValid($obj->product_offer_id);
               if(!$offer){
                   Cart::where('product_offer_id',$obj->product_offer_id)->delete();
                   Cart::where('product_offer_id',$obj->offer_parent)->delete();
               }
            }
        }

        $total = Cart::total($this->user_id());

        $coupon = Cart::where('user_id',$this->user_id())->first();
        if(isset($coupon->coupon)){
            $coupon = $coupon->coupon->coupon_code;
        }else{
            $coupon = null;
        }


        return view('client.pages.cart',['obj' => $cart,'total_from_model' => $total,'coupon'=>$coupon]);
    }

    public function add_extended_warranty(Request $request){

         $ew = ExtendedWarranty::find($request->id);
        $row = Cart::find($request->cart);
        $data = [];

        $cart = new Cart;

        $duplicate_check = Cart::where('warranty_parent',$row->product_id)->where('product_id',$ew->products_id)->first();
        if($duplicate_check){$duplicate_check->delete();}
        $this->add_Cart(null,$ew->products_id,$ew->warranty_price,$ew->warranty_price,$ew->warranty_price,1,null,$row->product_id);
        $data['status'] = true;
        return json_encode($data);
        
        
    }

    public function add_to_cart(Request $request){
        //to give json response
        $data = [];
        $data['message'] = '';

        $oid = $request->offer_id;
        $vid = $request->variant_id;

        //checking offer is valid
        if($oid){
            if(Offers::isValid($oid)){
                $data['message'] = 'Offer is invalid<br>';
            }
        }

        //checking variant is valid
        if($vid){
            $variant = Variants::find($vid);
            if(!$variant){
                $data['message'] .= 'The product is unavailable right now<br>';
            }
        }

        //checking variant is available in stock
        if($vid){
            $variant = Variants::inStock($vid,'check');
            if(!$variant){
                $data['message'] .= 'The product is out of stock right now<br>';
            }
        }


        if(!$oid){
            $p = DB::table('product_variants as p')
                ->join('product_inventory_by_vendor as piv', 'p.id', '=', 'piv.variant_id')
                ->select('p.id as products_id','piv.sale_price as sale_price','piv.retail_price as retail_price')->where( 'p.id', '=', $vid)->first();
            $this->add_Cart(null, $vid, $p->sale_price,$p->sale_price,$p->retail_price,1,null);
            return 'true';
        }


        $offer = Offers::find($oid);


        $minimum_purchase_amount =  (!empty($offer->min_purchase_amount)) ? $offer->min_purchase_amount : 0;
        $max_discount_amount =  (!empty($offer->max_discount_amount)) ? $offer->max_discount_amount : 10000000;
        $discount_price =  (!empty($offer->amount)) ? $offer->amount : false;
        $discount_percentage =  (!empty($offer->percentage)) ? $offer->percentage : false;


        $variant = Variants::find($vid);
        $variant_price = $variant->inventory->sale_price;
        switch($offer->type){

            case 'Free':
                $this->add_to_cart_free($oid,$vid);
                break;

            case 'Price':
                if($offer->discount_type == "Discount Percentage"){
                    $discount = ( $variant_price * $discount_percentage)/100;
                    if($max_discount_amount < $discount){$discount = $max_discount_amount;}
                    $final_price = $variant_price-$discount;
                    $this->add_Cart($oid, $vid, $final_price,$variant_price,$variant->inventory->retail_price,1,null);
                }
                if($offer->discount_type == "Discount Price"){
                    $discount = $discount_price;
                    if($max_discount_amount < $discount){$discount = $max_discount_amount;}
                    $final_price = $variant_price-$discount;
                    $this->add_Cart($oid, $vid, $final_price,$variant_price,$variant->inventory->retail_price,1,null);
                }
                break;

            case 'Combo':
                $this->add_to_cart_combo($oid,$vid);
                break;

        }
        return $request;
    }

    function add_to_cart_free($oid,$vid){

        $buy = Offers::getComboProducts($oid);
        $get = Offers::getFreeProducts($oid);

        if($buy && $get){
            foreach ($buy as $obj){
                return $this->add_Cart($oid,$obj->products_id,$obj->sale_price,$obj->sale_price,$obj->retail_price,1,null);
            }

            foreach ($get as $obj){
                $this->add_Cart($oid,$obj->products_id,0,$obj->sale_price,$obj->retail_price,1,$vid);
            }
        }

    }

    function add_to_cart_combo($oid,$vid){
          $buy = Offers::getComboProducts($oid);
          $get = Offers::getFreeProducts($oid);



        if($buy) {

            foreach ($buy as $obj) {
                echo $this->add_Cart($oid, $obj->products_id, $obj->sale_price, $obj->sale_price, $obj->retail_price, 1, $vid);

            }
        }
        if($get){

            foreach ($get as $obj) {
                switch ($obj->type) {
                    case 'Fixed Price':
                        $this->add_Cart($oid, $obj->products_id, $obj->fixed_price,$obj->sale_price,$obj->retail_price,1,$vid);
                        break;
                    case 'Free':
                        $this->add_Cart($oid, $obj->products_id, 0,$obj->sale_price,$obj->retail_price,1,$vid);
                        break;
                    case 'Discount Percentage':
                        $max_discount =  (!empty($obj->max_discount_amount)) ? $obj->max_discount_amount : 10000000;
                        $discount = ( $obj->sale_price * $obj->discount_percentage)/100;
                        if($max_discount < $discount){$discount = $max_discount;}
                        $final_price = $obj->sale_price-$discount;
                        $this->add_Cart($oid, $obj->products_id, $final_price,$obj->sale_price,$obj->retail_price,1,$vid);
                        break;
                    case 'Discount Fixed':
                        $max_discount =  (!empty($obj->max_discount_amount)) ? $obj->max_discount_amount : 10000000;
                        $discount = $obj->discount_amount;
                        if($max_discount < $discount){$discount = $max_discount;}
                        $final_price = $obj->sale_price-$discount;
                        $this->add_Cart($oid, $obj->products_id, $final_price,$obj->sale_price,$obj->retail_price,1,$vid);
                        break;
                    case 'Fixed Price':
                        $this->add_Cart($oid, $obj->products_id, $obj->fixed_price,$obj->sale_price,$obj->retail_price,1,$vid);
                        break;
                }
            }
        }
    }


    public function add_Cart($product_offer_id = null,$variant_id = null,$final_price,$sale_price,$retail_price,$quantity,$offer_parent = null,$warranty_parent=null){

        $cart= Cart::where('user_id',$this->user_id())->get();
        $cart = $cart->where('product_offer_id',$product_offer_id)->where('product_id',$variant_id)->first();

        if($cart){
            //Checking the offer is valid or not
            if($product_offer_id == null){
                $cart->quantity = $cart->quantity + 1;
                $cart->save();
                return true;
            }elseif(!Offers::isValid($product_offer_id) ){
                Cart::where('user_id',$this->user_id())->where('product_offer_id',$product_offer_id)->delete();
                return 'Offer is not valid anymore!';
            }
            //Checking the product and offer already there, if there quantity of all products related to that offer increase.
            if($offer_parent == $variant_id) {
                $offer_products = Cart::where('user_id', $this->user_id())->where('product_offer_id', $product_offer_id)->get();
                foreach ($offer_products as $offer_product) {
                    $offer_product->quantity = $offer_product->quantity + $quantity;
                    $offer_product->save();
                    echo 'Product and its offer products quantity updated';
                }
            }

        }else{
            $cart = new Cart;
            $cart->user_id = $this->user_id();

            if($product_offer_id){
                $cart->product_offer_id = $product_offer_id;
                $cart->offer_parent = $offer_parent;
                if($offer_parent == $variant_id){
                    $cart->offer_parent = null;
                }
            }
            if($warranty_parent){
                $cart->warranty_parent = $warranty_parent;
            }
            $cart->product_id = $variant_id;
            $cart->quantity = $quantity;
            $cart->price = $final_price;
            $cart->retail_price = $retail_price;
            $cart->sale_price = $sale_price;
            $cart->save();
        }

    }



    public function getUser(){
        $data = [];
        if (Auth::user()){
            $data['status'] = true;
        }else{
            $data['status'] = false;
        }
        return json_encode($data);
    }

    public function startPayment(Request $request){
        session()->put('address',$request->address);
        return 'true';
    }

    public function get_cart()
    {
        return $cart = Cart::where('user_id',$this->user_id())->get();
    }

    public function complete(Request $request){

        if(session()->has('address')){ }else{
            return redirect('checkout/address');
        }

        $cart = $this->get_cart();

        $total_sale_price = 0;
        foreach ($cart as $c){
             $total_sale_price = $total_sale_price + ($c->price * $c->quantity);
        }
        
        if(count($cart) == 0){
            session()->flash('status', 'Session timed out! please try again');
            return redirect('cart');
        }

        $total = Cart::total(Auth::user()->id);

        if($total_sale_price != $total['total']){
            echo 'Session mismatch please try again';exit;
        }else{
            if($total['coupon_discount']>0){
                $total_sale_price = $total_sale_price - $total['coupon_discount'];
            }
        }

        $order_id = 'OD'.date('dmyhis').rand(11111,99999);

        if($request->checkout_payment_method == 'cash')
        {
            $payment_method = 'Cash On Delivery';
            $this->create_order($payment_method,$total['coupon_discount'],$c->cart_offer_id,$order_id, $cart,null);
        }
        else
        {
            $obj = new \AWLMEAPI();
            $reqMsgDTO = new \ReqMsgDTO();
            $reqMsgDTO->setOrderId($order_id);
            $reqMsgDTO->setMid(Config::get('common.payments.merchant_id'));
            $reqMsgDTO->setTrnAmt($total_sale_price*100); //Paisa Format
            $reqMsgDTO->setTrnCurrency("INR");
            $reqMsgDTO->setMeTransReqType("S");
            $reqMsgDTO->setEnckey(Config::get('common.payments.encryption_key'));
            $reqMsgDTO->setResponseUrl(url('payments/response'));
            $reqMsgDTO->setTrnRemarks('Order placed for pittappillil');

            $merchantRequest = "";
            $reqMsgDTO = $obj->generateTrnReqMsg($reqMsgDTO);
            if ($reqMsgDTO->getStatusDesc() == "Success"){
                $merchantRequest = $reqMsgDTO->getReqMsg();
                $merchantId = $reqMsgDTO->getMid();
                return view('client/payments/index', ['merchantRequest'=>$merchantRequest, 'merchantId'=>$merchantId]);
            } 
            else{
                return view('client/payments/errors');
            }
        }

        return redirect('account/orders');
    }

    public function payment_response()
    {
        //create an Object of the above included class
        $obj = new \AWLMEAPI();
        
        /* This is the response Object */
        $resMsgDTO = new \ResMsgDTO();

        /* This is the request Object */
        $reqMsgDTO = new \ReqMsgDTO();
        
        //This is the Merchant Key that is used for decryption also
        $enc_key = Config::get('common.payments.encryption_key');
        
        /* Get the Response from the WorldLine */
        $responseMerchant = $_REQUEST['merchantResponse'];
        
        $response = $obj->parseTrnResMsg( $responseMerchant , $enc_key );
        $status = $response->getStatusCode();
        if($status == 'S')
        {
            $total = Cart::total(Auth::user()->id);
            $cart = $this->get_cart();
            $c = Cart::where('user_id',Auth::user()->id)->first();
            $order_id = $response->getOrderId();
            $cart = $this->get_cart();
            if($this->create_order('Online Payment',$total['coupon_discount'],$c->cart_offer_id,$order_id, $cart, $response))
                return redirect('account/orders');
        }
        return view('client/payments/errors');
    }

    public function create_order($payment_method,$discount=0,$coupon_id=null, $order_id, $cart, $response = null)
    {
        $mrp = 0; $sale = 0;
        $total_sale_price = 0;
        foreach ($cart as $c){
             $total_sale_price = $total_sale_price + ($c->price * $c->quantity);
             $mrp = $mrp + ($c->product->inventory->retail_price * $c->quantity);
        }

        $data = Cart::total($this->user_id());


        $order = new Orders;
        $order->users_id = Auth::user()->id;
        $order->order_reference_number = $order_id;
        $order->total_mrp = $mrp;
        $order->total_discount = ($mrp - $total_sale_price)+$data['coupon_discount']+
        $order->total_sale_price = $total_sale_price;
        $order->total_final_price = $data['total'];
        $order->coupon_id = $coupon_id;
        $order->coupon_discount = $discount;
        $order->payment_method = $payment_method;
        if($payment_method == 'Cash On Delivery')
        {
            $order->transaction_id = $order_id;
            $order->payment_status = 0;
        }
        else{
            $order->transaction_id = $response->getPgMeTrnRefNo();
            $order->response_data = json_encode((array)$response);
            $order->payment_status = 1;
        }
        
        if($address = Address::find(session('address')))
        {
            $order->delivery_instructions = $address->delivery_instructions;
        }
        $order->delivery_address_id =  session('address');
        $order->save();

        foreach ($cart as $c){

            $mrp =$c->retail_price * $c->quantity;
            $price = $c->price * $c->quantity;
            $sale_price = $c->sale_price * $c->quantity;

            $order_list = new OrderDetails;
            $order_list->orders_id = $order->id;
            $order_list->products_id = $c->product_id;
            $order_list->mrp = $mrp;
            $order_list->quantity = $c->quantity;
            $order_list->cart_offer_id = $c->cart_offer_id;
            $order_list->product_offer_id = $c->product_offer_id;
            $order_list->offer_parent = $c->offer_parent;
            $order_list->sale_price = $sale_price;
            $order_list->price = $price;
            $order_list->warranty_parent = $c->warranty_parent;
            $order_list->discount = $mrp - $price;
            $order_list->status = 1;
            $order_list->save();
            
                //Remove stocks
            $inventory = Variants\Inventory::where('variant_id',$c->product_id)->first();
            $inventory->available_quantity = $inventory->available_quantity-$c->quantity;
            $inventory->save();

            $tracking = new OrderTracking;
            $tracking->order_details_id = $order_list->id;
            $tracking->order_status_labels_master_id = 1;
            $tracking->save();



        }

        foreach ($cart as $c){
            if($c->warranty_parent){
                 $order_list = OrderDetails::where('orders_id',$order->id)->where('products_id',$c->warranty_parent)->first();
                 if($order_list){
                     $order_list->waranty_id = $c->products_id;
                     $order_list->save();
                 }

            }
        }

        Cart::destroy($c->id);
        
        BaseController::send_sms_notification('9895715674','New order - '.$order_id.' has been placed! ( Payment method : '.$payment_method.')'); // Sunil
        BaseController::send_sms_notification('9747229926','New order - '.$order_id.' has been placed! ( Payment method : '.$payment_method.')'); // Peter
        BaseController::send_sms_notification('9074094959','New order - '.$order_id.' has been placed! ( Payment method : '.$payment_method.')'); // Shibu
        BaseController::send_sms_notification($address->mobile_number,'Congratulations Your order - '.$order_id.' has been placed! Thank you for shopping with pittappillil agencies');
        BaseController::send_notification('Congratulations Your order - '.$order_id.' has been placed! Thank you for shopping with pittappillil agencies','Your order has been placed');

        return true;

    }

    public function payment(){
        if(!session()->has('address')){
            return redirect('checkout/address');
        }

        $cart = DB::table('cart as cr')
            ->join('product_variants as p', 'p.id', '=', 'cr.product_id')
            ->leftjoin('media_library as m', 'p.image_id', '=', 'm.id')
            ->leftjoin('offers as o', 'o.id', '=', 'cr.product_offer_id')
            ->join('products as pro', 'pro.id', '=', 'p.products_id')
            ->join('categories as c', 'c.id', '=', 'pro.category_id')
            ->join('product_inventory_by_vendor as pr', 'pr.variant_id', '=', 'p.id')
            ->where('user_id','=',$this->user_id())

            ->select('pro.id as pid','p.slug as slug','p.name as product_name', 'p.id as id', 'pr.retail_price as mrp', 'pr.sale_price as sale_price', 'm.file_path as url', 'c.category_name as category','cr.offer_parent as offer_parent','cr.quantity as quantity','cr.price as price','cr.product_offer_id as product_offer_id','o.offer_name as offer','p.slug as slug','cr.id as cart_id')->orderBy('cr.id')->get();

        $cart = Cart::where('user_id',$this->user_id())->get();
        $total = Cart::total($this->user_id());
        return view('client.checkout.summary',['cart'=>$cart,'total'=>$total]);
    }

    public function address(){

        $user = Auth::user();
        $user_id = $user->id;
        $addresses = DB::table('address')->select('address.id', 'full_name', 'address1', 'address2', 'landmark', 'city', 'states.name AS state_name', 'pincode', DB::raw("CONCAT(mobile_code, ' ', mobile_number) AS phone"), 'type', 'is_default')->join('states', 'address.state', '=', 'states.id')->where('user_id', $user_id)->orderBy('address.is_default', 'DESC')->orderBy('address.created_at', 'DESC')->get();
        return view('client.checkout.address', ['addresses'=>$addresses]);

    }

    public function user_id(){
        if(Auth::user()){
            $user = Auth::user()->id;
        }else{
            $user = session('guest');
        }
        return $user;
    }


    public function update_cart(Request $request){

        $cart = Cart::find(decrypt($request->cart));

        if($request->type == 'remove'){
            $this->removeCart($cart->id);
        }

        if($request->type == 'update') {

            $cart->quantity = $cart->quantity + $request->quantity;
            if($cart->quantity <= 0){
                $this->removeCart($cart->id);
            }

           if($cart->product_offer_id){
                $objs = Cart::where('offer_parent',$cart->product_id)->where('product_offer_id',$cart->product_offer_id)->get();
                foreach ($objs as $obj){$obj->quantity = $obj->quantity+$request->quantity;  $obj->save();}
            }
            $cart->save();
        }
    }

    public function removeCart($id){
        $cart = Cart::find($id);
        if($cart->product_offer_id){
            $objs = Cart::where('offer_parent',$cart->product_id)->where('product_offer_id',$cart->product_offer_id)->delete();
        }
        $cart->delete();
    }

    public function discountedAmount($se,$oid,$min,$discount,$max,$type){
        $variant = Variants::find($vid);
        if($variant->inventory->sale_price > $min){
            if($type == 'percentage'){
                $discount = ( $variant->inventory->sale_price * $discount)/100;
            }

            if($max < $discount){
                $discount =  $max;
            }
        }

        $sale_price = ($variant->inventory->sale_price)-$discount;
        $this->add_Cart($oid,$vid,$sale_price);
    }

    public function checkout_step1(){

        return view('client.pages.choose_address');
    }

    public function pincode_verify(){
         $pincode = Input::get('pincode');
         session()->put('pincode',$pincode);

        $data = [];
         $pincode = Pincode::where('pin_code',$pincode)->first();
        if($pincode){
            $data['status'] = true;
            $data['city'] = $pincode->place;
        }else{
            $data['status'] = false;
        }
        return json_encode($data);
    }

    public function productvariantgallery($id){
        return  $images = DB::table('product_variant_images as img')->where('variant_id',$id)->join('media_library as ml','img.image_id','=','ml.id')->select('ml.file_path')->get();
    }

    public function sendotp(Request $request){
        $type = $request->type;
        $otp = rand(111111,999999);
        $user = User::find(Auth::user()->id);
        $email = Auth::user()->email;
        $mobile = Auth::user()->username;
        $user->otp = $otp; $user->save();
        if($type == 'email'){
            $data['status'] = true;
            if($type == 'email'){
                Mail::to($email)->send(new SendOtp($otp));
            }
        }
        if ($type == 'mobile'){
            if(!$mobile){
                $data['status'] = 101;
                session()->put('mobile',true);
            }
            if(BaseController::sms_send($mobile,'Your OTP is '.$otp)){
                $data['status'] = 'mobile';
            }

        }
        return json_encode($data);
    }

    public function otpverify(Request $request){
        $user = User::find(Auth::user()->id);
        $data['type'] = decrypt($request->type);
        if($user->otp == $request->otp){
            if($data['type'] == 'email'){
                session()->put('email',true);
            }elseif($data['type'] == 'mobile'){
                session()->put('mobile',true);
            }
            if($request->note == 'verify_email'){
                $user->email_verified_at = Carbon::now();
                $user->save();
            }
            if($request->note == 'verify_mobile'){
                $user->phone_verified_at = Carbon::now();
                $user->save();
            }
            $data['status'] = true;
        }else{
            $data['status'] = false;
        }
        return json_encode($data);
    }

    public function compare(){
        abort(404);
    }

    public function compare_by_category($slug){

        $category = Category::where('slug',$slug)->first();
        if(!$category){
            abort(404);
        }
        $products = session('cat_'.$category->id);

        //Checking products are in same category
        $i=0;
        foreach ($products as $product){ $product = Variants::find($product);
            if($i==0){$cat = $product->product->category_id;$i=1;}
            if($product->product->category_id !== $cat){
                return 'Checking products are in same category : '.false;
            }
        }

        $category_attributes_group = CategoryAttributeGroups::where('category_id',$cat)->get();
        $category_attributes_group->map(function ($category_attributes_group)use($products) {
            $i=0;
            foreach ($products as $obj){
                $category_attributes_group['p_'.$i++] = $obj;
                $category_attributes_group['count'] = count($products);
            }
            return $category_attributes_group;
        });

        return view('client.pages.compare',compact('category_attributes_group'));
    }

    public function compare_list(Request $request){
        $data = [];
        $product = Variants::find($request->variant_id)->product;
        $array = session('cat_'.$product->category_id);
        $i=0;
        if($array){
        foreach ($array as $obj){
            $variant = Variants::find($obj);
            $data[$i]['vid'] = $variant->id;
            $data[$i]['title'] = $variant->name;
            if($variant->media){
                $data[$i]['image'] = URL::asset($variant->media->file_path);
            }else{
                $data[$i]['image'] = URL::asset('404.jpg');
            }

            $data[$i++]['slug'] = $variant->slug;
        }
        }

        return json_encode($data);

    }

    public function compare_post(Request $request){
        $data = [];
        $variant= Variants::find($request->variant_id)->product;
        if($request->variant_id && $request->type == 'add'){


            if(session($variant->category_id)){
                Session::push('cat_'.$variant->category_id, $request->variant_id);
            }else{
                Session::push('cat_'.$variant->category_id, $request->variant_id);
            }
            $data['status'] = true;
            $data['message'] = 'Product added to compare';

        }

        if($request->variant_id && $request->type == 'remove'){
            $array = session('cat_'.$variant->category_id);
            if (($key = array_search($request->variant_id, $array)) !== false) {
                unset($array[$key]);
                session()->put('cat_'.$variant->category_id, $array);
                $data['message'] = 'Product removed from compare';
                $data['status'] = true;
            }else{
                $data['message'] = 'Product not added in compare';
                $data['status'] = true;
            }
        }

        if($request->variant_id && $request->type == 'remove-all'){
                session()->put('cat_'.$variant->category_id, []);
            $data['status'] = true;
        }

        if($request->variant_id && $request->type == 'check'){


            if(session('cat_'.$variant->category_id)){
                $array = session('cat_'.$variant->category_id);


                if (($key = array_search($request->variant_id, $array)) !== false) {
                        $data['status'] = true;
                }else{
                    $data['status'] = false;
                }


            }else{
                $data['status'] = false;
            }

        }

        $array = array_unique(session('cat_'.$variant->category_id),SORT_NUMERIC);
        session()->put('cat_'.$variant->category_id,$array);
        $data['total'] = count(session('cat_'.$variant->category_id));
        return json_encode($data);


    }

    public function variant_details($id){
        return $varaint = Variants::select('id','name', 'slug','image_id')->where('id',$id)
            ->with(['inventory' => function($query) {
              $query->addSelect(['retail_price', 'sale_price', 'variant_id']);
         }])->with(['media' => function($query) {
            $query->addSelect(['file_path','id']);
        }])->first()->toJson();

    }
    
    public function get_payment_staus_response()
    {
        BaseController::send_sms_notification('9496849448','cron job worked'); // Sunil
        //create an Object of the above included class
        $obj = new \VtransactSecurity();
        
        //This is the Merchant Key that is used for decryption also
        $enc_key = Config::get('common.payments.encryption_key');
        
        /* Get the Response from the WorldLine */
        $mId = Config::get('common.payments.merchant_id');
        
        $to_date = time().'000';
        $from_date = time() - (24*60*60);
        $from_date = $from_date.'000';
        
        $data = [];
        $data['mid'] = $mId;
        $data['fromDate'] = $from_date;
        $data['toDate'] = $to_date;
        $data['count'] = 500;
        $data['offset'] = 0; 
        $data['currStatusCode'] = '2220';
        
        $request = json_encode($data);
        
        $encReq = $obj->encryptValue( $request , $enc_key);
        $req_data = [];
        $req_data['encReq'] = $encReq;
        $req_data['mid'] = $mId;
        
        $request = json_encode($req_data);
        
        $url="https://ipg.in.worldline.com/api/v1/bulkStatus/mid";

        $ch = curl_init();
        if (!$ch)
        {
            die("Couldn't initialize a cURL handle");
        }

        $ret = curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Connection: Keep-Alive'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $request);
        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $curlresponse = curl_exec($ch);
        if (empty($ret))
        {
            curl_close($ch);
        }
        else
        {
            $info = curl_getinfo($ch);
            $curlresponse = curl_exec ($ch);
            curl_close($ch);
            $response = json_decode($curlresponse);
            $error = $obj->decryptValue($response->apiErrorDesc, $enc_key);
            if($error == '')
            {
                $output = $obj->decryptValue($response->encRes, $enc_key);
                $output = preg_replace('/[[:cntrl:]]/', '', $output);
                $output = str_replace("\r\n", '\r\n', $output);
                $output = str_replace("\n", '\n', $output);
                $output = str_replace("\r", '\r', $output);
                $jsonDecode = json_decode(trim($output), TRUE);
                if(isset($jsonDecode['records']))
                {
                    foreach($jsonDecode['records'] as $order)
                    {
                        $order_id = isset($order['merchantTxnDetails']['orderId'])?$order['merchantTxnDetails']['orderId']:null;
                        if($order_id)
                        {
                            $settled = (isset($order['settlementDetails']['settleStatusCode'])&& ($order['settlementDetails']['settleStatusCode'] == 'SC'))?true:false;
                            if($settled)
                            {
                                $order = Orders::where('order_reference_number', $order_id)->first();
                                if($order && $settled)
                                {
                                    $order->payment_receive_status = 1;
                                    $order->save();
                                }
                            }
                        }
                    }
                }
            }
            
        }
        exit;
    }
    
     public function testmail(){
         $message = "India recorded the largest single-day jump of 1,993 new coronavirus cases in the last 24 hours taking the total to 35,043 cases, including 1,147 deaths, the Union Health Ministry said this morning, adding that 73 deaths linked to the highly infectious illness were reported from different parts of the country since yesterday. The country's recovery rate - the share of people who have been discharged from hospital after treatment - stood at 25.36 per cent this morning; a total of 8,889 patients have recovered so far. On Thursday, the government said that a significant improvement has been recorded over the last two weeks when the recovery rate was 13 per cent. The doubling rate of COVID-19 cases has also improved to 11 days from 3.4 days before the nationwide lockdown, the Union Health Ministry said. ";
        Mail::to('b2akhilmj@gmail.com')->send(new Message($message,'This is confidential'));
        Mail::to('tonyjohn@gmail.com')->send(new Message($message,'This is confidential'));
        Mail::to('tony@spiderworks.in')->send(new Message($message,'This is confidential'));
        Mail::to('akhil@spiderworks.in')->send(new Message($message,'This is confidential'));
    }
    

}
