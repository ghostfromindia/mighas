<?php

namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Products extends BaseModel
{
    use SoftDeletes;
	use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';


    protected $fillable = array('category_id', 'product_name', 'slug', 'tagline', 'brand_id', 'vendor_id', 'summary', 'top_description', 'bottom_description', 'quantity', 'mrp', 'sale_price', 'default_variant_id', 'is_featured_in_home_page', 'is_featured_in_category', 'is_new', 'is_top_seller', 'is_today_deal', 'is_active', 'default_image_id', 'page_heading', 'browser_title', 'meta_keywords', 'meta_description', 'is_completed');

    protected $dates = ['created_at','updated_at'];

    public $uploadPath = array(
        'products' => 'uploads/products/',
    );


    protected function setRules() {

        $this->val_rules = array(
            'category_id'=> 'required',
            'product_name' => 'required|max:250',
            'slug' => 'required|alpha_dash|unique:products,slug,ignoreId',
            'summary' => 'required',
            'page_heading' => 'nullable|max:250',
            'browser_title' => 'nullable|max:250',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        $ignore_array = ['slug'];
        foreach($ignore_array as $ignore){
            $this->val_rules[$ignore] = str_replace('ignoreId', $ignoreId, $this->val_rules[$ignore]);
        }
        return $this->parent_validate($data);
    }

    public function createCode($product_name, $id=0)
    {
        $slug = Str::slug($product_name, '-');

        $allSlugs = static::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();

        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 100; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function default(){
        return $this->hasOne('App\Models\Products\Variants', 'products_id')->where('is_default','=',1);
    }

    public function variants(){
        return $this->hasMany('App\Models\Products\Variants', 'products_id');
    }

    public function primary()
    {
        return $this->belongsTo('App\Models\File', 'default_image_id')->select('url');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    public function attributes()
    {
        return $this->hasMany('App\Models\Products\Attributes', 'products_id');
    }

    public function reviews(){
        return DB::table('product_reviews')->where('products_id',$this->id)->get();
    }


    
    public function variant()
    {
        return $this->hasOne('App\Models\Products\Variants', 'products_id');
    }

}