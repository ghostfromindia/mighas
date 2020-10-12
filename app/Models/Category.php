<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ValidationTrait;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = array('type','category_code', 'parent_category_id','category_name','slug', 'policies','brochure_pdf','top_description','bottom_description','page_title','browser_title','meta_keywords','meta_description','tagline','banner_image','thumbnail_image');

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }

    public function __construct() {

        parent::__construct();
        $this->__validationConstruct();
    }

    protected function setRules() {
        $this->val_rules = array(
            'slug' => 'required|unique:categories,slug,ignoreId',
            'category_name' => 'required|max:150'
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
            'slug' => 'url code',
            'category_name' => 'category name',
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['slug']) )
        {
            $this->val_rules['slug'] = str_replace('ignoreId', $ignoreId, $this->val_rules['slug']);
        }
        return $this->parent_validate($data);
    }

    public static function listForSelectCategory($default = '--- Select a Country ---') {
        $list[''] = $default;
        foreach (Category::orderBy('category_name', 'ASC')->get() as $category) {
            $list[$category->id] = $category->name;
        }
        return $list;
    }

    public function selected($id) {
        if($id){
            $category = Category::find($id);
            if(!$category){return [];}
            $list[$category->id] = $category->category_name;
            return $list;
        }
        return [];
    }

    public function childs(){
        return $this->hasMany('App\Models\Category','parent_category_id');
    }

    public function childs_with_products(){
        return $categories = DB::table('products as p')
            ->join('categories as c','c.id','=','p.category_id')
            ->where('c.parent_category_id',$this->id)->select('c.id','c.category_name','c.slug')->distinct('category_name')->get();
    }

    public function banner(){
        return $this->belongsTo('App\Models\Media','banner_image');
    }

    public function primary(){
        return $this->belongsTo('App\Models\Media','thumbnail_image');
    }

    public function brochure(){
        return $this->belongsTo('App\Models\Media','brochure_pdf');
    }

    public function sub_categories()
    {
        return $this->hasMany('App\Models\Category','parent_category_id');
    }

    public function has_products(){
        return $this->hasMany('App\Models\Products','category_id')->count();
    }
    
    public function parent(){
        $category = Category::find($this->parent_category_id);
        if($category){
            return $category;
        }else{
            return null;
        }
    }

 


}
