<?php

namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;
use App\Models\Products\Review;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Orders extends BaseModel
{
    use SoftDeletes;
    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }

    public function __construct()
    {

        parent::__construct();
        $this->__validationConstruct();
    }

    /**
     * The database table used by the model.
     *
     * @var string                         L̥
     */
    protected $table = 'orders';


    protected $fillable = array('users_id', 'transaction_id', 'order_reference_number', 'total_mrp', 'total_discount', 'total_sale_price', 'payment_method', 'payment_status', 'delivery_address_id', 'is_cancelled', 'cancelled_reason');

    protected $dates = ['created_at', 'updated_at'];


    protected function setRules()
    {

        $this->val_rules = array();
    }

    protected function setAttributes()
    {
        $this->val_attributes = array();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\Orders\OrderDetails', 'orders_id');
    }

    public function delivery_address()
    {
        return $this->belongsTo('App\Models\Orders\Address', 'delivery_address_id');
    }


}