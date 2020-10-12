<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Image, Redirect;
use App\Models\Products;
use App\Models\Products\Variants;
use App\Models\Products\Variants\Inventory;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Orders;
use App\Models\Orders\OrderDetails;
use App\Models\Orders\OrderTracking;
use App\Models\Orders\OrderStatusLabel;

class WingsApiController extends Controller
{

    public function index(Request $request)
    {
        $params = $_GET;
        $data = $request->all();

        DB::table('api_calls')->insert(
            ['params' => json_encode($params), 'data' => json_encode($data)]
        );

        if($params['api_type'] == 'get_token')
        {
            if($data['username'] == 'pittappillil' && $data['password'] == 'b980d9ea654e7c142a29')
                $this->get_token();
            else
                $this->sendError('Invalid credentials', null, '603');
        }
        else{
            if(isset($params['api_type']) && isset($params['api_token']))
            {
                $current_token = $this->get_token(1);
                if($current_token == $params['api_token'])
                {
                    if($params['api_type'] == 'save_products')
                        $this->save_products($data);
                    elseif($params['api_type'] == 'update_price')
                        $this->update_price($data);
                    elseif($params['api_type'] == 'update_stock')
                        $this->update_stock($data);
                    elseif($params['api_type'] == 'fetch_orders')
                        $this->fetch_orders($data);
                    elseif($params['api_type'] == 'update_order_status')
                        $this->update_order_status($data);
                    elseif($params['api_type'] == 'cancelled_orders')
                        $this->get_cancelled_orders($data);
                }
                else
                    $this->sendError('Token mismatch', null, '602');
            }
            else
                $this->sendError('Missing parameters', null, '601');
            
        }

    }
    
    public function get_token($verify = null)
    {
        $date = new \DateTime();
        $date->modify('-24 hours');
        $date_from = $date->format('Y-m-d H:i:s');

        $cur_date = new \DateTime();
        $date_to = $cur_date->format('Y-m-d H:i:s');

        $token = DB::table('api_tokens')->whereBetween('created_at', [$date_from, $date_to])->where('status', 1)->first();
        if($token)
        {
            if($verify)
                return $token->token;
            else
                $this->sendResponse('api_token', $token->token, 'Token successfully generated');
        }
        else{
            $str = rand(); 
            $new_token = hash("sha256", $str);

            DB::table('api_tokens')
                ->where('status', 1)
                ->update(['status' => 0]);

            $id = DB::table('api_tokens')->insertGetId(
                ['token' => $new_token]
            );
            if($id)
            {
                if($verify)
                    return $new_token;
                else
                    $this->sendResponse('api_token', $new_token, 'Token successfully generated');
            }
            else
                $this->sendError('Oops..something went wrong, please try again', null, '600');
        }
    }

    public function save_products($data)
    {
        if(isset($data['products']) && count($data['products'])>0)
        {
            $products = $data['products'];
            $response = [];
            foreach($products as $product)
            {
                if($product['is_new'] == 1)
                {
                    $save_product = Products::where('product_code', $product['product_code'])->first();
                    if($save_product)
                    {
                        $response[$product['product_code']]['status'] = "Failed";
                        $response[$product['product_code']]['code'] = "301";
                        $response[$product['product_code']]['message'] = "Duplicate product";
                        continue;
                    }
                    else
                    {
                        $save_product = new Products;
                        $save_product->slug = $product['product_code'];
                        $save_product->page_heading = $product['product_name'];
                    }
                }
                else
                {
                    $save_product = Products::where('product_code', $product['product_code'])->first();
                    if(!$save_product)
                    {
                        $response[$product['product_code']]['status'] = "Failed";
                        $response[$product['product_code']]['code'] = "302";
                        $response[$product['product_code']]['message'] = "Trying to update not existing product";
                        continue;
                    }
                }

                $category_id = 0;
                if(isset($product['category_code']))
                {
                    $category = Category::where('category_code', $product['category_code'])->first();
                    if($category)
                        $category_id = $category->id;
                    else{
                        $category = new Category;
                        $category->category_code = $product['category_code'];
                        $category->category_name = $product['category_code'];
                        $category->slug = $product['category_code'];
                        $category->status = 0;
                        $category->save();
                        $category_id = $category->id;
                    }
                }

                $brand_id = null;
                if(isset($product['brand_code']))
                {
                    $brand = Brand::where('brand_code', $product['brand_code'])->first();
                    if($brand)
                        $brand_id = $brand->id;
                    else{
                        $brand = new Brand;
                        $brand->brand_code = $product['brand_code'];
                        $brand->brand_name = $product['brand_code'];
                        $brand->slug = $product['brand_code'];
                        $brand->status = 0;
                        $brand->save();
                        $brand_id = $brand->id;
                    }
                }

                $save_product->brand_id = $brand_id;
                $save_product->category_id = $category_id;
                $save_product->product_name = $product['product_name'];
                $save_product->product_code = $product['product_code'];
                $save_product->summary = $product['description'];
                $save_product->hsn_code = $product['hsn_code'];
                $save_product->cgst = $product['cgst'];
                $save_product->sgst = $product['sgst'];
                $save_product->igst = $product['igst'];
                
                if($save_product->save())
                {
                    if($product['is_new'] == 1)
                    {
                        $varient_data = ['name'=>$product['product_name'], 'slug'=>$product['product_code'], 'products_id'=>$save_product->id, 'is_default'=>1];
                        $varient = new Variants;
                        $varient->fill($varient_data);
                        if($varient->save())
                        {
                            $response[$product['product_code']]['status'] = "Success";
                            $response[$product['product_code']]['code'] = "200";
                            $response[$product['product_code']]['message'] = "Product successfully saved";
                        }
                        else
                        {
                            $response[$product['product_code']]['status'] = "Failed";
                            $response[$product['product_code']]['code'] = "304";
                            $response[$product['product_code']]['message'] = "Product variant not saved";
                            continue;
                        }
                    }
                    else
                    {
                        $response[$product['product_code']]['status'] = "Success";
                        $response[$product['product_code']]['code'] = "200";
                        $response[$product['product_code']]['message'] = "Product successfully updated";
                    }
                }
                else{
                    $response[$product['product_code']]['status'] = "Failed";
                    $response[$product['product_code']]['code'] = "303";
                    $response[$product['product_code']]['message'] = "Product not saved";
                    continue;
                }
            }
            return response()->json($response, 200);
        }
        else{
            $this->sendError('Invalid product data', null, '102');
        }
    }

