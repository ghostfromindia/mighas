<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use MenuHelper;
use App\Models\Menu;


class BottomMenu extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $menu_name = $this->config['name'];
        $menu = Menu::where('name', $menu_name)->first();
        if(!$menu){return view('widgets.bottom_menu');}
        $menu_items = MenuHelper::menu_tree($menu->id, 0);
        return view('widgets.bottom_menu', [
            'config' => $this->config,
            'menu_items' => $menu_items,
        ]);
    }
}
