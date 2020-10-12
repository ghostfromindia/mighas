<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Orders, Input, View, Redirect, DB, Carbon;
use Helper, Config, Request, DataTables;
use App\Exports\AbandonedCartsExport;
use App\Exports\OrderHistoryExport;
use App\Exports\SalesHistoryExport;
use App\Exports\CustomerDetailsExport;
use App\Models\Orders\OrderStatusLabel;
use App\Models\Cart;

use Illuminate\Http\Request AS reqst;

class ReportsController extends BaseController
{
    public function abandoned_carts()
    {
    	if (Request::ajax()) {
            $collection = DB::table('cart')->select('cart.id', 'product_variants.name', 'cart.quantity', 'cart.price', 'cart.created_at')->join('product_variants', 'product_variants.id', '=', 'cart.product_id');

            $search = request()->get('data');
            if($search)
            	$collection = $this->filter($collection, $search);
            if(!$search || !isset($search['date_between-cart.created_at']))
            	$collection->whereDate('cart.created_at', '<=', now()->subDays(1)->setTime(0, 0, 0)->toDateTimeString());

            return Datatables::of($collection)
	            ->setRowId('row-{{ $id }}')
	            ->editColumn('created_at', function($obj){
	            	return date('d M, Y H:i A', strtotime($obj->created_at));
	            })
	            ->addColumn('action_delete', function($obj){ 
	                return '<a href="' . route( 'admin.reports.abandoned-carts.destroy',  [encrypt($obj->id)] ) . '" class="btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." title="Delete Abandoned Cart" style="padding: 0px;"><img width="20px" src="'.url('public/delete.png').'" alt="edit"></a>';
	            })
	            ->rawColumns(['action_delete'])
	            ->make(true);
            
        } else {
			return view('admin.reports.abandoned_carts');
        }
    }

    public function abandoned_cart_export(reqst $request)
    {
        $collection = DB::table('cart')->select('cart.id', 'product_variants.name', 'cart.quantity', 'cart.price', 'cart.created_at')->join('product_variants', 'product_variants.id', '=', 'cart.product_id');

        $search = $request->all();
        if(!isset($search['date_between-cart.created_at']))
            $collection->whereDate('cart.created_at', '<=', now()->subDays(1)->setTime(0, 0, 0)->toDateTimeString());

        $collection = $this->filter($collection, $search);
        $collection = $collection->get();
        $excel_name = 'abandoned_carts_'.round(microtime(true) * 1000).'.xlsx';
        return (new AbandonedCartsExport($collection))->download($excel_name);

    }

    public function order_history()
    {
    	if (Request::ajax()) {
            $collection = DB::table('order_details')->select('order_details.id', 'orders.transaction_id', 'orders.order_reference_number', DB::raw("CONCAT(address.mobile_code, ' ',address.mobile_number) AS mobile"), 'address.full_name', 'address.address1', 'address.address2', 'address.landmark', 'address.city', 'address.pincode', DB::raw("(CASE WHEN address.type = 1 THEN 'Home' ELSE 'Work' END) AS address_type"), 'product_variants.name', 'categories.category_name', 'order_details.quantity', 'order_details.sale_price', 'order_status_labels_master.name as status', 'order_details.created_at', 'orders.payment_method')->join('orders', 'order_details.orders_id', '=', 'orders.id')->join('product_variants', 'product_variants.id', '=', 'order_details.products_id')->join('products', 'product_variants.products_id', '=', 'products.id')->join('categories', 'categories.id', '=', 'products.category_id')->join('address', 'address.id', '=', 'orders.delivery_address_id')->join('order_status_labels_master', 'order_status_labels_master.id', '=', 'order_details.status');

            $search = request()->get('data');
            if($search)
            	$collection = $this->filter($collection, $search);

            return Datatables::of($collection)
	            ->setRowId('row-{{ $id }}')
	            ->editColumn('created_at', function($obj){
	            	return date('d M, Y H:i A', strtotime($obj->created_at));
	            })
	            ->addColumn('address', function($obj){
	            	$address = $obj->full_name;
	            	$address .= ', <br/>'.$obj->address1;
	            	if($obj->address2)
	            		$address .= ', <br/>'.$obj->address2;
	            	$address .= ', <br/>'.$obj->landmark;
	            	$address .= ', <br/>'.$obj->city;
	            	$address .= ', <br/>'.$obj->pincode;
                    return $address;
	            })
	            ->rawColumns(['address'])
	            ->make(true);
            
        } else {
			return view('admin.reports.order_history');
        }
    }

