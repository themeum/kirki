---
layout: docs-field
title: select
returns: string | array
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>select</code>.
  - argument: default
    required: "yes"
    type: string|array
    description: If <code>multiple</code> is > 1 then use an <code>array</code>. If not, then a <code>string</code>.
  - argument: multiple
    required: "no"
    type: int
    description: The number of options users will be able to select simultaneously. Use <code>1</code> for single-select controls (defaults to <code>1</code>).
---
