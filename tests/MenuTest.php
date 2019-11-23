<?php

namespace Async\Menu\Test;

use Async\Menu\Menu;
use PHPUnit\Framework\TestCase;

class MenuTests extends TestCase
{
    protected $menu;

    public function assertHtmlEquals(string $expected, string $actual, string $message = '')
    {
        $this->assertEquals(
            $this->sanitizeHtmlWhitespace($expected),
            $this->sanitizeHtmlWhitespace($actual),
            $message
        );
    }

    protected function sanitizeHtmlWhitespace(string $subject): string
    {
        $find = ['/>\s+</', '/(^\s+)|(\s+$)/'];
        $replace = ['><', ''];
        return preg_replace($find, $replace, $subject);
    }

    public function assertRenders(string $expected)
    {
        $this->assertHtmlEquals($expected, $this->menu->render());
    }
    public function testBasic()
    {
        $builder = new Menu();

        $builder->add('Home');
        $builder->add('About', 'about');
        $builder->add('Services', 'services');
        $builder->add('Contact', 'contact');

        $this->assertEquals('<ul>
<li><a href="">Home</a></li>
<li><a href="about">About</a></li>
<li><a href="services">Services</a></li>
<li><a href="contact">Contact</a></li></ul>', $builder->renderUnordered());
        $this->assertEquals('<ol>
<li><a href="">Home</a></li>
<li><a href="about">About</a></li>
<li><a href="services">Services</a></li>
<li><a href="contact">Contact</a></li></ol>', $builder->renderOrdered());
        $this->assertEquals('<div>
<div><a href="">Home</a></div>
<div><a href="about">About</a></div>
<div><a href="services">Services</a></div>
<div><a href="contact">Contact</a></div></div>', $builder->renderDiv());
    }
}
