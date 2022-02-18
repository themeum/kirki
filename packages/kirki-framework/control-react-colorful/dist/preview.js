/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************!*\
  !*** ./src/preview.js ***!
  \************************/
(() => {
  /**
   * Check if the provided value is a numeric.
   *
   * Thanks to Dan (https://stackoverflow.com/users/17121/dan) for his answer on StackOverflow:
   * @see https://stackoverflow.com/questions/175739/built-in-way-in-javascript-to-check-if-a-string-is-a-valid-number#answer-175787
   *
   * @param {string|number} str The provided value.
   * @return bool
   */
  const isNumeric = str => {
    // Number is a numeric.
    if ('number' === typeof str) return true; // We only process strings.

    if ('string' !== typeof str) return false; // Use type coercion to parse the entirety of the string (`parseFloat` alone does not do this) and ensure strings of whitespace fail.

    return !isNaN(str) && !isNaN(parseFloat(str));
  };
  /**
   * Generate value from color object.
   *
   * @param {Object} value The value.
   * @return string
   */


  const generateStringValue = value => {
    alphaEnabled = false;

    if (value.r || value.g || value.b) {
      colorMode = "undefined" !== typeof value.a ? 'rgba' : 'rgb';
      alphaEnabled = 'rgba' === colorMode ? true : alphaEnabled;
      pos1 = value.r;
      pos2 = value.g;
      pos3 = value.b;
      pos4 = 'rgba' === colorMode ? value.a : 1;
    } else if (value.h || value.s) {
      pos1 = value.h;

      if (value.l) {
        colorMode = "undefined" !== typeof value.a ? 'hsla' : 'hsl';
        pos2 = isNumeric(value.l) ? value.l + '%' : value.l;
      } else if (value.v) {
        colorMode = "undefined" !== typeof value.a ? 'hvla' : 'hvl';
        pos2 = isNumeric(value.v) ? value.v + '%' : value.v;
      }

      alphaEnabled = 'hsla' === colorMode || 'hsva' === colorMode ? true : alphaEnabled;
      pos3 = isNumeric(value) ? value.s + '%' : value.s;
      pos4 = alphaEnabled ? value.a : 1;
    }

    if (alphaEnabled) {
      formattedValue = colorMode + '(' + pos1 + ', ' + pos2 + ', ' + pos3 + ', ' + pos4 + ')';
    } else {
      formattedValue = colorMode + '(' + pos1 + ', ' + pos2 + ', ' + pos3 + ')';
    }

    return formattedValue;
  };
  /**
   * Function to hook into `kirkiPostMessageStylesOutput` filter.
   *
   * @param {string} styles The styles to be filtered.
   * @param {string|Object|int} value The control's value.
   * @param {Object} output The control's output argument.
   * @param {string} controlType The control type.
   *
   * @return {string} The filtered styles.
   */


  const stylesOutput = (styles, value, output, controlType) => {
    if ('kirki-react-colorful' !== controlType) return styles;
    if ('string' === typeof value || 'number' === typeof value) return styles;
    const prefix = output.prefix ? output.prefix : '';
    const suffix = output.suffix ? output.suffix : "";
    styles += output.element + '{' + output.property + ': ' + prefix + generateStringValue(value) + suffix + ';\
		}';
    return styles;
  }; // Hook the function to the `kirkiPostMessageStylesOutput` filter.


  wp.hooks.addFilter('kirkiPostMessageStylesOutput', 'kirki', stylesOutput);
})();
/******/ })()
;
//# sourceMappingURL=preview.js.map