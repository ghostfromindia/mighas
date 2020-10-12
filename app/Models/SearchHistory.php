<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class SearchHistory extends Model
{
   protected $table = 'search_history';

   protected $fillable = ['user_id', 'search_term', 'count'];
   protected $dates = ['created_at','updated_at'];
 
 
   public function user(){
       return $this->belongsTo('App\User','id','user_id');
   }
 
}