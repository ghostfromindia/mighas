<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use App\Models\Groups, Input, View, Redirect, DB, Datatables, Carbon;
use App\Models\GroupProducts;
use Helper;

use Illuminate\Http\Request;

class GroupsController extends BaseController
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

        $this->model = new Groups;

        $this->route .= '.groups';
        $this->views .= '.groups';
        $this->url = "admin/groups/";

        $this->resourceConstruct();

    }


    protected function getCollection() {
        return $this->model->select('id', 'group_name', 'status', 'created_at', 'updated_at');
        
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('status', function($obj) use ($route) {
                if($obj->status == 1)
                    return '<a href="' . route( $route . '.change-status',  [$obj->id, $obj->status] ) . '" class="btn btn-success btn-sm" ><i class="fa fa-times-circle"></i></a>';
                else
                    return '<a href="' . route( $route . '.change-status',  [$obj->id, $obj->status] ) . '" class="btn btn-danger btn-sm" ><i class="fa fa-check-circle"></i></a>';
            })
            ->editColumn('updated_at', function($obj) { return date('m/d/Y H:i:s', strtotime($obj->updated_at)); })
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    public function create()
    {
        $products = DB::table('product_variants')->select('product_variants.id', 'name as product_name')->join('products', 'products.id', '=', 'product_variants.products_id')->where('products.is_active', 1)->where('products.is_completed', 1)->whereNull('product_variants.deleted_at')->whereNull('products.deleted_at')->paginate(10);
        $products = $products->setPath(url('admin/offers/ajax-list'));
        return view($this->views . '.form')->with('obj', $this->model)->with('products', $products);
    }

    public function edit($id) {
        $id =  decrypt($id);
        if($obj = $this->model->find($id)){
            $products = DB::table('product_variants')->select('product_variants.id', 'name as product_name')->join('products', 'products.id', '=', 'product_variants.products_id')->where('products.is_active', 1)->where('products.is_completed', 1)->whereNull('product_variants.deleted_at')->whereNull('products.deleted_at')->paginate(10);
            $products = $products->setPath(url('admin/offers/ajax-list'));

            return view($this->views . '.form')->with('obj', $obj)->with('products', $products);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store()
    {
        $this->model->validate();
        $data = Input::all();
        $this->model->fill($data);
        if($this->model->save())
        {
            if(isset($data['offer_products']))
            {
                foreach ($data['offer_products'] as $key => $product) {
                    $group_product = new GroupProducts;
                    $group_product->groups_id = $this->model->id;
                    $group_product->products_id = $product;
                    $group_product->save();
                } 
            }
        }
        return Redirect::to(url('admin/groups/edit', ['id'=>encrypt($this->model->id)]))->withSuccess('Group successfully added!');
    }

    public function update()
    {
        $data = Input::all();
        $id = decrypt($data['id']);
        $this->model->validate(Input::all(), $id);
        if($obj = $this->model->find($id)){
            
            $obj->group_name = $data['group_name'];
            if($obj->save())
            {
                if(isset($data['offer_products']))
                {
                    GroupProducts::where('groups_id', $id)->delete();
                    foreach ($data['offer_products'] as $key => $product) {
                        $group_product = new GroupProducts;
                        $group_product->groups_id = $obj->id;
                        $group_product->products_id = $product;
                        $group_product->save();
                    } 
                }
            }
            return Redirect::to(url('admin/groups/edit', ['id'=>encrypt($id)]))->withSuccess('Group successfully updated!');
        } else {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(Input::all());
        }
    }

    public function checkCodeExist()
    {
        /* RECEIVED VALUE */
         $id = $_REQUEST['id'];
         $code = $_REQUEST['name'];
         
         $where = "name='".$code."'";
         if($id)
            $where .= " AND id != ".$id;
         $resuts = $this->model->whereRaw($where)->get();
         
         if (count($resuts)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

}
