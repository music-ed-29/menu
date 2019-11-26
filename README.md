# menu

[![Build Status](https://travis-ci.org/symplely/menu.svg?branch=master)](https://travis-ci.org/symplely/menu)[![Build status](https://ci.appveyor.com/api/projects/status/cja0ddhr67kb2que/branch/master?svg=true)](https://ci.appveyor.com/project/techno-express/menu/branch/master)[![codecov](https://codecov.io/gh/symplely/menu/branch/master/graph/badge.svg)](https://codecov.io/gh/symplely/menu)[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c34a13a639914bf79456f43ba3341e20)](https://www.codacy.com/manual/techno-express/menu?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=symplely/menu&amp;utm_campaign=Badge_Grade)[![Maintainability](https://api.codeclimate.com/v1/badges/092f4b13fa8c12896a22/maintainability)](https://codeclimate.com/github/symplely/menu/maintainability)

A simple menu builder in PHP

## Installation

To install this library make sure you have [composer](https://getcomposer.org/) installed, then run following command:

```shell
composer require symplely/menu
```

## Usage

A **menu** can be instantiated and items can be added fluently with the `add` method,
which requires a __url__ and a string of __text__ as parameters.

```php
<?php
require_once 'vendor/autoload.php';

$menu = new Async\Menu\Menu;

// The main menu
$menu->add('Home', '');

// Creates a sub menu
$about = $menu->add('About', 'about');

// Creates a another sub menu from the sub menu, passing url and other attributes in key = value pair.
$support = $about->add('Who we are?', ['url' => 'who-we-are', 'class' => 'navbar-item who']);

// Add items to sub menu, passing url and other attributes in key = value pair.
$about->add('What we do?', ['url' => 'what-we-do', 'class' => 'navbar-item what']);

// Item has sub items we append a caret icon to the hyperlink text
$about->append(' <span class="caret"></span>');

// Or just the preset, $default = 'caret'
$about->caret($default);

// Attach HTML attributes to the hyper-link as a key = value array
$about->attributes(['class' => 'link-item', 'target' => '_blank']);

// Or Separately
$about->attributes('data-model', 'nice');

// Or the shorter
$about->addClass('link-item');
$about->addTarget('_blank');

// Add more items to the main menu
$menu->add('Portfolio', 'portfolio');
$menu->add('Contact', 'contact');

// we're only going to hide items with `display` set to **false**
$menu->filter( function($item) {
    if ($item->meta('display') === false) {
        return false;
    }
    return true;
});

// Now we can render the menu as various HTML entities:
echo $menu->renderUnordered(['class' => 'some-ul']);

// OR
echo $menu->renderOrdered(['class' => 'some-ol']);

// OR
echo $menu->renderDiv(['class' => 'some-div']);

// For bootstrap users
echo bootstrap_menu($menu);
```

Let's get things started by building a simple menu with two links. All of the following examples are using classes from the `Async\Menu` namespace.

```html
<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/about">About</a></li>
</ul>
```

```php
$menu = new Link;
$menu->add('Home', '/')
$menu->add('About', '/about'));
```

When we render or echo the menu, it will output our intended html string.

```php
// Via the `render` method:
echo $menu->render();

// Or just through `__toString`:
echo $menu;
```

```html
<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/about">About</a></li>
</ul>
```

## The functional approach

```php
$menuInstance = \create_menu($url, $urlName, $iconImage, $iconType, $anyPreviousMenuInstance);
$subMenu = \create_menuSub($menuInstance, $url, $urlName, $iconImage, $iconType);
\create_menuItem($subMenu, $url, $urlName, $iconImage, $iconType);

print $menuInstance->render());
// Or
print \bootstrap_menu($menuInstance);
```
