<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';
    
    public function landmarks()
    {
        return $this->hasMany('App\Models\BranchLandmark', 'district_id');
    }

    public function state(){
        return $this->belongsTo('App\Models\States', 'state_id');
    }

}
