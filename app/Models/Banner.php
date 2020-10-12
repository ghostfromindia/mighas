<?php namespace App\Models;

use App\Models\BaseModel;
use App\Models\ValidationTrait;
use DB;
use Illuminate\Support\Str;

class Banner extends BaseModel
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
    protected $table = 'banners';

    protected $fillable = array('banner_name', 'code', 'width', 'height', 'link', 'title');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
            'banner_name' => 'required|max:250',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function createCode($slider_name, $id=0)
    {
        $slug = Str::slug($slider_name, '-');

        $allSlugs = static::select('code')->where('code', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();

        if (! $allSlugs->contains('code', $slug)){
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 100; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('code', $newSlug)) {
                return $newSlug;
            }
        }

    }

    public static function GCD ($a, $b){
        while ( $b != 0)
        {
            $remainder = $a % $b;
            $a = $b;
            $b = $remainder;
        }
        return abs ($a);
    }

    public function photos()
    {
        return $this->hasMany('App\Models\BannerPhoto', 'banners_id');
    }

}
