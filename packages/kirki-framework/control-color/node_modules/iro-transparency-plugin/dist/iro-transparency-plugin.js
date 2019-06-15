/*!
 * iro-transparency-plugin v1.0.2
 * Adds comprehensive transparency support to iro.js
 * 2019 James Daniel
 * Licensed under MPL 2.0
 * github.com/jaames/iro-transparency-plugin
 */
(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define("iroTransparencyPlugin", [], factory);
	else if(typeof exports === 'object')
		exports["iroTransparencyPlugin"] = factory();
	else
		root["iroTransparencyPlugin"] = factory();
})(typeof self !== 'undefined' ? self : this, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./TransparencySlider.jsx":
/*!********************************!*\
  !*** ./TransparencySlider.jsx ***!
  \********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/* harmony default export */ __webpack_exports__["default"] = (function (_ref, _ref2) {
  var h = _ref.h,
      Slider = _ref.Slider,
      Handle = _ref.Handle;
  var resolveUrl = _ref2.resolveUrl;

  var IroTransparencySlider =
  /*#__PURE__*/
  function (_Slider) {
    _inherits(IroTransparencySlider, _Slider);

    function IroTransparencySlider() {
      _classCallCheck(this, IroTransparencySlider);

      return _possibleConstructorReturn(this, _getPrototypeOf(IroTransparencySlider).apply(this, arguments));
    }

    _createClass(IroTransparencySlider, [{
      key: "render",
      value: function render(props) {
        var width = props.width,
            sliderHeight = props.sliderHeight,
            borderWidth = props.borderWidth,
            handleRadius = props.handleRadius;
        sliderHeight = sliderHeight ? sliderHeight : props.padding * 2 + handleRadius * 2 + borderWidth * 2;
        this.width = width;
        this.height = sliderHeight;
        var cornerRadius = sliderHeight / 2;
        var range = width - cornerRadius * 2;
        var hslString = props.color.hslString;
        var alpha = props.color.hsva.a;
        return h("svg", {
          class: "iro__slider iro__slider--transparency",
          width: width,
          height: sliderHeight,
          style: {
            marginTop: props.sliderMargin,
            overflow: 'visible',
            display: 'block'
          }
        }, h("defs", null, h("linearGradient", {
          id: "gradient_".concat(this.uid)
        }, h("stop", {
          offset: "0%",
          "stop-color": hslString,
          "stop-opacity": "0"
        }), h("stop", {
          offset: "100%",
          "stop-color": hslString,
          "stop-opacity": "1"
        })), h("pattern", {
          id: "grid_".concat(this.uid),
          width: "8",
          height: "8",
          patternUnits: "userSpaceOnUse"
        }, h("rect", {
          class: "iro__slider__grid",
          x: "0",
          y: "0",
          width: "4",
          height: "4",
          fill: "#fff"
        }), h("rect", {
          class: "iro__slider__grid iro__slider__grid--alt",
          x: "4",
          y: "0",
          width: "4",
          height: "4",
          fill: "#ccc"
        }), h("rect", {
          class: "iro__slider__grid",
          x: "4",
          y: "4",
          width: "4",
          height: "4",
          fill: "#fff"
        }), h("rect", {
          class: "iro__slider__grid iro__slider__grid--alt",
          x: "0",
          y: "4",
          width: "4",
          height: "4",
          fill: "#ccc"
        })), h("pattern", {
          id: "fill_".concat(this.uid),
          width: "100%",
          height: "100%"
        }, h("rect", {
          x: "0",
          y: "0",
          width: "100%",
          height: "100%",
          fill: "url(".concat(resolveUrl('#grid_' + this.uid), ")")
        }), h("rect", {
          x: "0",
          y: "0",
          width: "100%",
          height: "100%",
          fill: "url(".concat(resolveUrl('#gradient_' + this.uid), ")")
        }))), h("rect", {
          class: "iro__slider__value",
          rx: cornerRadius,
          ry: cornerRadius,
          x: borderWidth / 2,
          y: borderWidth / 2,
          width: width - borderWidth,
          height: sliderHeight - borderWidth,
          "stroke-width": borderWidth,
          stroke: props.borderColor,
          fill: "url(".concat(resolveUrl('#fill_' + this.uid), ")")
        }), h(Handle, {
          r: handleRadius,
          url: props.handleSvg,
          origin: props.handleOrigin,
          x: cornerRadius + alpha * range,
          y: sliderHeight / 2
        }));
      }
    }, {
      key: "handleInput",
      value: function handleInput(x, y, bounds, type) {
        this.props.onInput(type, {
          a: this.getValueFromPoint(x, y, bounds) / 100
        });
      }
    }]);

    return IroTransparencySlider;
  }(Slider);

  return IroTransparencySlider;
});

/***/ }),

