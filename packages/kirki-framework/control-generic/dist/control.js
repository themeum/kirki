wp.customize.controlConstructor["kirki-generic"]=wp.customize.kirkiDynamicControl.extend({initKirkiControl:function(i){(i=i||this).container.find("input, textarea").on("change keyup paste click",(function(){i.setting.set(jQuery(this).val())}))}});
//# sourceMappingURL=control.js.map
