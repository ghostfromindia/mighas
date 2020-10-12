<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use App\Models\Roles, Input, View, Redirect, DB, Datatables, Carbon;
use Helper;
use App\Models\Permissions;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

class RolesController extends BaseController
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

        $this->model = new Roles;

        $this->route .= '.roles';
        $this->views .= '.roles';
        $this->url = "admin/roles/";

        $this->resourceConstruct();

    }


    protected function getCollection() {
        return $this->model->select('id', 'name', 'status', 'created_at', 'updated_at');
        
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
        $permissions = Permissions::get();
        return view($this->views . '.form')->with('obj', $this->model)->with('permissions', $permissions);
    }

    public function edit($id) {
        if($obj = $this->model->find($id)){
            $permissions = Permissions::get();
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all();

            return view($this->views . '.form')->with('obj', $obj)->with('permissions', $permissions)->with('rolePermissions', $rolePermissions);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store()
    {
        $this->model->validate();
        $data = Input::all();
        $role = Role::create(['name' => $data['name']]);
        //$role->syncPermissions($data['permission']);
        return Redirect::to(url('admin/roles/edit', ['id'=>$role->id]))->withSuccess('Role successfully added!');
    }

    public function update($id)
    {
        $this->model->validate(Input::all(), $id);
        if($role = Role::find($id)){
            $data = Input::all();
            $role->name = $data['name'];
            $role->save();
            //$role->syncPermissions($data['permission']);
            return Redirect::to(url('admin/roles/edit', ['id'=>$id]))->withSuccess('Role successfully updated!');
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
