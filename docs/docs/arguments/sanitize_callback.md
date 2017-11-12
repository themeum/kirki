---
layout: default
title: sanitize_callback
published: true
mainMaxWidth: 50rem;
---

WordPress requires you to define a `sanitize_callback` for every option you create, which is a great for security purposes.

In Kirki depending on the control-type you're using we're automatically setting a `sanitize_callback` for all your fields so you don't have to.

However, in case you want to override the default sanitization you can enter a callable function or method here. If you use a function then you must set this value to a string (the function name) and if you use a method then you must set this to an array. (example: `array( $object, $method_name )`).
