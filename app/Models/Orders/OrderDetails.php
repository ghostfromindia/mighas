<?php

namespace App\Models\Orders;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;
use App\Models\Products\Review;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class OrderDetails extends BaseModel
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
    protected $table = 'order_details';


    protected $fillable = array('orders_id', 'products_id', 'mrp', 'quantity', 'sale_price', 'discount', 'expected_delivery_date', 'customer_instructions', 'is_cancelled', 'cancelled_reason', 'status');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }


    public function order()
    {
        return $this->belongsTo('App\Models\Orders', 'orders_id');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Products', 'id','products_id');
    }

    public function product_variants()
    {
        return $this->belongsTo('App\Models\Products\Variants', 'products_id');
    }

    public function tracking_status()
    {
        return $this->belongsTo('App\Models\Orders\OrderStatusLabel', 'status', 'id');
    }

    public function tracking_history()
    {
        return $this->hasMany('App\Models\Orders\OrderTracking', 'order_details_id');
    }
    
    public function get_status_note()
    {
        $status = DB::table('order_details')->select('order_tracking.notes')->join('order_tracking', function($join){
            $join->on('order_details.id', '=', 'order_tracking.order_details_id');
            $join->on('order_details.status', '=', 'order_tracking.order_status_labels_master_id');
        })->where('order_details.id',$this->id)->orderBy('order_tracking.created_at', 'DESC')->first();
        return $status->notes;
    }

    public function ratings()
    {
        $user = DB::table('order_details')->select('orders.users_id as user')
            ->join('orders','orders.id','=','order_details.orders_id')
            ->join('users','users.id','=','orders.users_id')
            ->where('order_details.id',$this->id)->first()->user;

        $review = Review::select('rating')->where('products_id',$this->product_variants->id)->where('user_id',$user)->first();
        if($review){
            return $review->rating;
        }else{
            return 0;
        }
    }
}