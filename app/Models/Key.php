<?php

namespace App\Models;
use App\Http\Controllers\BaseController;
use App\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    public static function get($key){
        $value = Settings::where('code',$key)->first();
        if(!$value){return 'NA';}else{
            if($value->type == 'Image'){
                if($value->media){
                    return asset($value->media->file_path);
                }
            }else{
                return $value->value;
            }
        }return 'NA';
    }

    public static function page_meta($slug,$type){
        $page = Page::where('slug',$slug)->where('status',1)->first();
        if(!$page){return '';}
        switch ($type){
            case 'title' :
                return $page->browser_title; break;
            case 'keywords' :
                return $page->meta_keywords; break;
            case 'description' :
                return $page->meta_description; break;
            case 'css' :
                return $page->extra_css; break;
            case 'js' :
                return $page->extra_js; break;
            default:
                return $page->browser_title; break;
        }
    }

    public static function category_meta($slug,$type){
        $page = Category::where('slug',$slug)->where('status',1)->first();
        if(!$page){return '';}
        switch ($type){
            case 'title' :
                return $page->browser_title; break;
            case 'keywords' :
                return $page->meta_keywords; break;
            case 'description' :
                return $page->meta_description; break;
            case 'css' :
                return $page->extra_css; break;
            case 'js' :
                return $page->extra_js; break;
            default:
                return $page->browser_title; break;
        }
    }

    public static function product_meta($slug,$type){
        $page = Products::where('slug',$slug)->where('status',1)->first();
        if(!$page){return '';}
        switch ($type){
            case 'title' :
                return $page->browser_title; break;
            case 'keywords' :
                return $page->meta_keywords; break;
            case 'description' :
                return $page->meta_description; break;
            case 'css' :
                return $page->extra_css; break;
            case 'js' :
                return $page->extra_js; break;
            default:
                return $page->browser_title; break;
        }
    }


}