<?php

namespace App\Models\Orders;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatusLabel extends BaseModel
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
    protected $table = 'order_status_labels_master';


    protected $fillable = array('name', 'display_order', 'color_code');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function getInitialStatusAttribute() {
        return $id = static::where('type', 'N')->orderBy('display_order', 'ASC')->first()->id;
    }

    public function getFinalStatusAttribute() {
        return $id = static::where('type', 'N')->orderBy('display_order', 'DESC')->first()->id;
    }

    public function getCancelRequestStatusAttribute() {
        return $id = static::where('type', 'C')->orderBy('display_order', 'ASC')->first()->id;
    }

    public function getCanceledStatusAttribute() {
        return $id = static::where('type', 'C')->orderBy('display_order', 'DESC')->first()->id;
    }

    public function getReturnRequestStatusAttribute() {
        return $id = static::where('type', 'R')->orderBy('display_order', 'ASC')->first()->id;
    }

    public function getReturnedStatusAttribute() {
        return $id = static::where('type', 'R')->orderBy('display_order', 'DESC')->first()->id;
    }

    public function get_order_processing_type($current_id)
    {
        return static::where('id', $current_id)->first()->type;
    }

}