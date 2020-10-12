<?php namespace App\Models;

use App\Models\BaseModel;
use App\Models\ValidationTrait;
use DB;

class BannerPhoto extends BaseModel
{
    
    public function __construct() {
        
        parent::__construct();
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banner_photos';

    protected $fillable = array('banners_id', 'media_id', 'crop_data', 'title', 'alt_text', 'link');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function banner() {
        return $this->belongsTo('App\Models\Banner', 'banners_id');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

}
