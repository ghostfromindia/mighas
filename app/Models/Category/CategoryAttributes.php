<?php

namespace App\Models\Category;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;
use App\Models\Products\Attributes;
use App\Models\Products\Variants;

class CategoryAttributes extends BaseModel
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
    protected $table = 'product_cateory_attributes';


    protected $fillable = array('category_id', 'attribute_name', 'show_as_variant', 'attribute_type', 'group_id');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function values()
    {
        return $this->hasMany('App\Models\Category\CategoryAttributeValues', 'attribute_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\CategoryAttributeGroups', 'group_id');
    }


    public function get($product_id){

        if(session('store_'.$product_id.$this->id)){
            return session('store_'.$product_id.$this->id)[0];
        }

        $attribute = Attributes::where('attribute_id',$this->id)->where('products_id',$product_id)->first();
        if(!$attribute){
            session()->push($product_id.$this->id, '---------');
            return '---------';
        }

        if($attribute->values){
            session()->push('store_'.$product_id.$this->id, $attribute->values->value);
            return $attribute->values->value;
        }else{
            session()->push('store_'.$product_id.$this->id, $attribute->attribute_value);
            return $attribute->attribute_value;
        }
    }

    public function getSelectableValues(){
        return $this->hasMany('App\Models\Category\CategoryAttributeValues','attribute_id','id');
    }

}
