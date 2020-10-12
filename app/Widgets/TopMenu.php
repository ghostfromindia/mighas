<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use MenuHelper;
use App\Models\Menu;


class TopMenu extends AbstractWidget
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
        $menu_items = MenuHelper::menu_tree($menu->id, 0);
        return view('widgets.top_menu', [
            'config' => $this->config,
            'menu_items' => $menu_items,
        ]);
    }
}
