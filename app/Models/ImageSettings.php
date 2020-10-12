<?php

namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageSettings extends BaseModel
{
    use SoftDeletes;
    
    protected $table = 'media_settings';

    protected $fillable = ['type_id','width','height'];

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }


    public function __construct() {
        parent::__construct();
        $this->__validationConstruct();
    }

    protected function setRules() {
        $this->val_rules = [      
        ];
    }

    protected function setAttributes() {
        $this->val_attributes = [    
        ];
    }

    public function media_type()
    {
        return $this->belongsTo('App\Models\MediaTypes', 'type_id');
    }
}