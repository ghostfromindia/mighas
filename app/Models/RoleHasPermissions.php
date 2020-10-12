<?php namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class RoleHasPermissions extends BaseModel
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
    protected $table = 'role_has_permissions';


    protected $fillable = array('permission_id', 'role_id');


    protected function setRules() {

        $this->val_rules = array(
           
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function permission()
    {
        return $this->belongsTo('App\Models\Permissions', 'permission_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Roles', 'role_id');
    }

}
