<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\ValidationTrait;

class Coupon extends BaseModel
{
	use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    protected $table = 'coupons';


    protected $fillable = array('coupon_code', 'description', 'type', 'minimum_purchase_value', 'discount_type', 'discount_percentage', 'discount_amount', 'maximum_discount_value', 'start_date', 'end_date', 'terms', 'status');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'coupon_code' => 'required|max:250|unique:coupons,coupon_code,ignoreId',
            'minimum_purchase_value' => 'required',
            'maximum_discount_value' => 'required',
            "discount_percentage" => "required_if:discount_type,==,Percentage",
            "discount_amount" => "required_if:discount_type,==,Amount",
            'start_date' => 'required',
            'end_date' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['coupon_code']) )
        {
            $this->val_rules['coupon_code'] = str_replace('ignoreId', $ignoreId, $this->val_rules['coupon_code']);
        }
        return $this->parent_validate($data);
    }
}