    public function update_price($data)
    {
        $response = [];
        if(isset($data['api_type']))
            unset($data['api_type']);
        if(isset($data['api_token']))
            unset($data['api_token']);
        foreach ($data as $key => $price) {
            $inventory_data = DB::table('products')->select('product_variants.id AS variant_id', 'product_inventory_by_vendor.id AS inventory_id')->join('product_variants', function($join) {
                $join->on('products.id', '=', 'product_variants.products_id');
                $join->where('product_variants.is_default', '=', 1);
            })->Leftjoin('product_inventory_by_vendor', 'product_inventory_by_vendor.variant_id', '=', 'product_variants.id')->where('products.product_code', $key)->where('products.use_psp', 0)->first();

            if($inventory_data)
            {
                if(!$inventory_data->inventory_id)
                    $inventrory = new Inventory;
                else
                {
                    $inventrory = Inventory::find($inventory_data->inventory_id);
                    DB::table('product_price_history')->insert(
                        ['inventory_id' => $inventrory->id, 'retail_price' =>$inventrory->retail_price , 'sale_price'=>$inventrory->sale_price]
                    );
                }

                $inventrory->vendor_id = 1;
                $inventrory->variant_id = $inventory_data->variant_id;
                $inventrory->retail_price = $price['retail_price'];
                $inventrory->sale_price = $price['sale_price'];
                if($inventrory->save())
                {
                    $response[$key]['status'] = "Success";
                    $response[$key]['code'] = "200";
                    $response[$key]['message'] = "Price successfully updated";
                }
                else{
                    $response[$key]['status'] = "Failed";
                    $response[$key]['code'] = "600";
                    $response[$key]['message'] = "Unknown error";
                }
            }
            else
            {
                $response[$key]['status'] = "Failed";
                $response[$key]['code'] = "401";
                $response[$key]['message'] = "Product not found or product may not have price change permission";
                continue;
            }
        }
        print_r(json_encode($response));
        return response()->json($response, 200);
    }

    public function update_stock($data)
    {
        $response = [];
        if(isset($data['api_type']))
            unset($data['api_type']);
        if(isset($data['api_token']))
            unset($data['api_token']);
        foreach ($data as $key => $stock) {
            $inventory_data = DB::table('products')->select('products.product_code','product_variants.id AS variant_id', 'product_inventory_by_vendor.id AS inventory_id')->join('product_variants', function($join){
                $join->on('products.id', '=', 'product_variants.products_id');
                $join->where('product_variants.is_default', '=', 1);
            })->Leftjoin('product_inventory_by_vendor', 'product_inventory_by_vendor.variant_id', '=', 'product_variants.id')->where('products.product_code', $key)->first();

            if($inventory_data)
            {
                if(!$inventory_data->inventory_id)
                {
                    $inventrory = new Inventory;
                    $inventrory->available_quantity = intval($stock);
                }
                else
                {
                    $inventrory = Inventory::find($inventory_data->inventory_id);
                    DB::table('product_stock_history')->insert(
                        ['inventory_id' => $inventrory->id, 'last_stock' =>$inventrory->available_quantity , 'added_stock'=>intval($stock)]
                    );
                    $inventrory->available_quantity = $inventrory->available_quantity + (intval($stock));
                }

                $inventrory->vendor_id = 1;
                $inventrory->variant_id = $inventory_data->variant_id;
                if($inventrory->save())
                {
                    $response[$key]['status'] = "Success";
                    $response[$key]['code'] = "200";
                    $response[$key]['message'] = "Stock successfully updated";
                }
                else{
                    $response[$key]['status'] = "Failed";
                    $response[$key]['code'] = "600";
                    $response[$key]['message'] = "Unknown error";
                }
            }
            else
            {
                $response[$key]['status'] = "Failed";
                $response[$key]['code'] = "401";
                $response[$key]['message'] = "Product not found";
                continue;
            }

        }
        print_r(json_encode($response));
        return response()->json($response, 200);
    }

