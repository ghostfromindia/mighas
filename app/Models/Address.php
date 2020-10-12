<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $fillable = ['user_id','full_name','mobile_code','mobile_number','address1','address2','landmark','city','state','country_id','pincode','type','is_default'];

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }


    public function __construct() {

        parent::__construct();
        $this->__validationConstruct();
    }

    protected function setRules() {
        $this->val_rules = [
            'full_name' => 'required|max:225',
            'mobile_number' => 'required',
            'address1' => 'required|max:225',
            'city' => 'required|max:225',
            'state' => 'required|max:225',
            'pincode' => 'required',
        ];
    }

    protected function setAttributes() {
        $this->val_attributes = [
            'full_name' => 'full name',
            'mobile_number' => 'mobile number',
            'address1' => 'address',
            'city' => 'city',
            'state' => 'state',
            'pincode' => 'pincode'
        ];
    }

    public function validate($data = null, $ignoreId = 'NULL') {
    }

    public function state_details()
    {
        return $this->belongsTo('App\Models\States', 'state');
    }
}