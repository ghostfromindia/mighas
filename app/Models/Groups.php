<?php namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class Groups extends BaseModel
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
    protected $table = 'groups';


    protected $fillable = array('group_name', 'status');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
            'group_name' => 'required|max:250',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }


    public function products()
    {
        return $this->hasMany('App\Models\GroupProducts');
    }

}
