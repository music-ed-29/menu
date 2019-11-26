<?php

declare(strict_types=1);

use Async\Menu\Item;
use Async\Menu\Menu;

if (!\function_exists('bootstrap_menu')) {
    function create_menu(string $url = "#", ?string $name, ?string $icon, ?string $type, ?Menu $menu)
    {
        if (empty($menu))
            $menu = new Menu;

        $item = $menu->add($name, $url);
        if (!empty($icon)) {
            if ($type == "img") {
                $item->addImage($icon);
            } else {
                $item->addIcon($icon);
            }
        }

        return $menu;
    }

    function create_menuSub(Menu $menu, string $url = "#", ?string $name, ?string $icon, ?string $type)
    {
        $subMenu = $menu->add($name, ['url' => $url, 'class' => 'submenu']);
        $subMenu->caret();
        if (!empty($icon)) {
            if ($type == "img") {
                $subMenu->addImage($icon);
            } else {
                $subMenu->addIcon($icon);
            }
        }

        return $subMenu;
    }

    function create_menuItem(Item $item, string $url = "#", ?string $name, ?string $icon, ?string $type)
    {
        $item->add($name, $url);
        if (!empty($icon)) {
            if ($type == "img") {
                $item->addImage($icon);
            } else {
                $item->addIcon($icon);
            }
        }

        return $item;
    }

    function bootstrap_menu($items, string $extra = '')
    {
        // Starting from items at root level
        if (!\is_array($items)) {
            $items = $items->roots();
        }

        $html = '';
        foreach ($items as $item) {
            $html .= '<li';
            if ($item->hasChildren())
                $html .= ' class="dropdown' . (!empty($extra) ? ' ' . $extra : '') . '"';

            $html .= '><a href="' . $item->url() . '"';
            if ($item->hasChildren())
                $html .= ' class="dropdown-toggle" data-toggle="dropdown"';

            $html .= '>' . $item->text();
            if ($item->hasChildren())
                $html .= ' <b class="caret"></b>';
            $html .= '</a>';

            if ($item->hasChildren()) {
                $html .= "\n    " . '<ul class="dropdown-menu">' . "\n";
                $html .= "        " . \bootstrap_menu($item->children());
                $html .= '    </ul>' . "\n";
            }
            $html .= '</li>' . "\n";
        }

        return $html;
    }
}
