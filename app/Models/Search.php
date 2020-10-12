<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table = 'search';

    public function variant(){
        return $this->belongsTo('App\Models\Products\Variants','variant_id');
    }
}
