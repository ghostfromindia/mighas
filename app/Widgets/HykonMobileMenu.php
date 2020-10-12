<?php

namespace App\Widgets;

use App\Helpers\MenuHelper;
use App\Models\Menu;
use Arrilot\Widgets\AbstractWidget;

class HykonMobileMenu extends AbstractWidget
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
        $menu_position = $this->config['menu_position'];
        $a = Menu::where('name', 'Top Menu')->orderBy('menu_order', 'ASC');

        $b = Menu::where('position', $menu_position)->orderBy('menu_order', 'ASC')
            ->union($a)
            ->get();

        $menus = $b;

        $menu_items = [];
        if($menus)
        {
            foreach ($menus as $key => $menu) {
                $menu_items[$key]['menu'] = MenuHelper::menu_tree($menu->id, 0);
                $menu_items[$key]['type'] = $menu->menu_type;
            }
        }

        return view('hykon.widgets.mobile_menu', [
            'config' => $this->config,
            'menu_items' => $menu_items,
        ]);
    }
}
