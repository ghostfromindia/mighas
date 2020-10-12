<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Activity extends Model
{
   protected $table = 'activities';
   protected $fillable = ['request_token', 'user_id', 'guest_id', 'url', 'ip', 'user_agent', 'response_http_code', 'response_time', 'response', 'payload'];
 
 
   public function getUser(){
       return $this->hasOne('App\User','id','user_id');
   }
 
}