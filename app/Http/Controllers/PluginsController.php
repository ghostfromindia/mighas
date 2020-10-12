<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Auth;

class PluginsController extends Controller
{
    public function select2_countries(Request $r){
        $categories = DB::table('countries')->where('name', 'like', $r->q.'%')->orderBy('name')
            ->get();
        $json = [];
        foreach($categories as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->name];
        }
        return \Response::json($json);
    }

    public function select2_states(Request $r){
        $json = [];
        $country_id = $r->country_id;
        if($country_id)
        {
            $categories = DB::table('states')->where('name', 'like', $r->q.'%')->orderBy('name')
                ->get();
            foreach($categories as $c){
                $json[] = ['id'=>$c->id, 'text'=>$c->name];
            }
        }
        return \Response::json($json);
    }

    public function select2_pages(Request $r){
        $pages = DB::table('pages')->where('name', 'like', $r->q.'%')->orderBy('name')
            ->get();
        $json = [];
        foreach($pages as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->name];
        }
        return \Response::json($json);
    }

    public function select2_categories(Request $r){
        $categories = DB::table('categories')->where('category_name', 'like', $r->q.'%')->orderBy('category_name')
            ->get();
        $json = [];
        foreach($categories as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->category_name];
        }
        return \Response::json($json);
    }

    public function select2_brands(Request $r){
        $brands = DB::table('brands')->where('brand_name', 'like', $r->q.'%')->orderBy('brand_name')
            ->get();
        $json = [];
        foreach($brands as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->brand_name];
        }
        return \Response::json($json);
    }

    public function select2_venders(Request $r){
        $venders = DB::table('vendors')->where('vendor_name', 'like', $r->q.'%')->orderBy('vendor_name')
            ->get();
        $json = [];
        foreach($venders as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->vendor_name];
        }
        return \Response::json($json);
    }

    public function select2_groups(Request $r){
        $groups = DB::table('groups')->where('group_name', 'like', $r->q.'%')->orderBy('group_name')
            ->get();
        $json = [];
        foreach($groups as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->group_name];
        }
        return \Response::json($json);
    }

    public function select2_products(Request $r){
        $products = DB::table('product_variants as v')->join('products as p','v.products_id','=','p.id')
            ->where('p.deleted_at',null)
            ->where('p.is_active',1)->where('v.name', 'like', '%'.$r->q.'%')->orderBy('name')
            ->where('v.deleted_at',null)->select('v.name as name','v.id as id')->get();
        $json = [];
        foreach($products as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->name];
        }
        return \Response::json($json);
    }

    public function select2_order_status(Request $r){
        /*$products = DB::table('order_status_labels_master')->where('name', 'like', $r->q.'%')->where('type', 'N')->where('id', '!=', function($query){
            $query->select('order_status_labels_master1.id')->from('order_status_labels_master as order_status_labels_master1')->orderBy('order_status_labels_master1.display_order', 'desc')->where('type', 'N')->first();
        })->orderBy('name')->get();*/

        $products = DB::table('order_status_labels_master')->where('name', 'like', $r->q.'%')->orderBy('name')->get();

        $json = [];
        foreach($products as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->name];
        }
        return \Response::json($json);
    }

    public function ajax_locations($district_id)
    {
        $locations = DB::table('branch_landmarks')->where('district_id', $district_id)->orderBy('landmark')->get();
        
        $json = [];
        foreach($locations as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->landmark];
        }
        return \Response::json($json);
    }

    public function unique_user(Request $r)
    {
         $id = $r->id;
         $email = $r->email;
         
         $where = "email='".$email."'";
         if($id)
            $where .= " AND id != ".decrypt($id);
         $user = DB::table('users')
                    ->whereRaw($where)
                    ->get();
         
         if (count($user)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

    public function unique_customer_phone(Request $r)
    {
        $id = $r->id;
        $username = $r->phone_number;
         
         $where = "username='".$username."'";
         if($id)
            $where .= " AND id != ".decrypt($id);
         $user = DB::table('users')
                    ->whereRaw($where)
                    ->get();
         
         if (count($user)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

    public function unique_attribute_slug(Request $r)
    {
        $id = $r->id;
        $attribute_slug = $r->attribute_slug;
         
         $where = "attribute_slug='".$attribute_slug."'";
         if($id)
            $where .= " AND id != ".decrypt($id);
         $result = DB::table('product_cateory_attributes')
                    ->whereRaw($where)
                    ->get();
         
         if (count($result)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

    public function unique_attribute_value_slug(Request $r)
    {
        $id = $r->id;
        $value_slug = $r->value_slug;
         
         $where = "value_slug='".$value_slug."'";
         if($id)
            $where .= " AND id != ".decrypt($id);
         $result = DB::table('product_cateory_attribute_values')
                    ->whereRaw($where)
                    ->get();
         
         if (count($result)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

    public function unique_product_slug(Request $r)
    {
        $id = $r->id;
        $slug = $r->slug;
         
         $where = "slug='".$slug."'";
         if($id)
            $where .= " AND id != ".decrypt($id);
         $result = DB::table('products')
                    ->whereRaw($where)
                    ->get();
         
         if (count($result)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

    public function unique_product_variant_slug(Request $r)
    {
        $id = $r->id;
        $slug = $r->slug;
         
         $where = "slug='".$slug."'";
         if($id)
            $where .= " AND id != ".decrypt($id);
         $result = DB::table('product_variants')
                    ->whereRaw($where)
                    ->get();
         
         if (count($result)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

    public function unique_page_slug(Request $r)
    {
        $id = $r->id;
        $slug = $r->slug;
         
         $where = "slug='".$slug."'";
         if($id)
            $where .= " AND id != ".decrypt($id);
         $result = DB::table('pages')
                    ->whereRaw($where)
                    ->get();
         
         if (count($result)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

     public function unique_user_email(Request $r)
    {
         $id = Auth::user()->id;
         $email = $r->email;
         
         $where = "email='".$email."'";
         if($id)
            $where .= " AND id != ".$id;
         $user = DB::table('users')
                    ->whereRaw($where)
                    ->get();
         
         if (count($user)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

     public function unique_user_phone(Request $r)
    {
         $id = Auth::user()->id;
         $username = $r->username;
         
         $where = "username='".$username."'";
         if($id)
            $where .= " AND id != ".$id;
         $user = DB::table('users')
                    ->whereRaw($where)
                    ->get();
         
         if (count($user)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

    public function unique_coupon_code(Request $r)
    {
        $id = $r->id;
        $coupon_code = $r->coupon_code;
         
         $where = "coupon_code='".$coupon_code."'";
         if($id)
            $where .= " AND id != ".decrypt($id);
         $result = DB::table('coupons')
                    ->whereRaw($where)
                    ->get();
         
         if (count($result)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }
}
