<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Products\Attributes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AttributeController extends Controller
{
    public function getSelectable($category){
        $selected = Input::get('selected');
        if($selected){
            $sel = explode(',',$selected);
        }else{
            $sel = [];
        }
        $data = [];
        $category = Category::findOrFail($category);
        $category_attributtes =  Category\CategoryAttributes::where('category_id',$category->id)->where('attribute_type','Selectable')->get();
        foreach ($category_attributtes as $obj){
            if($obj->getSelectableValues){
                foreach ($obj->getSelectableValues as $ob){
                    if($ob->value){
                        if (in_array($ob->id, $sel)){
                            $status = true;
                        }else{
                            $status = false;
                        }

                        $data[$obj->attribute_name][] = ['id' => $ob->id,'value' => $ob->value,'status' => $status];
                    }

                }
            }
        }

        return json_encode($data);
    }

}
