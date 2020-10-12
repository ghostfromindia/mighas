<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Vendor;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use View;


class VendorController extends BaseController
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Vendor;

        $this->route .= '.vendor';
        $this->views .= '.vendor';
        $this->url = "admin/vendor/";
        $this->breadcrumbs = 'vendor';

        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'slug' ,'vendor_name','contact_name');
    }

    public function index(){
        $obj = $this->model;
        return view('admin.vendor.home',['obj'=>$obj]);
    }


    public function home(Request $request, $parent=null){
        if ($request->ajax()) {
            $collection = $this->getCollection();
            $parent_id = null;
            if($parent)
                $parent_id = $parent;
//            $collection->where('categories.parent_category_id', '=', $parent_id);
            $route = $this->route;
            return $this->setDTData($collection)->make(true);
        } else {
            $parent_data = null;
            if($parent)
                $parent_data = $this->model->find($parent);
            return view::make($this->views . '.home', ['parent'=>$parent, 'parent_data'=>$parent_data]);
        }
    }


    public function create(){
        $obj = $this->model;
        return view('admin.vendor.form',['obj'=>$obj]);
    }


    public function edit($id){
        if($obj = $this->model->find(decrypt($id))){
            return view($this->views . '.form',['obj' => $obj]);
        } else {
            return $this->redirect('notfound');
        }
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete']);
    }

    public function save(Request $request){
        $this->model->validate();
        $data = Input::all();
        $this->model->fill($data);
        $this->model->save();

        return redirect(route($this->route.'.edit', ['id' => encrypt($this->model->id)]))
            ->withSuccess("Vendor updated succesfully");
    }

    public function update(Request $request){
        $this->model->validate(Input::all(), decrypt($request->id));
        $data = Input::all();
        if($obj = $this->model->find(decrypt($request->id))) {
            $obj->update($data);
            $obj->save();
        }
        return Redirect::back()
            ->withSuccess("Vendor updated succesfully") // send back all errors to the login form
            ->withInput(Input::all());
    }

    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->delete();
            return $this->redirect('removed', 'success', 'home');
        }
        
        return $this->redirect('notfound');
    }

}
