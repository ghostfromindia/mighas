<?php
 
namespace App\Models\Products;
 
use Illuminate\Database\Eloquent\Model;
 
class Views extends Model
{
   protected $table = 'product_views';

   protected $fillable = ['user_id', 'products_id', 'count'];
   protected $dates = ['created_at','updated_at'];
 
 
   public function user(){
       return $this->belongsTo('App\User','id','user_id');
   }

   public function product()
   {
   		return $this->belongsTo('App\Models\Products\Variants', 'products_id');
   }
 
}