<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\ValidationTrait;

class Page extends BaseModel
{
	use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    protected $table = 'pages';


    protected $fillable = array('slug', 'type', 'name','event_date_time', 'primary_heading', 'short_description', 'content', 'parent_id', 'media_id', 'banner_id', 'browser_title', 'meta_description', 'meta_keywords', 'top_description', 'bottom_description', 'extra_css', 'extra_js', 'status','block_1_title','block_1_summary','block_2_title','block_2_summary','block_3_title','block_3_summary');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|max:250',
            'slug' => 'required|max:250|unique:pages,slug,ignoreId',
            'content' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['slug']) )
        {
            $this->val_rules['slug'] = str_replace('ignoreId', $ignoreId, $this->val_rules['slug']);
        }
        return $this->parent_validate($data);
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Page', 'parent_id');
    }

    public function featured_image()
    {
    	return $this->belongsTo('App\Models\Media', 'media_id');
    }

    public function banner_image()
    {
        return $this->belongsTo('App\Models\Media', 'banner_id');
    }

    public function menu()
    {
        return $this->morphOne('App\Models\MenuItem', 'linkable');
    }


}
