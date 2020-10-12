<?php

namespace App\Models\Offers;

use Illuminate\Database\Eloquent\Model;

class OfferView extends Model
{
    protected $table = 'offers_data';

    public function product_details(){
        return $this->belongsTo('App\Models\Products\Variants','product');
    }

    public function offer_details(){
        return $this->hasOne('App\Models\Products\Offers','offers');
    }
}
