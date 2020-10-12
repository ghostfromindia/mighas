<?php

namespace App\Models\Products;

use App\Models\BaseModel, App\Models\ValidationTrait, DB, Config;
use App\Models\ExtendedWarranty;
use App\Models\Products\Variants\Inventory;

class Variants extends BaseModel
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
    protected $table = 'product_variants';


    protected $fillable = array('products_id', 'name', 'slug', 'is_new', 'is_topseller','is_active' ,'image_id', 'level1_attribute_value_id', 'level2_attribute_value_id', 'level3_attribute_value_id', 'is_default', 'sku', 'short_description', 'offer_status', 'combo_offer_status');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|max:250',
            'slug' => 'required|alpha_dash|unique:product_variants,slug,ignoreId',
            'sku' => 'required|max:250',
            'retail_price' => 'required',
            'sale_price' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        $ignore_array = ['slug'];
        foreach($ignore_array as $ignore){ 
            $this->val_rules[$ignore] = str_replace('ignoreId', $ignoreId, $this->val_rules[$ignore]);
        }
        return $this->parent_validate($data);
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products', 'products_id');
    }

    public  function attribute_level1()
    {
        return $this->belongsTo('App\Models\Category\CategoryAttributeValues', 'level1_attribute_value_id');
    }

    public  function attribute_level2()
    {
        return $this->belongsTo('App\Models\Category\CategoryAttributeValues', 'level2_attribute_value_id');
    }

    public  function attribute_level3()
    {
        return $this->belongsTo('App\Models\Category\CategoryAttributeValues', 'level3_attribute_value_id');
    }

    public function media()
    {
        return $this->belongsTo('App\Models\Media', 'image_id');
    }

    public function inventory()
    {
        if(Config::get('common.multi_vendor'))
            return $this->hasMany('App\Models\Products\Variants\Inventory', 'variant_id');
        else
            return $this->hasOne('App\Models\Products\Variants\Inventory', 'variant_id', 'id');
    }

    public static function inStock($id,$do='available'){
        $stock = Inventory::where('variant_id',$id)->where('available_quantity','>',0)->first();
        if($do=='check'){
            if ($stock){return true;}else{return false;}
        }
        return $stock->available_quantity;
    }

    public function extended_warranty()
    {
        $sale_price = $this->inventory->sale_price;
        if($this->product){
            $category_id = $this->product->category_id;

            if($category_id){
                $extended = ExtendedWarranty::where('category_id',$category_id)->where('start_price','<',$sale_price)->where('end_price','>',$sale_price)->get();
                if(count($extended)>0){
                    return $extended;
                }
            }
        }



        return null;
    }

}