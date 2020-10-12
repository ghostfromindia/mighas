<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blocks extends Model
{
    protected $table = 'blocks';

    public function variant()
    {
        return $this->belongsTo('App\Models\Products\Variants', 'variant_id');
    }

}
