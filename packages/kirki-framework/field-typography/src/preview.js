/**
 * Hook in the kirkiPostMessageStylesOutput filter.
 *
 * Handles postMessage styles for typography controls.
 */
jQuery(document).ready(function () {
  wp.hooks.addFilter(
    "kirkiPostMessageStylesOutput",
    "kirki",

    /**
     * Append styles for this control.
     *
     * @param {string} styles      - The styles.
     * @param {Object} value       - The control value.
     * @param {Object} output      - The control's "output" argument.
     * @param {string} controlType - The control type.
     * @returns {string} - Returns the CSS as a string.
     */
    function (styles, value, output, controlType) {
      var googleFont = "",
        processedValue;

      if (value.variant) {
        value["font-weight"] =
          "regular" === value.variant || "italic" === value.variant
            ? 400
            : parseInt(value.variant, 10);

        value["font-style"] = value.variant.includes("italic")
          ? "italic"
          : "normal";
      }

      if ("kirki-typography" === controlType) {
        styles += output.element + "{";

        _.each(value, function (val, key) {
          if (output.choice && key !== output.choice) {
            return;
          }

          if ("variant" === key) {
            return;
          }

          processedValue = window.kirkiPostMessage.util.processValue(
            output,
            val
          );

          if (false !== processedValue) {
            styles += key + ":" + processedValue + ";";
          }
        });

        styles += "}";

        // Check if this is a googlefont so that we may load it.
        if (
          !_.isUndefined(window.WebFont) &&
          value["font-family"] &&
          kirkiGoogleFontNames.includes(value["font-family"])
        ) {
          // Calculate the googlefont params.
          googleFont = value["font-family"].replace(/\"/g, "&quot;"); // eslint-disable-line no-useless-escape

          if (value.variant) {
            if ("regular" === value.variant) {
              googleFont += ":400";
            } else if ("italic" === value.variant) {
              googleFont += ":400i";
            } else {
              googleFont += ":" + value.variant;
            }
          }

          googleFont +=
            ":cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese,hebrew,arabic,bengali,gujarati,tamil,telugu,thai";

          window.WebFont.load({
            google: {
              families: [googleFont],
            },
          });
        }
      }

      return styles;
    }
  );
});
