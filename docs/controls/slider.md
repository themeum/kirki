---
layout: docs-field
title: slider
returns: string
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>slider</code>.
  - argument: default
    required: "yes"
    type: string|int|float
    description: Default numeric value. We recommend you format this as a string (wrap it in quotes).
  - argument: choices
    required: "yes"
    type: array
    description: Define the minimum value, maximum value, and step. Example <code>'choices' => array( 'min' => '0', 'max' => '100', 'step' => '1' )</code>.
---
