<?php

namespace Spiderworks\Menu;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use App\Models\Menus, Input, View, Redirect, DB, Datatables;
use Helper;
use App\Models\MenuItems;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MenusController extends BaseController
{
    use ResourceTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->model = new Menus;

        $this->route .= '.menus';
        $this->views .= '.menus';
        $this->url = "admin/menus/";

        $this->resourceConstruct();

    }


    protected function getCollection() {
        return $this->model->select('id', 'name', 'menu_position', 'status', 'created_at', 'updated_at');
        
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('status', function($obj) use ($route) {
                if($obj->status == 1)
                    return '<a href="' . route( $route . '.change-status',  [$obj->id, $obj->status] ) . '" class="btn btn-success btn-sm" ><i class="glyphicon glyphicon-ok-circle"></i></a>';
                else
                    return '<a href="' . route( $route . '.change-status',  [$obj->id, $obj->status] ) . '" class="btn btn-danger btn-sm" ><i class="glyphicon glyphicon-remove-circle"></i></a>';
            })
            ->editColumn('updated_at', function($obj) { return date('m/d/Y H:i:s', strtotime($obj->updated_at)); })
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    public function create()
    {
        $pages = Pages::where('status', 1)->orderBy('created_at', 'DESC')->get();
        return view($this->views . '.form')->with('obj', $this->model)->with('pages', $pages);
    }

    public function edit($id) {
        if($obj = $this->model->find($id)){
            $pages = Pages::where('status', 1)->orderBy('created_at', 'DESC')->get();
            $obj->menu_items = $this->menu_tree($id, 0);
            return view($this->views . '.form')->with('obj', $obj)->with('pages', $pages);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store()
    {
        $this->model->validate();
        $data = Input::all();
        $this->model->fill($data);
        $data['code'] = $this->model->createCode($data['name']);
        $this->model->save();
        $menu_settings = json_decode($data['menu_settings']);
        if(isset($data['menu']))
            $this->store_recurssion($menu_settings, $data['menu'], 0, $this->model->id);
        return Redirect::to(url('admin/menus/edit', ['id'=>$this->model->id]))->withSuccess('Menu successfully added!');
    }

    public function store_recurssion($menu_settings, $menu, $parent=0, $menu_id)
    {
        if($menu_settings)
        {
            foreach ($menu_settings as $key => $setting) {
                $id = $setting->id;
                if(isset($menu[$id]))
                {
                    $item_array = explode('-', $id);
                    $obj = new MenuItems;
                    $obj->menus_id = $menu_id;
                    if($item_array[0] == 'page_link')
                    {                       
                        $obj->pages_id = $menu[$id]['id'];
                    }
                    elseif($item_array[0] == 'custom_link')
                    {
                        $obj->url = $menu[$id]['url'];
                        if(isset($menu[$id]['target_blank']))
                            $obj->target_blank = 1;
                        $obj->original_title = $menu[$id]['original_title'];
                    }
                    elseif($item_array[0] == 'internal_link')
                    {
                        $obj->url = $menu[$id]['url'];
                        $obj->original_title = $menu[$id]['original_title'];
                    }
                    $obj->title = $menu[$id]['text'];
                    $obj->menu_order = $key;
                    $obj->menu_type = $item_array[0];
                    $obj->parent_id = $parent;
                    $obj->menu_nextable_id = $menu[$id]['menu_nextable_id'];
                    $obj->save();
                    if(isset($setting->children))
                        $this->store_recurssion($setting->children, $menu, $obj->id, $menu_id);
                }
            }
        }
    }


    public function menu_tree($menu_id, $parent)
    {
        $items = MenuItems::where('menus_id', $menu_id)->where('parent_id', $parent)->get();
        if($items)
        {
            foreach ($items as $key => $item) {
                $check_children = MenuItems::where('parent_id', $item->id)->count();
                if($check_children>0)
                {
                    $item['children'] = $this->menu_tree($menu_id, $item->id);
                }
            }
        }
        return $items;
    }

    public function update($id) {
        $this->model->validate(Input::all(), $id);
        if($obj = $this->model->find($id)){
            $data = Input::all();
            $obj->update($data);
            MenuItems::where('menus_id', $obj->id)->forcedelete();
            $menu_settings = json_decode($data['menu_settings']);
            if(isset($data['menu']))
                $this->store_recurssion($menu_settings, $data['menu'], 0, $obj->id);
            return Redirect::to(url('admin/menus/edit', ['id'=>$obj->id]))->withSuccess('Menu successfully updated!');
        }
        else {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(Input::all());
        }
    }

}
