<?php

declare(strict_types=1);

use Async\Menu\Menu;

if (!\function_exists('bootstrap_menu')) {
    function bootstrap_menu(Menu $items, string $extra = '')
    {
        // Starting from items at root level
        if (!\is_array($items)) {
            $items = $items->roots();
        }

        $html = '';
        foreach ($items as $item) {
            $html .= '<li';
            if ($item->hasChildren())
                $html .= ' class="dropdown'.(!empty($extra) ? ' '.$extra : '').'"';

            $html .= '><a href="' . $item->link->url() . '"';
            if ($item->hasChildren())
                $html .= ' class="dropdown-toggle" data-toggle="dropdown"';

            $html .= '>' . $item->link->text();
            if ($item->hasChildren())
                $html .= ' <b class="caret"></b>';
            $html .= '</a>';

            if ($item->hasChildren()) {
                $html .= '<ul class="dropdown-menu">';
                $html .= \bootstrap_menu($item->children());
                $html .= '</ul>';
            }
            $html .= '</li>';
        }

        return $html;
    }
}
