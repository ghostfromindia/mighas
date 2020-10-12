<?php

namespace App\Http\Controllers\Vanila;

use App\Models\Products;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Products\Variants;
use App\User;
use Auth, Redirect;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home(){
        $products = DB::table('product_variants as pv')
            ->select('pv.name AS product_name','f.file_name AS url','pv.slug','tagline','mrp','p.sale_price','pv.id')
            ->join('products as p','pv.products_id','=','p.id')
            ->leftJoin('media_library as f','pv.image_id','=','f.id')
            ->orderby('pv.id','DESC')
            ->where('is_active', 1)
            ->where('is_completed', 1)
            ->where('is_default', 1)
            ->paginate(12);
        return view('vanila.home',['products'=>$products]);
    }

    public function product($slug){
        $product = DB::table('product_variants as pv')
            ->select('pv.name AS product_name','f.file_name AS url','pv.slug','tagline','mrp','p.sale_price','pv.id','pv.short_description as summary','top_description','bottom_description', 'pv.products_id', 'pv.level1_attribute_value_id', 'pv.level2_attribute_value_id', 'pv.level3_attribute_value_id', 'pv.id')
            ->join('products as p','pv.products_id','=','p.id')
            ->leftJoin('media_library as f','pv.image_id','=','f.id')
            ->where('pv.slug','=',$slug)
            ->where('p.is_active', 1)
            ->where('p.is_completed', 1)
            ->first();
        if(!$product)
            return Redirect::back();
        $available_variants = $this->getAvailableAttributes($product->products_id, $product->level1_attribute_value_id, 1);
        $product->available_variants = $available_variants;
        $variant_levels = $this->getVariantLevels($product->products_id);
        
        return view('vanila.product',['obj'=>$product, 'level1_variants'=>$variant_levels['level1_variants'], 'level2_variants'=>$variant_levels['level2_variants'], 'level3_variants'=>$variant_levels['level3_variants']]);
    }

    public function variant(Request $r)
    {
        $data = $r->all();
        $product = $this->getProductVariant($data);
        if(!$product)
        {
            if($data['level'] == 2)
                $product = $this->getProductVariant($data);
            if($data['level'] == 3)
            {
                $product = $this->getProductVariant($data, ['1']);
                if(!$product)
                {
                    $product = $this->getProductVariant($data, ['2']);
                    if(!$product)
                        $product = $this->getProductVariant($data, ['3']);
                }
            }
            if(!$product)
                return Redirect::to('/');
        }

        $available_variants = $this->getAvailableAttributes($product->products_id, $data['attr_value_id'], $data['level']);
        $product->available_variants = $available_variants;
        $variant_levels = $this->getVariantLevels($product->products_id);
        $view =  view('vanila.products.ajax',['obj'=>$product, 'level1_variants'=>$variant_levels['level1_variants'], 'level2_variants'=>$variant_levels['level2_variants'], 'level3_variants'=>$variant_levels['level3_variants']])->render();
        return response()->json(['html'=>$view, 'slug'=>$product->slug]);
    }

    public function getProductVariant($data, $itration=['1','2'])
    {
        $query = DB::table('product_variants as pv')
            ->select('pv.name AS product_name','f.file_name AS url','pv.slug','tagline','mrp','p.sale_price','pv.id','pv.short_description as summary','top_description','bottom_description', 'pv.products_id', 'pv.level1_attribute_value_id', 'pv.level2_attribute_value_id', 'pv.level3_attribute_value_id', 'pv.id')
            ->join('products as p','pv.products_id','=','p.id')
            ->leftJoin('media_library as f','pv.image_id','=','f.id');
        if($data['level']>=1 && in_array('1', $itration))
        {
            $level1_id = ($data['level'] ==1)?$data['attr_value_id']:$data['variant_level1'];
            $query->where('pv.level1_attribute_value_id', $level1_id);
        }

        if($data['level']>=2 && in_array('2', $itration))
        {
            $level2_id = ($data['level'] ==2)?$data['attr_value_id']:$data['variant_level2'];
            $query->where('pv.level2_attribute_value_id', $level2_id);
        }

        if($data['level'] == 3)
        {
            $level3_id = $data['attr_value_id'];
            $query->where('pv.level3_attribute_value_id', $level3_id);
        }

        $query->where('pv.products_id', $data['product_id']);
        $product = $query->where('p.is_active', 1)
                        ->where('p.is_completed', 1)
                        ->first();
        return $product;
    }

    public function getAvailableAttributes($pid, $attr_value, $level)
    {
        $level1_available_variants = Variants::where('products_id', $pid)->where('level'.$level.'_attribute_value_id', $attr_value)->pluck('level1_attribute_value_id')->toArray();

        $level2_available_variants = Variants::where('products_id', $pid)->where('level'.$level.'_attribute_value_id', $attr_value)->pluck('level2_attribute_value_id')->toArray();

        $level3_available_variants = Variants::where('products_id', $pid)->where('level'.$level.'_attribute_value_id', $attr_value)->pluck('level3_attribute_value_id')->toArray();

        return ['level1_available_variants'=>$level1_available_variants, 'level2_available_variants'=>$level2_available_variants, 'level3_available_variants'=>$level3_available_variants];
    }

    public function getVariantLevels($pid)
    {
        $level1_variants = DB::table('product_variants as pv')->select('pca.attribute_name as attribute_name', 'pcav.value AS attribute_value', 'ml.file_name', 'pcav.id as value_id')->join('product_cateory_attribute_values as pcav', 'pv.level1_attribute_value_id', '=', 'pcav.id')->join('product_cateory_attributes as pca', 'pcav.attribute_id', '=', 'pca.id')->leftJoin('media_library as ml', 'pv.image_id', '=', 'ml.id')->where('pv.products_id', $pid)->groupBy('pcav.id')->get();

        $level2_variants = DB::table('product_variants as pv')->select('pca.attribute_name as attribute_name', 'pcav.value AS attribute_value', 'pcav.id as value_id')->join('product_cateory_attribute_values as pcav', 'pv.level2_attribute_value_id', '=', 'pcav.id')->join('product_cateory_attributes as pca', 'pcav.attribute_id', '=', 'pca.id')->where('pv.products_id', $pid)->groupBy('pcav.id')->get();

        $level3_variants = DB::table('product_variants as pv')->select('pca.attribute_name as attribute_name', 'pcav.value AS attribute_value', 'pcav.id as value_id')->join('product_cateory_attribute_values as pcav', 'pv.level3_attribute_value_id', '=', 'pcav.id')->join('product_cateory_attributes as pca', 'pcav.attribute_id', '=', 'pca.id')->where('pv.products_id', $pid)->groupBy('pcav.id')->get();

        return ['level1_variants'=>$level1_variants, 'level2_variants'=>$level2_variants, 'level3_variants'=>$level3_variants];
    }

    public function cart(){

         $cart = DB::table('cart as c')
            ->select('pv.name AS product_name','f.file_path AS url','c.quantity','pv.sale_price','c.id','c.product_id')
            ->join('product_variants as pv','c.product_id','=','pv.id')
            ->join('products as p','pv.products_id','=','p.id')
            ->leftJoin('media_library as f','pv.image_id','=','f.id')
            ->where('c.user_id',session('guest'))
            ->orderby('c.id','DESC')
            ->get(12);
        return view('vanila.cart',['cart'=>$cart]);
    }



    public function addtocart(Request $request){
        $cart = Cart::where('user_id',session('guest'))->where('product_id',$request->product)->first();
        if($cart){
            $cart->quantity = (($cart->quantity)+($request->qty)); $cart->save();
            return json_encode(['status'=>true,'message'=>$cart->product->name.' added to cart successfully','qty'=>$cart->quantity]);
        }else{
            $cart = new Cart;
            $cart->user_id = session('guest');
            $cart->product_id = $request->product;
            $cart->quantity = $request->qty;
            $cart->save();
            return json_encode(['status'=>true,'message'=>$cart->product->name.' added to cart successfully','qty'=>$cart->quantity]);
        }
    }

    public function cartcount(){
        $cart = Cart::where('user_id',session('guest'))->count();
        return json_encode(['status'=>true,'count'=>$cart]);
    }

    public function carttotal(){
        $cart = Cart::where('user_id',session('guest'))->get();$total= 0;
        foreach ($cart as $c){
            $total =$total+ $c->quantity * $c->product->sale_price;
        }
        return json_encode(['status'=>true,'total'=>$total]);
    }

    public function remove(Request $request){
        $cart = Cart::find($request->id)->product->name.' removed from cart' ;
        Cart::find($request->id)->delete();
        return json_encode(['status'=>true,'message'=>$cart]);
    }


    public function popup_login(){
        return view('vanila.common.login_popup');
    }

    public function popup_register(){
        return view('vanila.common.register_popup');
    }

    public function signin(Request $request){
        if (Auth::attempt ([
            'email' => $request->username,
            'password' => $request->password
        ])){
            $data = ['status'=>true , 'message' => 'Login is successful'];
            return json_encode($data);
        }else{
            $data = ['status'=>false , 'message' => 'Login is attempt was failed'];
            return json_encode($data);
        }
    }

    public function signup(Request $request){

        if(DB::table('users')->where('email',$request->email)->orWhere('email',$request->phone)->first()){
            $data = ['status'=>false , 'message' => 'User already exist'];
            return json_encode($data);
        }

        $user = User::create(request(['phone', 'email', 'password']));
        auth()->login($user);
        $data = ['status'=>true , 'message' => 'Login is successful'];

    }

    public function register(){

    }

    public function signout(){
        Auth::logout();
        $data = ['status'=>true , 'message' => 'User logged out successfully'];
        return json_encode($data);
    }

}
