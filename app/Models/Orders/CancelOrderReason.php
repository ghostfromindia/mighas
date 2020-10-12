<?php

namespace App\Models\Orders;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancelOrderReason extends BaseModel
{
    use SoftDeletes;
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
    protected $table = 'cancel_order_reasons';


    protected $fillable = array('title', 'display_order');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

}