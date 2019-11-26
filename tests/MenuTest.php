<?php

namespace Async\Menu\Test;

use Async\Menu\Menu;
use PHPUnit\Framework\TestCase;

class MenuTest extends TestCase
{
    public function testEmpty()
    {
        $menu = new Menu();
        $this->assertEquals('', $menu->render());
    }

    public function testBasic()
    {
        $builder = new Menu();

        $builder->add('Home', '/');
        $about = $builder->add('About', '/about');
        $about->add('Help', '/help');
        $about->caret();
        $builder->add('Services', '/services');
        $builder->add('Contact', '/contact');

        $this->assertEquals('<ul>
<li><a href="/">Home</a></li>
<li><a href="/about">About <span class="caret"></span></a>
<ul class="dropdown-menu">
<li><a href="/help">Help</a></li></ul></li>
<li><a href="/services">Services</a></li>
<li><a href="/contact">Contact</a></li></ul>', $builder->renderUnordered());
        $this->assertEquals('<ol>
<li><a href="/">Home</a></li>
<li><a href="/about">About <span class="caret"></span></a>
<ol class="dropdown-menu">
<li><a href="/help">Help</a></li></ol></li>
<li><a href="/services">Services</a></li>
<li><a href="/contact">Contact</a></li></ol>', $builder->renderOrdered());
        $this->assertEquals('<div>
<div><a href="/">Home</a></div>
<div><a href="/about">About <span class="caret"></span></a>
<div class="dropdown-menu">
<div><a href="/help">Help</a></div></div></div>
<div><a href="/services">Services</a></div>
<div><a href="/contact">Contact</a></div></div>', $builder->renderDiv());
    }
}