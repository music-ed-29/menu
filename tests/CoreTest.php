<?php

namespace Async\Menu\Test;

use Async\Menu\Menu;
use PHPUnit\Framework\TestCase;

class CoreTest extends TestCase
{
    public function testCore()
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
</ul></li>
<li><a href="services">Services</a></li>
<li><a href="contact">Contact</a></li>
', \bootstrap_menu($builder));
    }
}
