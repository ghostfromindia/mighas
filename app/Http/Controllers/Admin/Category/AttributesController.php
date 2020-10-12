<?php namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image, URL;
use App\Models\Category\CategoryAttributes;
use App\Models\Category\CategoryAttributeGroups;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Reqst;
use App\Models\Category\CategoryAttributeValues;

class AttributesController extends BaseController
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

        $this->model = new CategoryAttributes;

        $this->route .= '.category.attribute';
        $this->views .= '.category.attributes';
        $this->url = "admin/category/attributes/";

        $this->resourceConstruct();

    }

    public function index(Reqst $request, $category_id=null)
    {
        if ($request->ajax()) {
            $collection = $this->getCollection();
            if($category_id)
                $collection->where('product_cateory_attributes.category_id', '=', $category_id);
            return $this->setDTData($collection)->make(true);
        } else {
            return view::make($this->views . '.index', array('category_id'=>$category_id));
        }
    }

    protected function getCollection() {
        $collection = DB::table('product_cateory_attributes')->select('product_cateory_attributes.id', 'product_cateory_attribute_groups.group_name' ,'product_cateory_attributes.attribute_name', 'product_cateory_attributes.show_as_variant', 'product_cateory_attributes.updated_at', DB::raw("COUNT(product_cateory_attribute_values.id) AS value_count"))->leftJoin('product_cateory_attribute_groups', 'product_cateory_attribute_groups.id', '=', 'product_cateory_attributes.group_id')->leftJoin('product_cateory_attribute_values', 'product_cateory_attribute_values.attribute_id', '=', 'product_cateory_attributes.id')->groupBy('product_cateory_attributes.id');

        return $collection; 
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('show_as_variant', function($obj) {
                switch ($obj->show_as_variant) {
                    case '1':
                        $variant = "Level1";
                        break;
                    case '2':
                        $variant = "Level2";
                        break;
                    case '3':
                        $variant = "Level3";
                        break;
                    default:
                        $variant = "None";
                        break;
                }
                return $variant;
            })
            ->editColumn('value_count', function($obj) {
                $values = CategoryAttributeValues::where('attribute_id', $obj->id)->pluck('value')->toArray();
                $output = "";
                foreach ($values as $key => $value) {
                    $output .= '<span class="badge badge-light">'.$value.'</span>';
                }
                return $output;
            })
            ->addColumn('action_edit', function($obj) use ($route) { 
                return '<a href="' . route( $route . '.edit',  [encrypt($obj->id)] ) . '" class="btn btn-info btn-sm open-ajax-confirm" title="Update Attribute" ><i class="fa fa-edit"></i></a>'; 
            })
            ->filterColumn('value_count', function($query, $keyword) {
                $query->whereRaw("COUNT(product_cateory_attribute_values.id)", "=", $keyword);
            })
            ->rawColumns(['value', 'action_edit', 'action_delete', 'value_count']);
    }

    public function create($category_id=null)
    {
        return view($this->views . '.form')->with('obj', $this->model)->with('category_id', $category_id);
    }


    public function store(Reqst $r)
    {
        $data = $r->all();
        //print_r($data);exit;
        $this->model->validate();
        if($data['group_name'] != '')
        {
            $group = CategoryAttributeGroups::where('category_id', $data['category_id'])->where('group_name', $data['group_name'])->first();
            if(!$group)
            {
                $group = new CategoryAttributeGroups;
                $group->category_id = $data['category_id'];
                $group->group_name = $data['group_name'];
                $group->save();
            }
            $data['group_id'] = $group->id;
        }
        $this->model->fill($data);
        $this->model->save();
        $id = $this->model->id;
        if(isset($data['value']))
        {
            $this->saveValue($data, $id);
        }
        return response()->json(['success'=>'Category attribute successfully added.']);
    }

    public function update(Reqst $r)
    {
        $data = $r->all();
        $id = decrypt($data['id']);
        $this->model->validate($data, $id);
        if($obj = $this->model->find($id)){
            if($data['group_name'] != '')
            {
                $group = CategoryAttributeGroups::firstOrCreate(
                    ['group_name' => $data['group_name'], 'category_id'=>$data['category_id']]);

                $data['group_id'] = $group->id;
            }
            $obj->update($data);
            if($obj->attribute_type == 'Running Text')
            {
                CategoryAttributeValues::where('attribute_id', $id)->delete();
            }
            else{
                if($obj->values)
                {
                    foreach ($obj->values as $key => $value) {
                        $editValue = CategoryAttributeValues::find($value->id);
                        if(isset($data['value_edit'][$value->id]))
                        {
                            $editValue->value = $data['value_edit'][$value->id];
                            $editValue->save();
                        }
                        else
                            $editValue->delete();
                    }
                }
                if(isset($data['value']))
                {
                    $this->saveValue($data, $id);
                }
            }
            return response()->json(['success'=>'Category attribute successfully updated.']);
        } else {
            return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
        }
    }

    public function saveValue($data, $id)
    {
        if(isset($data['value']))
        {
            foreach ($data['value'] as $key => $value) {
                if($value != '')
                {
                    $checkExist = DB::table('product_cateory_attribute_values')->join('product_cateory_attributes', 'product_cateory_attribute_values.attribute_id', '=', 'product_cateory_attributes.id')->where('product_cateory_attribute_values.value', $value)->where('product_cateory_attribute_values.attribute_id', $id)->count();
                    if($checkExist == 0)
                    {
                        $attrValue = new CategoryAttributeValues;
                        $attrValue->attribute_id = $id;
                        $attrValue->value = $value;
                        $attrValue->save();
                    }
                }
            }
        }
        return true;
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
