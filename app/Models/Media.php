<?php

namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class Media extends BaseModel
{
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
    protected $table = 'media_library';

    public $uploadPath = array(
        'media' => 'uploads/media/',
        'media_thumb' => 'uploads/media/thumb/',
    );


    protected $fillable = array('file_name', 'file_path', 'file_type', 'file_size', 'dimensions', 'media_type', 'title', 'description', 'alt_text');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

}
