// modules are defined as an array
// [ module function, map of requires ]
//
// map of requires is short require name -> numeric require
//
// anything defined in a previous bundle is accessed via the
// orig method which is the require for previous bundles

(function (modules, entry, mainEntry, parcelRequireName, globalName) {
  /* eslint-disable no-undef */
  var globalObject =
    typeof globalThis !== 'undefined'
      ? globalThis
      : typeof self !== 'undefined'
      ? self
      : typeof window !== 'undefined'
      ? window
      : typeof global !== 'undefined'
      ? global
      : {};
  /* eslint-enable no-undef */

  // Save the require from previous bundle to this closure if any
  var previousRequire =
    typeof globalObject[parcelRequireName] === 'function' &&
    globalObject[parcelRequireName];

  var cache = previousRequire.cache || {};
  // Do not use `require` to prevent Webpack from trying to bundle this call
  var nodeRequire =
    typeof module !== 'undefined' &&
    typeof module.require === 'function' &&
    module.require.bind(module);

  function newRequire(name, jumped) {
    if (!cache[name]) {
      if (!modules[name]) {
        // if we cannot find the module within our internal map or
        // cache jump to the current global require ie. the last bundle
        // that was added to the page.
        var currentRequire =
          typeof globalObject[parcelRequireName] === 'function' &&
          globalObject[parcelRequireName];
        if (!jumped && currentRequire) {
          return currentRequire(name, true);
        }

        // If there are other bundles on this page the require from the
        // previous one is saved to 'previousRequire'. Repeat this as
        // many times as there are bundles until the module is found or
        // we exhaust the require chain.
        if (previousRequire) {
          return previousRequire(name, true);
        }

        // Try the node require function if it exists.
        if (nodeRequire && typeof name === 'string') {
          return nodeRequire(name);
        }

        var err = new Error("Cannot find module '" + name + "'");
        err.code = 'MODULE_NOT_FOUND';
        throw err;
      }

      localRequire.resolve = resolve;
      localRequire.cache = {};

      var module = (cache[name] = new newRequire.Module(name));

      modules[name][0].call(
        module.exports,
        localRequire,
        module,
        module.exports,
        this
      );
    }

    return cache[name].exports;

    function localRequire(x) {
      var res = localRequire.resolve(x);
      return res === false ? {} : newRequire(res);
    }

    function resolve(x) {
      var id = modules[name][1][x];
      return id != null ? id : x;
    }
  }

  function Module(moduleName) {
    this.id = moduleName;
    this.bundle = newRequire;
    this.exports = {};
  }

  newRequire.isParcelRequire = true;
  newRequire.Module = Module;
  newRequire.modules = modules;
  newRequire.cache = cache;
  newRequire.parent = previousRequire;
  newRequire.register = function (id, exports) {
    modules[id] = [
      function (require, module) {
        module.exports = exports;
      },
      {},
    ];
  };

  Object.defineProperty(newRequire, 'root', {
    get: function () {
      return globalObject[parcelRequireName];
    },
  });

  globalObject[parcelRequireName] = newRequire;

  for (var i = 0; i < entry.length; i++) {
    newRequire(entry[i]);
  }

  if (mainEntry) {
    // Expose entry point to Node, AMD or browser globals
    // Based on https://github.com/ForbesLindesay/umd/blob/master/template.js
    var mainExports = newRequire(mainEntry);

    // CommonJS
    if (typeof exports === 'object' && typeof module !== 'undefined') {
      module.exports = mainExports;

      // RequireJS
    } else if (typeof define === 'function' && define.amd) {
      define(function () {
        return mainExports;
      });

      // <script>
    } else if (globalName) {
      this[globalName] = mainExports;
    }
  }
})({"hHzGY":[function(require,module,exports) {
"use strict";
var HMR_HOST = null;
var HMR_PORT = 1234;
var HMR_SECURE = false;
var HMR_ENV_HASH = "916932b22e4085ab";
module.bundle.HMR_BUNDLE_ID = "e057e161a2c0c609";
function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
}
function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
function _iterableToArray(iter) {
    if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
}
function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return _arrayLikeToArray(arr);
}
function _createForOfIteratorHelper(o, allowArrayLike) {
    var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"];
    if (!it) {
        if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") {
            if (it) o = it;
            var i = 0;
            var F = function F() {
            };
            return {
                s: F,
                n: function n() {
                    if (i >= o.length) return {
                        done: true
                    };
                    return {
                        done: false,
                        value: o[i++]
                    };
                },
                e: function e(_e) {
                    throw _e;
                },
                f: F
            };
        }
        throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
    }
    var normalCompletion = true, didErr = false, err;
    return {
        s: function s() {
            it = it.call(o);
        },
        n: function n() {
            var step = it.next();
            normalCompletion = step.done;
            return step;
        },
        e: function e(_e2) {
            didErr = true;
            err = _e2;
        },
        f: function f() {
            try {
                if (!normalCompletion && it.return != null) it.return();
            } finally{
                if (didErr) throw err;
            }
        }
    };
}
function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === "string") return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === "Object" && o.constructor) n = o.constructor.name;
    if (n === "Map" || n === "Set") return Array.from(o);
    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}
