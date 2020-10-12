<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Branch;
use App\Models\District;
use App\Models\States;
use App\Models\BranchLandmark;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use View;


class BranchController extends BaseController
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Branch;

        $this->route .= '.branch';
        $this->views .= '.branch';
        $this->url = "admin/branch";
        $this->breadcrumbs = 'branch';
        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'slug' ,'branch_name', 'updated_at');
    }



    public function home(Request $request, $parent=null){
        if ($request->ajax()) {
            $collection = $this->getCollection();
            $parent_id = null;
            if($parent)
                $parent_id = $parent;
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
        $districts = District::all();
        $states = States::all();
        $locations = null;
        $obj->district_id = null;
        return view('admin.branch.form',['obj'=>$obj,'states'=>$states ,'districts'=>$districts, 'locations'=>$locations]);
    }


    public function edit($id){
        if($obj = $this->model->find(decrypt($id))){
            $districts = District::all();
            $states = States::all();

            return view($this->views . '.form',['obj' => $obj,'states'=>$states, 'districts'=>$districts]);
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
        if(isset($data['landmark_id']))
        {
            $location = $data['landmark_id'];
            if(!is_numeric($location))
            {
                $new_landmark = new BranchLandmark;
                $new_landmark->landmark = $location;
                $new_landmark->district_id = $data['district_id'];
                $new_landmark->save();
                $data['landmark_id'] = $new_landmark->id;
            }
        }
        $data['sunday_open'] = isset($data['sunday_open'])?1:0;
        $data['opening_time'] = date('H:i:s', strtotime($data['opening_time']));
        $data['closing_time'] = date('H:i:s', strtotime($data['closing_time']));
        $this->model->fill($data);
        $this->model->save();

        return redirect(route($this->route.'.edit', ['id' => encrypt($this->model->id)]))
            ->withSuccess("branch updated succesfully");
    }

    public function update(Request $request){
        $this->model->validate(Input::all(), decrypt($request->id));
        $data = Input::all();
        if($obj = $this->model->find(decrypt($request->id))) {
            if(isset($data['landmark_id']))
            {
                $location = $data['landmark_id'];
                if(!is_numeric($location))
                {
                    $new_landmark = new BranchLandmark;
                    $new_landmark->landmark = $location;
                    $new_landmark->district_id = $data['district_id'];
                    $new_landmark->save();
                    $data['landmark_id'] = $new_landmark->id;
                }
            }
            $data['sunday_open'] = isset($data['sunday_open'])?1:0;
            $data['opening_time'] = date('H:i:s', strtotime($data['opening_time']));
            $data['closing_time'] = date('H:i:s', strtotime($data['closing_time']));
            $obj->update($data);
            $obj->save();
        }
        return Redirect::back()
            ->withSuccess("branch updated succesfully") // send back all errors to the login form
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
