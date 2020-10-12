<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\File,URL;

class PluginController extends BaseController
{
    public function summernote_image_upload(Request $request){
        $image = $this->uploadFile($request->file('file'),'summernote');
        echo URL::asset($image['filepath']);
    }


}
