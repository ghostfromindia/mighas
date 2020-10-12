<?php

namespace App\Models\Offers;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class OfferGroups extends BaseModel
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
    protected $table = 'offer_groups';


    protected $fillable = array('groups_id', 'offers_id', 'how_many_to_buy', 'how_many_to_get_free');

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

    public function group()
    {
        return $this->belongsTo('App\Models\Groups', 'groups_id');
    }

}