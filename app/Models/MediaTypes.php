<?php

namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class MediaTypes extends BaseModel
{
    protected $table = 'media_types';

    protected $fillable = ['type','path'];

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

    public static function listForSelect($default = '--- Select a type ---') {
        $list[''] = $default;

        foreach (static::orderBy('type', 'ASC')->get() as $type) {
            $list[$type->id] = $type->type;
        }
        return $list;
    }

}