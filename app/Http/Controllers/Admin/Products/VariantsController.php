<?php namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use App\Imports\SpecificationImport;
use App\Models\Specification;
use Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Reqst;
use App\Models\Products\Variants;
use App\Models\Products;
use App\Models\Products\Variants\Images AS ImageVariants;
use App\Models\Products\Variants\Inventory;
use Maatwebsite\Excel\Facades\Excel;

class VariantsController extends BaseController
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

        $this->model = new Variants;

        $this->route .= '.products.variants';
        $this->views .= '.products.variants';
        $this->url = "admin/products/variants";

        $this->resourceConstruct();

    }

    public function index(Reqst $request, $pid=null)
    {
        if ($request->ajax()) {
            $collection = $this->getCollection();
            if($pid)
                $collection->where('variants.products_id', '=', $pid);
            return $this->setDTData($collection)->make(true);
        } else {
            return view::make($this->views . '.index', array('pid'=>$pid));
        }
    }

    protected function getCollection() {
        $collection = DB::table('product_variants AS variants')->select('variants.id', 'variants.products_id', 'variants.name', 'variants.updated_at', 'variants.is_default')->join('products', 'products.id', '=', 'variants.products_id')->whereNull('variants.deleted_at');

        return $collection; 
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('updated_at', function($obj) { return date('m/d/Y H:i:s', strtotime($obj->updated_at)); })
            ->editColumn('is_default', function($obj){
                return ($obj->is_default == 1)?'<span class="badge badge-success">Default</span>':'';
            })
            ->rawColumns(['action_edit', 'action_delete', 'is_default']);
    }

    public function create($pid)
    {
        $product = Products::find($pid);
        
        $gallery = [];
        $levels = $this->getLevelAttributes($product->category_id);

        return view($this->views . '.form')->with('obj', $this->model)->with('product', $product)->with('level1', $levels['level1'])->with('level2', $levels['level2'])->with('level3', $levels['level3'])->with('gallery', $gallery);
    }


    public function getLevelAttributes($category_id)
    {
        $variants = DB::table('product_cateory_attribute_values')->select('product_cateory_attribute_values.id', 'product_cateory_attribute_values.value', 'product_cateory_attributes.attribute_name', 'product_cateory_attributes.show_as_variant')->join('product_cateory_attributes',  'product_cateory_attributes.id', '=', 'product_cateory_attribute_values.attribute_id')->orderBy('product_cateory_attributes.attribute_name')->where('product_cateory_attributes.category_id', $category_id)->where('product_cateory_attributes.show_as_variant', '!=', 0)->get();
        $level1 = $level2 = $level3 = [];
        foreach ($variants as $key => $variant) {
            switch ($variant->show_as_variant) {
                case '1':
                    $level1[$key]['id'] = $variant->id;
                    $level1[$key]['value'] = $variant->value;
                    $level1[$key]['text'] = $variant->attribute_name.' - '.$variant->value;
                    break;
                case '2':
                    $level2[$key]['id'] = $variant->id;
                    $level2[$key]['value'] = $variant->value;
                    $level2[$key]['text'] = $variant->attribute_name.' - '.$variant->value;
                    break;
                case '3':
                    $level3[$key]['id'] = $variant->id;
                    $level3[$key]['value'] = $variant->value;
                    $level3[$key]['text'] = $variant->attribute_name.' - '.$variant->value;
                    break;
            }
        }
        return ['level1'=>$level1, 'level2'=>$level2, 'level3'=>$level3];
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $product = Products::find($obj->products_id);

            $levels = $this->getLevelAttributes($product->category_id);
            $gallery = $this->getVariantGallery($id);
            //echo count($gallery);exit;

            return view($this->views . '.form')->with('obj', $obj)->with('product', $product)->with('gallery', $gallery)->with('level1', $levels['level1'])->with('level2', $levels['level2'])->with('level3', $levels['level3']);;
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store(Reqst $r)
    {
        $data = $r->all();
        $data['products_id'] = decrypt($data['products_id']);
        $this->model->validate();
        $this->model->fill($data);
        if($this->model->save())
        {

            if(isset($data['is_default']))
            {
                Variants::where('products_id', $data['products_id'])->update(['is_default'=>0]);
                $obj = $this->model->find($this->model->id);
                $obj->is_default = 1;
                $obj->save();
            }

            if(isset($data['media_id']))
            {
                $this->saveGallery($this->model->id, $data);
            }
            $inventrory = new Inventory;
            $inventrory->saveVariantByInventory($this->model->id, $data);
            
        }
        return Redirect::to(url('admin/products/variants/edit', array('id'=>encrypt($this->model->id))))->withSuccess('Variant successfully saved!'); 
    }

    public function update(Reqst $r)
    {



        if($r->specification){
            $path = $r->file('specification')->getRealPath();
            $rows = Excel::toArray(new SpecificationImport, $path, null, \Maatwebsite\Excel\Excel::XLSX)[0];
            $batch = date('ymdhis');
            foreach ($rows as $obj){

                 $variant = Variants::where('name',$obj['product_name'])->first();
                 if($variant){
                     $specification = Specification::where('variant_id',$variant->id)->where('group',$obj['tab'])->where('key',$obj['attribute_name'])->first();
                     if(!$specification){
                         $specification = new Specification();
                     }
                     $specification->variant_id = $variant->id;
                     $specification->group = $obj['tab'];
                     $specification->key = $obj['attribute_name'];
                     $specification->value = $obj['attribute_value'];
                     $specification->batch = $batch;
                     $specification->save();
                 }
            }
        }



        $data = $r->all();
        $id = decrypt($data['id']);
        $this->model->validate($data, $id);

        if($obj = $this->model->find($id)){

            if(isset($data['is_default']))
                Variants::where('products_id', $obj->products_id)->update(['is_default'=>0]);

            $obj->update($data);

            if(isset($data['media_id']))
            {
                $this->saveGallery($id, $data, 'edit');
            }
            $inventrory = new Inventory;
            $inventrory->saveVariantByInventory($id, $data);

            return Redirect::to(url('admin/products/variants/edit', array('id'=>encrypt($obj->id))))->withSuccess('Variant successfully updated!');
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
            return response()->json(['success'=>'Variant successfully deleted']);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }
    
    public function changeOfferStatus($id)
    {
        $id =  decrypt($id);
        if($obj = $this->model->find($id))
        {
            $set_status = ($obj->offer_status == 1)?0:1;
            $obj->offer_status = $set_status;
            $obj->save();
            $message = ($obj->offer_status == 0)?"disabled":"enabled";
            return Redirect::back()->withSuccess('Product offer successfully '.$message.'!');
        }
        return Redirect::back()->withError('Oops!! something went wrong...Please try again.');
    }

}
