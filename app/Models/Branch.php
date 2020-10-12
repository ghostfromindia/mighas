<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';
    protected $fillable = ['branch_name','page','state_id','location','district_id' ,'page_heading', 'slug', 'address', 'email', 'landline_number', 'contact_person', 'contact_person_number', 'contact_person_image', 'landmark_id', 'GSTIN', 'media_id', 'banner_id', 'lattitude', 'longitude', 'website', 'mobile_number', 'description', 'browser_title', 'meta_description', 'meta_keywords', 'status', 'opening_time', 'closing_time', 'sunday_open'];

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }


    public function __construct() {

        parent::__construct();
        $this->__validationConstruct();
    }

    protected function setRules() {
        $this->val_rules = [
            'slug' => 'required|alpha_dash|unique:branches,slug,ignoreId',
            'branch_name' => 'required|max:250',
            'page_heading' => 'required|max:250',
            'address' => 'required',
        ];
    }

    protected function setAttributes() {
        $this->val_attributes = [
        ];
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        $ignore_array = ['slug'];
        foreach($ignore_array as $ignore){
            $this->val_rules[$ignore] = str_replace('ignoreId', $ignoreId, $this->val_rules[$ignore]);
        }
        return $this->parent_validate($data);
    }

    public function media()
    {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

    public function banner()
    {
        return $this->belongsTo('App\Models\Media', 'banner_id');
    }

    public function contact_person_photo()
    {
        return $this->belongsTo('App\Models\Media', 'contact_person_image');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\BranchLandmark', 'landmark_id');
    }
}