<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blocks;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{
    public function add(Request $request){
            $data = [];
            $data['status'] = 'Response';
            $page = Page::find($request->landing_id);

            if(!$page){
                abort(303);
            }


            if($request->type == 'block-1'){
                if(!empty($request->title)){

                    $page->block_1_title = $request->title;
                    $data['status'] .= '<br>Block title updated';
                }

                if(!empty($request->summary)){
                    $page->block_1_summary = $request->summary;
                    $data['status'] .= '<br>Block summary updated';
                }
            }


        if($request->type == 'block-2'){
            if(!empty($request->title)){

                $page->block_2_title = $request->title;
                $data['status'] .= '<br>Block title updated';
            }

            if(!empty($request->summary)){
                $page->block_2_summary = $request->summary;
                $data['status'] .= '<br>Block summary updated';
            }
        }


        if($request->type == 'block-3'){
            if(!empty($request->title)){

                $page->block_3_title = $request->title;
                $data['status'] .= '<br>Block title updated';
            }

            if(!empty($request->summary)){
                $page->block_3_summary = $request->summary;
                $data['status'] .= '<br>Block summary updated';
            }
        }




            $page->save();



        if(!empty($request->products)){
//                $products = explode(',',$request->products);
                $i =0;
                foreach ($request->products as $obj){

                    $block = Blocks::where('page_id',$request->landing_id)->where('variant_id',$obj)->where('type',$request->type)->first();

                    if(!$block){
                        $blocks = new Blocks;
                        $blocks->page_id = $request->landing_id;
                        $blocks->type = $request->type;
                        $blocks->variant_id = $obj;
                        $blocks->save();
                        if($i==0){
                            $data['status'] .= '<br>New products added'; $i++;
                        }

                    }else{
                        $data['status'] .= '<br>No new products added';
                    }

                }


            }else{
                $data['status'] .= '<br>No new products added';
            }
            return json_encode($data);
    }

    public function get(Request $request){
        $data = [];
        $blocks = Blocks::where('page_id',$request->landing_id)->where('type',$request->type)->get();
        $data['products'] = [];
        foreach ($blocks as $obj){
            array_push($data['products'],array($obj->id,$obj->variant->name));
        }

        $page = Page::find($request->landing_id);

        if($request->type == 'block-1'){
            $data['title'] = $page->block_1_title;
            $data['summary'] = $page->block_1_summary;
        }

        if($request->type == 'block-2'){
            $data['title'] = $page->block_2_title;
            $data['summary'] = $page->block_2_summary;
        }

        if($request->type == 'block-3'){
            $data['title'] = $page->block_3_title;
            $data['summary'] = $page->block_3_summary;
        }


        return json_encode($data);
    }

    public function destroy(Request $request){
        $data = [];
        $blocks = Blocks::find($request->id);
        if($blocks){
            $data['status'] = 'Product removed successfully';
            $blocks->delete();
        }else{
            $data['status'] = 'There are not product in that name';
        }
        return json_encode($data);
    }
}
