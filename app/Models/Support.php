<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Support extends Model
{
   protected $table = 'supports';

   protected $fillable = ['name', 'email', 'phone','type','form','subject', 'message'];


    public function resume()
    {
        return $this->belongsTo('App\Models\Media', 'career_file_id');
    }
}