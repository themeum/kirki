---
layout: default
title: The "switch" control
slug: switch
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: boolean
---


Switches provide a simple way to turn on/off options. They return a `boolean` so you can easily check their value in your code and act on them.

Switch controls are internally [`checkbox`](checkbox) controls styled differently.

One main difference that `switch` controls have from [`checkbox`](checkbox) and [`toggle`](toggle) controls is that on switches you can change their labels.

By default the labels are ON/OFF. To change them you can use the `choices` argument:

```php
'choices' => array(
    'on'  => esc_attr__( 'Enable', 'textdomain' ),
    'off' => esc_attr__( 'Disable', 'textdomain' )
)
```
