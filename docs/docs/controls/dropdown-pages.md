---
layout: default
title: The "dropdown-pages" control
slug: dropdown-pages
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: int
---

Exactly the same as [`select`](select) controls.

The only difference is that the field `type` is defined as `dropdown-pages` and it will show a list of your pages. As a result, you don't have to manually define the `choices` argument as it will be auto-populated using your pages.

The default value for dropdown-pages controls can be a page ID (int).

example: `'default' => 42,`
The returned value is the ID of the selected page.
