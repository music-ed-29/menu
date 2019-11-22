<?php

declare(strict_types=1);

use Async\Menu\Menu;

if (!\function_exists('bootstrapItems')) {
    function bootstrapItems(Menu $items)
    {
        // Starting from items at root level
        if (!\is_array($items)) {
            $items = $items->roots();
        }

        $menu = '';
        foreach ($items as $item) {
            $menu .= '<li';
            if ($item->hasChildren())
                $menu .= '> class="dropdown"';

            $menu .= '><a href="' . $item->link->get_url() . '" ';
            if ($item->hasChildren())
                $menu .= 'class="dropdown-toggle" data-toggle="dropdown" ';

            $menu .= $item->link->get_text();
            if ($item->hasChildren())
                $menu .= ' <b class="caret"></b>';
            $menu .= '</a>';

            if ($item->hasChildren()) {
                $menu .= '<ul class="dropdown-menu">';
                $menu .= \bootstrapItems($item->children());
                $menu .= '</u>';
            }
            $menu .= '</li>';
        }

        return $menu;
    }
}
