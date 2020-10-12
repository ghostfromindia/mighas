<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\ValidationTrait;
use Str;

class ExtendedWarranty extends BaseModel
{
	use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    protected $table = 'extended_warranties';


    protected $fillable = array('products_id','category_id','title', 'year', 'warranty_price', 'start_price', 'end_price', 'status');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'product_name' => 'required|max:225',
            'category_id' => 'required',
            'sale_price' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
            'product_name' => 'warranty name',
            'category_id' => 'category_id',
            'sale_price' => 'warranty price',
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        
    }

    public function variant()
    {
        return $this->belongsTo('App\Models\Products\Variants', 'products_id');
    }

}