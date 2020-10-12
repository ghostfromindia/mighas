<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    protected $table = 'waranty';

    public function installation_address()
    {
        return $this->belongsTo('App\Models\Orders\Address', 'installation_address_id');
    }

    public function billing_address()
    {
        return $this->belongsTo('App\Models\Orders\Address', 'billing_address_id');
    }


}
