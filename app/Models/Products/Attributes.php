<?php

namespace App\Models\Products;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class Attributes extends BaseModel
{
	use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_attributes';


    protected $fillable = array('products_id', 'attribute_id', 'attribute_value_id', 'attribute_value');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
            
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products', 'products_id');
    }

    public function attribute()
    {
        return $this->belongsTo('App\Models\Category\CategoryAttributes', 'attribute_id');
    }

    public function attribute_value()
    {
        return $this->belongsTo('App\Models\Category\CategoryAttributeValues', 'attribute_value_id');
    }

}