<?php

namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class Settings extends BaseModel
{
    protected $table = 'settings';

    protected $fillable = ['code','value','type','page', 'media_id'];

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }


    public function __construct() {

        parent::__construct();
        $this->__validationConstruct();
    }

    public $uploadPath = array(
        'settings' => 'uploads/settings/',
    );

    protected function setRules() {
        $this->val_rules = [
            'code' => 'required|alpha_dash|unique:settings,code,ignoreId',
            'value' => 'required',
            'type' => 'max:10',
            'page' => 'max:250',
        ];
    }

    protected function setAttributes() {
        $this->val_attributes = [
            'code' => 'key name',
            'value' => 'key value',
        ];
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['code']) )
        {
            $this->val_rules['code'] = str_replace('ignoreId', $ignoreId, $this->val_rules['code']);
        }
        return $this->parent_validate($data);
    }
    public function media()
    {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }
}