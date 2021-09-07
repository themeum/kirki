wp.customize.controlConstructor["kirki-date"]=wp.customize.kirkiDynamicControl.extend({initKirkiControl:function(t){var i;i=(t=t||this).selector+" input.datepicker",jQuery(i).datepicker({dateFormat:"yy-mm-dd"}),this.container.on("change keyup paste","input.datepicker",(function(){t.setting.set(jQuery(this).val())}))}});
//# sourceMappingURL=control.js.map
