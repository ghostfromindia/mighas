<?php

namespace App\Models\Hykon;

use Illuminate\Database\Eloquent\Model;

class CMDMessage extends Model
{
    protected $table = 'hykon_cmd_message';

    public function media(){
        return $this->belongsTo('App\Models\Media', 'image_id');
    }
}
