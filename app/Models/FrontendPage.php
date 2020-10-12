<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\ValidationTrait;

class FrontendPage extends BaseModel
{
	use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }
    
    protected $table = 'frontend_pages';

    protected $fillable = [
        'slug', 'name', 'media_id', 'browser_title', 'meta_description', 'meta_keywords', 'top_description', 'bottom_description', 'extra_css', 'extra_js', 'status'
    ];

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function featured_image()
    {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

    public function menu()
    {
        return $this->morphOne('App\Models\MenuItem', 'linkable');
    }
}
