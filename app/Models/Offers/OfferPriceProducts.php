<?php

namespace App\Models\Offers;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class OfferPriceProducts extends BaseModel
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
    protected $table = 'offer_price_products';


    protected $fillable = array('products_id', 'offers_id');

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