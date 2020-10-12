<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $table = 'wishlist';

    public function product_details(){
        return $this->belongsTo('App\Models\Products\Variants','variant_id');
    }

    public function user_details(){
        return $this->hasOne('App\User','user_id');
    }

    public static function is_in($variant_id,$user_id){
        $w  = WishList::where('variant_id',$variant_id)->where('user_id',$user_id)->first();
        if($w){
            return true;
        }else{
            return false;
        }
    }

}