    public function order_history_export(reqst $request)
    {
    	$collection = DB::table('order_details')->select('orders.transaction_id', 'orders.order_reference_number', DB::raw("CONCAT(address.mobile_code, ' ',address.mobile_number) AS mobile"), 'address.full_name', 'address.address1', 'address.address2', 'address.landmark', 'address.city', 'address.pincode', DB::raw("(CASE WHEN address.type = 1 THEN 'Home' ELSE 'Work' END) AS address_type"), 'product_variants.name', 'categories.category_name', 'order_details.quantity', 'order_details.sale_price', 'order_status_labels_master.name as status', 'order_details.customer_instructions', 'order_details.created_at', 'orders.payment_method')->join('orders', 'order_details.orders_id', '=', 'orders.id')->join('product_variants', 'product_variants.id', '=', 'order_details.products_id')->join('products', 'product_variants.products_id', '=', 'products.id')->join('categories', 'categories.id', '=', 'products.category_id')->join('address', 'address.id', '=', 'orders.delivery_address_id')->join('order_status_labels_master', 'order_status_labels_master.id', '=', 'order_details.status');

        $search = $request->all();

        $collection = $this->filter($collection, $search);
        $collection = $collection->get();
        $excel_name = 'order_history_'.round(microtime(true) * 1000).'.xlsx';
        return (new OrderHistoryExport($collection))->download($excel_name);

    }

    public function sales_history()
    {
    	if (Request::ajax()) {
            $id = OrderStatusLabel::where('type', 'N')->orderBy('display_order', 'DESC')->first()->id;
            $collection = DB::table('order_details')->select('order_details.id', 'product_variants.name', 'order_details.quantity', 'order_details.sale_price', 'order_details.mrp', 'order_details.price', 'order_details.discount', 'products.hsn_code', 'products.cgst', 'products.sgst', 'products.igst', 'order_details.created_at')->join('orders', 'order_details.orders_id', '=', 'orders.id')->join('product_variants', 'product_variants.id', '=', 'order_details.products_id')->join('products', 'products.id', 'product_variants.products_id')->join('order_status_labels_master', 'order_status_labels_master.id', '=', 'order_details.status')->where('order_details.status', $id);

            $search = request()->get('data');
            if($search)
            	$collection = $this->filter($collection, $search);

            return Datatables::of($collection)
	            ->setRowId('row-{{ $id }}')
	            ->editColumn('created_at', function($obj){
	            	return date('d M, Y H:i A', strtotime($obj->created_at));
	            })
	            ->make(true);
            
        } else {
			return view('admin.reports.sales_history');
        }
    }

    public function sales_history_export(reqst $request)
    {
        $id = OrderStatusLabel::where('type', 'N')->orderBy('display_order', 'DESC')->first()->id;
        $collection = DB::table('order_details')->select('product_variants.name', 'order_details.quantity', 'order_details.sale_price', 'order_details.mrp', 'order_details.discount', 'products.hsn_code', 'products.cgst', 'products.sgst', 'products.igst', 'order_details.updated_at')->join('orders', 'order_details.orders_id', '=', 'orders.id')->join('product_variants', 'product_variants.id', '=', 'order_details.products_id')->join('products', 'products.id', 'product_variants.products_id')->join('order_status_labels_master', 'order_status_labels_master.id', '=', 'order_details.status')->where('order_details.status', $id);

        $search = $request->all();

        $collection = $this->filter($collection, $search);
        $collection = $collection->get();
        $excel_name = 'sales_report_'.round(microtime(true) * 1000).'.xlsx';
        return (new SalesHistoryExport($collection))->download($excel_name);

    }

