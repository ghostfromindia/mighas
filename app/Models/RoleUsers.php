<?php namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class RoleUsers extends BaseModel
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
    protected $table = 'role_users';


    protected $fillable = array('user_id', 'role_id');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
           
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Roles', 'role_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
