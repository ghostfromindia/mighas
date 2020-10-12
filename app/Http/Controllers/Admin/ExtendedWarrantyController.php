<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use App\Models\ExtendedWarranty, Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Reqst;
use App\Models\Products;
use App\Models\Products\Variants;
use App\Models\Products\Variants\Inventory;

class ExtendedWarrantyController extends BaseController
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

        $this->model = new ExtendedWarranty;

        $this->route .= '.extended-warranty';
        $this->views .= '.extended_warranty';
        $this->url = "admin/extended-warranty/";

        $this->resourceConstruct();

    }

    protected function getCollection() {
        $collection = DB::table('extended_warranties')->select('extended_warranties.id', 'products.product_name', 'extended_warranties.warranty_price', 'extended_warranties.status', 'extended_warranties.year', 'categories.category_name', 'extended_warranties.updated_at')->join('products', 'extended_warranties.products_id', '=', 'products.id')->join('categories', 'products.category_id', '=', 'categories.id')->whereNull('extended_warranties.deleted_at');

        return $collection; 
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('year', function($obj) { 
                 
                $year = $obj->year .'Year';
                $year .= ($obj->year >1)?'s':'';
                return $year;
            })
            ->editColumn('updated_at', function($obj) { return date('m/d/Y H:i:s', strtotime($obj->updated_at)); })
            ->editColumn('status', function($obj) use ($route) {
                if($obj->status == 1)
                    return '<a href="' . route( $route . '.change-status',  [encrypt($obj->id), $obj->status] ) . '" class="btn btn-success btn-sm" ><i class="fa fa-times-circle"></i></a>';
                else
                    return '<a href="' . route( $route . '.change-status',  [encrypt($obj->id), $obj->status] ) . '" class="btn btn-danger btn-sm" ><i class="fa fa-check-circle"></i></a>';
            })
            ->rawColumns(['status', 'action_edit', 'action_delete']);
    }

    public function create()
    {

        return view($this->views . '.form')->with('obj', $this->model);
    }

    public function edit($id, $tab=null) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            return view($this->views . '.form')->with('obj', $obj);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store(Reqst $r)
    {
        $data = $r->all();
        $this->model->validate();
        $product = new Products;
        $product->category_id = $data['category_id'];
        $product->product_name = $data['product_name'];
        $product->slug = $product->createCode($data['product_name']);
        $product->summary = $data['summary'];
        $product->page_heading = $data['product_name'];
        $product->is_warranty_product = 1;
        if($product->save())
        {
            $varient_data = ['name'=>$product->product_name, 'slug'=>$product->slug, 'products_id'=>$product->id, 'is_default'=>1];
            $varient = new Variants;
            $varient->fill($varient_data);
            if($varient->save())
            {
                $inventory_data = ['retail_price'=>$data['sale_price'], 'sale_price'=>$data['sale_price'], 'landing_price'=>$data['sale_price'], 'quantity'=>'1000000'];
                $inventrory = new Inventory;
                $inventrory->saveVariantByInventory($varient->id, $inventory_data);

                $warranty_data = ['products_id'=>$varient->id, 'warranty_price'=>$data['sale_price'], 'year'=>$data['year'], 'start_price'=>$data['start_price'], 'end_price'=>$data['end_price'], 'category_id'=>$data['category_id'],'title'=>$data['product_name']];
                $this->model->fill($warranty_data);
                $this->model->save();
            }
        }
        return Redirect::to(url('admin/extended-warranty/edit', array('id'=>encrypt($this->model->id))))->withSuccess('Warranty successfully saved!'); 
    }

    public function update(Reqst $r)
    {
        $data = $r->all();
        $id = decrypt($data['id']);
        $this->model->validate($data, $id);
        if($obj = $this->model->find($id)){

            $varient = Variants::find($obj->products_id);
            $varient->name = $data['product_name'];
            if($varient->save())
            {
                $product = Products::find($varient->products_id);
                $product->category_id = $data['category_id'];
                $product->product_name = $data['product_name'];
                $product->summary = $data['summary'];
                $product->save();

                $inventory_data = ['retail_price'=>$data['sale_price'], 'sale_price'=>$data['sale_price'], 'landing_price'=>$data['sale_price'], 'quantity'=>'1000000'];
                $inventrory = new Inventory;
                $inventrory->saveVariantByInventory($varient->id, $inventory_data);

                $warranty_data = ['products_id'=>$varient->id, 'warranty_price'=>$data['sale_price'], 'year'=>$data['year'], 'start_price'=>$data['start_price'], 'end_price'=>$data['end_price'], 'category_id'=>$data['category_id'], 'title'=>$data['product_name']];
                $obj->update($warranty_data);
            }

            return Redirect::to(url('admin/extended-warranty/edit', array('id'=>encrypt($obj->id))))->withSuccess('Warranty details successfully updated!');
        } else {
            return Redirect::back()
                        ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                        ->withInput(Input::all());
        }
    }

    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->delete();
            return response()->json(['success'=>'Warranty successfully deleted']);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

}
