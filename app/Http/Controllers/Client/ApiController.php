<?php

namespace App\Http\Controllers\Client;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Page;
use App\Models\SliderPhotos,Sliders,Media;
use App\Models\Banner;
use App\Models\Category;
use App\Models\HomePageSettings;
use DB, Auth;

class ApiController extends Controller
{
    public function slider($code='home-slider')
    {
        $asset = asset('uploads/slider/').'/';
        $slides = DB::table('slider_photos')->select('slider_photos.id', 'slider_photos.title', 'slider_photos.description', 'slider_photos.alt_text', 'slider_photos.button_text', 'slider_photos.button_link', 'slider_photos.button_link_target', 'slider_photos.button2_text', 'slider_photos.button2_link', 'slider_photos.button2_link_target',DB::raw("CONCAT('".$asset."', media_library.file_name) AS file_name",'?".uniqid()."'))->join('sliders', 'slider_photos.sliders_id', '=', 'sliders.id')->join('media_library', 'slider_photos.media_id', '=', 'media_library.id')->where('sliders.code', $code)->get();
        return json_encode($slides);

    }

    public function banner($code)
    {
        $banner = DB::table('banners as banner')
                  ->join('banner_photos as bp','bp.banners_id','=','banner.id')
                  ->join('media_library as media','media.id','=','bp.media_id')
                  ->where('banner.code', $code);

        $data['data'] = $banner->select('banner.id as id','banner.title as name','bp.title as child_name','bp.link','media.file_path as image_url')->get();
        if($banner->first()){
             $data['title'] = $banner->first()->name;
        }else{
             $data['title'] = null;
        }
       

        return json_encode($data);
    }

    public function home_popular_categories()
    {
        $categories = Category::whereHas('sub_categories', function($query){
            $query->where('is_popular', 1)->where('status', 1);
        })->with('primary')->where('is_popular', 1)->where('status', 1)->take(6)->get()->map(function($query) {
            $query->setRelation('sub_categories', $query->sub_categories->take(5));
            return $query;
        });
        return json_encode($categories);
    }

    public function home_features()
    {
        $website_features = HomePageSettings::where('code', 'website-features')->first();
        return $website_features->content;
    }

    public function home_banner()
    {
        $banner = HomePageSettings::where('code', 'home-banner')->first();
        return $banner->content;
    }

    public function home_news_slider()
    {
        $news = DB::table('pages')->select('pages.id', 'pages.slug', 'pages.name', 'pages.short_description', 'pages.updated_at', 'media_library.file_path')->leftJoin('media_library', 'pages.media_id', '=', 'media_library.id')->where('status', 1)->where('type', 'News')->orderBy('updated_at', 'DESC')->take(5)->get();
        return json_encode($news);
    }

    public function featured_brands()
    {
        $website_features = HomePageSettings::where('code', 'featured-brands')->first();
        $content = json_decode($website_features->content);
        $ids = (array)$content->featured_brands;
        $brands = null;
        if($ids)
        {
            $brands = DB::table('brands')->select('brands.id', 'brands.slug', 'brands.website', 'media_library.file_path')->join('media_library', 'brands.media_id', '=', 'media_library.id')->whereIn('brands.id', $ids)->where('status', 1)->get();
        }
        return json_encode($brands);
    }

    public function productlist($type){

        $product = DB::table('products as p')
            ->select('pv.id','pv.name','pv.slug','pibv.retail_price as mrp','pibv.sale_price', 'ml.file_name', 'pv.rating', 'pv.reviews')
            ->join('product_variants as pv', 'p.id', '=', 'pv.products_id')
            ->join('product_inventory_by_vendor as pibv', 'pv.id', '=', 'pibv.variant_id')
            ->leftJoin('media_library as ml','pv.image_id','=','ml.id')
            ->where('pibv.vendor_id', 1)
            ->where('pv.is_default', 1)
            ->where('p.is_active', 1);
        switch ($type){
            case 'topratedproducts':
                $data = $product->where('p.is_new','1')->take(3)->get();
                return json_encode($data);
            case 'specialoffer':
                $data = $product->where('p.is_today_deal','1')->take(3)->get();
                return json_encode($data);
            case 'bestseller':
                $data = $product->where('p.is_top_seller','1')->take(3)->get();
                return json_encode($data);
        }
        $data = $product->take(3)->get();
        return json_encode($data);
    }

    public function default_address()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $address = DB::table('address')->select('full_name', DB::raw("CONCAT(address1,'<br/>', landmark, '<br/>', city, '<br/>', state, '<br/>', pincode) AS address"), DB::raw("CONCAT(mobile_code, ' ', mobile_number) AS phone"), 'type', 'is_default')->where('user_id', $user_id)->where('is_default', 1)->first();
        return json_encode($address);
    }

    public function get_banners($banner_id)
    {
        $banner = Banner::where('code', $banner_id)->first();
        return json_encode($banner);
    }
}
