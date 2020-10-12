<?php namespace App\Http\Controllers\Admin\Category\Attribute;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image, URL;
use App\Models\Category\CategoryAttributeGroups;
use App\Models\Category\CategoryAttributes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Reqst;

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

        $this->model = new CategoryAttributeGroups;

        $this->route .= '.category.attribute.groups';
        $this->views .= '.category.attributes.groups';
        $this->url = "admin/category/attribute/groups";

        $this->resourceConstruct();

    }

    public function index(Reqst $request, $category_id=null)
    {
        if ($request->ajax()) {
            $collection = $this->getCollection();
            if($category_id)
                $collection->where('category_id', '=', $category_id);
            return $this->setDTData($collection)->make(true);
        } else {
            return view::make($this->views . '.index', array('category_id'=>$category_id));
        }
    }

    protected function getCollection() {
        return $this->model->select('id', 'group_name', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->addColumn('action_edit', function($obj) use ($route) { 
                return '<a href="' . route( $route . '.edit',  [encrypt($obj->id)] ) . '" class="btn btn-info btn-sm open-ajax-confirm" title="Update Value" ><i class="fa fa-edit"></i></a>'; 
            })
            ->rawColumns(['action_edit', 'action_delete']);
    }

    public function create($category_id=null)
    {
        return view($this->views . '.form')->with('obj', $this->model)->with('category_id', $category_id);
    }


    public function store(Reqst $r)
    {
        $data = $r->all();
        $this->model->validate();
        $this->model->fill($data);
        $this->model->save();
        return response()->json(['success'=>'Attribute group successfully added.']);
    }

    public function update(Reqst $r)
    {
        $data = $r->all();
        $id = decrypt($data['id']);
        $this->model->validate($data, $id);
        if($obj = $this->model->find($id)){
            $obj->update($data);
            return response()->json(['success'=>'Attribute group successfully updated.']);
        } else {
            return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
        }
    }

    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->delete();
            return response()->json(['success'=>'Attribute group successfully deleted']);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

}
