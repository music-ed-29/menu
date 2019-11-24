<?php

namespace Async\Menu\Test;

use Async\Menu\Link;
use PHPUnit\Framework\TestCase;

class LinkTest extends TestCase
{
    public function testText()
    {
        $link = new Link('Home', 'https://test.menu');
        $this->assertEquals(
            'Home',
            $link->text()
        );
    }

    public function testUrl()
    {
        $link = new Link('Home', 'https://test.menu');
        $this->assertEquals(
            'https://test.menu',
            $link->url()
        );
    }

    public function testRendered()
    {
        $link = new Link('Home', 'https://test.menu');
        $this->assertEquals(
            '<a href="https://test.menu">Home</a>',
            $link->render()
        );
    }

    public function testRenderClasses()
    {
        $link = new Link('Home', 'https://test.menu');
        $this->assertEquals(
            '<a href="https://test.menu" class="home">Home</a>',
            $link->addClass('home')->render()
        );
    }

    public function testRenderTargetToString()
    {
        $link = new Link('Home', 'https://test.menu');
        $link->addTarget('test');
        $this->assertEquals(
            '<a target="test" href="https://test.menu">Home</a>',
            $link
        );
    }

    public function testRenderAttributes()
    {
        $link = new Link('Home', 'https://test.menu');
        $this->assertEquals(
            '<a data-home-link href="https://test.menu">Home</a>',
            $link->setAttributes(['data-home-link'])->render()
        );
    }
}
