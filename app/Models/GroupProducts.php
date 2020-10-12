<?php namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class GroupProducts extends BaseModel
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
    protected $table = 'group_products';


    protected $fillable = array('groups_id', 'products_id');


    protected function setRules() {

        $this->val_rules = array(
           
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }


    public function group()
    {
        return $this->belongsTo('App\Models\Groups', 'groups_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products\Variants', 'products_id');
    }

}
