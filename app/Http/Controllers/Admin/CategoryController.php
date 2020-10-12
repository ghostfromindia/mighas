<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Key;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Input;
use View,Redirect, DB;
use App\Http\Controllers\Admin\Common\ImageController as Image;

use App\Models\Products;
use App\Models\Category\CategoryAttributes;
use App\Models\Products\Attributes;
use App\Models\Category\CategoryAttributeValues;

use App\Imports\CategoriesImports;
use App\Exports\CategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends BaseController
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Category;
        $this->route .= '.category';
        $this->views .= '.category';
        $this->url = "admin/category/";
        $this->resourceConstruct();

    }
    protected function getCollection() {
        return $this->model->select('id', 'slug', 'category_name', 'browser_title', 'meta_keywords', 'updated_at');
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



    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete']);
    }

    public function category_select2(Request $r){
        return $this->select2('slug',Input::get('q'),'category_name');
    }

    public function create(){
        $obj = $this->model;
        return view($this->views.'.form',['obj'=>$obj]);
    }

    public function edit($id){
        if($obj = $this->model->find(decrypt($id))){
            return view($this->views . '.form',['obj' => $obj]);
        } else {
            return $this->redirect('notfound');
        }
    }


    public function save(Request $request){
        $this->model->validate();
        $data = Input::all();
        $data['parent_category_id'] = (!$data['parent_category_id'])?0:$data['parent_category_id'];
        $this->model->fill($data);
        $this->model->save();
        

        return redirect(route($this->route.'.edit', ['id' => encrypt($this->model->id)]))
            ->withSuccess("Category created succesfully");
        // send back all errors to the login form;
    }

    public function update(Request $request){
        $this->model->validate(Input::all(), decrypt($request->id));
        $data = Input::all();
        if($obj = $this->model->find(decrypt($request->id))) {
            $data['parent_category_id'] = (!$data['parent_category_id'])?0:$data['parent_category_id'];
            $obj->update($data);
            $obj->save();
        }
//        $category = Key::get('category-type');
//        $types = explode(',',$category);
//
//        foreach ($types as $o){
//            $this->setKey($obj->id.'-'.$o,$request->{$o.'_description'},'text');
//        }
//
//        foreach ($types as $o){
//            $this->setKey($obj->id.'-img-'.$o,$request->{$o.'_img'},'image');
//        }
//
//        $o = 'POPULAR';
//        $this->setKey($obj->id.'-'.$o,$request->{$o.'_description'},'text');
//        $this->setKey($obj->id.'-img-'.$o,$request->{$o.'_img'},'image');



        return Redirect::back()
            ->withSuccess("Category updated succesfully") // send back all errors to the login form
            ->withInput(Input::all());
    }

    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $check_products = Products::where('category_id', $id)->count();
            if($check_products >0)
                return redirect()->back()->withError('This category is in use!');
            else
            {
                $check_menu = DB::table('menu_items')->where('menu_type', 'category_link')->where('linkable_id', $id)->first();
                if($check_menu)
                    return redirect()->back()->withError('This category is in use!');
            }
            $obj->delete();
            return $this->redirect('removed', 'success', 'home');
        }
        
        return $this->redirect('notfound');
    }

    public function export()
    {
        return Excel::download(new CategoriesExport, 'categories.xlsx');
    }

        public function import()
    {
        return view($this->views . '.import');
    }

    public function import_save(Request $request)
    {
        ini_set('max_execution_time', '0');
        $this->validate($request, [
          'excel_file'  => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('excel_file')->getRealPath();
        $rows = Excel::toArray(new CategoriesImports, $path, null, \Maatwebsite\Excel\Excel::XLSX)[0];
        foreach ($rows as $key => $value) {
            $product = Products::where('product_code', $value['code'])->first();
            $this->update_attribute($product, $value['attibute_1_name'], $value['attibute_1_value']);
            $this->update_attribute($product, $value['attibute_2_name'], $value['attibute_2_value']);
            $this->update_attribute($product, $value['attibute_3_name'], $value['attibute_3_value']);
        }
        return redirect()->back()->withSuccess('Excel successfully imported!');
    }

    public function update_attribute($product, $attribute_name, $attribute_value)
    {
        $check_attribute_exist = CategoryAttributes::where('category_id', $product->category_id)->where('attribute_name', $attribute_name)->first();
        if(!$check_attribute_exist)
            $check_attribute_exist = new CategoryAttributes;
        $check_attribute_exist->category_id = $product->category_id;
        $check_attribute_exist->attribute_name = $attribute_name;
        $check_attribute_exist->attribute_type = 'Selectable';
        $check_attribute_exist->group_id = 1;
        if($check_attribute_exist->save())
        {
            $check_attribute_value_exist = CategoryAttributeValues::where('attribute_id', $check_attribute_exist->id)->where('value', $attribute_value)->first();
            if(!$check_attribute_value_exist)
            {
                $check_attribute_value_exist = new CategoryAttributeValues;
                $check_attribute_value_exist->attribute_id = $check_attribute_exist->id;
                $check_attribute_value_exist->value = $attribute_value;
                $check_attribute_value_exist->save();
            }
            $check_product_attribute = Attributes::where('products_id', $product->id)->where('attribute_id', $check_attribute_exist->id)->first();
            if(!$check_product_attribute)
            {
                $check_product_attribute = new Attributes;
                $check_product_attribute->products_id = $product->id;
                $check_product_attribute->attribute_id = $check_attribute_exist->id;
            }
            $check_product_attribute->attribute_value_id = $check_attribute_value_exist->id;
            $check_product_attribute->attribute_value = $attribute_value;
            $check_product_attribute->save();
        }
        return true;
    }

    public function remove_brochure($slug){
            $category = Category::find(decrypt($slug));
            $category->brochure_pdf = null;
            $category->save();
    }


}
