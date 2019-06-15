---
layout: default
title: Telemetry module
subtitle: Statistics for Kirki plugin usage with themes.
mainMaxWidth: 55rem;
bodyClasses: page module
---

Starting with version 3.0.36, Kirki includes a new Telemetry module.
This allows us to gather statistics about which themes are most used with Kirki, and also which field-types most theme-developers use.
When not disabled, a notice will be shown to administrators of a site, asking for their consent to send data. In the consent notice, users are able to see exactly what data they will send.

Once they consent, the following data is sent:

* PHP Version
* Theme Name
* Theme Author
* Theme URI
* Kirki Field-Types used.

We then use that information to prioritize development of the most necessary and widely used field-types, and try to collaborate with the top themes to improve the whole ecosystem.

We believe in complete transparency so all that information is [publicly available](https://wplemon.com/kirki-telemetry-statistics/)

The code we use on our server to store and display the data is also [available to everyone on Github](https://github.com/aristath/kirki-telemetry-server)

Both Kirki and themes will benefit from the data gathered and we hope this will lead to more collaboration efforts between the kirki plugin developers and themes that use the framework in order to more efficiently and effectively improve them both.

You can disable the telemetry module in your theme if you want by adding the following line:

```php
add_filter( 'kirki_telemetry', '__return_false' );
```