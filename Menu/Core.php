<?php

declare(strict_types=1);

if (!\function_exists('bootstrap_menu')) {
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
                $html .= ' class="dropdown'.(!empty($extra) ? ' '.$extra : '').'"';

            $html .= '><a href="' . $item->url() . '"';
            if ($item->hasChildren())
                $html .= ' class="dropdown-toggle" data-toggle="dropdown"';

            $html .= '>' . $item->text();
            if ($item->hasChildren())
                $html .= ' <b class="caret"></b>';
            $html .= '</a>';

            if ($item->hasChildren()) {
                $html .= "\n    ".'<ul class="dropdown-menu">'."\n";
                $html .= "        ".\bootstrap_menu($item->children());
                $html .= '    </ul>'."\n";
            }
            $html .= '</li>'."\n";
        }

        return $html;
    }
}
