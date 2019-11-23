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
    public $text;

    /**
     * Hyperlink's URL
     *
     * @var string
     */
    public $url;

    /**
     * Hyperlink's attributes
     *
     * @var array
     */
    public $attributes;

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
        $this->attributes(['class' => $class]);

        return $this;
    }

    public function renderAttributes(): string
    {
        if (empty($this->attributes)) {
            return '';
        }

        $attributeStrings = [];
        foreach ($this->attributes as $attribute => $value) {
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
