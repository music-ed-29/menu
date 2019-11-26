<?php

namespace Async\Menu\Test;

use Async\Menu\Menu;
use PHPUnit\Framework\TestCase;

class CoreTest extends TestCase
{
    public function testBootstrapMenu()
    {
        $builder = new Menu;

        $builder->add('Home');
        $about = $builder->add('About', 'about');
        $about->add('Help', 'help');
        $builder->add('Services', 'services');
        $builder->add('Contact', 'contact');

        $this->assertEquals('<li><a href="">Home</a></li>
<li class="dropdown"><a href="about" class="dropdown-toggle" data-toggle="dropdown">About <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li><a href="help">Help</a></li>
    </ul>
</li>
<li><a href="services">Services</a></li>
<li><a href="contact">Contact</a></li>
', \bootstrap_menu($builder));
    }

    public function testCreateMenu()
    {
        $builder = \create_menu('#', 'top', 'home');

        $this->assertInstanceOf(\Async\Menu\Menu::class, $builder);

        $this->assertEquals("\n".'<li><a href="#"><i class="fa fa-home lg"></i> top</a></li>', $builder->render());
    }

    public function testCreateMenuSub()
    {
        $builder = \create_menu('#', 'top', 'home');
        $subBuilder = \create_menuSub($builder,'/','Sub', 'arrow');

        $this->assertInstanceOf(\Async\Menu\Item::class, $subBuilder);
        $this->assertEquals("\n".'<li><a href="#"><i class="fa fa-home lg"></i> top</a></li>
<li class="submenu"><a href="/"><i class="fa fa-arrow lg"></i> Sub <span class="caret"></span></a></li>', $subBuilder->render());
    }

    public function testCreateMenuItem()
    {
        $builder = \create_menu('#', 'top', 'home');
        $subBuilder = \create_menuSub($builder,'/','Sub', 'arrow');
        \create_menuItem($subBuilder,'/sub','Item', '/image', 'img');

        $this->assertInstanceOf(\Async\Menu\Item::class, $subBuilder);
        $this->assertEquals("\n".'<li><a href="#"><i class="fa fa-home lg"></i> top</a></li>
<li class="submenu"><a href="/"><img src="/image" class="icon" width="14px" height="14px"> <i class="fa fa-arrow lg"></i> Sub <span class="caret"></span></a>
<ul class="dropdown-menu">
<li><a href="/sub">Item</a></li></ul></li>', $subBuilder->render());
    }
}
