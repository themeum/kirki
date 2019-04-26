# control-background

The background control is a pseudo-control for the Kirki framework. The control itself doesn't exist, it it a proxy for more basic controls. It adds controls for the following properties:

* background-color
* background-image
* background-repeat
* background-position
* background-size
* background-attachment

In addition to the above visible controls, a hidden control is added which contains the value for the sum of the above sub-controls saved as an array.

The control is only useful when using the Kirki API (which is just a proxy for the WordPress-Core Customizer API) and can not be used as-is using the customizer API directly.

If you are using the customizer-api directly, you can see what the control does by examining the code it contains in `src/Field/Background.php` and extrapolating the fields you need to use directly from there.