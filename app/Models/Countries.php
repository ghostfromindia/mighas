<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = 'countries';

    public static function listForSelect($default = '--- Select Country ---') {
        $list[''] = $default;
        foreach (static::orderBy('name', 'ASC')->get() as $country) {
            $list[$country->id] = $country->name;
        }
        return $list;
    }
}
