<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use App\Models\Products, Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Reqst;
use App\Models\Products\Variants;
use App\Models\Products\Variants\Images AS ImageVariants;
use App\Models\Category\CategoryAttributes;
use App\Models\Products\Attributes;
use App\Models\Category\CategoryAttributeValues;
use App\Models\Products\Variants\Inventory;
use App\Exports\ProductsExport;
use App\Imports\ProductsImports;
use App\Imports\ProductsAttributesImports;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Category;
use App\Models\Brand;

class ProductsController extends BaseController
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

        $this->model = new Products;

        $this->route .= '.products';
        $this->views .= '.products';
        $this->url = "admin/products/";

        $this->resourceConstruct();

    }

    protected function getCollection() {
        $collection = DB::table('products')->select('products.id', 'products.product_name', 'products.page_heading', 'products.is_active', 'products.is_completed', 'categories.category_name', 'products.use_psp', 'products.updated_at', 'product_variants.offer_status', 'product_variants.id AS variant_id')->join('product_variants', 'product_variants.products_id', '=', 'products.id')->join('categories', 'products.category_id', '=', 'categories.id')->where('is_warranty_product', 0)->whereNull('products.deleted_at');

        return $collection; 
    }
    
    
     public function no_stock_switch($type){
        $invent =  Inventory::where('available_quantity','<=',0)->get();
        $i=0;
        $status ='';
        if($type == 'hide'){ $status ='disabled';
            foreach ($invent as $obj){

                $variant = Variants::find($obj->variant_id);
                if($variant){
                    $product = Products::find($variant->products_id);
                }

                if($product){
                    $product->is_active = 0;
                    $product->save();
                    $i++;

                }else{
                    echo $variant;
                }

            }
        }elseif($type == 'show'){ $status ='enabled';
            foreach ($invent as $obj){
                $variant = Variants::find($obj->variant_id);
                if($variant){
                    $product = Products::find($variant->products_id);
                }

                if($product){
                    $product->is_active = 1;
                    $product->save();
                    $i++;
                }else{
                    echo $variant;
                }
            }
        }
        session()->flash('status', 'Task was successful! '.count($invent).' products '.$status);
        return redirect('admin/dashboard');

    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('updated_at', function($obj) { return date('m/d/Y H:i:s', strtotime($obj->updated_at)); })
            ->editColumn('is_active', function($obj) {
                if($obj->is_active)
                    return '<span><i class="fa fa-check-circle text-success"></i></span>';
                else
                    return '<span><i class="fa fa-times-circle text-danger"></i></span>';
            })
            ->editColumn('use_psp', function($obj) use ($route) {
                $id =  $obj->id;
                if($obj->use_psp == 0)
                    return '<a href="' . url('admin/products/set-psp-as-price', [encrypt($id)]) . '" class="btn btn-danger"><i class="fa fa-times"></i></a>';
                else
                   return '<a href="' . url('admin/products/set-psp-as-price', [encrypt($id)]) . '" class="btn btn-success" ><i class="fa fa-check"></i></a>'; 
            })
            ->editColumn('offer_status', function($obj) use ($route) {
                $id =  $obj->variant_id;
                if($obj->offer_status == 0)
                    return '<a href="' . url('admin/products/variants/change-offer-status', [encrypt($id)]) . '" class="btn btn-danger"><i class="fa fa-times"></i></a>';
                else
                   return '<a href="' . url('admin/products/variants/change-offer-status', [encrypt($id)]) . '" class="btn btn-success" ><i class="fa fa-check"></i></a>'; 
            })
            ->setRowClass(function ($obj) {
                    return ($obj->is_completed==0 ? 'bg-warning' : ' ');
            })
            ->rawColumns(['is_active', 'action_edit', 'action_delete', 'use_psp', 'offer_status']);
    }

    public function create()
    {
        $gallery = [];
        $varient = new Variants;
        return view($this->views . '.form')->with('obj', $this->model)->with('gallery', $gallery)->with('varient', $varient);
    }

    public function edit($id, $tab=null) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $varients = Variants::where('products_id', $obj->id)->count();

            $parent_varient = Variants::where('products_id', $obj->id)->orderBy('id', 'asc')->first();
            $parent_variant_id = $parent_varient->id;
            $gallery = $this->getVariantGallery($parent_variant_id);

            $attributes = CategoryAttributes::where('category_id', $obj->category_id)->where('show_as_variant', 0)->get();

            return view($this->views . '.edit')->with('obj', $obj)->with('gallery', $gallery)->with('varients', $varients)->with('attributes', $attributes)->with('tab', $tab)->with('parent_varient', $parent_varient);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store(Reqst $r)
    {
        $data = $r->all();
        $this->model->validate();
        $data['is_featured_in_home_page'] = isset($data['is_featured_in_home_page'])?1:0;
        $data['is_featured_in_category'] = isset($data['is_featured_in_category'])?1:0;
        $data['is_new'] = isset($data['is_new'])?1:0;
        $data['is_top_seller'] = isset($data['is_top_seller'])?1:0;
        $data['is_today_deal'] = isset($data['is_today_deal'])?1:0;
        $this->model->fill($data);
        if($this->model->save())
        {
            $varient_data = ['name'=>$data['product_name'], 'slug'=>$data['slug'], 'products_id'=>$this->model->id, 'is_default'=>1];
            $varient = new Variants;
            $varient->fill($varient_data);
            $varient->save();
        }
        return Redirect::to(url('admin/products/edit', array('id'=>encrypt($this->model->id))))->withSuccess('Products successfully saved!'); 
    }

    public function update(Reqst $r)
    {
        $data = $r->all();
        //print_r($data);exit;
        $id = decrypt($data['id']);
        $this->model->validate($data, $id);
        if($obj = $this->model->find($id)){
            
            $parent_varient = Variants::where('products_id', $obj->id)->orderBy('id', 'asc')->first();
            $parent_variant_id = $parent_varient->id;
            
            $data['is_featured_in_home_page'] = isset($data['is_featured_in_home_page'])?1:0;
            $data['is_featured_in_category'] = isset($data['is_featured_in_category'])?1:0;
            $data['is_new'] = isset($data['is_new'])?1:0;
            $data['is_top_seller'] = isset($data['is_top_seller'])?1:0;
            $data['is_today_deal'] = isset($data['is_today_deal'])?1:0;
            $data['offer_status'] = isset($data['offer_status'])?1:0;
            $data['combo_offer_status'] = isset($data['combo_offer_status'])?1:0;


                $data['mrp'] = isset($data['retail_price'])?$data['retail_price']:$parent_varient->inventory->retail_price;
                $data['sale_price'] = isset($data['sale_price'])?$data['sale_price']:$parent_varient->inventory->sale_price;
                $data['quantity'] = is_int((int)$data['quantity'])?(int)$data['quantity']:$parent_varient->inventory->quantity;



            if(isset($data['retail_price']) && $data['retail_price']!="" && isset($data['sale_price']) && $data['sale_price']!="" && isset($data['quantity']) && $data['quantity']!="" && isset($data['sku']) && $data['sku']!="")
                $data['is_completed'] = 1;
            $obj->update($data);

            $data['name'] = $data['product_name'];


                //$parent_varient->image_id = $data['image_id'];
//                if ($parent_varient->update($data)) {
//                    $inventrory = new Inventory;
//                    $inventrory->saveVariantByInventory($parent_varient->id, $data);
//                }


            Attributes::where('products_id', $obj->id)->delete();
            $attributes = CategoryAttributes::where('category_id', $obj->category_id)->get();
            foreach ($attributes as $key => $attribute) {
                if(isset($data['attribute_'.$attribute->id]))
                {
                    $product_attribute = new Attributes;
                    $product_attribute->products_id = $obj->id;
                    $product_attribute->attribute_id = $attribute->id;
                    
                    if($attribute->attribute_type == 'Selectable')
                    {
                        $product_attribute->attribute_value_id = $data['attribute_'.$attribute->id];
                        $selected_value = CategoryAttributeValues::find($data['attribute_'.$attribute->id]);
                        $product_attribute->attribute_value = $selected_value->value;
                    }
                    else{
                        $product_attribute->attribute_value = $data['attribute_'.$attribute->id];
                    }
                    $product_attribute->save();
                }
            }

            $this->saveGallery($parent_variant_id, $data, 'edit');

            return Redirect::to(url('admin/products/edit', array('id'=>encrypt($obj->id))))->withSuccess('Product details successfully updated!');
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
            return response()->json(['success'=>'Product successfully deleted']);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

    public function mediaSave(Reqst $r)
    {
        $data = $r->all();
        $files = $data['files'];
        $json = array(
            'files' => array()
        );
        foreach ($files as $key=> $file) {
            $upload = $this->uploadFile($file, $this->model->uploadPath['products'], ['Products']);
            if($upload['success']) {
                if(isset($data['related_type']) && $data['related_type']!='' && isset($data['related_id']) && $data['related_id']!='')
                {
                    $upload['related_type'] = $data['related_type'];
                    $upload['related_id'] = $data['related_id'];
                }
                $result = $this->saveMedia($upload);
                $json['files'][] = array(
                        'name' => $result['name'],
                        'size' => $result['size'],
                        'url' => \URL::to('').'/public/'.$result['url'],
                        'id' => $result['id'],
                        'original_file' => $result['original_file'],
                        'type' => $result['type'],
                );
            }
        }
        return response()->json($json);
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function import()
    {
        return view($this->views . '.import');
    }
    
    public function import_save2(Reqst $request)
    {
        ini_set('max_execution_time', '0');
        $this->validate($request, [
          'excel_file'  => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('excel_file')->getRealPath();
        $rows = Excel::toArray(new ProductsImports, $path, null, \Maatwebsite\Excel\Excel::XLSX)[0];
        foreach ($rows as $key => $product) {
            $save_product = Variants::where('slug', $product['product_as_in_wings'])->first();
            if($save_product)
            {
                $save_product->code = $product['code'];
                $save_product->save();
            }
        }
        return redirect()->back()->withSuccess('Excel successfully imported!');
    }
    
    public function import_save1(Reqst $request)
    {
        ini_set('max_execution_time', '0');
        $this->validate($request, [
          'excel_file'  => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('excel_file')->getRealPath();
        $rows = Excel::toArray(new ProductsImports, $path, null, \Maatwebsite\Excel\Excel::XLSX)[0];
        foreach ($rows as $key => $product) {
            $save_product = Products::where('product_code', $product['product_as_in_wings'])->first();
            if($save_product)
            {
                $save_product->meta_keywords = $product['focus_keyword'];
                $save_product->meta_description = $product['meta_description'];
                $save_product->browser_title = $product['meta_title'];
                $save_product->save();
            }
        }
        return redirect()->back()->withSuccess('Excel successfully imported!');
    }

    public function import_save(Reqst $request)
    {
        ini_set('max_execution_time', '0');
        $this->validate($request, [
          'excel_file'  => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('excel_file')->getRealPath();
        $rows = Excel::toArray(new ProductsImports, $path, null, \Maatwebsite\Excel\Excel::XLSX)[0];

        foreach ($rows as $key => $product) {
            if($product['product_code'] != '')
            {
                $save_product = Products::withTrashed()->where('product_name', $product['product_code'])->first();
                if(!$save_product)
                {
                    $save_product = new Products;
                    $save_product->product_code = $product['product_code'];
                    $save_product->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['product_code'])));
                }
                if($save_product)
                {
                    if($product['title']!='')
                        $save_product->page_heading = $product['title'];
                }
                else
                    $save_product->page_heading = ($product['title']!='')?$product['title']:$product['product_code'];
    
                $category_id = 0;
                if($product['category_name'] != '')
                {
                    $category = Category::where('category_name', $product['category_name'])->first();
                    if($category)
                    {
                        $category_id = $category->id;
                    }
                    else{
                        $category = new Category;
                        $category->category_code = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['category_name'])));
                        $category->category_name = $product['category_name'];
                        $category->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['category_name'])));
                        $category->status = 1;
                        $category->save();
                        $category_id = $category->id;
                    }
                    $save_product->category_id = $category_id;
                }
                $brand_id = null;
                if($product['brand_name'] != '')
                {
                    $brand = Brand::where('brand_name', $product['brand_name'])->first();
                    if($brand)
                        $brand_id = $brand->id;
                    else{
                        $brand = new Brand;
                        $brand->brand_code = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['brand_name'])));;
                        $brand->brand_name = $product['brand_name'];
                        $brand->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['brand_name'])));;
                        $brand->status = 1;
                        $brand->save();
                    }
                    $save_product->brand_id = $brand_id;
                }
                
                if($save_product)
                {
                    if($product['title']!='')
                        $save_product->product_name = $product['title'];
                    if($product['summary']!='')
                        $save_product->summary = $product['summary'];
                    if($product['description']!='')
                        $save_product->top_description = $product['description'];
                    if($product['hsn']!='')
                        $save_product->hsn_code = $product['hsn'];
                    if($product['cgst']!='')
                        $save_product->cgst = $product['cgst'];
                    if($product['sgst']!='')
                        $save_product->sgst = $product['sgst'];
                        
                    if(isset($product['browser_title']) && $product['browser_title']!='')
                        $save_product->browser_title = $product['browser_title'];
                    if(isset($product['meta_keywords']) && $product['meta_keywords']!='')
                        $save_product->meta_keywords = $product['meta_keywords'];
                    if(isset($product['meta_description']) && $product['meta_description']!='')
                        $save_product->meta_description = $product['meta_description'];
                }
                else
                {
                    $save_product->product_name = ($product['title']!='')?$product['title']:$product['product_code'];
                    $save_product->summary = $product['summary'];
                    $save_product->top_description = $product['description'];
                    $save_product->hsn_code = $product['hsn'];
                    $save_product->cgst = ($product['cgst']!='')?$product['cgst']:NULL;
                    $save_product->sgst = ($product['sgst']!='')?$product['sgst']:NULL;
                    $save_product->browser_title = (isset($product['browser_title']) && $product['browser_title']!='')?$product['browser_title']:NULL;
                    $save_product->meta_keywords = (isset($product['meta_keywords']) && $product['meta_keywords']!='')?$product['meta_keywords']:NULL;
                    $save_product->meta_description = (isset($product['meta_description']) && $product['meta_description']!='')?$product['meta_description']:NULL;
                }
                
                $save_product->is_active = 1;
                $save_product->is_completed = 1;
                $save_product->deleted_at = NULL;
                if($save_product->save())
                {
                    $varient = Variants::where('slug', $save_product->slug)->first();
                    if(!$varient)
                    {
                        $varient = new Variants;
                        $varient->slug = $save_product->slug;
                        $varient->products_id = $save_product->id;
                        $varient->is_default = 1;
                    }
                    $varient->name = $save_product->product_name;
                    if($varient->save())
                    {
                        $inventory_data = ['retail_price'=>$product['mrp'], 'sale_price'=>$product['sale_price'], 'landing_price'=>$product['mrp'], 'quantity'=>$product['stock']];
                        $inventrory = new Inventory;
                        $inventrory->saveVariantByInventory($varient->id, $inventory_data);
                    }
                }
            }
        }
        return redirect()->back()->withSuccess('Excel successfully imported!');
    }

    public function setPriceAsPsp($id)
    {
        $id =  decrypt($id);
        if($obj = $this->model->find($id))
        {
            $set_status = ($obj->use_psp == 1)?0:1;
            $obj->use_psp = $set_status;
            $obj->save();
            $message = ($obj->use_psp == 0)?"disabled":"enabled";
            return Redirect::route($this->route . '.index')->withSuccess($this->entity.' price successfully '.$message.'!');
        }

        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }
    
    public function browse_images($category=null)
    {
        $all_categories = Category::all();
        $products = null;
        if($category)
        {
            $products = Products::where('category_id', $category)->get();
        }
        return view($this->views . '.browse_images', ['all_categories'=>$all_categories, 'products'=>$products, 'category'=>$category]);
    }

    public function browse_images_save()
    {
        ini_set('max_execution_time', '0');
        $data = request()->all();
        foreach ($data['products'] as $key => $value) {
            $product = Variants::where('products_id', $value)->first();
            if($product)
            {
                if(isset($data['primary_image'][$key]))
                {
                    $primary_image = $this->uploadFile($data['primary_image'][$key], $this->model->uploadPath['products'], ['Products']);
                    if($primary_image['success'])
                    {
                        $primary_image['related_type'] = "Products";
                        $primary_image['related_id'] = $value;
                        $result = $this->saveMedia($primary_image);
                        $product->image_id = $result['id'];
                        $product->save();
                    }
                }
                if(isset($data['gallery1'][$key]))
                {
                    $gallery1 = $this->uploadFile($data['gallery1'][$key], $this->model->uploadPath['products'], ['Products']);
                    if($gallery1['success'])
                    {
                        $gallery1['related_type'] = "Products";
                        $gallery1['related_id'] = $value;
                        $result = $this->saveMedia($gallery1);
                        $gallery = new ImageVariants;
                        $gallery->variant_id = $product->id;
                        $gallery->image_id = $result['id'];
                        $gallery->save();
                    }
                }
                if(isset($data['gallery2'][$key]))
                {
                    $gallery2 = $this->uploadFile($data['gallery2'][$key], $this->model->uploadPath['products'], ['Products']);
                    if($gallery2['success'])
                    {
                        $gallery2['related_type'] = "Products";
                        $gallery2['related_id'] = $value;
                        $result = $this->saveMedia($gallery2);
                        $gallery = new ImageVariants;
                        $gallery->variant_id = $product->id;
                        $gallery->image_id = $result['id'];
                        $gallery->save();
                    }
                }
                if(isset($data['gallery3'][$key]))
                {
                    $gallery3 = $this->uploadFile($data['gallery3'][$key], $this->model->uploadPath['products'], ['Products']);
                    if($gallery3['success'])
                    {
                        $gallery3['related_type'] = "Products";
                        $gallery3['related_id'] = $value;
                        $result = $this->saveMedia($gallery3);
                        $gallery = new ImageVariants;
                        $gallery->variant_id = $product->id;
                        $gallery->image_id = $result['id'];
                        $gallery->save();
                    }
                }
                if(isset($data['gallery4'][$key]))
                {
                    $gallery4 = $this->uploadFile($data['gallery4'][$key], $this->model->uploadPath['products'], ['Products']);
                    if($gallery4['success'])
                    {
                        $gallery4['related_type'] = "Products";
                        $gallery4['related_id'] = $value;
                        $result = $this->saveMedia($gallery4);

                        $gallery = new ImageVariants;
                        $gallery->variant_id = $product->id;
                        $gallery->image_id = $result['id'];
                        $gallery->save();
                    }
                }
            }
        }
        return redirect()->back()->withSuccess('Images successfully imported!');
    }
    
    public function bulk_image_upload()
    {
        return view($this->views . '.bulk_image_upload');
    }

    public function bulk_image_upload_save()
    {
        $files = Input::file('files');
        $data = Input::all();
        $json = array(
            'files' => array()
        );
        foreach ($files as $key=> $file) {
            $filename = $file->getClientOriginalName();
            $original_name = $filename;
            $filename = pathinfo($filename, PATHINFO_FILENAME);

            $exploded = explode('-', $filename);
            $is_gallery =  end($exploded);
            $is_gallery = preg_replace('/[0-9]+/', '', $is_gallery);
            if($is_gallery == 'gallery')
            {
                array_pop($exploded);
                $product_name = implode('-', $exploded);
            }
            else
                $product_name = $filename;

            $product = Variants::where('name', $product_name)->first();
            if($product)
            {
                $upload = $this->uploadFile($file, $this->model->uploadPath['products'], ['Products']);
                if($upload['success'])
                {
                    $upload['related_type'] = "Products";
                    $upload['related_id'] = $product->products_id;
                    $result = $this->saveMedia($upload);                    
                    if($is_gallery == 'gallery')
                    {
                        $gallery = new ImageVariants;
                        $gallery->variant_id = $product->id;
                        $gallery->image_id = $result['id'];
                        $gallery->save();
                    }
                    else{
                        $product->image_id = $result['id'];
                        $product->save();
                    }
                    $json['files'][] = array(
                            'name' => $result['name'],
                            'size' => $result['size'],
                            'url' => \URL::to('').'/public/'.$result['url'],
                            'id' => $result['id'],
                            'original_file' => $result['original_file'],
                            'type' => $result['type'],
                    );
                }
            }
            else{
                $json['files'][] = array(
                            'error' => 'Error - '.$original_name
                    );
            }
        }
        return response()->json($json);
    }
    
    public function attribute_import()
    {
        return view($this->views . '.attribute_import');
    }

    public function attribute_import_save(Reqst $request)
    {
        ini_set('max_execution_time', '0');
        $this->validate($request, [
          'excel_file'  => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('excel_file')->getRealPath();
        $rows = Excel::toArray(new ProductsAttributesImports, $path, null, \Maatwebsite\Excel\Excel::XLSX)[0];
        foreach ($rows as $key => $value) {
            $product = Products::withTrashed()->where('product_name', $value['product_code'])->first();
            if($product)
            {
                for($i=1; $i<=20; $i++)
                {
                    if(isset($value['attribute_name'.$i]) && isset($value['attribute_value'.$i]) && isset($value['attribute_type'.$i]) && $value['attribute_name'.$i]!='' && $value['attribute_value'.$i]!='' && $value['attribute_type'.$i]!='')
                        $this->update_attribute($product, $value['attribute_name'.$i], $value['attribute_value'.$i], $value['attribute_type'.$i]);
                }
            }
        }
        return redirect()->back()->withSuccess('Excel successfully imported!');
    }

    public function update_attribute($product, $attribute_name, $attribute_value, $attribute_type, $variant_level=0)
    {
        $check_attribute_exist = CategoryAttributes::where('category_id', $product->category_id)->where('attribute_name', $attribute_name)->first();
        if(!$check_attribute_exist)
            $check_attribute_exist = new CategoryAttributes;
        $check_attribute_exist->category_id = $product->category_id;
        $check_attribute_exist->attribute_name = $attribute_name;
        $check_attribute_exist->attribute_type = ($attribute_type=='select')?'Selectable':'Running Text';
        $check_attribute_exist->show_as_variant = $variant_level;
        $check_attribute_exist->group_id = 1;
        if($check_attribute_exist->save())
        {
            $attribute_value_id = null;
            if($attribute_type=='select')
            {
                $check_attribute_value_exist = CategoryAttributeValues::where('attribute_id', $check_attribute_exist->id)->where('value', $attribute_value)->first();
                if(!$check_attribute_value_exist)
                {
                    $check_attribute_value_exist = new CategoryAttributeValues;
                    $check_attribute_value_exist->attribute_id = $check_attribute_exist->id;
                    $check_attribute_value_exist->value = $attribute_value;
                    $check_attribute_value_exist->save();
                }
                $attribute_value_id = $check_attribute_value_exist->id;
                if($variant_level>0)
                    return $check_attribute_value_exist->id;
            }

            $check_product_attribute = Attributes::where('products_id', $product->id)->where('attribute_id', $check_attribute_exist->id)->first();
            if(!$check_product_attribute)
            {
                $check_product_attribute = new Attributes;
                $check_product_attribute->products_id = $product->id;
                $check_product_attribute->attribute_id = $check_attribute_exist->id;
            }
            $check_product_attribute->attribute_value_id = $attribute_value_id;
            $check_product_attribute->attribute_value = $attribute_value;
            $check_product_attribute->save();
        }
        return true;
    }
}
