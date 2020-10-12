<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use App\Models\Orders, Input, View, Redirect, DB, Datatables, Carbon;
use App\Models\Orders\OrderDetails;
use App\Models\Orders\OrderStatusLabel;
use App\Models\Orders\OrderTracking;
use Helper, Config,Auth,PDF;

use Illuminate\Http\Request;

class OrdersController extends BaseController
{
    use ResourceTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->model = new Orders;

        $this->route .= '.orders';
        $this->views .= '.orders';
        $this->url = "admin/orders/";

        $this->resourceConstruct();

    }

    public function index($type=null)
    {
        $status = null;
        if($type)
            $status = OrderStatusLabel::find($type);
        if (request()->ajax()) {
            $collection = $this->getCollection();
            $search = request()->get('data');
            if($search)
            {
                foreach ($search as $key => $value) {
                    $condition = null;
                    $keyArr =  explode('-', $key);
                    if(isset($keyArr[1]))
                    {
                        $key = $keyArr[1];
                        $condition = $keyArr[0];
                    }

                    if($value)
                    {
                        if($condition == 'date_between')
                        {
                            $date_array = explode('-', $value);
                            $from_date = $this->formatDate($date_array[0]);
                            $from_date = date('Y-m-d H:i:s', strtotime($from_date.' 00:00:00'));
                            $to_date = $this->formatDate($date_array[1]);
                            $to_date = date('Y-m-d H:i:s', strtotime($to_date.' 00:00:00'));
                            $collection->whereBetween($key, [$from_date, $to_date]);
                        }
                        elseif($condition == 'like')
                        {
                            $collection->where($key, 'LIKE', "%$value%");
                        }
                        else
                            $collection->where($key,$value);
                    }
                }
            }
            
            if($type)
                $collection->where('order_details.status', '=', $type);
            
            return $this->setDTData($collection)->make(true);
        } else {
            return view($this->views . '.index', ['type'=>$type, 'status'=>$status]);
        }
    }


    protected function getCollection() {
        $collection = DB::table('order_details')->select('order_details.id', 'orders.transaction_id', 'orders.order_reference_number', 'orders.payment_method', 'orders.payment_receive_status', 'orders.created_at', 'orders.updated_at', DB::raw("CONCAT(address.mobile_code, ' ',address.mobile_number) AS mobile"), 'product_variants.name', 'order_details.quantity', 'order_details.sale_price', 'order_status_labels_master.name as status')->join('orders', 'order_details.orders_id', '=', 'orders.id')->join('product_variants', 'product_variants.id', '=', 'order_details.products_id')->join('address', 'address.id', '=', 'orders.delivery_address_id')->join('order_status_labels_master', 'order_status_labels_master.id', '=', 'order_details.status')->where('order_details.is_returned', 0);

        return $collection;  
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('status', function($obj){
                return '<span class="badge badge-success">'.$obj->status.'</span>';
            })
            ->editColumn('payment_receive_status', function($obj){
                if($obj->payment_method == 'Online Payment')
                {
                    if($obj->payment_receive_status == 1)
                        return '<span class="badge badge-success">Received</span>';
                    else
                        return '<span class="badge badge-danger">Pending</span>';
                }
                else
                    return '<span class="badge badge-info">On Delivery</span>';
            })
              ->editColumn('order_reference_number', function($obj) use ($route) {
                return '<a href="' . route( $route . '.view',  [$obj->id] ) . '" class="open-ajax-popup" data-popup-size="large" title="Order Tracking">'.$obj->order_reference_number.'</a> | 
                <a href="' . url( 'admin/invoice/'.$obj->order_reference_number) . '" target="_blank" style="color: red;
    display: block;">SALE ORDER</a>';
            })
            ->editColumn('created_at', function($obj) { return date('m/d/Y H:i:s', strtotime($obj->created_at)); })
            ->filterColumn('mobile', function($query, $keyword) {
                    $sql = "CONCAT(address.mobile_code, ' ',address.mobile_number) like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
            ->rawColumns(['order_reference_number', 'action_delete', 'status', 'payment_receive_status']);
    }

    public function view($id, $response=null)
    {
        if($obj = OrderDetails::find($id)){
            $status_lable = new OrderStatusLabel;
            $order_processing_type  = $status_lable->get_order_processing_type($obj->status);
            $canceled_status = $status_lable->getCanceledStatusAttribute();
            $tracking_statuses = OrderStatusLabel::orderBy('display_order', 'ASC')->where('type', $order_processing_type)->get();
            return view($this->views . '.form')->with('obj', $obj)->with('tracking_statuses', $tracking_statuses)->with('order_processing_type', $order_processing_type)->with('canceled_status', $canceled_status)->with('response', $response);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function changeStatus(Request $r)
    {
        $data = $r->all();
        if($obj = OrderDetails::find($data['id'])){
            if(isset($data['is_cancel']))
            {
                $response = $this->cancel_order($obj, $data);
            }
            else
            {
                $statuses = OrderStatusLabel::where('type', 'N')->orderBy('display_order', 'DESC')->where('id', '>', $obj->status)->where('id', '<=', $data['status'])->get();
                if($statuses);
                {
                    foreach ($statuses as $key => $status) {
                        $tracking = new OrderTracking;
                        $tracking->order_details_id = $data['id'];
                        $tracking->order_status_labels_master_id = $status->id;
                        $tracking->notes = $data['note'];
                        $tracking->save();
                    }

                    $obj->status = $data['status'];
                    $obj->save();
                }
                $response = array('success'=>true);
            }
            return $this->view($data['id'], $response);
        }
        else{
            return $this->redirect('notfound');
        }
    }

    public function cancel_order($obj, $data)
    {
        $cancel_status = OrderStatusLabel::where('type', 'C')->orderBy('display_order', 'DESC')->value('id');
        $money_returned = null;
        if($obj->order->payment_status == '1' && $obj->order->payment_method == 'Online Payment')
        {
            $amount = $obj->sale_price*$obj->quantity;
            $money_returned_details = $this->return_money($obj->order->order_reference_number, $obj->order->transaction_id, $amount);
            if($money_returned_details['success'] == true)
                $money_returned = $money_returned_details['return_request_id'];
            else
                return $money_returned_details;
        }
        elseif($obj->order->payment_method == 'Cash On Delivery')
        {
            $obj->status = $cancel_status;
            $obj->is_cancelled = 1;
            $obj->save();
        }

        if($money_returned)
        {
            $obj->refund_request_id = $money_returned;
            $obj->status = $cancel_status;
            $obj->is_cancelled = 1;
            $obj->save();
        }
        
        $tracking = new OrderTracking;
        $tracking->order_details_id = $data['id'];

        $tracking->order_status_labels_master_id = $cancel_status;
        $tracking->notes = $data['note'];
        $tracking->save();
        
        return array('success'=>true);
    }

    public function return_money($order_id, $transaction_id, $amount)
    {
        $return_request_id = null;
        $obj = new \AWLMEAPI();

        $reqMsgDTO = new \ReqMsgDTO();
        // Merchant unique order id
        $reqMsgDTO->setOrderId($order_id);
        // PG MID
        $reqMsgDTO->setMid(Config::get('common.payments.merchant_id'));
        // PG transaction reference number
        $reqMsgDTO->setPgMeTrnRefNo($transaction_id);
        // Merchant encryption key
        $reqMsgDTO->setEnckey(Config::get('common.payments.encryption_key'));
        // Refund amount
        $reqMsgDTO->setRefundAmt($amount*100);
        $resMsgDTO = $obj->refundTransaction($reqMsgDTO);
        //print_r($resMsgDTO);

        if($resMsgDTO->getStatusCode() == 'S')
            $return_request_id = $resMsgDTO->getPgRefCancelReqId();
        else
            return array('success'=>false, 'message'=>$resMsgDTO->getStatusDesc());
        return array('success'=>true, 'return_request_id'=>$return_request_id);

    }
    
       public function invoice($order_id){
       
            $order =Orders::where('order_reference_number',$order_id)->first();
            $ordertotalinwords = BaseController::getIndianCurrency($order->total_sale_price);
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('client.pdf.invoice', compact('order','ordertotalinwords'));
            return $pdf->stream('invoice.pdf');
       
       }
        

}
