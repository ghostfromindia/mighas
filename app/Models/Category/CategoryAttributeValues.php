<?php

namespace App\Models\Category;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class CategoryAttributeValues extends BaseModel
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
    protected $table = 'product_cateory_attribute_values';


    protected $fillable = array('attribute_id', 'value');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function attribute()
    {
        return $this->belongsTo('App\Models\Category\CategoryAttributes', 'attribute_id');
    }

}
