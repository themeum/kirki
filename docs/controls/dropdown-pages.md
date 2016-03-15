---
layout: docs-field
title: dropdown-pages
edit: docs/controls/dropdown-pages.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>dropdown-pages</code>
---


Exactly the same as **select** controls.

The only difference is that the field `type` is defined as `dropdown-pages` and it will show a list of your pages. As a result, you don't have to manually define the `choices` argument as it will be auto-populated using your pages.

The default value for dropdown-pages controls can be a page ID (int).

example: `'default' => 42,`
The returned value is the ID of the selected page.
