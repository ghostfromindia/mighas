<?php

namespace App\Models\Orders;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTracking extends BaseModel
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
    protected $table = 'order_tracking';


    protected $fillable = array('order_details_id', 'order_status_labels_master_id', 'notes');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }


    public function order_details()
    {
        return $this->belongsTo('App\Models\Orders\OrderDetails', 'order_details_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Orders\OrderStatusLabel', 'order_status_labels_master_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

}