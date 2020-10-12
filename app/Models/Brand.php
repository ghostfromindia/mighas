<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = ['slug','brand_name', 'website', 'media_id', 'page_heading','browser_title','meta_keywords','meta_description', 'brand_code'];

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }


    public function __construct() {

        parent::__construct();
        $this->__validationConstruct();
    }

    protected function setRules() {
        $this->val_rules = [
            'slug' => 'required|alpha_dash|unique:brands,slug,ignoreId',
            'brand_name' => 'required|unique:brands,brand_name,ignoreId|max:150',
            'page_heading' => 'nullable',
            'browser_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
        ];
    }

    protected function setAttributes() {
        $this->val_attributes = [
            'slug' => 'vendor slug',
            'vendor_name' => 'vendor name',
            'page_heading' => 'page heading',
            'browser_title' => 'browser title',
            'meta_keywords' => 'meta keywords',
            'meta_description' => 'meta description'
        ];
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        $ignore_array = ['slug','brand_name'];
        foreach($ignore_array as $ignore){
            $this->val_rules[$ignore] = str_replace('ignoreId', $ignoreId, $this->val_rules[$ignore]);
        }
        return $this->parent_validate($data);
    }

    public function logo(){
        return $this->belongsTo('App\Models\Media','media_id');
    }
}