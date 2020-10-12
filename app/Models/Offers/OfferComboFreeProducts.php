<?php

namespace App\Models\Offers;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class OfferComboFreeProducts extends BaseModel
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
    protected $table = 'offer_combo_free_products';


    protected $fillable = array('products_id', 'offers_id', 'type', 'fixed_price', 'discount_amount', 'discount_percentage', 'max_discount_amount');

    protected $dates = ['created_at','updated_at'];

    public $uploadPath = array(
        
    );


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products\Variants', 'products_id');
    }

}