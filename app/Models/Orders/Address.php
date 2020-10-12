<?php

namespace App\Models\Orders;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends BaseModel
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
    protected $table = 'address';


    protected $fillable = array('user_id', 'full_name', 'mobile_code', 'mobile_number', 'address', 'landmark', 'city', 'state', 'country_id', 'pincode', 'type', 'delivery_instruction');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function getPhoneAttribute() {
        return '+ '.$this->mobile_code. ' ' . $this->mobile_number;
    }

    public function state_details()
    {
        return $this->belongsTo('App\Models\States', 'state');
    }


    public function city_details()
    {
        return $this->belongsTo('App\Models\District', 'city');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

}