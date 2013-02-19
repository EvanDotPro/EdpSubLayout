EdpSubLayout
================
Version 1.0 Created by Evan Coury

Introduction
------------

EdpSubLayout is a very simple ZF2 module which allows you to specify a layout... within your layout. Yep.

Usage
-----

```php
public function fooAction()
{
    $this->subLayout('some/other-layout');
}
```