    public function customer_details()
    {
        if (Request::ajax()) {
            $collection = DB::table('users')->select('users.id', 'users.email', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name"), 'users.banned_at', 'users.created_at', 'users.updated_at', "users.username AS phone")->join('role_users', 'users.id', '=', 'role_users.user_id')->where('role_users.role_id', 2)->whereNull('deleted_at');

            $search = request()->get('data');
            if($search)
                $collection = $this->filter($collection, $search);

            return Datatables::of($collection)
                ->setRowId('row-{{ $id }}')
                ->editColumn('created_at', function($obj){
                    return date('d M, Y H:i A', strtotime($obj->created_at));
                })
                ->editColumn('banned_at', function($obj) {
                    if($obj->banned_at)
                        return 'Inactive';
                    else
                       return 'Active'; 
                })
                ->filterColumn('name', function($query, $keyword) {
                        $query->where(function($q) use($keyword) {
                            $q->where('first_name', 'like', "%{$keyword}%")->orWhere('last_name', 'like', "%{$keyword}%");
                        });
                })
                ->make(true);
            
        } else {
            return view('admin.reports.customer_details');
        }
    }

    public function customer_details_export(reqst $request)
    {
       $collection = DB::table('users')->select( DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name"), 'users.email', 'users.username', 'users.created_at', DB::raw("(CASE WHEN users.banned_at IS NULL THEN 'Active' ELSE 'Inactive' END) AS status"))->join('role_users', 'users.id', '=', 'role_users.user_id')->where('role_users.role_id', 2)->whereNull('deleted_at')->orderBy('created_at', 'ASC');

        $search = $request->all();

        $collection = $this->filter($collection, $search);
        $collection = $collection->get();
        $excel_name = 'customer_details_'.round(microtime(true) * 1000).'.xlsx';
        return (new CustomerDetailsExport($collection))->download($excel_name);

    }

    public function filter($collection, $search)
    {
    	if($search)
        {
        	if(isset($search['_token']))
        		unset($search['_token']);

            foreach ($search as $key => $value) {
                $condition = null;
                $keyArr =  explode('-', $key);
                if(isset($keyArr[1]))
                {
                    $key = $keyArr[1];
                    $condition = $keyArr[0];
                }

                $key = str_replace('+', '.', $key);

                if($value)
                {
                    if($condition == 'date_between')
                    {
                        $date_array = explode('-', $value);
                        $from_date = $this->formatDate($date_array[0]);
                        $from_date = date('Y-m-d H:i:s', strtotime($from_date.' 00:00:00'));
                        $to_date = $this->formatDate($date_array[1]);
                        $to_date = date('Y-m-d H:i:s', strtotime($to_date.' 23:59:00'));
                        $collection->whereBetween($key, [$from_date, $to_date]);
                    }
                    elseif($condition == 'check_null')
                    {
                        if($value == 'N')
                            $collection->whereNotNull($key);
                        else
                            $collection->whereNull($key);
                    }
                    else
                    	$collection->where($key,$value);
                }
            }
        }
        return $collection;
    }

    public function formatDate($date) {
        $arr = explode("/",$date);

        $year  = trim($arr[2]);
        $month = trim($arr[1]);
        $day   = trim($arr[0]);

        return $year."-".$month."-".$day;
    }

    public function abandoned_cart_destroy($id)
    {
        $id = decrypt($id);
        $obj = Cart::find($id);
        if ($obj) {
            $obj->delete();
            return response()->json(['success'=>'Cart successfully deleted']);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }
}
