---
layout: docs-field
title: repeater
returns: array
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>repeater</code>.
  - argument: default
    required: "no"
    type: array
    description: Use the key of one of the items in the <code>choices</code> argument.
  - argument: fields
    required: "yes"
    type: array
    description: "Define an array of fields that will be used. Each defined field must be an array."
  - argument: row_label
    required: "no"
    type: array
    description: "An array of settings for the display of each row produced by the repeater control."
  - argument: row_label['type']
    required: "no"
    type: string
    description: "Accepts `field` or `text` for type. Defaults to `text` if not specified."
  - argument: row_label['value']
    required: "no"
    type: string
    description: "When `row_label['type']` is set to `'text'` this is the text that appears in the label of each row.  Defaults to `'row'` if not specified.  Each row is appended with a number to represent it's instance.  If `row_label['type']` is set to `'field'` this will be the default text used if value is obtained from the specified field."
  - argument: row_label['field']
    required: "no"
    type: string
    description: "Accepts a field that is specifed in fields for the repeater control.  The field's value will be displayed as the row label, or default to the `row_label['value']` (used also for new rows)."
---
