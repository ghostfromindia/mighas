<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Hykon\CMDMessage;
use App\Models\InfoBlocks;
use App\Models\Key;
use App\Models\Products;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaticPageController extends BaseController
{
    public function home_page_data(){
        $cmd = new Products();

        $popular_categories = Category::where('is_popular',1)->get();
        $domestic_categories = Category::where('is_domestic',1)->get();
        $corporate_categories = Category::where('is_corporate',1)->get();

        return view ('admin.static.home',compact('cmd','popular_categories','domestic_categories','corporate_categories'));
    }

    public function about_page_data(){
        return view ('admin.static.about');
    }

    public function save_about(Request $request){
        foreach($request->all() as $key => $value) {



            if ($request->hasFile($key)) {
                $this->setKey($key,$value,'image');
            }else{
                $this->setKey($key,$value,'text');
            }


        }
        return redirect('admin/static/about');
    }

    public function save_cmd_message(Request $request){


        $request->validate([
            'cmd_title' => 'required',
            'cmd_image' => 'mimes:jpeg,bmp,png'
        ]);
        // title	summary	start_up	emplyees	companies	crore_turnover	image_id
        $this->setKey('cmd-message-title',$request->cmd_title,'text');
        $this->setKey('cmd-message-description',$request->cmd_summary,'text');
        $this->setKey('start-up',$request->cmd_start_up,'text');
        $this->setKey('employees',$request->cmd_employess,'text');
        $this->setKey('companies',$request->cmd_companies,'text');
        $this->setKey('crore-turnover',$request->cmd_crore_turnover,'text');

        if($request->cmd_image){
            $this->setKey('cmd-image',$request->cmd_image,'image');
        }



        session()->flash('success','Task completed successfully');
        return redirect('admin/static/home');
    }
    public function remove_cmd_image($id){
        $cmd = Settings::where('code',decrypt($id))->first();
        if($cmd){
            $cmd->delete();
            session()->flash('success','Task completed successfully');
        }else{
            session()->flash('error','Corresponding image not found or already deleted');
        }

        return redirect('admin/static/home');
    }

    public function site(){
        return view ('admin.static.site');
    }

    public function save(Request $request){
        foreach ($request->all() as $key=>$value){
            if (strpos($key, '-image') !== false) {
                $this->setKey($key,$value,'image');
            }else{
                $this->setKey($key,$value,'text');
            }
        }
        session()->flash('success','Task completed successfully');
        return redirect()->back();
    }


    public function save_highlights(Request $request){

    foreach ($request->all() as $key=>$value){
        if (strpos($key, '-image') !== false) {
            $this->setKey($key,$value,'image');
        }else{
            $this->setKey($key,$value,'text');
        }
    }
        session()->flash('success','Task completed successfully');
        return redirect('admin/static/home');
    }


    public function save_popular(Request $request){


        foreach ($request->categories as $category){
            $category = Category::find($category);
            if($category){
                $category->is_popular = 1;
                $category->save();
            }
            session()->flash('success','Task completed successfully');
        }

        return redirect('admin/static/home');
    }

    public function save_domestic(Request $request){


        foreach ($request->categories as $category){
            $category = Category::find($category);
            if($category){
                $category->is_domestic = 1;
                $category->save();
            }
            session()->flash('success','Task completed successfully');
        }

        return redirect('admin/static/home');
    }

    public function save_corporate(Request $request){


        foreach ($request->categories as $category){
            $category = Category::find($category);
            if($category){
                $category->is_corporate = 1;
                $category->save();
            }
            session()->flash('success','Task completed successfully');
        }

        return redirect('admin/static/home');
    }

    public function remove_popular($id){
        $category = Category::find(decrypt($id));
        if($category){
            $category->is_popular = 0;$category->save();
            session()->flash('success','Task completed successfully');
        }else{
            session()->flash('error','Corresponding Category not found or already deleted');
        }

        return redirect('admin/static/home');
    }

    public function remove_domestic($id){
        $category = Category::find(decrypt($id));
        if($category){
            $category->is_domestic = 0;$category->save();
            session()->flash('success','Task completed successfully');
        }else{
            session()->flash('error','Corresponding Category not found or already deleted');
        }

        return redirect('admin/static/home');
    }

    public function remove_corporate($id){
        $category = Category::find(decrypt($id));
        if($category){
            $category->is_corporate = 0;$category->save();
            session()->flash('success','Task completed successfully');
        }else{
            session()->flash('error','Corresponding Category not found or already deleted');
        }

        return redirect('admin/static/home');
    }


}
