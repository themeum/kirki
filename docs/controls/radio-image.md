---
layout: docs-field
title: radio-image
returns: string
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>radio-image</code>.
  - argument: default
    required: "yes"
    type: string
    description: Use the key of one of the items in the <code>choices</code> argument.
  - argument: choices
    required: "yes"
    type: array
    description: Use an array of elements. Format <code>$key => $url</code>.
---
