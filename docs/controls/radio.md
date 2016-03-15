---
layout: docs-field
title: radio
sections:
  - Arguments
  - Example
edit: docs/controls/radio.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>radio</code>.
  - argument: default
    required: "yes"
    type: string
    description: Use the key of one of the items in the <code>choices</code> argument.
  - argument: choices
    required: "yes"
    type: array
    description: Use an array of elements. Format <code>$key => $label</code>.
---