/***/ "./index.js":
/*!******************!*\
  !*** ./index.js ***!
  \******************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TransparencySlider_jsx__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TransparencySlider.jsx */ "./TransparencySlider.jsx");
function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



var TransparencyPlugin = function TransparencyPlugin(iro, pluginOptions) {
  var TransparencySlider = Object(_TransparencySlider_jsx__WEBPACK_IMPORTED_MODULE_0__["default"])(iro.ui, iro.util);
  var _iro$util = iro.util,
      parseHexInt = _iro$util.parseHexInt,
      parseUnit = _iro$util.parseUnit,
      intToHex = _iro$util.intToHex;
  iro.ColorPicker.addHook('init:after', function () {
    if (this.props.transparency) {
      this.layout.push({
        component: TransparencySlider,
        options: {}
      });
    }
  }); // extend set method to work with alpha colors

  var set = iro.Color.prototype.set;

  iro.Color.prototype.set = function (value) {
    var isObject = _typeof(value) === 'object';

    if (isObject && 'r' in value && 'g' in value && 'b' in value && 'a' in value) {
      this.rgba = value;
    } else if (isObject && 'h' in value && 's' in value && 'v' in value && 'a' in value) {
      this.hsva = value;
    } else if (isObject && 'h' in value && 's' in value && 'l' in value && 'a' in value) {
      this.hsla = value;
    } else {
      set.call(this, value);
    }
  }; // add extra properties to color class


  Object.defineProperties(iro.Color.prototype, {
    hsva: {
      get: function get() {
        var value = this._value;
        return {
          h: value.h,
          s: value.s,
          v: value.v,
          a: value.a
        };
      },
      set: function set(value) {
        this.hsv = value;
      }
    },
    alpha: {
      get: function get() {
        var a = this._value.a;
        return a;
      },
      set: function set(value) {
        this.hsv = _objectSpread({}, this.hsv, {
          a: value
        });
      }
    },
    rgba: {
      get: function get() {
        return _objectSpread({}, this.rgb, {
          a: this.alpha
        });
      },
      set: function set(value) {
        var a = value.a,
            rgb = _objectWithoutProperties(value, ["a"]);

        this.rgb = rgb;
        this.alpha = a;
      }
    },
    hsla: {
      get: function get() {
        return _objectSpread({}, this.hsl, {
          a: this.alpha
        });
      },
      set: function set(value) {
        var a = value.a,
            hsl = _objectWithoutProperties(value, ["a"]);

        this.hsl = hsl;
        this.alpha = a;
      }
    },
    hex8String: {
      get: function get() {
        var _this$rgba = this.rgba,
            r = _this$rgba.r,
            g = _this$rgba.g,
            b = _this$rgba.b,
            a = _this$rgba.a;
        return "#".concat(intToHex(r)).concat(intToHex(g)).concat(intToHex(b)).concat(intToHex(Math.floor(a * 255)));
      },
      set: function set(value) {
        this.hexString = value;
      }
    },
    rgbaString: {
      get: function get() {
        var _this$rgba2 = this.rgba,
            r = _this$rgba2.r,
            g = _this$rgba2.g,
            b = _this$rgba2.b,
            a = _this$rgba2.a;
        return "rgba(".concat(r, ", ").concat(g, ", ").concat(b, ", ").concat(a, ")");
      },
      set: function set(value) {
        this.rgbString = value;
      }
    },
    hslaString: {
      get: function get() {
        var _this$hsla = this.hsla,
            h = _this$hsla.h,
            s = _this$hsla.s,
            l = _this$hsla.l,
            a = _this$hsla.a;
        return "hsla(".concat(h, ", ").concat(s, "%, ").concat(l, "%, ").concat(a, ")");
      },
      set: function set(value) {
        this.hslString = value;
      }
    }
  });
  iro.ui.TransparencySlider = TransparencySlider;
  iro.transparencyPlugin = {
    version: "1.0.2"
  };
};

/* harmony default export */ __webpack_exports__["default"] = (TransparencyPlugin);

/***/ }),

/***/ 0:
/*!************************!*\
  !*** multi ./index.js ***!
  \************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./index.js */"./index.js");


/***/ })

/******/ })["default"];
});
//# sourceMappingURL=iro-transparency-plugin.js.map