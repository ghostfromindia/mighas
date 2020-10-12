<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Offers;
use App\Models\Offers\OfferView;
use Carbon\Carbon as Carbon;
use Route, DB;
use App\Models\FrontendPage;

class OfferController extends Controller
{
    public function home(){
        $offers =  Offers::whereDate('validity_end_date','>',Carbon::now())->get();
        $name = Route::currentRouteName();
        $meta_details = FrontendPage::where('slug',$name)->first();
        return view('client.pages.offer',compact('offers', 'meta_details'));
    }

    public function offer_details($slug){
        $offer = Offers::where('slug',$slug)->first();
        $products = OfferView::where('offer',$offer->id)->paginate(12);
        return view('client/pages/offer_details',compact('products','offer'));
    }
    
    
    public function offer_page($type){
        if($type == 'offers' ){
            
              $variants = DB::table('product_variants as variant')
            		  ->join('products as parent', 'parent.id', '=', 'variant.products_id')
                          ->leftjoin('media_library as media', 'variant.image_id', '=', 'media.id')
                          ->join('product_inventory_by_vendor as price', 'price.variant_id', '=', 'variant.id')
                          ->where('parent.is_active',1)
                          ->where('variant.offer_status',1)
                          ->select('variant.name','variant.slug','media.file_path','price.sale_price','price.retail_price')->get();
       
        }else{
           $variants = DB::table('product_variants as variant')
            		  ->join('products as parent', 'parent.id', '=', 'variant.products_id')
                          ->leftjoin('media_library as media', 'variant.image_id', '=', 'media.id')
                          ->join('product_inventory_by_vendor as price', 'price.variant_id', '=', 'variant.id')
                          ->where('parent.is_active',1)
                          ->where('variant.combo_offer_status',1)
                          ->select('variant.name','variant.slug','media.file_path','price.sale_price','price.retail_price')->get();
        }
        
         return view('client.pages.latest_offers',compact('variants'));
    }


}
