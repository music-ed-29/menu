# menu

[![Build Status](https://travis-ci.org/symplely/menu.svg?branch=master)](https://travis-ci.org/symplely/menu)[![Build status](https://ci.appveyor.com/api/projects/status/cja0ddhr67kb2que/branch/master?svg=true)](https://ci.appveyor.com/project/techno-express/menu/branch/master)[![codecov](https://codecov.io/gh/symplely/menu/branch/master/graph/badge.svg)](https://codecov.io/gh/symplely/menu)[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c34a13a639914bf79456f43ba3341e20)](https://www.codacy.com/manual/techno-express/menu?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=symplely/menu&amp;utm_campaign=Badge_Grade)[![Maintainability](https://api.codeclimate.com/v1/badges/092f4b13fa8c12896a22/maintainability)](https://codeclimate.com/github/symplely/menu/maintainability)

A simple menu builder in PHP

## Installation

To install this library make sure you have [composer](https://getcomposer.org/) installed, then run following command:

```shell
composer require symplely/menu
```

## Usage

```php
<?php
require_once 'vendor/autoload.php';

$menu = new Async\Menu\Menu;

$menu->add('Home', '');

$about = $menu->add('About', 'about');

// since this item has sub items we append a caret icon to the hyperlink text
$about->link->append(' <span class="caret"></span>');

// we can attach HTML attributes to the hyper-link as well
$about->link->attributes(['class' => 'link-item', 'target' => '_blank']);

$about->attributes('data-model', 'nice');

$t = $about->add('Who we are?', array('url' => 'who-we-are',  'class' => 'navbar-item whoweare'));
$about->add('What we do?', array('url' => 'what-we-do',  'class' => 'navbar-item whatwedo'));


$menu->add('Portfolio', 'portfolio');
$menu->add('Contact',   'contact');

// we're only going to hide items with `display` set to **false**
$menu->filter( function($item) {
    if( $item->meta('display') === false) {
        return false;
    }
    return true;
});

// Now we can render the menu as various HTML entities:
echo $menu->renderUnordered( ['class' => 'class-ul'] );

// OR
echo $menu->renderOrdered( ['class' => 'class-ol'] );

// OR
echo $menu->renderDiv( ['class' => 'class-div'] );
```
