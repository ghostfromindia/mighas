<?php

namespace App\Models\Products\Variants;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class Images extends BaseModel
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
    protected $table = 'product_variant_images';


    protected $fillable = array('variant_id', 'image_id', 'is_common');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
            'varient_id'=> 'required',
            'image_id' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function varient()
    {
        return $this->belongsTo('App\Models\Products\Variants', 'variant_id');
    }

    public function image()
    {
        return $this->belongsTo('App\Models\Media', 'image_id');
    }

}