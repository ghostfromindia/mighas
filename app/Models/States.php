<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $table = 'states';

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'CountryID');
    }

    public static function listForSelect($default = '--- Select a State ---', $country=null) {
        $list[''] = $default;
        if($country)
        	$states = static::where('CountryID', $country)->orderBy('name', 'ASC')->get();
        else
        	$states = static::orderBy('name', 'ASC')->get();

        foreach ($states as $state) {
            $list[$state->id] = $state->name;
        }
        return $list;
    }
}
