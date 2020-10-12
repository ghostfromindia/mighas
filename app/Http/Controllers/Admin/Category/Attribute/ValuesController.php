<?php namespace App\Http\Controllers\Admin\Category\Attribute;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image, URL;
use App\Models\Category\CategoryAttributeValues;
use App\Models\Category\CategoryAttributes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Reqst;

class ValuesController extends BaseController
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

        $this->model = new CategoryAttributeValues;

        $this->route .= '.category.attribute.value';
        $this->views .= '.category.attributes.values';
        $this->url = "admin/category/attribute/values";

        $this->resourceConstruct();

    }

    public function index(Request $request, $attribute)
    {
        $attribute = CategoryAttributes::find(decrypt($attribute));
        if(!$attribute)
            return $this->redirect('notfound');

        if (Request::ajax()) {
            $collection = $this->getCollection();
            $collection->where('attribute_id', '=', $attribute->id);
            return $this->setDTData($collection)->make(true);
        } else {
            return view($this->views . '.index')->with('attribute', $attribute);
        }
    }

    protected function getCollection() {
        return $this->model->select('id', 'value' ,'value_slug', 'updated_at'); 
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('show_as_variant', function($obj) {
                return ($obj->show_as_variant == 0)?'No':'Yes';
            })
            ->editColumn('value_count', function($obj) {
                return '<a href="" class="btn btn-success btn-sm" title="Update Attribute" >'.$obj->value_count.'</a>';
            })
            ->addColumn('action_edit', function($obj) use ($route) { 
                return '<a href="' . route( $route . '.edit',  [encrypt($obj->id)] ) . '" class="btn btn-info btn-sm open-ajax-confirm" title="Update Value" ><i class="fa fa-edit"></i></a>'; 
            })
            ->filterColumn('value_count', function($query, $keyword) {
                $query->whereRaw("COUNT(product_cateory_attribute_values.id)", "=", $keyword);
            })
            ->rawColumns(['value', 'action_edit', 'action_delete', 'value_count']);
    }

    public function create($attribute)
    {
        $attribute = CategoryAttributes::find(decrypt($attribute));
        if(!$attribute)
            return $this->redirect('notfound');
        else
            return view::make($this->views . '.form', array('obj'=>$this->model, 'attribute'=>$attribute));
    }


    public function edit($id) {
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
        $data['attribute_id'] = decrypt($data['attribute_id']);
        $this->model->fill($data);
        $this->model->save();
        return response()->json(['success'=>'Attribute value successfully added.']);
    }

    public function update(Reqst $r)
    {
        $data = $r->all();
        $id = decrypt($data['id']);
        $this->model->validate($data, $id);
        if($obj = $this->model->find($id)){
            $obj->update($data);
            return response()->json(['success'=>'Attribute value successfully updated.']);
        } else {
            return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
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
