
The functionality of `spacing` controls is similar to that of `dimension` controls:
They  allow you to add inputs that get sanitized as CSS dimensions (example: `10px`, `3em`, `48%`, `90vh` etc.).
The difference between `spacing` and `dimension` controls is that `spacing` controls allow you to control the left/right/top/bottom spacing of an element, and they save their values as an array instead of a string.

Invalid values are not saved, and the preview refresh is only triggered once a valid value has been entered.
