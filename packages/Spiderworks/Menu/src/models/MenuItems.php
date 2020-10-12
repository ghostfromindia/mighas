<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menu_items';


    protected $fillable = array('url', 'pages_id', ' menu_type', 'menu_order', 'parent_id');

    protected $dates = ['created_at','updated_at'];


}
