<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Input, Request, View, Validator, Redirect, Auth, DB, Session, Carbon;

class AdminController extends Controller {

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pending_orders = DB::table('order_details')->where('order_details.status', function($query){
			$query->from('order_status_labels_master')->select('id')->where('type', 'N')->orderBy('display_order', 'ASC')->take(1);
		})->join('orders', 'orders.id', '=', 'order_details.orders_id')->where('is_returned', 0)->where('order_details.is_cancelled', 0)->count();

		$pending_return_requests = DB::table('order_details')->where('order_details.status', function($query){
			$query->from('order_status_labels_master')->select('id')->where('type', 'R')->orderBy('display_order', 'ASC')->take(1);
		})->join('orders', 'orders.id', '=', 'order_details.orders_id')->where('is_returned', 0)->where('order_details.is_cancelled', 0)->count();

		$new_members = DB::table('users')->where('created_at', '>=', now()->subDays(7)->setTime(0, 0, 0)->toDateTimeString())->count();

		$low_stocks = DB::table('products')->join('product_variants', 'product_variants.products_id', '=', 'products.id')->join('product_inventory_by_vendor', 'product_inventory_by_vendor.vendor_id', '=', 'product_variants.id')->where('products.is_active', 1)->where('products.is_warranty_product', '!=', 1)->where('available_quantity', '<', '5')->count();

		$todays_order_query = DB::table('order_details')->whereDate('order_details.created_at', DB::raw('CURDATE()'))->join('orders', 'orders.id', '=', 'order_details.orders_id')->where('is_returned', 0)->join('product_variants', 'product_variants.id', '=', 'order_details.products_id')->where('order_details.is_cancelled', 0);

		$todays_order = $todays_order_query->select('orders.order_reference_number', 'order_details.quantity', 'order_details.sale_price', 'product_variants.name')->get();
		$todays_sale = 0;
		if(count($todays_order)>0)
		{
			foreach ($todays_order as $key => $order) {
				$todays_sale = $todays_sale+ $order->sale_price;
			}
		}

		$weekly_sales = DB::table('order_details')->select(DB::raw('SUM(`sale_price`) AS sale_price'), DB::raw('DATE(`order_details`.`created_at`) AS order_date'))->join('orders', 'orders.id', '=', 'order_details.orders_id')->where('order_details.created_at', '>=', now()->subDays(7)->setTime(0, 0, 0)->toDateTimeString())->where('is_returned', 0)->where('order_details.is_cancelled', 0)->groupBy('order_date')->get();

		$last_7_days = $this->get7DaysDates(7);
		$sales = [];
		foreach($last_7_days as $key=> $day)
		{
			$sales[$key] = 0;
			foreach ($weekly_sales as $sale) {
				if($day == $sale->order_date)
					$sales[$key] = $sale->sale_price;
			}
		}
		$sales = json_encode($sales);

		return view('admin.dashboard', ['pending_orders'=>$pending_orders, 'pending_return_requests'=>$pending_return_requests, 'new_members'=>$new_members, 'low_stocks'=>$low_stocks, 'todays_order'=>$todays_order, 'sales'=>$sales, 'todays_sale'=>$todays_sale]);
	}


	public function get7DaysDates($days, $format = 'Y-m-d'){
	    $m = date("m"); 
	    $de= date("d"); 
	    $y= date("Y");
	    $dateArray = array();
	    for($i=0; $i<=$days-1; $i++){
	        $dateArray[] = date($format, mktime(0,0,0,$m,($de-$i),$y)); 
	    }
	    return array_reverse($dateArray);
	}

	public function login()
	{
		if(Auth::user())
		{
			if(Auth::user()->hasRole('Admin'))
				return Redirect::to('admin/dashboard');
			else
				return Redirect::to('account/dashboard');
		}
		else{
			return view('admin.login');
		}
	}

}
