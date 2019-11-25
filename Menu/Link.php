<?php

declare(strict_types=1);

namespace Async\Menu;

class Link
{
    /**
     * Hyperlink's text
     *
     * @var string
     */
    protected $text;

    /**
     * Hyperlink's URL
     *
     * @var string
     */
    protected $url;

    /**
     * Hyperlink's attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $classes = [];

    /**
     * Creates a hyperlink
     *
     * @param  string $title
     * @param  string  $url
     * @param  array  $attributes
     * @return void
     */
    public function __construct(?string $text, ?string $url, array $attributes = array())
    {
        $this->text = $text;

        $this->url = $url;

        $this->attributes = $attributes;
    }

    /**
     * Return hyperlink's URL
     *
     * @return string $url
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * Return hyperlink's title
     *
     * @return string $title
     */
    public function text()
    {
        return $this->text;
    }

    /**
     * Append content at the end of hyperlink's text
     *
     * @return Link
     */
    public function append($content)
    {
        $this->text .= $content;

        return $this;
    }

    public function caret(string $marker = 'caret')
    {
        $this->append(' <span class="' . $marker . '"></span>');

        return $this;
    }

    /**
     * Add content at the beginning of hyperlink's text
     *
     * @return Link
     */
    public function prepend($content)
    {
        $this->text = $content . $this->text;

        return $this;
    }

    public function addImage(?string $path = null, $class = 'icon')
    {
        return $this->prepend('<img src="' . $path . '" class="' . $class . '" width="14px" height="14px"> ');
    }

    public function addIcon(string $icon = 'icon')
    {
        return $this->prepend('<i class="fa fa-' . $icon . ' lg"></i> ');
    }

    /**
     * Add attributes to the hyperlink
     *
     * @param mixed $attributes
     * @return Link
     */
    public function attributes()
    {
        $args = \func_get_args();

        if (isset($args[0]) && \is_array($args[0])) {
            $this->attributes = \array_merge($this->attributes, $args[0]);
            return $this;
        } elseif (isset($args[0]) && isset($args[1])) {
            $this->attributes[$args[0]] = $args[1];
            return $this;
        } elseif (isset($args[0])) {
            return isset($this->attributes[$args[0]]) ? $this->attributes[$args[0]] : null;
        }

        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            if ($attribute === 'class') {
                $this->addClass($value);
                continue;
            }

            if (\is_int($attribute)) {
                $attribute = $value;
                $value = '';
            }

            $this->attributes($attribute, $value);
        }

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addClass($class)
    {
        if (!\is_array($class)) {
            $class = [$class];
        }

        $this->classes = \array_unique(
            \array_merge($this->classes, $class)
        );

        return $this;
    }

    public function addTarget(string $target = '_blank')
    {
        $this->attributes(['target' => $target]);

        return $this;
    }

    protected function renderAttributes(): string
    {
        if (empty($this->attributes) && empty($this->classes)) {
            return '';
        }

        $attributeStrings = [];

        $attributes = !empty($this->classes)
            ? \array_merge($this->attributes, ['class' => \implode(' ', $this->classes)])
            : $this->attributes;

        foreach ($attributes as $attribute => $value) {
            if (\is_null($value) || $value === '') {
                $attributeStrings[] = $attribute;
                continue;
            }

            $attributeStrings[] = "{$attribute}=\"{$value}\"";
        }

        return \implode(' ', $attributeStrings);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $this->attributes(['href' => $this->url]);
        return "<a {$this->renderAttributes()}>{$this->text}</a>";
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
