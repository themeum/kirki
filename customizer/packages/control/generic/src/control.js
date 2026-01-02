wp.customize.controlConstructor["kirki-generic"] =
  wp.customize.kirkiDynamicControl.extend({
    initKirkiControl: function (_control) {
      const control = _control ?? this;
      const params = control.params;
      const container = control.container[0] || control.container;

      // Handle both 'change' and 'input' events using event delegation
      const handleInputChange = function (event) {
        // Only handle input and textarea elements
        if (
          event.target &&
          (event.target.tagName === "INPUT" || event.target.tagName === "TEXTAREA")
        ) {
          let value = event.target.value;

          // Apply min/max validation for number inputs
          if (
            "kirki-generic" === params.type &&
            params.choices &&
            "number" === params.choices.type
          ) {
            params.choices.min = parseFloat(params.choices.min);
            params.choices.max = parseFloat(params.choices.max);

            // Parse the value as a number for comparison
            const numValue = parseFloat(value);

            if (!isNaN(numValue)) {
              if (numValue < params.choices.min) {
                value = params.choices.min;
                // Update the input value if it was clamped
                event.target.value = value;
              } else if (numValue > params.choices.max) {
                value = params.choices.max;
                // Update the input value if it was clamped
                event.target.value = value;
              }
            }
          }

          control.setting.set(value);
        }
      };

      container.addEventListener("change", handleInputChange);
      container.addEventListener("input", handleInputChange);
    },
  });
