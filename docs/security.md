# Security
We take security seriously and we have multiple checks throughout the code.

All fields in the customizer have a `sanitize_callback` defined by default, no matter if you specify it or not. Of course if you specify your own `sanitize_callback` in a field your selection will override the default callback, so you're still free to do whatever you wish, but for security reasons if you don't include one we will use one of our own instead, based on the field type.

The only exception is the `custom` control. The purpose of that control is to allow developers to output raw HTML and should be used with caution. When you're creating a custom control please use valid HTML.
