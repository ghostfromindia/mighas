<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\ValidationTrait;

class HomePageSettings extends BaseModel
{
    protected $table = 'home_page_settings';

    protected $fillable = ['section','code','type','content'];

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }


    public function __construct() {

        parent::__construct();
        $this->__validationConstruct();
    }

    public $uploadPath = array(
        'settings' => 'uploads/home_settings/',
    );

    protected function setRules() {
        $this->val_rules = [
            'content' => 'required',
        ];
    }

    protected function setAttributes() {
        $this->val_attributes = [
        ];
    }

}