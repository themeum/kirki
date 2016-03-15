
We extend WordPress Core's `select` controls and all `select` controls created using Kirki will use the [selectize.js](http://brianreavis.github.io/selectize.js/) script.

### Multi-Select

The `multiple` argument allows you to define the maximum number of simultaneous selections a user can make.
If `multiple` is set to `1` then users will be able to select a single option like on a normal dropdown.
If `multiple` is set to `2` for example, the user will be able to select 2 items from the dropdown, as well as re-order their selections using drag-n-drop.
To allow unlimited options simply set a high number like `999`.

If `multiple` is set to `1` then the saved value will be a string.
If `multiple` is set to a value greater than 1 and the user selects multiple elements then the saved value will be an array of all the selected values.
