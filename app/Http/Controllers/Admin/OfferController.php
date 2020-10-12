<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image;
use Activation as Act;
use App\Models\Offers;
use App\Models\Offers\OfferPriceProducts;
use App\Models\Offers\OfferComboProducts;
use App\Models\Offers\OfferComboFreeProducts;
use App\Models\Offers\OfferCategories;
use App\Models\Offers\OfferGroups;
use App\Models\Products;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Reqst;

class OfferController extends BaseController
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

        $this->model = new Offers;

        $this->route .= '.offers';
        $this->views .= '.offers';
        $this->url = "admin/offers/";

        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'offer_name', 'type', 'validity_start_date', 'validity_end_date', 'is_active', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('updated_at', function($obj) { return date('m/d/Y H:i:s', strtotime($obj->updated_at)); })
            ->editColumn('is_active', function($obj) use ($route) {
                $id =  $obj->id;
                if($obj->is_active)
                    return '<a href="' . url('admin/offers/change-status', [$id]) . '" class="btn btn-success btn-sm btn-warning-popup" data-message="Are you sure, want to disable this offer?"><i class="fa fa-check-circle"></i></a>';
                else
                   return '<a href="' . url('admin/offers/change-status', [$id]) . '" class="btn btn-danger btn-sm btn-warning-popup" data-message="Are you sure, want to enable this offer?"><i class="fa fa-times-circle"></i></a>'; 
            })
            ->editColumn('validity_start_date', function($obj) { return date('m/d/Y', strtotime($obj->validity_start_date)); })
            ->editColumn('validity_end_date', function($obj) { return date('m/d/Y', strtotime($obj->validity_end_date)); })
            ->rawColumns(['is_active', 'action_edit', 'action_delete']);
    }


    public function ajax_list(Reqst $r)
    {
        $data = $r->all();
        $products_query = DB::table('product_variants')->join('products', 'products.id', '=', 'product_variants.products_id')->select('product_variants.id', 'product_variants.name as product_name')->where('products.is_active', 1)->where('products.is_completed', 1)->whereNull('products.deleted_at')->whereNull('product_variants.deleted_at');
        if(isset($data['category']) && $data['category'])
        {
            $products_query->whereIn('products.category_id', $data['category']);
        }
        if(isset($data['brand']) && $data['brand'])
        {
            $products_query->whereIn('products.brand_id', $data['brand']);
        }
        if(isset($data['keyword']) && $data['keyword']!='')
        {
            $products_query->where('product_variants.name', 'like', '%'.$data['keyword'].'%');
        }
        $selected_items = [];
        if(isset($data['selected_item']) && $data['selected_item'])
        {
            $selected_items = $data['selected_item'];
        }
        $all_selected = isset($data['select_all'])?$data['select_all']:null;
        $products = $products_query->whereNull('products.deleted_at')->paginate(10);
        $products = $products->setPath(url('admin/offers/ajax-list'));
        return view($this->views . '.ajax_list')->with('products', $products)->with('selected_items', $selected_items)->with('all_selected', $all_selected);
    }

    public function create()
    {
        $products = DB::table('product_variants')->select('product_variants.id', 'name as product_name')->join('products', 'products.id', '=', 'product_variants.products_id')->where('products.is_active', 1)->where('products.is_completed', 1)->whereNull('product_variants.deleted_at')->whereNull('products.deleted_at')->paginate(10);
        $products = $products->setPath(url('admin/offers/ajax-list'));
        return view($this->views . '.form')->with('obj', $this->model)->with('products', $products);
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            if($obj->type == 'Price')
            {
                $offer_price = OfferPriceProducts::where('offers_id', $obj->id)->get();
                $obj->offer_price = $offer_price;
            }
            else{
                $offer_products = OfferComboProducts::where('offers_id', $obj->id)->get();
                $obj->offer_products = $offer_products;
            }
            $products = DB::table('product_variants')->select('product_variants.id', 'name as product_name')->join('products', 'products.id', '=', 'product_variants.products_id')->where('products.is_active', 1)->where('products.is_completed', 1)->whereNull('product_variants.deleted_at')->whereNull('products.deleted_at')->paginate(10);
            $products = $products->setPath(url('admin/offers/ajax-list'));
            return view($this->views . '.form')->with('obj', $obj)->with('products', $products);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store(Reqst $r)
    {
        /*Validator::extend('discount_type_required', function ($attribute, $value, $parameters) {
            preg_match('#<a[\s]+([^>]+)>((?:.(?!\<\/a\>))*.)</a>#',$value,$a);
            if($a)
                return false;
            else
            {
                $bHasLink = strpos($value, 'http') !== false || strpos($value, 'www.') !== false;
                if($bHasLink)
                    return false;
                else
                    return true;
            }
        });*/

        $data = $r->all();
        $validator = Validator::make($data, [
            'offer_name' => 'required|max:250',
            'type' => 'required',
            'validity_start_date' => 'required',
            'validity_end_date' => 'required',
            /*'discount_type' => 'max:10',
            'amount' => 'max:10',
            'percentage' => 'max:500',
            'combo_products[]' => 'max:500',
            'free_products[]' => 'max:500',*/

        ]);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator->errors()->all());
        }
        else
        {
            $data['discount_type'] = $data['amount'] = $data['percentage'] = $data['min_purchase_amount'] = $data['max_discount_amount'] = null;
            $data['applicable_for_full_order'] = 0;
            $data['slug'] = $this->create_slug($data['offer_name']);
            $data['validity_start_date'] = date('Y-m-d H:i:s', strtotime($data['validity_start_date']));
            $data['validity_end_date'] = date('Y-m-d H:i:s', strtotime($data['validity_end_date']));
            switch ($data['type']) {
                case 'Price':
                    $data['discount_type'] = $data['price_discount_type'];
                    if($data['price_discount_type'] == "Discount Price")
                        $data['amount'] = $data['price_amount'];
                    else
                        $data['percentage'] = $data['price_percentage'];
                    $data['min_purchase_amount'] = $data['price_min_purchase_amount'];
                    $data['max_discount_amount'] = $data['price_max_discount_amount'];
                    if($data['price_offer_applicable_to'] == "All Products")
                        $data['applicable_for_full_order'] = 1;
                    break;
                
                case 'Combo':
                    if($data['combo_offer_type'] == "Price")
                    {
                        $data['discount_type'] = $data['combo_discount_type'];
                        if($data['combo_discount_type'] == "Discount Price")
                            $data['amount'] = $data['combo_amount'];
                        else
                            $data['percentage'] = $data['combo_percentage'];
                        $data['max_discount_amount'] = $data['combo_max_discount_amount'];
                    }
                    break;
                case 'Group':
                    if($data['group_offer_type'] == "Price")
                    {
                        $data['discount_type'] = $data['group_discount_type'];
                        if($data['group_discount_type'] == "Discount Price")
                            $data['amount'] = $data['group_amount'];
                        else
                            $data['percentage'] = $data['group_percentage'];
                        $data['max_discount_amount'] = $data['group_max_discount_amount'];
                    }
                    break;
                case 'Free':
                    if($data['free_offer_applicable_to'] == "All Products")
                        $data['applicable_for_full_order'] = 1;
                    break;
            }
            $this->model->fill($data);
            if($this->model->save())
            {
                $id = $this->model->id;
                switch ($data['type']) {
                    case 'Price':
                        if($data['price_offer_applicable_to'] == "Categories")
                        {
                            foreach ($data['price_categories'] as $key => $category) {
                                $categories = new OfferCategories;
                                $categories->categories_id = $category;
                                $categories->offers_id = $id;
                                $categories->save();
                            }
                        }
                        elseif ($data['price_offer_applicable_to'] == "Products") {
                            foreach ($data['offer_products'] as $key => $product) {
                                $new_product = new OfferPriceProducts;
                                $new_product->products_id = $product;
                                $new_product->offers_id = $id;
                                $new_product->save();
                            }
                        }
                        break;
                    
                    case 'Combo':
                        if(isset($data['offer_products']))
                            foreach ($data['offer_products'] as $key => $product) {
                                $new_product = new OfferComboProducts;
                                $new_product->products_id = $product;
                                $new_product->offers_id = $id;
                                $new_product->save();
                            }
                        if(isset($data['combo_offer_type']))
                            if($data['combo_offer_type'] == "Another Product")
                            {
                                foreach ($data['combo_free_products'] as $key => $combo_product) {
                                    $new_product = new OfferComboFreeProducts;
                                    $new_product->products_id = $combo_product;
                                    $new_product->offers_id = $id;
                                    $new_product->max_discount_amount = $data['free_max_discount_amount'][$key];
                                    if(isset($data['free'][$key]))
                                        $new_product->type = 'Free';
                                    else
                                    {
                                        $new_product->type = $data['free_discount_type'][$key];
                                        if($data['free_discount_type'][$key] == "Discount Percentage")
                                            $new_product->discount_percentage = $data['free_discount_percentage'][$key];
                                        elseif($data['free_discount_type'][$key] == "Fixed Price")
                                            $new_product->fixed_price = $data['free_discount_amount'][$key];
                                        elseif($data['free_discount_type'][$key] == "Discount Price")
                                            $new_product->discount_amount = $data['free_discount_amount'][$key];
                                    }
                                    $new_product->save();
                                }
                            }
                        break;

                    case 'Group':
                        $group = new OfferGroups;
                        $group->groups_id = $data['groups_id'];
                        $group->offers_id = $id;
                        $group->how_many_to_buy = $data['how_many_to_buy'];
                        if(isset($data['group_offer_type']) == "Another Product")
                            $group->how_many_to_get_free = $data['how_many_to_get_free'];
                        $group->save();
                        break;

                    case 'Free':
                        if($data['free_offer_applicable_to'] == "Categories")
                        {
                            foreach ($data['free_categories'] as $key => $category) {
                                $categories = new OfferCategories;
                                $categories->categories_id = $category;
                                $categories->offers_id = $id;
                                $categories->save();
                            }
                        }
                        if(isset($data['offer_products']))
                            foreach ($data['offer_products'] as $key => $product) {
                                $new_product = new OfferComboProducts;
                                $new_product->products_id = $product;
                                $new_product->offers_id = $id;
                                $new_product->save();
                            }
                        if(isset($data['free_products']))
                            foreach ($data['free_products'] as $key => $free_product) {
                                $free = new OfferComboFreeProducts;
                                $free->products_id = $free_product;
                                $free->offers_id = $id;
                                $free->type = 'Free';
                                $free->save();
                            }
                        break;
                }
            }
            return Redirect::to(url('admin/offers/edit', array('id'=>encrypt($id))))->withSuccess('Offer details successfully saved!'); 
        } 
    }

    function saveOfferCategories($categories, $offer_id)
    {
        foreach ($categories as $key => $category) {
            $offer_category = new OfferCategories;
            $offer_category->categories_id = $category;
            $offer_category->offers_id = $offer_id;
            $offer_category->save();
        }
        return true;
    }

    function saveComboOffer($products, $offer_id)
    {
        foreach ($products as $key => $product) {
            $combo_offer = new OfferComboProducts;
            $combo_offer->products_id = $product;
            $combo_offer->offers_id = $offer_id;
            $combo_offer->save();
        }
        return true;
    }

    function saveFreeProducts($data, $offer_id)
    {
        foreach ($data['free_products'] as $key => $product) {
            $free = new OfferComboFreeProducts;
            $free->products_id = $product;
            $free->offers_id = $offer_id;
            $free->type = $data['combo_discount_type'];
            $free->save();
        }
        return true;
    }

    public function update(Reqst $r)
    {
        $data = $r->all();
        $id = decrypt($data['id']);
        $validator = Validator::make($data, [
            'offer_name' => 'required|max:250',
            'type' => 'required',
            'validity_start_date' => 'required',
            'validity_end_date' => 'required',
        ]);
        $data['slug'] = $this->create_slug($data['offer_name']);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator->errors()->all());
        }
        else
        {
            if($obj = $this->model->find($id)){
                //print_r($data);exit;

                $data['discount_type'] = $data['amount'] = $data['percentage'] = $data['min_purchase_amount'] = $data['max_discount_amount'] = null;
                $data['applicable_for_full_order'] = 0;
                $data['validity_start_date'] = date('Y-m-d H:i:s', strtotime($data['validity_start_date']));
                $data['validity_end_date'] = date('Y-m-d H:i:s', strtotime($data['validity_end_date']));
                switch ($data['type']) {
                    case 'Price':
                        $data['discount_type'] = $data['price_discount_type'];
                        if($data['price_discount_type'] == "Discount Price")
                            $data['amount'] = $data['price_amount'];
                        else
                            $data['percentage'] = $data['price_percentage'];
                        $data['min_purchase_amount'] = $data['price_min_purchase_amount'];
                        $data['max_discount_amount'] = $data['price_max_discount_amount'];
                        if($data['price_offer_applicable_to'] == "All Products")
                            $data['applicable_for_full_order'] = 1;
                        break;
                    
                    case 'Combo':
                        if($data['combo_offer_type'] == "Price")
                        {
                            $data['discount_type'] = $data['combo_discount_type'];
                            if($data['combo_discount_type'] == "Discount Price")
                                $data['amount'] = $data['combo_amount'];
                            else
                                $data['percentage'] = $data['combo_percentage'];
                            $data['max_discount_amount'] = $data['combo_max_discount_amount'];
                        }
                        break;
                    case 'Group':
                        if($data['group_offer_type'] == "Price")
                        {
                            $data['discount_type'] = $data['group_discount_type'];
                            if($data['group_discount_type'] == "Discount Price")
                                $data['amount'] = $data['group_amount'];
                            else
                                $data['percentage'] = $data['group_percentage'];
                            $data['max_discount_amount'] = $data['group_max_discount_amount'];
                        }
                        else{
                            $data['discount_type'] = null;
                            $data['amount'] = null;
                            $data['percentage'] = null;
                            $data['max_discount_amount'] = null;
                        }
                        break;
                    case 'Free':
                        if($data['free_offer_applicable_to'] == "All Products")
                            $data['applicable_for_full_order'] = 1;
                        break;
                }
                if($obj->update($data))
                {
                    OfferCategories::where('offers_id', $id)->delete();
                    OfferCategories::where('offers_id', $id)->delete();
                    OfferComboProducts::where('offers_id', $id)->delete();
                    OfferComboFreeProducts::where('offers_id', $id)->delete();
                    OfferGroups::where('offers_id', $id)->delete();
                    switch ($data['type']) {
                        case 'Price':
                            if($data['price_offer_applicable_to'] == "Categories")
                            {
                                foreach ($data['price_categories'] as $key => $category) {
                                    $categories = new OfferCategories;
                                    $categories->categories_id = $category;
                                    $categories->offers_id = $id;
                                    $categories->save();
                                }
                            }
                            elseif ($data['price_offer_applicable_to'] == "Products") {
                                foreach ($data['offer_products'] as $key => $product) {
                                    $new_product = new OfferPriceProducts;
                                    $new_product->products_id = $product;
                                    $new_product->offers_id = $id;
                                    $new_product->save();
                                }
                            }
                            break;
                        
                        case 'Combo':
                            if(isset($data['offer_products']))
                                foreach ($data['offer_products'] as $key => $product) {
                                    $new_product = new OfferComboProducts;
                                    $new_product->products_id = $product;
                                    $new_product->offers_id = $id;
                                    $new_product->save();
                                }
                            if($data['combo_offer_type'] == "Another Product")
                            {
                                if(isset($data['combo_free_products']))
                                    foreach ($data['combo_free_products'] as $key => $combo_product) {
                                        $new_product = new OfferComboFreeProducts;
                                        $new_product->products_id = $combo_product;
                                        $new_product->offers_id = $id;
                                        $new_product->max_discount_amount = $data['free_max_discount_amount'][$key];
                                        if(isset($data['free'][$key]))
                                            $new_product->type = 'Free';
                                        else
                                        {
                                            $new_product->type = $data['free_discount_type'][$key];
                                            if($data['free_discount_type'][$key] == "Discount Percentage")
                                                $new_product->discount_percentage = $data['free_discount_percentage'][$key];
                                            elseif($data['free_discount_type'][$key] == "Fixed Price")
                                                $new_product->fixed_price = $data['free_discount_amount'][$key];
                                            elseif($data['free_discount_type'][$key] == "Discount Price")
                                                $new_product->discount_amount = $data['free_discount_amount'][$key];
                                        }
                                        $new_product->save();
                                    }
                            }
                            break;

                        case 'Group':
                            $group = new OfferGroups;
                            $group->groups_id = $data['groups_id'];
                            $group->offers_id = $id;
                            $group->how_many_to_buy = $data['how_many_to_buy'];
                            if(isset($data['group_offer_type']) && $data['group_offer_type'] == "Another Product")
                                $group->how_many_to_get_free = $data['how_many_to_get_free'];
                            else
                                $group->how_many_to_get_free = null;
                            $group->save();
                            break;

                        case 'Free':
                            if($data['free_offer_applicable_to'] == "Categories")
                            {
                                foreach ($data['free_categories'] as $key => $category) {
                                    $categories = new OfferCategories;
                                    $categories->categories_id = $category;
                                    $categories->offers_id = $id;
                                    $categories->save();
                                }
                            }
                            
                            if(isset($data['offer_products']))
                                foreach ($data['offer_products'] as $key => $product) {
                                    $new_product = new OfferComboProducts;
                                    $new_product->products_id = $product;
                                    $new_product->offers_id = $id;
                                    $new_product->save();
                                }
                            if(isset($data['free_products']))
                                foreach ($data['free_products'] as $key => $free_product) {
                                    $free = new OfferComboFreeProducts;
                                    $free->products_id = $free_product;
                                    $free->offers_id = $id;
                                    $free->type = 'Free';
                                    $free->save();
                                }
                            break;
                    }
                }
                return Redirect::to(url('admin/offers/edit', array('id'=>encrypt($id))))->withSuccess('Offer details successfully saved!'); 
            } else {
                return Redirect::back()
                        ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                        ->withInput(Input::all());
            }
        }
    }

    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->delete();
            return response()->json(['success'=>'User successfully deleted']);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

    public function changeStatus($id)
    {
        $obj = $this->model->find($id);
        if ($obj) {
            $status = ($obj->is_active == 1)?0:1;
            $message = ($obj->is_active == 1)?'disabled':'enabled';
            $obj->is_active = $status;
            $obj->save();
            return response()->json(['success'=>'User successfully '.$message]);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

}
