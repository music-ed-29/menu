<?php

declare(strict_types=1);

namespace Async\Menu;

use Async\Menu\Item;

class Menu
{
    /**
     * The Item's array
     *
     * @var array
     */
    protected $menu = array();

    /**
     * Reserved keys
     *
     * @var array
     */
    protected $reserved = array('pid', 'url');

    /**
     * Create a new menu item.
     * Using the returned instance creates a `sub menu` item.
     *
     * @param  string  $title
     * @param  array|string  $options
     * @return Item
     */
    public function add($title, $options = '', $priority = null)
    {
        $url  = $this->getUrl($options);

        // if $data contains 'pid' we  set the given pid
        $pid  = (isset($options['pid'])) ? $options['pid'] : null;

        // we separate html attributes from reserved keys
        $attr = (\is_array($options)) ? $this->extractAttr($options) : array();

        // making an instance of Item class
        $item = new Item($this, $title, $url, $attr, $pid);

        if (\is_null($priority) && \count($this->menu) > 0) {
            $priority = \max(\array_keys($this->menu)) ?: 0;
            $priority += 10;
        }

        $this->menu[$pid . '00' . $priority] = $item;

        \ksort($this->menu);

        // return the object just created
        return $item;
    }

    public function getById($id)
    {
        $item = \array_filter($this->menu, function ($item) use ($id) {
            return $item->attributes('id') == $id;
        });

        $item = \end($item);

        return $item;
    }

    /**
     * Return Items at root level
     *
     * @return array
     */
    public function roots()
    {
        return $this->whereParent();
    }

    /**
     * Return Items at the given level
     *
     * @param  int  $parent
     * @return array
     */
    public function whereParent($parent = null)
    {
        return \array_filter($this->menu, function ($item) use ($parent) {

            if ($item->get_pid() == $parent) {
                return true;
            }

            return false;
        });
    }

    /**
     * Filter menu items by user callback
     *
     * @param  callable $callback
     * @return Menu
     */
    public function filter($callback)
    {
        if (\is_callable($callback)) {
            $this->menu = \array_filter($this->menu, $callback);
        }

        return $this;
    }

    /**
     * Generate the menu items as list items using a recursive function
     *
     * @param string $type
     * @param int $pid
     * @return string
     */
    public function render($type = 'ul', $pid = null)
    {
        $items = '';
        $element = (\in_array($type, ['ul', 'ol'])) ? 'li' : $type;
        foreach ($this->whereParent($pid) as $item) {
            $items .= "\n<{$element}{$this->parseAttr($item->attributes())}>";
            $items .= "<a href=\"{$item->url()}\"{$this->parseAttr($item->getAttributes())}>{$item->text()}</a>";

            if ($item->hasChildren()) {
                $items .= "<{$type} class=\"dropdown-menu\">";
                $items .= $this->render($type, $item->get_id());
                $items .= "</{$type}>";
            }

            $items .= "</{$element}>";
        }

        return $items;
    }

    /**
     * Return url
     *
     * @param array|string  $options
     * @return string
     */
    public function getUrl($options)
    {
        if (!\is_array($options)) {
            return $options;
        } elseif (isset($options['url'])) {
            return $options['url'];
        }

        return null;
    }

    /**
     * Extract valid html attributes from user's options
     *
     * @param  array $options
     * @return array
     */
    public function extractAttr($options)
    {
        return \array_diff_key($options, \array_flip($this->reserved));
    }

    /**
     * Generate an string of key=value pairs from item attributes
     *
     * @param  array  $attributes
     * @return string
     */
    public function parseAttr($attributes)
    {
        $html = array();
        foreach ($attributes as $key => $value) {
            if (\is_numeric($key)) {
                $key = $value;
            }

            $element = (!\is_null($value)) ? $key . '="' . $value . '"' : null;

            if (!\is_null($element)) $html[] = $element;
        }

        return \count($html) > 0 ? ' ' . \implode(' ', $html) : '';
    }

    /**
     * Count number of items in the menu
     *
     * @return int
     */
    public function count()
    {
        return \count($this->menu);
    }

    /**
     * Returns the menu as an unordered list.
     *
     * @return string
     */
    public function renderUnordered($attributes = array())
    {
        return "<ul{$this->parseAttr($attributes)}>{$this->render('ul')}</ul>";
    }

    /**
     * Returns the menu as an ordered list.
     *
     * @return string
     */
    public function renderOrdered($attributes = array())
    {
        return "<ol{$this->parseAttr($attributes)}>{$this->render('ol')}</ol>";
    }

    /**
     * Returns the menu as div.
     *
     * @return string
     */
    public function renderDiv($attributes = array())
    {
        return "<div{$this->parseAttr($attributes)}>{$this->render('div')}</div>";
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
