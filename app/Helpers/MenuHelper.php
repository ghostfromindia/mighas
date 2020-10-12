<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use App\Models\MenuItem;

class MenuHelper
{

    public static function menu_tree($menu_id, $parent)
    {
        $items = MenuItem::where('menu_id', $menu_id)->where('parent_id', $parent)->orderBy('menu_order', 'ASC')->get();
        if($items)
        {
            foreach ($items as $key => $item) {
                if($item->menu_type == 'custom_link')
                    $item->slug = $item->url;
                elseif ($item->menu_type == 'page_link')
                    $item->slug = url('company', $item->linkable->slug);
                elseif($item->menu_type == 'frontpage_links')
                {
                    if(isset($item->linkable->slug))
                    {
                        if($item->linkable->slug == 'logout')
                            $item->slug = 'logout';
                        else
                            $item->slug = route($item->linkable->slug);
                    }
                    else
                        $item->slug = "#";
                }
                elseif($item->menu_type == 'category_link')
                {
                    if($item->linkable)
                        $item->slug = url('stores', $item->linkable->slug);
                    else
                        $item->slug = '#';
                }

                $check_children = MenuItem::where('parent_id', $item->id)->count();
                if($check_children>0)
                {
                    $item['children'] = static::menu_tree($menu_id, $item->id);
                }
            }
        }
        return $items;
    }
}