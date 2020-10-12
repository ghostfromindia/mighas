<?php namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class Pages extends BaseModel
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
    protected $table = 'pages';


    protected $fillable = array('code', 'title', 'description', 'description_data', 'browser_title', 'meta_description', 'meta_keywords', 'media_id', 'status', 'parent_id', 'header_text', 'footer_text', 'embedded_form', 'embedded_form_text');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
            'code' => 'required|unique:pages,code,ignoreId',
            'title' => 'required|max:250',
            'description' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
            'code' => 'url code',
            'title' => 'title',
            'description' => 'description',
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['code']) )
        {
            $this->val_rules['code'] = str_replace('ignoreId', $ignoreId, $this->val_rules['code']);
        }
        return $this->parent_validate($data);
    }

    public function media()
    {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

}
