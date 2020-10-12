<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ValidationTrait;

class Vendor extends Model
{
    protected $table = 'vendors';
    protected $fillable = ['slug','vendor_name','contact_name','phone','email','website','address','description','page_heading','browser_title','meta_keywords','meta_description','phone_code'];

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }


    public function __construct() {

        parent::__construct();
        $this->__validationConstruct();
    }

    protected function setRules() {
        $this->val_rules = [
            'slug' => 'required|alpha_dash|unique:vendors,slug,ignoreId',
            'vendor_name' => 'required|max:150',
            'contact_name' => 'required|max:150',
            'phone' => 'nullable|numeric|unique:vendors,phone,ignoreId',
            'email' => 'nullable|email|max:20|unique:vendors,email,ignoreId',
            'website' => 'nullable|url|max:20|unique:vendors,website,ignoreId',
            'address' => 'nullable|max:500',
            'description' => 'nullable',
            'phone_code' => 'nullable',
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
            'contact_name' => 'contact name',
            'phone' => 'phone number',
            'email' => 'email address',
            'website' => 'website url',
            'phone_code' => 'phone code',
            'page_heading' => 'page heading',
            'browser_title' => 'browser title',
            'meta_keywords' => 'meta keywords',
            'meta_description' => 'meta description'
        ];
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        $ignore_array = ['slug','phone','email'];
        foreach($ignore_array as $ignore){
            $this->val_rules[$ignore] = str_replace('ignoreId', $ignoreId, $this->val_rules[$ignore]);
        }
        return $this->parent_validate($data);
    }


}