<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchLandmark extends Model
{
    protected $table = 'branch_landmarks';

    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id');
    }

}
