
Switches provide a simple way to turn on/off options. They return a `boolean` so you can easily check their value in your code and act on them (check the examples for more details).

Switch controls are internally [`checkbox`](https://aristath.github.io/kirki/docs/controls/checkbox) controls styled differently, inspired from Zurb's [Foundation Switches](http://foundation.zurb.com/sites/docs/switch.html).

One main difference that `switch` controls have from [`checkbox`](https://aristath.github.io/kirki/docs/controls/checkbox) and [`toggle`](https://aristath.github.io/kirki/docs/controls/toggle) controls is that on switches you can change their labels.

By default the labels are ON/OFF. To change them you can use the `choices` argument:

```php
'choices' => array(
    'on'  => esc_attr__( 'Enable', 'textdomain' ),
    'off' => esc_attr__( 'Disable', 'textdomain' )
)
```
