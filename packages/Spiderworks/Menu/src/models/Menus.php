<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';


    protected $fillable = array('name', 'code', 'menu_position');

    protected $dates = ['created_at','updated_at'];


    public function createCode($menu_name, $id=0)
    {
        $slug = str_slug($menu_name);

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


    public function menu_items()
    {
        return $this->hasMany('App\Models\MenuItems');
    }

    public function parent_menu_items()
    {
        return $this->menu_items()->where('parent_id',0);
    }

}
