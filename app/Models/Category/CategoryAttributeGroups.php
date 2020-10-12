<?php

namespace App\Models\Category;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class CategoryAttributeGroups extends BaseModel
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
    protected $table = 'product_cateory_attribute_groups';


    protected $fillable = array('category_id', 'group_name');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public static function listForSelect($default = '--- Select a Group ---', $category_id=null) {
        $list[''] = $default;
        $query = static::orderBy('group_name', 'ASC');
        if($category_id)
            $query->where('category_id', $category_id);
        foreach ($query->get() as $group) {
            $list[$group->id] = $group->group_name;
        }
        return $list;
    }

    public function attributes(){
        return $attributes = CategoryAttributes::where('category_id',$this->category_id)->where('group_id',$this->id)->get();
    }

}
