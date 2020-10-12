<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use App\User, Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image;
use Activation as Act;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Reqst;

class CustomerController extends BaseController
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

        $this->model = new User;

        $this->route .= '.customers';
        $this->views .= '.customers';
        $this->url = "admin/customers/";

        $this->resourceConstruct();

    }

    protected function getCollection() {
        $collection = DB::table('users')->select('users.id', 'users.email', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name"), 'users.banned_at', 'users.created_at', 'users.updated_at', "users.username AS phone")->join('role_users', 'users.id', '=', 'role_users.user_id')->where('role_users.role_id', 2)->whereNull('deleted_at');

        return $collection; 
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('updated_at', function($obj) { return date('m/d/Y H:i:s', strtotime($obj->updated_at)); })
            ->editColumn('banned_at', function($obj) use ($route) {
                $id =  $obj->id;
                if($obj->banned_at)
                    return '<a href="' . url('admin/users/change-status', [$id]) . '" class="btn btn-danger btn-sm btn-warning-popup" data-message="Are you sure, want to enable this user?"><i class="fa fa-times-circle"></i></a>';
                else
                   return '<a href="' . url('admin/users/change-status', [$id]) . '" class="btn btn-success btn-sm btn-warning-popup" data-message="Are you sure, want to disable this user?"><i class="fa fa-check-circle"></i></a>'; 
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('phone', function($query, $keyword) {
                $query->whereRaw("CONCAT(users.country_code, ' ', users.phone_number) like ?", ["%{$keyword}%"]);
            })
            ->rawColumns(['banned_at', 'action_edit', 'action_delete']);
    }

    public function create()
    {
        $roles = Roles::get();
        return view($this->views . '.form')->with('obj', $this->model)->with('roles', $roles);
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $roles = Roles::get();
            if($obj->banned_at)
                $obj->status = 0;
            else
                $obj->status = 1;
            return view($this->views . '.form')->with('obj', $obj)->with('roles', $roles);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store(Reqst $r)
    {
        $data = $r->all();
        //print_r($data);exit;
        $validator = Validator::make($data, [
            'first_name' => 'required|max:250',
            'last_name' => 'required|max:250',
            'email' => 'required|email|unique:users,email|max:250',
            'password' => 'required|same:password_confirmation',
            'phone_number' => 'required|unique:users,username|max:10',

        ]);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator->errors()->all());
        }
        else
        {
            $data['username'] = $data['phone_number'];
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);
            $user->assignRole(['2']);

            return Redirect::to(url('admin/customers/edit', array('id'=>encrypt($user->id))))->withSuccess('User details successfully saved!'); 
        } 
    }

    public function update(Reqst $r)
    {
        $data = $r->all();
        $id = decrypt($data['id']);
        $validator = Validator::make($data, [
            'first_name' => 'required|max:250',
            'last_name' => 'required|max:250',
            'email' => 'required|email|max:250|unique:users,email,'.$id,
            'password' => 'nullable|same:password_confirmation',
            'phone_number' => 'required|max:10|unique:users,username,'.$id,
        ]);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator->errors()->all());
        }
        else
        {
            if($obj = $this->model->find($id)){
                $data['username'] = $data['phone_number'];
                if($data['password'] != '')
                    $data['password'] = Hash::make($data['password']);
                else
                    unset($data['password']);

                $obj->update($data);

                return Redirect::to(url('admin/customers/edit', array('id'=>encrypt($obj->id))))->withSuccess('User details successfully updated!');
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
        //$id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            if($obj->banned_at)
            {
                $obj->banned_at = null;
                $message = 'enabled';
            }
            else
            {
                $obj->banned_at = date('Y-m-d H:i:s');
                $message = 'disabled';
            }
            $obj->save();
            return response()->json(['success'=>'User successfully '.$message]);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

}