function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for(var i = 0, arr2 = new Array(len); i < len; i++)arr2[i] = arr[i];
    return arr2;
}
/* global HMR_HOST, HMR_PORT, HMR_ENV_HASH, HMR_SECURE */ /*::
import type {
  HMRAsset,
  HMRMessage,
} from '@parcel/reporter-dev-server/src/HMRServer.js';
interface ParcelRequire {
  (string): mixed;
  cache: {|[string]: ParcelModule|};
  hotData: mixed;
  Module: any;
  parent: ?ParcelRequire;
  isParcelRequire: true;
  modules: {|[string]: [Function, {|[string]: string|}]|};
  HMR_BUNDLE_ID: string;
  root: ParcelRequire;
}
interface ParcelModule {
  hot: {|
    data: mixed,
    accept(cb: (Function) => void): void,
    dispose(cb: (mixed) => void): void,
    // accept(deps: Array<string> | string, cb: (Function) => void): void,
    // decline(): void,
    _acceptCallbacks: Array<(Function) => void>,
    _disposeCallbacks: Array<(mixed) => void>,
  |};
}
declare var module: {bundle: ParcelRequire, ...};
declare var HMR_HOST: string;
declare var HMR_PORT: string;
declare var HMR_ENV_HASH: string;
declare var HMR_SECURE: boolean;
*/ var OVERLAY_ID = '__parcel__error__overlay__';
var OldModule = module.bundle.Module;
function Module(moduleName) {
    OldModule.call(this, moduleName);
    this.hot = {
        data: module.bundle.hotData,
        _acceptCallbacks: [],
        _disposeCallbacks: [],
        accept: function accept(fn) {
            this._acceptCallbacks.push(fn || function() {
            });
        },
        dispose: function dispose(fn) {
            this._disposeCallbacks.push(fn);
        }
    };
    module.bundle.hotData = undefined;
}
module.bundle.Module = Module;
var checkedAssets, acceptedAssets, assetsToAccept;
function getHostname() {
    return HMR_HOST || (location.protocol.indexOf('http') === 0 ? location.hostname : 'localhost');
}
function getPort() {
    return HMR_PORT || location.port;
} // eslint-disable-next-line no-redeclare
var parent = module.bundle.parent;
if ((!parent || !parent.isParcelRequire) && typeof WebSocket !== 'undefined') {
    var hostname = getHostname();
    var port = getPort();
    var protocol = HMR_SECURE || location.protocol == 'https:' && !/localhost|127.0.0.1|0.0.0.0/.test(hostname) ? 'wss' : 'ws';
    var ws = new WebSocket(protocol + '://' + hostname + (port ? ':' + port : '') + '/'); // $FlowFixMe
    ws.onmessage = function(event) {
        checkedAssets = {
        };
        acceptedAssets = {
        };
        assetsToAccept = [];
        var data = JSON.parse(event.data);
        if (data.type === 'update') {
            // Remove error overlay if there is one
            if (typeof document !== 'undefined') removeErrorOverlay();
            var assets = data.assets.filter(function(asset) {
                return asset.envHash === HMR_ENV_HASH;
            }); // Handle HMR Update
            var handled = assets.every(function(asset) {
                return asset.type === 'css' || asset.type === 'js' && hmrAcceptCheck(module.bundle.root, asset.id, asset.depsByBundle);
            });
            if (handled) {
                console.clear();
                assets.forEach(function(asset) {
                    hmrApply(module.bundle.root, asset);
                });
                for(var i = 0; i < assetsToAccept.length; i++){
                    var id = assetsToAccept[i][1];
                    if (!acceptedAssets[id]) hmrAcceptRun(assetsToAccept[i][0], id);
                }
            } else window.location.reload();
        }
        if (data.type === 'error') {
            // Log parcel errors to console
            var _iterator = _createForOfIteratorHelper(data.diagnostics.ansi), _step;
            try {
                for(_iterator.s(); !(_step = _iterator.n()).done;){
                    var ansiDiagnostic = _step.value;
                    var stack = ansiDiagnostic.codeframe ? ansiDiagnostic.codeframe : ansiDiagnostic.stack;
                    console.error('🚨 [parcel]: ' + ansiDiagnostic.message + '\n' + stack + '\n\n' + ansiDiagnostic.hints.join('\n'));
                }
            } catch (err) {
                _iterator.e(err);
            } finally{
                _iterator.f();
            }
            if (typeof document !== 'undefined') {
                // Render the fancy html overlay
                removeErrorOverlay();
                var overlay = createErrorOverlay(data.diagnostics.html); // $FlowFixMe
                document.body.appendChild(overlay);
            }
        }
    };
    ws.onerror = function(e) {
        console.error(e.message);
    };
    ws.onclose = function() {
        console.warn('[parcel] 🚨 Connection to the HMR server was lost');
    };
}
function removeErrorOverlay() {
    var overlay = document.getElementById(OVERLAY_ID);
    if (overlay) {
        overlay.remove();
        console.log('[parcel] ✨ Error resolved');
    }
}
function createErrorOverlay(diagnostics) {
    var overlay = document.createElement('div');
    overlay.id = OVERLAY_ID;
    var errorHTML = '<div style="background: black; opacity: 0.85; font-size: 16px; color: white; position: fixed; height: 100%; width: 100%; top: 0px; left: 0px; padding: 30px; font-family: Menlo, Consolas, monospace; z-index: 9999;">';
    var _iterator2 = _createForOfIteratorHelper(diagnostics), _step2;
    try {
        for(_iterator2.s(); !(_step2 = _iterator2.n()).done;){
            var diagnostic = _step2.value;
            var stack = diagnostic.codeframe ? diagnostic.codeframe : diagnostic.stack;
            errorHTML += "\n      <div>\n        <div style=\"font-size: 18px; font-weight: bold; margin-top: 20px;\">\n          \uD83D\uDEA8 ".concat(diagnostic.message, "\n        </div>\n        <pre>").concat(stack, "</pre>\n        <div>\n          ").concat(diagnostic.hints.map(function(hint) {
                return '<div>💡 ' + hint + '</div>';
            }).join(''), "\n        </div>\n        ").concat(diagnostic.documentation ? "<div>\uD83D\uDCDD <a style=\"color: violet\" href=\"".concat(diagnostic.documentation, "\" target=\"_blank\">Learn more</a></div>") : '', "\n      </div>\n    ");
        }
    } catch (err) {
        _iterator2.e(err);
    } finally{
        _iterator2.f();
    }
    errorHTML += '</div>';
    overlay.innerHTML = errorHTML;
    return overlay;
}
function getParents(bundle, id) /*: Array<[ParcelRequire, string]> */ {
    var modules = bundle.modules;
    if (!modules) return [];
    var parents = [];
    var k, d, dep;
    for(k in modules)for(d in modules[k][1]){
        dep = modules[k][1][d];
        if (dep === id || Array.isArray(dep) && dep[dep.length - 1] === id) parents.push([
            bundle,
            k
        ]);
    }
    if (bundle.parent) parents = parents.concat(getParents(bundle.parent, id));
    return parents;
}
function updateLink(link) {
    var newLink = link.cloneNode();
    newLink.onload = function() {
        if (link.parentNode !== null) // $FlowFixMe
        link.parentNode.removeChild(link);
    };
    newLink.setAttribute('href', link.getAttribute('href').split('?')[0] + '?' + Date.now()); // $FlowFixMe
    link.parentNode.insertBefore(newLink, link.nextSibling);
}
var cssTimeout = null;
function reloadCSS() {
    if (cssTimeout) return;
    cssTimeout = setTimeout(function() {
        var links = document.querySelectorAll('link[rel="stylesheet"]');
        for(var i = 0; i < links.length; i++){
            // $FlowFixMe[incompatible-type]
            var href = links[i].getAttribute('href');
            var hostname = getHostname();
            var servedFromHMRServer = hostname === 'localhost' ? new RegExp('^(https?:\\/\\/(0.0.0.0|127.0.0.1)|localhost):' + getPort()).test(href) : href.indexOf(hostname + ':' + getPort());
            var absolute = /^https?:\/\//i.test(href) && href.indexOf(window.location.origin) !== 0 && !servedFromHMRServer;
            if (!absolute) updateLink(links[i]);
        }
        cssTimeout = null;
    }, 50);
}
function hmrApply(bundle, asset) {
    var modules = bundle.modules;
    if (!modules) return;
    if (asset.type === 'css') reloadCSS();
    else if (asset.type === 'js') {
        var deps = asset.depsByBundle[bundle.HMR_BUNDLE_ID];
        if (deps) {
            if (modules[asset.id]) {
                // Remove dependencies that are removed and will become orphaned.
                // This is necessary so that if the asset is added back again, the cache is gone, and we prevent a full page reload.
                var oldDeps = modules[asset.id][1];
                for(var dep in oldDeps)if (!deps[dep] || deps[dep] !== oldDeps[dep]) {
                    var id = oldDeps[dep];
                    var parents = getParents(module.bundle.root, id);
                    if (parents.length === 1) hmrDelete(module.bundle.root, id);
                }
            }
            var fn = new Function('require', 'module', 'exports', asset.output);
            modules[asset.id] = [
                fn,
                deps
            ];
        } else if (bundle.parent) hmrApply(bundle.parent, asset);
    }
}
function hmrDelete(bundle, id1) {
    var modules = bundle.modules;
    if (!modules) return;
    if (modules[id1]) {
        // Collect dependencies that will become orphaned when this module is deleted.
        var deps = modules[id1][1];
        var orphans = [];
        for(var dep in deps){
            var parents = getParents(module.bundle.root, deps[dep]);
            if (parents.length === 1) orphans.push(deps[dep]);
        } // Delete the module. This must be done before deleting dependencies in case of circular dependencies.
        delete modules[id1];
        delete bundle.cache[id1]; // Now delete the orphans.
        orphans.forEach(function(id) {
            hmrDelete(module.bundle.root, id);
        });
    } else if (bundle.parent) hmrDelete(bundle.parent, id1);
}
function hmrAcceptCheck(bundle, id, depsByBundle) {
    if (hmrAcceptCheckOne(bundle, id, depsByBundle)) return true;
     // Traverse parents breadth first. All possible ancestries must accept the HMR update, or we'll reload.
    var parents = getParents(module.bundle.root, id);
    var accepted = false;
    while(parents.length > 0){
        var v = parents.shift();
        var a = hmrAcceptCheckOne(v[0], v[1], null);
        if (a) // If this parent accepts, stop traversing upward, but still consider siblings.
        accepted = true;
        else {
            // Otherwise, queue the parents in the next level upward.
            var p = getParents(module.bundle.root, v[1]);
            if (p.length === 0) {
                // If there are no parents, then we've reached an entry without accepting. Reload.
                accepted = false;
                break;
            }
            parents.push.apply(parents, _toConsumableArray(p));
        }
    }
    return accepted;
}
function hmrAcceptCheckOne(bundle, id, depsByBundle) {
    var modules = bundle.modules;
    if (!modules) return;
    if (depsByBundle && !depsByBundle[bundle.HMR_BUNDLE_ID]) {
        // If we reached the root bundle without finding where the asset should go,
        // there's nothing to do. Mark as "accepted" so we don't reload the page.
        if (!bundle.parent) return true;
        return hmrAcceptCheck(bundle.parent, id, depsByBundle);
    }
    if (checkedAssets[id]) return true;
    checkedAssets[id] = true;
    var cached = bundle.cache[id];
    assetsToAccept.push([
        bundle,
        id
    ]);
    if (!cached || cached.hot && cached.hot._acceptCallbacks.length) return true;
}
function hmrAcceptRun(bundle, id) {
    var cached = bundle.cache[id];
    bundle.hotData = {
    };
    if (cached && cached.hot) cached.hot.data = bundle.hotData;
    if (cached && cached.hot && cached.hot._disposeCallbacks.length) cached.hot._disposeCallbacks.forEach(function(cb) {
        cb(bundle.hotData);
    });
    delete bundle.cache[id];
    bundle(id);
    cached = bundle.cache[id];
    if (cached && cached.hot && cached.hot._acceptCallbacks.length) cached.hot._acceptCallbacks.forEach(function(cb) {
        var assetsToAlsoAccept = cb(function() {
            return getParents(module.bundle.root, id);
        });
        if (assetsToAlsoAccept && assetsToAccept.length) // $FlowFixMe[method-unbinding]
        assetsToAccept.push.apply(assetsToAccept, assetsToAlsoAccept);
    });
    acceptedAssets[id] = true;
}

},{}],"kCKmj":[function(require,module,exports) {
var _controlScss = require("./control.scss");
/* global kirkiControlLoader */ /* eslint max-depth: 0 */ /* eslint no-useless-escape: 0 */ var RepeaterRow = function RepeaterRow(rowIndex, container, label, control) {
    var self = this;
    this.rowIndex = rowIndex;
    this.container = container;
    this.label = label;
    this.header = this.container.find(".repeater-row-header");
    this.header.on("click", function() {
        self.toggleMinimize();
    });
    this.container.on("click", ".repeater-row-remove", function() {
        self.remove();
    });
    this.header.on("mousedown", function() {
        self.container.trigger("row:start-dragging");
    });
    this.container.on("keyup change", "input, select, textarea", function(e) {
        self.container.trigger("row:update", [
            self.rowIndex,
            jQuery(e.target).data("field"),
            e.target, 
        ]);
    });
    this.setRowIndex = function(rowNum) {
        this.rowIndex = rowNum;
        this.container.attr("data-row", rowNum);
        this.container.data("row", rowNum);
        this.updateLabel();
    };
    this.toggleMinimize = function() {
        // Store the previous state.
        this.container.toggleClass("minimized");
        this.header.find(".dashicons").toggleClass("dashicons-arrow-up").toggleClass("dashicons-arrow-down");
    };
    this.remove = function() {
        this.container.slideUp(300, function() {
            jQuery(this).detach();
        });
        this.container.trigger("row:remove", [
            this.rowIndex
        ]);
    };
    this.updateLabel = function() {
        var rowLabelField, rowLabel, rowLabelSelector;
        if ("field" === this.label.type) {
            rowLabelField = this.container.find('.repeater-field [data-field="' + this.label.field + '"]');
            if (_.isFunction(rowLabelField.val)) {
                rowLabel = rowLabelField.val();
                if ("" !== rowLabel) {
                    if (!_.isUndefined(control.params.fields[this.label.field])) {
                        if (!_.isUndefined(control.params.fields[this.label.field].type)) {
                            if ("select" === control.params.fields[this.label.field].type) {
                                if (!_.isUndefined(control.params.fields[this.label.field].choices) && !_.isUndefined(control.params.fields[this.label.field].choices[rowLabelField.val()])) rowLabel = control.params.fields[this.label.field].choices[rowLabelField.val()];
                            } else if ("radio" === control.params.fields[this.label.field].type || "radio-image" === control.params.fields[this.label.field].type) {
                                rowLabelSelector = control.selector + ' [data-row="' + this.rowIndex + '"] .repeater-field [data-field="' + this.label.field + '"]:checked';
                                rowLabel = jQuery(rowLabelSelector).val();
                            }
                        }
                    }
                    this.header.find(".repeater-row-label").text(rowLabel);
                    return;
                }
            }
        }
        this.header.find(".repeater-row-label").text(this.label.value + " " + (this.rowIndex + 1));
    };
    this.updateLabel();
};
wp.customize.controlConstructor.repeater = wp.customize.Control.extend({
    // When we're finished loading continue processing
    ready: function ready() {
        var control = this;
        // Init the control.
        if (!_.isUndefined(window.kirkiControlLoader) && _.isFunction(kirkiControlLoader)) kirkiControlLoader(control);
        else control.initKirkiControl();
    },
    initKirkiControl: function initKirkiControl(control) {
        var limit, theNewRow, settingValue;
        control = control || this;
        // The current value set in Control Class (set in Kirki_Customize_Repeater_Control::to_json() function)
        settingValue = control.params.value;
        // The hidden field that keeps the data saved (though we never update it)
        control.settingField = control.container.find("[data-customize-setting-link]").first();
        // Set the field value for the first time, we'll fill it up later
        control.setValue([], false);
        // The DIV that holds all the rows
        control.repeaterFieldsContainer = control.container.find(".repeater-fields").first();
        // Set number of rows to 0
        control.currentIndex = 0;
        // Save the rows objects
        control.rows = [];
        // Default limit choice
        limit = false;
        if (!_.isUndefined(control.params.choices.limit)) limit = 0 >= control.params.choices.limit ? false : parseInt(control.params.choices.limit, 10);
        control.container.on("click", "button.repeater-add", function(e) {
            e.preventDefault();
            if (!limit || control.currentIndex < limit) {
                theNewRow = control.addRow();
                theNewRow.toggleMinimize();
                control.initColorPicker();
                control.initSelect(theNewRow);
            } else jQuery(control.selector + " .limit").addClass("highlight");
        });
        control.container.on("click", ".repeater-row-remove", function() {
            control.currentIndex--;
            if (!limit || control.currentIndex < limit) jQuery(control.selector + " .limit").removeClass("highlight");
        });
        control.container.on("click keypress", ".repeater-field-image .upload-button,.repeater-field-cropped_image .upload-button,.repeater-field-upload .upload-button", function(e) {
            e.preventDefault();
            control.$thisButton = jQuery(this);
            control.openFrame(e);
        });
        control.container.on("click keypress", ".repeater-field-image .remove-button,.repeater-field-cropped_image .remove-button", function(e) {
            e.preventDefault();
            control.$thisButton = jQuery(this);
            control.removeImage(e);
        });
        control.container.on("click keypress", ".repeater-field-upload .remove-button", function(e) {
            e.preventDefault();
            control.$thisButton = jQuery(this);
            control.removeFile(e);
        });
        /**
     * Function that loads the Mustache template
     */ control.repeaterTemplate = _.memoize(function() {
            var compiled, /*
         * Underscore's default ERB-style templates are incompatible with PHP
         * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
         *
         * @see trac ticket #22344.
         */ options = {
                evaluate: /<#([\s\S]+?)#>/g,
                interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                escape: /\{\{([^\}]+?)\}\}(?!\})/g,
                variable: "data"
            };
            return function(data) {
                compiled = _.template(control.container.find(".customize-control-repeater-content").first().html(), null, options);
                return compiled(data);
            };
        });
        // When we load the control, the fields have not been filled up
        // This is the first time that we create all the rows
        if (settingValue.length) _.each(settingValue, function(subValue) {
            theNewRow = control.addRow(subValue);
            control.initColorPicker();
            control.initSelect(theNewRow, subValue);
        });
        control.repeaterFieldsContainer.sortable({
            handle: ".repeater-row-header",
            update: function update() {
                control.sort();
            }
        });
    },
    /**
   * Open the media modal.
   *
   * @param {Object} event - The JS event.
   * @returns {void}
   */ openFrame: function openFrame(event) {
        if (wp.customize.utils.isKeydownButNotEnterEvent(event)) return;
        if (this.$thisButton.closest(".repeater-field").hasClass("repeater-field-cropped_image")) this.initCropperFrame();
        else this.initFrame();
        this.frame.open();
    },
    initFrame: function initFrame() {
        var libMediaType = this.getMimeType();
        this.frame = wp.media({
            states: [
                new wp.media.controller.Library({
                    library: wp.media.query({
                        type: libMediaType
                    }),
                    multiple: false,
                    date: false
                }), 
            ]
        });
        // When a file is selected, run a callback.
        this.frame.on("select", this.onSelect, this);
    },
    /**
   * Create a media modal select frame, and store it so the instance can be reused when needed.
   * This is mostly a copy/paste of Core api.CroppedImageControl in /wp-admin/js/customize-control.js
   *
   * @returns {void}
   */ initCropperFrame: function initCropperFrame() {
        // We get the field id from which this was called
        var currentFieldId = this.$thisButton.siblings("input.hidden-field").attr("data-field"), attrs = [
            "width",
            "height",
            "flex_width",
            "flex_height"
        ], libMediaType = this.getMimeType();
        // Make sure we got it
        if (_.isString(currentFieldId) && "" !== currentFieldId) // Make fields is defined and only do the hack for cropped_image
        {
            if (_.isObject(this.params.fields[currentFieldId]) && "cropped_image" === this.params.fields[currentFieldId].type) //Iterate over the list of attributes
            attrs.forEach((function(el) {
                // If the attribute exists in the field
                if (!_.isUndefined(this.params.fields[currentFieldId][el])) // Set the attribute in the main object
                this.params[el] = this.params.fields[currentFieldId][el];
            }).bind(this));
        }
        this.frame = wp.media({
            button: {
                text: "Select and Crop",
                close: false
            },
            states: [
                new wp.media.controller.Library({
                    library: wp.media.query({
                        type: libMediaType
                    }),
                    multiple: false,
                    date: false,
                    suggestedWidth: this.params.width,
                    suggestedHeight: this.params.height
                }),
                new wp.media.controller.CustomizeImageCropper({
                    imgSelectOptions: this.calculateImageSelectOptions,
                    control: this
                }), 
            ]
        });
        this.frame.on("select", this.onSelectForCrop, this);
        this.frame.on("cropped", this.onCropped, this);
        this.frame.on("skippedcrop", this.onSkippedCrop, this);
    },
    onSelect: function onSelect() {
        var attachment = this.frame.state().get("selection").first().toJSON();
        if (this.$thisButton.closest(".repeater-field").hasClass("repeater-field-upload")) this.setFileInRepeaterField(attachment);
        else this.setImageInRepeaterField(attachment);
    },
    /**
   * After an image is selected in the media modal, switch to the cropper
   * state if the image isn't the right size.
   */ onSelectForCrop: function onSelectForCrop() {
        var attachment = this.frame.state().get("selection").first().toJSON();
        if (this.params.width === attachment.width && this.params.height === attachment.height && !this.params.flex_width && !this.params.flex_height) this.setImageInRepeaterField(attachment);
        else this.frame.setState("cropper");
    },
    /**
   * After the image has been cropped, apply the cropped image data to the setting.
   *
   * @param {object} croppedImage Cropped attachment data.
   * @returns {void}
   */ onCropped: function onCropped(croppedImage) {
        this.setImageInRepeaterField(croppedImage);
    },
    /**
   * Returns a set of options, computed from the attached image data and
   * control-specific data, to be fed to the imgAreaSelect plugin in
   * wp.media.view.Cropper.
   *
   * @param {wp.media.model.Attachment} attachment - The attachment from the WP API.
   * @param {wp.media.controller.Cropper} controller - Media controller.
   * @returns {Object} - Options.
   */ calculateImageSelectOptions: function calculateImageSelectOptions(attachment, controller) {
        var control = controller.get("control"), flexWidth = !!parseInt(control.params.flex_width, 10), flexHeight = !!parseInt(control.params.flex_height, 10), realWidth = attachment.get("width"), realHeight = attachment.get("height"), xInit = parseInt(control.params.width, 10), yInit = parseInt(control.params.height, 10), ratio = xInit / yInit, xImg = realWidth, yImg = realHeight, x1, y1, imgSelectOptions;
        controller.set("canSkipCrop", !control.mustBeCropped(flexWidth, flexHeight, xInit, yInit, realWidth, realHeight));
        if (xImg / yImg > ratio) {
            yInit = yImg;
            xInit = yInit * ratio;
        } else {
            xInit = xImg;
            yInit = xInit / ratio;
        }
        x1 = (xImg - xInit) / 2;
        y1 = (yImg - yInit) / 2;
        imgSelectOptions = {
            handles: true,
            keys: true,
            instance: true,
            persistent: true,
            imageWidth: realWidth,
            imageHeight: realHeight,
            x1: x1,
            y1: y1,
            x2: xInit + x1,
            y2: yInit + y1
        };
        if (false === flexHeight && false === flexWidth) imgSelectOptions.aspectRatio = xInit + ":" + yInit;
        if (false === flexHeight) imgSelectOptions.maxHeight = yInit;
        if (false === flexWidth) imgSelectOptions.maxWidth = xInit;
        return imgSelectOptions;
    },
    /**
   * Return whether the image must be cropped, based on required dimensions.
   *
   * @param {bool} flexW - The flex-width.
   * @param {bool} flexH - The flex-height.
   * @param {int}  dstW - Initial point distance in the X axis.
   * @param {int}  dstH - Initial point distance in the Y axis.
   * @param {int}  imgW - Width.
   * @param {int}  imgH - Height.
   * @returns {bool} - Whether the image must be cropped or not based on required dimensions.
   */ mustBeCropped: function mustBeCropped(flexW, flexH, dstW, dstH, imgW, imgH) {
        return !(true === flexW && true === flexH || true === flexW && dstH === imgH || true === flexH && dstW === imgW || dstW === imgW && dstH === imgH || imgW <= dstW);
    },
    /**
   * If cropping was skipped, apply the image data directly to the setting.
   *
   * @returns {void}
   */ onSkippedCrop: function onSkippedCrop() {
        var attachment = this.frame.state().get("selection").first().toJSON();
        this.setImageInRepeaterField(attachment);
    },
    /**
   * Updates the setting and re-renders the control UI.
   *
   * @param {object} attachment - The attachment object.
   * @returns {void}
   */ setImageInRepeaterField: function setImageInRepeaterField(attachment) {
        var $targetDiv = this.$thisButton.closest(".repeater-field-image,.repeater-field-cropped_image");
        $targetDiv.find(".kirki-image-attachment").html('<img src="' + attachment.url + '">').hide().slideDown("slow");
        $targetDiv.find(".hidden-field").val(attachment.id);
        this.$thisButton.text(this.$thisButton.data("alt-label"));
        $targetDiv.find(".remove-button").show();
        //This will activate the save button
        $targetDiv.find("input, textarea, select").trigger("change");
        this.frame.close();
    },
    /**
   * Updates the setting and re-renders the control UI.
   *
   * @param {object} attachment - The attachment object.
   * @returns {void}
   */ setFileInRepeaterField: function setFileInRepeaterField(attachment) {
        var $targetDiv = this.$thisButton.closest(".repeater-field-upload");
        $targetDiv.find(".kirki-file-attachment").html('<span class="file"><span class="dashicons dashicons-media-default"></span> ' + attachment.filename + "</span>").hide().slideDown("slow");
        $targetDiv.find(".hidden-field").val(attachment.id);
        this.$thisButton.text(this.$thisButton.data("alt-label"));
        $targetDiv.find(".upload-button").show();
        $targetDiv.find(".remove-button").show();
        //This will activate the save button
        $targetDiv.find("input, textarea, select").trigger("change");
        this.frame.close();
    },
    getMimeType: function getMimeType() {
        // We get the field id from which this was called
        var currentFieldId = this.$thisButton.siblings("input.hidden-field").attr("data-field");
        // Make sure we got it
        if (_.isString(currentFieldId) && "" !== currentFieldId) // Make fields is defined and only do the hack for cropped_image
        {
            if (_.isObject(this.params.fields[currentFieldId]) && "upload" === this.params.fields[currentFieldId].type) {
                // If the attribute exists in the field
                if (!_.isUndefined(this.params.fields[currentFieldId].mime_type)) // Set the attribute in the main object
                return this.params.fields[currentFieldId].mime_type;
            }
        }
        return "image";
    },
    removeImage: function removeImage(event) {
        var $targetDiv, $uploadButton;
        if (wp.customize.utils.isKeydownButNotEnterEvent(event)) return;
        $targetDiv = this.$thisButton.closest(".repeater-field-image,.repeater-field-cropped_image,.repeater-field-upload");
        $uploadButton = $targetDiv.find(".upload-button");
        $targetDiv.find(".kirki-image-attachment").slideUp("fast", function() {
            jQuery(this).show().html(jQuery(this).data("placeholder"));
        });
        $targetDiv.find(".hidden-field").val("");
        $uploadButton.text($uploadButton.data("label"));
        this.$thisButton.hide();
        $targetDiv.find("input, textarea, select").trigger("change");
    },
    removeFile: function removeFile(event) {
        var $targetDiv, $uploadButton;
        if (wp.customize.utils.isKeydownButNotEnterEvent(event)) return;
        $targetDiv = this.$thisButton.closest(".repeater-field-upload");
        $uploadButton = $targetDiv.find(".upload-button");
        $targetDiv.find(".kirki-file-attachment").slideUp("fast", function() {
            jQuery(this).show().html(jQuery(this).data("placeholder"));
        });
        $targetDiv.find(".hidden-field").val("");
        $uploadButton.text($uploadButton.data("label"));
        this.$thisButton.hide();
        $targetDiv.find("input, textarea, select").trigger("change");
    },
    /**
   * Get the current value of the setting
   *
   * @returns {Object} - Returns the value.
   */ getValue: function getValue() {
        // The setting is saved in JSON
        return JSON.parse(decodeURI(this.setting.get()));
    },
    /**
   * Set a new value for the setting
   *
   * @param {Object} newValue - The new value.
   * @param {bool} refresh - If we want to refresh the previewer or not
   * @param {bool} filtering - If we want to filter or not.
   * @returns {void}
   */ setValue: function setValue(newValue, refresh, filtering) {
        // We need to filter the values after the first load to remove data requrired for diplay but that we don't want to save in DB
        var filteredValue = newValue, filter = [];
        if (filtering) {
            jQuery.each(this.params.fields, function(index, value) {
                if ("image" === value.type || "cropped_image" === value.type || "upload" === value.type) filter.push(index);
            });
            jQuery.each(newValue, function(index, value) {
                jQuery.each(filter, function(ind, field) {
                    if (!_.isUndefined(value[field]) && !_.isUndefined(value[field].id)) filteredValue[index][field] = value[field].id;
                });
            });
        }
        this.setting.set(encodeURI(JSON.stringify(filteredValue)));
        if (refresh) // Trigger the change event on the hidden field so
        // previewer refresh the website on Customizer
        this.settingField.trigger("change");
    },
    /**
   * Add a new row to repeater settings based on the structure.
   *
   * @param {Object} data - (Optional) Object of field => value pairs (undefined if you want to get the default values)
   * @returns {Object} - Returns the new row.
   */ addRow: function addRow(data) {
        var control = this, template = control.repeaterTemplate(), settingValue = this.getValue(), newRowSetting = {
        }, templateData, newRow, i;
        if (template) {
            // The control structure is going to define the new fields
            // We need to clone control.params.fields. Assigning it
            // ould result in a reference assignment.
            templateData = jQuery.extend(true, {
            }, control.params.fields);
            // But if we have passed data, we'll use the data values instead
            if (data) {
                for(i in data)if (data.hasOwnProperty(i) && templateData.hasOwnProperty(i)) templateData[i].default = data[i];
            }
            templateData.index = this.currentIndex;
            // Append the template content
            template = template(templateData);
            // Create a new row object and append the element
            newRow = new RepeaterRow(control.currentIndex, jQuery(template).appendTo(control.repeaterFieldsContainer), control.params.row_label, control);
            newRow.container.on("row:remove", function(e, rowIndex) {
                control.deleteRow(rowIndex);
            });
            newRow.container.on("row:update", function(e, rowIndex, fieldName, element) {
                control.updateField.call(control, e, rowIndex, fieldName, element); // eslint-disable-line no-useless-call
                newRow.updateLabel();
            });
            // Add the row to rows collection
            this.rows[this.currentIndex] = newRow;
            for(i in templateData)if (templateData.hasOwnProperty(i)) newRowSetting[i] = templateData[i].default;
            settingValue[this.currentIndex] = newRowSetting;
            this.setValue(settingValue, true);
            this.currentIndex++;
            return newRow;
        }
    },
    sort: function sort() {
        var control = this, $rows = this.repeaterFieldsContainer.find(".repeater-row"), newOrder = [], settings = control.getValue(), newRows = [], newSettings = [];
        $rows.each(function(i, element) {
            newOrder.push(jQuery(element).data("row"));
        });
        jQuery.each(newOrder, function(newPosition, oldPosition) {
            newRows[newPosition] = control.rows[oldPosition];
            newRows[newPosition].setRowIndex(newPosition);
            newSettings[newPosition] = settings[oldPosition];
        });
        control.rows = newRows;
        control.setValue(newSettings);
    },
    /**
   * Delete a row in the repeater setting
   *
   * @param {int} index - Position of the row in the complete Setting Array
   * @returns {void}
   */ deleteRow: function deleteRow(index) {
        var currentSettings = this.getValue(), row, prop;
        if (currentSettings[index]) {
            // Find the row
            row = this.rows[index];
            if (row) {
                // Remove the row settings
                delete currentSettings[index];
                // Remove the row from the rows collection
                delete this.rows[index];
                // Update the new setting values
                this.setValue(currentSettings, true);
            }
        }
        // Remap the row numbers
        for(prop in this.rows)if (this.rows.hasOwnProperty(prop) && this.rows[prop]) this.rows[prop].updateLabel();
    },
    /**
   * Update a single field inside a row.
   * Triggered when a field has changed
   *
   * @param {Object} e - Event Object
   * @param {int} rowIndex - The row's index as an integer.
   * @param {string} fieldId - The field ID.
   * @param {string|Object} element - The element's identifier, or jQuery Object of the element.
   * @returns {void}
   */ updateField: function updateField(e, rowIndex, fieldId, element) {
        var type, row, currentSettings;
        if (!this.rows[rowIndex]) return;
        if (!this.params.fields[fieldId]) return;
        type = this.params.fields[fieldId].type;
        row = this.rows[rowIndex];
        currentSettings = this.getValue();
        element = jQuery(element);
        if (_.isUndefined(currentSettings[row.rowIndex][fieldId])) return;
        if ("checkbox" === type) currentSettings[row.rowIndex][fieldId] = element.is(":checked");
        else // Update the settings
        currentSettings[row.rowIndex][fieldId] = element.val();
        this.setValue(currentSettings, true);
    },
    /**
   * Init the color picker on color fields
   * Called after AddRow
   *
   * @returns {void}
   */ initColorPicker: function initColorPicker() {
        var control = this;
        var colorPicker = control.container.find(".kirki-classic-color-picker");
        var fieldId = colorPicker.data("field");
        var options = {
        };
        // We check if the color palette parameter is defined.
        if (!_.isUndefined(fieldId) && !_.isUndefined(control.params.fields[fieldId]) && !_.isUndefined(control.params.fields[fieldId].palettes) && _.isObject(control.params.fields[fieldId].palettes)) options.palettes = control.params.fields[fieldId].palettes;
        // When the color picker value is changed we update the value of the field
        options.change = function(event, ui) {
            var currentPicker = jQuery(event.target);
            var row = currentPicker.closest(".repeater-row");
            var rowIndex = row.data("row");
            var currentSettings = control.getValue();
            var value = ui.color._alpha < 1 ? ui.color.to_s() : ui.color.toString();
            currentSettings[rowIndex][currentPicker.data("field")] = value;
            control.setValue(currentSettings, true);
            // By default if the alpha is 1, the input will be rgb.
            // We setTimeout to 50ms to prevent race value set.
            setTimeout(function() {
                event.target.value = value;
            }, 50);
            console.log(event.target.value);
        };
        // Init the color picker
        if (colorPicker.length && 0 !== colorPicker.length) colorPicker.wpColorPicker(options);
    },
    /**
   * Init the dropdown-pages field.
   * Called after AddRow
   *
   * @param {object} theNewRow the row that was added to the repeater
   * @param {object} data the data for the row if we're initializing a pre-existing row
   * @returns {void}
   */ initSelect: function initSelect(theNewRow, data) {
        var control = this, dropdown = theNewRow.container.find(".repeater-field select"), dataField;
        if (0 === dropdown.length) return;
        dataField = dropdown.data("field");
        multiple = jQuery(dropdown).data("multiple");
        data = data || {
        };
        data[dataField] = data[dataField] || "";
        jQuery(dropdown).val(data[dataField] || jQuery(dropdown).val());
        this.container.on("change", ".repeater-field select", function(event) {
            var currentDropdown = jQuery(event.target), row = currentDropdown.closest(".repeater-row"), rowIndex = row.data("row"), currentSettings = control.getValue();
            currentSettings[rowIndex][currentDropdown.data("field")] = jQuery(this).val();
            control.setValue(currentSettings);
        });
    }
});

},{"./control.scss":"aHRDA"}],"aHRDA":[function() {},{}]},["hHzGY","kCKmj"], "kCKmj", "parcelRequired478")

//# sourceMappingURL=control.js.map