    public function update_order_status($data)
    {
        $response = [];
        foreach ($data as $key => $status) {
            $order = Orders::find($key);
            $status_id = $this->get_order_id_from_name($status);
            if(isset($order->details) && count($order->details)>0)
            {
                foreach ($order->details as $key1 => $item) {
                    $order_item = OrderDetails::find($item->id);
                    $statuses = OrderStatusLabel::where('type', 'N')->orderBy('display_order', 'DESC')->where('id', '>', $order_item->status)->where('id', '<=', $status_id)->get();
                    if($statuses);
                    {
                        foreach ($statuses as $key2 => $status) {
                            $tracking = new OrderTracking;
                            $tracking->order_details_id = $order_item->id;
                            $tracking->order_status_labels_master_id = $status->id;
                            $tracking->save();
                        }

                        $order_item->status = $status_id;
                        $order_item->save();
                    }

                }

                $response[$key]['status'] = "Success";
                $response[$key]['code'] = "200";
                $response[$key]['message'] = "Order status successfully updated";
            }
        }
        print_r(json_encode($response));
        return response()->json($response, 200);
    }

    public function get_order_id_from_name($name)
    {
        return DB::table('order_status_labels_master')->where('name', $name)->where('type', 'N')->value('id');
    }

    public function fetch_orders($data)
    {
        if(isset($data['created_date']))
        {
            $created_date = date('Y-m-d H:i:s', strtotime($data['created_date']));
            $orders = Orders::select('id', 'transaction_id', 'order_reference_number', 'total_mrp', 'total_discount', 'total_sale_price', 'payment_method', 'payment_status', 'delivery_address_id')->with(['details' => function($query) {
                return  $query->select(['order_details.id AS item_id', 'orders_id', 'products.product_code', 'order_details.mrp AS retail_price', 'order_details.quantity', 'order_details.sale_price', 'order_details.discount', 'order_details.is_cancelled'])->join('product_variants', 'product_variants.id', '=', 'order_details.products_id')->join('products', 'products.id', '=', 'product_variants.products_id');
            }, 'delivery_address' => function($query) {
                return $query->select(['id','full_name', 'mobile_number', 'address1', 'address2', 'landmark', 'city', 'state', 'pincode']);
            }])
            ->whereDate('created_at', '>=', $created_date)->get();

            print_r(json_encode($orders));
            return response()->json($orders, 200);
        }
        else{
            $this->sendError('Missing parameters', null, '601');
        }
    }
    
    public function get_cancelled_orders($data)
    {
        if(isset($data['created_date']))
        {
            $created_date = date('Y-m-d H:i:s', strtotime($data['created_date']));
            $orders = Orders::select('id', 'transaction_id', 'order_reference_number', 'total_mrp', 'total_discount', 'total_sale_price', 'payment_method', 'payment_status')->with(['details' => function($query) {
                return  $query->select(['order_details.id AS item_id', 'orders_id', 'products.product_code', 'order_details.mrp AS retail_price', 'order_details.quantity', 'order_details.sale_price', 'order_details.discount', 'order_details.cancelled_reason'])->join('product_variants', 'product_variants.id', '=', 'order_details.products_id')->join('products', 'products.id', '=', 'product_variants.products_id');
            }])->whereHas('details', function($query){
                $query->where('order_details.is_cancelled',1);
            })
            ->whereDate('created_at', '>=', $created_date)->get();

            print_r(json_encode($orders));
            return response()->json($orders, 200);
        }
        else{
            $this->sendError('Missing parameters', null, '601');
        }
    }

    public function sendResponse($key, $result, $message){
        $response = ['success' => true, $key => $result, 'message' => $message];
        print_r($response);
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404){
        $response = ['success' => false, 'message' => $error];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        print_r($response);
        return response()->json($response);
    }

}
