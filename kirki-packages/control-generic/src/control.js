wp.customize.controlConstructor["kirki-generic"] =
  wp.customize.kirkiDynamicControl.extend({
    initKirkiControl: function (control) {
      control = control || this;
      const params = control.params;

      control.container.find("input, textarea").on("change input", function () {
        const value = jQuery(this).val();

        if (
          "kirki-generic" === params.type &&
          params.choices &&
          "number" === params.choices.type
        ) {
          params.choices.min = parseFloat(params.choices.min);
          params.choices.max = parseFloat(params.choices.max);

          if (value < params.choices.min) {
            value = params.choices.min;
          } else if (value > params.choices.max) {
            value = params.choices.max;
          }
        }

        control.setting.set(value);
      });
    },
  });
