<?php namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class Roles extends BaseModel
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
    protected $table = 'roles';


    protected $fillable = array('name', 'status');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|unique:roles,name,ignoreId',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['name']) )
        {
            $this->val_rules['name'] = str_replace('ignoreId', $ignoreId, $this->val_rules['name']);
        }
        return $this->parent_validate($data);
    }

    public function permissions()
    {
        return $this->hasMany('App\Models\RoleHasPermissions');
    }

}
