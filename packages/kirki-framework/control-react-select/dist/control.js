// modules are defined as an array
// [ module function, map of requires ]
//
// map of requires is short require name -> numeric require
//
// anything defined in a previous bundle is accessed via the
// orig method which is the require for previous bundles

(function(modules, entry, mainEntry, parcelRequireName, globalName) {
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
      return newRequire(localRequire.resolve(x));
    }

    function resolve(x) {
      return modules[name][1][x] || x;
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
  newRequire.register = function(id, exports) {
    modules[id] = [
      function(require, module) {
        module.exports = exports;
      },
      {},
    ];
  };

  Object.defineProperty(newRequire, 'root', {
    get: function() {
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
      define(function() {
        return mainExports;
      });

      // <script>
    } else if (globalName) {
      this[globalName] = mainExports;
    }
  }
})({"jAg0Z":[function(require,module,exports) {
var Refresh = require('react-refresh/runtime');
Refresh.injectIntoGlobalHook(window);
window.$RefreshReg$ = function() {
};
window.$RefreshSig$ = function() {
    return function(type) {
        return type;
    };
};

},{"react-refresh/runtime":"kZ1Z6"}],"kZ1Z6":[function(require,module,exports) {
'use strict';
module.exports = require('./cjs/react-refresh-runtime.development.js');

},{"./cjs/react-refresh-runtime.development.js":"gFI7c"}],"gFI7c":[function(require,module,exports) {
/** @license React v0.9.0
 * react-refresh-runtime.development.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */ 'use strict';
(function() {
    // ATTENTION
    // When adding new symbols to this file,
    // Please consider also adding to 'react-devtools-shared/src/backend/ReactSymbols'
    // The Symbol used to tag the ReactElement-like types. If there is no native Symbol
    // nor polyfill, then a plain number is used for performance.
    var REACT_ELEMENT_TYPE = 60103;
    var REACT_PORTAL_TYPE = 60106;
    var REACT_FRAGMENT_TYPE = 60107;
    var REACT_STRICT_MODE_TYPE = 60108;
    var REACT_PROFILER_TYPE = 60114;
    var REACT_PROVIDER_TYPE = 60109;
    var REACT_CONTEXT_TYPE = 60110;
    var REACT_FORWARD_REF_TYPE = 60112;
    var REACT_SUSPENSE_TYPE = 60113;
    var REACT_SUSPENSE_LIST_TYPE = 60120;
    var REACT_MEMO_TYPE = 60115;
    var REACT_LAZY_TYPE = 60116;
    var REACT_BLOCK_TYPE = 60121;
    var REACT_SERVER_BLOCK_TYPE = 60122;
    var REACT_FUNDAMENTAL_TYPE = 60117;
    var REACT_SCOPE_TYPE = 60119;
    var REACT_OPAQUE_ID_TYPE = 60128;
    var REACT_DEBUG_TRACING_MODE_TYPE = 60129;
    var REACT_OFFSCREEN_TYPE = 60130;
    var REACT_LEGACY_HIDDEN_TYPE = 60131;
    if (typeof Symbol === 'function' && Symbol.for) {
        var symbolFor = Symbol.for;
        REACT_ELEMENT_TYPE = symbolFor('react.element');
        REACT_PORTAL_TYPE = symbolFor('react.portal');
        REACT_FRAGMENT_TYPE = symbolFor('react.fragment');
        REACT_STRICT_MODE_TYPE = symbolFor('react.strict_mode');
        REACT_PROFILER_TYPE = symbolFor('react.profiler');
        REACT_PROVIDER_TYPE = symbolFor('react.provider');
        REACT_CONTEXT_TYPE = symbolFor('react.context');
        REACT_FORWARD_REF_TYPE = symbolFor('react.forward_ref');
        REACT_SUSPENSE_TYPE = symbolFor('react.suspense');
        REACT_SUSPENSE_LIST_TYPE = symbolFor('react.suspense_list');
        REACT_MEMO_TYPE = symbolFor('react.memo');
        REACT_LAZY_TYPE = symbolFor('react.lazy');
        REACT_BLOCK_TYPE = symbolFor('react.block');
        REACT_SERVER_BLOCK_TYPE = symbolFor('react.server.block');
        REACT_FUNDAMENTAL_TYPE = symbolFor('react.fundamental');
        REACT_SCOPE_TYPE = symbolFor('react.scope');
        REACT_OPAQUE_ID_TYPE = symbolFor('react.opaque.id');
        REACT_DEBUG_TRACING_MODE_TYPE = symbolFor('react.debug_trace_mode');
        REACT_OFFSCREEN_TYPE = symbolFor('react.offscreen');
        REACT_LEGACY_HIDDEN_TYPE = symbolFor('react.legacy_hidden');
    }
    var PossiblyWeakMap = typeof WeakMap === 'function' ? WeakMap : Map; // We never remove these associations.
    // It's OK to reference families, but use WeakMap/Set for types.
    var allFamiliesByID = new Map();
    var allFamiliesByType = new PossiblyWeakMap();
    var allSignaturesByType = new PossiblyWeakMap(); // This WeakMap is read by React, so we only put families
    // that have actually been edited here. This keeps checks fast.
    // $FlowIssue
    var updatedFamiliesByType = new PossiblyWeakMap(); // This is cleared on every performReactRefresh() call.
    // It is an array of [Family, NextType] tuples.
    var pendingUpdates = []; // This is injected by the renderer via DevTools global hook.
    var helpersByRendererID = new Map();
    var helpersByRoot = new Map(); // We keep track of mounted roots so we can schedule updates.
    var mountedRoots = new Set(); // If a root captures an error, we remember it so we can retry on edit.
    var failedRoots = new Set(); // In environments that support WeakMap, we also remember the last element for every root.
    // It needs to be weak because we do this even for roots that failed to mount.
    // If there is no WeakMap, we won't attempt to do retrying.
    // $FlowIssue
    var rootElements = typeof WeakMap === 'function' ? new WeakMap() : null;
    var isPerformingRefresh = false;
    function computeFullKey(signature) {
        if (signature.fullKey !== null) return signature.fullKey;
        var fullKey = signature.ownKey;
        var hooks;
        try {
            hooks = signature.getCustomHooks();
        } catch (err) {
            // This can happen in an edge case, e.g. if expression like Foo.useSomething
            // depends on Foo which is lazily initialized during rendering.
            // In that case just assume we'll have to remount.
            signature.forceReset = true;
            signature.fullKey = fullKey;
            return fullKey;
        }
        for(var i = 0; i < hooks.length; i++){
            var hook = hooks[i];
            if (typeof hook !== 'function') {
                // Something's wrong. Assume we need to remount.
                signature.forceReset = true;
                signature.fullKey = fullKey;
                return fullKey;
            }
            var nestedHookSignature = allSignaturesByType.get(hook);
            if (nestedHookSignature === undefined) continue;
            var nestedHookKey = computeFullKey(nestedHookSignature);
            if (nestedHookSignature.forceReset) signature.forceReset = true;
            fullKey += '\n---\n' + nestedHookKey;
        }
        signature.fullKey = fullKey;
        return fullKey;
    }
    function haveEqualSignatures(prevType, nextType) {
        var prevSignature = allSignaturesByType.get(prevType);
        var nextSignature = allSignaturesByType.get(nextType);
        if (prevSignature === undefined && nextSignature === undefined) return true;
        if (prevSignature === undefined || nextSignature === undefined) return false;
        if (computeFullKey(prevSignature) !== computeFullKey(nextSignature)) return false;
        if (nextSignature.forceReset) return false;
        return true;
    }
    function isReactClass(type) {
        return type.prototype && type.prototype.isReactComponent;
    }
    function canPreserveStateBetween(prevType, nextType) {
        if (isReactClass(prevType) || isReactClass(nextType)) return false;
        if (haveEqualSignatures(prevType, nextType)) return true;
        return false;
    }
    function resolveFamily(type) {
        // Only check updated types to keep lookups fast.
        return updatedFamiliesByType.get(type);
    } // If we didn't care about IE11, we could use new Map/Set(iterable).
    function cloneMap(map) {
        var clone = new Map();
        map.forEach(function(value, key) {
            clone.set(key, value);
        });
        return clone;
    }
    function cloneSet(set) {
        var clone = new Set();
        set.forEach(function(value) {
            clone.add(value);
        });
        return clone;
    }
    function performReactRefresh() {
        if (pendingUpdates.length === 0) return null;
        if (isPerformingRefresh) return null;
        isPerformingRefresh = true;
        try {
            var staleFamilies = new Set();
            var updatedFamilies = new Set();
            var updates = pendingUpdates;
            pendingUpdates = [];
            updates.forEach(function(_ref) {
                var family = _ref[0], nextType = _ref[1];
                // Now that we got a real edit, we can create associations
                // that will be read by the React reconciler.
                var prevType = family.current;
                updatedFamiliesByType.set(prevType, family);
                updatedFamiliesByType.set(nextType, family);
                family.current = nextType; // Determine whether this should be a re-render or a re-mount.
                if (canPreserveStateBetween(prevType, nextType)) updatedFamilies.add(family);
                else staleFamilies.add(family);
            }); // TODO: rename these fields to something more meaningful.
            var update = {
                updatedFamilies: updatedFamilies,
                // Families that will re-render preserving state
                staleFamilies: staleFamilies // Families that will be remounted
            };
            helpersByRendererID.forEach(function(helpers) {
                // Even if there are no roots, set the handler on first update.
                // This ensures that if *new* roots are mounted, they'll use the resolve handler.
                helpers.setRefreshHandler(resolveFamily);
            });
            var didError = false;
            var firstError = null; // We snapshot maps and sets that are mutated during commits.
            // If we don't do this, there is a risk they will be mutated while
            // we iterate over them. For example, trying to recover a failed root
            // may cause another root to be added to the failed list -- an infinite loop.
            var failedRootsSnapshot = cloneSet(failedRoots);
            var mountedRootsSnapshot = cloneSet(mountedRoots);
            var helpersByRootSnapshot = cloneMap(helpersByRoot);
            failedRootsSnapshot.forEach(function(root) {
                var helpers = helpersByRootSnapshot.get(root);
                if (helpers === undefined) throw new Error('Could not find helpers for a root. This is a bug in React Refresh.');
                failedRoots.has(root);
                if (rootElements === null) return;
                if (!rootElements.has(root)) return;
                var element = rootElements.get(root);
                try {
                    helpers.scheduleRoot(root, element);
                } catch (err) {
                    if (!didError) {
                        didError = true;
                        firstError = err;
                    } // Keep trying other roots.
                }
            });
            mountedRootsSnapshot.forEach(function(root) {
                var helpers = helpersByRootSnapshot.get(root);
                if (helpers === undefined) throw new Error('Could not find helpers for a root. This is a bug in React Refresh.');
                mountedRoots.has(root);
                try {
                    helpers.scheduleRefresh(root, update);
                } catch (err) {
                    if (!didError) {
                        didError = true;
                        firstError = err;
                    } // Keep trying other roots.
                }
            });
            if (didError) throw firstError;
            return update;
        } finally{
            isPerformingRefresh = false;
        }
    }
    function register(type, id) {
        if (type === null) return;
        if (typeof type !== 'function' && typeof type !== 'object') return;
         // This can happen in an edge case, e.g. if we register
        // return value of a HOC but it returns a cached component.
        // Ignore anything but the first registration for each type.
        if (allFamiliesByType.has(type)) return;
         // Create family or remember to update it.
        // None of this bookkeeping affects reconciliation
        // until the first performReactRefresh() call above.
        var family = allFamiliesByID.get(id);
        if (family === undefined) {
            family = {
                current: type
            };
            allFamiliesByID.set(id, family);
        } else pendingUpdates.push([
            family,
            type
        ]);
        allFamiliesByType.set(type, family); // Visit inner types because we might not have registered them.
        if (typeof type === 'object' && type !== null) switch(type.$$typeof){
            case REACT_FORWARD_REF_TYPE:
                register(type.render, id + '$render');
                break;
            case REACT_MEMO_TYPE:
                register(type.type, id + '$type');
                break;
        }
    }
    function setSignature(type, key) {
        var forceReset = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
        var getCustomHooks = arguments.length > 3 ? arguments[3] : undefined;
        allSignaturesByType.set(type, {
            forceReset: forceReset,
            ownKey: key,
            fullKey: null,
            getCustomHooks: getCustomHooks || function() {
                return [];
            }
        });
    } // This is lazily called during first render for a type.
    // It captures Hook list at that time so inline requires don't break comparisons.
    function collectCustomHooksForSignature(type) {
        var signature = allSignaturesByType.get(type);
        if (signature !== undefined) computeFullKey(signature);
    }
    function getFamilyByID(id) {
        return allFamiliesByID.get(id);
    }
    function getFamilyByType(type) {
        return allFamiliesByType.get(type);
    }
    function findAffectedHostInstances(families) {
        var affectedInstances = new Set();
        mountedRoots.forEach(function(root) {
            var helpers = helpersByRoot.get(root);
            if (helpers === undefined) throw new Error('Could not find helpers for a root. This is a bug in React Refresh.');
            var instancesForRoot = helpers.findHostInstancesForRefresh(root, families);
            instancesForRoot.forEach(function(inst) {
                affectedInstances.add(inst);
            });
        });
        return affectedInstances;
    }
    function injectIntoGlobalHook(globalObject) {
        // For React Native, the global hook will be set up by require('react-devtools-core').
        // That code will run before us. So we need to monkeypatch functions on existing hook.
        // For React Web, the global hook will be set up by the extension.
        // This will also run before us.
        var hook = globalObject.__REACT_DEVTOOLS_GLOBAL_HOOK__;
        if (hook === undefined) {
            // However, if there is no DevTools extension, we'll need to set up the global hook ourselves.
            // Note that in this case it's important that renderer code runs *after* this method call.
            // Otherwise, the renderer will think that there is no global hook, and won't do the injection.
            var nextID = 0;
            globalObject.__REACT_DEVTOOLS_GLOBAL_HOOK__ = hook = {
                renderers: new Map(),
                supportsFiber: true,
                inject: function(injected) {
                    return nextID++;
                },
                onScheduleFiberRoot: function(id, root, children) {
                },
                onCommitFiberRoot: function(id, root, maybePriorityLevel, didError) {
                },
                onCommitFiberUnmount: function() {
                }
            };
        } // Here, we just want to get a reference to scheduleRefresh.
        var oldInject = hook.inject;
        hook.inject = function(injected) {
            var id = oldInject.apply(this, arguments);
            if (typeof injected.scheduleRefresh === 'function' && typeof injected.setRefreshHandler === 'function') // This version supports React Refresh.
            helpersByRendererID.set(id, injected);
            return id;
        }; // Do the same for any already injected roots.
        // This is useful if ReactDOM has already been initialized.
        // https://github.com/facebook/react/issues/17626
        hook.renderers.forEach(function(injected, id) {
            if (typeof injected.scheduleRefresh === 'function' && typeof injected.setRefreshHandler === 'function') // This version supports React Refresh.
            helpersByRendererID.set(id, injected);
        }); // We also want to track currently mounted roots.
        var oldOnCommitFiberRoot = hook.onCommitFiberRoot;
        var oldOnScheduleFiberRoot = hook.onScheduleFiberRoot || function() {
        };
        hook.onScheduleFiberRoot = function(id, root, children) {
            if (!isPerformingRefresh) {
                // If it was intentionally scheduled, don't attempt to restore.
                // This includes intentionally scheduled unmounts.
                failedRoots.delete(root);
                if (rootElements !== null) rootElements.set(root, children);
            }
            return oldOnScheduleFiberRoot.apply(this, arguments);
        };
        hook.onCommitFiberRoot = function(id, root, maybePriorityLevel, didError) {
            var helpers = helpersByRendererID.get(id);
            if (helpers === undefined) return;
            helpersByRoot.set(root, helpers);
            var current = root.current;
            var alternate = current.alternate; // We need to determine whether this root has just (un)mounted.
            // This logic is copy-pasted from similar logic in the DevTools backend.
            // If this breaks with some refactoring, you'll want to update DevTools too.
            if (alternate !== null) {
                var wasMounted = alternate.memoizedState != null && alternate.memoizedState.element != null;
                var isMounted = current.memoizedState != null && current.memoizedState.element != null;
                if (!wasMounted && isMounted) {
                    // Mount a new root.
                    mountedRoots.add(root);
                    failedRoots.delete(root);
                } else if (wasMounted && isMounted) ;
                else if (wasMounted && !isMounted) {
                    // Unmount an existing root.
                    mountedRoots.delete(root);
                    if (didError) // We'll remount it on future edits.
                    failedRoots.add(root);
                    else helpersByRoot.delete(root);
                } else if (!wasMounted && !isMounted) {
                    if (didError) // We'll remount it on future edits.
                    failedRoots.add(root);
                }
            } else // Mount a new root.
            mountedRoots.add(root);
            return oldOnCommitFiberRoot.apply(this, arguments);
        };
    }
    function hasUnrecoverableErrors() {
        // TODO: delete this after removing dependency in RN.
        return false;
    } // Exposed for testing.
    function _getMountedRootCount() {
        return mountedRoots.size;
    } // This is a wrapper over more primitive functions for setting signature.
    // Signatures let us decide whether the Hook order has changed on refresh.
    //
    // This function is intended to be used as a transform target, e.g.:
    // var _s = createSignatureFunctionForTransform()
    //
    // function Hello() {
    //   const [foo, setFoo] = useState(0);
    //   const value = useCustomHook();
    //   _s(); /* Second call triggers collecting the custom Hook list.
    //          * This doesn't happen during the module evaluation because we
    //          * don't want to change the module order with inline requires.
    //          * Next calls are noops. */
    //   return <h1>Hi</h1>;
    // }
    //
    // /* First call specifies the signature: */
    // _s(
    //   Hello,
    //   'useState{[foo, setFoo]}(0)',
    //   () => [useCustomHook], /* Lazy to avoid triggering inline requires */
    // );
    function createSignatureFunctionForTransform() {
        // We'll fill in the signature in two steps.
        // First, we'll know the signature itself. This happens outside the component.
        // Then, we'll know the references to custom Hooks. This happens inside the component.
        // After that, the returned function will be a fast path no-op.
        var status = 'needsSignature';
        var savedType;
        var hasCustomHooks;
        return function(type, key, forceReset, getCustomHooks) {
            switch(status){
                case 'needsSignature':
                    if (type !== undefined) {
                        // If we received an argument, this is the initial registration call.
                        savedType = type;
                        hasCustomHooks = typeof getCustomHooks === 'function';
                        setSignature(type, key, forceReset, getCustomHooks); // The next call we expect is from inside a function, to fill in the custom Hooks.
                        status = 'needsCustomHooks';
                    }
                    break;
                case 'needsCustomHooks':
                    if (hasCustomHooks) collectCustomHooksForSignature(savedType);
                    status = 'resolved';
                    break;
            }
            return type;
        };
    }
    function isLikelyComponentType(type) {
        switch(typeof type){
            case 'function':
                // First, deal with classes.
                if (type.prototype != null) {
                    if (type.prototype.isReactComponent) // React class.
                    return true;
                    var ownNames = Object.getOwnPropertyNames(type.prototype);
                    if (ownNames.length > 1 || ownNames[0] !== 'constructor') // This looks like a class.
                    return false;
                     // eslint-disable-next-line no-proto
                    if (type.prototype.__proto__ !== Object.prototype) // It has a superclass.
                    return false;
                     // Pass through.
                // This looks like a regular function with empty prototype.
                } // For plain functions and arrows, use name as a heuristic.
                var name = type.name || type.displayName;
                return typeof name === 'string' && /^[A-Z]/.test(name);
            case 'object':
                if (type != null) switch(type.$$typeof){
                    case REACT_FORWARD_REF_TYPE:
                    case REACT_MEMO_TYPE:
                        // Definitely React components.
                        return true;
                    default:
                        return false;
                }
                return false;
            default:
                return false;
        }
    }
    exports._getMountedRootCount = _getMountedRootCount;
    exports.collectCustomHooksForSignature = collectCustomHooksForSignature;
    exports.createSignatureFunctionForTransform = createSignatureFunctionForTransform;
    exports.findAffectedHostInstances = findAffectedHostInstances;
    exports.getFamilyByID = getFamilyByID;
    exports.getFamilyByType = getFamilyByType;
    exports.hasUnrecoverableErrors = hasUnrecoverableErrors;
    exports.injectIntoGlobalHook = injectIntoGlobalHook;
    exports.isLikelyComponentType = isLikelyComponentType;
    exports.performReactRefresh = performReactRefresh;
    exports.register = register;
    exports.setSignature = setSignature;
})();

},{}],"ecPDr":[function(require,module,exports) {
"use strict";
var HMR_HOST = null;
var HMR_PORT = 1234;
var HMR_SECURE = false;
var HMR_ENV_HASH = "0ec47630371e291a";
module.bundle.HMR_BUNDLE_ID = "2a4e2d0c02cb4d06";
function _createForOfIteratorHelper(o, allowArrayLike) {
    var it;
    if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) {
        if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") {
            if (it) o = it;
            var i = 0;
            var F = function F1() {
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
            it = o[Symbol.iterator]();
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
            removeErrorOverlay();
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
                } // Render the fancy html overlay
            } catch (err) {
                _iterator.e(err);
            } finally{
                _iterator.f();
            }
            removeErrorOverlay();
            var overlay = createErrorOverlay(data.diagnostics.html); // $FlowFixMe
            document.body.appendChild(overlay);
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
            errorHTML += "\n      <div>\n        <div style=\"font-size: 18px; font-weight: bold; margin-top: 20px;\">\n          \uD83D\uDEA8 ".concat(diagnostic.message, "\n        </div>\n        <pre>\n          ").concat(stack, "\n        </pre>\n        <div>\n          ").concat(diagnostic.hints.map(function(hint) {
                return '<div>' + hint + '</div>';
            }).join(''), "\n        </div>\n      </div>\n    ");
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
    if (asset.type === 'css') {
        reloadCSS();
        return;
    }
    var deps = asset.depsByBundle[bundle.HMR_BUNDLE_ID];
    if (deps) {
        var fn = new Function('require', 'module', 'exports', asset.output);
        modules[asset.id] = [
            fn,
            deps
        ];
    } else if (bundle.parent) hmrApply(bundle.parent, asset);
}
function hmrAcceptCheck(bundle, id, depsByBundle) {
    var modules = bundle.modules;
    if (!modules) return;
    if (depsByBundle && !depsByBundle[bundle.HMR_BUNDLE_ID]) {
        // If we reached the root bundle without finding where the asset should go,
        // there's nothing to do. Mark as "accepted" so we don't reload the page.
        if (!bundle.parent) return true;
        return hmrAcceptCheck(bundle.parent, id, depsByBundle);
    }
    if (checkedAssets[id]) return;
    checkedAssets[id] = true;
    var cached = bundle.cache[id];
    assetsToAccept.push([
        bundle,
        id
    ]);
    if (cached && cached.hot && cached.hot._acceptCallbacks.length) return true;
    return getParents(module.bundle.root, id).some(function(v) {
        return hmrAcceptCheck(v[0], v[1], null);
    });
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

},{}],"7Y5mU":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
/* global wp */ var _controlScss = require("./control.scss");
var _kirkiSelectControl = require("./KirkiSelectControl"); // Register control type with Customizer.
var _kirkiSelectControlDefault = parcelHelpers.interopDefault(_kirkiSelectControl);
wp.customize.controlConstructor['kirki-react-select'] = _kirkiSelectControlDefault.default;

},{"./control.scss":"3avPQ","./KirkiSelectControl":"d6ILU","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"3avPQ":[function() {},{}],"d6ILU":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
/* global wp, jQuery, React, ReactDOM, _ */ var _kirkiSelectForm = require("./KirkiSelectForm");
var _kirkiSelectFormDefault = parcelHelpers.interopDefault(_kirkiSelectForm);
function _extends() {
    _extends = Object.assign || function(target) {
        for(var i = 1; i < arguments.length; i++){
            var source = arguments[i];
            for(var key in source)if (Object.prototype.hasOwnProperty.call(source, key)) target[key] = source[key];
        }
        return target;
    };
    return _extends.apply(this, arguments);
}
/**
 * KirkiSelectControl.
 *
 * @class
 * @augments wp.customize.Control
 * @augments wp.customize.Class
 */ var KirkiSelectControl = wp.customize.Control.extend({
    /**
   * Initialize.
   *
   * @param {string} id - Control ID.
   * @param {object} params - Control params.
   */ initialize: function initialize(id, params) {
        var control = this; // Bind functions to this control context for passing as React props.
        control.setNotificationContainer = control.setNotificationContainer.bind(control);
        wp.customize.Control.prototype.initialize.call(control, id, params); // The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
        function onRemoved(removedControl) {
            if (control === removedControl) {
                control.destroy();
                control.container.remove();
                wp.customize.control.unbind('removed', onRemoved);
            }
        }
        wp.customize.control.bind('removed', onRemoved);
    },
    /**
   * Set notification container and render.
   *
   * This is called when the React component is mounted.
   *
   * @param {Element} element - Notification container.
   * @returns {void}
   */ setNotificationContainer: function setNotificationContainer(element) {
        var control = this;
        control.notifications.container = jQuery(element);
        control.notifications.render();
    },
    /**
   * Render the control into the DOM.
   *
   * This is called from the Control#embed() method in the parent class.
   *
   * @returns {void}
   */ renderContent: function renderContent() {
        var control = this;
        var value = control.setting.get();
        var form = /*#__PURE__*/ React.createElement(_kirkiSelectFormDefault.default, _extends({
        }, control.params, {
            value: value,
            setNotificationContainer: control.setNotificationContainer,
            isClearable: control.params.isClearable,
            customizerSetting: control.setting,
            isOptionDisabled: control.isOptionDisabled,
            control: control,
            isMulti: control.isMulti()
        }));
        ReactDOM.render(form, control.container[0]);
    },
    /**
   * After control has been first rendered, start re-rendering when setting changes.
   *
   * React is able to be used here instead of the wp.customize.Element abstraction.
   *
   * @returns {void}
   */ ready: function ready() {
        var control = this; // Re-render control when setting changes.
        control.setting.bind(function() {
            control.renderContent();
        });
    },
    isMulti: function isMulti() {
        if (!isNaN(this.params.multiple)) return 1 < this.params.multiple;
        if (true === this.params.multiple) return this.params.multiple;
        return false;
    },
    /**
   * Handle removal/de-registration of the control.
   *
   * This is essentially the inverse of the Control#embed() method.
   *
   * @link https://core.trac.wordpress.org/ticket/31334
   * @returns {void}
   */ destroy: function destroy() {
        var control = this; // Garbage collection: undo mounting that was done in the embed/renderContent method.
        ReactDOM.unmountComponentAtNode(control.container[0]); // Call destroy method in parent if it exists (as of #31334).
        if (wp.customize.Control.prototype.destroy) wp.customize.Control.prototype.destroy.call(control);
    },
    isOptionDisabled: function isOptionDisabled(option) {
        var control = this;
        if (!control) return false;
        if (!control.disabledSelectOptions) return false;
        if (control.disabledSelectOptions.indexOf(option)) return true;
        return false;
    },
    doSelectAction: function doSelectAction(action, arg) {
        var control = this;
        var i;
        switch(action){
            case 'disableOption':
                control.disabledSelectOptions = 'undefined' === typeof control.disabledSelectOptions ? [] : control.disabledSelectOptions;
                control.disabledSelectOptions.push(control.getOptionProps(arg));
                break;
            case 'enableOption':
                if (control.disabledSelectOptions) {
                    for(i = 0; i < control.disabledSelectOptions.length; i++)if (control.disabledSelectOptions[i].value === arg) control.disabledSelectOptions.splice(i, 1);
                }
                break;
            case 'selectOption':
                control.value = arg;
                break;
        }
        control.renderContent();
    },
    formatOptions: function formatOptions() {
        var self = this;
        this.formattedOptions = [];
        _.each(self.params.choices, function(label, value) {
            var optGroup;
            if ('object' === typeof label) {
                optGroup = {
                    label: label[0],
                    options: []
                };
                _.each(label[1], function(optionVal, optionKey) {
                    optGroup.options.push({
                        label: optionVal,
                        value: optionKey
                    });
                });
                self.formattedOptions.push(optGroup);
            } else if ('string' === typeof label) self.formattedOptions.push({
                label: label,
                value: value
            });
        });
    },
    getFormattedOptions: function getFormattedOptions() {
        if (!this.formattedOptions || !this.formattedOptions.length) this.formatOptions();
        return this.formattedOptions;
    },
    getOptionProps: function getOptionProps(value) {
        var options = this.getFormattedOptions(), i, l;
        for(i = 0; i < options.length; i++){
            if (options[i].value === value) return options[i];
            if (options[i].options) for(l = 0; l < options[i].options.length; l++){
                if (options[i].options[l].value === value) return options[i].options[l];
            }
        }
    }
});
exports.default = KirkiSelectControl;

},{"./KirkiSelectForm":"5gyD3","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"5gyD3":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _helpers = require("@swc/helpers");
/* globals _, wp, React */ var _reactSelect = require("react-select");
var _reactSelectDefault = parcelHelpers.interopDefault(_reactSelect);
function _extends() {
    _extends = Object.assign || function(target) {
        for(var i = 1; i < arguments.length; i++){
            var source = arguments[i];
            for(var key in source)if (Object.prototype.hasOwnProperty.call(source, key)) target[key] = source[key];
        }
        return target;
    };
    return _extends.apply(this, arguments);
}
var KirkiSelectForm = function(props) {
    /**
   * Pass-on the value to the customizer object to save.
   *
   * @param {Object} val - The selected option.
   */ var handleChangeComplete = function(val, type) {
        var newValue = type.action === 'clear' ? '' : val.value;
        wp.customize(props.customizerSetting.id).set(newValue);
    };
    /**
   * Change the color-scheme using WordPress colors.
   *
   * @param {Object} theme
   */ var theme = function(theme1) {
        return _helpers.objectSpread({
        }, theme1, {
            colors: _helpers.objectSpread({
            }, theme1.colors, {
                primary: '#0073aa',
                primary75: '#33b3db',
                primary50: '#99d9ed',
                primary24: '#e5f5fa'
            })
        });
    };
    /**
   * Allow rendering HTML in select labels.
   *
   * @param {Object} props - Object { label: foo, value: bar }.
   */ var getLabel = function(props1) {
        return(/*#__PURE__*/ React.createElement("div", {
            dangerouslySetInnerHTML: {
                __html: props1.label
            }
        }));
    };
    var inputId = props.inputId ? props.inputId : 'kirki-react-select-input--' + props.customizerSetting.id;
    return(/*#__PURE__*/ React.createElement("div", null, /*#__PURE__*/ React.createElement("label", {
        className: "customize-control-title",
        htmlFor: inputId
    }, props.label), /*#__PURE__*/ React.createElement("span", {
        className: "description customize-control-description",
        dangerouslySetInnerHTML: {
            __html: props.description
        }
    }), /*#__PURE__*/ React.createElement("div", {
        className: "customize-control-notifications-container",
        ref: props.setNotificationContainer
    }), /*#__PURE__*/ React.createElement(_reactSelectDefault.default, _extends({
    }, props, {
        inputId: inputId,
        openMenuOnFocus: props.openMenuOnFocus // @see https://github.com/JedWatson/react-select/issues/888#issuecomment-209376601
        ,
        formatOptionLabel: getLabel,
        options: props.control.getFormattedOptions(),
        theme: theme,
        onChange: handleChangeComplete,
        value: props.control.getOptionProps(props.value),
        isOptionDisabled: props.isOptionDisabled
    }))));
};
_c = KirkiSelectForm;
exports.default = KirkiSelectForm;
var _c;
$RefreshReg$(_c, "KirkiSelectForm");

},{"@swc/helpers":"fw9mb","react-select":"izluq","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"fw9mb":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "applyDecoratedDescriptor", ()=>_applyDecoratedDescriptorDefault.default
);
parcelHelpers.export(exports, "arrayWithHoles", ()=>_arrayWithHolesDefault.default
);
parcelHelpers.export(exports, "arrayWithoutHoles", ()=>_arrayWithoutHolesDefault.default
);
parcelHelpers.export(exports, "assertThisInitialized", ()=>_assertThisInitializedDefault.default
);
parcelHelpers.export(exports, "asyncGenerator", ()=>_asyncGeneratorDefault.default
);
parcelHelpers.export(exports, "asyncGeneratorDelegate", ()=>_asyncGeneratorDelegateDefault.default
);
parcelHelpers.export(exports, "asyncIterator", ()=>_asyncIteratorDefault.default
);
parcelHelpers.export(exports, "asyncToGenerator", ()=>_asyncToGeneratorDefault.default
);
parcelHelpers.export(exports, "awaitAsyncGenerator", ()=>_awaitAsyncGeneratorDefault.default
);
parcelHelpers.export(exports, "awaitValue", ()=>_awaitValueDefault.default
);
parcelHelpers.export(exports, "classCallCheck", ()=>_classCallCheckDefault.default
);
parcelHelpers.export(exports, "classNameTDZError", ()=>_classNameTdzErrorDefault.default
);
parcelHelpers.export(exports, "classPrivateFieldGet", ()=>_classPrivateFieldGetDefault.default
);
parcelHelpers.export(exports, "classPrivateFieldLooseBase", ()=>_classPrivateFieldLooseBaseDefault.default
);
parcelHelpers.export(exports, "classPrivateFieldSet", ()=>_classPrivateFieldSetDefault.default
);
parcelHelpers.export(exports, "classPrivateMethodGet", ()=>_classPrivateMethodGetDefault.default
);
parcelHelpers.export(exports, "classPrivateMethodSet", ()=>_classPrivateMethodSetDefault.default
);
parcelHelpers.export(exports, "classStaticPrivateFieldSpecGet", ()=>_classStaticPrivateFieldSpecGetDefault.default
);
parcelHelpers.export(exports, "classStaticPrivateFieldSpecSet", ()=>_classStaticPrivateFieldSpecSetDefault.default
);
parcelHelpers.export(exports, "construct", ()=>_constructDefault.default
);
parcelHelpers.export(exports, "createClass", ()=>_createClassDefault.default
);
parcelHelpers.export(exports, "decorate", ()=>_decorateDefault.default
);
parcelHelpers.export(exports, "defaults", ()=>_defaultsDefault.default
);
parcelHelpers.export(exports, "defineEnumerableProperties", ()=>_defineEnumerablePropertiesDefault.default
);
parcelHelpers.export(exports, "defineProperty", ()=>_definePropertyDefault.default
);
parcelHelpers.export(exports, "extends", ()=>_extendsDefault.default
);
parcelHelpers.export(exports, "get", ()=>_getDefault.default
);
parcelHelpers.export(exports, "getPrototypeOf", ()=>_getPrototypeOfDefault.default
);
parcelHelpers.export(exports, "inherits", ()=>_inheritsDefault.default
);
parcelHelpers.export(exports, "inheritsLoose", ()=>_inheritsLooseDefault.default
);
parcelHelpers.export(exports, "initializerDefineProperty", ()=>_initializerDefinePropertyDefault.default
);
parcelHelpers.export(exports, "initializerWarningHelper", ()=>_initializerWarningHelperDefault.default
);
parcelHelpers.export(exports, "_instanceof", ()=>_instanceofDefault.default
);
parcelHelpers.export(exports, "interopRequireDefault", ()=>_interopRequireDefaultDefault.default
);
parcelHelpers.export(exports, "interopRequireWildcard", ()=>_interopRequireWildcardDefault.default
);
parcelHelpers.export(exports, "isNativeFunction", ()=>_isNativeFunctionDefault.default
);
parcelHelpers.export(exports, "iterableToArray", ()=>_iterableToArrayDefault.default
);
parcelHelpers.export(exports, "iterableToArrayLimit", ()=>_iterableToArrayLimitDefault.default
);
parcelHelpers.export(exports, "iterableToArrayLimitLoose", ()=>_iterableToArrayLimitLooseDefault.default
);
parcelHelpers.export(exports, "jsx", ()=>_jsxDefault.default
);
parcelHelpers.export(exports, "newArrowCheck", ()=>_newArrowCheckDefault.default
);
parcelHelpers.export(exports, "nonIterableRest", ()=>_nonIterableRestDefault.default
);
parcelHelpers.export(exports, "nonIterableSpread", ()=>_nonIterableSpreadDefault.default
);
parcelHelpers.export(exports, "objectSpread", ()=>_objectSpreadDefault.default
);
parcelHelpers.export(exports, "objectWithoutProperties", ()=>_objectWithoutPropertiesDefault.default
);
parcelHelpers.export(exports, "objectWithoutPropertiesLoose", ()=>_objectWithoutPropertiesLooseDefault.default
);
parcelHelpers.export(exports, "possibleConstructorReturn", ()=>_possibleConstructorReturnDefault.default
);
parcelHelpers.export(exports, "readOnlyError", ()=>_readOnlyErrorDefault.default
);
parcelHelpers.export(exports, "set", ()=>_setDefault.default
);
parcelHelpers.export(exports, "setPrototypeOf", ()=>_setPrototypeOfDefault.default
);
parcelHelpers.export(exports, "skipFirstGeneratorNext", ()=>_skipFirstGeneratorNextDefault.default
);
parcelHelpers.export(exports, "slicedToArray", ()=>_slicedToArrayDefault.default
);
parcelHelpers.export(exports, "slicedToArrayLoose", ()=>_slicedToArrayLooseDefault.default
);
parcelHelpers.export(exports, "superPropBase", ()=>_superPropBaseDefault.default
);
parcelHelpers.export(exports, "taggedTemplateLiteral", ()=>_taggedTemplateLiteralDefault.default
);
parcelHelpers.export(exports, "taggedTemplateLiteralLoose", ()=>_taggedTemplateLiteralLooseDefault.default
);
parcelHelpers.export(exports, "_throw", ()=>_throwDefault.default
);
parcelHelpers.export(exports, "toArray", ()=>_toArrayDefault.default
);
parcelHelpers.export(exports, "toConsumableArray", ()=>_toConsumableArrayDefault.default
);
parcelHelpers.export(exports, "toPrimitive", ()=>_toPrimitiveDefault.default
);
parcelHelpers.export(exports, "toPropertyKey", ()=>_toPropertyKeyDefault.default
);
parcelHelpers.export(exports, "typeOf", ()=>_typeOfDefault.default
);
parcelHelpers.export(exports, "wrapAsyncGenerator", ()=>_wrapAsyncGeneratorDefault.default
);
parcelHelpers.export(exports, "wrapNativeSuper", ()=>_wrapNativeSuperDefault.default
);
var _applyDecoratedDescriptor = require("./_apply_decorated_descriptor");
var _applyDecoratedDescriptorDefault = parcelHelpers.interopDefault(_applyDecoratedDescriptor);
var _arrayWithHoles = require("./_array_with_holes");
var _arrayWithHolesDefault = parcelHelpers.interopDefault(_arrayWithHoles);
var _arrayWithoutHoles = require("./_array_without_holes");
var _arrayWithoutHolesDefault = parcelHelpers.interopDefault(_arrayWithoutHoles);
var _assertThisInitialized = require("./_assert_this_initialized");
var _assertThisInitializedDefault = parcelHelpers.interopDefault(_assertThisInitialized);
var _asyncGenerator = require("./_async_generator");
var _asyncGeneratorDefault = parcelHelpers.interopDefault(_asyncGenerator);
var _asyncGeneratorDelegate = require("./_async_generator_delegate");
var _asyncGeneratorDelegateDefault = parcelHelpers.interopDefault(_asyncGeneratorDelegate);
var _asyncIterator = require("./_async_iterator");
var _asyncIteratorDefault = parcelHelpers.interopDefault(_asyncIterator);
var _asyncToGenerator = require("./_async_to_generator");
var _asyncToGeneratorDefault = parcelHelpers.interopDefault(_asyncToGenerator);
var _awaitAsyncGenerator = require("./_await_async_generator");
var _awaitAsyncGeneratorDefault = parcelHelpers.interopDefault(_awaitAsyncGenerator);
var _awaitValue = require("./_await_value");
var _awaitValueDefault = parcelHelpers.interopDefault(_awaitValue);
var _classCallCheck = require("./_class_call_check");
var _classCallCheckDefault = parcelHelpers.interopDefault(_classCallCheck);
var _classNameTdzError = require("./_class_name_tdz_error");
var _classNameTdzErrorDefault = parcelHelpers.interopDefault(_classNameTdzError);
var _classPrivateFieldGet = require("./_class_private_field_get");
var _classPrivateFieldGetDefault = parcelHelpers.interopDefault(_classPrivateFieldGet);
var _classPrivateFieldLooseBase = require("./_class_private_field_loose_base");
var _classPrivateFieldLooseBaseDefault = parcelHelpers.interopDefault(_classPrivateFieldLooseBase);
var _classPrivateFieldSet = require("./_class_private_field_set");
var _classPrivateFieldSetDefault = parcelHelpers.interopDefault(_classPrivateFieldSet);
var _classPrivateMethodGet = require("./_class_private_method_get");
var _classPrivateMethodGetDefault = parcelHelpers.interopDefault(_classPrivateMethodGet);
var _classPrivateMethodSet = require("./_class_private_method_set");
var _classPrivateMethodSetDefault = parcelHelpers.interopDefault(_classPrivateMethodSet);
var _classStaticPrivateFieldSpecGet = require("./_class_static_private_field_spec_get");
var _classStaticPrivateFieldSpecGetDefault = parcelHelpers.interopDefault(_classStaticPrivateFieldSpecGet);
var _classStaticPrivateFieldSpecSet = require("./_class_static_private_field_spec_set");
var _classStaticPrivateFieldSpecSetDefault = parcelHelpers.interopDefault(_classStaticPrivateFieldSpecSet);
var _construct = require("./_construct");
var _constructDefault = parcelHelpers.interopDefault(_construct);
var _createClass = require("./_create_class");
var _createClassDefault = parcelHelpers.interopDefault(_createClass);
var _decorate = require("./_decorate");
var _decorateDefault = parcelHelpers.interopDefault(_decorate);
var _defaults = require("./_defaults");
var _defaultsDefault = parcelHelpers.interopDefault(_defaults);
var _defineEnumerableProperties = require("./_define_enumerable_properties");
var _defineEnumerablePropertiesDefault = parcelHelpers.interopDefault(_defineEnumerableProperties);
var _defineProperty = require("./_define_property");
var _definePropertyDefault = parcelHelpers.interopDefault(_defineProperty);
var _extends = require("./_extends");
var _extendsDefault = parcelHelpers.interopDefault(_extends);
var _get = require("./_get");
var _getDefault = parcelHelpers.interopDefault(_get);
var _getPrototypeOf = require("./_get_prototype_of");
var _getPrototypeOfDefault = parcelHelpers.interopDefault(_getPrototypeOf);
var _inherits = require("./_inherits");
var _inheritsDefault = parcelHelpers.interopDefault(_inherits);
var _inheritsLoose = require("./_inherits_loose");
var _inheritsLooseDefault = parcelHelpers.interopDefault(_inheritsLoose);
var _initializerDefineProperty = require("./_initializer_define_property");
var _initializerDefinePropertyDefault = parcelHelpers.interopDefault(_initializerDefineProperty);
var _initializerWarningHelper = require("./_initializer_warning_helper");
var _initializerWarningHelperDefault = parcelHelpers.interopDefault(_initializerWarningHelper);
var _instanceof = require("./_instanceof");
var _instanceofDefault = parcelHelpers.interopDefault(_instanceof);
var _interopRequireDefault = require("./_interop_require_default");
var _interopRequireDefaultDefault = parcelHelpers.interopDefault(_interopRequireDefault);
var _interopRequireWildcard = require("./_interop_require_wildcard");
var _interopRequireWildcardDefault = parcelHelpers.interopDefault(_interopRequireWildcard);
var _isNativeFunction = require("./_is_native_function");
var _isNativeFunctionDefault = parcelHelpers.interopDefault(_isNativeFunction);
var _iterableToArray = require("./_iterable_to_array");
var _iterableToArrayDefault = parcelHelpers.interopDefault(_iterableToArray);
var _iterableToArrayLimit = require("./_iterable_to_array_limit");
var _iterableToArrayLimitDefault = parcelHelpers.interopDefault(_iterableToArrayLimit);
var _iterableToArrayLimitLoose = require("./_iterable_to_array_limit_loose");
var _iterableToArrayLimitLooseDefault = parcelHelpers.interopDefault(_iterableToArrayLimitLoose);
var _jsx = require("./_jsx");
var _jsxDefault = parcelHelpers.interopDefault(_jsx);
var _newArrowCheck = require("./_new_arrow_check");
var _newArrowCheckDefault = parcelHelpers.interopDefault(_newArrowCheck);
var _nonIterableRest = require("./_non_iterable_rest");
var _nonIterableRestDefault = parcelHelpers.interopDefault(_nonIterableRest);
var _nonIterableSpread = require("./_non_iterable_spread");
var _nonIterableSpreadDefault = parcelHelpers.interopDefault(_nonIterableSpread);
var _objectSpread = require("./_object_spread");
var _objectSpreadDefault = parcelHelpers.interopDefault(_objectSpread);
var _objectWithoutProperties = require("./_object_without_properties");
var _objectWithoutPropertiesDefault = parcelHelpers.interopDefault(_objectWithoutProperties);
var _objectWithoutPropertiesLoose = require("./_object_without_properties_loose");
var _objectWithoutPropertiesLooseDefault = parcelHelpers.interopDefault(_objectWithoutPropertiesLoose);
var _possibleConstructorReturn = require("./_possible_constructor_return");
var _possibleConstructorReturnDefault = parcelHelpers.interopDefault(_possibleConstructorReturn);
var _readOnlyError = require("./_read_only_error");
var _readOnlyErrorDefault = parcelHelpers.interopDefault(_readOnlyError);
var _set = require("./_set");
var _setDefault = parcelHelpers.interopDefault(_set);
var _setPrototypeOf = require("./_set_prototype_of");
var _setPrototypeOfDefault = parcelHelpers.interopDefault(_setPrototypeOf);
var _skipFirstGeneratorNext = require("./_skip_first_generator_next");
var _skipFirstGeneratorNextDefault = parcelHelpers.interopDefault(_skipFirstGeneratorNext);
var _slicedToArray = require("./_sliced_to_array");
var _slicedToArrayDefault = parcelHelpers.interopDefault(_slicedToArray);
var _slicedToArrayLoose = require("./_sliced_to_array_loose");
var _slicedToArrayLooseDefault = parcelHelpers.interopDefault(_slicedToArrayLoose);
var _superPropBase = require("./_super_prop_base");
var _superPropBaseDefault = parcelHelpers.interopDefault(_superPropBase);
var _taggedTemplateLiteral = require("./_tagged_template_literal");
var _taggedTemplateLiteralDefault = parcelHelpers.interopDefault(_taggedTemplateLiteral);
var _taggedTemplateLiteralLoose = require("./_tagged_template_literal_loose");
var _taggedTemplateLiteralLooseDefault = parcelHelpers.interopDefault(_taggedTemplateLiteralLoose);
var _throw = require("./_throw");
var _throwDefault = parcelHelpers.interopDefault(_throw);
var _toArray = require("./_to_array");
var _toArrayDefault = parcelHelpers.interopDefault(_toArray);
var _toConsumableArray = require("./_to_consumable_array");
var _toConsumableArrayDefault = parcelHelpers.interopDefault(_toConsumableArray);
var _toPrimitive = require("./_to_primitive");
var _toPrimitiveDefault = parcelHelpers.interopDefault(_toPrimitive);
var _toPropertyKey = require("./_to_property_key");
var _toPropertyKeyDefault = parcelHelpers.interopDefault(_toPropertyKey);
var _typeOf = require("./_type_of");
var _typeOfDefault = parcelHelpers.interopDefault(_typeOf);
var _wrapAsyncGenerator = require("./_wrap_async_generator");
var _wrapAsyncGeneratorDefault = parcelHelpers.interopDefault(_wrapAsyncGenerator);
var _wrapNativeSuper = require("./_wrap_native_super");
var _wrapNativeSuperDefault = parcelHelpers.interopDefault(_wrapNativeSuper);

},{"./_apply_decorated_descriptor":"lfXlB","./_array_with_holes":"4bPjv","./_array_without_holes":"iondU","./_assert_this_initialized":"kUyb2","./_async_generator":"hendw","./_async_generator_delegate":"5GhYz","./_async_iterator":"cJf2z","./_async_to_generator":"3oC7B","./_await_async_generator":"5OrZN","./_await_value":"9K3QG","./_class_call_check":"l65ID","./_class_name_tdz_error":"fraHo","./_class_private_field_get":"c1Xv7","./_class_private_field_loose_base":"3N2W9","./_class_private_field_set":"93MOC","./_class_private_method_get":"6uRdf","./_class_private_method_set":"lBWOR","./_class_static_private_field_spec_get":"bKX7D","./_class_static_private_field_spec_set":"14P2S","./_construct":"kITdI","./_create_class":"87aUT","./_decorate":"4LjN9","./_defaults":"dEpp1","./_define_enumerable_properties":"fOq1m","./_define_property":"63lzi","./_extends":"cDXfG","./_get":"kLvQz","./_get_prototype_of":"gYdhY","./_inherits":"iUa9b","./_inherits_loose":"bXGPP","./_initializer_define_property":"blDCs","./_initializer_warning_helper":"1wFgn","./_instanceof":"5qkn9","./_interop_require_default":"9Dkex","./_interop_require_wildcard":"6L2fb","./_is_native_function":"1lChi","./_iterable_to_array":"6TjaF","./_iterable_to_array_limit":"l9ohl","./_iterable_to_array_limit_loose":"fJTPN","./_jsx":"cgH9z","./_new_arrow_check":"kWAHZ","./_non_iterable_rest":"fW4Zj","./_non_iterable_spread":"3VWOU","./_object_spread":"6u00B","./_object_without_properties":"9TPKd","./_object_without_properties_loose":"ly94u","./_possible_constructor_return":"6EFRu","./_read_only_error":"jLs6m","./_set":"bHz5n","./_set_prototype_of":"3QEan","./_skip_first_generator_next":"f4W1z","./_sliced_to_array":"afwXB","./_sliced_to_array_loose":"MXuPk","./_super_prop_base":"7Qc8A","./_tagged_template_literal":"kaFDN","./_tagged_template_literal_loose":"6Q47B","./_throw":"bU4YJ","./_to_array":"2QxEV","./_to_consumable_array":"4HrUM","./_to_primitive":"9205g","./_to_property_key":"iz6DG","./_type_of":"3RJph","./_wrap_async_generator":"8TRim","./_wrap_native_super":"4RJ2k","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"lfXlB":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _applyDecoratedDescriptor(target, property, decorators, descriptor, context) {
    var desc = {
    };
    Object["keys"](descriptor).forEach(function(key) {
        desc[key] = descriptor[key];
    });
    desc.enumerable = !!desc.enumerable;
    desc.configurable = !!desc.configurable;
    if ('value' in desc || desc.initializer) desc.writable = true;
    desc = decorators.slice().reverse().reduce(function(desc1, decorator) {
        return decorator ? decorator(target, property, desc1) || desc1 : desc1;
    }, desc);
    if (context && desc.initializer !== void 0) {
        desc.value = desc.initializer ? desc.initializer.call(context) : void 0;
        desc.initializer = undefined;
    }
    if (desc.initializer === void 0) {
        Object["defineProperty"](target, property, desc);
        desc = null;
    }
    return desc;
}
exports.default = _applyDecoratedDescriptor;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"bdniN":[function(require,module,exports) {
exports.interopDefault = function(a) {
    return a && a.__esModule ? a : {
        default: a
    };
};
exports.defineInteropFlag = function(a) {
    Object.defineProperty(a, '__esModule', {
        value: true
    });
};
exports.exportAll = function(source, dest) {
    Object.keys(source).forEach(function(key) {
        if (key === 'default' || key === '__esModule') return;
        // Skip duplicate re-exports when they have the same value.
        if (key in dest && dest[key] === source[key]) return;
        Object.defineProperty(dest, key, {
            enumerable: true,
            get: function() {
                return source[key];
            }
        });
    });
    return dest;
};
exports.export = function(dest, destName, get) {
    Object.defineProperty(dest, destName, {
        enumerable: true,
        get: get
    });
};

},{}],"4bPjv":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _arrayWithHoles(arr) {
    if (Array.isArray(arr)) return arr;
}
exports.default = _arrayWithHoles;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"iondU":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) {
        for(var i = 0, arr2 = new Array(arr.length); i < arr.length; i++)arr2[i] = arr[i];
        return arr2;
    }
}
exports.default = _arrayWithoutHoles;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"kUyb2":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _assertThisInitialized(self) {
    if (self === void 0) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    return self;
}
exports.default = _assertThisInitialized;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"hendw":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _awaitValue = require("./_await_value");
var _awaitValueDefault = parcelHelpers.interopDefault(_awaitValue);
function AsyncGenerator(gen) {
    var front, back;
    function send(key, arg) {
        return new Promise(function(resolve, reject) {
            var request = {
                key: key,
                arg: arg,
                resolve: resolve,
                reject: reject,
                next: null
            };
            if (back) back = back.next = request;
            else {
                front = back = request;
                resume(key, arg);
            }
        });
    }
    function resume(key, arg) {
        try {
            var result = gen[key](arg);
            var value = result.value;
            var wrappedAwait = value instanceof _awaitValueDefault.default;
            Promise.resolve(wrappedAwait ? value.wrapped : value).then(function(arg1) {
                if (wrappedAwait) {
                    resume("next", arg1);
                    return;
                }
                settle(result.done ? "return" : "normal", arg1);
            }, function(err) {
                resume("throw", err);
            });
        } catch (err) {
            settle("throw", err);
        }
    }
    function settle(type, value) {
        switch(type){
            case "return":
                front.resolve({
                    value: value,
                    done: true
                });
                break;
            case "throw":
                front.reject(value);
                break;
            default:
                front.resolve({
                    value: value,
                    done: false
                });
                break;
        }
        front = front.next;
        if (front) resume(front.key, front.arg);
        else back = null;
    }
    this._invoke = send;
    if (typeof gen.return !== "function") this.return = undefined;
}
exports.default = AsyncGenerator;
if (typeof Symbol === "function" && Symbol.asyncIterator) AsyncGenerator.prototype[Symbol.asyncIterator] = function() {
    return this;
};
AsyncGenerator.prototype.next = function(arg) {
    return this._invoke("next", arg);
};
AsyncGenerator.prototype.throw = function(arg) {
    return this._invoke("throw", arg);
};
AsyncGenerator.prototype.return = function(arg) {
    return this._invoke("return", arg);
};

},{"./_await_value":"9K3QG","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"9K3QG":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _AwaitValue(value) {
    this.wrapped = value;
}
exports.default = _AwaitValue;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"5GhYz":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _asyncGeneratorDelegate(inner, awaitWrap) {
    var iter = {
    }, waiting = false;
    function pump(key, value) {
        waiting = true;
        value = new Promise(function(resolve) {
            resolve(inner[key](value));
        });
        return {
            done: false,
            value: awaitWrap(value)
        };
    }
    if (typeof Symbol === "function" && Symbol.iterator) iter[Symbol.iterator] = function() {
        return this;
    };
    iter.next = function(value) {
        if (waiting) {
            waiting = false;
            return value;
        }
        return pump("next", value);
    };
    if (typeof inner.throw === "function") iter.throw = function(value) {
        if (waiting) {
            waiting = false;
            throw value;
        }
        return pump("throw", value);
    };
    if (typeof inner.return === "function") iter.return = function(value) {
        return pump("return", value);
    };
    return iter;
}
exports.default = _asyncGeneratorDelegate;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"cJf2z":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _asyncIterator(iterable) {
    var method;
    if (typeof Symbol === "function") {
        if (Symbol.asyncIterator) {
            method = iterable[Symbol.asyncIterator];
            if (method != null) return method.call(iterable);
        }
        if (Symbol.iterator) {
            method = iterable[Symbol.iterator];
            if (method != null) return method.call(iterable);
        }
    }
    throw new TypeError("Object is not async iterable");
}
exports.default = _asyncIterator;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"3oC7B":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
    try {
        var info = gen[key](arg);
        var value = info.value;
    } catch (error) {
        reject(error);
        return;
    }
    if (info.done) resolve(value);
    else Promise.resolve(value).then(_next, _throw);
}
function _asyncToGenerator(fn) {
    return function() {
        var self = this, args = arguments;
        return new Promise(function(resolve, reject) {
            var gen = fn.apply(self, args);
            function _next(value) {
                asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value);
            }
            function _throw(err) {
                asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err);
            }
            _next(undefined);
        });
    };
}
exports.default = _asyncToGenerator;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"5OrZN":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _awaitValue = require("./_await_value");
var _awaitValueDefault = parcelHelpers.interopDefault(_awaitValue);
function _awaitAsyncGenerator(value) {
    return new _awaitValueDefault.default(value);
}
exports.default = _awaitAsyncGenerator;

},{"./_await_value":"9K3QG","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"l65ID":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) throw new TypeError("Cannot call a class as a function");
}
exports.default = _classCallCheck;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"fraHo":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _classNameTDZError(name) {
    throw new Error("Class \"" + name + "\" cannot be referenced in computed property keys.");
}
exports.default = _classNameTDZError;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"c1Xv7":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _classPrivateFieldGet(receiver, privateMap) {
    if (!privateMap.has(receiver)) throw new TypeError("attempted to get private field on non-instance");
    return privateMap.get(receiver).value;
}
exports.default = _classPrivateFieldGet;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"3N2W9":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _classPrivateFieldBase(receiver, privateKey) {
    if (!Object.prototype.hasOwnProperty.call(receiver, privateKey)) throw new TypeError("attempted to use private field on non-instance");
    return receiver;
}
exports.default = _classPrivateFieldBase;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"93MOC":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _classPrivateFieldSet(receiver, privateMap, value) {
    if (!privateMap.has(receiver)) throw new TypeError("attempted to set private field on non-instance");
    var descriptor = privateMap.get(receiver);
    if (!descriptor.writable) throw new TypeError("attempted to set read only private field");
    descriptor.value = value;
    return value;
}
exports.default = _classPrivateFieldSet;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"6uRdf":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _classPrivateMethodGet(receiver, privateSet, fn) {
    if (!privateSet.has(receiver)) throw new TypeError("attempted to get private field on non-instance");
    return fn;
}
exports.default = _classPrivateMethodGet;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"lBWOR":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _classPrivateMethodSet() {
    throw new TypeError("attempted to reassign private method");
}
exports.default = _classPrivateMethodSet;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"bKX7D":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _classStaticPrivateFieldSpecGet(receiver, classConstructor, descriptor) {
    if (receiver !== classConstructor) throw new TypeError("Private static access of wrong provenance");
    return descriptor.value;
}
exports.default = _classStaticPrivateFieldSpecGet;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"14P2S":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _classStaticPrivateFieldSpecSet(receiver, classConstructor, descriptor, value) {
    if (receiver !== classConstructor) throw new TypeError("Private static access of wrong provenance");
    if (!descriptor.writable) throw new TypeError("attempted to set read only private field");
    descriptor.value = value;
    return value;
}
exports.default = _classStaticPrivateFieldSpecSet;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"kITdI":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function isNativeReflectConstruct() {
    if (typeof Reflect === "undefined" || !Reflect.construct) return false;
    if (Reflect.construct.sham) return false;
    if (typeof Proxy === "function") return true;
    try {
        Date.prototype.toString.call(Reflect.construct(Date, [], function() {
        }));
        return true;
    } catch (e) {
        return false;
    }
}
function construct(Parent, args, Class) {
    if (isNativeReflectConstruct()) construct = Reflect.construct;
    else construct = function construct1(Parent1, args1, Class1) {
        var a = [
            null
        ];
        a.push.apply(a, args1);
        var Constructor = Function.bind.apply(Parent1, a);
        var instance = new Constructor();
        if (Class1) _setPrototypeOf(instance, Class1.prototype);
        return instance;
    };
    return construct.apply(null, arguments);
}
function _construct(Parent, args, Class) {
    return construct.apply(null, arguments);
}
exports.default = _construct;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"87aUT":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _defineProperties(target, props) {
    for(var i = 0; i < props.length; i++){
        var descriptor = props[i];
        descriptor.enumerable = descriptor.enumerable || false;
        descriptor.configurable = true;
        if ("value" in descriptor) descriptor.writable = true;
        Object.defineProperty(target, descriptor.key, descriptor);
    }
}
function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor;
}
exports.default = _createClass;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"4LjN9":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _toArray = require("./_to_array");
var _toArrayDefault = parcelHelpers.interopDefault(_toArray);
var _toPropertyKey = require("./_to_property_key");
var _toPropertyKeyDefault = parcelHelpers.interopDefault(_toPropertyKey);
function _decorate(decorators, factory, superClass) {
    var r = factory(function initialize(O) {
        _initializeInstanceElements(O, decorated.elements);
    }, superClass);
    var decorated = _decorateClass(_coalesceClassElements(r.d.map(_createElementDescriptor)), decorators);
    _initializeClassElements(r.F, decorated.elements);
    return _runClassFinishers(r.F, decorated.finishers);
}
exports.default = _decorate;
function _createElementDescriptor(def) {
    var key = _toPropertyKeyDefault.default(def.key);
    var descriptor;
    if (def.kind === "method") {
        descriptor = {
            value: def.value,
            writable: true,
            configurable: true,
            enumerable: false
        };
        Object.defineProperty(def.value, "name", {
            value: _typeof(key) === "symbol" ? "" : key,
            configurable: true
        });
    } else if (def.kind === "get") descriptor = {
        get: def.value,
        configurable: true,
        enumerable: false
    };
    else if (def.kind === "set") descriptor = {
        set: def.value,
        configurable: true,
        enumerable: false
    };
    else if (def.kind === "field") descriptor = {
        configurable: true,
        writable: true,
        enumerable: true
    };
    var element = {
        kind: def.kind === "field" ? "field" : "method",
        key: key,
        placement: def.static ? "static" : def.kind === "field" ? "own" : "prototype",
        descriptor: descriptor
    };
    if (def.decorators) element.decorators = def.decorators;
    if (def.kind === "field") element.initializer = def.value;
    return element;
}
function _coalesceGetterSetter(element, other) {
    if (element.descriptor.get !== undefined) other.descriptor.get = element.descriptor.get;
    else other.descriptor.set = element.descriptor.set;
}
function _coalesceClassElements(elements) {
    var newElements = [];
    var isSameElement = function isSameElement1(other) {
        return other.kind === "method" && other.key === element.key && other.placement === element.placement;
    };
    for(var i = 0; i < elements.length; i++){
        var element = elements[i];
        var other;
        if (element.kind === "method" && (other = newElements.find(isSameElement))) {
            if (_isDataDescriptor(element.descriptor) || _isDataDescriptor(other.descriptor)) {
                if (_hasDecorators(element) || _hasDecorators(other)) throw new ReferenceError("Duplicated methods (" + element.key + ") can't be decorated.");
                other.descriptor = element.descriptor;
            } else {
                if (_hasDecorators(element)) {
                    if (_hasDecorators(other)) throw new ReferenceError("Decorators can't be placed on different accessors with for the same property (" + element.key + ").");
                    other.decorators = element.decorators;
                }
                _coalesceGetterSetter(element, other);
            }
        } else newElements.push(element);
    }
    return newElements;
}
function _hasDecorators(element) {
    return element.decorators && element.decorators.length;
}
function _isDataDescriptor(desc) {
    return desc !== undefined && !(desc.value === undefined && desc.writable === undefined);
}
function _initializeClassElements(F, elements) {
    var proto = F.prototype;
    [
        "method",
        "field"
    ].forEach(function(kind) {
        elements.forEach(function(element) {
            var placement = element.placement;
            if (element.kind === kind && (placement === "static" || placement === "prototype")) {
                var receiver = placement === "static" ? F : proto;
                _defineClassElement(receiver, element);
            }
        });
    });
}
function _initializeInstanceElements(O, elements) {
    [
        "method",
        "field"
    ].forEach(function(kind) {
        elements.forEach(function(element) {
            if (element.kind === kind && element.placement === "own") _defineClassElement(O, element);
        });
    });
}
function _defineClassElement(receiver, element) {
    var descriptor = element.descriptor;
    if (element.kind === "field") {
        var initializer = element.initializer;
        descriptor = {
            enumerable: descriptor.enumerable,
            writable: descriptor.writable,
            configurable: descriptor.configurable,
            value: initializer === void 0 ? void 0 : initializer.call(receiver)
        };
    }
    Object.defineProperty(receiver, element.key, descriptor);
}
function _decorateClass(elements, decorators) {
    var newElements = [];
    var finishers = [];
    var placements = {
        static: [],
        prototype: [],
        own: []
    };
    elements.forEach(function(element) {
        _addElementPlacement(element, placements);
    });
    elements.forEach(function(element) {
        if (!_hasDecorators(element)) return newElements.push(element);
        var elementFinishersExtras = _decorateElement(element, placements);
        newElements.push(elementFinishersExtras.element);
        newElements.push.apply(newElements, elementFinishersExtras.extras);
        finishers.push.apply(finishers, elementFinishersExtras.finishers);
    });
    if (!decorators) return {
        elements: newElements,
        finishers: finishers
    };
    var result = _decorateConstructor(newElements, decorators);
    finishers.push.apply(finishers, result.finishers);
    result.finishers = finishers;
    return result;
}
function _addElementPlacement(element, placements, silent) {
    var keys = placements[element.placement];
    if (!silent && keys.indexOf(element.key) !== -1) throw new TypeError("Duplicated element (" + element.key + ")");
    keys.push(element.key);
}
function _decorateElement(element, placements) {
    var extras = [];
    var finishers = [];
    for(var decorators = element.decorators, i = decorators.length - 1; i >= 0; i--){
        var keys = placements[element.placement];
        keys.splice(keys.indexOf(element.key), 1);
        var elementObject = _fromElementDescriptor(element);
        var elementFinisherExtras = _toElementFinisherExtras(decorators[i](elementObject) || elementObject);
        element = elementFinisherExtras.element;
        _addElementPlacement(element, placements);
        if (elementFinisherExtras.finisher) finishers.push(elementFinisherExtras.finisher);
        var newExtras = elementFinisherExtras.extras;
        if (newExtras) {
            for(var j = 0; j < newExtras.length; j++)_addElementPlacement(newExtras[j], placements);
            extras.push.apply(extras, newExtras);
        }
    }
    return {
        element: element,
        finishers: finishers,
        extras: extras
    };
}
function _decorateConstructor(elements, decorators) {
    var finishers = [];
    for(var i = decorators.length - 1; i >= 0; i--){
        var obj = _fromClassDescriptor(elements);
        var elementsAndFinisher = _toClassDescriptor(decorators[i](obj) || obj);
        if (elementsAndFinisher.finisher !== undefined) finishers.push(elementsAndFinisher.finisher);
        if (elementsAndFinisher.elements !== undefined) {
            elements = elementsAndFinisher.elements;
            for(var j = 0; j < elements.length - 1; j++)for(var k = j + 1; k < elements.length; k++){
                if (elements[j].key === elements[k].key && elements[j].placement === elements[k].placement) throw new TypeError("Duplicated element (" + elements[j].key + ")");
            }
        }
    }
    return {
        elements: elements,
        finishers: finishers
    };
}
function _fromElementDescriptor(element) {
    var obj = {
        kind: element.kind,
        key: element.key,
        placement: element.placement,
        descriptor: element.descriptor
    };
    var desc = {
        value: "Descriptor",
        configurable: true
    };
    Object.defineProperty(obj, Symbol.toStringTag, desc);
    if (element.kind === "field") obj.initializer = element.initializer;
    return obj;
}
function _toElementDescriptors(elementObjects) {
    if (elementObjects === undefined) return;
    return _toArrayDefault.default(elementObjects).map(function(elementObject) {
        var element = _toElementDescriptor(elementObject);
        _disallowProperty(elementObject, "finisher", "An element descriptor");
        _disallowProperty(elementObject, "extras", "An element descriptor");
        return element;
    });
}
function _toElementDescriptor(elementObject) {
    var kind = String(elementObject.kind);
    if (kind !== "method" && kind !== "field") throw new TypeError("An element descriptor's .kind property must be either \"method\" or \"field\", but a decorator created an element descriptor with .kind \"" + kind + '"');
    var key = _toPropertyKeyDefault.default(elementObject.key);
    var placement = String(elementObject.placement);
    if (placement !== "static" && placement !== "prototype" && placement !== "own") throw new TypeError("An element descriptor's .placement property must be one of \"static\", \"prototype\" or \"own\", but a decorator created an element descriptor with .placement \"" + placement + '"');
    var descriptor = elementObject.descriptor;
    _disallowProperty(elementObject, "elements", "An element descriptor");
    var element = {
        kind: kind,
        key: key,
        placement: placement,
        descriptor: Object.assign({
        }, descriptor)
    };
    if (kind !== "field") _disallowProperty(elementObject, "initializer", "A method descriptor");
    else {
        _disallowProperty(descriptor, "get", "The property descriptor of a field descriptor");
        _disallowProperty(descriptor, "set", "The property descriptor of a field descriptor");
        _disallowProperty(descriptor, "value", "The property descriptor of a field descriptor");
        element.initializer = elementObject.initializer;
    }
    return element;
}
function _toElementFinisherExtras(elementObject) {
    var element = _toElementDescriptor(elementObject);
    var finisher = _optionalCallableProperty(elementObject, "finisher");
    var extras = _toElementDescriptors(elementObject.extras);
    return {
        element: element,
        finisher: finisher,
        extras: extras
    };
}
function _fromClassDescriptor(elements) {
    var obj = {
        kind: "class",
        elements: elements.map(_fromElementDescriptor)
    };
    var desc = {
        value: "Descriptor",
        configurable: true
    };
    Object.defineProperty(obj, Symbol.toStringTag, desc);
    return obj;
}
function _toClassDescriptor(obj) {
    var kind = String(obj.kind);
    if (kind !== "class") throw new TypeError("A class descriptor's .kind property must be \"class\", but a decorator created a class descriptor with .kind \"" + kind + '"');
    _disallowProperty(obj, "key", "A class descriptor");
    _disallowProperty(obj, "placement", "A class descriptor");
    _disallowProperty(obj, "descriptor", "A class descriptor");
    _disallowProperty(obj, "initializer", "A class descriptor");
    _disallowProperty(obj, "extras", "A class descriptor");
    var finisher = _optionalCallableProperty(obj, "finisher");
    var elements = _toElementDescriptors(obj.elements);
    return {
        elements: elements,
        finisher: finisher
    };
}
function _disallowProperty(obj, name, objectType) {
    if (obj[name] !== undefined) throw new TypeError(objectType + " can't have a ." + name + " property.");
}
function _optionalCallableProperty(obj, name) {
    var value = obj[name];
    if (value !== undefined && typeof value !== "function") throw new TypeError("Expected '" + name + "' to be a function");
    return value;
}
function _runClassFinishers(constructor, finishers) {
    for(var i = 0; i < finishers.length; i++){
        var newConstructor = finishers[i](constructor);
        if (newConstructor !== undefined) {
            if (typeof newConstructor !== "function") throw new TypeError("Finishers must return a constructor.");
            constructor = newConstructor;
        }
    }
    return constructor;
}

},{"./_to_array":"2QxEV","./_to_property_key":"iz6DG","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"2QxEV":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _arrayWithHoles = require("./_array_with_holes");
var _arrayWithHolesDefault = parcelHelpers.interopDefault(_arrayWithHoles);
var _iterableToArray = require("./_iterable_to_array");
var _iterableToArrayDefault = parcelHelpers.interopDefault(_iterableToArray);
var _nonIterableRest = require("./_non_iterable_rest");
var _nonIterableRestDefault = parcelHelpers.interopDefault(_nonIterableRest);
function _toArray(arr) {
    return _arrayWithHolesDefault.default(arr) || _iterableToArrayDefault.default(arr) || _nonIterableRestDefault.default();
}
exports.default = _toArray;

},{"./_array_with_holes":"4bPjv","./_iterable_to_array":"6TjaF","./_non_iterable_rest":"fW4Zj","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"6TjaF":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _iterableToArray(iter) {
    if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter);
}
exports.default = _iterableToArray;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"fW4Zj":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _nonIterableRest() {
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}
exports.default = _nonIterableRest;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"iz6DG":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _typeOf = require("./_type_of");
var _typeOfDefault = parcelHelpers.interopDefault(_typeOf);
var _toPrimitive = require("./_to_primitive");
var _toPrimitiveDefault = parcelHelpers.interopDefault(_toPrimitive);
function _toPropertyKey(arg) {
    var key = _toPrimitiveDefault.default(arg, "string");
    return _typeOfDefault.default(key) === "symbol" ? key : String(key);
}
exports.default = _toPropertyKey;

},{"./_type_of":"3RJph","./_to_primitive":"9205g","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"3RJph":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _typeof(obj) {
    return obj && obj.constructor === Symbol ? "symbol" : typeof obj;
}
exports.default = _typeof;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"9205g":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _typeOf = require("./_type_of");
var _typeOfDefault = parcelHelpers.interopDefault(_typeOf);
function _toPrimitive(input, hint) {
    if (_typeOfDefault.default(input) !== "object" || input === null) return input;
    var prim = input[Symbol.toPrimitive];
    if (prim !== undefined) {
        var res = prim.call(input, hint || "default");
        if (_typeOfDefault.default(res) !== "object") return res;
        throw new TypeError("@@toPrimitive must return a primitive value.");
    }
    return (hint === "string" ? String : Number)(input);
}
exports.default = _toPrimitive;

},{"./_type_of":"3RJph","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"dEpp1":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _defaults(obj, defaults) {
    var keys = Object.getOwnPropertyNames(defaults);
    for(var i = 0; i < keys.length; i++){
        var key = keys[i];
        var value = Object.getOwnPropertyDescriptor(defaults, key);
        if (value && value.configurable && obj[key] === undefined) Object.defineProperty(obj, key, value);
    }
    return obj;
}
exports.default = _defaults;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"fOq1m":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _defineEnumerableProperties(obj, descs) {
    for(var key in descs){
        var desc = descs[key];
        desc.configurable = desc.enumerable = true;
        if ("value" in desc) desc.writable = true;
        Object.defineProperty(obj, key, desc);
    }
    if (Object.getOwnPropertySymbols) {
        var objectSymbols = Object.getOwnPropertySymbols(descs);
        for(var i = 0; i < objectSymbols.length; i++){
            var sym = objectSymbols[i];
            var desc = descs[sym];
            desc.configurable = desc.enumerable = true;
            if ("value" in desc) desc.writable = true;
            Object.defineProperty(obj, sym, desc);
        }
    }
    return obj;
}
exports.default = _defineEnumerableProperties;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"63lzi":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _defineProperty(obj, key, value) {
    if (key in obj) Object.defineProperty(obj, key, {
        value: value,
        enumerable: true,
        configurable: true,
        writable: true
    });
    else obj[key] = value;
    return obj;
}
exports.default = _defineProperty;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"cDXfG":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function extends_() {
    extends_ = Object.assign || function(target) {
        for(var i = 1; i < arguments.length; i++){
            var source = arguments[i];
            for(var key in source)if (Object.prototype.hasOwnProperty.call(source, key)) target[key] = source[key];
        }
        return target;
    };
    return extends_.apply(this, arguments);
}
function _extends() {
    return extends_.apply(this, arguments);
}
exports.default = _extends;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"kLvQz":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _superPropBase = require("./_super_prop_base");
var _superPropBaseDefault = parcelHelpers.interopDefault(_superPropBase);
function get(target, property, receiver) {
    if (typeof Reflect !== "undefined" && Reflect.get) get = Reflect.get;
    else get = function get1(target1, property1, receiver1) {
        var base = _superPropBaseDefault.default(target1, property1);
        if (!base) return;
        var desc = Object.getOwnPropertyDescriptor(base, property1);
        if (desc.get) return desc.get.call(receiver1 || target1);
        return desc.value;
    };
    return get(target, property, receiver);
}
function _get(target, property, reciever) {
    return get(target, property, reciever);
}
exports.default = _get;

},{"./_super_prop_base":"7Qc8A","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"7Qc8A":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _getPrototypeOf = require("./_get_prototype_of");
var _getPrototypeOfDefault = parcelHelpers.interopDefault(_getPrototypeOf);
function _superPropBase(object, property) {
    while(!Object.prototype.hasOwnProperty.call(object, property)){
        object = _getPrototypeOfDefault.default(object);
        if (object === null) break;
    }
    return object;
}
exports.default = _superPropBase;

},{"./_get_prototype_of":"gYdhY","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"gYdhY":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function getPrototypeOf(o) {
    getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function getPrototypeOf1(o1) {
        return o1.__proto__ || Object.getPrototypeOf(o1);
    };
    return getPrototypeOf(o);
}
function _getPrototypeOf(o) {
    return getPrototypeOf(o);
}
exports.default = _getPrototypeOf;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"iUa9b":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _setPrototypeOf = require("./_set_prototype_of");
var _setPrototypeOfDefault = parcelHelpers.interopDefault(_setPrototypeOf);
function _inherits(subClass, superClass) {
    if (typeof superClass !== "function" && superClass !== null) throw new TypeError("Super expression must either be null or a function");
    subClass.prototype = Object.create(superClass && superClass.prototype, {
        constructor: {
            value: subClass,
            writable: true,
            configurable: true
        }
    });
    if (superClass) _setPrototypeOfDefault.default(subClass, superClass);
}
exports.default = _inherits;

},{"./_set_prototype_of":"3QEan","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"3QEan":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function setPrototypeOf(o, p) {
    setPrototypeOf = Object.setPrototypeOf || function setPrototypeOf1(o1, p1) {
        o1.__proto__ = p1;
        return o1;
    };
    return setPrototypeOf(o, p);
}
function _setPrototypeOf(o, p) {
    return setPrototypeOf(o, p);
}
exports.default = _setPrototypeOf;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"bXGPP":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _inheritsLoose(subClass, superClass) {
    subClass.prototype = Object.create(superClass.prototype);
    subClass.prototype.constructor = subClass;
    subClass.__proto__ = superClass;
}
exports.default = _inheritsLoose;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"blDCs":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _initializerDefineProperty(target, property, descriptor, context) {
    if (!descriptor) return;
    Object.defineProperty(target, property, {
        enumerable: descriptor.enumerable,
        configurable: descriptor.configurable,
        writable: descriptor.writable,
        value: descriptor.initializer ? descriptor.initializer.call(context) : void 0
    });
}
exports.default = _initializerDefineProperty;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"1wFgn":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _initializerWarningHelper(descriptor, context) {
    throw new Error("Decorating class property failed. Please ensure that proposal-class-properties is enabled and set to use loose mode. To use proposal-class-properties in spec mode with decorators, wait for the next major version of decorators in stage 2.");
}
exports.default = _initializerWarningHelper;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"5qkn9":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _instanceof(left, right) {
    if (right != null && typeof Symbol !== "undefined" && right[Symbol.hasInstance]) return right[Symbol.hasInstance](left);
    else return left instanceof right;
}
exports.default = _instanceof;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"9Dkex":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
exports.default = _interopRequireDefault;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"6L2fb":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _interopRequireWildcard(obj) {
    if (obj && obj.__esModule) return obj;
    else {
        var newObj = {
        };
        if (obj != null) {
            for(var key in obj)if (Object.prototype.hasOwnProperty.call(obj, key)) {
                var desc = Object.defineProperty && Object.getOwnPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : {
                };
                if (desc.get || desc.set) Object.defineProperty(newObj, key, desc);
                else newObj[key] = obj[key];
            }
        }
        newObj.default = obj;
        return newObj;
    }
}
exports.default = _interopRequireWildcard;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"1lChi":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _isNativeFunction(fn) {
    return Function.toString.call(fn).indexOf("[native code]") !== -1;
}
exports.default = _isNativeFunction;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"l9ohl":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _iterableToArrayLimit(arr, i) {
    var _arr = [];
    var _n = true;
    var _d = false;
    var _e = undefined;
    try {
        for(var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true){
            _arr.push(_s.value);
            if (i && _arr.length === i) break;
        }
    } catch (err) {
        _d = true;
        _e = err;
    } finally{
        try {
            if (!_n && _i["return"] != null) _i["return"]();
        } finally{
            if (_d) throw _e;
        }
    }
    return _arr;
}
exports.default = _iterableToArrayLimit;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"fJTPN":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _iterableToArrayLimitLoose(arr, i) {
    var _arr = [];
    for(var _iterator = arr[Symbol.iterator](), _step; !(_step = _iterator.next()).done;){
        _arr.push(_step.value);
        if (i && _arr.length === i) break;
    }
    return _arr;
}
exports.default = _iterableToArrayLimitLoose;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"cgH9z":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var REACT_ELEMENT_TYPE;
function _createRawReactElement(type, props, key, children) {
    if (!REACT_ELEMENT_TYPE) REACT_ELEMENT_TYPE = typeof Symbol === "function" && Symbol.for && Symbol.for("react.element") || 60103;
    var defaultProps = type && type.defaultProps;
    var childrenLength = arguments.length - 3;
    if (!props && childrenLength !== 0) props = {
        children: void 0
    };
    if (props && defaultProps) {
        for(var propName in defaultProps)if (props[propName] === void 0) props[propName] = defaultProps[propName];
    } else if (!props) props = defaultProps || {
    };
    if (childrenLength === 1) props.children = children;
    else if (childrenLength > 1) {
        var childArray = new Array(childrenLength);
        for(var i = 0; i < childrenLength; i++)childArray[i] = arguments[i + 3];
        props.children = childArray;
    }
    return {
        $$typeof: REACT_ELEMENT_TYPE,
        type: type,
        key: key === undefined ? null : '' + key,
        ref: null,
        props: props,
        _owner: null
    };
}
exports.default = _createRawReactElement;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"kWAHZ":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _newArrowCheck(innerThis, boundThis) {
    if (innerThis !== boundThis) throw new TypeError("Cannot instantiate an arrow function");
}
exports.default = _newArrowCheck;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"3VWOU":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance");
}
exports.default = _nonIterableSpread;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"6u00B":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _defineProperty = require("./_define_property");
var _definePropertyDefault = parcelHelpers.interopDefault(_defineProperty);
function _objectSpread(target) {
    for(var i = 1; i < arguments.length; i++){
        var source = arguments[i] != null ? arguments[i] : {
        };
        var ownKeys = Object.keys(source);
        if (typeof Object.getOwnPropertySymbols === 'function') ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function(sym) {
            return Object.getOwnPropertyDescriptor(source, sym).enumerable;
        }));
        ownKeys.forEach(function(key) {
            _definePropertyDefault.default(target, key, source[key]);
        });
    }
    return target;
}
exports.default = _objectSpread;

},{"./_define_property":"63lzi","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"9TPKd":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _objectWithoutPropertiesLoose = require("./_object_without_properties_loose");
var _objectWithoutPropertiesLooseDefault = parcelHelpers.interopDefault(_objectWithoutPropertiesLoose);
function _objectWithoutProperties(source, excluded) {
    if (source == null) return {
    };
    var target = _objectWithoutPropertiesLooseDefault.default(source, excluded);
    var key, i;
    if (Object.getOwnPropertySymbols) {
        var sourceSymbolKeys = Object.getOwnPropertySymbols(source);
        for(i = 0; i < sourceSymbolKeys.length; i++){
            key = sourceSymbolKeys[i];
            if (excluded.indexOf(key) >= 0) continue;
            if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
            target[key] = source[key];
        }
    }
    return target;
}
exports.default = _objectWithoutProperties;

},{"./_object_without_properties_loose":"ly94u","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"ly94u":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _objectWithoutPropertiesLoose(source, excluded) {
    if (source == null) return {
    };
    var target = {
    };
    var sourceKeys = Object.keys(source);
    var key, i;
    for(i = 0; i < sourceKeys.length; i++){
        key = sourceKeys[i];
        if (excluded.indexOf(key) >= 0) continue;
        target[key] = source[key];
    }
    return target;
}
exports.default = _objectWithoutPropertiesLoose;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"6EFRu":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _assertThisInitialized = require("./_assert_this_initialized");
var _assertThisInitializedDefault = parcelHelpers.interopDefault(_assertThisInitialized);
var _typeOf = require("./_type_of");
var _typeOfDefault = parcelHelpers.interopDefault(_typeOf);
function _possibleConstructorReturn(self, call) {
    if (call && (_typeOfDefault.default(call) === "object" || typeof call === "function")) return call;
    return _assertThisInitializedDefault.default(self);
}
exports.default = _possibleConstructorReturn;

},{"./_assert_this_initialized":"kUyb2","./_type_of":"3RJph","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"jLs6m":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _readOnlyError(name) {
    throw new Error("\"" + name + "\" is read-only");
}
exports.default = _readOnlyError;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"bHz5n":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _defineProperty = require("./_define_property");
var _definePropertyDefault = parcelHelpers.interopDefault(_defineProperty);
var _superPropBase = require("./_super_prop_base");
var _superPropBaseDefault = parcelHelpers.interopDefault(_superPropBase);
function set(target, property, value, receiver) {
    if (typeof Reflect !== "undefined" && Reflect.set) set = Reflect.set;
    else set = function set1(target1, property1, value1, receiver1) {
        var base = _superPropBaseDefault.default(target1, property1);
        var desc;
        if (base) {
            desc = Object.getOwnPropertyDescriptor(base, property1);
            if (desc.set) {
                desc.set.call(receiver1, value1);
                return true;
            } else if (!desc.writable) return false;
        }
        desc = Object.getOwnPropertyDescriptor(receiver1, property1);
        if (desc) {
            if (!desc.writable) return false;
            desc.value = value1;
            Object.defineProperty(receiver1, property1, desc);
        } else _definePropertyDefault.default(receiver1, property1, value1);
        return true;
    };
    return set(target, property, value, receiver);
}
function _set(target, property, value, receiver, isStrict) {
    var s = set(target, property, value, receiver || target);
    if (!s && isStrict) throw new Error('failed to set property');
    return value;
}
exports.default = _set;

},{"./_define_property":"63lzi","./_super_prop_base":"7Qc8A","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"f4W1z":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _skipFirstGeneratorNext(fn) {
    return function() {
        var it = fn.apply(this, arguments);
        it.next();
        return it;
    };
}
exports.default = _skipFirstGeneratorNext;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"afwXB":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _arrayWithHoles = require("./_array_with_holes");
var _arrayWithHolesDefault = parcelHelpers.interopDefault(_arrayWithHoles);
var _iterableToArray = require("./_iterable_to_array");
var _iterableToArrayDefault = parcelHelpers.interopDefault(_iterableToArray);
var _nonIterableRest = require("./_non_iterable_rest");
var _nonIterableRestDefault = parcelHelpers.interopDefault(_nonIterableRest);
function _slicedToArray(arr, i) {
    return _arrayWithHolesDefault.default(arr) || _iterableToArrayDefault.default(arr, i) || _nonIterableRestDefault.default();
}
exports.default = _slicedToArray;

},{"./_array_with_holes":"4bPjv","./_iterable_to_array":"6TjaF","./_non_iterable_rest":"fW4Zj","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"MXuPk":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _arrayWithHoles = require("./_array_with_holes");
var _arrayWithHolesDefault = parcelHelpers.interopDefault(_arrayWithHoles);
var _iterableToArrayLimitLoose = require("./_iterable_to_array_limit_loose");
var _iterableToArrayLimitLooseDefault = parcelHelpers.interopDefault(_iterableToArrayLimitLoose);
var _nonIterableRest = require("./_non_iterable_rest");
var _nonIterableRestDefault = parcelHelpers.interopDefault(_nonIterableRest);
function _slicedToArrayLoose(arr, i) {
    return _arrayWithHolesDefault.default(arr) || _iterableToArrayLimitLooseDefault.default(arr, i) || _nonIterableRestDefault.default();
}
exports.default = _slicedToArrayLoose;

},{"./_array_with_holes":"4bPjv","./_iterable_to_array_limit_loose":"fJTPN","./_non_iterable_rest":"fW4Zj","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"kaFDN":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _taggedTemplateLiteral(strings, raw) {
    if (!raw) raw = strings.slice(0);
    return Object.freeze(Object.defineProperties(strings, {
        raw: {
            value: Object.freeze(raw)
        }
    }));
}
exports.default = _taggedTemplateLiteral;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"6Q47B":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _taggedTemplateLiteralLoose(strings, raw) {
    if (!raw) raw = strings.slice(0);
    strings.raw = raw;
    return strings;
}
exports.default = _taggedTemplateLiteralLoose;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"bU4YJ":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _throw(e) {
    throw e;
}
exports.default = _throw;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"4HrUM":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _arrayWithoutHoles = require("./_array_without_holes");
var _arrayWithoutHolesDefault = parcelHelpers.interopDefault(_arrayWithoutHoles);
var _iterableToArray = require("./_iterable_to_array");
var _iterableToArrayDefault = parcelHelpers.interopDefault(_iterableToArray);
var _nonIterableSpread = require("./_non_iterable_spread");
var _nonIterableSpreadDefault = parcelHelpers.interopDefault(_nonIterableSpread);
function _toConsumableArray(arr) {
    return _arrayWithoutHolesDefault.default(arr) || _iterableToArrayDefault.default(arr) || _nonIterableSpreadDefault.default();
}
exports.default = _toConsumableArray;

},{"./_array_without_holes":"iondU","./_iterable_to_array":"6TjaF","./_non_iterable_spread":"3VWOU","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"8TRim":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _asyncGenerator = require("./_async_generator");
var _asyncGeneratorDefault = parcelHelpers.interopDefault(_asyncGenerator);
function _wrapAsyncGenerator(fn) {
    return function() {
        return new _asyncGeneratorDefault.default(fn.apply(this, arguments));
    };
}
exports.default = _wrapAsyncGenerator;

},{"./_async_generator":"hendw","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"4RJ2k":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _construct = require("./_construct");
var _constructDefault = parcelHelpers.interopDefault(_construct);
var _isNativeFunction = require("./_is_native_function");
var _isNativeFunctionDefault = parcelHelpers.interopDefault(_isNativeFunction);
var _getPrototypeOf = require("./_get_prototype_of");
var _getPrototypeOfDefault = parcelHelpers.interopDefault(_getPrototypeOf);
var _setPrototypeOf = require("./_set_prototype_of");
var _setPrototypeOfDefault = parcelHelpers.interopDefault(_setPrototypeOf);
function wrapNativeSuper(Class) {
    var _cache = typeof Map === "function" ? new Map() : undefined;
    wrapNativeSuper = function wrapNativeSuper1(Class1) {
        if (Class1 === null || !_isNativeFunctionDefault.default(Class1)) return Class1;
        if (typeof Class1 !== "function") throw new TypeError("Super expression must either be null or a function");
        if (typeof _cache !== "undefined") {
            if (_cache.has(Class1)) return _cache.get(Class1);
            _cache.set(Class1, Wrapper);
        }
        function Wrapper() {
            return _constructDefault.default(Class1, arguments, _getPrototypeOfDefault.default(this).constructor);
        }
        Wrapper.prototype = Object.create(Class1.prototype, {
            constructor: {
                value: Wrapper,
                enumerable: false,
                writable: true,
                configurable: true
            }
        });
        return _setPrototypeOfDefault.default(Wrapper, Class1);
    };
    return wrapNativeSuper(Class);
}
function _wrapNativeSuper(Class) {
    return wrapNativeSuper(Class);
}
exports.default = _wrapNativeSuper;

},{"./_construct":"kITdI","./_is_native_function":"1lChi","./_get_prototype_of":"gYdhY","./_set_prototype_of":"3QEan","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"izluq":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "createFilter", ()=>_selectDbb12E54EsmJs.c
);
parcelHelpers.export(exports, "defaultTheme", ()=>_selectDbb12E54EsmJs.d
);
parcelHelpers.export(exports, "mergeStyles", ()=>_selectDbb12E54EsmJs.m
);
parcelHelpers.export(exports, "components", ()=>_index4Bd03571EsmJs.c
);
parcelHelpers.export(exports, "NonceProvider", ()=>NonceProvider1
);
var _selectDbb12E54EsmJs = require("./Select-dbb12e54.esm.js");
var _stateManager845A3300EsmJs = require("./stateManager-845a3300.esm.js");
var _classCallCheck = require("@babel/runtime/helpers/esm/classCallCheck");
var _classCallCheckDefault = parcelHelpers.interopDefault(_classCallCheck);
var _createClass = require("@babel/runtime/helpers/esm/createClass");
var _createClassDefault = parcelHelpers.interopDefault(_createClass);
var _inherits = require("@babel/runtime/helpers/esm/inherits");
var _inheritsDefault = parcelHelpers.interopDefault(_inherits);
var _index4Bd03571EsmJs = require("./index-4bd03571.esm.js");
var _react = require("react");
var _reactDefault = parcelHelpers.interopDefault(_react);
var _react1 = require("@emotion/react");
var _cache = require("@emotion/cache");
var _cacheDefault = parcelHelpers.interopDefault(_cache);
var _memoizeOne = require("memoize-one");
var _memoizeOneDefault = parcelHelpers.interopDefault(_memoizeOne);
var _extends = require("@babel/runtime/helpers/extends");
var _toConsumableArray = require("@babel/runtime/helpers/toConsumableArray");
var _objectWithoutProperties = require("@babel/runtime/helpers/objectWithoutProperties");
var _taggedTemplateLiteral = require("@babel/runtime/helpers/taggedTemplateLiteral");
var _typeof = require("@babel/runtime/helpers/typeof");
var _reactInputAutosize = require("react-input-autosize");
var _defineProperty = require("@babel/runtime/helpers/defineProperty");
var _reactDom = require("react-dom");
var NonceProvider1 = /*#__PURE__*/ function(_Component) {
    _inheritsDefault.default(NonceProvider2, _Component);
    var _super = _index4Bd03571EsmJs._(NonceProvider2);
    function NonceProvider2(props) {
        var _this;
        _classCallCheckDefault.default(this, NonceProvider2);
        _this = _super.call(this, props);
        _this.createEmotionCache = function(nonce, key) {
            return _cacheDefault.default({
                nonce: nonce,
                key: key
            });
        };
        _this.createEmotionCache = _memoizeOneDefault.default(_this.createEmotionCache);
        return _this;
    }
    _createClassDefault.default(NonceProvider2, [
        {
            key: "render",
            value: function render() {
                var emotionCache = this.createEmotionCache(this.props.nonce, this.props.cacheKey);
                return(/*#__PURE__*/ _reactDefault.default.createElement(_react1.CacheProvider, {
                    value: emotionCache
                }, this.props.children));
            }
        }
    ]);
    return NonceProvider2;
}(_react.Component);
var index = _stateManager845A3300EsmJs.m(_selectDbb12E54EsmJs.S);
exports.default = index;

},{"./Select-dbb12e54.esm.js":"2Nqkb","./stateManager-845a3300.esm.js":"2QbkT","@babel/runtime/helpers/esm/classCallCheck":"kcrhl","@babel/runtime/helpers/esm/createClass":"bETt6","@babel/runtime/helpers/esm/inherits":"1ybWu","./index-4bd03571.esm.js":"hhkYp","react":"bE4sN","@emotion/react":"gigaz","@emotion/cache":"83lJK","memoize-one":"ikgKw","@babel/runtime/helpers/extends":"gs4XN","@babel/runtime/helpers/toConsumableArray":"9RCJT","@babel/runtime/helpers/objectWithoutProperties":"edAJZ","@babel/runtime/helpers/taggedTemplateLiteral":"7t0wp","@babel/runtime/helpers/typeof":"1h3OK","react-input-autosize":"4dKpO","@babel/runtime/helpers/defineProperty":"byUGB","react-dom":"ilX9M","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"2Nqkb":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "S", ()=>Select1
);
parcelHelpers.export(exports, "a", ()=>getOptionLabel
);
parcelHelpers.export(exports, "b", ()=>defaultProps
);
parcelHelpers.export(exports, "c", ()=>createFilter
);
parcelHelpers.export(exports, "d", ()=>defaultTheme
);
parcelHelpers.export(exports, "g", ()=>getOptionValue
);
parcelHelpers.export(exports, "m", ()=>mergeStyles
);
var _extends = require("@babel/runtime/helpers/esm/extends");
var _extendsDefault = parcelHelpers.interopDefault(_extends);
var _index4Bd03571EsmJs = require("./index-4bd03571.esm.js");
var _classCallCheck = require("@babel/runtime/helpers/esm/classCallCheck");
var _classCallCheckDefault = parcelHelpers.interopDefault(_classCallCheck);
var _createClass = require("@babel/runtime/helpers/esm/createClass");
var _createClassDefault = parcelHelpers.interopDefault(_createClass);
var _inherits = require("@babel/runtime/helpers/esm/inherits");
var _inheritsDefault = parcelHelpers.interopDefault(_inherits);
var _toConsumableArray = require("@babel/runtime/helpers/esm/toConsumableArray");
var _toConsumableArrayDefault = parcelHelpers.interopDefault(_toConsumableArray);
var _react = require("react");
var _reactDefault = parcelHelpers.interopDefault(_react);
var _react1 = require("@emotion/react");
var _memoizeOne = require("memoize-one");
var _memoizeOneDefault = parcelHelpers.interopDefault(_memoizeOne);
var _objectWithoutProperties = require("@babel/runtime/helpers/esm/objectWithoutProperties");
var _objectWithoutPropertiesDefault = parcelHelpers.interopDefault(_objectWithoutProperties);
function _EMOTION_STRINGIFIED_CSS_ERROR__() {
    return "You have tried to stringify object returned from `css` function. It isn't supposed to be used directly (e.g. as value of the `className` prop), but rather handed to emotion so it can handle it (e.g. as value of `css` prop).";
}
var _ref = {
    name: "1f43avz-a11yText-A11yText",
    styles: "label:a11yText;z-index:9999;border:0;clip:rect(1px, 1px, 1px, 1px);height:1px;width:1px;position:absolute;overflow:hidden;padding:0;white-space:nowrap;label:A11yText;",
    map: "/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIkExMXlUZXh0LmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQVFJIiwiZmlsZSI6IkExMXlUZXh0LmpzIiwic291cmNlc0NvbnRlbnQiOlsiLy8gQGZsb3dcbi8qKiBAanN4IGpzeCAqL1xuaW1wb3J0IHsgdHlwZSBFbGVtZW50Q29uZmlnIH0gZnJvbSAncmVhY3QnO1xuaW1wb3J0IHsganN4IH0gZnJvbSAnQGVtb3Rpb24vcmVhY3QnO1xuXG4vLyBBc3Npc3RpdmUgdGV4dCB0byBkZXNjcmliZSB2aXN1YWwgZWxlbWVudHMuIEhpZGRlbiBmb3Igc2lnaHRlZCB1c2Vycy5cbmNvbnN0IEExMXlUZXh0ID0gKHByb3BzOiBFbGVtZW50Q29uZmlnPCdzcGFuJz4pID0+IChcbiAgPHNwYW5cbiAgICBjc3M9e3tcbiAgICAgIGxhYmVsOiAnYTExeVRleHQnLFxuICAgICAgekluZGV4OiA5OTk5LFxuICAgICAgYm9yZGVyOiAwLFxuICAgICAgY2xpcDogJ3JlY3QoMXB4LCAxcHgsIDFweCwgMXB4KScsXG4gICAgICBoZWlnaHQ6IDEsXG4gICAgICB3aWR0aDogMSxcbiAgICAgIHBvc2l0aW9uOiAnYWJzb2x1dGUnLFxuICAgICAgb3ZlcmZsb3c6ICdoaWRkZW4nLFxuICAgICAgcGFkZGluZzogMCxcbiAgICAgIHdoaXRlU3BhY2U6ICdub3dyYXAnLFxuICAgIH19XG4gICAgey4uLnByb3BzfVxuICAvPlxuKTtcblxuZXhwb3J0IGRlZmF1bHQgQTExeVRleHQ7XG4iXX0= */",
    toString: _EMOTION_STRINGIFIED_CSS_ERROR__
};
var A11yText = function A11yText1(props) {
    return _react1.jsx("span", _extendsDefault.default({
        css: _ref
    }, props));
};
var defaultAriaLiveMessages = {
    guidance: function guidance(props) {
        var isSearchable = props.isSearchable, isMulti = props.isMulti, isDisabled = props.isDisabled, tabSelectsValue = props.tabSelectsValue, context = props.context;
        switch(context){
            case 'menu':
                return "Use Up and Down to choose options".concat(isDisabled ? '' : ', press Enter to select the currently focused option', ", press Escape to exit the menu").concat(tabSelectsValue ? ', press Tab to select the option and exit the menu' : '', ".");
            case 'input':
                return "".concat(props['aria-label'] || 'Select', " is focused ").concat(isSearchable ? ',type to refine list' : '', ", press Down to open the menu, ").concat(isMulti ? ' press left to focus selected values' : '');
            case 'value':
                return 'Use left and right to toggle between focused values, press Backspace to remove the currently focused value';
            default:
                return '';
        }
    },
    onChange: function onChange(props) {
        var action = props.action, _props$label = props.label, label = _props$label === void 0 ? '' : _props$label, isDisabled = props.isDisabled;
        switch(action){
            case 'deselect-option':
            case 'pop-value':
            case 'remove-value':
                return "option ".concat(label, ", deselected.");
            case 'select-option':
                return isDisabled ? "option ".concat(label, " is disabled. Select another option.") : "option ".concat(label, ", selected.");
            default:
                return '';
        }
    },
    onFocus: function onFocus(props) {
        var context = props.context, _props$focused = props.focused, focused = _props$focused === void 0 ? {
        } : _props$focused, options = props.options, _props$label2 = props.label, label = _props$label2 === void 0 ? '' : _props$label2, selectValue = props.selectValue, isDisabled = props.isDisabled, isSelected = props.isSelected;
        var getArrayIndex = function getArrayIndex1(arr, item) {
            return arr && arr.length ? "".concat(arr.indexOf(item) + 1, " of ").concat(arr.length) : '';
        };
        if (context === 'value' && selectValue) return "value ".concat(label, " focused, ").concat(getArrayIndex(selectValue, focused), ".");
        if (context === 'menu') {
            var disabled = isDisabled ? ' disabled' : '';
            var status = "".concat(isSelected ? 'selected' : 'focused').concat(disabled);
            return "option ".concat(label, " ").concat(status, ", ").concat(getArrayIndex(options, focused), ".");
        }
        return '';
    },
    onFilter: function onFilter(props) {
        var inputValue = props.inputValue, resultsMessage = props.resultsMessage;
        return "".concat(resultsMessage).concat(inputValue ? ' for search term ' + inputValue : '', ".");
    }
};
var LiveRegion = function LiveRegion1(props) {
    var ariaSelection = props.ariaSelection, focusedOption = props.focusedOption, focusedValue = props.focusedValue, focusableOptions = props.focusableOptions, isFocused = props.isFocused, selectValue = props.selectValue, selectProps = props.selectProps;
    var ariaLiveMessages = selectProps.ariaLiveMessages, getOptionLabel = selectProps.getOptionLabel, inputValue = selectProps.inputValue, isMulti = selectProps.isMulti, isOptionDisabled = selectProps.isOptionDisabled, isSearchable = selectProps.isSearchable, menuIsOpen = selectProps.menuIsOpen, options = selectProps.options, screenReaderStatus = selectProps.screenReaderStatus, tabSelectsValue = selectProps.tabSelectsValue;
    var ariaLabel = selectProps['aria-label'];
    var ariaLive = selectProps['aria-live']; // Update aria live message configuration when prop changes
    var messages = _react.useMemo(function() {
        return _index4Bd03571EsmJs.a(_index4Bd03571EsmJs.a({
        }, defaultAriaLiveMessages), ariaLiveMessages || {
        });
    }, [
        ariaLiveMessages
    ]); // Update aria live selected option when prop changes
    var ariaSelected = _react.useMemo(function() {
        var message = '';
        if (ariaSelection && messages.onChange) {
            var option = ariaSelection.option, removedValue = ariaSelection.removedValue, value = ariaSelection.value; // select-option when !isMulti does not return option so we assume selected option is value
            var asOption = function asOption1(val) {
                return !Array.isArray(val) ? val : null;
            };
            var selected = removedValue || option || asOption(value);
            var onChangeProps = _index4Bd03571EsmJs.a({
                isDisabled: selected && isOptionDisabled(selected),
                label: selected ? getOptionLabel(selected) : ''
            }, ariaSelection);
            message = messages.onChange(onChangeProps);
        }
        return message;
    }, [
        ariaSelection,
        isOptionDisabled,
        getOptionLabel,
        messages
    ]);
    var ariaFocused = _react.useMemo(function() {
        var focusMsg = '';
        var focused = focusedOption || focusedValue;
        var isSelected = !!(focusedOption && selectValue && selectValue.includes(focusedOption));
        if (focused && messages.onFocus) {
            var onFocusProps = {
                focused: focused,
                label: getOptionLabel(focused),
                isDisabled: isOptionDisabled(focused),
                isSelected: isSelected,
                options: options,
                context: focused === focusedOption ? 'menu' : 'value',
                selectValue: selectValue
            };
            focusMsg = messages.onFocus(onFocusProps);
        }
        return focusMsg;
    }, [
        focusedOption,
        focusedValue,
        getOptionLabel,
        isOptionDisabled,
        messages,
        options,
        selectValue
    ]);
    var ariaResults = _react.useMemo(function() {
        var resultsMsg = '';
        if (menuIsOpen && options.length && messages.onFilter) {
            var resultsMessage = screenReaderStatus({
                count: focusableOptions.length
            });
            resultsMsg = messages.onFilter({
                inputValue: inputValue,
                resultsMessage: resultsMessage
            });
        }
        return resultsMsg;
    }, [
        focusableOptions,
        inputValue,
        menuIsOpen,
        messages,
        options,
        screenReaderStatus
    ]);
    var ariaGuidance = _react.useMemo(function() {
        var guidanceMsg = '';
        if (messages.guidance) {
            var context = focusedValue ? 'value' : menuIsOpen ? 'menu' : 'input';
            guidanceMsg = messages.guidance({
                'aria-label': ariaLabel,
                context: context,
                isDisabled: focusedOption && isOptionDisabled(focusedOption),
                isMulti: isMulti,
                isSearchable: isSearchable,
                tabSelectsValue: tabSelectsValue
            });
        }
        return guidanceMsg;
    }, [
        ariaLabel,
        focusedOption,
        focusedValue,
        isMulti,
        isOptionDisabled,
        isSearchable,
        menuIsOpen,
        messages,
        tabSelectsValue
    ]);
    var ariaContext = "".concat(ariaFocused, " ").concat(ariaResults, " ").concat(ariaGuidance);
    return _react1.jsx(A11yText, {
        "aria-live": ariaLive,
        "aria-atomic": "false",
        "aria-relevant": "additions text"
    }, isFocused && _react1.jsx(_reactDefault.default.Fragment, null, _react1.jsx("span", {
        id: "aria-selection"
    }, ariaSelected), _react1.jsx("span", {
        id: "aria-context"
    }, ariaContext)));
};
var diacritics = [
    {
        base: 'A',
        letters: "A\u24B6\uFF21\xC0\xC1\xC2\u1EA6\u1EA4\u1EAA\u1EA8\xC3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\xC4\u01DE\u1EA2\xC5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F"
    },
    {
        base: 'AA',
        letters: "\uA732"
    },
    {
        base: 'AE',
        letters: "\xC6\u01FC\u01E2"
    },
    {
        base: 'AO',
        letters: "\uA734"
    },
    {
        base: 'AU',
        letters: "\uA736"
    },
    {
        base: 'AV',
        letters: "\uA738\uA73A"
    },
    {
        base: 'AY',
        letters: "\uA73C"
    },
    {
        base: 'B',
        letters: "B\u24B7\uFF22\u1E02\u1E04\u1E06\u0243\u0182\u0181"
    },
    {
        base: 'C',
        letters: "C\u24B8\uFF23\u0106\u0108\u010A\u010C\xC7\u1E08\u0187\u023B\uA73E"
    },
    {
        base: 'D',
        letters: "D\u24B9\uFF24\u1E0A\u010E\u1E0C\u1E10\u1E12\u1E0E\u0110\u018B\u018A\u0189\uA779"
    },
    {
        base: 'DZ',
        letters: "\u01F1\u01C4"
    },
    {
        base: 'Dz',
        letters: "\u01F2\u01C5"
    },
    {
        base: 'E',
        letters: "E\u24BA\uFF25\xC8\xC9\xCA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\xCB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E"
    },
    {
        base: 'F',
        letters: "F\u24BB\uFF26\u1E1E\u0191\uA77B"
    },
    {
        base: 'G',
        letters: "G\u24BC\uFF27\u01F4\u011C\u1E20\u011E\u0120\u01E6\u0122\u01E4\u0193\uA7A0\uA77D\uA77E"
    },
    {
        base: 'H',
        letters: "H\u24BD\uFF28\u0124\u1E22\u1E26\u021E\u1E24\u1E28\u1E2A\u0126\u2C67\u2C75\uA78D"
    },
    {
        base: 'I',
        letters: "I\u24BE\uFF29\xCC\xCD\xCE\u0128\u012A\u012C\u0130\xCF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197"
    },
    {
        base: 'J',
        letters: "J\u24BF\uFF2A\u0134\u0248"
    },
    {
        base: 'K',
        letters: "K\u24C0\uFF2B\u1E30\u01E8\u1E32\u0136\u1E34\u0198\u2C69\uA740\uA742\uA744\uA7A2"
    },
    {
        base: 'L',
        letters: "L\u24C1\uFF2C\u013F\u0139\u013D\u1E36\u1E38\u013B\u1E3C\u1E3A\u0141\u023D\u2C62\u2C60\uA748\uA746\uA780"
    },
    {
        base: 'LJ',
        letters: "\u01C7"
    },
    {
        base: 'Lj',
        letters: "\u01C8"
    },
    {
        base: 'M',
        letters: "M\u24C2\uFF2D\u1E3E\u1E40\u1E42\u2C6E\u019C"
    },
    {
        base: 'N',
        letters: "N\u24C3\uFF2E\u01F8\u0143\xD1\u1E44\u0147\u1E46\u0145\u1E4A\u1E48\u0220\u019D\uA790\uA7A4"
    },
    {
        base: 'NJ',
        letters: "\u01CA"
    },
    {
        base: 'Nj',
        letters: "\u01CB"
    },
    {
        base: 'O',
        letters: "O\u24C4\uFF2F\xD2\xD3\xD4\u1ED2\u1ED0\u1ED6\u1ED4\xD5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\xD6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\xD8\u01FE\u0186\u019F\uA74A\uA74C"
    },
    {
        base: 'OI',
        letters: "\u01A2"
    },
    {
        base: 'OO',
        letters: "\uA74E"
    },
    {
        base: 'OU',
        letters: "\u0222"
    },
    {
        base: 'P',
        letters: "P\u24C5\uFF30\u1E54\u1E56\u01A4\u2C63\uA750\uA752\uA754"
    },
    {
        base: 'Q',
        letters: "Q\u24C6\uFF31\uA756\uA758\u024A"
    },
    {
        base: 'R',
        letters: "R\u24C7\uFF32\u0154\u1E58\u0158\u0210\u0212\u1E5A\u1E5C\u0156\u1E5E\u024C\u2C64\uA75A\uA7A6\uA782"
    },
    {
        base: 'S',
        letters: "S\u24C8\uFF33\u1E9E\u015A\u1E64\u015C\u1E60\u0160\u1E66\u1E62\u1E68\u0218\u015E\u2C7E\uA7A8\uA784"
    },
    {
        base: 'T',
        letters: "T\u24C9\uFF34\u1E6A\u0164\u1E6C\u021A\u0162\u1E70\u1E6E\u0166\u01AC\u01AE\u023E\uA786"
    },
    {
        base: 'TZ',
        letters: "\uA728"
    },
    {
        base: 'U',
        letters: "U\u24CA\uFF35\xD9\xDA\xDB\u0168\u1E78\u016A\u1E7A\u016C\xDC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244"
    },
    {
        base: 'V',
        letters: "V\u24CB\uFF36\u1E7C\u1E7E\u01B2\uA75E\u0245"
    },
    {
        base: 'VY',
        letters: "\uA760"
    },
    {
        base: 'W',
        letters: "W\u24CC\uFF37\u1E80\u1E82\u0174\u1E86\u1E84\u1E88\u2C72"
    },
    {
        base: 'X',
        letters: "X\u24CD\uFF38\u1E8A\u1E8C"
    },
    {
        base: 'Y',
        letters: "Y\u24CE\uFF39\u1EF2\xDD\u0176\u1EF8\u0232\u1E8E\u0178\u1EF6\u1EF4\u01B3\u024E\u1EFE"
    },
    {
        base: 'Z',
        letters: "Z\u24CF\uFF3A\u0179\u1E90\u017B\u017D\u1E92\u1E94\u01B5\u0224\u2C7F\u2C6B\uA762"
    },
    {
        base: 'a',
        letters: "a\u24D0\uFF41\u1E9A\xE0\xE1\xE2\u1EA7\u1EA5\u1EAB\u1EA9\xE3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\xE4\u01DF\u1EA3\xE5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250"
    },
    {
        base: 'aa',
        letters: "\uA733"
    },
    {
        base: 'ae',
        letters: "\xE6\u01FD\u01E3"
    },
    {
        base: 'ao',
        letters: "\uA735"
    },
    {
        base: 'au',
        letters: "\uA737"
    },
    {
        base: 'av',
        letters: "\uA739\uA73B"
    },
    {
        base: 'ay',
        letters: "\uA73D"
    },
    {
        base: 'b',
        letters: "b\u24D1\uFF42\u1E03\u1E05\u1E07\u0180\u0183\u0253"
    },
    {
        base: 'c',
        letters: "c\u24D2\uFF43\u0107\u0109\u010B\u010D\xE7\u1E09\u0188\u023C\uA73F\u2184"
    },
    {
        base: 'd',
        letters: "d\u24D3\uFF44\u1E0B\u010F\u1E0D\u1E11\u1E13\u1E0F\u0111\u018C\u0256\u0257\uA77A"
    },
    {
        base: 'dz',
        letters: "\u01F3\u01C6"
    },
    {
        base: 'e',
        letters: "e\u24D4\uFF45\xE8\xE9\xEA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\xEB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD"
    },
    {
        base: 'f',
        letters: "f\u24D5\uFF46\u1E1F\u0192\uA77C"
    },
    {
        base: 'g',
        letters: "g\u24D6\uFF47\u01F5\u011D\u1E21\u011F\u0121\u01E7\u0123\u01E5\u0260\uA7A1\u1D79\uA77F"
    },
    {
        base: 'h',
        letters: "h\u24D7\uFF48\u0125\u1E23\u1E27\u021F\u1E25\u1E29\u1E2B\u1E96\u0127\u2C68\u2C76\u0265"
    },
    {
        base: 'hv',
        letters: "\u0195"
    },
    {
        base: 'i',
        letters: "i\u24D8\uFF49\xEC\xED\xEE\u0129\u012B\u012D\xEF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131"
    },
    {
        base: 'j',
        letters: "j\u24D9\uFF4A\u0135\u01F0\u0249"
    },
    {
        base: 'k',
        letters: "k\u24DA\uFF4B\u1E31\u01E9\u1E33\u0137\u1E35\u0199\u2C6A\uA741\uA743\uA745\uA7A3"
    },
    {
        base: 'l',
        letters: "l\u24DB\uFF4C\u0140\u013A\u013E\u1E37\u1E39\u013C\u1E3D\u1E3B\u017F\u0142\u019A\u026B\u2C61\uA749\uA781\uA747"
    },
    {
        base: 'lj',
        letters: "\u01C9"
    },
    {
        base: 'm',
        letters: "m\u24DC\uFF4D\u1E3F\u1E41\u1E43\u0271\u026F"
    },
    {
        base: 'n',
        letters: "n\u24DD\uFF4E\u01F9\u0144\xF1\u1E45\u0148\u1E47\u0146\u1E4B\u1E49\u019E\u0272\u0149\uA791\uA7A5"
    },
    {
        base: 'nj',
        letters: "\u01CC"
    },
    {
        base: 'o',
        letters: "o\u24DE\uFF4F\xF2\xF3\xF4\u1ED3\u1ED1\u1ED7\u1ED5\xF5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\xF6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\xF8\u01FF\u0254\uA74B\uA74D\u0275"
    },
    {
        base: 'oi',
        letters: "\u01A3"
    },
    {
        base: 'ou',
        letters: "\u0223"
    },
    {
        base: 'oo',
        letters: "\uA74F"
    },
    {
        base: 'p',
        letters: "p\u24DF\uFF50\u1E55\u1E57\u01A5\u1D7D\uA751\uA753\uA755"
    },
    {
        base: 'q',
        letters: "q\u24E0\uFF51\u024B\uA757\uA759"
    },
    {
        base: 'r',
        letters: "r\u24E1\uFF52\u0155\u1E59\u0159\u0211\u0213\u1E5B\u1E5D\u0157\u1E5F\u024D\u027D\uA75B\uA7A7\uA783"
    },
    {
        base: 's',
        letters: "s\u24E2\uFF53\xDF\u015B\u1E65\u015D\u1E61\u0161\u1E67\u1E63\u1E69\u0219\u015F\u023F\uA7A9\uA785\u1E9B"
    },
    {
        base: 't',
        letters: "t\u24E3\uFF54\u1E6B\u1E97\u0165\u1E6D\u021B\u0163\u1E71\u1E6F\u0167\u01AD\u0288\u2C66\uA787"
    },
    {
        base: 'tz',
        letters: "\uA729"
    },
    {
        base: 'u',
        letters: "u\u24E4\uFF55\xF9\xFA\xFB\u0169\u1E79\u016B\u1E7B\u016D\xFC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289"
    },
    {
        base: 'v',
        letters: "v\u24E5\uFF56\u1E7D\u1E7F\u028B\uA75F\u028C"
    },
    {
        base: 'vy',
        letters: "\uA761"
    },
    {
        base: 'w',
        letters: "w\u24E6\uFF57\u1E81\u1E83\u0175\u1E87\u1E85\u1E98\u1E89\u2C73"
    },
    {
        base: 'x',
        letters: "x\u24E7\uFF58\u1E8B\u1E8D"
    },
    {
        base: 'y',
        letters: "y\u24E8\uFF59\u1EF3\xFD\u0177\u1EF9\u0233\u1E8F\xFF\u1EF7\u1E99\u1EF5\u01B4\u024F\u1EFF"
    },
    {
        base: 'z',
        letters: "z\u24E9\uFF5A\u017A\u1E91\u017C\u017E\u1E93\u1E95\u01B6\u0225\u0240\u2C6C\uA763"
    }
];
var anyDiacritic = new RegExp('[' + diacritics.map(function(d) {
    return d.letters;
}).join('') + ']', 'g');
var diacriticToBase = {
};
for(var i = 0; i < diacritics.length; i++){
    var diacritic = diacritics[i];
    for(var j = 0; j < diacritic.letters.length; j++)diacriticToBase[diacritic.letters[j]] = diacritic.base;
}
var stripDiacritics = function stripDiacritics1(str) {
    return str.replace(anyDiacritic, function(match) {
        return diacriticToBase[match];
    });
};
var memoizedStripDiacriticsForInput = _memoizeOneDefault.default(stripDiacritics);
var trimString = function trimString1(str) {
    return str.replace(/^\s+|\s+$/g, '');
};
var defaultStringify = function defaultStringify1(option) {
    return "".concat(option.label, " ").concat(option.value);
};
var createFilter = function createFilter1(config) {
    return function(option, rawInput) {
        var _ignoreCase$ignoreAcc = _index4Bd03571EsmJs.a({
            ignoreCase: true,
            ignoreAccents: true,
            stringify: defaultStringify,
            trim: true,
            matchFrom: 'any'
        }, config), ignoreCase = _ignoreCase$ignoreAcc.ignoreCase, ignoreAccents = _ignoreCase$ignoreAcc.ignoreAccents, stringify = _ignoreCase$ignoreAcc.stringify, trim = _ignoreCase$ignoreAcc.trim, matchFrom = _ignoreCase$ignoreAcc.matchFrom;
        var input = trim ? trimString(rawInput) : rawInput;
        var candidate = trim ? trimString(stringify(option)) : stringify(option);
        if (ignoreCase) {
            input = input.toLowerCase();
            candidate = candidate.toLowerCase();
        }
        if (ignoreAccents) {
            input = memoizedStripDiacriticsForInput(input);
            candidate = stripDiacritics(candidate);
        }
        return matchFrom === 'start' ? candidate.substr(0, input.length) === input : candidate.indexOf(input) > -1;
    };
};
function DummyInput(_ref1) {
    _ref1.in;
    _ref1.out;
    _ref1.onExited;
    _ref1.appear;
    _ref1.enter;
    _ref1.exit;
    var innerRef = _ref1.innerRef;
    _ref1.emotion;
    var props = _objectWithoutPropertiesDefault.default(_ref1, [
        "in",
        "out",
        "onExited",
        "appear",
        "enter",
        "exit",
        "innerRef",
        "emotion"
    ]);
    return _react1.jsx("input", _extendsDefault.default({
        ref: innerRef
    }, props, {
        css: /*#__PURE__*/ _react1.css({
            label: 'dummyInput',
            // get rid of any default styles
            background: 0,
            border: 0,
            fontSize: 'inherit',
            outline: 0,
            padding: 0,
            // important! without `width` browsers won't allow focus
            width: 1,
            // remove cursor on desktop
            color: 'transparent',
            // remove cursor on mobile whilst maintaining "scroll into view" behaviour
            left: -100,
            opacity: 0,
            position: 'relative',
            transform: 'scale(0)'
        }, ";label:DummyInput;", "/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIkR1bW15SW5wdXQuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBbUJNIiwiZmlsZSI6IkR1bW15SW5wdXQuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBAZmxvd1xuLyoqIEBqc3gganN4ICovXG5pbXBvcnQgeyBqc3ggfSBmcm9tICdAZW1vdGlvbi9yZWFjdCc7XG5cbmV4cG9ydCBkZWZhdWx0IGZ1bmN0aW9uIER1bW15SW5wdXQoe1xuICBpbjogaW5Qcm9wLFxuICBvdXQsXG4gIG9uRXhpdGVkLFxuICBhcHBlYXIsXG4gIGVudGVyLFxuICBleGl0LFxuICBpbm5lclJlZixcbiAgZW1vdGlvbixcbiAgLi4ucHJvcHNcbn06IGFueSkge1xuICByZXR1cm4gKFxuICAgIDxpbnB1dFxuICAgICAgcmVmPXtpbm5lclJlZn1cbiAgICAgIHsuLi5wcm9wc31cbiAgICAgIGNzcz17e1xuICAgICAgICBsYWJlbDogJ2R1bW15SW5wdXQnLFxuICAgICAgICAvLyBnZXQgcmlkIG9mIGFueSBkZWZhdWx0IHN0eWxlc1xuICAgICAgICBiYWNrZ3JvdW5kOiAwLFxuICAgICAgICBib3JkZXI6IDAsXG4gICAgICAgIGZvbnRTaXplOiAnaW5oZXJpdCcsXG4gICAgICAgIG91dGxpbmU6IDAsXG4gICAgICAgIHBhZGRpbmc6IDAsXG4gICAgICAgIC8vIGltcG9ydGFudCEgd2l0aG91dCBgd2lkdGhgIGJyb3dzZXJzIHdvbid0IGFsbG93IGZvY3VzXG4gICAgICAgIHdpZHRoOiAxLFxuXG4gICAgICAgIC8vIHJlbW92ZSBjdXJzb3Igb24gZGVza3RvcFxuICAgICAgICBjb2xvcjogJ3RyYW5zcGFyZW50JyxcblxuICAgICAgICAvLyByZW1vdmUgY3Vyc29yIG9uIG1vYmlsZSB3aGlsc3QgbWFpbnRhaW5pbmcgXCJzY3JvbGwgaW50byB2aWV3XCIgYmVoYXZpb3VyXG4gICAgICAgIGxlZnQ6IC0xMDAsXG4gICAgICAgIG9wYWNpdHk6IDAsXG4gICAgICAgIHBvc2l0aW9uOiAncmVsYXRpdmUnLFxuICAgICAgICB0cmFuc2Zvcm06ICdzY2FsZSgwKScsXG4gICAgICB9fVxuICAgIC8+XG4gICk7XG59XG4iXX0= */")
    }));
}
var cancelScroll = function cancelScroll1(event) {
    event.preventDefault();
    event.stopPropagation();
};
function useScrollCapture(_ref1) {
    var isEnabled = _ref1.isEnabled, onBottomArrive = _ref1.onBottomArrive, onBottomLeave = _ref1.onBottomLeave, onTopArrive = _ref1.onTopArrive, onTopLeave = _ref1.onTopLeave;
    var isBottom = _react.useRef(false);
    var isTop = _react.useRef(false);
    var touchStart = _react.useRef(0);
    var scrollTarget = _react.useRef(null);
    var handleEventDelta = _react.useCallback(function(event, delta) {
        // Reference should never be `null` at this point, but flow complains otherwise
        if (scrollTarget.current === null) return;
        var _scrollTarget$current = scrollTarget.current, scrollTop = _scrollTarget$current.scrollTop, scrollHeight = _scrollTarget$current.scrollHeight, clientHeight = _scrollTarget$current.clientHeight;
        var target = scrollTarget.current;
        var isDeltaPositive = delta > 0;
        var availableScroll = scrollHeight - clientHeight - scrollTop;
        var shouldCancelScroll = false; // reset bottom/top flags
        if (availableScroll > delta && isBottom.current) {
            if (onBottomLeave) onBottomLeave(event);
            isBottom.current = false;
        }
        if (isDeltaPositive && isTop.current) {
            if (onTopLeave) onTopLeave(event);
            isTop.current = false;
        } // bottom limit
        if (isDeltaPositive && delta > availableScroll) {
            if (onBottomArrive && !isBottom.current) onBottomArrive(event);
            target.scrollTop = scrollHeight;
            shouldCancelScroll = true;
            isBottom.current = true; // top limit
        } else if (!isDeltaPositive && -delta > scrollTop) {
            if (onTopArrive && !isTop.current) onTopArrive(event);
            target.scrollTop = 0;
            shouldCancelScroll = true;
            isTop.current = true;
        } // cancel scroll
        if (shouldCancelScroll) cancelScroll(event);
    }, []);
    var onWheel = _react.useCallback(function(event) {
        handleEventDelta(event, event.deltaY);
    }, [
        handleEventDelta
    ]);
    var onTouchStart = _react.useCallback(function(event) {
        // set touch start so we can calculate touchmove delta
        touchStart.current = event.changedTouches[0].clientY;
    }, []);
    var onTouchMove = _react.useCallback(function(event) {
        var deltaY = touchStart.current - event.changedTouches[0].clientY;
        handleEventDelta(event, deltaY);
    }, [
        handleEventDelta
    ]);
    var startListening = _react.useCallback(function(el) {
        // bail early if no element is available to attach to
        if (!el) return;
        var notPassive = _index4Bd03571EsmJs.s ? {
            passive: false
        } : false; // all the if statements are to appease Flow 😢
        if (typeof el.addEventListener === 'function') el.addEventListener('wheel', onWheel, notPassive);
        if (typeof el.addEventListener === 'function') el.addEventListener('touchstart', onTouchStart, notPassive);
        if (typeof el.addEventListener === 'function') el.addEventListener('touchmove', onTouchMove, notPassive);
    }, [
        onTouchMove,
        onTouchStart,
        onWheel
    ]);
    var stopListening = _react.useCallback(function(el) {
        // bail early if no element is available to detach from
        if (!el) return; // all the if statements are to appease Flow 😢
        if (typeof el.removeEventListener === 'function') el.removeEventListener('wheel', onWheel, false);
        if (typeof el.removeEventListener === 'function') el.removeEventListener('touchstart', onTouchStart, false);
        if (typeof el.removeEventListener === 'function') el.removeEventListener('touchmove', onTouchMove, false);
    }, [
        onTouchMove,
        onTouchStart,
        onWheel
    ]);
    _react.useEffect(function() {
        if (!isEnabled) return;
        var element = scrollTarget.current;
        startListening(element);
        return function() {
            stopListening(element);
        };
    }, [
        isEnabled,
        startListening,
        stopListening
    ]);
    return function(element) {
        scrollTarget.current = element;
    };
}
var STYLE_KEYS = [
    'boxSizing',
    'height',
    'overflow',
    'paddingRight',
    'position'
];
var LOCK_STYLES = {
    boxSizing: 'border-box',
    // account for possible declaration `width: 100%;` on body
    overflow: 'hidden',
    position: 'relative',
    height: '100%'
};
function preventTouchMove(e) {
    e.preventDefault();
}
function allowTouchMove(e) {
    e.stopPropagation();
}
function preventInertiaScroll() {
    var top = this.scrollTop;
    var totalScroll = this.scrollHeight;
    var currentScroll = top + this.offsetHeight;
    if (top === 0) this.scrollTop = 1;
    else if (currentScroll === totalScroll) this.scrollTop = top - 1;
} // `ontouchstart` check works on most browsers
// `maxTouchPoints` works on IE10/11 and Surface
function isTouchDevice() {
    return 'ontouchstart' in window || navigator.maxTouchPoints;
}
var canUseDOM = !!(typeof window !== 'undefined' && window.document && window.document.createElement);
var activeScrollLocks = 0;
var listenerOptions = {
    capture: false,
    passive: false
};
function useScrollLock(_ref1) {
    var isEnabled = _ref1.isEnabled, _ref$accountForScroll = _ref1.accountForScrollbars, accountForScrollbars = _ref$accountForScroll === void 0 ? true : _ref$accountForScroll;
    var originalStyles = _react.useRef({
    });
    var scrollTarget = _react.useRef(null);
    var addScrollLock = _react.useCallback(function(touchScrollTarget) {
        if (!canUseDOM) return;
        var target = document.body;
        var targetStyle = target && target.style;
        if (accountForScrollbars) // store any styles already applied to the body
        STYLE_KEYS.forEach(function(key) {
            var val = targetStyle && targetStyle[key];
            originalStyles.current[key] = val;
        });
         // apply the lock styles and padding if this is the first scroll lock
        if (accountForScrollbars && activeScrollLocks < 1) {
            var currentPadding = parseInt(originalStyles.current.paddingRight, 10) || 0;
            var clientWidth = document.body ? document.body.clientWidth : 0;
            var adjustedPadding = window.innerWidth - clientWidth + currentPadding || 0;
            Object.keys(LOCK_STYLES).forEach(function(key) {
                var val = LOCK_STYLES[key];
                if (targetStyle) targetStyle[key] = val;
            });
            if (targetStyle) targetStyle.paddingRight = "".concat(adjustedPadding, "px");
        } // account for touch devices
        if (target && isTouchDevice()) {
            // Mobile Safari ignores { overflow: hidden } declaration on the body.
            target.addEventListener('touchmove', preventTouchMove, listenerOptions); // Allow scroll on provided target
            if (touchScrollTarget) {
                touchScrollTarget.addEventListener('touchstart', preventInertiaScroll, listenerOptions);
                touchScrollTarget.addEventListener('touchmove', allowTouchMove, listenerOptions);
            }
        } // increment active scroll locks
        activeScrollLocks += 1;
    }, []);
    var removeScrollLock = _react.useCallback(function(touchScrollTarget) {
        if (!canUseDOM) return;
        var target = document.body;
        var targetStyle = target && target.style; // safely decrement active scroll locks
        activeScrollLocks = Math.max(activeScrollLocks - 1, 0); // reapply original body styles, if any
        if (accountForScrollbars && activeScrollLocks < 1) STYLE_KEYS.forEach(function(key) {
            var val = originalStyles.current[key];
            if (targetStyle) targetStyle[key] = val;
        });
         // remove touch listeners
        if (target && isTouchDevice()) {
            target.removeEventListener('touchmove', preventTouchMove, listenerOptions);
            if (touchScrollTarget) {
                touchScrollTarget.removeEventListener('touchstart', preventInertiaScroll, listenerOptions);
                touchScrollTarget.removeEventListener('touchmove', allowTouchMove, listenerOptions);
            }
        }
    }, []);
    _react.useEffect(function() {
        if (!isEnabled) return;
        var element = scrollTarget.current;
        addScrollLock(element);
        return function() {
            removeScrollLock(element);
        };
    }, [
        isEnabled,
        addScrollLock,
        removeScrollLock
    ]);
    return function(element) {
        scrollTarget.current = element;
    };
}
function _EMOTION_STRINGIFIED_CSS_ERROR__$1() {
    return "You have tried to stringify object returned from `css` function. It isn't supposed to be used directly (e.g. as value of the `className` prop), but rather handed to emotion so it can handle it (e.g. as value of `css` prop).";
}
var blurSelectInput = function blurSelectInput1() {
    return document.activeElement && document.activeElement.blur();
};
var _ref2 = {
    name: "bp8cua-ScrollManager",
    styles: "position:fixed;left:0;bottom:0;right:0;top:0;label:ScrollManager;",
    map: "/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIlNjcm9sbE1hbmFnZXIuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBa0RVIiwiZmlsZSI6IlNjcm9sbE1hbmFnZXIuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBAZmxvd1xuLyoqIEBqc3gganN4ICovXG5pbXBvcnQgeyBqc3ggfSBmcm9tICdAZW1vdGlvbi9yZWFjdCc7XG5pbXBvcnQgUmVhY3QsIHsgdHlwZSBFbGVtZW50IH0gZnJvbSAncmVhY3QnO1xuaW1wb3J0IHVzZVNjcm9sbENhcHR1cmUgZnJvbSAnLi91c2VTY3JvbGxDYXB0dXJlJztcbmltcG9ydCB1c2VTY3JvbGxMb2NrIGZyb20gJy4vdXNlU2Nyb2xsTG9jayc7XG5cbnR5cGUgUmVmQ2FsbGJhY2s8VD4gPSAoVCB8IG51bGwpID0+IHZvaWQ7XG5cbnR5cGUgUHJvcHMgPSB7XG4gIGNoaWxkcmVuOiAoUmVmQ2FsbGJhY2s8SFRNTEVsZW1lbnQ+KSA9PiBFbGVtZW50PCo+LFxuICBsb2NrRW5hYmxlZDogYm9vbGVhbixcbiAgY2FwdHVyZUVuYWJsZWQ6IGJvb2xlYW4sXG4gIG9uQm90dG9tQXJyaXZlPzogKGV2ZW50OiBTeW50aGV0aWNFdmVudDxIVE1MRWxlbWVudD4pID0+IHZvaWQsXG4gIG9uQm90dG9tTGVhdmU/OiAoZXZlbnQ6IFN5bnRoZXRpY0V2ZW50PEhUTUxFbGVtZW50PikgPT4gdm9pZCxcbiAgb25Ub3BBcnJpdmU/OiAoZXZlbnQ6IFN5bnRoZXRpY0V2ZW50PEhUTUxFbGVtZW50PikgPT4gdm9pZCxcbiAgb25Ub3BMZWF2ZT86IChldmVudDogU3ludGhldGljRXZlbnQ8SFRNTEVsZW1lbnQ+KSA9PiB2b2lkLFxufTtcblxuY29uc3QgYmx1clNlbGVjdElucHV0ID0gKCkgPT5cbiAgZG9jdW1lbnQuYWN0aXZlRWxlbWVudCAmJiBkb2N1bWVudC5hY3RpdmVFbGVtZW50LmJsdXIoKTtcblxuZXhwb3J0IGRlZmF1bHQgZnVuY3Rpb24gU2Nyb2xsTWFuYWdlcih7XG4gIGNoaWxkcmVuLFxuICBsb2NrRW5hYmxlZCxcbiAgY2FwdHVyZUVuYWJsZWQgPSB0cnVlLFxuICBvbkJvdHRvbUFycml2ZSxcbiAgb25Cb3R0b21MZWF2ZSxcbiAgb25Ub3BBcnJpdmUsXG4gIG9uVG9wTGVhdmUsXG59OiBQcm9wcykge1xuICBjb25zdCBzZXRTY3JvbGxDYXB0dXJlVGFyZ2V0ID0gdXNlU2Nyb2xsQ2FwdHVyZSh7XG4gICAgaXNFbmFibGVkOiBjYXB0dXJlRW5hYmxlZCxcbiAgICBvbkJvdHRvbUFycml2ZSxcbiAgICBvbkJvdHRvbUxlYXZlLFxuICAgIG9uVG9wQXJyaXZlLFxuICAgIG9uVG9wTGVhdmUsXG4gIH0pO1xuICBjb25zdCBzZXRTY3JvbGxMb2NrVGFyZ2V0ID0gdXNlU2Nyb2xsTG9jayh7IGlzRW5hYmxlZDogbG9ja0VuYWJsZWQgfSk7XG5cbiAgY29uc3QgdGFyZ2V0UmVmID0gZWxlbWVudCA9PiB7XG4gICAgc2V0U2Nyb2xsQ2FwdHVyZVRhcmdldChlbGVtZW50KTtcbiAgICBzZXRTY3JvbGxMb2NrVGFyZ2V0KGVsZW1lbnQpO1xuICB9O1xuXG4gIHJldHVybiAoXG4gICAgPFJlYWN0LkZyYWdtZW50PlxuICAgICAge2xvY2tFbmFibGVkICYmIChcbiAgICAgICAgPGRpdlxuICAgICAgICAgIG9uQ2xpY2s9e2JsdXJTZWxlY3RJbnB1dH1cbiAgICAgICAgICBjc3M9e3sgcG9zaXRpb246ICdmaXhlZCcsIGxlZnQ6IDAsIGJvdHRvbTogMCwgcmlnaHQ6IDAsIHRvcDogMCB9fVxuICAgICAgICAvPlxuICAgICAgKX1cbiAgICAgIHtjaGlsZHJlbih0YXJnZXRSZWYpfVxuICAgIDwvUmVhY3QuRnJhZ21lbnQ+XG4gICk7XG59XG4iXX0= */",
    toString: _EMOTION_STRINGIFIED_CSS_ERROR__$1
};
function ScrollManager(_ref1) {
    var children = _ref1.children, lockEnabled = _ref1.lockEnabled, _ref$captureEnabled = _ref1.captureEnabled, captureEnabled = _ref$captureEnabled === void 0 ? true : _ref$captureEnabled, onBottomArrive = _ref1.onBottomArrive, onBottomLeave = _ref1.onBottomLeave, onTopArrive = _ref1.onTopArrive, onTopLeave = _ref1.onTopLeave;
    var setScrollCaptureTarget = useScrollCapture({
        isEnabled: captureEnabled,
        onBottomArrive: onBottomArrive,
        onBottomLeave: onBottomLeave,
        onTopArrive: onTopArrive,
        onTopLeave: onTopLeave
    });
    var setScrollLockTarget = useScrollLock({
        isEnabled: lockEnabled
    });
    var targetRef = function targetRef1(element) {
        setScrollCaptureTarget(element);
        setScrollLockTarget(element);
    };
    return _react1.jsx(_reactDefault.default.Fragment, null, lockEnabled && _react1.jsx("div", {
        onClick: blurSelectInput,
        css: _ref2
    }), children(targetRef));
}
var formatGroupLabel = function formatGroupLabel1(group) {
    return group.label;
};
var getOptionLabel = function getOptionLabel1(option) {
    return option.label;
};
var getOptionValue = function getOptionValue1(option) {
    return option.value;
};
var isOptionDisabled = function isOptionDisabled1(option) {
    return !!option.isDisabled;
};
var defaultStyles = {
    clearIndicator: _index4Bd03571EsmJs.b,
    container: _index4Bd03571EsmJs.d,
    control: _index4Bd03571EsmJs.e,
    dropdownIndicator: _index4Bd03571EsmJs.f,
    group: _index4Bd03571EsmJs.g,
    groupHeading: _index4Bd03571EsmJs.h,
    indicatorsContainer: _index4Bd03571EsmJs.i,
    indicatorSeparator: _index4Bd03571EsmJs.j,
    input: _index4Bd03571EsmJs.k,
    loadingIndicator: _index4Bd03571EsmJs.l,
    loadingMessage: _index4Bd03571EsmJs.m,
    menu: _index4Bd03571EsmJs.n,
    menuList: _index4Bd03571EsmJs.o,
    menuPortal: _index4Bd03571EsmJs.p,
    multiValue: _index4Bd03571EsmJs.q,
    multiValueLabel: _index4Bd03571EsmJs.r,
    multiValueRemove: _index4Bd03571EsmJs.t,
    noOptionsMessage: _index4Bd03571EsmJs.u,
    option: _index4Bd03571EsmJs.v,
    placeholder: _index4Bd03571EsmJs.w,
    singleValue: _index4Bd03571EsmJs.x,
    valueContainer: _index4Bd03571EsmJs.y
}; // Merge Utility
// Allows consumers to extend a base Select with additional styles
function mergeStyles(source) {
    var target = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {
    };
    // initialize with source styles
    var styles = _index4Bd03571EsmJs.a({
    }, source); // massage in target styles
    Object.keys(target).forEach(function(key) {
        if (source[key]) styles[key] = function(rsCss, props) {
            return target[key](source[key](rsCss, props), props);
        };
        else styles[key] = target[key];
    });
    return styles;
}
var colors = {
    primary: '#2684FF',
    primary75: '#4C9AFF',
    primary50: '#B2D4FF',
    primary25: '#DEEBFF',
    danger: '#DE350B',
    dangerLight: '#FFBDAD',
    neutral0: 'hsl(0, 0%, 100%)',
    neutral5: 'hsl(0, 0%, 95%)',
    neutral10: 'hsl(0, 0%, 90%)',
    neutral20: 'hsl(0, 0%, 80%)',
    neutral30: 'hsl(0, 0%, 70%)',
    neutral40: 'hsl(0, 0%, 60%)',
    neutral50: 'hsl(0, 0%, 50%)',
    neutral60: 'hsl(0, 0%, 40%)',
    neutral70: 'hsl(0, 0%, 30%)',
    neutral80: 'hsl(0, 0%, 20%)',
    neutral90: 'hsl(0, 0%, 10%)'
};
var borderRadius = 4; // Used to calculate consistent margin/padding on elements
var baseUnit = 4; // The minimum height of the control
var controlHeight = 38; // The amount of space between the control and menu */
var menuGutter = baseUnit * 2;
var spacing = {
    baseUnit: baseUnit,
    controlHeight: controlHeight,
    menuGutter: menuGutter
};
var defaultTheme = {
    borderRadius: borderRadius,
    colors: colors,
    spacing: spacing
};
var defaultProps = {
    'aria-live': 'polite',
    backspaceRemovesValue: true,
    blurInputOnSelect: _index4Bd03571EsmJs.z(),
    captureMenuScroll: !_index4Bd03571EsmJs.z(),
    closeMenuOnSelect: true,
    closeMenuOnScroll: false,
    components: {
    },
    controlShouldRenderValue: true,
    escapeClearsValue: false,
    filterOption: createFilter(),
    formatGroupLabel: formatGroupLabel,
    getOptionLabel: getOptionLabel,
    getOptionValue: getOptionValue,
    isDisabled: false,
    isLoading: false,
    isMulti: false,
    isRtl: false,
    isSearchable: true,
    isOptionDisabled: isOptionDisabled,
    loadingMessage: function loadingMessage() {
        return 'Loading...';
    },
    maxMenuHeight: 300,
    minMenuHeight: 140,
    menuIsOpen: false,
    menuPlacement: 'bottom',
    menuPosition: 'absolute',
    menuShouldBlockScroll: false,
    menuShouldScrollIntoView: !_index4Bd03571EsmJs.A(),
    noOptionsMessage: function noOptionsMessage() {
        return 'No options';
    },
    openMenuOnFocus: false,
    openMenuOnClick: true,
    options: [],
    pageSize: 5,
    placeholder: 'Select...',
    screenReaderStatus: function screenReaderStatus(_ref1) {
        var count = _ref1.count;
        return "".concat(count, " result").concat(count !== 1 ? 's' : '', " available");
    },
    styles: {
    },
    tabIndex: '0',
    tabSelectsValue: true
};
function toCategorizedOption(props, option, selectValue, index) {
    var isDisabled = _isOptionDisabled(props, option, selectValue);
    var isSelected = _isOptionSelected(props, option, selectValue);
    var label = getOptionLabel$1(props, option);
    var value = getOptionValue$1(props, option);
    return {
        type: 'option',
        data: option,
        isDisabled: isDisabled,
        isSelected: isSelected,
        label: label,
        value: value,
        index: index
    };
}
function buildCategorizedOptions(props, selectValue) {
    return props.options.map(function(groupOrOption, groupOrOptionIndex) {
        if (groupOrOption.options) {
            var categorizedOptions = groupOrOption.options.map(function(option, optionIndex) {
                return toCategorizedOption(props, option, selectValue, optionIndex);
            }).filter(function(categorizedOption) {
                return isFocusable(props, categorizedOption);
            });
            return categorizedOptions.length > 0 ? {
                type: 'group',
                data: groupOrOption,
                options: categorizedOptions,
                index: groupOrOptionIndex
            } : undefined;
        }
        var categorizedOption = toCategorizedOption(props, groupOrOption, selectValue, groupOrOptionIndex);
        return isFocusable(props, categorizedOption) ? categorizedOption : undefined;
    }) // Flow limitation (see https://github.com/facebook/flow/issues/1414)
    .filter(function(categorizedOption) {
        return !!categorizedOption;
    });
}
function buildFocusableOptionsFromCategorizedOptions(categorizedOptions) {
    return categorizedOptions.reduce(function(optionsAccumulator, categorizedOption) {
        if (categorizedOption.type === 'group') optionsAccumulator.push.apply(optionsAccumulator, _toConsumableArrayDefault.default(categorizedOption.options.map(function(option) {
            return option.data;
        })));
        else optionsAccumulator.push(categorizedOption.data);
        return optionsAccumulator;
    }, []);
}
function buildFocusableOptions(props, selectValue) {
    return buildFocusableOptionsFromCategorizedOptions(buildCategorizedOptions(props, selectValue));
}
function isFocusable(props, categorizedOption) {
    var _props$inputValue = props.inputValue, inputValue = _props$inputValue === void 0 ? '' : _props$inputValue;
    var data = categorizedOption.data, isSelected = categorizedOption.isSelected, label = categorizedOption.label, value = categorizedOption.value;
    return (!shouldHideSelectedOptions(props) || !isSelected) && _filterOption(props, {
        label: label,
        value: value,
        data: data
    }, inputValue);
}
function getNextFocusedValue(state, nextSelectValue) {
    var focusedValue = state.focusedValue, lastSelectValue = state.selectValue;
    var lastFocusedIndex = lastSelectValue.indexOf(focusedValue);
    if (lastFocusedIndex > -1) {
        var nextFocusedIndex = nextSelectValue.indexOf(focusedValue);
        if (nextFocusedIndex > -1) // the focused value is still in the selectValue, return it
        return focusedValue;
        else if (lastFocusedIndex < nextSelectValue.length) // the focusedValue is not present in the next selectValue array by
        // reference, so return the new value at the same index
        return nextSelectValue[lastFocusedIndex];
    }
    return null;
}
function getNextFocusedOption(state, options) {
    var lastFocusedOption = state.focusedOption;
    return lastFocusedOption && options.indexOf(lastFocusedOption) > -1 ? lastFocusedOption : options[0];
}
var getOptionLabel$1 = function getOptionLabel2(props, data) {
    return props.getOptionLabel(data);
};
var getOptionValue$1 = function getOptionValue2(props, data) {
    return props.getOptionValue(data);
};
function _isOptionDisabled(props, option, selectValue) {
    return typeof props.isOptionDisabled === 'function' ? props.isOptionDisabled(option, selectValue) : false;
}
function _isOptionSelected(props, option, selectValue) {
    if (selectValue.indexOf(option) > -1) return true;
    if (typeof props.isOptionSelected === 'function') return props.isOptionSelected(option, selectValue);
    var candidate = getOptionValue$1(props, option);
    return selectValue.some(function(i1) {
        return getOptionValue$1(props, i1) === candidate;
    });
}
function _filterOption(props, option, inputValue) {
    return props.filterOption ? props.filterOption(option, inputValue) : true;
}
var shouldHideSelectedOptions = function shouldHideSelectedOptions1(props) {
    var hideSelectedOptions = props.hideSelectedOptions, isMulti = props.isMulti;
    if (hideSelectedOptions === undefined) return isMulti;
    return hideSelectedOptions;
};
var instanceId = 1;
var Select1 = /*#__PURE__*/ function(_Component) {
    _inheritsDefault.default(Select2, _Component);
    var _super = _index4Bd03571EsmJs._(Select2);
    // Misc. Instance Properties
    // ------------------------------
    // TODO
    // Refs
    // ------------------------------
    // Lifecycle
    // ------------------------------
    function Select2(_props) {
        var _this;
        _classCallCheckDefault.default(this, Select2);
        _this = _super.call(this, _props);
        _this.state = {
            ariaSelection: null,
            focusedOption: null,
            focusedValue: null,
            inputIsHidden: false,
            isFocused: false,
            selectValue: [],
            clearFocusValueOnUpdate: false,
            inputIsHiddenAfterUpdate: undefined,
            prevProps: undefined
        };
        _this.blockOptionHover = false;
        _this.isComposing = false;
        _this.commonProps = void 0;
        _this.initialTouchX = 0;
        _this.initialTouchY = 0;
        _this.instancePrefix = '';
        _this.openAfterFocus = false;
        _this.scrollToFocusedOptionOnUpdate = false;
        _this.userIsDragging = void 0;
        _this.controlRef = null;
        _this.getControlRef = function(ref) {
            _this.controlRef = ref;
        };
        _this.focusedOptionRef = null;
        _this.getFocusedOptionRef = function(ref) {
            _this.focusedOptionRef = ref;
        };
        _this.menuListRef = null;
        _this.getMenuListRef = function(ref) {
            _this.menuListRef = ref;
        };
        _this.inputRef = null;
        _this.getInputRef = function(ref) {
            _this.inputRef = ref;
        };
        _this.focus = _this.focusInput;
        _this.blur = _this.blurInput;
        _this.onChange = function(newValue, actionMeta) {
            var _this$props = _this.props, onChange = _this$props.onChange, name = _this$props.name;
            actionMeta.name = name;
            _this.ariaOnChange(newValue, actionMeta);
            onChange(newValue, actionMeta);
        };
        _this.setValue = function(newValue) {
            var action = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'set-value';
            var option = arguments.length > 2 ? arguments[2] : undefined;
            var _this$props2 = _this.props, closeMenuOnSelect = _this$props2.closeMenuOnSelect, isMulti = _this$props2.isMulti;
            _this.onInputChange('', {
                action: 'set-value'
            });
            if (closeMenuOnSelect) {
                _this.setState({
                    inputIsHiddenAfterUpdate: !isMulti
                });
                _this.onMenuClose();
            } // when the select value should change, we should reset focusedValue
            _this.setState({
                clearFocusValueOnUpdate: true
            });
            _this.onChange(newValue, {
                action: action,
                option: option
            });
        };
        _this.selectOption = function(newValue) {
            var _this$props3 = _this.props, blurInputOnSelect = _this$props3.blurInputOnSelect, isMulti = _this$props3.isMulti, name = _this$props3.name;
            var selectValue = _this.state.selectValue;
            var deselected = isMulti && _this.isOptionSelected(newValue, selectValue);
            var isDisabled = _this.isOptionDisabled(newValue, selectValue);
            if (deselected) {
                var candidate = _this.getOptionValue(newValue);
                _this.setValue(selectValue.filter(function(i1) {
                    return _this.getOptionValue(i1) !== candidate;
                }), 'deselect-option', newValue);
            } else if (!isDisabled) {
                // Select option if option is not disabled
                if (isMulti) _this.setValue([].concat(_toConsumableArrayDefault.default(selectValue), [
                    newValue
                ]), 'select-option', newValue);
                else _this.setValue(newValue, 'select-option');
            } else {
                _this.ariaOnChange(newValue, {
                    action: 'select-option',
                    name: name
                });
                return;
            }
            if (blurInputOnSelect) _this.blurInput();
        };
        _this.removeValue = function(removedValue) {
            var isMulti = _this.props.isMulti;
            var selectValue = _this.state.selectValue;
            var candidate = _this.getOptionValue(removedValue);
            var newValueArray = selectValue.filter(function(i1) {
                return _this.getOptionValue(i1) !== candidate;
            });
            var newValue = isMulti ? newValueArray : newValueArray[0] || null;
            _this.onChange(newValue, {
                action: 'remove-value',
                removedValue: removedValue
            });
            _this.focusInput();
        };
        _this.clearValue = function() {
            var selectValue = _this.state.selectValue;
            _this.onChange(_this.props.isMulti ? [] : null, {
                action: 'clear',
                removedValues: selectValue
            });
        };
        _this.popValue = function() {
            var isMulti = _this.props.isMulti;
            var selectValue = _this.state.selectValue;
            var lastSelectedValue = selectValue[selectValue.length - 1];
            var newValueArray = selectValue.slice(0, selectValue.length - 1);
            var newValue = isMulti ? newValueArray : newValueArray[0] || null;
            _this.onChange(newValue, {
                action: 'pop-value',
                removedValue: lastSelectedValue
            });
        };
        _this.getValue = function() {
            return _this.state.selectValue;
        };
        _this.cx = function() {
            for(var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++)args[_key] = arguments[_key];
            return _index4Bd03571EsmJs.B.apply(void 0, [
                _this.props.classNamePrefix
            ].concat(args));
        };
        _this.getOptionLabel = function(data) {
            return getOptionLabel$1(_this.props, data);
        };
        _this.getOptionValue = function(data) {
            return getOptionValue$1(_this.props, data);
        };
        _this.getStyles = function(key, props) {
            var base = defaultStyles[key](props);
            base.boxSizing = 'border-box';
            var custom = _this.props.styles[key];
            return custom ? custom(base, props) : base;
        };
        _this.getElementId = function(element) {
            return "".concat(_this.instancePrefix, "-").concat(element);
        };
        _this.getComponents = function() {
            return _index4Bd03571EsmJs.C(_this.props);
        };
        _this.buildCategorizedOptions = function() {
            return buildCategorizedOptions(_this.props, _this.state.selectValue);
        };
        _this.getCategorizedOptions = function() {
            return _this.props.menuIsOpen ? _this.buildCategorizedOptions() : [];
        };
        _this.buildFocusableOptions = function() {
            return buildFocusableOptionsFromCategorizedOptions(_this.buildCategorizedOptions());
        };
        _this.getFocusableOptions = function() {
            return _this.props.menuIsOpen ? _this.buildFocusableOptions() : [];
        };
        _this.ariaOnChange = function(value, actionMeta) {
            _this.setState({
                ariaSelection: _index4Bd03571EsmJs.a({
                    value: value
                }, actionMeta)
            });
        };
        _this.onMenuMouseDown = function(event) {
            if (event.button !== 0) return;
            event.stopPropagation();
            event.preventDefault();
            _this.focusInput();
        };
        _this.onMenuMouseMove = function(event) {
            _this.blockOptionHover = false;
        };
        _this.onControlMouseDown = function(event) {
            var openMenuOnClick = _this.props.openMenuOnClick;
            if (!_this.state.isFocused) {
                if (openMenuOnClick) _this.openAfterFocus = true;
                _this.focusInput();
            } else if (!_this.props.menuIsOpen) {
                if (openMenuOnClick) _this.openMenu('first');
            } else if (event.target.tagName !== 'INPUT' && event.target.tagName !== 'TEXTAREA') _this.onMenuClose();
            if (event.target.tagName !== 'INPUT' && event.target.tagName !== 'TEXTAREA') event.preventDefault();
        };
        _this.onDropdownIndicatorMouseDown = function(event) {
            // ignore mouse events that weren't triggered by the primary button
            if (event && event.type === 'mousedown' && event.button !== 0) return;
            if (_this.props.isDisabled) return;
            var _this$props4 = _this.props, isMulti = _this$props4.isMulti, menuIsOpen = _this$props4.menuIsOpen;
            _this.focusInput();
            if (menuIsOpen) {
                _this.setState({
                    inputIsHiddenAfterUpdate: !isMulti
                });
                _this.onMenuClose();
            } else _this.openMenu('first');
            event.preventDefault();
            event.stopPropagation();
        };
        _this.onClearIndicatorMouseDown = function(event) {
            // ignore mouse events that weren't triggered by the primary button
            if (event && event.type === 'mousedown' && event.button !== 0) return;
            _this.clearValue();
            event.stopPropagation();
            _this.openAfterFocus = false;
            if (event.type === 'touchend') _this.focusInput();
            else setTimeout(function() {
                return _this.focusInput();
            });
        };
        _this.onScroll = function(event) {
            if (typeof _this.props.closeMenuOnScroll === 'boolean') {
                if (event.target instanceof HTMLElement && _index4Bd03571EsmJs.D(event.target)) _this.props.onMenuClose();
            } else if (typeof _this.props.closeMenuOnScroll === 'function') {
                if (_this.props.closeMenuOnScroll(event)) _this.props.onMenuClose();
            }
        };
        _this.onCompositionStart = function() {
            _this.isComposing = true;
        };
        _this.onCompositionEnd = function() {
            _this.isComposing = false;
        };
        _this.onTouchStart = function(_ref21) {
            var touches = _ref21.touches;
            var touch = touches && touches.item(0);
            if (!touch) return;
            _this.initialTouchX = touch.clientX;
            _this.initialTouchY = touch.clientY;
            _this.userIsDragging = false;
        };
        _this.onTouchMove = function(_ref3) {
            var touches = _ref3.touches;
            var touch = touches && touches.item(0);
            if (!touch) return;
            var deltaX = Math.abs(touch.clientX - _this.initialTouchX);
            var deltaY = Math.abs(touch.clientY - _this.initialTouchY);
            var moveThreshold = 5;
            _this.userIsDragging = deltaX > moveThreshold || deltaY > moveThreshold;
        };
        _this.onTouchEnd = function(event) {
            if (_this.userIsDragging) return; // close the menu if the user taps outside
            // we're checking on event.target here instead of event.currentTarget, because we want to assert information
            // on events on child elements, not the document (which we've attached this handler to).
            if (_this.controlRef && !_this.controlRef.contains(event.target) && _this.menuListRef && !_this.menuListRef.contains(event.target)) _this.blurInput();
             // reset move vars
            _this.initialTouchX = 0;
            _this.initialTouchY = 0;
        };
        _this.onControlTouchEnd = function(event) {
            if (_this.userIsDragging) return;
            _this.onControlMouseDown(event);
        };
        _this.onClearIndicatorTouchEnd = function(event) {
            if (_this.userIsDragging) return;
            _this.onClearIndicatorMouseDown(event);
        };
        _this.onDropdownIndicatorTouchEnd = function(event) {
            if (_this.userIsDragging) return;
            _this.onDropdownIndicatorMouseDown(event);
        };
        _this.handleInputChange = function(event) {
            var inputValue = event.currentTarget.value;
            _this.setState({
                inputIsHiddenAfterUpdate: false
            });
            _this.onInputChange(inputValue, {
                action: 'input-change'
            });
            if (!_this.props.menuIsOpen) _this.onMenuOpen();
        };
        _this.onInputFocus = function(event) {
            if (_this.props.onFocus) _this.props.onFocus(event);
            _this.setState({
                inputIsHiddenAfterUpdate: false,
                isFocused: true
            });
            if (_this.openAfterFocus || _this.props.openMenuOnFocus) _this.openMenu('first');
            _this.openAfterFocus = false;
        };
        _this.onInputBlur = function(event) {
            if (_this.menuListRef && _this.menuListRef.contains(document.activeElement)) {
                _this.inputRef.focus();
                return;
            }
            if (_this.props.onBlur) _this.props.onBlur(event);
            _this.onInputChange('', {
                action: 'input-blur'
            });
            _this.onMenuClose();
            _this.setState({
                focusedValue: null,
                isFocused: false
            });
        };
        _this.onOptionHover = function(focusedOption) {
            if (_this.blockOptionHover || _this.state.focusedOption === focusedOption) return;
            _this.setState({
                focusedOption: focusedOption
            });
        };
        _this.shouldHideSelectedOptions = function() {
            return shouldHideSelectedOptions(_this.props);
        };
        _this.onKeyDown = function(event) {
            var _this$props5 = _this.props, isMulti = _this$props5.isMulti, backspaceRemovesValue = _this$props5.backspaceRemovesValue, escapeClearsValue = _this$props5.escapeClearsValue, inputValue = _this$props5.inputValue, isClearable = _this$props5.isClearable, isDisabled = _this$props5.isDisabled, menuIsOpen = _this$props5.menuIsOpen, onKeyDown = _this$props5.onKeyDown, tabSelectsValue = _this$props5.tabSelectsValue, openMenuOnFocus = _this$props5.openMenuOnFocus;
            var _this$state = _this.state, focusedOption = _this$state.focusedOption, focusedValue = _this$state.focusedValue, selectValue = _this$state.selectValue;
            if (isDisabled) return;
            if (typeof onKeyDown === 'function') {
                onKeyDown(event);
                if (event.defaultPrevented) return;
            } // Block option hover events when the user has just pressed a key
            _this.blockOptionHover = true;
            switch(event.key){
                case 'ArrowLeft':
                    if (!isMulti || inputValue) return;
                    _this.focusValue('previous');
                    break;
                case 'ArrowRight':
                    if (!isMulti || inputValue) return;
                    _this.focusValue('next');
                    break;
                case 'Delete':
                case 'Backspace':
                    if (inputValue) return;
                    if (focusedValue) _this.removeValue(focusedValue);
                    else {
                        if (!backspaceRemovesValue) return;
                        if (isMulti) _this.popValue();
                        else if (isClearable) _this.clearValue();
                    }
                    break;
                case 'Tab':
                    if (_this.isComposing) return;
                    if (event.shiftKey || !menuIsOpen || !tabSelectsValue || !focusedOption || // option is already selected; it breaks the flow of navigation
                    openMenuOnFocus && _this.isOptionSelected(focusedOption, selectValue)) return;
                    _this.selectOption(focusedOption);
                    break;
                case 'Enter':
                    if (event.keyCode === 229) break;
                    if (menuIsOpen) {
                        if (!focusedOption) return;
                        if (_this.isComposing) return;
                        _this.selectOption(focusedOption);
                        break;
                    }
                    return;
                case 'Escape':
                    if (menuIsOpen) {
                        _this.setState({
                            inputIsHiddenAfterUpdate: false
                        });
                        _this.onInputChange('', {
                            action: 'menu-close'
                        });
                        _this.onMenuClose();
                    } else if (isClearable && escapeClearsValue) _this.clearValue();
                    break;
                case ' ':
                    // space
                    if (inputValue) return;
                    if (!menuIsOpen) {
                        _this.openMenu('first');
                        break;
                    }
                    if (!focusedOption) return;
                    _this.selectOption(focusedOption);
                    break;
                case 'ArrowUp':
                    if (menuIsOpen) _this.focusOption('up');
                    else _this.openMenu('last');
                    break;
                case 'ArrowDown':
                    if (menuIsOpen) _this.focusOption('down');
                    else _this.openMenu('first');
                    break;
                case 'PageUp':
                    if (!menuIsOpen) return;
                    _this.focusOption('pageup');
                    break;
                case 'PageDown':
                    if (!menuIsOpen) return;
                    _this.focusOption('pagedown');
                    break;
                case 'Home':
                    if (!menuIsOpen) return;
                    _this.focusOption('first');
                    break;
                case 'End':
                    if (!menuIsOpen) return;
                    _this.focusOption('last');
                    break;
                default:
                    return;
            }
            event.preventDefault();
        };
        _this.instancePrefix = 'react-select-' + (_this.props.instanceId || ++instanceId);
        _this.state.selectValue = _index4Bd03571EsmJs.E(_props.value);
        return _this;
    }
    _createClassDefault.default(Select2, [
        {
            key: "componentDidMount",
            value: function componentDidMount() {
                this.startListeningComposition();
                this.startListeningToTouch();
                if (this.props.closeMenuOnScroll && document && document.addEventListener) // Listen to all scroll events, and filter them out inside of 'onScroll'
                document.addEventListener('scroll', this.onScroll, true);
                if (this.props.autoFocus) this.focusInput();
            }
        },
        {
            key: "componentDidUpdate",
            value: function componentDidUpdate(prevProps) {
                var _this$props6 = this.props, isDisabled = _this$props6.isDisabled, menuIsOpen = _this$props6.menuIsOpen;
                var isFocused = this.state.isFocused;
                if (isFocused && !isDisabled && prevProps.isDisabled || isFocused && menuIsOpen && !prevProps.menuIsOpen) this.focusInput();
                if (isFocused && isDisabled && !prevProps.isDisabled) // ensure select state gets blurred in case Select is programatically disabled while focused
                this.setState({
                    isFocused: false
                }, this.onMenuClose);
                 // scroll the focused option into view if necessary
                if (this.menuListRef && this.focusedOptionRef && this.scrollToFocusedOptionOnUpdate) {
                    _index4Bd03571EsmJs.F(this.menuListRef, this.focusedOptionRef);
                    this.scrollToFocusedOptionOnUpdate = false;
                }
            }
        },
        {
            key: "componentWillUnmount",
            value: function componentWillUnmount() {
                this.stopListeningComposition();
                this.stopListeningToTouch();
                document.removeEventListener('scroll', this.onScroll, true);
            } // ==============================
        },
        {
            key: "onMenuOpen",
            value: function onMenuOpen() {
                this.props.onMenuOpen();
            }
        },
        {
            key: "onMenuClose",
            value: function onMenuClose() {
                this.onInputChange('', {
                    action: 'menu-close'
                });
                this.props.onMenuClose();
            }
        },
        {
            key: "onInputChange",
            value: function onInputChange(newValue, actionMeta) {
                this.props.onInputChange(newValue, actionMeta);
            } // ==============================
        },
        {
            key: "focusInput",
            value: function focusInput() {
                if (!this.inputRef) return;
                this.inputRef.focus();
            }
        },
        {
            key: "blurInput",
            value: function blurInput() {
                if (!this.inputRef) return;
                this.inputRef.blur();
            } // aliased for consumers
        },
        {
            key: "openMenu",
            value: function openMenu(focusOption) {
                var _this2 = this;
                var _this$state2 = this.state, selectValue = _this$state2.selectValue, isFocused = _this$state2.isFocused;
                var focusableOptions = this.buildFocusableOptions();
                var openAtIndex = focusOption === 'first' ? 0 : focusableOptions.length - 1;
                if (!this.props.isMulti) {
                    var selectedIndex = focusableOptions.indexOf(selectValue[0]);
                    if (selectedIndex > -1) openAtIndex = selectedIndex;
                } // only scroll if the menu isn't already open
                this.scrollToFocusedOptionOnUpdate = !(isFocused && this.menuListRef);
                this.setState({
                    inputIsHiddenAfterUpdate: false,
                    focusedValue: null,
                    focusedOption: focusableOptions[openAtIndex]
                }, function() {
                    return _this2.onMenuOpen();
                });
            }
        },
        {
            key: "focusValue",
            value: function focusValue(direction) {
                var _this$state3 = this.state, selectValue = _this$state3.selectValue, focusedValue = _this$state3.focusedValue; // Only multiselects support value focusing
                if (!this.props.isMulti) return;
                this.setState({
                    focusedOption: null
                });
                var focusedIndex = selectValue.indexOf(focusedValue);
                if (!focusedValue) focusedIndex = -1;
                var lastIndex = selectValue.length - 1;
                var nextFocus = -1;
                if (!selectValue.length) return;
                switch(direction){
                    case 'previous':
                        if (focusedIndex === 0) // don't cycle from the start to the end
                        nextFocus = 0;
                        else if (focusedIndex === -1) // if nothing is focused, focus the last value first
                        nextFocus = lastIndex;
                        else nextFocus = focusedIndex - 1;
                        break;
                    case 'next':
                        if (focusedIndex > -1 && focusedIndex < lastIndex) nextFocus = focusedIndex + 1;
                        break;
                }
                this.setState({
                    inputIsHidden: nextFocus !== -1,
                    focusedValue: selectValue[nextFocus]
                });
            }
        },
        {
            key: "focusOption",
            value: function focusOption() {
                var direction = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'first';
                var pageSize = this.props.pageSize;
                var focusedOption = this.state.focusedOption;
                var options = this.getFocusableOptions();
                if (!options.length) return;
                var nextFocus = 0; // handles 'first'
                var focusedIndex = options.indexOf(focusedOption);
                if (!focusedOption) focusedIndex = -1;
                if (direction === 'up') nextFocus = focusedIndex > 0 ? focusedIndex - 1 : options.length - 1;
                else if (direction === 'down') nextFocus = (focusedIndex + 1) % options.length;
                else if (direction === 'pageup') {
                    nextFocus = focusedIndex - pageSize;
                    if (nextFocus < 0) nextFocus = 0;
                } else if (direction === 'pagedown') {
                    nextFocus = focusedIndex + pageSize;
                    if (nextFocus > options.length - 1) nextFocus = options.length - 1;
                } else if (direction === 'last') nextFocus = options.length - 1;
                this.scrollToFocusedOptionOnUpdate = true;
                this.setState({
                    focusedOption: options[nextFocus],
                    focusedValue: null
                });
            }
        },
        {
            key: "getTheme",
            value: // Getters
            // ==============================
            function getTheme() {
                // Use the default theme if there are no customizations.
                if (!this.props.theme) return defaultTheme;
                 // If the theme prop is a function, assume the function
                // knows how to merge the passed-in default theme with
                // its own modifications.
                if (typeof this.props.theme === 'function') return this.props.theme(defaultTheme);
                 // Otherwise, if a plain theme object was passed in,
                // overlay it with the default theme.
                return _index4Bd03571EsmJs.a(_index4Bd03571EsmJs.a({
                }, defaultTheme), this.props.theme);
            }
        },
        {
            key: "getCommonProps",
            value: function getCommonProps() {
                var clearValue = this.clearValue, cx = this.cx, getStyles = this.getStyles, getValue = this.getValue, selectOption = this.selectOption, setValue = this.setValue, props = this.props;
                var isMulti = props.isMulti, isRtl = props.isRtl, options = props.options;
                var hasValue = this.hasValue();
                return {
                    clearValue: clearValue,
                    cx: cx,
                    getStyles: getStyles,
                    getValue: getValue,
                    hasValue: hasValue,
                    isMulti: isMulti,
                    isRtl: isRtl,
                    options: options,
                    selectOption: selectOption,
                    selectProps: props,
                    setValue: setValue,
                    theme: this.getTheme()
                };
            }
        },
        {
            key: "hasValue",
            value: function hasValue() {
                var selectValue = this.state.selectValue;
                return selectValue.length > 0;
            }
        },
        {
            key: "hasOptions",
            value: function hasOptions() {
                return !!this.getFocusableOptions().length;
            }
        },
        {
            key: "isClearable",
            value: function isClearable() {
                var _this$props7 = this.props, isClearable = _this$props7.isClearable, isMulti = _this$props7.isMulti; // single select, by default, IS NOT clearable
                // multi select, by default, IS clearable
                if (isClearable === undefined) return isMulti;
                return isClearable;
            }
        },
        {
            key: "isOptionDisabled",
            value: function isOptionDisabled2(option, selectValue) {
                return _isOptionDisabled(this.props, option, selectValue);
            }
        },
        {
            key: "isOptionSelected",
            value: function isOptionSelected(option, selectValue) {
                return _isOptionSelected(this.props, option, selectValue);
            }
        },
        {
            key: "filterOption",
            value: function filterOption(option, inputValue) {
                return _filterOption(this.props, option, inputValue);
            }
        },
        {
            key: "formatOptionLabel",
            value: function formatOptionLabel(data, context) {
                if (typeof this.props.formatOptionLabel === 'function') {
                    var inputValue = this.props.inputValue;
                    var selectValue = this.state.selectValue;
                    return this.props.formatOptionLabel(data, {
                        context: context,
                        inputValue: inputValue,
                        selectValue: selectValue
                    });
                } else return this.getOptionLabel(data);
            }
        },
        {
            key: "formatGroupLabel",
            value: function formatGroupLabel2(data) {
                return this.props.formatGroupLabel(data);
            } // ==============================
        },
        {
            key: "startListeningComposition",
            value: // Composition Handlers
            // ==============================
            function startListeningComposition() {
                if (document && document.addEventListener) {
                    document.addEventListener('compositionstart', this.onCompositionStart, false);
                    document.addEventListener('compositionend', this.onCompositionEnd, false);
                }
            }
        },
        {
            key: "stopListeningComposition",
            value: function stopListeningComposition() {
                if (document && document.removeEventListener) {
                    document.removeEventListener('compositionstart', this.onCompositionStart);
                    document.removeEventListener('compositionend', this.onCompositionEnd);
                }
            }
        },
        {
            key: "startListeningToTouch",
            value: // Touch Handlers
            // ==============================
            function startListeningToTouch() {
                if (document && document.addEventListener) {
                    document.addEventListener('touchstart', this.onTouchStart, false);
                    document.addEventListener('touchmove', this.onTouchMove, false);
                    document.addEventListener('touchend', this.onTouchEnd, false);
                }
            }
        },
        {
            key: "stopListeningToTouch",
            value: function stopListeningToTouch() {
                if (document && document.removeEventListener) {
                    document.removeEventListener('touchstart', this.onTouchStart);
                    document.removeEventListener('touchmove', this.onTouchMove);
                    document.removeEventListener('touchend', this.onTouchEnd);
                }
            }
        },
        {
            key: "renderInput",
            value: // Renderers
            // ==============================
            function renderInput() {
                var _this$props8 = this.props, isDisabled = _this$props8.isDisabled, isSearchable = _this$props8.isSearchable, inputId = _this$props8.inputId, inputValue = _this$props8.inputValue, tabIndex = _this$props8.tabIndex, form = _this$props8.form;
                var _this$getComponents = this.getComponents(), Input = _this$getComponents.Input;
                var inputIsHidden = this.state.inputIsHidden;
                var commonProps = this.commonProps;
                var id = inputId || this.getElementId('input'); // aria attributes makes the JSX "noisy", separated for clarity
                var ariaAttributes = {
                    'aria-autocomplete': 'list',
                    'aria-label': this.props['aria-label'],
                    'aria-labelledby': this.props['aria-labelledby']
                };
                if (!isSearchable) // use a dummy input to maintain focus/blur functionality
                return(/*#__PURE__*/ _reactDefault.default.createElement(DummyInput, _extendsDefault.default({
                    id: id,
                    innerRef: this.getInputRef,
                    onBlur: this.onInputBlur,
                    onChange: _index4Bd03571EsmJs.G,
                    onFocus: this.onInputFocus,
                    readOnly: true,
                    disabled: isDisabled,
                    tabIndex: tabIndex,
                    form: form,
                    value: ""
                }, ariaAttributes)));
                return(/*#__PURE__*/ _reactDefault.default.createElement(Input, _extendsDefault.default({
                }, commonProps, {
                    autoCapitalize: "none",
                    autoComplete: "off",
                    autoCorrect: "off",
                    id: id,
                    innerRef: this.getInputRef,
                    isDisabled: isDisabled,
                    isHidden: inputIsHidden,
                    onBlur: this.onInputBlur,
                    onChange: this.handleInputChange,
                    onFocus: this.onInputFocus,
                    spellCheck: "false",
                    tabIndex: tabIndex,
                    form: form,
                    type: "text",
                    value: inputValue
                }, ariaAttributes)));
            }
        },
        {
            key: "renderPlaceholderOrValue",
            value: function renderPlaceholderOrValue() {
                var _this3 = this;
                var _this$getComponents2 = this.getComponents(), MultiValue = _this$getComponents2.MultiValue, MultiValueContainer = _this$getComponents2.MultiValueContainer, MultiValueLabel = _this$getComponents2.MultiValueLabel, MultiValueRemove = _this$getComponents2.MultiValueRemove, SingleValue = _this$getComponents2.SingleValue, Placeholder = _this$getComponents2.Placeholder;
                var commonProps = this.commonProps;
                var _this$props9 = this.props, controlShouldRenderValue = _this$props9.controlShouldRenderValue, isDisabled = _this$props9.isDisabled, isMulti = _this$props9.isMulti, inputValue = _this$props9.inputValue, placeholder = _this$props9.placeholder;
                var _this$state4 = this.state, selectValue = _this$state4.selectValue, focusedValue = _this$state4.focusedValue, isFocused = _this$state4.isFocused;
                if (!this.hasValue() || !controlShouldRenderValue) return inputValue ? null : /*#__PURE__*/ _reactDefault.default.createElement(Placeholder, _extendsDefault.default({
                }, commonProps, {
                    key: "placeholder",
                    isDisabled: isDisabled,
                    isFocused: isFocused
                }), placeholder);
                if (isMulti) {
                    var selectValues = selectValue.map(function(opt, index) {
                        var isOptionFocused = opt === focusedValue;
                        return(/*#__PURE__*/ _reactDefault.default.createElement(MultiValue, _extendsDefault.default({
                        }, commonProps, {
                            components: {
                                Container: MultiValueContainer,
                                Label: MultiValueLabel,
                                Remove: MultiValueRemove
                            },
                            isFocused: isOptionFocused,
                            isDisabled: isDisabled,
                            key: "".concat(_this3.getOptionValue(opt)).concat(index),
                            index: index,
                            removeProps: {
                                onClick: function onClick() {
                                    return _this3.removeValue(opt);
                                },
                                onTouchEnd: function onTouchEnd() {
                                    return _this3.removeValue(opt);
                                },
                                onMouseDown: function onMouseDown(e) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                }
                            },
                            data: opt
                        }), _this3.formatOptionLabel(opt, 'value')));
                    });
                    return selectValues;
                }
                if (inputValue) return null;
                var singleValue = selectValue[0];
                return(/*#__PURE__*/ _reactDefault.default.createElement(SingleValue, _extendsDefault.default({
                }, commonProps, {
                    data: singleValue,
                    isDisabled: isDisabled
                }), this.formatOptionLabel(singleValue, 'value')));
            }
        },
        {
            key: "renderClearIndicator",
            value: function renderClearIndicator() {
                var _this$getComponents3 = this.getComponents(), ClearIndicator = _this$getComponents3.ClearIndicator;
                var commonProps = this.commonProps;
                var _this$props10 = this.props, isDisabled = _this$props10.isDisabled, isLoading = _this$props10.isLoading;
                var isFocused = this.state.isFocused;
                if (!this.isClearable() || !ClearIndicator || isDisabled || !this.hasValue() || isLoading) return null;
                var innerProps = {
                    onMouseDown: this.onClearIndicatorMouseDown,
                    onTouchEnd: this.onClearIndicatorTouchEnd,
                    'aria-hidden': 'true'
                };
                return(/*#__PURE__*/ _reactDefault.default.createElement(ClearIndicator, _extendsDefault.default({
                }, commonProps, {
                    innerProps: innerProps,
                    isFocused: isFocused
                })));
            }
        },
        {
            key: "renderLoadingIndicator",
            value: function renderLoadingIndicator() {
                var _this$getComponents4 = this.getComponents(), LoadingIndicator = _this$getComponents4.LoadingIndicator;
                var commonProps = this.commonProps;
                var _this$props11 = this.props, isDisabled = _this$props11.isDisabled, isLoading = _this$props11.isLoading;
                var isFocused = this.state.isFocused;
                if (!LoadingIndicator || !isLoading) return null;
                var innerProps = {
                    'aria-hidden': 'true'
                };
                return(/*#__PURE__*/ _reactDefault.default.createElement(LoadingIndicator, _extendsDefault.default({
                }, commonProps, {
                    innerProps: innerProps,
                    isDisabled: isDisabled,
                    isFocused: isFocused
                })));
            }
        },
        {
            key: "renderIndicatorSeparator",
            value: function renderIndicatorSeparator() {
                var _this$getComponents5 = this.getComponents(), DropdownIndicator = _this$getComponents5.DropdownIndicator, IndicatorSeparator = _this$getComponents5.IndicatorSeparator; // separator doesn't make sense without the dropdown indicator
                if (!DropdownIndicator || !IndicatorSeparator) return null;
                var commonProps = this.commonProps;
                var isDisabled = this.props.isDisabled;
                var isFocused = this.state.isFocused;
                return(/*#__PURE__*/ _reactDefault.default.createElement(IndicatorSeparator, _extendsDefault.default({
                }, commonProps, {
                    isDisabled: isDisabled,
                    isFocused: isFocused
                })));
            }
        },
        {
            key: "renderDropdownIndicator",
            value: function renderDropdownIndicator() {
                var _this$getComponents6 = this.getComponents(), DropdownIndicator = _this$getComponents6.DropdownIndicator;
                if (!DropdownIndicator) return null;
                var commonProps = this.commonProps;
                var isDisabled = this.props.isDisabled;
                var isFocused = this.state.isFocused;
                var innerProps = {
                    onMouseDown: this.onDropdownIndicatorMouseDown,
                    onTouchEnd: this.onDropdownIndicatorTouchEnd,
                    'aria-hidden': 'true'
                };
                return(/*#__PURE__*/ _reactDefault.default.createElement(DropdownIndicator, _extendsDefault.default({
                }, commonProps, {
                    innerProps: innerProps,
                    isDisabled: isDisabled,
                    isFocused: isFocused
                })));
            }
        },
        {
            key: "renderMenu",
            value: function renderMenu() {
                var _this4 = this;
                var _this$getComponents7 = this.getComponents(), Group = _this$getComponents7.Group, GroupHeading = _this$getComponents7.GroupHeading, Menu = _this$getComponents7.Menu, MenuList = _this$getComponents7.MenuList, MenuPortal = _this$getComponents7.MenuPortal, LoadingMessage = _this$getComponents7.LoadingMessage, NoOptionsMessage = _this$getComponents7.NoOptionsMessage, Option1 = _this$getComponents7.Option;
                var commonProps = this.commonProps;
                var focusedOption = this.state.focusedOption;
                var _this$props12 = this.props, captureMenuScroll = _this$props12.captureMenuScroll, inputValue = _this$props12.inputValue, isLoading = _this$props12.isLoading, loadingMessage = _this$props12.loadingMessage, minMenuHeight = _this$props12.minMenuHeight, maxMenuHeight = _this$props12.maxMenuHeight, menuIsOpen = _this$props12.menuIsOpen, menuPlacement = _this$props12.menuPlacement, menuPosition = _this$props12.menuPosition, menuPortalTarget = _this$props12.menuPortalTarget, menuShouldBlockScroll = _this$props12.menuShouldBlockScroll, menuShouldScrollIntoView = _this$props12.menuShouldScrollIntoView, noOptionsMessage = _this$props12.noOptionsMessage, onMenuScrollToTop = _this$props12.onMenuScrollToTop, onMenuScrollToBottom = _this$props12.onMenuScrollToBottom;
                if (!menuIsOpen) return null; // TODO: Internal Option Type here
                var render = function render1(props, id) {
                    var type = props.type, data = props.data, isDisabled = props.isDisabled, isSelected = props.isSelected, label = props.label, value = props.value;
                    var isFocused = focusedOption === data;
                    var onHover = isDisabled ? undefined : function() {
                        return _this4.onOptionHover(data);
                    };
                    var onSelect = isDisabled ? undefined : function() {
                        return _this4.selectOption(data);
                    };
                    var optionId = "".concat(_this4.getElementId('option'), "-").concat(id);
                    var innerProps = {
                        id: optionId,
                        onClick: onSelect,
                        onMouseMove: onHover,
                        onMouseOver: onHover,
                        tabIndex: -1
                    };
                    return(/*#__PURE__*/ _reactDefault.default.createElement(Option1, _extendsDefault.default({
                    }, commonProps, {
                        innerProps: innerProps,
                        data: data,
                        isDisabled: isDisabled,
                        isSelected: isSelected,
                        key: optionId,
                        label: label,
                        type: type,
                        value: value,
                        isFocused: isFocused,
                        innerRef: isFocused ? _this4.getFocusedOptionRef : undefined
                    }), _this4.formatOptionLabel(props.data, 'menu')));
                };
                var menuUI;
                if (this.hasOptions()) menuUI = this.getCategorizedOptions().map(function(item) {
                    if (item.type === 'group') {
                        var data = item.data, options = item.options, groupIndex = item.index;
                        var groupId = "".concat(_this4.getElementId('group'), "-").concat(groupIndex);
                        var headingId = "".concat(groupId, "-heading");
                        return(/*#__PURE__*/ _reactDefault.default.createElement(Group, _extendsDefault.default({
                        }, commonProps, {
                            key: groupId,
                            data: data,
                            options: options,
                            Heading: GroupHeading,
                            headingProps: {
                                id: headingId,
                                data: item.data
                            },
                            label: _this4.formatGroupLabel(item.data)
                        }), item.options.map(function(option) {
                            return render(option, "".concat(groupIndex, "-").concat(option.index));
                        })));
                    } else if (item.type === 'option') return render(item, "".concat(item.index));
                });
                else if (isLoading) {
                    var message = loadingMessage({
                        inputValue: inputValue
                    });
                    if (message === null) return null;
                    menuUI = /*#__PURE__*/ _reactDefault.default.createElement(LoadingMessage, commonProps, message);
                } else {
                    var _message = noOptionsMessage({
                        inputValue: inputValue
                    });
                    if (_message === null) return null;
                    menuUI = /*#__PURE__*/ _reactDefault.default.createElement(NoOptionsMessage, commonProps, _message);
                }
                var menuPlacementProps = {
                    minMenuHeight: minMenuHeight,
                    maxMenuHeight: maxMenuHeight,
                    menuPlacement: menuPlacement,
                    menuPosition: menuPosition,
                    menuShouldScrollIntoView: menuShouldScrollIntoView
                };
                var menuElement = /*#__PURE__*/ _reactDefault.default.createElement(_index4Bd03571EsmJs.M, _extendsDefault.default({
                }, commonProps, menuPlacementProps), function(_ref4) {
                    var ref = _ref4.ref, _ref4$placerProps = _ref4.placerProps, placement = _ref4$placerProps.placement, maxHeight = _ref4$placerProps.maxHeight;
                    return(/*#__PURE__*/ _reactDefault.default.createElement(Menu, _extendsDefault.default({
                    }, commonProps, menuPlacementProps, {
                        innerRef: ref,
                        innerProps: {
                            onMouseDown: _this4.onMenuMouseDown,
                            onMouseMove: _this4.onMenuMouseMove
                        },
                        isLoading: isLoading,
                        placement: placement
                    }), /*#__PURE__*/ _reactDefault.default.createElement(ScrollManager, {
                        captureEnabled: captureMenuScroll,
                        onTopArrive: onMenuScrollToTop,
                        onBottomArrive: onMenuScrollToBottom,
                        lockEnabled: menuShouldBlockScroll
                    }, function(scrollTargetRef) {
                        return(/*#__PURE__*/ _reactDefault.default.createElement(MenuList, _extendsDefault.default({
                        }, commonProps, {
                            innerRef: function innerRef(instance) {
                                _this4.getMenuListRef(instance);
                                scrollTargetRef(instance);
                            },
                            isLoading: isLoading,
                            maxHeight: maxHeight,
                            focusedOption: focusedOption
                        }), menuUI));
                    })));
                }); // positioning behaviour is almost identical for portalled and fixed,
                // so we use the same component. the actual portalling logic is forked
                // within the component based on `menuPosition`
                return menuPortalTarget || menuPosition === 'fixed' ? /*#__PURE__*/ _reactDefault.default.createElement(MenuPortal, _extendsDefault.default({
                }, commonProps, {
                    appendTo: menuPortalTarget,
                    controlElement: this.controlRef,
                    menuPlacement: menuPlacement,
                    menuPosition: menuPosition
                }), menuElement) : menuElement;
            }
        },
        {
            key: "renderFormField",
            value: function renderFormField() {
                var _this5 = this;
                var _this$props13 = this.props, delimiter = _this$props13.delimiter, isDisabled = _this$props13.isDisabled, isMulti = _this$props13.isMulti, name = _this$props13.name;
                var selectValue = this.state.selectValue;
                if (!name || isDisabled) return;
                if (isMulti) {
                    if (delimiter) {
                        var value = selectValue.map(function(opt) {
                            return _this5.getOptionValue(opt);
                        }).join(delimiter);
                        return(/*#__PURE__*/ _reactDefault.default.createElement("input", {
                            name: name,
                            type: "hidden",
                            value: value
                        }));
                    } else {
                        var input = selectValue.length > 0 ? selectValue.map(function(opt, i1) {
                            return(/*#__PURE__*/ _reactDefault.default.createElement("input", {
                                key: "i-".concat(i1),
                                name: name,
                                type: "hidden",
                                value: _this5.getOptionValue(opt)
                            }));
                        }) : /*#__PURE__*/ _reactDefault.default.createElement("input", {
                            name: name,
                            type: "hidden"
                        });
                        return(/*#__PURE__*/ _reactDefault.default.createElement("div", null, input));
                    }
                } else {
                    var _value = selectValue[0] ? this.getOptionValue(selectValue[0]) : '';
                    return(/*#__PURE__*/ _reactDefault.default.createElement("input", {
                        name: name,
                        type: "hidden",
                        value: _value
                    }));
                }
            }
        },
        {
            key: "renderLiveRegion",
            value: function renderLiveRegion() {
                var commonProps = this.commonProps;
                var _this$state5 = this.state, ariaSelection = _this$state5.ariaSelection, focusedOption = _this$state5.focusedOption, focusedValue = _this$state5.focusedValue, isFocused = _this$state5.isFocused, selectValue = _this$state5.selectValue;
                var focusableOptions = this.getFocusableOptions();
                return(/*#__PURE__*/ _reactDefault.default.createElement(LiveRegion, _extendsDefault.default({
                }, commonProps, {
                    ariaSelection: ariaSelection,
                    focusedOption: focusedOption,
                    focusedValue: focusedValue,
                    isFocused: isFocused,
                    selectValue: selectValue,
                    focusableOptions: focusableOptions
                })));
            }
        },
        {
            key: "render",
            value: function render() {
                var _this$getComponents8 = this.getComponents(), Control = _this$getComponents8.Control, IndicatorsContainer = _this$getComponents8.IndicatorsContainer, SelectContainer = _this$getComponents8.SelectContainer, ValueContainer = _this$getComponents8.ValueContainer;
                var _this$props14 = this.props, className = _this$props14.className, id = _this$props14.id, isDisabled = _this$props14.isDisabled, menuIsOpen = _this$props14.menuIsOpen;
                var isFocused = this.state.isFocused;
                var commonProps = this.commonProps = this.getCommonProps();
                return(/*#__PURE__*/ _reactDefault.default.createElement(SelectContainer, _extendsDefault.default({
                }, commonProps, {
                    className: className,
                    innerProps: {
                        id: id,
                        onKeyDown: this.onKeyDown
                    },
                    isDisabled: isDisabled,
                    isFocused: isFocused
                }), this.renderLiveRegion(), /*#__PURE__*/ _reactDefault.default.createElement(Control, _extendsDefault.default({
                }, commonProps, {
                    innerRef: this.getControlRef,
                    innerProps: {
                        onMouseDown: this.onControlMouseDown,
                        onTouchEnd: this.onControlTouchEnd
                    },
                    isDisabled: isDisabled,
                    isFocused: isFocused,
                    menuIsOpen: menuIsOpen
                }), /*#__PURE__*/ _reactDefault.default.createElement(ValueContainer, _extendsDefault.default({
                }, commonProps, {
                    isDisabled: isDisabled
                }), this.renderPlaceholderOrValue(), this.renderInput()), /*#__PURE__*/ _reactDefault.default.createElement(IndicatorsContainer, _extendsDefault.default({
                }, commonProps, {
                    isDisabled: isDisabled
                }), this.renderClearIndicator(), this.renderLoadingIndicator(), this.renderIndicatorSeparator(), this.renderDropdownIndicator())), this.renderMenu(), this.renderFormField()));
            }
        }
    ], [
        {
            key: "getDerivedStateFromProps",
            value: function getDerivedStateFromProps(props, state) {
                var prevProps = state.prevProps, clearFocusValueOnUpdate = state.clearFocusValueOnUpdate, inputIsHiddenAfterUpdate = state.inputIsHiddenAfterUpdate;
                var options = props.options, value = props.value, menuIsOpen = props.menuIsOpen, inputValue = props.inputValue;
                var newMenuOptionsState = {
                };
                if (prevProps && (value !== prevProps.value || options !== prevProps.options || menuIsOpen !== prevProps.menuIsOpen || inputValue !== prevProps.inputValue)) {
                    var selectValue = _index4Bd03571EsmJs.E(value);
                    var focusableOptions = menuIsOpen ? buildFocusableOptions(props, selectValue) : [];
                    var focusedValue = clearFocusValueOnUpdate ? getNextFocusedValue(state, selectValue) : null;
                    var focusedOption = getNextFocusedOption(state, focusableOptions);
                    newMenuOptionsState = {
                        selectValue: selectValue,
                        focusedOption: focusedOption,
                        focusedValue: focusedValue,
                        clearFocusValueOnUpdate: false
                    };
                } // some updates should toggle the state of the input visibility
                var newInputIsHiddenState = inputIsHiddenAfterUpdate != null && props !== prevProps ? {
                    inputIsHidden: inputIsHiddenAfterUpdate,
                    inputIsHiddenAfterUpdate: undefined
                } : {
                };
                return _index4Bd03571EsmJs.a(_index4Bd03571EsmJs.a(_index4Bd03571EsmJs.a({
                }, newMenuOptionsState), newInputIsHiddenState), {
                }, {
                    prevProps: props
                });
            }
        }
    ]);
    return Select2;
}(_react.Component);
Select1.defaultProps = defaultProps;

},{"@babel/runtime/helpers/esm/extends":"6kJrr","./index-4bd03571.esm.js":"hhkYp","@babel/runtime/helpers/esm/classCallCheck":"kcrhl","@babel/runtime/helpers/esm/createClass":"bETt6","@babel/runtime/helpers/esm/inherits":"1ybWu","@babel/runtime/helpers/esm/toConsumableArray":"1YmTR","react":"bE4sN","@emotion/react":"gigaz","memoize-one":"ikgKw","@babel/runtime/helpers/esm/objectWithoutProperties":"hRPaM","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"6kJrr":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _extends() {
    _extends = Object.assign || function(target) {
        for(var i = 1; i < arguments.length; i++){
            var source = arguments[i];
            for(var key in source)if (Object.prototype.hasOwnProperty.call(source, key)) target[key] = source[key];
        }
        return target;
    };
    return _extends.apply(this, arguments);
}
exports.default = _extends;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"hhkYp":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "A", ()=>isMobileDevice
);
parcelHelpers.export(exports, "B", ()=>classNames
);
parcelHelpers.export(exports, "C", ()=>defaultComponents
);
parcelHelpers.export(exports, "D", ()=>isDocumentElement
);
parcelHelpers.export(exports, "E", ()=>cleanValue
);
parcelHelpers.export(exports, "F", ()=>scrollIntoView
);
parcelHelpers.export(exports, "G", ()=>noop
);
parcelHelpers.export(exports, "H", ()=>handleInputChange
);
parcelHelpers.export(exports, "M", ()=>MenuPlacer1
);
parcelHelpers.export(exports, "_", ()=>_createSuper
);
parcelHelpers.export(exports, "a", ()=>_objectSpread2
);
parcelHelpers.export(exports, "b", ()=>clearIndicatorCSS
);
parcelHelpers.export(exports, "c", ()=>components
);
parcelHelpers.export(exports, "d", ()=>containerCSS
);
parcelHelpers.export(exports, "e", ()=>css
);
parcelHelpers.export(exports, "f", ()=>dropdownIndicatorCSS
);
parcelHelpers.export(exports, "g", ()=>groupCSS
);
parcelHelpers.export(exports, "h", ()=>groupHeadingCSS
);
parcelHelpers.export(exports, "i", ()=>indicatorsContainerCSS
);
parcelHelpers.export(exports, "j", ()=>indicatorSeparatorCSS
);
parcelHelpers.export(exports, "k", ()=>inputCSS
);
parcelHelpers.export(exports, "l", ()=>loadingIndicatorCSS
);
parcelHelpers.export(exports, "m", ()=>loadingMessageCSS
);
parcelHelpers.export(exports, "n", ()=>menuCSS
);
parcelHelpers.export(exports, "o", ()=>menuListCSS
);
parcelHelpers.export(exports, "p", ()=>menuPortalCSS
);
parcelHelpers.export(exports, "q", ()=>multiValueCSS
);
parcelHelpers.export(exports, "r", ()=>multiValueLabelCSS
);
parcelHelpers.export(exports, "s", ()=>supportsPassiveEvents
);
parcelHelpers.export(exports, "t", ()=>multiValueRemoveCSS
);
parcelHelpers.export(exports, "u", ()=>noOptionsMessageCSS
);
parcelHelpers.export(exports, "v", ()=>optionCSS
);
parcelHelpers.export(exports, "w", ()=>placeholderCSS
);
parcelHelpers.export(exports, "x", ()=>css$1
);
parcelHelpers.export(exports, "y", ()=>valueContainerCSS
);
parcelHelpers.export(exports, "z", ()=>isTouchCapable
);
var _extends = require("@babel/runtime/helpers/esm/extends");
var _extendsDefault = parcelHelpers.interopDefault(_extends);
var _react = require("@emotion/react");
var _taggedTemplateLiteral = require("@babel/runtime/helpers/esm/taggedTemplateLiteral");
var _taggedTemplateLiteralDefault = parcelHelpers.interopDefault(_taggedTemplateLiteral);
var _objectWithoutProperties = require("@babel/runtime/helpers/esm/objectWithoutProperties");
var _objectWithoutPropertiesDefault = parcelHelpers.interopDefault(_objectWithoutProperties);
var _typeof = require("@babel/runtime/helpers/esm/typeof");
var _typeofDefault = parcelHelpers.interopDefault(_typeof);
var _reactInputAutosize = require("react-input-autosize");
var _reactInputAutosizeDefault = parcelHelpers.interopDefault(_reactInputAutosize);
var _classCallCheck = require("@babel/runtime/helpers/esm/classCallCheck");
var _classCallCheckDefault = parcelHelpers.interopDefault(_classCallCheck);
var _createClass = require("@babel/runtime/helpers/esm/createClass");
var _createClassDefault = parcelHelpers.interopDefault(_createClass);
var _inherits = require("@babel/runtime/helpers/esm/inherits");
var _inheritsDefault = parcelHelpers.interopDefault(_inherits);
var _defineProperty = require("@babel/runtime/helpers/esm/defineProperty");
var _definePropertyDefault = parcelHelpers.interopDefault(_defineProperty);
var _react1 = require("react");
var _reactDom = require("react-dom");
function _defineProperty1(obj, key, value) {
    if (key in obj) Object.defineProperty(obj, key, {
        value: value,
        enumerable: true,
        configurable: true,
        writable: true
    });
    else obj[key] = value;
    return obj;
}
function ownKeys(object, enumerableOnly) {
    var keys = Object.keys(object);
    if (Object.getOwnPropertySymbols) {
        var symbols = Object.getOwnPropertySymbols(object);
        if (enumerableOnly) symbols = symbols.filter(function(sym) {
            return Object.getOwnPropertyDescriptor(object, sym).enumerable;
        });
        keys.push.apply(keys, symbols);
    }
    return keys;
}
function _objectSpread2(target) {
    for(var i = 1; i < arguments.length; i++){
        var source = arguments[i] != null ? arguments[i] : {
        };
        if (i % 2) ownKeys(Object(source), true).forEach(function(key) {
            _defineProperty1(target, key, source[key]);
        });
        else if (Object.getOwnPropertyDescriptors) Object.defineProperties(target, Object.getOwnPropertyDescriptors(source));
        else ownKeys(Object(source)).forEach(function(key) {
            Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
        });
    }
    return target;
}
function _getPrototypeOf(o) {
    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf1(o1) {
        return o1.__proto__ || Object.getPrototypeOf(o1);
    };
    return _getPrototypeOf(o);
}
function _isNativeReflectConstruct() {
    if (typeof Reflect === "undefined" || !Reflect.construct) return false;
    if (Reflect.construct.sham) return false;
    if (typeof Proxy === "function") return true;
    try {
        Date.prototype.toString.call(Reflect.construct(Date, [], function() {
        }));
        return true;
    } catch (e) {
        return false;
    }
}
function _assertThisInitialized(self) {
    if (self === void 0) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    return self;
}
function _possibleConstructorReturn(self, call) {
    if (call && (typeof call === "object" || typeof call === "function")) return call;
    return _assertThisInitialized(self);
}
function _createSuper(Derived) {
    var hasNativeReflectConstruct = _isNativeReflectConstruct();
    return function _createSuperInternal() {
        var Super = _getPrototypeOf(Derived), result;
        if (hasNativeReflectConstruct) {
            var NewTarget = _getPrototypeOf(this).constructor;
            result = Reflect.construct(Super, arguments, NewTarget);
        } else result = Super.apply(this, arguments);
        return _possibleConstructorReturn(this, result);
    };
}
// ==============================
// NO OP
// ==============================
var noop = function noop1() {
};
// Class Name Prefixer
// ==============================
/**
 String representation of component state for styling with class names.

 Expects an array of strings OR a string/object pair:
 - className(['comp', 'comp-arg', 'comp-arg-2'])
   @returns 'react-select__comp react-select__comp-arg react-select__comp-arg-2'
 - className('comp', { some: true, state: false })
   @returns 'react-select__comp react-select__comp--some'
*/ function applyPrefixToName(prefix, name) {
    if (!name) return prefix;
    else if (name[0] === '-') return prefix + name;
    else return prefix + '__' + name;
}
function classNames(prefix, state, className) {
    var arr = [
        className
    ];
    if (state && prefix) {
        for(var key in state)if (state.hasOwnProperty(key) && state[key]) arr.push("".concat(applyPrefixToName(prefix, key)));
    }
    return arr.filter(function(i) {
        return i;
    }).map(function(i) {
        return String(i).trim();
    }).join(' ');
} // ==============================
// Clean Value
// ==============================
var cleanValue = function cleanValue1(value) {
    if (Array.isArray(value)) return value.filter(Boolean);
    if (_typeofDefault.default(value) === 'object' && value !== null) return [
        value
    ];
    return [];
}; // ==============================
// Clean Common Props
// ==============================
var cleanCommonProps = function cleanCommonProps1(props) {
    //className
    props.className;
    props.clearValue;
    props.cx;
    props.getStyles;
    props.getValue;
    props.hasValue;
    props.isMulti;
    props.isRtl;
    props.options;
    props.selectOption;
    props.selectProps;
    props.setValue;
    props.theme;
    var innerProps = _objectWithoutPropertiesDefault.default(props, [
        "className",
        "clearValue",
        "cx",
        "getStyles",
        "getValue",
        "hasValue",
        "isMulti",
        "isRtl",
        "options",
        "selectOption",
        "selectProps",
        "setValue",
        "theme"
    ]);
    return _objectSpread2({
    }, innerProps);
}; // ==============================
// Handle Input Change
// ==============================
function handleInputChange(inputValue, actionMeta, onInputChange) {
    if (onInputChange) {
        var newValue = onInputChange(inputValue, actionMeta);
        if (typeof newValue === 'string') return newValue;
    }
    return inputValue;
} // ==============================
// Scroll Helpers
// ==============================
function isDocumentElement(el) {
    return [
        document.documentElement,
        document.body,
        window
    ].indexOf(el) > -1;
} // Normalized Scroll Top
// ------------------------------
function getScrollTop(el) {
    if (isDocumentElement(el)) return window.pageYOffset;
    return el.scrollTop;
}
function scrollTo(el, top) {
    // with a scroll distance, we perform scroll on the element
    if (isDocumentElement(el)) {
        window.scrollTo(0, top);
        return;
    }
    el.scrollTop = top;
} // Get Scroll Parent
// ------------------------------
function getScrollParent(element) {
    var style = getComputedStyle(element);
    var excludeStaticParent = style.position === 'absolute';
    var overflowRx = /(auto|scroll)/;
    var docEl = document.documentElement; // suck it, flow...
    if (style.position === 'fixed') return docEl;
    for(var parent = element; parent = parent.parentElement;){
        style = getComputedStyle(parent);
        if (excludeStaticParent && style.position === 'static') continue;
        if (overflowRx.test(style.overflow + style.overflowY + style.overflowX)) return parent;
    }
    return docEl;
} // Animated Scroll To
// ------------------------------
/**
  @param t: time (elapsed)
  @param b: initial value
  @param c: amount of change
  @param d: duration
*/ function easeOutCubic(t, b, c, d) {
    return c * ((t = t / d - 1) * t * t + 1) + b;
}
function animatedScrollTo(element, to) {
    var duration = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 200;
    var callback = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : noop;
    var start = getScrollTop(element);
    var change = to - start;
    var increment = 10;
    var currentTime = 0;
    function animateScroll() {
        currentTime += increment;
        var val = easeOutCubic(currentTime, start, change, duration);
        scrollTo(element, val);
        if (currentTime < duration) window.requestAnimationFrame(animateScroll);
        else callback(element);
    }
    animateScroll();
} // Scroll Into View
// ------------------------------
function scrollIntoView(menuEl, focusedEl) {
    var menuRect = menuEl.getBoundingClientRect();
    var focusedRect = focusedEl.getBoundingClientRect();
    var overScroll = focusedEl.offsetHeight / 3;
    if (focusedRect.bottom + overScroll > menuRect.bottom) scrollTo(menuEl, Math.min(focusedEl.offsetTop + focusedEl.clientHeight - menuEl.offsetHeight + overScroll, menuEl.scrollHeight));
    else if (focusedRect.top - overScroll < menuRect.top) scrollTo(menuEl, Math.max(focusedEl.offsetTop - overScroll, 0));
} // ==============================
// Get bounding client object
// ==============================
// cannot get keys using array notation with DOMRect
function getBoundingClientObj(element) {
    var rect = element.getBoundingClientRect();
    return {
        bottom: rect.bottom,
        height: rect.height,
        left: rect.left,
        right: rect.right,
        top: rect.top,
        width: rect.width
    };
}
// Touch Capability Detector
// ==============================
function isTouchCapable() {
    try {
        document.createEvent('TouchEvent');
        return true;
    } catch (e) {
        return false;
    }
} // ==============================
// Mobile Device Detector
// ==============================
function isMobileDevice() {
    try {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    } catch (e) {
        return false;
    }
} // ==============================
// Passive Event Detector
// ==============================
// https://github.com/rafgraph/detect-it/blob/main/src/index.ts#L19-L36
var passiveOptionAccessed = false;
var options = {
    get passive () {
        return passiveOptionAccessed = true;
    }
}; // check for SSR
var w = typeof window !== 'undefined' ? window : {
};
if (w.addEventListener && w.removeEventListener) {
    w.addEventListener('p', noop, options);
    w.removeEventListener('p', noop, false);
}
var supportsPassiveEvents = passiveOptionAccessed;
function getMenuPlacement(_ref) {
    var maxHeight = _ref.maxHeight, menuEl = _ref.menuEl, minHeight = _ref.minHeight, placement = _ref.placement, shouldScroll = _ref.shouldScroll, isFixedPosition = _ref.isFixedPosition, theme = _ref.theme;
    var spacing = theme.spacing;
    var scrollParent = getScrollParent(menuEl);
    var defaultState = {
        placement: 'bottom',
        maxHeight: maxHeight
    }; // something went wrong, return default state
    if (!menuEl || !menuEl.offsetParent) return defaultState; // we can't trust `scrollParent.scrollHeight` --> it may increase when
    // the menu is rendered
    var _scrollParent$getBoun = scrollParent.getBoundingClientRect(), scrollHeight = _scrollParent$getBoun.height;
    var _menuEl$getBoundingCl = menuEl.getBoundingClientRect(), menuBottom = _menuEl$getBoundingCl.bottom, menuHeight = _menuEl$getBoundingCl.height, menuTop = _menuEl$getBoundingCl.top;
    var _menuEl$offsetParent$ = menuEl.offsetParent.getBoundingClientRect(), containerTop = _menuEl$offsetParent$.top;
    var viewHeight = window.innerHeight;
    var scrollTop = getScrollTop(scrollParent);
    var marginBottom = parseInt(getComputedStyle(menuEl).marginBottom, 10);
    var marginTop = parseInt(getComputedStyle(menuEl).marginTop, 10);
    var viewSpaceAbove = containerTop - marginTop;
    var viewSpaceBelow = viewHeight - menuTop;
    var scrollSpaceAbove = viewSpaceAbove + scrollTop;
    var scrollSpaceBelow = scrollHeight - scrollTop - menuTop;
    var scrollDown = menuBottom - viewHeight + scrollTop + marginBottom;
    var scrollUp = scrollTop + menuTop - marginTop;
    var scrollDuration = 160;
    switch(placement){
        case 'auto':
        case 'bottom':
            // 1: the menu will fit, do nothing
            if (viewSpaceBelow >= menuHeight) return {
                placement: 'bottom',
                maxHeight: maxHeight
            };
             // 2: the menu will fit, if scrolled
            if (scrollSpaceBelow >= menuHeight && !isFixedPosition) {
                if (shouldScroll) animatedScrollTo(scrollParent, scrollDown, scrollDuration);
                return {
                    placement: 'bottom',
                    maxHeight: maxHeight
                };
            } // 3: the menu will fit, if constrained
            if (!isFixedPosition && scrollSpaceBelow >= minHeight || isFixedPosition && viewSpaceBelow >= minHeight) {
                if (shouldScroll) animatedScrollTo(scrollParent, scrollDown, scrollDuration);
                 // we want to provide as much of the menu as possible to the user,
                // so give them whatever is available below rather than the minHeight.
                var constrainedHeight = isFixedPosition ? viewSpaceBelow - marginBottom : scrollSpaceBelow - marginBottom;
                return {
                    placement: 'bottom',
                    maxHeight: constrainedHeight
                };
            } // 4. Forked beviour when there isn't enough space below
            // AUTO: flip the menu, render above
            if (placement === 'auto' || isFixedPosition) {
                // may need to be constrained after flipping
                var _constrainedHeight = maxHeight;
                var spaceAbove = isFixedPosition ? viewSpaceAbove : scrollSpaceAbove;
                if (spaceAbove >= minHeight) _constrainedHeight = Math.min(spaceAbove - marginBottom - spacing.controlHeight, maxHeight);
                return {
                    placement: 'top',
                    maxHeight: _constrainedHeight
                };
            } // BOTTOM: allow browser to increase scrollable area and immediately set scroll
            if (placement === 'bottom') {
                if (shouldScroll) scrollTo(scrollParent, scrollDown);
                return {
                    placement: 'bottom',
                    maxHeight: maxHeight
                };
            }
            break;
        case 'top':
            // 1: the menu will fit, do nothing
            if (viewSpaceAbove >= menuHeight) return {
                placement: 'top',
                maxHeight: maxHeight
            };
             // 2: the menu will fit, if scrolled
            if (scrollSpaceAbove >= menuHeight && !isFixedPosition) {
                if (shouldScroll) animatedScrollTo(scrollParent, scrollUp, scrollDuration);
                return {
                    placement: 'top',
                    maxHeight: maxHeight
                };
            } // 3: the menu will fit, if constrained
            if (!isFixedPosition && scrollSpaceAbove >= minHeight || isFixedPosition && viewSpaceAbove >= minHeight) {
                var _constrainedHeight2 = maxHeight; // we want to provide as much of the menu as possible to the user,
                // so give them whatever is available below rather than the minHeight.
                if (!isFixedPosition && scrollSpaceAbove >= minHeight || isFixedPosition && viewSpaceAbove >= minHeight) _constrainedHeight2 = isFixedPosition ? viewSpaceAbove - marginTop : scrollSpaceAbove - marginTop;
                if (shouldScroll) animatedScrollTo(scrollParent, scrollUp, scrollDuration);
                return {
                    placement: 'top',
                    maxHeight: _constrainedHeight2
                };
            } // 4. not enough space, the browser WILL NOT increase scrollable area when
            // absolutely positioned element rendered above the viewport (only below).
            // Flip the menu, render below
            return {
                placement: 'bottom',
                maxHeight: maxHeight
            };
        default:
            throw new Error("Invalid placement provided \"".concat(placement, "\"."));
    } // fulfil contract with flow: implicit return value of undefined
    return defaultState;
} // Menu Component
// ------------------------------
function alignToControl(placement) {
    var placementToCSSProp = {
        bottom: 'top',
        top: 'bottom'
    };
    return placement ? placementToCSSProp[placement] : 'bottom';
}
var coercePlacement = function coercePlacement1(p) {
    return p === 'auto' ? 'bottom' : p;
};
var menuCSS = function menuCSS1(_ref2) {
    var _ref3;
    var placement = _ref2.placement, _ref2$theme = _ref2.theme, borderRadius = _ref2$theme.borderRadius, spacing = _ref2$theme.spacing, colors = _ref2$theme.colors;
    return _ref3 = {
        label: 'menu'
    }, _definePropertyDefault.default(_ref3, alignToControl(placement), '100%'), _definePropertyDefault.default(_ref3, "backgroundColor", colors.neutral0), _definePropertyDefault.default(_ref3, "borderRadius", borderRadius), _definePropertyDefault.default(_ref3, "boxShadow", '0 0 0 1px hsla(0, 0%, 0%, 0.1), 0 4px 11px hsla(0, 0%, 0%, 0.1)'), _definePropertyDefault.default(_ref3, "marginBottom", spacing.menuGutter), _definePropertyDefault.default(_ref3, "marginTop", spacing.menuGutter), _definePropertyDefault.default(_ref3, "position", 'absolute'), _definePropertyDefault.default(_ref3, "width", '100%'), _definePropertyDefault.default(_ref3, "zIndex", 1), _ref3;
};
var PortalPlacementContext = /*#__PURE__*/ _react1.createContext({
    getPortalPlacement: null
}); // NOTE: internal only
var MenuPlacer1 = /*#__PURE__*/ function(_Component) {
    _inheritsDefault.default(MenuPlacer2, _Component);
    var _super = _createSuper(MenuPlacer2);
    function MenuPlacer2() {
        var _this;
        _classCallCheckDefault.default(this, MenuPlacer2);
        for(var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++)args[_key] = arguments[_key];
        _this = _super.call.apply(_super, [
            this
        ].concat(args));
        _this.state = {
            maxHeight: _this.props.maxMenuHeight,
            placement: null
        };
        _this.getPlacement = function(ref) {
            var _this$props = _this.props, minMenuHeight = _this$props.minMenuHeight, maxMenuHeight = _this$props.maxMenuHeight, menuPlacement = _this$props.menuPlacement, menuPosition = _this$props.menuPosition, menuShouldScrollIntoView = _this$props.menuShouldScrollIntoView, theme = _this$props.theme;
            if (!ref) return; // DO NOT scroll if position is fixed
            var isFixedPosition = menuPosition === 'fixed';
            var shouldScroll = menuShouldScrollIntoView && !isFixedPosition;
            var state = getMenuPlacement({
                maxHeight: maxMenuHeight,
                menuEl: ref,
                minHeight: minMenuHeight,
                placement: menuPlacement,
                shouldScroll: shouldScroll,
                isFixedPosition: isFixedPosition,
                theme: theme
            });
            var getPortalPlacement = _this.context.getPortalPlacement;
            if (getPortalPlacement) getPortalPlacement(state);
            _this.setState(state);
        };
        _this.getUpdatedProps = function() {
            var menuPlacement = _this.props.menuPlacement;
            var placement = _this.state.placement || coercePlacement(menuPlacement);
            return _objectSpread2(_objectSpread2({
            }, _this.props), {
            }, {
                placement: placement,
                maxHeight: _this.state.maxHeight
            });
        };
        return _this;
    }
    _createClassDefault.default(MenuPlacer2, [
        {
            key: "render",
            value: function render() {
                var children = this.props.children;
                return children({
                    ref: this.getPlacement,
                    placerProps: this.getUpdatedProps()
                });
            }
        }
    ]);
    return MenuPlacer2;
}(_react1.Component);
MenuPlacer1.contextType = PortalPlacementContext;
var Menu = function Menu1(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, innerRef = props.innerRef, innerProps = props.innerProps;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('menu', props),
        className: cx({
            menu: true
        }, className),
        ref: innerRef
    }, innerProps), children);
};
// Menu List
// ==============================
var menuListCSS = function menuListCSS1(_ref4) {
    var maxHeight = _ref4.maxHeight, baseUnit = _ref4.theme.spacing.baseUnit;
    return {
        maxHeight: maxHeight,
        overflowY: 'auto',
        paddingBottom: baseUnit,
        paddingTop: baseUnit,
        position: 'relative',
        // required for offset[Height, Top] > keyboard scroll
        WebkitOverflowScrolling: 'touch'
    };
};
var MenuList = function MenuList1(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, innerProps = props.innerProps, innerRef = props.innerRef, isMulti = props.isMulti;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('menuList', props),
        className: cx({
            'menu-list': true,
            'menu-list--is-multi': isMulti
        }, className),
        ref: innerRef
    }, innerProps), children);
}; // ==============================
// Menu Notices
// ==============================
var noticeCSS = function noticeCSS1(_ref5) {
    var _ref5$theme = _ref5.theme, baseUnit = _ref5$theme.spacing.baseUnit, colors = _ref5$theme.colors;
    return {
        color: colors.neutral40,
        padding: "".concat(baseUnit * 2, "px ").concat(baseUnit * 3, "px"),
        textAlign: 'center'
    };
};
var noOptionsMessageCSS = noticeCSS;
var loadingMessageCSS = noticeCSS;
var NoOptionsMessage = function NoOptionsMessage1(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, innerProps = props.innerProps;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('noOptionsMessage', props),
        className: cx({
            'menu-notice': true,
            'menu-notice--no-options': true
        }, className)
    }, innerProps), children);
};
NoOptionsMessage.defaultProps = {
    children: 'No options'
};
var LoadingMessage = function LoadingMessage1(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, innerProps = props.innerProps;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('loadingMessage', props),
        className: cx({
            'menu-notice': true,
            'menu-notice--loading': true
        }, className)
    }, innerProps), children);
};
LoadingMessage.defaultProps = {
    children: 'Loading...'
}; // ==============================
// Menu Portal
// ==============================
var menuPortalCSS = function menuPortalCSS1(_ref6) {
    var rect = _ref6.rect, offset = _ref6.offset, position = _ref6.position;
    return {
        left: rect.left,
        position: position,
        top: offset,
        width: rect.width,
        zIndex: 1
    };
};
var MenuPortal1 = /*#__PURE__*/ function(_Component2) {
    _inheritsDefault.default(MenuPortal2, _Component2);
    var _super2 = _createSuper(MenuPortal2);
    function MenuPortal2() {
        var _this2;
        _classCallCheckDefault.default(this, MenuPortal2);
        for(var _len2 = arguments.length, args = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++)args[_key2] = arguments[_key2];
        _this2 = _super2.call.apply(_super2, [
            this
        ].concat(args));
        _this2.state = {
            placement: null
        };
        _this2.getPortalPlacement = function(_ref7) {
            var placement = _ref7.placement;
            var initialPlacement = coercePlacement(_this2.props.menuPlacement); // avoid re-renders if the placement has not changed
            if (placement !== initialPlacement) _this2.setState({
                placement: placement
            });
        };
        return _this2;
    }
    _createClassDefault.default(MenuPortal2, [
        {
            key: "render",
            value: function render() {
                var _this$props2 = this.props, appendTo = _this$props2.appendTo, children = _this$props2.children, className = _this$props2.className, controlElement = _this$props2.controlElement, cx = _this$props2.cx, innerProps = _this$props2.innerProps, menuPlacement = _this$props2.menuPlacement, position = _this$props2.menuPosition, getStyles = _this$props2.getStyles;
                var isFixed = position === 'fixed'; // bail early if required elements aren't present
                if (!appendTo && !isFixed || !controlElement) return null;
                var placement = this.state.placement || coercePlacement(menuPlacement);
                var rect = getBoundingClientObj(controlElement);
                var scrollDistance = isFixed ? 0 : window.pageYOffset;
                var offset = rect[placement] + scrollDistance;
                var state = {
                    offset: offset,
                    position: position,
                    rect: rect
                }; // same wrapper element whether fixed or portalled
                var menuWrapper = _react.jsx("div", _extendsDefault.default({
                    css: getStyles('menuPortal', state),
                    className: cx({
                        'menu-portal': true
                    }, className)
                }, innerProps), children);
                return _react.jsx(PortalPlacementContext.Provider, {
                    value: {
                        getPortalPlacement: this.getPortalPlacement
                    }
                }, appendTo ? /*#__PURE__*/ _reactDom.createPortal(menuWrapper, appendTo) : menuWrapper);
            }
        }
    ]);
    return MenuPortal2;
}(_react1.Component);
var containerCSS = function containerCSS1(_ref) {
    var isDisabled = _ref.isDisabled, isRtl = _ref.isRtl;
    return {
        label: 'container',
        direction: isRtl ? 'rtl' : null,
        pointerEvents: isDisabled ? 'none' : null,
        // cancel mouse events when disabled
        position: 'relative'
    };
};
var SelectContainer = function SelectContainer1(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, innerProps = props.innerProps, isDisabled = props.isDisabled, isRtl = props.isRtl;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('container', props),
        className: cx({
            '--is-disabled': isDisabled,
            '--is-rtl': isRtl
        }, className)
    }, innerProps), children);
}; // ==============================
// Value Container
// ==============================
var valueContainerCSS = function valueContainerCSS1(_ref2) {
    var spacing = _ref2.theme.spacing;
    return {
        alignItems: 'center',
        display: 'flex',
        flex: 1,
        flexWrap: 'wrap',
        padding: "".concat(spacing.baseUnit / 2, "px ").concat(spacing.baseUnit * 2, "px"),
        WebkitOverflowScrolling: 'touch',
        position: 'relative',
        overflow: 'hidden'
    };
};
var ValueContainer = function ValueContainer1(props) {
    var children = props.children, className = props.className, cx = props.cx, innerProps = props.innerProps, isMulti = props.isMulti, getStyles = props.getStyles, hasValue = props.hasValue;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('valueContainer', props),
        className: cx({
            'value-container': true,
            'value-container--is-multi': isMulti,
            'value-container--has-value': hasValue
        }, className)
    }, innerProps), children);
}; // ==============================
// Indicator Container
// ==============================
var indicatorsContainerCSS = function indicatorsContainerCSS1() {
    return {
        alignItems: 'center',
        alignSelf: 'stretch',
        display: 'flex',
        flexShrink: 0
    };
};
var IndicatorsContainer = function IndicatorsContainer1(props) {
    var children = props.children, className = props.className, cx = props.cx, innerProps = props.innerProps, getStyles = props.getStyles;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('indicatorsContainer', props),
        className: cx({
            indicators: true
        }, className)
    }, innerProps), children);
};
var _templateObject;
function _EMOTION_STRINGIFIED_CSS_ERROR__() {
    return "You have tried to stringify object returned from `css` function. It isn't supposed to be used directly (e.g. as value of the `className` prop), but rather handed to emotion so it can handle it (e.g. as value of `css` prop).";
}
var _ref2 = {
    name: "tj5bde-Svg",
    styles: "display:inline-block;fill:currentColor;line-height:1;stroke:currentColor;stroke-width:0;label:Svg;",
    map: "/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImluZGljYXRvcnMuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBa0JJIiwiZmlsZSI6ImluZGljYXRvcnMuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBAZmxvd1xuLyoqIEBqc3gganN4ICovXG5pbXBvcnQgeyB0eXBlIE5vZGUgfSBmcm9tICdyZWFjdCc7XG5pbXBvcnQgeyBqc3gsIGtleWZyYW1lcyB9IGZyb20gJ0BlbW90aW9uL3JlYWN0JztcblxuaW1wb3J0IHR5cGUgeyBDb21tb25Qcm9wcywgVGhlbWUgfSBmcm9tICcuLi90eXBlcyc7XG5cbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gRHJvcGRvd24gJiBDbGVhciBJY29uc1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbmNvbnN0IFN2ZyA9ICh7IHNpemUsIC4uLnByb3BzIH06IHsgc2l6ZTogbnVtYmVyIH0pID0+IChcbiAgPHN2Z1xuICAgIGhlaWdodD17c2l6ZX1cbiAgICB3aWR0aD17c2l6ZX1cbiAgICB2aWV3Qm94PVwiMCAwIDIwIDIwXCJcbiAgICBhcmlhLWhpZGRlbj1cInRydWVcIlxuICAgIGZvY3VzYWJsZT1cImZhbHNlXCJcbiAgICBjc3M9e3tcbiAgICAgIGRpc3BsYXk6ICdpbmxpbmUtYmxvY2snLFxuICAgICAgZmlsbDogJ2N1cnJlbnRDb2xvcicsXG4gICAgICBsaW5lSGVpZ2h0OiAxLFxuICAgICAgc3Ryb2tlOiAnY3VycmVudENvbG9yJyxcbiAgICAgIHN0cm9rZVdpZHRoOiAwLFxuICAgIH19XG4gICAgey4uLnByb3BzfVxuICAvPlxuKTtcblxuZXhwb3J0IGNvbnN0IENyb3NzSWNvbiA9IChwcm9wczogYW55KSA9PiAoXG4gIDxTdmcgc2l6ZT17MjB9IHsuLi5wcm9wc30+XG4gICAgPHBhdGggZD1cIk0xNC4zNDggMTQuODQ5Yy0wLjQ2OSAwLjQ2OS0xLjIyOSAwLjQ2OS0xLjY5NyAwbC0yLjY1MS0zLjAzMC0yLjY1MSAzLjAyOWMtMC40NjkgMC40NjktMS4yMjkgMC40NjktMS42OTcgMC0wLjQ2OS0wLjQ2OS0wLjQ2OS0xLjIyOSAwLTEuNjk3bDIuNzU4LTMuMTUtMi43NTktMy4xNTJjLTAuNDY5LTAuNDY5LTAuNDY5LTEuMjI4IDAtMS42OTdzMS4yMjgtMC40NjkgMS42OTcgMGwyLjY1MiAzLjAzMSAyLjY1MS0zLjAzMWMwLjQ2OS0wLjQ2OSAxLjIyOC0wLjQ2OSAxLjY5NyAwczAuNDY5IDEuMjI5IDAgMS42OTdsLTIuNzU4IDMuMTUyIDIuNzU4IDMuMTVjMC40NjkgMC40NjkgMC40NjkgMS4yMjkgMCAxLjY5OHpcIiAvPlxuICA8L1N2Zz5cbik7XG5leHBvcnQgY29uc3QgRG93bkNoZXZyb24gPSAocHJvcHM6IGFueSkgPT4gKFxuICA8U3ZnIHNpemU9ezIwfSB7Li4ucHJvcHN9PlxuICAgIDxwYXRoIGQ9XCJNNC41MTYgNy41NDhjMC40MzYtMC40NDYgMS4wNDMtMC40ODEgMS41NzYgMGwzLjkwOCAzLjc0NyAzLjkwOC0zLjc0N2MwLjUzMy0wLjQ4MSAxLjE0MS0wLjQ0NiAxLjU3NCAwIDAuNDM2IDAuNDQ1IDAuNDA4IDEuMTk3IDAgMS42MTUtMC40MDYgMC40MTgtNC42OTUgNC41MDItNC42OTUgNC41MDItMC4yMTcgMC4yMjMtMC41MDIgMC4zMzUtMC43ODcgMC4zMzVzLTAuNTctMC4xMTItMC43ODktMC4zMzVjMCAwLTQuMjg3LTQuMDg0LTQuNjk1LTQuNTAycy0wLjQzNi0xLjE3IDAtMS42MTV6XCIgLz5cbiAgPC9Tdmc+XG4pO1xuXG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbi8vIERyb3Bkb3duICYgQ2xlYXIgQnV0dG9uc1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbmV4cG9ydCB0eXBlIEluZGljYXRvclByb3BzID0gQ29tbW9uUHJvcHMgJiB7XG4gIC8qKiBUaGUgY2hpbGRyZW4gdG8gYmUgcmVuZGVyZWQgaW5zaWRlIHRoZSBpbmRpY2F0b3IuICovXG4gIGNoaWxkcmVuOiBOb2RlLFxuICAvKiogUHJvcHMgdGhhdCB3aWxsIGJlIHBhc3NlZCBvbiB0byB0aGUgY2hpbGRyZW4uICovXG4gIGlubmVyUHJvcHM6IGFueSxcbiAgLyoqIFRoZSBmb2N1c2VkIHN0YXRlIG9mIHRoZSBzZWxlY3QuICovXG4gIGlzRm9jdXNlZDogYm9vbGVhbixcbiAgLyoqIFdoZXRoZXIgdGhlIHRleHQgaXMgcmlnaHQgdG8gbGVmdCAqL1xuICBpc1J0bDogYm9vbGVhbixcbn07XG5cbmNvbnN0IGJhc2VDU1MgPSAoe1xuICBpc0ZvY3VzZWQsXG4gIHRoZW1lOiB7XG4gICAgc3BhY2luZzogeyBiYXNlVW5pdCB9LFxuICAgIGNvbG9ycyxcbiAgfSxcbn06IEluZGljYXRvclByb3BzKSA9PiAoe1xuICBsYWJlbDogJ2luZGljYXRvckNvbnRhaW5lcicsXG4gIGNvbG9yOiBpc0ZvY3VzZWQgPyBjb2xvcnMubmV1dHJhbDYwIDogY29sb3JzLm5ldXRyYWwyMCxcbiAgZGlzcGxheTogJ2ZsZXgnLFxuICBwYWRkaW5nOiBiYXNlVW5pdCAqIDIsXG4gIHRyYW5zaXRpb246ICdjb2xvciAxNTBtcycsXG5cbiAgJzpob3Zlcic6IHtcbiAgICBjb2xvcjogaXNGb2N1c2VkID8gY29sb3JzLm5ldXRyYWw4MCA6IGNvbG9ycy5uZXV0cmFsNDAsXG4gIH0sXG59KTtcblxuZXhwb3J0IGNvbnN0IGRyb3Bkb3duSW5kaWNhdG9yQ1NTID0gYmFzZUNTUztcbmV4cG9ydCBjb25zdCBEcm9wZG93bkluZGljYXRvciA9IChwcm9wczogSW5kaWNhdG9yUHJvcHMpID0+IHtcbiAgY29uc3QgeyBjaGlsZHJlbiwgY2xhc3NOYW1lLCBjeCwgZ2V0U3R5bGVzLCBpbm5lclByb3BzIH0gPSBwcm9wcztcbiAgcmV0dXJuIChcbiAgICA8ZGl2XG4gICAgICBjc3M9e2dldFN0eWxlcygnZHJvcGRvd25JbmRpY2F0b3InLCBwcm9wcyl9XG4gICAgICBjbGFzc05hbWU9e2N4KFxuICAgICAgICB7XG4gICAgICAgICAgaW5kaWNhdG9yOiB0cnVlLFxuICAgICAgICAgICdkcm9wZG93bi1pbmRpY2F0b3InOiB0cnVlLFxuICAgICAgICB9LFxuICAgICAgICBjbGFzc05hbWVcbiAgICAgICl9XG4gICAgICB7Li4uaW5uZXJQcm9wc31cbiAgICA+XG4gICAgICB7Y2hpbGRyZW4gfHwgPERvd25DaGV2cm9uIC8+fVxuICAgIDwvZGl2PlxuICApO1xufTtcblxuZXhwb3J0IGNvbnN0IGNsZWFySW5kaWNhdG9yQ1NTID0gYmFzZUNTUztcbmV4cG9ydCBjb25zdCBDbGVhckluZGljYXRvciA9IChwcm9wczogSW5kaWNhdG9yUHJvcHMpID0+IHtcbiAgY29uc3QgeyBjaGlsZHJlbiwgY2xhc3NOYW1lLCBjeCwgZ2V0U3R5bGVzLCBpbm5lclByb3BzIH0gPSBwcm9wcztcbiAgcmV0dXJuIChcbiAgICA8ZGl2XG4gICAgICBjc3M9e2dldFN0eWxlcygnY2xlYXJJbmRpY2F0b3InLCBwcm9wcyl9XG4gICAgICBjbGFzc05hbWU9e2N4KFxuICAgICAgICB7XG4gICAgICAgICAgaW5kaWNhdG9yOiB0cnVlLFxuICAgICAgICAgICdjbGVhci1pbmRpY2F0b3InOiB0cnVlLFxuICAgICAgICB9LFxuICAgICAgICBjbGFzc05hbWVcbiAgICAgICl9XG4gICAgICB7Li4uaW5uZXJQcm9wc31cbiAgICA+XG4gICAgICB7Y2hpbGRyZW4gfHwgPENyb3NzSWNvbiAvPn1cbiAgICA8L2Rpdj5cbiAgKTtcbn07XG5cbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gU2VwYXJhdG9yXG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxudHlwZSBTZXBhcmF0b3JTdGF0ZSA9IHsgaXNEaXNhYmxlZDogYm9vbGVhbiB9O1xuXG5leHBvcnQgY29uc3QgaW5kaWNhdG9yU2VwYXJhdG9yQ1NTID0gKHtcbiAgaXNEaXNhYmxlZCxcbiAgdGhlbWU6IHtcbiAgICBzcGFjaW5nOiB7IGJhc2VVbml0IH0sXG4gICAgY29sb3JzLFxuICB9LFxufTogQ29tbW9uUHJvcHMgJiBTZXBhcmF0b3JTdGF0ZSkgPT4gKHtcbiAgbGFiZWw6ICdpbmRpY2F0b3JTZXBhcmF0b3InLFxuICBhbGlnblNlbGY6ICdzdHJldGNoJyxcbiAgYmFja2dyb3VuZENvbG9yOiBpc0Rpc2FibGVkID8gY29sb3JzLm5ldXRyYWwxMCA6IGNvbG9ycy5uZXV0cmFsMjAsXG4gIG1hcmdpbkJvdHRvbTogYmFzZVVuaXQgKiAyLFxuICBtYXJnaW5Ub3A6IGJhc2VVbml0ICogMixcbiAgd2lkdGg6IDEsXG59KTtcblxuZXhwb3J0IGNvbnN0IEluZGljYXRvclNlcGFyYXRvciA9IChwcm9wczogSW5kaWNhdG9yUHJvcHMpID0+IHtcbiAgY29uc3QgeyBjbGFzc05hbWUsIGN4LCBnZXRTdHlsZXMsIGlubmVyUHJvcHMgfSA9IHByb3BzO1xuICByZXR1cm4gKFxuICAgIDxzcGFuXG4gICAgICB7Li4uaW5uZXJQcm9wc31cbiAgICAgIGNzcz17Z2V0U3R5bGVzKCdpbmRpY2F0b3JTZXBhcmF0b3InLCBwcm9wcyl9XG4gICAgICBjbGFzc05hbWU9e2N4KHsgJ2luZGljYXRvci1zZXBhcmF0b3InOiB0cnVlIH0sIGNsYXNzTmFtZSl9XG4gICAgLz5cbiAgKTtcbn07XG5cbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gTG9hZGluZ1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbmNvbnN0IGxvYWRpbmdEb3RBbmltYXRpb25zID0ga2V5ZnJhbWVzYFxuICAwJSwgODAlLCAxMDAlIHsgb3BhY2l0eTogMDsgfVxuICA0MCUgeyBvcGFjaXR5OiAxOyB9XG5gO1xuXG5leHBvcnQgY29uc3QgbG9hZGluZ0luZGljYXRvckNTUyA9ICh7XG4gIGlzRm9jdXNlZCxcbiAgc2l6ZSxcbiAgdGhlbWU6IHtcbiAgICBjb2xvcnMsXG4gICAgc3BhY2luZzogeyBiYXNlVW5pdCB9LFxuICB9LFxufToge1xuICBpc0ZvY3VzZWQ6IGJvb2xlYW4sXG4gIHNpemU6IG51bWJlcixcbiAgdGhlbWU6IFRoZW1lLFxufSkgPT4gKHtcbiAgbGFiZWw6ICdsb2FkaW5nSW5kaWNhdG9yJyxcbiAgY29sb3I6IGlzRm9jdXNlZCA/IGNvbG9ycy5uZXV0cmFsNjAgOiBjb2xvcnMubmV1dHJhbDIwLFxuICBkaXNwbGF5OiAnZmxleCcsXG4gIHBhZGRpbmc6IGJhc2VVbml0ICogMixcbiAgdHJhbnNpdGlvbjogJ2NvbG9yIDE1MG1zJyxcbiAgYWxpZ25TZWxmOiAnY2VudGVyJyxcbiAgZm9udFNpemU6IHNpemUsXG4gIGxpbmVIZWlnaHQ6IDEsXG4gIG1hcmdpblJpZ2h0OiBzaXplLFxuICB0ZXh0QWxpZ246ICdjZW50ZXInLFxuICB2ZXJ0aWNhbEFsaWduOiAnbWlkZGxlJyxcbn0pO1xuXG50eXBlIERvdFByb3BzID0geyBkZWxheTogbnVtYmVyLCBvZmZzZXQ6IGJvb2xlYW4gfTtcbmNvbnN0IExvYWRpbmdEb3QgPSAoeyBkZWxheSwgb2Zmc2V0IH06IERvdFByb3BzKSA9PiAoXG4gIDxzcGFuXG4gICAgY3NzPXt7XG4gICAgICBhbmltYXRpb246IGAke2xvYWRpbmdEb3RBbmltYXRpb25zfSAxcyBlYXNlLWluLW91dCAke2RlbGF5fW1zIGluZmluaXRlO2AsXG4gICAgICBiYWNrZ3JvdW5kQ29sb3I6ICdjdXJyZW50Q29sb3InLFxuICAgICAgYm9yZGVyUmFkaXVzOiAnMWVtJyxcbiAgICAgIGRpc3BsYXk6ICdpbmxpbmUtYmxvY2snLFxuICAgICAgbWFyZ2luTGVmdDogb2Zmc2V0ID8gJzFlbScgOiBudWxsLFxuICAgICAgaGVpZ2h0OiAnMWVtJyxcbiAgICAgIHZlcnRpY2FsQWxpZ246ICd0b3AnLFxuICAgICAgd2lkdGg6ICcxZW0nLFxuICAgIH19XG4gIC8+XG4pO1xuXG5leHBvcnQgdHlwZSBMb2FkaW5nSWNvblByb3BzID0ge1xuICAvKiogUHJvcHMgdGhhdCB3aWxsIGJlIHBhc3NlZCBvbiB0byB0aGUgY2hpbGRyZW4uICovXG4gIGlubmVyUHJvcHM6IGFueSxcbiAgLyoqIFRoZSBmb2N1c2VkIHN0YXRlIG9mIHRoZSBzZWxlY3QuICovXG4gIGlzRm9jdXNlZDogYm9vbGVhbixcbiAgLyoqIFdoZXRoZXIgdGhlIHRleHQgaXMgcmlnaHQgdG8gbGVmdCAqL1xuICBpc1J0bDogYm9vbGVhbixcbn0gJiBDb21tb25Qcm9wcyAmIHtcbiAgICAvKiogU2V0IHNpemUgb2YgdGhlIGNvbnRhaW5lci4gKi9cbiAgICBzaXplOiBudW1iZXIsXG4gIH07XG5leHBvcnQgY29uc3QgTG9hZGluZ0luZGljYXRvciA9IChwcm9wczogTG9hZGluZ0ljb25Qcm9wcykgPT4ge1xuICBjb25zdCB7IGNsYXNzTmFtZSwgY3gsIGdldFN0eWxlcywgaW5uZXJQcm9wcywgaXNSdGwgfSA9IHByb3BzO1xuXG4gIHJldHVybiAoXG4gICAgPGRpdlxuICAgICAgY3NzPXtnZXRTdHlsZXMoJ2xvYWRpbmdJbmRpY2F0b3InLCBwcm9wcyl9XG4gICAgICBjbGFzc05hbWU9e2N4KFxuICAgICAgICB7XG4gICAgICAgICAgaW5kaWNhdG9yOiB0cnVlLFxuICAgICAgICAgICdsb2FkaW5nLWluZGljYXRvcic6IHRydWUsXG4gICAgICAgIH0sXG4gICAgICAgIGNsYXNzTmFtZVxuICAgICAgKX1cbiAgICAgIHsuLi5pbm5lclByb3BzfVxuICAgID5cbiAgICAgIDxMb2FkaW5nRG90IGRlbGF5PXswfSBvZmZzZXQ9e2lzUnRsfSAvPlxuICAgICAgPExvYWRpbmdEb3QgZGVsYXk9ezE2MH0gb2Zmc2V0IC8+XG4gICAgICA8TG9hZGluZ0RvdCBkZWxheT17MzIwfSBvZmZzZXQ9eyFpc1J0bH0gLz5cbiAgICA8L2Rpdj5cbiAgKTtcbn07XG5Mb2FkaW5nSW5kaWNhdG9yLmRlZmF1bHRQcm9wcyA9IHsgc2l6ZTogNCB9O1xuIl19 */",
    toString: _EMOTION_STRINGIFIED_CSS_ERROR__
};
// ==============================
// Dropdown & Clear Icons
// ==============================
var Svg = function Svg1(_ref) {
    var size = _ref.size, props = _objectWithoutPropertiesDefault.default(_ref, [
        "size"
    ]);
    return _react.jsx("svg", _extendsDefault.default({
        height: size,
        width: size,
        viewBox: "0 0 20 20",
        "aria-hidden": "true",
        focusable: "false",
        css: _ref2
    }, props));
};
var CrossIcon = function CrossIcon1(props) {
    return _react.jsx(Svg, _extendsDefault.default({
        size: 20
    }, props), _react.jsx("path", {
        d: "M14.348 14.849c-0.469 0.469-1.229 0.469-1.697 0l-2.651-3.030-2.651 3.029c-0.469 0.469-1.229 0.469-1.697 0-0.469-0.469-0.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-0.469-0.469-0.469-1.228 0-1.697s1.228-0.469 1.697 0l2.652 3.031 2.651-3.031c0.469-0.469 1.228-0.469 1.697 0s0.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c0.469 0.469 0.469 1.229 0 1.698z"
    }));
};
var DownChevron = function DownChevron1(props) {
    return _react.jsx(Svg, _extendsDefault.default({
        size: 20
    }, props), _react.jsx("path", {
        d: "M4.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.574 0 0.436 0.445 0.408 1.197 0 1.615-0.406 0.418-4.695 4.502-4.695 4.502-0.217 0.223-0.502 0.335-0.787 0.335s-0.57-0.112-0.789-0.335c0 0-4.287-4.084-4.695-4.502s-0.436-1.17 0-1.615z"
    }));
}; // ==============================
// Dropdown & Clear Buttons
// ==============================
var baseCSS = function baseCSS1(_ref3) {
    var isFocused = _ref3.isFocused, _ref3$theme = _ref3.theme, baseUnit = _ref3$theme.spacing.baseUnit, colors = _ref3$theme.colors;
    return {
        label: 'indicatorContainer',
        color: isFocused ? colors.neutral60 : colors.neutral20,
        display: 'flex',
        padding: baseUnit * 2,
        transition: 'color 150ms',
        ':hover': {
            color: isFocused ? colors.neutral80 : colors.neutral40
        }
    };
};
var dropdownIndicatorCSS = baseCSS;
var DropdownIndicator = function DropdownIndicator1(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, innerProps = props.innerProps;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('dropdownIndicator', props),
        className: cx({
            indicator: true,
            'dropdown-indicator': true
        }, className)
    }, innerProps), children || _react.jsx(DownChevron, null));
};
var clearIndicatorCSS = baseCSS;
var ClearIndicator = function ClearIndicator1(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, innerProps = props.innerProps;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('clearIndicator', props),
        className: cx({
            indicator: true,
            'clear-indicator': true
        }, className)
    }, innerProps), children || _react.jsx(CrossIcon, null));
}; // ==============================
// Separator
// ==============================
var indicatorSeparatorCSS = function indicatorSeparatorCSS1(_ref4) {
    var isDisabled = _ref4.isDisabled, _ref4$theme = _ref4.theme, baseUnit = _ref4$theme.spacing.baseUnit, colors = _ref4$theme.colors;
    return {
        label: 'indicatorSeparator',
        alignSelf: 'stretch',
        backgroundColor: isDisabled ? colors.neutral10 : colors.neutral20,
        marginBottom: baseUnit * 2,
        marginTop: baseUnit * 2,
        width: 1
    };
};
var IndicatorSeparator = function IndicatorSeparator1(props) {
    var className = props.className, cx = props.cx, getStyles = props.getStyles, innerProps = props.innerProps;
    return _react.jsx("span", _extendsDefault.default({
    }, innerProps, {
        css: getStyles('indicatorSeparator', props),
        className: cx({
            'indicator-separator': true
        }, className)
    }));
}; // ==============================
// Loading
// ==============================
var loadingDotAnimations = _react.keyframes(_templateObject || (_templateObject = _taggedTemplateLiteralDefault.default([
    "\n  0%, 80%, 100% { opacity: 0; }\n  40% { opacity: 1; }\n"
])));
var loadingIndicatorCSS = function loadingIndicatorCSS1(_ref5) {
    var isFocused = _ref5.isFocused, size = _ref5.size, _ref5$theme = _ref5.theme, colors = _ref5$theme.colors, baseUnit = _ref5$theme.spacing.baseUnit;
    return {
        label: 'loadingIndicator',
        color: isFocused ? colors.neutral60 : colors.neutral20,
        display: 'flex',
        padding: baseUnit * 2,
        transition: 'color 150ms',
        alignSelf: 'center',
        fontSize: size,
        lineHeight: 1,
        marginRight: size,
        textAlign: 'center',
        verticalAlign: 'middle'
    };
};
var LoadingDot = function LoadingDot1(_ref6) {
    var delay = _ref6.delay, offset = _ref6.offset;
    return _react.jsx("span", {
        css: /*#__PURE__*/ _react.css({
            animation: "".concat(loadingDotAnimations, " 1s ease-in-out ").concat(delay, "ms infinite;"),
            backgroundColor: 'currentColor',
            borderRadius: '1em',
            display: 'inline-block',
            marginLeft: offset ? '1em' : null,
            height: '1em',
            verticalAlign: 'top',
            width: '1em'
        }, ";label:LoadingDot;", "/*# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImluZGljYXRvcnMuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBc0xJIiwiZmlsZSI6ImluZGljYXRvcnMuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBAZmxvd1xuLyoqIEBqc3gganN4ICovXG5pbXBvcnQgeyB0eXBlIE5vZGUgfSBmcm9tICdyZWFjdCc7XG5pbXBvcnQgeyBqc3gsIGtleWZyYW1lcyB9IGZyb20gJ0BlbW90aW9uL3JlYWN0JztcblxuaW1wb3J0IHR5cGUgeyBDb21tb25Qcm9wcywgVGhlbWUgfSBmcm9tICcuLi90eXBlcyc7XG5cbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gRHJvcGRvd24gJiBDbGVhciBJY29uc1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbmNvbnN0IFN2ZyA9ICh7IHNpemUsIC4uLnByb3BzIH06IHsgc2l6ZTogbnVtYmVyIH0pID0+IChcbiAgPHN2Z1xuICAgIGhlaWdodD17c2l6ZX1cbiAgICB3aWR0aD17c2l6ZX1cbiAgICB2aWV3Qm94PVwiMCAwIDIwIDIwXCJcbiAgICBhcmlhLWhpZGRlbj1cInRydWVcIlxuICAgIGZvY3VzYWJsZT1cImZhbHNlXCJcbiAgICBjc3M9e3tcbiAgICAgIGRpc3BsYXk6ICdpbmxpbmUtYmxvY2snLFxuICAgICAgZmlsbDogJ2N1cnJlbnRDb2xvcicsXG4gICAgICBsaW5lSGVpZ2h0OiAxLFxuICAgICAgc3Ryb2tlOiAnY3VycmVudENvbG9yJyxcbiAgICAgIHN0cm9rZVdpZHRoOiAwLFxuICAgIH19XG4gICAgey4uLnByb3BzfVxuICAvPlxuKTtcblxuZXhwb3J0IGNvbnN0IENyb3NzSWNvbiA9IChwcm9wczogYW55KSA9PiAoXG4gIDxTdmcgc2l6ZT17MjB9IHsuLi5wcm9wc30+XG4gICAgPHBhdGggZD1cIk0xNC4zNDggMTQuODQ5Yy0wLjQ2OSAwLjQ2OS0xLjIyOSAwLjQ2OS0xLjY5NyAwbC0yLjY1MS0zLjAzMC0yLjY1MSAzLjAyOWMtMC40NjkgMC40NjktMS4yMjkgMC40NjktMS42OTcgMC0wLjQ2OS0wLjQ2OS0wLjQ2OS0xLjIyOSAwLTEuNjk3bDIuNzU4LTMuMTUtMi43NTktMy4xNTJjLTAuNDY5LTAuNDY5LTAuNDY5LTEuMjI4IDAtMS42OTdzMS4yMjgtMC40NjkgMS42OTcgMGwyLjY1MiAzLjAzMSAyLjY1MS0zLjAzMWMwLjQ2OS0wLjQ2OSAxLjIyOC0wLjQ2OSAxLjY5NyAwczAuNDY5IDEuMjI5IDAgMS42OTdsLTIuNzU4IDMuMTUyIDIuNzU4IDMuMTVjMC40NjkgMC40NjkgMC40NjkgMS4yMjkgMCAxLjY5OHpcIiAvPlxuICA8L1N2Zz5cbik7XG5leHBvcnQgY29uc3QgRG93bkNoZXZyb24gPSAocHJvcHM6IGFueSkgPT4gKFxuICA8U3ZnIHNpemU9ezIwfSB7Li4ucHJvcHN9PlxuICAgIDxwYXRoIGQ9XCJNNC41MTYgNy41NDhjMC40MzYtMC40NDYgMS4wNDMtMC40ODEgMS41NzYgMGwzLjkwOCAzLjc0NyAzLjkwOC0zLjc0N2MwLjUzMy0wLjQ4MSAxLjE0MS0wLjQ0NiAxLjU3NCAwIDAuNDM2IDAuNDQ1IDAuNDA4IDEuMTk3IDAgMS42MTUtMC40MDYgMC40MTgtNC42OTUgNC41MDItNC42OTUgNC41MDItMC4yMTcgMC4yMjMtMC41MDIgMC4zMzUtMC43ODcgMC4zMzVzLTAuNTctMC4xMTItMC43ODktMC4zMzVjMCAwLTQuMjg3LTQuMDg0LTQuNjk1LTQuNTAycy0wLjQzNi0xLjE3IDAtMS42MTV6XCIgLz5cbiAgPC9Tdmc+XG4pO1xuXG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cbi8vIERyb3Bkb3duICYgQ2xlYXIgQnV0dG9uc1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbmV4cG9ydCB0eXBlIEluZGljYXRvclByb3BzID0gQ29tbW9uUHJvcHMgJiB7XG4gIC8qKiBUaGUgY2hpbGRyZW4gdG8gYmUgcmVuZGVyZWQgaW5zaWRlIHRoZSBpbmRpY2F0b3IuICovXG4gIGNoaWxkcmVuOiBOb2RlLFxuICAvKiogUHJvcHMgdGhhdCB3aWxsIGJlIHBhc3NlZCBvbiB0byB0aGUgY2hpbGRyZW4uICovXG4gIGlubmVyUHJvcHM6IGFueSxcbiAgLyoqIFRoZSBmb2N1c2VkIHN0YXRlIG9mIHRoZSBzZWxlY3QuICovXG4gIGlzRm9jdXNlZDogYm9vbGVhbixcbiAgLyoqIFdoZXRoZXIgdGhlIHRleHQgaXMgcmlnaHQgdG8gbGVmdCAqL1xuICBpc1J0bDogYm9vbGVhbixcbn07XG5cbmNvbnN0IGJhc2VDU1MgPSAoe1xuICBpc0ZvY3VzZWQsXG4gIHRoZW1lOiB7XG4gICAgc3BhY2luZzogeyBiYXNlVW5pdCB9LFxuICAgIGNvbG9ycyxcbiAgfSxcbn06IEluZGljYXRvclByb3BzKSA9PiAoe1xuICBsYWJlbDogJ2luZGljYXRvckNvbnRhaW5lcicsXG4gIGNvbG9yOiBpc0ZvY3VzZWQgPyBjb2xvcnMubmV1dHJhbDYwIDogY29sb3JzLm5ldXRyYWwyMCxcbiAgZGlzcGxheTogJ2ZsZXgnLFxuICBwYWRkaW5nOiBiYXNlVW5pdCAqIDIsXG4gIHRyYW5zaXRpb246ICdjb2xvciAxNTBtcycsXG5cbiAgJzpob3Zlcic6IHtcbiAgICBjb2xvcjogaXNGb2N1c2VkID8gY29sb3JzLm5ldXRyYWw4MCA6IGNvbG9ycy5uZXV0cmFsNDAsXG4gIH0sXG59KTtcblxuZXhwb3J0IGNvbnN0IGRyb3Bkb3duSW5kaWNhdG9yQ1NTID0gYmFzZUNTUztcbmV4cG9ydCBjb25zdCBEcm9wZG93bkluZGljYXRvciA9IChwcm9wczogSW5kaWNhdG9yUHJvcHMpID0+IHtcbiAgY29uc3QgeyBjaGlsZHJlbiwgY2xhc3NOYW1lLCBjeCwgZ2V0U3R5bGVzLCBpbm5lclByb3BzIH0gPSBwcm9wcztcbiAgcmV0dXJuIChcbiAgICA8ZGl2XG4gICAgICBjc3M9e2dldFN0eWxlcygnZHJvcGRvd25JbmRpY2F0b3InLCBwcm9wcyl9XG4gICAgICBjbGFzc05hbWU9e2N4KFxuICAgICAgICB7XG4gICAgICAgICAgaW5kaWNhdG9yOiB0cnVlLFxuICAgICAgICAgICdkcm9wZG93bi1pbmRpY2F0b3InOiB0cnVlLFxuICAgICAgICB9LFxuICAgICAgICBjbGFzc05hbWVcbiAgICAgICl9XG4gICAgICB7Li4uaW5uZXJQcm9wc31cbiAgICA+XG4gICAgICB7Y2hpbGRyZW4gfHwgPERvd25DaGV2cm9uIC8+fVxuICAgIDwvZGl2PlxuICApO1xufTtcblxuZXhwb3J0IGNvbnN0IGNsZWFySW5kaWNhdG9yQ1NTID0gYmFzZUNTUztcbmV4cG9ydCBjb25zdCBDbGVhckluZGljYXRvciA9IChwcm9wczogSW5kaWNhdG9yUHJvcHMpID0+IHtcbiAgY29uc3QgeyBjaGlsZHJlbiwgY2xhc3NOYW1lLCBjeCwgZ2V0U3R5bGVzLCBpbm5lclByb3BzIH0gPSBwcm9wcztcbiAgcmV0dXJuIChcbiAgICA8ZGl2XG4gICAgICBjc3M9e2dldFN0eWxlcygnY2xlYXJJbmRpY2F0b3InLCBwcm9wcyl9XG4gICAgICBjbGFzc05hbWU9e2N4KFxuICAgICAgICB7XG4gICAgICAgICAgaW5kaWNhdG9yOiB0cnVlLFxuICAgICAgICAgICdjbGVhci1pbmRpY2F0b3InOiB0cnVlLFxuICAgICAgICB9LFxuICAgICAgICBjbGFzc05hbWVcbiAgICAgICl9XG4gICAgICB7Li4uaW5uZXJQcm9wc31cbiAgICA+XG4gICAgICB7Y2hpbGRyZW4gfHwgPENyb3NzSWNvbiAvPn1cbiAgICA8L2Rpdj5cbiAgKTtcbn07XG5cbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gU2VwYXJhdG9yXG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxudHlwZSBTZXBhcmF0b3JTdGF0ZSA9IHsgaXNEaXNhYmxlZDogYm9vbGVhbiB9O1xuXG5leHBvcnQgY29uc3QgaW5kaWNhdG9yU2VwYXJhdG9yQ1NTID0gKHtcbiAgaXNEaXNhYmxlZCxcbiAgdGhlbWU6IHtcbiAgICBzcGFjaW5nOiB7IGJhc2VVbml0IH0sXG4gICAgY29sb3JzLFxuICB9LFxufTogQ29tbW9uUHJvcHMgJiBTZXBhcmF0b3JTdGF0ZSkgPT4gKHtcbiAgbGFiZWw6ICdpbmRpY2F0b3JTZXBhcmF0b3InLFxuICBhbGlnblNlbGY6ICdzdHJldGNoJyxcbiAgYmFja2dyb3VuZENvbG9yOiBpc0Rpc2FibGVkID8gY29sb3JzLm5ldXRyYWwxMCA6IGNvbG9ycy5uZXV0cmFsMjAsXG4gIG1hcmdpbkJvdHRvbTogYmFzZVVuaXQgKiAyLFxuICBtYXJnaW5Ub3A6IGJhc2VVbml0ICogMixcbiAgd2lkdGg6IDEsXG59KTtcblxuZXhwb3J0IGNvbnN0IEluZGljYXRvclNlcGFyYXRvciA9IChwcm9wczogSW5kaWNhdG9yUHJvcHMpID0+IHtcbiAgY29uc3QgeyBjbGFzc05hbWUsIGN4LCBnZXRTdHlsZXMsIGlubmVyUHJvcHMgfSA9IHByb3BzO1xuICByZXR1cm4gKFxuICAgIDxzcGFuXG4gICAgICB7Li4uaW5uZXJQcm9wc31cbiAgICAgIGNzcz17Z2V0U3R5bGVzKCdpbmRpY2F0b3JTZXBhcmF0b3InLCBwcm9wcyl9XG4gICAgICBjbGFzc05hbWU9e2N4KHsgJ2luZGljYXRvci1zZXBhcmF0b3InOiB0cnVlIH0sIGNsYXNzTmFtZSl9XG4gICAgLz5cbiAgKTtcbn07XG5cbi8vID09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuLy8gTG9hZGluZ1xuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XG5cbmNvbnN0IGxvYWRpbmdEb3RBbmltYXRpb25zID0ga2V5ZnJhbWVzYFxuICAwJSwgODAlLCAxMDAlIHsgb3BhY2l0eTogMDsgfVxuICA0MCUgeyBvcGFjaXR5OiAxOyB9XG5gO1xuXG5leHBvcnQgY29uc3QgbG9hZGluZ0luZGljYXRvckNTUyA9ICh7XG4gIGlzRm9jdXNlZCxcbiAgc2l6ZSxcbiAgdGhlbWU6IHtcbiAgICBjb2xvcnMsXG4gICAgc3BhY2luZzogeyBiYXNlVW5pdCB9LFxuICB9LFxufToge1xuICBpc0ZvY3VzZWQ6IGJvb2xlYW4sXG4gIHNpemU6IG51bWJlcixcbiAgdGhlbWU6IFRoZW1lLFxufSkgPT4gKHtcbiAgbGFiZWw6ICdsb2FkaW5nSW5kaWNhdG9yJyxcbiAgY29sb3I6IGlzRm9jdXNlZCA/IGNvbG9ycy5uZXV0cmFsNjAgOiBjb2xvcnMubmV1dHJhbDIwLFxuICBkaXNwbGF5OiAnZmxleCcsXG4gIHBhZGRpbmc6IGJhc2VVbml0ICogMixcbiAgdHJhbnNpdGlvbjogJ2NvbG9yIDE1MG1zJyxcbiAgYWxpZ25TZWxmOiAnY2VudGVyJyxcbiAgZm9udFNpemU6IHNpemUsXG4gIGxpbmVIZWlnaHQ6IDEsXG4gIG1hcmdpblJpZ2h0OiBzaXplLFxuICB0ZXh0QWxpZ246ICdjZW50ZXInLFxuICB2ZXJ0aWNhbEFsaWduOiAnbWlkZGxlJyxcbn0pO1xuXG50eXBlIERvdFByb3BzID0geyBkZWxheTogbnVtYmVyLCBvZmZzZXQ6IGJvb2xlYW4gfTtcbmNvbnN0IExvYWRpbmdEb3QgPSAoeyBkZWxheSwgb2Zmc2V0IH06IERvdFByb3BzKSA9PiAoXG4gIDxzcGFuXG4gICAgY3NzPXt7XG4gICAgICBhbmltYXRpb246IGAke2xvYWRpbmdEb3RBbmltYXRpb25zfSAxcyBlYXNlLWluLW91dCAke2RlbGF5fW1zIGluZmluaXRlO2AsXG4gICAgICBiYWNrZ3JvdW5kQ29sb3I6ICdjdXJyZW50Q29sb3InLFxuICAgICAgYm9yZGVyUmFkaXVzOiAnMWVtJyxcbiAgICAgIGRpc3BsYXk6ICdpbmxpbmUtYmxvY2snLFxuICAgICAgbWFyZ2luTGVmdDogb2Zmc2V0ID8gJzFlbScgOiBudWxsLFxuICAgICAgaGVpZ2h0OiAnMWVtJyxcbiAgICAgIHZlcnRpY2FsQWxpZ246ICd0b3AnLFxuICAgICAgd2lkdGg6ICcxZW0nLFxuICAgIH19XG4gIC8+XG4pO1xuXG5leHBvcnQgdHlwZSBMb2FkaW5nSWNvblByb3BzID0ge1xuICAvKiogUHJvcHMgdGhhdCB3aWxsIGJlIHBhc3NlZCBvbiB0byB0aGUgY2hpbGRyZW4uICovXG4gIGlubmVyUHJvcHM6IGFueSxcbiAgLyoqIFRoZSBmb2N1c2VkIHN0YXRlIG9mIHRoZSBzZWxlY3QuICovXG4gIGlzRm9jdXNlZDogYm9vbGVhbixcbiAgLyoqIFdoZXRoZXIgdGhlIHRleHQgaXMgcmlnaHQgdG8gbGVmdCAqL1xuICBpc1J0bDogYm9vbGVhbixcbn0gJiBDb21tb25Qcm9wcyAmIHtcbiAgICAvKiogU2V0IHNpemUgb2YgdGhlIGNvbnRhaW5lci4gKi9cbiAgICBzaXplOiBudW1iZXIsXG4gIH07XG5leHBvcnQgY29uc3QgTG9hZGluZ0luZGljYXRvciA9IChwcm9wczogTG9hZGluZ0ljb25Qcm9wcykgPT4ge1xuICBjb25zdCB7IGNsYXNzTmFtZSwgY3gsIGdldFN0eWxlcywgaW5uZXJQcm9wcywgaXNSdGwgfSA9IHByb3BzO1xuXG4gIHJldHVybiAoXG4gICAgPGRpdlxuICAgICAgY3NzPXtnZXRTdHlsZXMoJ2xvYWRpbmdJbmRpY2F0b3InLCBwcm9wcyl9XG4gICAgICBjbGFzc05hbWU9e2N4KFxuICAgICAgICB7XG4gICAgICAgICAgaW5kaWNhdG9yOiB0cnVlLFxuICAgICAgICAgICdsb2FkaW5nLWluZGljYXRvcic6IHRydWUsXG4gICAgICAgIH0sXG4gICAgICAgIGNsYXNzTmFtZVxuICAgICAgKX1cbiAgICAgIHsuLi5pbm5lclByb3BzfVxuICAgID5cbiAgICAgIDxMb2FkaW5nRG90IGRlbGF5PXswfSBvZmZzZXQ9e2lzUnRsfSAvPlxuICAgICAgPExvYWRpbmdEb3QgZGVsYXk9ezE2MH0gb2Zmc2V0IC8+XG4gICAgICA8TG9hZGluZ0RvdCBkZWxheT17MzIwfSBvZmZzZXQ9eyFpc1J0bH0gLz5cbiAgICA8L2Rpdj5cbiAgKTtcbn07XG5Mb2FkaW5nSW5kaWNhdG9yLmRlZmF1bHRQcm9wcyA9IHsgc2l6ZTogNCB9O1xuIl19 */")
    });
};
var LoadingIndicator = function LoadingIndicator1(props) {
    var className = props.className, cx = props.cx, getStyles = props.getStyles, innerProps = props.innerProps, isRtl = props.isRtl;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('loadingIndicator', props),
        className: cx({
            indicator: true,
            'loading-indicator': true
        }, className)
    }, innerProps), _react.jsx(LoadingDot, {
        delay: 0,
        offset: isRtl
    }), _react.jsx(LoadingDot, {
        delay: 160,
        offset: true
    }), _react.jsx(LoadingDot, {
        delay: 320,
        offset: !isRtl
    }));
};
LoadingIndicator.defaultProps = {
    size: 4
};
var css = function css1(_ref) {
    var isDisabled = _ref.isDisabled, isFocused = _ref.isFocused, _ref$theme = _ref.theme, colors = _ref$theme.colors, borderRadius = _ref$theme.borderRadius, spacing = _ref$theme.spacing;
    return {
        label: 'control',
        alignItems: 'center',
        backgroundColor: isDisabled ? colors.neutral5 : colors.neutral0,
        borderColor: isDisabled ? colors.neutral10 : isFocused ? colors.primary : colors.neutral20,
        borderRadius: borderRadius,
        borderStyle: 'solid',
        borderWidth: 1,
        boxShadow: isFocused ? "0 0 0 1px ".concat(colors.primary) : null,
        cursor: 'default',
        display: 'flex',
        flexWrap: 'wrap',
        justifyContent: 'space-between',
        minHeight: spacing.controlHeight,
        outline: '0 !important',
        position: 'relative',
        transition: 'all 100ms',
        '&:hover': {
            borderColor: isFocused ? colors.primary : colors.neutral30
        }
    };
};
var Control = function Control1(props) {
    var children = props.children, cx = props.cx, getStyles = props.getStyles, className = props.className, isDisabled = props.isDisabled, isFocused = props.isFocused, innerRef = props.innerRef, innerProps = props.innerProps, menuIsOpen = props.menuIsOpen;
    return _react.jsx("div", _extendsDefault.default({
        ref: innerRef,
        css: getStyles('control', props),
        className: cx({
            control: true,
            'control--is-disabled': isDisabled,
            'control--is-focused': isFocused,
            'control--menu-is-open': menuIsOpen
        }, className)
    }, innerProps), children);
};
var groupCSS = function groupCSS1(_ref) {
    var spacing = _ref.theme.spacing;
    return {
        paddingBottom: spacing.baseUnit * 2,
        paddingTop: spacing.baseUnit * 2
    };
};
var Group = function Group1(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, Heading = props.Heading, headingProps = props.headingProps, innerProps = props.innerProps, label = props.label, theme = props.theme, selectProps = props.selectProps;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('group', props),
        className: cx({
            group: true
        }, className)
    }, innerProps), _react.jsx(Heading, _extendsDefault.default({
    }, headingProps, {
        selectProps: selectProps,
        theme: theme,
        getStyles: getStyles,
        cx: cx
    }), label), _react.jsx("div", null, children));
};
var groupHeadingCSS = function groupHeadingCSS1(_ref21) {
    var spacing = _ref21.theme.spacing;
    return {
        label: 'group',
        color: '#999',
        cursor: 'default',
        display: 'block',
        fontSize: '75%',
        fontWeight: '500',
        marginBottom: '0.25em',
        paddingLeft: spacing.baseUnit * 3,
        paddingRight: spacing.baseUnit * 3,
        textTransform: 'uppercase'
    };
};
var GroupHeading = function GroupHeading1(props) {
    var getStyles = props.getStyles, cx = props.cx, className = props.className;
    var _cleanCommonProps = cleanCommonProps(props);
    _cleanCommonProps.data;
    var innerProps = _objectWithoutPropertiesDefault.default(_cleanCommonProps, [
        "data"
    ]);
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('groupHeading', props),
        className: cx({
            'group-heading': true
        }, className)
    }, innerProps));
};
var inputCSS = function inputCSS1(_ref) {
    var isDisabled = _ref.isDisabled, _ref$theme = _ref.theme, spacing = _ref$theme.spacing, colors = _ref$theme.colors;
    return {
        margin: spacing.baseUnit / 2,
        paddingBottom: spacing.baseUnit / 2,
        paddingTop: spacing.baseUnit / 2,
        visibility: isDisabled ? 'hidden' : 'visible',
        color: colors.neutral80
    };
};
var inputStyle = function inputStyle1(isHidden) {
    return {
        label: 'input',
        background: 0,
        border: 0,
        fontSize: 'inherit',
        opacity: isHidden ? 0 : 1,
        outline: 0,
        padding: 0,
        color: 'inherit'
    };
};
var Input = function Input1(props) {
    var className = props.className, cx = props.cx, getStyles = props.getStyles;
    var _cleanCommonProps = cleanCommonProps(props), innerRef = _cleanCommonProps.innerRef, isDisabled = _cleanCommonProps.isDisabled, isHidden = _cleanCommonProps.isHidden, innerProps = _objectWithoutPropertiesDefault.default(_cleanCommonProps, [
        "innerRef",
        "isDisabled",
        "isHidden"
    ]);
    return _react.jsx("div", {
        css: getStyles('input', props)
    }, _react.jsx(_reactInputAutosizeDefault.default, _extendsDefault.default({
        className: cx({
            input: true
        }, className),
        inputRef: innerRef,
        inputStyle: inputStyle(isHidden),
        disabled: isDisabled
    }, innerProps)));
};
var multiValueCSS = function multiValueCSS1(_ref) {
    var _ref$theme = _ref.theme, spacing = _ref$theme.spacing, borderRadius = _ref$theme.borderRadius, colors = _ref$theme.colors;
    return {
        label: 'multiValue',
        backgroundColor: colors.neutral10,
        borderRadius: borderRadius / 2,
        display: 'flex',
        margin: spacing.baseUnit / 2,
        minWidth: 0 // resolves flex/text-overflow bug
    };
};
var multiValueLabelCSS = function multiValueLabelCSS1(_ref21) {
    var _ref2$theme = _ref21.theme, borderRadius = _ref2$theme.borderRadius, colors = _ref2$theme.colors, cropWithEllipsis = _ref21.cropWithEllipsis;
    return {
        borderRadius: borderRadius / 2,
        color: colors.neutral80,
        fontSize: '85%',
        overflow: 'hidden',
        padding: 3,
        paddingLeft: 6,
        textOverflow: cropWithEllipsis ? 'ellipsis' : null,
        whiteSpace: 'nowrap'
    };
};
var multiValueRemoveCSS = function multiValueRemoveCSS1(_ref3) {
    var _ref3$theme = _ref3.theme, spacing = _ref3$theme.spacing, borderRadius = _ref3$theme.borderRadius, colors = _ref3$theme.colors, isFocused = _ref3.isFocused;
    return {
        alignItems: 'center',
        borderRadius: borderRadius / 2,
        backgroundColor: isFocused && colors.dangerLight,
        display: 'flex',
        paddingLeft: spacing.baseUnit,
        paddingRight: spacing.baseUnit,
        ':hover': {
            backgroundColor: colors.dangerLight,
            color: colors.danger
        }
    };
};
var MultiValueGeneric = function MultiValueGeneric1(_ref4) {
    var children = _ref4.children, innerProps = _ref4.innerProps;
    return _react.jsx("div", innerProps, children);
};
var MultiValueContainer = MultiValueGeneric;
var MultiValueLabel = MultiValueGeneric;
function MultiValueRemove(_ref5) {
    var children = _ref5.children, innerProps = _ref5.innerProps;
    return _react.jsx("div", innerProps, children || _react.jsx(CrossIcon, {
        size: 14
    }));
}
var MultiValue = function MultiValue1(props) {
    var children = props.children, className = props.className, components = props.components, cx = props.cx, data = props.data, getStyles = props.getStyles, innerProps = props.innerProps, isDisabled = props.isDisabled, removeProps = props.removeProps, selectProps = props.selectProps;
    var Container = components.Container, Label = components.Label, Remove = components.Remove;
    return _react.jsx(_react.ClassNames, null, function(_ref6) {
        var css2 = _ref6.css, emotionCx = _ref6.cx;
        return _react.jsx(Container, {
            data: data,
            innerProps: _objectSpread2({
                className: emotionCx(css2(getStyles('multiValue', props)), cx({
                    'multi-value': true,
                    'multi-value--is-disabled': isDisabled
                }, className))
            }, innerProps),
            selectProps: selectProps
        }, _react.jsx(Label, {
            data: data,
            innerProps: {
                className: emotionCx(css2(getStyles('multiValueLabel', props)), cx({
                    'multi-value__label': true
                }, className))
            },
            selectProps: selectProps
        }, children), _react.jsx(Remove, {
            data: data,
            innerProps: _objectSpread2({
                className: emotionCx(css2(getStyles('multiValueRemove', props)), cx({
                    'multi-value__remove': true
                }, className))
            }, removeProps),
            selectProps: selectProps
        }));
    });
};
MultiValue.defaultProps = {
    cropWithEllipsis: true
};
var optionCSS = function optionCSS1(_ref) {
    var isDisabled = _ref.isDisabled, isFocused = _ref.isFocused, isSelected = _ref.isSelected, _ref$theme = _ref.theme, spacing = _ref$theme.spacing, colors = _ref$theme.colors;
    return {
        label: 'option',
        backgroundColor: isSelected ? colors.primary : isFocused ? colors.primary25 : 'transparent',
        color: isDisabled ? colors.neutral20 : isSelected ? colors.neutral0 : 'inherit',
        cursor: 'default',
        display: 'block',
        fontSize: 'inherit',
        padding: "".concat(spacing.baseUnit * 2, "px ").concat(spacing.baseUnit * 3, "px"),
        width: '100%',
        userSelect: 'none',
        WebkitTapHighlightColor: 'rgba(0, 0, 0, 0)',
        // provide some affordance on touch devices
        ':active': {
            backgroundColor: !isDisabled && (isSelected ? colors.primary : colors.primary50)
        }
    };
};
var Option1 = function Option2(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, isDisabled = props.isDisabled, isFocused = props.isFocused, isSelected = props.isSelected, innerRef = props.innerRef, innerProps = props.innerProps;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('option', props),
        className: cx({
            option: true,
            'option--is-disabled': isDisabled,
            'option--is-focused': isFocused,
            'option--is-selected': isSelected
        }, className),
        ref: innerRef
    }, innerProps), children);
};
var placeholderCSS = function placeholderCSS1(_ref) {
    var _ref$theme = _ref.theme, spacing = _ref$theme.spacing, colors = _ref$theme.colors;
    return {
        label: 'placeholder',
        color: colors.neutral50,
        marginLeft: spacing.baseUnit / 2,
        marginRight: spacing.baseUnit / 2,
        position: 'absolute',
        top: '50%',
        transform: 'translateY(-50%)'
    };
};
var Placeholder = function Placeholder1(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, innerProps = props.innerProps;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('placeholder', props),
        className: cx({
            placeholder: true
        }, className)
    }, innerProps), children);
};
var css$1 = function css2(_ref) {
    var isDisabled = _ref.isDisabled, _ref$theme = _ref.theme, spacing = _ref$theme.spacing, colors = _ref$theme.colors;
    return {
        label: 'singleValue',
        color: isDisabled ? colors.neutral40 : colors.neutral80,
        marginLeft: spacing.baseUnit / 2,
        marginRight: spacing.baseUnit / 2,
        maxWidth: "calc(100% - ".concat(spacing.baseUnit * 2, "px)"),
        overflow: 'hidden',
        position: 'absolute',
        textOverflow: 'ellipsis',
        whiteSpace: 'nowrap',
        top: '50%',
        transform: 'translateY(-50%)'
    };
};
var SingleValue = function SingleValue1(props) {
    var children = props.children, className = props.className, cx = props.cx, getStyles = props.getStyles, isDisabled = props.isDisabled, innerProps = props.innerProps;
    return _react.jsx("div", _extendsDefault.default({
        css: getStyles('singleValue', props),
        className: cx({
            'single-value': true,
            'single-value--is-disabled': isDisabled
        }, className)
    }, innerProps), children);
};
var components = {
    ClearIndicator: ClearIndicator,
    Control: Control,
    DropdownIndicator: DropdownIndicator,
    DownChevron: DownChevron,
    CrossIcon: CrossIcon,
    Group: Group,
    GroupHeading: GroupHeading,
    IndicatorsContainer: IndicatorsContainer,
    IndicatorSeparator: IndicatorSeparator,
    Input: Input,
    LoadingIndicator: LoadingIndicator,
    Menu: Menu,
    MenuList: MenuList,
    MenuPortal: MenuPortal1,
    LoadingMessage: LoadingMessage,
    NoOptionsMessage: NoOptionsMessage,
    MultiValue: MultiValue,
    MultiValueContainer: MultiValueContainer,
    MultiValueLabel: MultiValueLabel,
    MultiValueRemove: MultiValueRemove,
    Option: Option1,
    Placeholder: Placeholder,
    SelectContainer: SelectContainer,
    SingleValue: SingleValue,
    ValueContainer: ValueContainer
};
var defaultComponents = function defaultComponents1(props) {
    return _objectSpread2(_objectSpread2({
    }, components), props.components);
};

},{"@babel/runtime/helpers/esm/extends":"6kJrr","@emotion/react":"gigaz","@babel/runtime/helpers/esm/taggedTemplateLiteral":"6T52e","@babel/runtime/helpers/esm/objectWithoutProperties":"hRPaM","@babel/runtime/helpers/esm/typeof":"3U77u","react-input-autosize":"4dKpO","@babel/runtime/helpers/esm/classCallCheck":"kcrhl","@babel/runtime/helpers/esm/createClass":"bETt6","@babel/runtime/helpers/esm/inherits":"1ybWu","@babel/runtime/helpers/esm/defineProperty":"bOy9j","react":"bE4sN","react-dom":"ilX9M","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"gigaz":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "CacheProvider", ()=>_emotionElement99289B21BrowserEsmJs.C
);
parcelHelpers.export(exports, "ThemeContext", ()=>_emotionElement99289B21BrowserEsmJs.T
);
parcelHelpers.export(exports, "ThemeProvider", ()=>_emotionElement99289B21BrowserEsmJs.a
);
parcelHelpers.export(exports, "__unsafe_useEmotionCache", ()=>_emotionElement99289B21BrowserEsmJs._
);
parcelHelpers.export(exports, "useTheme", ()=>_emotionElement99289B21BrowserEsmJs.u
);
parcelHelpers.export(exports, "withEmotionCache", ()=>_emotionElement99289B21BrowserEsmJs.w
);
parcelHelpers.export(exports, "withTheme", ()=>_emotionElement99289B21BrowserEsmJs.b
);
parcelHelpers.export(exports, "ClassNames", ()=>ClassNames
);
parcelHelpers.export(exports, "Global", ()=>Global
);
parcelHelpers.export(exports, "createElement", ()=>jsx
);
parcelHelpers.export(exports, "css", ()=>css
);
parcelHelpers.export(exports, "jsx", ()=>jsx
);
parcelHelpers.export(exports, "keyframes", ()=>keyframes
);
var _react = require("react");
var _cache = require("@emotion/cache");
var _emotionElement99289B21BrowserEsmJs = require("./emotion-element-99289b21.browser.esm.js");
var _extends = require("@babel/runtime/helpers/extends");
var _weakMemoize = require("@emotion/weak-memoize");
var _hoistNonReactStatics = require("hoist-non-react-statics");
// import '../isolated-hoist-non-react-statics-do-not-use-this-in-your-code/dist/emotion-react-isolated-hoist-non-react-statics-do-not-use-this-in-your-code.browser.esm.js';
var _utils = require("@emotion/utils");
var _serialize = require("@emotion/serialize");
var _sheet = require("@emotion/sheet");
var global = arguments[3];
var pkg = {
    name: "@emotion/react",
    version: "11.4.1",
    main: "dist/emotion-react.cjs.js",
    module: "dist/emotion-react.esm.js",
    browser: {
        "./dist/emotion-react.cjs.js": "./dist/emotion-react.browser.cjs.js",
        "./dist/emotion-react.esm.js": "./dist/emotion-react.browser.esm.js"
    },
    types: "types/index.d.ts",
    files: [
        "src",
        "dist",
        "jsx-runtime",
        "jsx-dev-runtime",
        "isolated-hoist-non-react-statics-do-not-use-this-in-your-code",
        "types/*.d.ts",
        "macro.js",
        "macro.d.ts",
        "macro.js.flow"
    ],
    sideEffects: false,
    author: "mitchellhamilton <mitchell@mitchellhamilton.me>",
    license: "MIT",
    scripts: {
        "test:typescript": "dtslint types"
    },
    dependencies: {
        "@babel/runtime": "^7.13.10",
        "@emotion/cache": "^11.4.0",
        "@emotion/serialize": "^1.0.2",
        "@emotion/sheet": "^1.0.2",
        "@emotion/utils": "^1.0.0",
        "@emotion/weak-memoize": "^0.2.5",
        "hoist-non-react-statics": "^3.3.1"
    },
    peerDependencies: {
        "@babel/core": "^7.0.0",
        react: ">=16.8.0"
    },
    peerDependenciesMeta: {
        "@babel/core": {
            optional: true
        },
        "@types/react": {
            optional: true
        }
    },
    devDependencies: {
        "@babel/core": "^7.13.10",
        "@emotion/css": "11.1.3",
        "@emotion/css-prettifier": "1.0.0",
        "@emotion/server": "11.4.0",
        "@emotion/styled": "11.3.0",
        "@types/react": "^16.9.11",
        dtslint: "^0.3.0",
        "html-tag-names": "^1.1.2",
        react: "16.14.0",
        "svg-tag-names": "^1.1.1"
    },
    repository: "https://github.com/emotion-js/emotion/tree/main/packages/react",
    publishConfig: {
        access: "public"
    },
    "umd:main": "dist/emotion-react.umd.min.js",
    preconstruct: {
        entrypoints: [
            "./index.js",
            "./jsx-runtime.js",
            "./jsx-dev-runtime.js",
            "./isolated-hoist-non-react-statics-do-not-use-this-in-your-code.js"
        ],
        umdName: "emotionReact"
    }
};
var jsx = function jsx1(type, props) {
    var args = arguments;
    if (props == null || !_emotionElement99289B21BrowserEsmJs.h.call(props, 'css')) // $FlowFixMe
    return _react.createElement.apply(undefined, args);
    var argsLength = args.length;
    var createElementArgArray = new Array(argsLength);
    createElementArgArray[0] = _emotionElement99289B21BrowserEsmJs.E;
    createElementArgArray[1] = _emotionElement99289B21BrowserEsmJs.c(type, props);
    for(var i = 2; i < argsLength; i++)createElementArgArray[i] = args[i];
     // $FlowFixMe
    return _react.createElement.apply(null, createElementArgArray);
};
var warnedAboutCssPropForGlobal = false; // maintain place over rerenders.
// initial render from browser, insertBefore context.sheet.tags[0] or if a style hasn't been inserted there yet, appendChild
// initial client-side render from SSR, use place of hydrating tag
var Global = /* #__PURE__ */ _emotionElement99289B21BrowserEsmJs.w(function(props, cache) {
    if (!warnedAboutCssPropForGlobal && // probably using the custom createElement which
    // means it will be turned into a className prop
    // $FlowFixMe I don't really want to add it to the type since it shouldn't be used
    (props.className || props.css)) {
        console.error("It looks like you're using the css prop on Global, did you mean to use the styles prop instead?");
        warnedAboutCssPropForGlobal = true;
    }
    var styles = props.styles;
    var serialized = _serialize.serializeStyles([
        styles
    ], undefined, _react.useContext(_emotionElement99289B21BrowserEsmJs.T));
    // but it is based on a constant that will never change at runtime
    // it's effectively like having two implementations and switching them out
    // so it's not actually breaking anything
    var sheetRef = _react.useRef();
    _react.useLayoutEffect(function() {
        var key = cache.key + "-global";
        var sheet = new _sheet.StyleSheet({
            key: key,
            nonce: cache.sheet.nonce,
            container: cache.sheet.container,
            speedy: cache.sheet.isSpeedy
        });
        var rehydrating = false; // $FlowFixMe
        var node = document.querySelector("style[data-emotion=\"" + key + " " + serialized.name + "\"]");
        if (cache.sheet.tags.length) sheet.before = cache.sheet.tags[0];
        if (node !== null) {
            rehydrating = true; // clear the hash so this node won't be recognizable as rehydratable by other <Global/>s
            node.setAttribute('data-emotion', key);
            sheet.hydrate([
                node
            ]);
        }
        sheetRef.current = [
            sheet,
            rehydrating
        ];
        return function() {
            sheet.flush();
        };
    }, [
        cache
    ]);
    _react.useLayoutEffect(function() {
        var sheetRefCurrent = sheetRef.current;
        var sheet = sheetRefCurrent[0], rehydrating = sheetRefCurrent[1];
        if (rehydrating) {
            sheetRefCurrent[1] = false;
            return;
        }
        if (serialized.next !== undefined) // insert keyframes
        _utils.insertStyles(cache, serialized.next, true);
        if (sheet.tags.length) {
            // if this doesn't exist then it will be null so the style element will be appended
            var element = sheet.tags[sheet.tags.length - 1].nextElementSibling;
            sheet.before = element;
            sheet.flush();
        }
        cache.insert("", serialized, sheet, false);
    }, [
        cache,
        serialized.name
    ]);
    return null;
});
Global.displayName = 'EmotionGlobal';
function css() {
    for(var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++)args[_key] = arguments[_key];
    return _serialize.serializeStyles(args);
}
var keyframes = function keyframes1() {
    var insertable = css.apply(void 0, arguments);
    var name = "animation-" + insertable.name; // $FlowFixMe
    return {
        name: name,
        styles: "@keyframes " + name + "{" + insertable.styles + "}",
        anim: 1,
        toString: function toString() {
            return "_EMO_" + this.name + "_" + this.styles + "_EMO_";
        }
    };
};
var classnames = function classnames1(args) {
    var len = args.length;
    var i = 0;
    var cls = '';
    for(; i < len; i++){
        var arg = args[i];
        if (arg == null) continue;
        var toAdd = void 0;
        switch(typeof arg){
            case 'boolean':
                break;
            case 'object':
                if (Array.isArray(arg)) toAdd = classnames1(arg);
                else {
                    if (arg.styles !== undefined && arg.name !== undefined) console.error("You have passed styles created with `css` from `@emotion/react` package to the `cx`.\n`cx` is meant to compose class names (strings) so you should convert those styles to a class name by passing them to the `css` received from <ClassNames/> component.");
                    toAdd = '';
                    for(var k in arg)if (arg[k] && k) {
                        toAdd && (toAdd += ' ');
                        toAdd += k;
                    }
                }
                break;
            default:
                toAdd = arg;
        }
        if (toAdd) {
            cls && (cls += ' ');
            cls += toAdd;
        }
    }
    return cls;
};
function merge(registered, css1, className) {
    var registeredStyles = [];
    var rawClassName = _utils.getRegisteredStyles(registered, registeredStyles, className);
    if (registeredStyles.length < 2) return className;
    return rawClassName + css1(registeredStyles);
}
var ClassNames = /* #__PURE__ */ _emotionElement99289B21BrowserEsmJs.w(function(props, cache) {
    var hasRendered = false;
    var css1 = function css2() {
        if (hasRendered && true) throw new Error('css can only be used during render');
        for(var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++)args[_key] = arguments[_key];
        var serialized = _serialize.serializeStyles(args, cache.registered);
        _utils.insertStyles(cache, serialized, false);
        return cache.key + "-" + serialized.name;
    };
    var cx = function cx1() {
        if (hasRendered && true) throw new Error('cx can only be used during render');
        for(var _len2 = arguments.length, args = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++)args[_key2] = arguments[_key2];
        return merge(cache.registered, css1, classnames(args));
    };
    var content = {
        css: css1,
        cx: cx,
        theme: _react.useContext(_emotionElement99289B21BrowserEsmJs.T)
    };
    var ele = props.children(content);
    hasRendered = true;
    return ele;
});
ClassNames.displayName = 'EmotionClassNames';
var isBrowser = true; // #1727 for some reason Jest evaluates modules twice if some consuming module gets mocked with jest.mock
var isJest = typeof jest !== 'undefined';
if (isBrowser && !isJest) {
    var globalContext = isBrowser ? window : global;
    var globalKey = "__EMOTION_REACT_" + pkg.version.split('.')[0] + "__";
    if (globalContext[globalKey]) console.warn("You are loading @emotion/react when it is already loaded. Running multiple instances may cause problems. This can happen if multiple versions are used, or if multiple builds of the same version are used.");
    globalContext[globalKey] = true;
}

},{"react":"bE4sN","@emotion/cache":"83lJK","./emotion-element-99289b21.browser.esm.js":"klZCZ","@babel/runtime/helpers/extends":"gs4XN","@emotion/weak-memoize":"f50WZ","hoist-non-react-statics":"5t68n","@emotion/utils":"2kmdx","@emotion/serialize":"6hzKH","@emotion/sheet":"iWqaz","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"bE4sN":[function(require,module,exports) {
module.exports = React;

},{}],"83lJK":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _sheet = require("@emotion/sheet");
var _stylis = require("stylis");
var _weakMemoize = require("@emotion/weak-memoize");
var _memoize = require("@emotion/memoize");
var last = function last1(arr) {
    return arr.length ? arr[arr.length - 1] : null;
};
var toRules = function toRules1(parsed, points) {
    // pretend we've started with a comma
    var index = -1;
    var character = 44;
    do switch(_stylis.token(character)){
        case 0:
            // &\f
            if (character === 38 && _stylis.peek() === 12) // this is not 100% correct, we don't account for literal sequences here - like for example quoted strings
            // stylis inserts \f after & to know when & where it should replace this sequence with the context selector
            // and when it should just concatenate the outer and inner selectors
            // it's very unlikely for this sequence to actually appear in a different context, so we just leverage this fact here
            points[index] = 1;
            parsed[index] += _stylis.identifier(_stylis.position - 1);
            break;
        case 2:
            parsed[index] += _stylis.delimit(character);
            break;
        case 4:
            // comma
            if (character === 44) {
                // colon
                parsed[++index] = _stylis.peek() === 58 ? '&\f' : '';
                points[index] = parsed[index].length;
                break;
            }
        // fallthrough
        default:
            parsed[index] += _stylis.from(character);
    }
    while (character = _stylis.next())
    return parsed;
};
var getRules = function getRules1(value, points) {
    return _stylis.dealloc(toRules(_stylis.alloc(value), points));
}; // WeakSet would be more appropriate, but only WeakMap is supported in IE11
var fixedElements = /* #__PURE__ */ new WeakMap();
var compat = function compat1(element) {
    if (element.type !== 'rule' || !element.parent || !element.length) return;
    var value = element.value, parent = element.parent;
    var isImplicitRule = element.column === parent.column && element.line === parent.line;
    while(parent.type !== 'rule'){
        parent = parent.parent;
        if (!parent) return;
    } // short-circuit for the simplest case
    if (element.props.length === 1 && value.charCodeAt(0) !== 58 && !fixedElements.get(parent)) return;
     // if this is an implicitly inserted rule (the one eagerly inserted at the each new nested level)
    // then the props has already been manipulated beforehand as they that array is shared between it and its "rule parent"
    if (isImplicitRule) return;
    fixedElements.set(element, true);
    var points = [];
    var rules = getRules(value, points);
    var parentRules = parent.props;
    for(var i = 0, k = 0; i < rules.length; i++)for(var j = 0; j < parentRules.length; j++, k++)element.props[k] = points[i] ? rules[i].replace(/&\f/g, parentRules[j]) : parentRules[j] + " " + rules[i];
};
var removeLabel = function removeLabel1(element) {
    if (element.type === 'decl') {
        var value = element.value;
        if (value.charCodeAt(0) === 108 && value.charCodeAt(2) === 98) {
            // this ignores label
            element["return"] = '';
            element.value = '';
        }
    }
};
var ignoreFlag = 'emotion-disable-server-rendering-unsafe-selector-warning-please-do-not-use-this-the-warning-exists-for-a-reason';
var isIgnoringComment = function isIgnoringComment1(element) {
    return !!element && element.type === 'comm' && element.children.indexOf(ignoreFlag) > -1;
};
var createUnsafeSelectorsAlarm = function createUnsafeSelectorsAlarm1(cache) {
    return function(element, index, children) {
        if (element.type !== 'rule') return;
        var unsafePseudoClasses = element.value.match(/(:first|:nth|:nth-last)-child/g);
        if (unsafePseudoClasses && cache.compat !== true) {
            var prevElement = index > 0 ? children[index - 1] : null;
            if (prevElement && isIgnoringComment(last(prevElement.children))) return;
            unsafePseudoClasses.forEach(function(unsafePseudoClass) {
                console.error("The pseudo class \"" + unsafePseudoClass + "\" is potentially unsafe when doing server-side rendering. Try changing it to \"" + unsafePseudoClass.split('-child')[0] + "-of-type\".");
            });
        }
    };
};
var isImportRule = function isImportRule1(element) {
    return element.type.charCodeAt(1) === 105 && element.type.charCodeAt(0) === 64;
};
var isPrependedWithRegularRules = function isPrependedWithRegularRules1(index, children) {
    for(var i = index - 1; i >= 0; i--){
        if (!isImportRule(children[i])) return true;
    }
    return false;
}; // use this to remove incorrect elements from further processing
// so they don't get handed to the `sheet` (or anything else)
// as that could potentially lead to additional logs which in turn could be overhelming to the user
var nullifyElement = function nullifyElement1(element) {
    element.type = '';
    element.value = '';
    element["return"] = '';
    element.children = '';
    element.props = '';
};
var incorrectImportAlarm = function incorrectImportAlarm1(element, index, children) {
    if (!isImportRule(element)) return;
    if (element.parent) {
        console.error("`@import` rules can't be nested inside other rules. Please move it to the top level and put it before regular rules. Keep in mind that they can only be used within global styles.");
        nullifyElement(element);
    } else if (isPrependedWithRegularRules(index, children)) {
        console.error("`@import` rules can't be after other rules. Please put your `@import` rules before your other rules.");
        nullifyElement(element);
    }
};
var defaultStylisPlugins = [_stylis.prefixer];
var createCache = function createCache1(options) {
    var key = options.key;
    if (!key) throw new Error("You have to configure `key` for your cache. Please make sure it's unique (and not equal to 'css') as it's used for linking styles to your cache.\nIf multiple caches share the same key they might \"fight\" for each other's style elements.");
    if (key === 'css') {
        var ssrStyles = document.querySelectorAll("style[data-emotion]:not([data-s])"); // get SSRed styles out of the way of React's hydration
        // document.head is a safe place to move them to(though note document.head is not necessarily the last place they will be)
        // note this very very intentionally targets all style elements regardless of the key to ensure
        // that creating a cache works inside of render of a React component
        Array.prototype.forEach.call(ssrStyles, function(node) {
            // we want to only move elements which have a space in the data-emotion attribute value
            // because that indicates that it is an Emotion 11 server-side rendered style elements
            // while we will already ignore Emotion 11 client-side inserted styles because of the :not([data-s]) part in the selector
            // Emotion 10 client-side inserted styles did not have data-s (but importantly did not have a space in their data-emotion attributes)
            // so checking for the space ensures that loading Emotion 11 after Emotion 10 has inserted some styles
            // will not result in the Emotion 10 styles being destroyed
            var dataEmotionAttribute = node.getAttribute('data-emotion');
            if (dataEmotionAttribute.indexOf(' ') === -1) return;
            document.head.appendChild(node);
            node.setAttribute('data-s', '');
        });
    }
    var stylisPlugins = options.stylisPlugins || defaultStylisPlugins;
    // $FlowFixMe
    if (/[^a-z-]/.test(key)) throw new Error("Emotion key must only contain lower case alphabetical characters and - but \"" + key + "\" was passed");
    var inserted = {
    }; // $FlowFixMe
    var container;
    var nodesToHydrate = [];
    container = options.container || document.head;
    Array.prototype.forEach.call(// means that the style elements we're looking at are only Emotion 11 server-rendered style elements
    document.querySelectorAll("style[data-emotion^=\"" + key + " \"]"), function(node) {
        var attrib = node.getAttribute("data-emotion").split(' '); // $FlowFixMe
        for(var i = 1; i < attrib.length; i++)inserted[attrib[i]] = true;
        nodesToHydrate.push(node);
    });
    var _insert;
    var omnipresentPlugins = [
        compat,
        removeLabel
    ];
    omnipresentPlugins.push(createUnsafeSelectorsAlarm({
        get compat () {
            return cache.compat;
        }
    }), incorrectImportAlarm);
    var currentSheet;
    var finalizingPlugins = [_stylis.stringify, function(element) {
            if (!element.root) {
                if (element["return"]) currentSheet.insert(element["return"]);
                else if (element.value && element.type !== _stylis.COMMENT) // insert empty rule in non-production environments
                // so @emotion/jest can grab `key` from the (JS)DOM for caches without any rules inserted yet
                currentSheet.insert(element.value + "{}");
            }
        }
    ];
    var serializer = _stylis.middleware(omnipresentPlugins.concat(stylisPlugins, finalizingPlugins));
    var stylis = function stylis1(styles) {
        return _stylis.serialize(_stylis.compile(styles), serializer);
    };
    _insert = function insert(selector, serialized, sheet, shouldCache) {
        currentSheet = sheet;
        if (serialized.map !== undefined) currentSheet = {
            insert: function insert1(rule) {
                sheet.insert(rule + serialized.map);
            }
        };
        stylis(selector ? selector + "{" + serialized.styles + "}" : serialized.styles);
        if (shouldCache) cache.inserted[serialized.name] = true;
    };
    var cache = {
        key: key,
        sheet: new _sheet.StyleSheet({
            key: key,
            container: container,
            nonce: options.nonce,
            speedy: options.speedy,
            prepend: options.prepend
        }),
        nonce: options.nonce,
        inserted: inserted,
        registered: {
        },
        insert: _insert
    };
    cache.sheet.hydrate(nodesToHydrate);
    return cache;
};
exports.default = createCache;

},{"@emotion/sheet":"iWqaz","stylis":"kb3YF","@emotion/weak-memoize":"f50WZ","@emotion/memoize":"WdjGJ","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"iWqaz":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "StyleSheet", ()=>StyleSheet1
);
/*

Based off glamor's StyleSheet, thanks Sunil ❤️

high performance StyleSheet for css-in-js systems

- uses multiple style tags behind the scenes for millions of rules
- uses `insertRule` for appending in production for *much* faster performance

// usage

import { StyleSheet } from '@emotion/sheet'

let styleSheet = new StyleSheet({ key: '', container: document.head })

styleSheet.insert('#box { border: 1px solid red; }')
- appends a css rule into the stylesheet

styleSheet.flush()
- empties the stylesheet of all its contents

*/ // $FlowFixMe
function sheetForTag(tag) {
    if (tag.sheet) // $FlowFixMe
    return tag.sheet;
     // this weirdness brought to you by firefox
    /* istanbul ignore next */ for(var i = 0; i < document.styleSheets.length; i++){
        if (document.styleSheets[i].ownerNode === tag) // $FlowFixMe
        return document.styleSheets[i];
    }
}
function createStyleElement(options) {
    var tag = document.createElement('style');
    tag.setAttribute('data-emotion', options.key);
    if (options.nonce !== undefined) tag.setAttribute('nonce', options.nonce);
    tag.appendChild(document.createTextNode(''));
    tag.setAttribute('data-s', '');
    return tag;
}
var StyleSheet1 = /*#__PURE__*/ function() {
    function StyleSheet2(options) {
        var _this = this;
        this._insertTag = function(tag) {
            var before;
            if (_this.tags.length === 0) before = _this.prepend ? _this.container.firstChild : _this.before;
            else before = _this.tags[_this.tags.length - 1].nextSibling;
            _this.container.insertBefore(tag, before);
            _this.tags.push(tag);
        };
        this.isSpeedy = options.speedy === undefined ? false : options.speedy;
        this.tags = [];
        this.ctr = 0;
        this.nonce = options.nonce; // key is the value of the data-emotion attribute, it's used to identify different sheets
        this.key = options.key;
        this.container = options.container;
        this.prepend = options.prepend;
        this.before = null;
    }
    var _proto = StyleSheet2.prototype;
    _proto.hydrate = function hydrate(nodes) {
        nodes.forEach(this._insertTag);
    };
    _proto.insert = function insert(rule) {
        // the max length is how many rules we have per style tag, it's 65000 in speedy mode
        // it's 1 in dev because we insert source maps that map a single rule to a location
        // and you can only have one source map per style tag
        if (this.ctr % (this.isSpeedy ? 65000 : 1) === 0) this._insertTag(createStyleElement(this));
        var tag = this.tags[this.tags.length - 1];
        var isImportRule = rule.charCodeAt(0) === 64 && rule.charCodeAt(1) === 105;
        if (isImportRule && this._alreadyInsertedOrderInsensitiveRule) // this would only cause problem in speedy mode
        // but we don't want enabling speedy to affect the observable behavior
        // so we report this error at all times
        console.error("You're attempting to insert the following rule:\n" + rule + '\n\n`@import` rules must be before all other types of rules in a stylesheet but other rules have already been inserted. Please ensure that `@import` rules are before all other rules.');
        this._alreadyInsertedOrderInsensitiveRule = this._alreadyInsertedOrderInsensitiveRule || !isImportRule;
        if (this.isSpeedy) {
            var sheet = sheetForTag(tag);
            try {
                // this is the ultrafast version, works across browsers
                // the big drawback is that the css won't be editable in devtools
                sheet.insertRule(rule, sheet.cssRules.length);
            } catch (e) {
                if (!/:(-moz-placeholder|-moz-focus-inner|-moz-focusring|-ms-input-placeholder|-moz-read-write|-moz-read-only|-ms-clear){/.test(rule)) console.error("There was a problem inserting the following rule: \"" + rule + "\"", e);
            }
        } else tag.appendChild(document.createTextNode(rule));
        this.ctr++;
    };
    _proto.flush = function flush() {
        // $FlowFixMe
        this.tags.forEach(function(tag) {
            return tag.parentNode.removeChild(tag);
        });
        this.tags = [];
        this.ctr = 0;
        this._alreadyInsertedOrderInsensitiveRule = false;
    };
    return StyleSheet2;
}();

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"kb3YF":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "CHARSET", ()=>f
);
parcelHelpers.export(exports, "COMMENT", ()=>c
);
parcelHelpers.export(exports, "COUNTER_STYLE", ()=>w
);
parcelHelpers.export(exports, "DECLARATION", ()=>t
);
parcelHelpers.export(exports, "DOCUMENT", ()=>v
);
parcelHelpers.export(exports, "FONT_FACE", ()=>b
);
parcelHelpers.export(exports, "FONT_FEATURE_VALUES", ()=>$
);
parcelHelpers.export(exports, "IMPORT", ()=>i
);
parcelHelpers.export(exports, "KEYFRAMES", ()=>p
);
parcelHelpers.export(exports, "MEDIA", ()=>u
);
parcelHelpers.export(exports, "MOZ", ()=>r
);
parcelHelpers.export(exports, "MS", ()=>e
);
parcelHelpers.export(exports, "NAMESPACE", ()=>h
);
parcelHelpers.export(exports, "PAGE", ()=>s
);
parcelHelpers.export(exports, "RULESET", ()=>n
);
parcelHelpers.export(exports, "SUPPORTS", ()=>l
);
parcelHelpers.export(exports, "VIEWPORT", ()=>o
);
parcelHelpers.export(exports, "WEBKIT", ()=>a
);
parcelHelpers.export(exports, "abs", ()=>k
);
parcelHelpers.export(exports, "alloc", ()=>T
);
parcelHelpers.export(exports, "append", ()=>O
);
parcelHelpers.export(exports, "caret", ()=>P
);
parcelHelpers.export(exports, "char", ()=>J
);
parcelHelpers.export(exports, "character", ()=>F
);
parcelHelpers.export(exports, "characters", ()=>G
);
parcelHelpers.export(exports, "charat", ()=>z
);
parcelHelpers.export(exports, "column", ()=>B
);
parcelHelpers.export(exports, "combine", ()=>S
);
parcelHelpers.export(exports, "comment", ()=>te
);
parcelHelpers.export(exports, "commenter", ()=>ee
);
parcelHelpers.export(exports, "compile", ()=>ae
);
parcelHelpers.export(exports, "copy", ()=>I
);
parcelHelpers.export(exports, "dealloc", ()=>U
);
parcelHelpers.export(exports, "declaration", ()=>se
);
parcelHelpers.export(exports, "delimit", ()=>V
);
parcelHelpers.export(exports, "delimiter", ()=>_
);
parcelHelpers.export(exports, "escaping", ()=>Z
);
parcelHelpers.export(exports, "from", ()=>d
);
parcelHelpers.export(exports, "hash", ()=>m
);
parcelHelpers.export(exports, "identifier", ()=>re
);
parcelHelpers.export(exports, "indexof", ()=>j
);
parcelHelpers.export(exports, "length", ()=>D
);
parcelHelpers.export(exports, "line", ()=>q
);
parcelHelpers.export(exports, "match", ()=>x
);
parcelHelpers.export(exports, "middleware", ()=>oe
);
parcelHelpers.export(exports, "namespace", ()=>he
);
parcelHelpers.export(exports, "next", ()=>L
);
parcelHelpers.export(exports, "node", ()=>H
);
parcelHelpers.export(exports, "parse", ()=>ce
);
parcelHelpers.export(exports, "peek", ()=>N
);
parcelHelpers.export(exports, "position", ()=>E
);
parcelHelpers.export(exports, "prefix", ()=>ue
);
parcelHelpers.export(exports, "prefixer", ()=>ve
);
parcelHelpers.export(exports, "prev", ()=>K
);
parcelHelpers.export(exports, "replace", ()=>y
);
parcelHelpers.export(exports, "ruleset", ()=>ne
);
parcelHelpers.export(exports, "rulesheet", ()=>le
);
parcelHelpers.export(exports, "serialize", ()=>ie
);
parcelHelpers.export(exports, "sizeof", ()=>M
);
parcelHelpers.export(exports, "slice", ()=>Q
);
parcelHelpers.export(exports, "stringify", ()=>fe
);
parcelHelpers.export(exports, "strlen", ()=>A
);
parcelHelpers.export(exports, "substr", ()=>C
);
parcelHelpers.export(exports, "token", ()=>R
);
parcelHelpers.export(exports, "tokenize", ()=>W
);
parcelHelpers.export(exports, "tokenizer", ()=>Y
);
parcelHelpers.export(exports, "trim", ()=>g
);
parcelHelpers.export(exports, "whitespace", ()=>X
);
var e = "-ms-";
var r = "-moz-";
var a = "-webkit-";
var c = "comm";
var n = "rule";
var t = "decl";
var s = "@page";
var u = "@media";
var i = "@import";
var f = "@charset";
var o = "@viewport";
var l = "@supports";
var v = "@document";
var h = "@namespace";
var p = "@keyframes";
var b = "@font-face";
var w = "@counter-style";
var $ = "@font-feature-values";
var k = Math.abs;
var d = String.fromCharCode;
function m(e1, r1) {
    return (((r1 << 2 ^ z(e1, 0)) << 2 ^ z(e1, 1)) << 2 ^ z(e1, 2)) << 2 ^ z(e1, 3);
}
function g(e1) {
    return e1.trim();
}
function x(e1, r1) {
    return (e1 = r1.exec(e1)) ? e1[0] : e1;
}
function y(e1, r1, a1) {
    return e1.replace(r1, a1);
}
function j(e1, r1) {
    return e1.indexOf(r1);
}
function z(e1, r1) {
    return e1.charCodeAt(r1) | 0;
}
function C(e1, r1, a1) {
    return e1.slice(r1, a1);
}
function A(e1) {
    return e1.length;
}
function M(e1) {
    return e1.length;
}
function O(e1, r1) {
    return r1.push(e1), e1;
}
function S(e1, r1) {
    return e1.map(r1).join("");
}
var q = 1;
var B = 1;
var D = 0;
var E = 0;
var F = 0;
var G = "";
function H(e1, r1, a1, c1, n1, t1, s1) {
    return {
        value: e1,
        root: r1,
        parent: a1,
        type: c1,
        props: n1,
        children: t1,
        line: q,
        column: B,
        length: s1,
        return: ""
    };
}
function I(e1, r1, a1) {
    return H(e1, r1.root, r1.parent, a1, r1.props, r1.children, 0);
}
function J() {
    return F;
}
function K() {
    F = E > 0 ? z(G, --E) : 0;
    if (B--, F === 10) B = 1, q--;
    return F;
}
function L() {
    F = E < D ? z(G, E++) : 0;
    if (B++, F === 10) B = 1, q++;
    return F;
}
function N() {
    return z(G, E);
}
function P() {
    return E;
}
function Q(e1, r1) {
    return C(G, e1, r1);
}
function R(e1) {
    switch(e1){
        case 0:
        case 9:
        case 10:
        case 13:
        case 32:
            return 5;
        case 33:
        case 43:
        case 44:
        case 47:
        case 62:
        case 64:
        case 126:
        case 59:
        case 123:
        case 125:
            return 4;
        case 58:
            return 3;
        case 34:
        case 39:
        case 40:
        case 91:
            return 2;
        case 41:
        case 93:
            return 1;
    }
    return 0;
}
function T(e1) {
    return q = B = 1, D = A(G = e1), E = 0, [];
}
function U(e1) {
    return G = "", e1;
}
function V(e1) {
    return g(Q(E - 1, _(e1 === 91 ? e1 + 2 : e1 === 40 ? e1 + 1 : e1)));
}
function W(e1) {
    return U(Y(T(e1)));
}
function X(e1) {
    while(F = N())if (F < 33) L();
    else break;
    return R(e1) > 2 || R(F) > 3 ? "" : " ";
}
function Y(e1) {
    while(L())switch(R(F)){
        case 0:
            O(re(E - 1), e1);
            break;
        case 2:
            O(V(F), e1);
            break;
        default:
            O(d(F), e1);
    }
    return e1;
}
function Z(e1, r1) {
    while((--r1) && L())if (F < 48 || F > 102 || F > 57 && F < 65 || F > 70 && F < 97) break;
    return Q(e1, P() + (r1 < 6 && N() == 32 && L() == 32));
}
function _(e1) {
    while(L())switch(F){
        case e1:
            return E;
        case 34:
        case 39:
            return _(e1 === 34 || e1 === 39 ? e1 : F);
        case 40:
            if (e1 === 41) _(e1);
            break;
        case 92:
            L();
            break;
    }
    return E;
}
function ee(e1, r1) {
    while(L())if (e1 + F === 57) break;
    else if (e1 + F === 84 && N() === 47) break;
    return "/*" + Q(r1, E - 1) + "*" + d(e1 === 47 ? e1 : L());
}
function re(e1) {
    while(!R(N()))L();
    return Q(e1, E);
}
function ae(e1) {
    return U(ce("", null, null, null, [
        ""
    ], e1 = T(e1), 0, [
        0
    ], e1));
}
function ce(e1, r1, a1, c1, n1, t1, s1, u1, i1) {
    var f1 = 0;
    var o1 = 0;
    var l1 = s1;
    var v1 = 0;
    var h1 = 0;
    var p1 = 0;
    var b1 = 1;
    var w1 = 1;
    var $1 = 1;
    var k1 = 0;
    var m1 = "";
    var g1 = n1;
    var x1 = t1;
    var j1 = c1;
    var z1 = m1;
    while(w1)switch(p1 = k1, k1 = L()){
        case 34:
        case 39:
        case 91:
        case 40:
            z1 += V(k1);
            break;
        case 9:
        case 10:
        case 13:
        case 32:
            z1 += X(p1);
            break;
        case 92:
            z1 += Z(P() - 1, 7);
            continue;
        case 47:
            switch(N()){
                case 42:
                case 47:
                    O(te(ee(L(), P()), r1, a1), i1);
                    break;
                default:
                    z1 += "/";
            }
            break;
        case 123 * b1:
            u1[f1++] = A(z1) * $1;
        case 125 * b1:
        case 59:
        case 0:
            switch(k1){
                case 0:
                case 125:
                    w1 = 0;
                case 59 + o1:
                    if (h1 > 0 && A(z1) - l1) O(h1 > 32 ? se(z1 + ";", c1, a1, l1 - 1) : se(y(z1, " ", "") + ";", c1, a1, l1 - 2), i1);
                    break;
                case 59:
                    z1 += ";";
                default:
                    O(j1 = ne(z1, r1, a1, f1, o1, n1, u1, m1, g1 = [], x1 = [], l1), t1);
                    if (k1 === 123) {
                        if (o1 === 0) ce(z1, r1, j1, j1, g1, t1, l1, u1, x1);
                        else switch(v1){
                            case 100:
                            case 109:
                            case 115:
                                ce(e1, j1, j1, c1 && O(ne(e1, j1, j1, 0, 0, n1, u1, m1, n1, g1 = [], l1), x1), n1, x1, l1, u1, c1 ? g1 : x1);
                                break;
                            default:
                                ce(z1, j1, j1, j1, [
                                    ""
                                ], x1, l1, u1, x1);
                        }
                    }
            }
            f1 = o1 = h1 = 0, b1 = $1 = 1, m1 = z1 = "", l1 = s1;
            break;
        case 58:
            l1 = 1 + A(z1), h1 = p1;
        default:
            if (b1 < 1) {
                if (k1 == 123) --b1;
                else if (k1 == 125 && (b1++) == 0 && K() == 125) continue;
            }
            switch(z1 += d(k1), k1 * b1){
                case 38:
                    $1 = o1 > 0 ? 1 : (z1 += "\f", -1);
                    break;
                case 44:
                    u1[f1++] = (A(z1) - 1) * $1, $1 = 1;
                    break;
                case 64:
                    if (N() === 45) z1 += V(L());
                    v1 = N(), o1 = A(m1 = z1 += re(P())), k1++;
                    break;
                case 45:
                    if (p1 === 45 && A(z1) == 2) b1 = 0;
            }
    }
    return t1;
}
function ne(e1, r1, a1, c1, t1, s1, u1, i1, f1, o1, l1) {
    var v1 = t1 - 1;
    var h1 = t1 === 0 ? s1 : [
        ""
    ];
    var p1 = M(h1);
    for(var b1 = 0, w1 = 0, $1 = 0; b1 < c1; ++b1)for(var d1 = 0, m1 = C(e1, v1 + 1, v1 = k(w1 = u1[b1])), x1 = e1; d1 < p1; ++d1)if (x1 = g(w1 > 0 ? h1[d1] + " " + m1 : y(m1, /&\f/g, h1[d1]))) f1[$1++] = x1;
    return H(e1, r1, a1, t1 === 0 ? n : i1, f1, o1, l1);
}
function te(e1, r1, a1) {
    return H(e1, r1, a1, c, d(J()), C(e1, 2, -2), 0);
}
function se(e1, r1, a1, c1) {
    return H(e1, r1, a1, t, C(e1, 0, c1), C(e1, c1 + 1, -1), c1);
}
function ue(c1, n1) {
    switch(m(c1, n1)){
        case 5103:
            return a + "print-" + c1 + c1;
        case 5737:
        case 4201:
        case 3177:
        case 3433:
        case 1641:
        case 4457:
        case 2921:
        case 5572:
        case 6356:
        case 5844:
        case 3191:
        case 6645:
        case 3005:
        case 6391:
        case 5879:
        case 5623:
        case 6135:
        case 4599:
        case 4855:
        case 4215:
        case 6389:
        case 5109:
        case 5365:
        case 5621:
        case 3829:
            return a + c1 + c1;
        case 5349:
        case 4246:
        case 4810:
        case 6968:
        case 2756:
            return a + c1 + r + c1 + e + c1 + c1;
        case 6828:
        case 4268:
            return a + c1 + e + c1 + c1;
        case 6165:
            return a + c1 + e + "flex-" + c1 + c1;
        case 5187:
            return a + c1 + y(c1, /(\w+).+(:[^]+)/, a + "box-$1$2" + e + "flex-$1$2") + c1;
        case 5443:
            return a + c1 + e + "flex-item-" + y(c1, /flex-|-self/, "") + c1;
        case 4675:
            return a + c1 + e + "flex-line-pack" + y(c1, /align-content|flex-|-self/, "") + c1;
        case 5548:
            return a + c1 + e + y(c1, "shrink", "negative") + c1;
        case 5292:
            return a + c1 + e + y(c1, "basis", "preferred-size") + c1;
        case 6060:
            return a + "box-" + y(c1, "-grow", "") + a + c1 + e + y(c1, "grow", "positive") + c1;
        case 4554:
            return a + y(c1, /([^-])(transform)/g, "$1" + a + "$2") + c1;
        case 6187:
            return y(y(y(c1, /(zoom-|grab)/, a + "$1"), /(image-set)/, a + "$1"), c1, "") + c1;
        case 5495:
        case 3959:
            return y(c1, /(image-set\([^]*)/, a + "$1" + "$`$1");
        case 4968:
            return y(y(c1, /(.+:)(flex-)?(.*)/, a + "box-pack:$3" + e + "flex-pack:$3"), /s.+-b[^;]+/, "justify") + a + c1 + c1;
        case 4095:
        case 3583:
        case 4068:
        case 2532:
            return y(c1, /(.+)-inline(.+)/, a + "$1$2") + c1;
        case 8116:
        case 7059:
        case 5753:
        case 5535:
        case 5445:
        case 5701:
        case 4933:
        case 4677:
        case 5533:
        case 5789:
        case 5021:
        case 4765:
            if (A(c1) - 1 - n1 > 6) switch(z(c1, n1 + 1)){
                case 109:
                    if (z(c1, n1 + 4) !== 45) break;
                case 102:
                    return y(c1, /(.+:)(.+)-([^]+)/, "$1" + a + "$2-$3" + "$1" + r + (z(c1, n1 + 3) == 108 ? "$3" : "$2-$3")) + c1;
                case 115:
                    return ~j(c1, "stretch") ? ue(y(c1, "stretch", "fill-available"), n1) + c1 : c1;
            }
            break;
        case 4949:
            if (z(c1, n1 + 1) !== 115) break;
        case 6444:
            switch(z(c1, A(c1) - 3 - (~j(c1, "!important") && 10))){
                case 107:
                    return y(c1, ":", ":" + a) + c1;
                case 101:
                    return y(c1, /(.+:)([^;!]+)(;|!.+)?/, "$1" + a + (z(c1, 14) === 45 ? "inline-" : "") + "box$3" + "$1" + a + "$2$3" + "$1" + e + "$2box$3") + c1;
            }
            break;
        case 5936:
            switch(z(c1, n1 + 11)){
                case 114:
                    return a + c1 + e + y(c1, /[svh]\w+-[tblr]{2}/, "tb") + c1;
                case 108:
                    return a + c1 + e + y(c1, /[svh]\w+-[tblr]{2}/, "tb-rl") + c1;
                case 45:
                    return a + c1 + e + y(c1, /[svh]\w+-[tblr]{2}/, "lr") + c1;
            }
            return a + c1 + e + c1 + c1;
    }
    return c1;
}
function ie(e1, r1) {
    var a1 = "";
    var c1 = M(e1);
    for(var n1 = 0; n1 < c1; n1++)a1 += r1(e1[n1], n1, e1, r1) || "";
    return a1;
}
function fe(e1, r1, a1, s1) {
    switch(e1.type){
        case i:
        case t:
            return e1.return = e1.return || e1.value;
        case c:
            return "";
        case n:
            e1.value = e1.props.join(",");
    }
    return A(a1 = ie(e1.children, s1)) ? e1.return = e1.value + "{" + a1 + "}" : "";
}
function oe(e1) {
    var r1 = M(e1);
    return function(a1, c1, n1, t1) {
        var s1 = "";
        for(var u1 = 0; u1 < r1; u1++)s1 += e1[u1](a1, c1, n1, t1) || "";
        return s1;
    };
}
function le(e1) {
    return function(r1) {
        if (!r1.root) {
            if (r1 = r1.return) e1(r1);
        }
    };
}
function ve(c1, s1, u1, i1) {
    if (!c1.return) switch(c1.type){
        case t:
            c1.return = ue(c1.value, c1.length);
            break;
        case p:
            return ie([
                I(y(c1.value, "@", "@" + a), c1, "")
            ], i1);
        case n:
            if (c1.length) return S(c1.props, function(n1) {
                switch(x(n1, /(::plac\w+|:read-\w+)/)){
                    case ":read-only":
                    case ":read-write":
                        return ie([
                            I(y(n1, /:(read-\w+)/, ":" + r + "$1"), c1, "")
                        ], i1);
                    case "::placeholder":
                        return ie([
                            I(y(n1, /:(plac\w+)/, ":" + a + "input-$1"), c1, ""),
                            I(y(n1, /:(plac\w+)/, ":" + r + "$1"), c1, ""),
                            I(y(n1, /:(plac\w+)/, e + "input-$1"), c1, "")
                        ], i1);
                }
                return "";
            });
    }
}
function he(e1) {
    switch(e1.type){
        case n:
            e1.props = e1.props.map(function(r1) {
                return S(W(r1), function(r2, a1, c1) {
                    switch(z(r2, 0)){
                        case 12:
                            return C(r2, 1, A(r2));
                        case 0:
                        case 40:
                        case 43:
                        case 62:
                        case 126:
                            return r2;
                        case 58:
                            if (c1[++a1] === "global") c1[a1] = "", c1[++a1] = "\f" + C(c1[a1], a1 = 1, -1);
                        case 32:
                            return a1 === 1 ? "" : r2;
                        default:
                            switch(a1){
                                case 0:
                                    e1 = r2;
                                    return M(c1) > 1 ? "" : r2;
                                case a1 = M(c1) - 1:
                                case 2:
                                    return a1 === 2 ? r2 + e1 + e1 : r2 + e1;
                                default:
                                    return r2;
                            }
                    }
                });
            });
    }
}

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"f50WZ":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var weakMemoize = function weakMemoize1(func) {
    // $FlowFixMe flow doesn't include all non-primitive types as allowed for weakmaps
    var cache = new WeakMap();
    return function(arg) {
        if (cache.has(arg)) // $FlowFixMe
        return cache.get(arg);
        var ret = func(arg);
        cache.set(arg, ret);
        return ret;
    };
};
exports.default = weakMemoize;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"WdjGJ":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function memoize(fn) {
    var cache = Object.create(null);
    return function(arg) {
        if (cache[arg] === undefined) cache[arg] = fn(arg);
        return cache[arg];
    };
}
exports.default = memoize;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"klZCZ":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "C", ()=>CacheProvider
);
parcelHelpers.export(exports, "E", ()=>Emotion
);
parcelHelpers.export(exports, "T", ()=>ThemeContext
);
parcelHelpers.export(exports, "_", ()=>__unsafe_useEmotionCache
);
parcelHelpers.export(exports, "a", ()=>ThemeProvider
);
parcelHelpers.export(exports, "b", ()=>withTheme
);
parcelHelpers.export(exports, "c", ()=>createEmotionProps
);
parcelHelpers.export(exports, "h", ()=>hasOwnProperty
);
parcelHelpers.export(exports, "u", ()=>useTheme
);
parcelHelpers.export(exports, "w", ()=>withEmotionCache
);
var _react = require("react");
var _cache = require("@emotion/cache");
var _cacheDefault = parcelHelpers.interopDefault(_cache);
var _extends = require("@babel/runtime/helpers/esm/extends");
var _extendsDefault = parcelHelpers.interopDefault(_extends);
var _weakMemoize = require("@emotion/weak-memoize");
var _weakMemoizeDefault = parcelHelpers.interopDefault(_weakMemoize);
// import hoistNonReactStatics from '../isolated-hoist-non-react-statics-do-not-use-this-in-your-code/dist/emotion-react-isolated-hoist-non-react-statics-do-not-use-this-in-your-code.browser.esm.js';
var _hoistNonReactStatics = require("hoist-non-react-statics");
var _hoistNonReactStaticsDefault = parcelHelpers.interopDefault(_hoistNonReactStatics);
var _utils = require("@emotion/utils");
var _serialize = require("@emotion/serialize");
var hasOwnProperty = Object.prototype.hasOwnProperty;
var EmotionCacheContext = /* #__PURE__ */ _react.createContext(// because this module is primarily intended for the browser and node
// but it's also required in react native and similar environments sometimes
// and we could have a special build just for that
// but this is much easier and the native packages
// might use a different theme context in the future anyway
typeof HTMLElement !== 'undefined' ? /* #__PURE__ */ _cacheDefault.default({
    key: 'css'
}) : null);
EmotionCacheContext.displayName = 'EmotionCacheContext';
var CacheProvider = EmotionCacheContext.Provider;
var __unsafe_useEmotionCache = function useEmotionCache() {
    return _react.useContext(EmotionCacheContext);
};
var withEmotionCache = function withEmotionCache1(func) {
    // $FlowFixMe
    return(/*#__PURE__*/ _react.forwardRef(function(props, ref) {
        // the cache will never be null in the browser
        var cache = _react.useContext(EmotionCacheContext);
        return func(props, cache, ref);
    }));
};
var ThemeContext = /* #__PURE__ */ _react.createContext({
});
ThemeContext.displayName = 'EmotionThemeContext';
var useTheme = function useTheme1() {
    return _react.useContext(ThemeContext);
};
var getTheme = function getTheme1(outerTheme, theme) {
    if (typeof theme === 'function') {
        var mergedTheme = theme(outerTheme);
        if (mergedTheme == null || typeof mergedTheme !== 'object' || Array.isArray(mergedTheme)) throw new Error('[ThemeProvider] Please return an object from your theme function, i.e. theme={() => ({})}!');
        return mergedTheme;
    }
    if (theme == null || typeof theme !== 'object' || Array.isArray(theme)) throw new Error('[ThemeProvider] Please make your theme prop a plain object');
    return _extendsDefault.default({
    }, outerTheme, theme);
};
var createCacheWithTheme = /* #__PURE__ */ _weakMemoizeDefault.default(function(outerTheme) {
    return _weakMemoizeDefault.default(function(theme) {
        return getTheme(outerTheme, theme);
    });
});
var ThemeProvider = function ThemeProvider1(props) {
    var theme = _react.useContext(ThemeContext);
    if (props.theme !== theme) theme = createCacheWithTheme(theme)(props.theme);
    return(/*#__PURE__*/ _react.createElement(ThemeContext.Provider, {
        value: theme
    }, props.children));
};
function withTheme(Component) {
    var componentName = Component.displayName || Component.name || 'Component';
    var render = function render1(props, ref) {
        var theme = _react.useContext(ThemeContext);
        return(/*#__PURE__*/ _react.createElement(Component, _extendsDefault.default({
            theme: theme,
            ref: ref
        }, props)));
    }; // $FlowFixMe
    var WithTheme = /*#__PURE__*/ _react.forwardRef(render);
    WithTheme.displayName = "WithTheme(" + componentName + ")";
    return _hoistNonReactStaticsDefault.default(WithTheme, Component);
}
// thus we only need to replace what is a valid character for JS, but not for CSS
var sanitizeIdentifier = function sanitizeIdentifier1(identifier) {
    return identifier.replace(/\$/g, '-');
};
var typePropName = '__EMOTION_TYPE_PLEASE_DO_NOT_USE__';
var labelPropName = '__EMOTION_LABEL_PLEASE_DO_NOT_USE__';
var createEmotionProps = function createEmotionProps1(type, props) {
    if (typeof props.css === 'string' && props.css.indexOf(':') !== -1) throw new Error("Strings are not allowed as css prop values, please wrap it in a css template literal from '@emotion/react' like this: css`" + props.css + "`");
    var newProps = {
    };
    for(var key in props)if (hasOwnProperty.call(props, key)) newProps[key] = props[key];
    newProps[typePropName] = type;
    var error = new Error();
    if (error.stack) {
        // chrome
        var match = error.stack.match(/at (?:Object\.|Module\.|)(?:jsx|createEmotionProps).*\n\s+at (?:Object\.|)([A-Z][A-Za-z0-9$]+) /);
        if (!match) // safari and firefox
        match = error.stack.match(/.*\n([A-Z][A-Za-z0-9$]+)@/);
        if (match) newProps[labelPropName] = sanitizeIdentifier(match[1]);
    }
    return newProps;
};
var Emotion = /* #__PURE__ */ withEmotionCache(function(props, cache, ref) {
    var cssProp = props.css; // so that using `css` from `emotion` and passing the result to the css prop works
    // not passing the registered cache to serializeStyles because it would
    // make certain babel optimisations not possible
    if (typeof cssProp === 'string' && cache.registered[cssProp] !== undefined) cssProp = cache.registered[cssProp];
    var type = props[typePropName];
    var registeredStyles = [
        cssProp
    ];
    var className = '';
    if (typeof props.className === 'string') className = _utils.getRegisteredStyles(cache.registered, registeredStyles, props.className);
    else if (props.className != null) className = props.className + " ";
    var serialized = _serialize.serializeStyles(registeredStyles, undefined, _react.useContext(ThemeContext));
    if (serialized.name.indexOf('-') === -1) {
        var labelFromStack = props[labelPropName];
        if (labelFromStack) serialized = _serialize.serializeStyles([
            serialized,
            'label:' + labelFromStack + ';'
        ]);
    }
    var rules = _utils.insertStyles(cache, serialized, typeof type === 'string');
    className += cache.key + "-" + serialized.name;
    var newProps = {
    };
    for(var key in props)if (hasOwnProperty.call(props, key) && key !== 'css' && key !== typePropName && key !== labelPropName) newProps[key] = props[key];
    newProps.ref = ref;
    newProps.className = className;
    var ele = /*#__PURE__*/ _react.createElement(type, newProps);
    return ele;
});
Emotion.displayName = 'EmotionCssPropInternal';

},{"react":"bE4sN","@emotion/cache":"83lJK","@babel/runtime/helpers/esm/extends":"6kJrr","@emotion/weak-memoize":"f50WZ","hoist-non-react-statics":"5t68n","@emotion/utils":"2kmdx","@emotion/serialize":"6hzKH","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"5t68n":[function(require,module,exports) {
'use strict';
var reactIs = require('react-is');
/**
 * Copyright 2015, Yahoo! Inc.
 * Copyrights licensed under the New BSD License. See the accompanying LICENSE file for terms.
 */ var REACT_STATICS = {
    childContextTypes: true,
    contextType: true,
    contextTypes: true,
    defaultProps: true,
    displayName: true,
    getDefaultProps: true,
    getDerivedStateFromError: true,
    getDerivedStateFromProps: true,
    mixins: true,
    propTypes: true,
    type: true
};
var KNOWN_STATICS = {
    name: true,
    length: true,
    prototype: true,
    caller: true,
    callee: true,
    arguments: true,
    arity: true
};
var FORWARD_REF_STATICS = {
    '$$typeof': true,
    render: true,
    defaultProps: true,
    displayName: true,
    propTypes: true
};
var MEMO_STATICS = {
    '$$typeof': true,
    compare: true,
    defaultProps: true,
    displayName: true,
    propTypes: true,
    type: true
};
var TYPE_STATICS = {
};
TYPE_STATICS[reactIs.ForwardRef] = FORWARD_REF_STATICS;
TYPE_STATICS[reactIs.Memo] = MEMO_STATICS;
function getStatics(component) {
    // React v16.11 and below
    if (reactIs.isMemo(component)) return MEMO_STATICS;
     // React v16.12 and above
    return TYPE_STATICS[component['$$typeof']] || REACT_STATICS;
}
var defineProperty = Object.defineProperty;
var getOwnPropertyNames = Object.getOwnPropertyNames;
var getOwnPropertySymbols = Object.getOwnPropertySymbols;
var getOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;
var getPrototypeOf = Object.getPrototypeOf;
var objectPrototype = Object.prototype;
function hoistNonReactStatics(targetComponent, sourceComponent, blacklist) {
    if (typeof sourceComponent !== 'string') {
        // don't hoist over string (html) components
        if (objectPrototype) {
            var inheritedComponent = getPrototypeOf(sourceComponent);
            if (inheritedComponent && inheritedComponent !== objectPrototype) hoistNonReactStatics(targetComponent, inheritedComponent, blacklist);
        }
        var keys = getOwnPropertyNames(sourceComponent);
        if (getOwnPropertySymbols) keys = keys.concat(getOwnPropertySymbols(sourceComponent));
        var targetStatics = getStatics(targetComponent);
        var sourceStatics = getStatics(sourceComponent);
        for(var i = 0; i < keys.length; ++i){
            var key = keys[i];
            if (!KNOWN_STATICS[key] && !(blacklist && blacklist[key]) && !(sourceStatics && sourceStatics[key]) && !(targetStatics && targetStatics[key])) {
                var descriptor = getOwnPropertyDescriptor(sourceComponent, key);
                try {
                    // Avoid failures from read-only properties
                    defineProperty(targetComponent, key, descriptor);
                } catch (e) {
                }
            }
        }
    }
    return targetComponent;
}
module.exports = hoistNonReactStatics;

},{"react-is":"fN6Vw"}],"fN6Vw":[function(require,module,exports) {
'use strict';
module.exports = require('./cjs/react-is.development.js');

},{"./cjs/react-is.development.js":"9SPWR"}],"9SPWR":[function(require,module,exports) {
/** @license React v16.13.1
 * react-is.development.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */ 'use strict';
(function() {
    // The Symbol used to tag the ReactElement-like types. If there is no native Symbol
    // nor polyfill, then a plain number is used for performance.
    var hasSymbol = typeof Symbol === 'function' && Symbol.for;
    var REACT_ELEMENT_TYPE = hasSymbol ? Symbol.for('react.element') : 60103;
    var REACT_PORTAL_TYPE = hasSymbol ? Symbol.for('react.portal') : 60106;
    var REACT_FRAGMENT_TYPE = hasSymbol ? Symbol.for('react.fragment') : 60107;
    var REACT_STRICT_MODE_TYPE = hasSymbol ? Symbol.for('react.strict_mode') : 60108;
    var REACT_PROFILER_TYPE = hasSymbol ? Symbol.for('react.profiler') : 60114;
    var REACT_PROVIDER_TYPE = hasSymbol ? Symbol.for('react.provider') : 60109;
    var REACT_CONTEXT_TYPE = hasSymbol ? Symbol.for('react.context') : 60110; // TODO: We don't use AsyncMode or ConcurrentMode anymore. They were temporary
    // (unstable) APIs that have been removed. Can we remove the symbols?
    var REACT_ASYNC_MODE_TYPE = hasSymbol ? Symbol.for('react.async_mode') : 60111;
    var REACT_CONCURRENT_MODE_TYPE = hasSymbol ? Symbol.for('react.concurrent_mode') : 60111;
    var REACT_FORWARD_REF_TYPE = hasSymbol ? Symbol.for('react.forward_ref') : 60112;
    var REACT_SUSPENSE_TYPE = hasSymbol ? Symbol.for('react.suspense') : 60113;
    var REACT_SUSPENSE_LIST_TYPE = hasSymbol ? Symbol.for('react.suspense_list') : 60120;
    var REACT_MEMO_TYPE = hasSymbol ? Symbol.for('react.memo') : 60115;
    var REACT_LAZY_TYPE = hasSymbol ? Symbol.for('react.lazy') : 60116;
    var REACT_BLOCK_TYPE = hasSymbol ? Symbol.for('react.block') : 60121;
    var REACT_FUNDAMENTAL_TYPE = hasSymbol ? Symbol.for('react.fundamental') : 60117;
    var REACT_RESPONDER_TYPE = hasSymbol ? Symbol.for('react.responder') : 60118;
    var REACT_SCOPE_TYPE = hasSymbol ? Symbol.for('react.scope') : 60119;
    function isValidElementType(type) {
        return typeof type === 'string' || typeof type === 'function' || type === REACT_FRAGMENT_TYPE || type === REACT_CONCURRENT_MODE_TYPE || type === REACT_PROFILER_TYPE || type === REACT_STRICT_MODE_TYPE || type === REACT_SUSPENSE_TYPE || type === REACT_SUSPENSE_LIST_TYPE || typeof type === 'object' && type !== null && (type.$$typeof === REACT_LAZY_TYPE || type.$$typeof === REACT_MEMO_TYPE || type.$$typeof === REACT_PROVIDER_TYPE || type.$$typeof === REACT_CONTEXT_TYPE || type.$$typeof === REACT_FORWARD_REF_TYPE || type.$$typeof === REACT_FUNDAMENTAL_TYPE || type.$$typeof === REACT_RESPONDER_TYPE || type.$$typeof === REACT_SCOPE_TYPE || type.$$typeof === REACT_BLOCK_TYPE);
    }
    function typeOf(object) {
        if (typeof object === 'object' && object !== null) {
            var $$typeof = object.$$typeof;
            switch($$typeof){
                case REACT_ELEMENT_TYPE:
                    var type = object.type;
                    switch(type){
                        case REACT_ASYNC_MODE_TYPE:
                        case REACT_CONCURRENT_MODE_TYPE:
                        case REACT_FRAGMENT_TYPE:
                        case REACT_PROFILER_TYPE:
                        case REACT_STRICT_MODE_TYPE:
                        case REACT_SUSPENSE_TYPE:
                            return type;
                        default:
                            var $$typeofType = type && type.$$typeof;
                            switch($$typeofType){
                                case REACT_CONTEXT_TYPE:
                                case REACT_FORWARD_REF_TYPE:
                                case REACT_LAZY_TYPE:
                                case REACT_MEMO_TYPE:
                                case REACT_PROVIDER_TYPE:
                                    return $$typeofType;
                                default:
                                    return $$typeof;
                            }
                    }
                case REACT_PORTAL_TYPE:
                    return $$typeof;
            }
        }
        return undefined;
    } // AsyncMode is deprecated along with isAsyncMode
    var AsyncMode = REACT_ASYNC_MODE_TYPE;
    var ConcurrentMode = REACT_CONCURRENT_MODE_TYPE;
    var ContextConsumer = REACT_CONTEXT_TYPE;
    var ContextProvider = REACT_PROVIDER_TYPE;
    var Element1 = REACT_ELEMENT_TYPE;
    var ForwardRef = REACT_FORWARD_REF_TYPE;
    var Fragment = REACT_FRAGMENT_TYPE;
    var Lazy = REACT_LAZY_TYPE;
    var Memo = REACT_MEMO_TYPE;
    var Portal = REACT_PORTAL_TYPE;
    var Profiler = REACT_PROFILER_TYPE;
    var StrictMode = REACT_STRICT_MODE_TYPE;
    var Suspense = REACT_SUSPENSE_TYPE;
    var hasWarnedAboutDeprecatedIsAsyncMode = false; // AsyncMode should be deprecated
    function isAsyncMode(object) {
        if (!hasWarnedAboutDeprecatedIsAsyncMode) {
            hasWarnedAboutDeprecatedIsAsyncMode = true; // Using console['warn'] to evade Babel and ESLint
            console['warn']("The ReactIs.isAsyncMode() alias has been deprecated, and will be removed in React 17+. Update your code to use ReactIs.isConcurrentMode() instead. It has the exact same API.");
        }
        return isConcurrentMode(object) || typeOf(object) === REACT_ASYNC_MODE_TYPE;
    }
    function isConcurrentMode(object) {
        return typeOf(object) === REACT_CONCURRENT_MODE_TYPE;
    }
    function isContextConsumer(object) {
        return typeOf(object) === REACT_CONTEXT_TYPE;
    }
    function isContextProvider(object) {
        return typeOf(object) === REACT_PROVIDER_TYPE;
    }
    function isElement(object) {
        return typeof object === 'object' && object !== null && object.$$typeof === REACT_ELEMENT_TYPE;
    }
    function isForwardRef(object) {
        return typeOf(object) === REACT_FORWARD_REF_TYPE;
    }
    function isFragment(object) {
        return typeOf(object) === REACT_FRAGMENT_TYPE;
    }
    function isLazy(object) {
        return typeOf(object) === REACT_LAZY_TYPE;
    }
    function isMemo(object) {
        return typeOf(object) === REACT_MEMO_TYPE;
    }
    function isPortal(object) {
        return typeOf(object) === REACT_PORTAL_TYPE;
    }
    function isProfiler(object) {
        return typeOf(object) === REACT_PROFILER_TYPE;
    }
    function isStrictMode(object) {
        return typeOf(object) === REACT_STRICT_MODE_TYPE;
    }
    function isSuspense(object) {
        return typeOf(object) === REACT_SUSPENSE_TYPE;
    }
    exports.AsyncMode = AsyncMode;
    exports.ConcurrentMode = ConcurrentMode;
    exports.ContextConsumer = ContextConsumer;
    exports.ContextProvider = ContextProvider;
    exports.Element = Element1;
    exports.ForwardRef = ForwardRef;
    exports.Fragment = Fragment;
    exports.Lazy = Lazy;
    exports.Memo = Memo;
    exports.Portal = Portal;
    exports.Profiler = Profiler;
    exports.StrictMode = StrictMode;
    exports.Suspense = Suspense;
    exports.isAsyncMode = isAsyncMode;
    exports.isConcurrentMode = isConcurrentMode;
    exports.isContextConsumer = isContextConsumer;
    exports.isContextProvider = isContextProvider;
    exports.isElement = isElement;
    exports.isForwardRef = isForwardRef;
    exports.isFragment = isFragment;
    exports.isLazy = isLazy;
    exports.isMemo = isMemo;
    exports.isPortal = isPortal;
    exports.isProfiler = isProfiler;
    exports.isStrictMode = isStrictMode;
    exports.isSuspense = isSuspense;
    exports.isValidElementType = isValidElementType;
    exports.typeOf = typeOf;
})();

},{}],"2kmdx":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "getRegisteredStyles", ()=>getRegisteredStyles
);
parcelHelpers.export(exports, "insertStyles", ()=>insertStyles
);
var isBrowser = true;
function getRegisteredStyles(registered, registeredStyles, classNames) {
    var rawClassName = '';
    classNames.split(' ').forEach(function(className) {
        if (registered[className] !== undefined) registeredStyles.push(registered[className] + ";");
        else rawClassName += className + " ";
    });
    return rawClassName;
}
var insertStyles = function insertStyles1(cache, serialized, isStringTag) {
    var className = cache.key + "-" + serialized.name;
    if (// class name could be used further down
    // the tree but if it's a string tag, we know it won't
    // so we don't have to add it to registered cache.
    // this improves memory usage since we can avoid storing the whole style string
    (isStringTag === false || // in node since emotion-server relies on whether a style is in
    // the registered cache to know whether a style is global or not
    // also, note that this check will be dead code eliminated in the browser
    isBrowser === false) && cache.registered[className] === undefined) cache.registered[className] = serialized.styles;
    if (cache.inserted[serialized.name] === undefined) {
        var current = serialized;
        do {
            var maybeStyles = cache.insert(serialized === current ? "." + className : '', current, cache.sheet, true);
            current = current.next;
        }while (current !== undefined)
    }
};

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"6hzKH":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "serializeStyles", ()=>serializeStyles
);
var _hash = require("@emotion/hash");
var _hashDefault = parcelHelpers.interopDefault(_hash);
var _unitless = require("@emotion/unitless");
var _unitlessDefault = parcelHelpers.interopDefault(_unitless);
var _memoize = require("@emotion/memoize");
var _memoizeDefault = parcelHelpers.interopDefault(_memoize);
var ILLEGAL_ESCAPE_SEQUENCE_ERROR = "You have illegal escape sequence in your template literal, most likely inside content's property value.\nBecause you write your CSS inside a JavaScript string you actually have to do double escaping, so for example \"content: '\\00d7';\" should become \"content: '\\\\00d7';\".\nYou can read more about this here:\nhttps://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals#ES2018_revision_of_illegal_escape_sequences";
var UNDEFINED_AS_OBJECT_KEY_ERROR = "You have passed in falsy value as style object's key (can happen when in example you pass unexported component as computed key).";
var hyphenateRegex = /[A-Z]|^ms/g;
var animationRegex = /_EMO_([^_]+?)_([^]*?)_EMO_/g;
var isCustomProperty = function isCustomProperty1(property) {
    return property.charCodeAt(1) === 45;
};
var isProcessableValue = function isProcessableValue1(value) {
    return value != null && typeof value !== 'boolean';
};
var processStyleName = /* #__PURE__ */ _memoizeDefault.default(function(styleName) {
    return isCustomProperty(styleName) ? styleName : styleName.replace(hyphenateRegex, '-$&').toLowerCase();
});
var processStyleValue = function processStyleValue1(key, value) {
    switch(key){
        case 'animation':
        case 'animationName':
            if (typeof value === 'string') return value.replace(animationRegex, function(match, p1, p2) {
                cursor = {
                    name: p1,
                    styles: p2,
                    next: cursor
                };
                return p1;
            });
    }
    if (_unitlessDefault.default[key] !== 1 && !isCustomProperty(key) && typeof value === 'number' && value !== 0) return value + 'px';
    return value;
};
var contentValuePattern = /(attr|counters?|url|(((repeating-)?(linear|radial))|conic)-gradient)\(|(no-)?(open|close)-quote/;
var contentValues = [
    'normal',
    'none',
    'initial',
    'inherit',
    'unset'
];
var oldProcessStyleValue = processStyleValue;
var msPattern = /^-ms-/;
var hyphenPattern = /-(.)/g;
var hyphenatedCache = {
};
processStyleValue = function processStyleValue2(key, value) {
    if (key === 'content') {
        if (typeof value !== 'string' || contentValues.indexOf(value) === -1 && !contentValuePattern.test(value) && (value.charAt(0) !== value.charAt(value.length - 1) || value.charAt(0) !== '"' && value.charAt(0) !== "'")) throw new Error("You seem to be using a value for 'content' without quotes, try replacing it with `content: '\"" + value + "\"'`");
    }
    var processed = oldProcessStyleValue(key, value);
    if (processed !== '' && !isCustomProperty(key) && key.indexOf('-') !== -1 && hyphenatedCache[key] === undefined) {
        hyphenatedCache[key] = true;
        console.error("Using kebab-case for css properties in objects is not supported. Did you mean " + key.replace(msPattern, 'ms-').replace(hyphenPattern, function(str, _char) {
            return _char.toUpperCase();
        }) + "?");
    }
    return processed;
};
function handleInterpolation(mergedProps, registered, interpolation) {
    if (interpolation == null) return '';
    if (interpolation.__emotion_styles !== undefined) {
        if (interpolation.toString() === 'NO_COMPONENT_SELECTOR') throw new Error('Component selectors can only be used in conjunction with @emotion/babel-plugin.');
        return interpolation;
    }
    switch(typeof interpolation){
        case 'boolean':
            return '';
        case 'object':
            if (interpolation.anim === 1) {
                cursor = {
                    name: interpolation.name,
                    styles: interpolation.styles,
                    next: cursor
                };
                return interpolation.name;
            }
            if (interpolation.styles !== undefined) {
                var next = interpolation.next;
                if (next !== undefined) // not the most efficient thing ever but this is a pretty rare case
                // and there will be very few iterations of this generally
                while(next !== undefined){
                    cursor = {
                        name: next.name,
                        styles: next.styles,
                        next: cursor
                    };
                    next = next.next;
                }
                var styles = interpolation.styles + ";";
                if (interpolation.map !== undefined) styles += interpolation.map;
                return styles;
            }
            return createStringFromObject(mergedProps, registered, interpolation);
        case 'function':
            if (mergedProps !== undefined) {
                var previousCursor = cursor;
                var result = interpolation(mergedProps);
                cursor = previousCursor;
                return handleInterpolation(mergedProps, registered, result);
            } else console.error("Functions that are interpolated in css calls will be stringified.\nIf you want to have a css call based on props, create a function that returns a css call like this\nlet dynamicStyle = (props) => css`color: ${props.color}`\nIt can be called directly with props or interpolated in a styled call like this\nlet SomeComponent = styled('div')`${dynamicStyle}`");
            break;
        case 'string':
            var matched = [];
            var replaced = interpolation.replace(animationRegex, function(match, p1, p2) {
                var fakeVarName = "animation" + matched.length;
                matched.push("const " + fakeVarName + " = keyframes`" + p2.replace(/^@keyframes animation-\w+/, '') + "`");
                return "${" + fakeVarName + "}";
            });
            if (matched.length) console.error("`keyframes` output got interpolated into plain string, please wrap it with `css`.\n\nInstead of doing this:\n\n" + [].concat(matched, [
                "`" + replaced + "`"
            ]).join('\n') + '\n\nYou should wrap it with `css` like this:\n\n' + ("css`" + replaced + "`"));
            break;
    } // finalize string values (regular strings and functions interpolated into css calls)
    if (registered == null) return interpolation;
    var cached = registered[interpolation];
    return cached !== undefined ? cached : interpolation;
}
function createStringFromObject(mergedProps, registered, obj) {
    var string = '';
    if (Array.isArray(obj)) for(var i = 0; i < obj.length; i++)string += handleInterpolation(mergedProps, registered, obj[i]) + ";";
    else for(var _key in obj){
        var value = obj[_key];
        if (typeof value !== 'object') {
            if (registered != null && registered[value] !== undefined) string += _key + "{" + registered[value] + "}";
            else if (isProcessableValue(value)) string += processStyleName(_key) + ":" + processStyleValue(_key, value) + ";";
        } else {
            if (_key === 'NO_COMPONENT_SELECTOR' && true) throw new Error('Component selectors can only be used in conjunction with @emotion/babel-plugin.');
            if (Array.isArray(value) && typeof value[0] === 'string' && (registered == null || registered[value[0]] === undefined)) {
                for(var _i = 0; _i < value.length; _i++)if (isProcessableValue(value[_i])) string += processStyleName(_key) + ":" + processStyleValue(_key, value[_i]) + ";";
            } else {
                var interpolated = handleInterpolation(mergedProps, registered, value);
                switch(_key){
                    case 'animation':
                    case 'animationName':
                        string += processStyleName(_key) + ":" + interpolated + ";";
                        break;
                    default:
                        if (_key === 'undefined') console.error(UNDEFINED_AS_OBJECT_KEY_ERROR);
                        string += _key + "{" + interpolated + "}";
                }
            }
        }
    }
    return string;
}
var labelPattern = /label:\s*([^\s;\n{]+)\s*(;|$)/g;
var sourceMapPattern;
sourceMapPattern = /\/\*#\ssourceMappingURL=data:application\/json;\S+\s+\*\//g;
// keyframes are stored on the SerializedStyles object as a linked list
var cursor;
var serializeStyles = function serializeStyles1(args, registered, mergedProps) {
    if (args.length === 1 && typeof args[0] === 'object' && args[0] !== null && args[0].styles !== undefined) return args[0];
    var stringMode = true;
    var styles = '';
    cursor = undefined;
    var strings = args[0];
    if (strings == null || strings.raw === undefined) {
        stringMode = false;
        styles += handleInterpolation(mergedProps, registered, strings);
    } else {
        if (strings[0] === undefined) console.error(ILLEGAL_ESCAPE_SEQUENCE_ERROR);
        styles += strings[0];
    } // we start at 1 since we've already handled the first arg
    for(var i = 1; i < args.length; i++){
        styles += handleInterpolation(mergedProps, registered, args[i]);
        if (stringMode) {
            if (strings[i] === undefined) console.error(ILLEGAL_ESCAPE_SEQUENCE_ERROR);
            styles += strings[i];
        }
    }
    var sourceMap;
    styles = styles.replace(sourceMapPattern, function(match) {
        sourceMap = match;
        return '';
    });
    labelPattern.lastIndex = 0;
    var identifierName = '';
    var match; // https://esbench.com/bench/5b809c2cf2949800a0f61fb5
    while((match = labelPattern.exec(styles)) !== null)identifierName += '-' + match[1];
    var name = _hashDefault.default(styles) + identifierName;
    // $FlowFixMe SerializedStyles type doesn't have toString property (and we don't want to add it)
    return {
        name: name,
        styles: styles,
        map: sourceMap,
        next: cursor,
        toString: function toString() {
            return "You have tried to stringify object returned from `css` function. It isn't supposed to be used directly (e.g. as value of the `className` prop), but rather handed to emotion so it can handle it (e.g. as value of `css` prop).";
        }
    };
};

},{"@emotion/hash":"fgs44","@emotion/unitless":"3EmXY","@emotion/memoize":"WdjGJ","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"fgs44":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
/* eslint-disable */ // Inspired by https://github.com/garycourt/murmurhash-js
// Ported from https://github.com/aappleby/smhasher/blob/61a0530f28277f2e850bfc39600ce61d02b518de/src/MurmurHash2.cpp#L37-L86
function murmur2(str) {
    // 'm' and 'r' are mixing constants generated offline.
    // They're not really 'magic', they just happen to work well.
    // const m = 0x5bd1e995;
    // const r = 24;
    // Initialize the hash
    var h = 0; // Mix 4 bytes at a time into the hash
    var k, i = 0, len = str.length;
    for(; len >= 4; ++i, len -= 4){
        k = str.charCodeAt(i) & 255 | (str.charCodeAt(++i) & 255) << 8 | (str.charCodeAt(++i) & 255) << 16 | (str.charCodeAt(++i) & 255) << 24;
        k = /* Math.imul(k, m): */ (k & 65535) * 1540483477 + ((k >>> 16) * 59797 << 16);
        k ^= /* k >>> r: */ k >>> 24;
        h = /* Math.imul(k, m): */ (k & 65535) * 1540483477 + ((k >>> 16) * 59797 << 16) ^ /* Math.imul(h, m): */ (h & 65535) * 1540483477 + ((h >>> 16) * 59797 << 16);
    } // Handle the last few bytes of the input array
    switch(len){
        case 3:
            h ^= (str.charCodeAt(i + 2) & 255) << 16;
        case 2:
            h ^= (str.charCodeAt(i + 1) & 255) << 8;
        case 1:
            h ^= str.charCodeAt(i) & 255;
            h = /* Math.imul(h, m): */ (h & 65535) * 1540483477 + ((h >>> 16) * 59797 << 16);
    } // Do a few final mixes of the hash to ensure the last few
    // bytes are well-incorporated.
    h ^= h >>> 13;
    h = /* Math.imul(h, m): */ (h & 65535) * 1540483477 + ((h >>> 16) * 59797 << 16);
    return ((h ^ h >>> 15) >>> 0).toString(36);
}
exports.default = murmur2;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"3EmXY":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var unitlessKeys = {
    animationIterationCount: 1,
    borderImageOutset: 1,
    borderImageSlice: 1,
    borderImageWidth: 1,
    boxFlex: 1,
    boxFlexGroup: 1,
    boxOrdinalGroup: 1,
    columnCount: 1,
    columns: 1,
    flex: 1,
    flexGrow: 1,
    flexPositive: 1,
    flexShrink: 1,
    flexNegative: 1,
    flexOrder: 1,
    gridRow: 1,
    gridRowEnd: 1,
    gridRowSpan: 1,
    gridRowStart: 1,
    gridColumn: 1,
    gridColumnEnd: 1,
    gridColumnSpan: 1,
    gridColumnStart: 1,
    msGridRow: 1,
    msGridRowSpan: 1,
    msGridColumn: 1,
    msGridColumnSpan: 1,
    fontWeight: 1,
    lineHeight: 1,
    opacity: 1,
    order: 1,
    orphans: 1,
    tabSize: 1,
    widows: 1,
    zIndex: 1,
    zoom: 1,
    WebkitLineClamp: 1,
    // SVG-related properties
    fillOpacity: 1,
    floodOpacity: 1,
    stopOpacity: 1,
    strokeDasharray: 1,
    strokeDashoffset: 1,
    strokeMiterlimit: 1,
    strokeOpacity: 1,
    strokeWidth: 1
};
exports.default = unitlessKeys;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"gs4XN":[function(require,module,exports) {
function _extends() {
    module.exports = _extends = Object.assign || function(target) {
        for(var i = 1; i < arguments.length; i++){
            var source = arguments[i];
            for(var key in source)if (Object.prototype.hasOwnProperty.call(source, key)) target[key] = source[key];
        }
        return target;
    };
    module.exports["default"] = module.exports, module.exports.__esModule = true;
    return _extends.apply(this, arguments);
}
module.exports = _extends;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{}],"6T52e":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _taggedTemplateLiteral(strings, raw) {
    if (!raw) raw = strings.slice(0);
    return Object.freeze(Object.defineProperties(strings, {
        raw: {
            value: Object.freeze(raw)
        }
    }));
}
exports.default = _taggedTemplateLiteral;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"hRPaM":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _objectWithoutPropertiesLooseJs = require("./objectWithoutPropertiesLoose.js");
var _objectWithoutPropertiesLooseJsDefault = parcelHelpers.interopDefault(_objectWithoutPropertiesLooseJs);
function _objectWithoutProperties(source, excluded) {
    if (source == null) return {
    };
    var target = _objectWithoutPropertiesLooseJsDefault.default(source, excluded);
    var key, i;
    if (Object.getOwnPropertySymbols) {
        var sourceSymbolKeys = Object.getOwnPropertySymbols(source);
        for(i = 0; i < sourceSymbolKeys.length; i++){
            key = sourceSymbolKeys[i];
            if (excluded.indexOf(key) >= 0) continue;
            if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
            target[key] = source[key];
        }
    }
    return target;
}
exports.default = _objectWithoutProperties;

},{"./objectWithoutPropertiesLoose.js":"6fbC1","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"6fbC1":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _objectWithoutPropertiesLoose(source, excluded) {
    if (source == null) return {
    };
    var target = {
    };
    var sourceKeys = Object.keys(source);
    var key, i;
    for(i = 0; i < sourceKeys.length; i++){
        key = sourceKeys[i];
        if (excluded.indexOf(key) >= 0) continue;
        target[key] = source[key];
    }
    return target;
}
exports.default = _objectWithoutPropertiesLoose;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"3U77u":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _typeof(obj) {
    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") _typeof = function _typeof1(obj1) {
        return typeof obj1;
    };
    else _typeof = function _typeof2(obj1) {
        return obj1 && typeof Symbol === "function" && obj1.constructor === Symbol && obj1 !== Symbol.prototype ? "symbol" : typeof obj1;
    };
    return _typeof(obj);
}
exports.default = _typeof;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"4dKpO":[function(require,module,exports) {
'use strict';
Object.defineProperty(exports, "__esModule", {
    value: true
});
var _extends = Object.assign || function(target) {
    for(var i = 1; i < arguments.length; i++){
        var source = arguments[i];
        for(var key in source)if (Object.prototype.hasOwnProperty.call(source, key)) target[key] = source[key];
    }
    return target;
};
var _createClass = function() {
    function defineProperties(target, props) {
        for(var i = 0; i < props.length; i++){
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ("value" in descriptor) descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
        }
    }
    return function(Constructor, protoProps, staticProps) {
        if (protoProps) defineProperties(Constructor.prototype, protoProps);
        if (staticProps) defineProperties(Constructor, staticProps);
        return Constructor;
    };
}();
var _react = require('react');
var _react2 = _interopRequireDefault(_react);
var _propTypes = require('prop-types');
var _propTypes2 = _interopRequireDefault(_propTypes);
function _interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
function _objectWithoutProperties(obj, keys) {
    var target = {
    };
    for(var i in obj){
        if (keys.indexOf(i) >= 0) continue;
        if (!Object.prototype.hasOwnProperty.call(obj, i)) continue;
        target[i] = obj[i];
    }
    return target;
}
function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) throw new TypeError("Cannot call a class as a function");
}
function _possibleConstructorReturn(self, call) {
    if (!self) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    return call && (typeof call === "object" || typeof call === "function") ? call : self;
}
function _inherits(subClass, superClass) {
    if (typeof superClass !== "function" && superClass !== null) throw new TypeError("Super expression must either be null or a function, not " + typeof superClass);
    subClass.prototype = Object.create(superClass && superClass.prototype, {
        constructor: {
            value: subClass,
            enumerable: false,
            writable: true,
            configurable: true
        }
    });
    if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass;
}
var sizerStyle = {
    position: 'absolute',
    top: 0,
    left: 0,
    visibility: 'hidden',
    height: 0,
    overflow: 'scroll',
    whiteSpace: 'pre'
};
var INPUT_PROPS_BLACKLIST = [
    'extraWidth',
    'injectStyles',
    'inputClassName',
    'inputRef',
    'inputStyle',
    'minWidth',
    'onAutosize',
    'placeholderIsMinWidth'
];
var cleanInputProps = function cleanInputProps1(inputProps) {
    INPUT_PROPS_BLACKLIST.forEach(function(field) {
        return delete inputProps[field];
    });
    return inputProps;
};
var copyStyles = function copyStyles1(styles, node) {
    node.style.fontSize = styles.fontSize;
    node.style.fontFamily = styles.fontFamily;
    node.style.fontWeight = styles.fontWeight;
    node.style.fontStyle = styles.fontStyle;
    node.style.letterSpacing = styles.letterSpacing;
    node.style.textTransform = styles.textTransform;
};
var isIE = typeof window !== 'undefined' && window.navigator ? /MSIE |Trident\/|Edge\//.test(window.navigator.userAgent) : false;
var generateId = function generateId1() {
    // we only need an auto-generated ID for stylesheet injection, which is only
    // used for IE. so if the browser is not IE, this should return undefined.
    return isIE ? '_' + Math.random().toString(36).substr(2, 12) : undefined;
};
var AutosizeInput1 = function(_Component) {
    _inherits(AutosizeInput2, _Component);
    _createClass(AutosizeInput2, null, [
        {
            key: 'getDerivedStateFromProps',
            value: function getDerivedStateFromProps(props, state) {
                var id = props.id;
                return id !== state.prevId ? {
                    inputId: id || generateId(),
                    prevId: id
                } : null;
            }
        }
    ]);
    function AutosizeInput2(props) {
        _classCallCheck(this, AutosizeInput2);
        var _this = _possibleConstructorReturn(this, (AutosizeInput2.__proto__ || Object.getPrototypeOf(AutosizeInput2)).call(this, props));
        _this.inputRef = function(el) {
            _this.input = el;
            if (typeof _this.props.inputRef === 'function') _this.props.inputRef(el);
        };
        _this.placeHolderSizerRef = function(el) {
            _this.placeHolderSizer = el;
        };
        _this.sizerRef = function(el) {
            _this.sizer = el;
        };
        _this.state = {
            inputWidth: props.minWidth,
            inputId: props.id || generateId(),
            prevId: props.id
        };
        return _this;
    }
    _createClass(AutosizeInput2, [
        {
            key: 'componentDidMount',
            value: function componentDidMount() {
                this.mounted = true;
                this.copyInputStyles();
                this.updateInputWidth();
            }
        },
        {
            key: 'componentDidUpdate',
            value: function componentDidUpdate(prevProps, prevState) {
                if (prevState.inputWidth !== this.state.inputWidth) {
                    if (typeof this.props.onAutosize === 'function') this.props.onAutosize(this.state.inputWidth);
                }
                this.updateInputWidth();
            }
        },
        {
            key: 'componentWillUnmount',
            value: function componentWillUnmount() {
                this.mounted = false;
            }
        },
        {
            key: 'copyInputStyles',
            value: function copyInputStyles() {
                if (!this.mounted || !window.getComputedStyle) return;
                var inputStyles = this.input && window.getComputedStyle(this.input);
                if (!inputStyles) return;
                copyStyles(inputStyles, this.sizer);
                if (this.placeHolderSizer) copyStyles(inputStyles, this.placeHolderSizer);
            }
        },
        {
            key: 'updateInputWidth',
            value: function updateInputWidth() {
                if (!this.mounted || !this.sizer || typeof this.sizer.scrollWidth === 'undefined') return;
                var newInputWidth = void 0;
                if (this.props.placeholder && (!this.props.value || this.props.value && this.props.placeholderIsMinWidth)) newInputWidth = Math.max(this.sizer.scrollWidth, this.placeHolderSizer.scrollWidth) + 2;
                else newInputWidth = this.sizer.scrollWidth + 2;
                // add extraWidth to the detected width. for number types, this defaults to 16 to allow for the stepper UI
                var extraWidth = this.props.type === 'number' && this.props.extraWidth === undefined ? 16 : parseInt(this.props.extraWidth) || 0;
                newInputWidth += extraWidth;
                if (newInputWidth < this.props.minWidth) newInputWidth = this.props.minWidth;
                if (newInputWidth !== this.state.inputWidth) this.setState({
                    inputWidth: newInputWidth
                });
            }
        },
        {
            key: 'getInput',
            value: function getInput() {
                return this.input;
            }
        },
        {
            key: 'focus',
            value: function focus() {
                this.input.focus();
            }
        },
        {
            key: 'blur',
            value: function blur() {
                this.input.blur();
            }
        },
        {
            key: 'select',
            value: function select() {
                this.input.select();
            }
        },
        {
            key: 'renderStyles',
            value: function renderStyles() {
                // this method injects styles to hide IE's clear indicator, which messes
                // with input size detection. the stylesheet is only injected when the
                // browser is IE, and can also be disabled by the `injectStyles` prop.
                var injectStyles = this.props.injectStyles;
                return isIE && injectStyles ? _react2.default.createElement('style', {
                    dangerouslySetInnerHTML: {
                        __html: 'input#' + this.state.inputId + '::-ms-clear {display: none;}'
                    }
                }) : null;
            }
        },
        {
            key: 'render',
            value: function render() {
                var sizerValue = [
                    this.props.defaultValue,
                    this.props.value,
                    ''
                ].reduce(function(previousValue, currentValue) {
                    if (previousValue !== null && previousValue !== undefined) return previousValue;
                    return currentValue;
                });
                var wrapperStyle = _extends({
                }, this.props.style);
                if (!wrapperStyle.display) wrapperStyle.display = 'inline-block';
                var inputStyle = _extends({
                    boxSizing: 'content-box',
                    width: this.state.inputWidth + 'px'
                }, this.props.inputStyle);
                var inputProps = _objectWithoutProperties(this.props, []);
                cleanInputProps(inputProps);
                inputProps.className = this.props.inputClassName;
                inputProps.id = this.state.inputId;
                inputProps.style = inputStyle;
                return _react2.default.createElement('div', {
                    className: this.props.className,
                    style: wrapperStyle
                }, this.renderStyles(), _react2.default.createElement('input', _extends({
                }, inputProps, {
                    ref: this.inputRef
                })), _react2.default.createElement('div', {
                    ref: this.sizerRef,
                    style: sizerStyle
                }, sizerValue), this.props.placeholder ? _react2.default.createElement('div', {
                    ref: this.placeHolderSizerRef,
                    style: sizerStyle
                }, this.props.placeholder) : null);
            }
        }
    ]);
    return AutosizeInput2;
}(_react.Component);
AutosizeInput1.propTypes = {
    className: _propTypes2.default.string,
    defaultValue: _propTypes2.default.any,
    extraWidth: _propTypes2.default.oneOfType([
        _propTypes2.default.number,
        _propTypes2.default.string
    ]),
    id: _propTypes2.default.string,
    injectStyles: _propTypes2.default.bool,
    inputClassName: _propTypes2.default.string,
    inputRef: _propTypes2.default.func,
    inputStyle: _propTypes2.default.object,
    minWidth: _propTypes2.default.oneOfType([
        _propTypes2.default.number,
        _propTypes2.default.string
    ]),
    onAutosize: _propTypes2.default.func,
    onChange: _propTypes2.default.func,
    placeholder: _propTypes2.default.string,
    placeholderIsMinWidth: _propTypes2.default.bool,
    style: _propTypes2.default.object,
    value: _propTypes2.default.any // field value
};
AutosizeInput1.defaultProps = {
    minWidth: 1,
    injectStyles: true
};
exports.default = AutosizeInput1;

},{"react":"bE4sN","prop-types":"grdYW"}],"grdYW":[function(require,module,exports) {
var ReactIs = require('react-is');
// By explicitly using `prop-types` you are opting into new development behavior.
// http://fb.me/prop-types-in-prod
var throwOnDirectAccess = true;
module.exports = require('./factoryWithTypeCheckers')(ReactIs.isElement, throwOnDirectAccess);

},{"react-is":"fN6Vw","./factoryWithTypeCheckers":"9o3g6"}],"9o3g6":[function(require,module,exports) {
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */ 'use strict';
var ReactIs = require('react-is');
var assign = require('object-assign');
var ReactPropTypesSecret = require('./lib/ReactPropTypesSecret');
var checkPropTypes = require('./checkPropTypes');
var has = Function.call.bind(Object.prototype.hasOwnProperty);
var printWarning = function() {
};
printWarning = function(text) {
    var message = 'Warning: ' + text;
    if (typeof console !== 'undefined') console.error(message);
    try {
        // --- Welcome to debugging React ---
        // This error was thrown as a convenience so that you can use this stack
        // to find the callsite that caused this warning to fire.
        throw new Error(message);
    } catch (x) {
    }
};
function emptyFunctionThatReturnsNull() {
    return null;
}
module.exports = function(isValidElement, throwOnDirectAccess) {
    /* global Symbol */ var ITERATOR_SYMBOL = typeof Symbol === 'function' && Symbol.iterator;
    var FAUX_ITERATOR_SYMBOL = '@@iterator'; // Before Symbol spec.
    /**
   * Returns the iterator method function contained on the iterable object.
   *
   * Be sure to invoke the function with the iterable as context:
   *
   *     var iteratorFn = getIteratorFn(myIterable);
   *     if (iteratorFn) {
   *       var iterator = iteratorFn.call(myIterable);
   *       ...
   *     }
   *
   * @param {?object} maybeIterable
   * @return {?function}
   */ function getIteratorFn(maybeIterable) {
        var iteratorFn = maybeIterable && (ITERATOR_SYMBOL && maybeIterable[ITERATOR_SYMBOL] || maybeIterable[FAUX_ITERATOR_SYMBOL]);
        if (typeof iteratorFn === 'function') return iteratorFn;
    }
    /**
   * Collection of methods that allow declaration and validation of props that are
   * supplied to React components. Example usage:
   *
   *   var Props = require('ReactPropTypes');
   *   var MyArticle = React.createClass({
   *     propTypes: {
   *       // An optional string prop named "description".
   *       description: Props.string,
   *
   *       // A required enum prop named "category".
   *       category: Props.oneOf(['News','Photos']).isRequired,
   *
   *       // A prop named "dialog" that requires an instance of Dialog.
   *       dialog: Props.instanceOf(Dialog).isRequired
   *     },
   *     render: function() { ... }
   *   });
   *
   * A more formal specification of how these methods are used:
   *
   *   type := array|bool|func|object|number|string|oneOf([...])|instanceOf(...)
   *   decl := ReactPropTypes.{type}(.isRequired)?
   *
   * Each and every declaration produces a function with the same signature. This
   * allows the creation of custom validation functions. For example:
   *
   *  var MyLink = React.createClass({
   *    propTypes: {
   *      // An optional string or URI prop named "href".
   *      href: function(props, propName, componentName) {
   *        var propValue = props[propName];
   *        if (propValue != null && typeof propValue !== 'string' &&
   *            !(propValue instanceof URI)) {
   *          return new Error(
   *            'Expected a string or an URI for ' + propName + ' in ' +
   *            componentName
   *          );
   *        }
   *      }
   *    },
   *    render: function() {...}
   *  });
   *
   * @internal
   */ var ANONYMOUS = '<<anonymous>>';
    // Important!
    // Keep this list in sync with production version in `./factoryWithThrowingShims.js`.
    var ReactPropTypes = {
        array: createPrimitiveTypeChecker('array'),
        bool: createPrimitiveTypeChecker('boolean'),
        func: createPrimitiveTypeChecker('function'),
        number: createPrimitiveTypeChecker('number'),
        object: createPrimitiveTypeChecker('object'),
        string: createPrimitiveTypeChecker('string'),
        symbol: createPrimitiveTypeChecker('symbol'),
        any: createAnyTypeChecker(),
        arrayOf: createArrayOfTypeChecker,
        element: createElementTypeChecker(),
        elementType: createElementTypeTypeChecker(),
        instanceOf: createInstanceTypeChecker,
        node: createNodeChecker(),
        objectOf: createObjectOfTypeChecker,
        oneOf: createEnumTypeChecker,
        oneOfType: createUnionTypeChecker,
        shape: createShapeTypeChecker,
        exact: createStrictShapeTypeChecker
    };
    /**
   * inlined Object.is polyfill to avoid requiring consumers ship their own
   * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/is
   */ /*eslint-disable no-self-compare*/ function is(x, y) {
        // SameValue algorithm
        if (x === y) // Steps 1-5, 7-10
        // Steps 6.b-6.e: +0 != -0
        return x !== 0 || 1 / x === 1 / y;
        else // Step 6.a: NaN == NaN
        return x !== x && y !== y;
    }
    /*eslint-enable no-self-compare*/ /**
   * We use an Error-like object for backward compatibility as people may call
   * PropTypes directly and inspect their output. However, we don't use real
   * Errors anymore. We don't inspect their stack anyway, and creating them
   * is prohibitively expensive if they are created too often, such as what
   * happens in oneOfType() for any type before the one that matched.
   */ function PropTypeError(message) {
        this.message = message;
        this.stack = '';
    }
    // Make `instanceof Error` still work for returned errors.
    PropTypeError.prototype = Error.prototype;
    function createChainableTypeChecker(validate) {
        var manualPropTypeCallCache = {
        };
        var manualPropTypeWarningCount = 0;
        function checkType(isRequired, props, propName, componentName, location, propFullName, secret) {
            componentName = componentName || ANONYMOUS;
            propFullName = propFullName || propName;
            if (secret !== ReactPropTypesSecret) {
                if (throwOnDirectAccess) {
                    // New behavior only for users of `prop-types` package
                    var err = new Error("Calling PropTypes validators directly is not supported by the `prop-types` package. Use `PropTypes.checkPropTypes()` to call them. Read more at http://fb.me/use-check-prop-types");
                    err.name = 'Invariant Violation';
                    throw err;
                } else if (typeof console !== 'undefined') {
                    // Old behavior for people using React.PropTypes
                    var cacheKey = componentName + ':' + propName;
                    if (!manualPropTypeCallCache[cacheKey] && // Avoid spamming the console because they are often not actionable except for lib authors
                    manualPropTypeWarningCount < 3) {
                        printWarning("You are manually calling a React.PropTypes validation function for the `" + propFullName + '` prop on `' + componentName + '`. This is deprecated ' + 'and will throw in the standalone `prop-types` package. ' + 'You may be seeing this warning due to a third-party PropTypes ' + 'library. See https://fb.me/react-warning-dont-call-proptypes ' + 'for details.');
                        manualPropTypeCallCache[cacheKey] = true;
                        manualPropTypeWarningCount++;
                    }
                }
            }
            if (props[propName] == null) {
                if (isRequired) {
                    if (props[propName] === null) return new PropTypeError('The ' + location + ' `' + propFullName + '` is marked as required ' + ('in `' + componentName + '`, but its value is `null`.'));
                    return new PropTypeError('The ' + location + ' `' + propFullName + '` is marked as required in ' + ('`' + componentName + '`, but its value is `undefined`.'));
                }
                return null;
            } else return validate(props, propName, componentName, location, propFullName);
        }
        var chainedCheckType = checkType.bind(null, false);
        chainedCheckType.isRequired = checkType.bind(null, true);
        return chainedCheckType;
    }
    function createPrimitiveTypeChecker(expectedType) {
        function validate(props, propName, componentName, location, propFullName, secret) {
            var propValue = props[propName];
            var propType = getPropType(propValue);
            if (propType !== expectedType) {
                // `propValue` being instance of, say, date/regexp, pass the 'object'
                // check, but we can offer a more precise error message here rather than
                // 'of type `object`'.
                var preciseType = getPreciseType(propValue);
                return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + preciseType + '` supplied to `' + componentName + '`, expected ') + ('`' + expectedType + '`.'));
            }
            return null;
        }
        return createChainableTypeChecker(validate);
    }
    function createAnyTypeChecker() {
        return createChainableTypeChecker(emptyFunctionThatReturnsNull);
    }
    function createArrayOfTypeChecker(typeChecker) {
        function validate(props, propName, componentName, location, propFullName) {
            if (typeof typeChecker !== 'function') return new PropTypeError('Property `' + propFullName + '` of component `' + componentName + '` has invalid PropType notation inside arrayOf.');
            var propValue = props[propName];
            if (!Array.isArray(propValue)) {
                var propType = getPropType(propValue);
                return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + propType + '` supplied to `' + componentName + '`, expected an array.'));
            }
            for(var i = 0; i < propValue.length; i++){
                var error = typeChecker(propValue, i, componentName, location, propFullName + '[' + i + ']', ReactPropTypesSecret);
                if (error instanceof Error) return error;
            }
            return null;
        }
        return createChainableTypeChecker(validate);
    }
    function createElementTypeChecker() {
        function validate(props, propName, componentName, location, propFullName) {
            var propValue = props[propName];
            if (!isValidElement(propValue)) {
                var propType = getPropType(propValue);
                return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + propType + '` supplied to `' + componentName + '`, expected a single ReactElement.'));
            }
            return null;
        }
        return createChainableTypeChecker(validate);
    }
    function createElementTypeTypeChecker() {
        function validate(props, propName, componentName, location, propFullName) {
            var propValue = props[propName];
            if (!ReactIs.isValidElementType(propValue)) {
                var propType = getPropType(propValue);
                return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + propType + '` supplied to `' + componentName + '`, expected a single ReactElement type.'));
            }
            return null;
        }
        return createChainableTypeChecker(validate);
    }
    function createInstanceTypeChecker(expectedClass) {
        function validate(props, propName, componentName, location, propFullName) {
            if (!(props[propName] instanceof expectedClass)) {
                var expectedClassName = expectedClass.name || ANONYMOUS;
                var actualClassName = getClassName(props[propName]);
                return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + actualClassName + '` supplied to `' + componentName + '`, expected ') + ('instance of `' + expectedClassName + '`.'));
            }
            return null;
        }
        return createChainableTypeChecker(validate);
    }
    function createEnumTypeChecker(expectedValues) {
        if (!Array.isArray(expectedValues)) {
            {
                if (arguments.length > 1) printWarning('Invalid arguments supplied to oneOf, expected an array, got ' + arguments.length + ' arguments. ' + 'A common mistake is to write oneOf(x, y, z) instead of oneOf([x, y, z]).');
                else printWarning('Invalid argument supplied to oneOf, expected an array.');
            }
            return emptyFunctionThatReturnsNull;
        }
        function validate(props, propName, componentName, location, propFullName) {
            var propValue = props[propName];
            for(var i = 0; i < expectedValues.length; i++){
                if (is(propValue, expectedValues[i])) return null;
            }
            var valuesString = JSON.stringify(expectedValues, function replacer(key, value) {
                var type = getPreciseType(value);
                if (type === 'symbol') return String(value);
                return value;
            });
            return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of value `' + String(propValue) + '` ' + ('supplied to `' + componentName + '`, expected one of ' + valuesString + '.'));
        }
        return createChainableTypeChecker(validate);
    }
    function createObjectOfTypeChecker(typeChecker) {
        function validate(props, propName, componentName, location, propFullName) {
            if (typeof typeChecker !== 'function') return new PropTypeError('Property `' + propFullName + '` of component `' + componentName + '` has invalid PropType notation inside objectOf.');
            var propValue = props[propName];
            var propType = getPropType(propValue);
            if (propType !== 'object') return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + propType + '` supplied to `' + componentName + '`, expected an object.'));
            for(var key in propValue)if (has(propValue, key)) {
                var error = typeChecker(propValue, key, componentName, location, propFullName + '.' + key, ReactPropTypesSecret);
                if (error instanceof Error) return error;
            }
            return null;
        }
        return createChainableTypeChecker(validate);
    }
    function createUnionTypeChecker(arrayOfTypeCheckers) {
        if (!Array.isArray(arrayOfTypeCheckers)) {
            printWarning('Invalid argument supplied to oneOfType, expected an instance of array.');
            return emptyFunctionThatReturnsNull;
        }
        for(var i = 0; i < arrayOfTypeCheckers.length; i++){
            var checker = arrayOfTypeCheckers[i];
            if (typeof checker !== 'function') {
                printWarning("Invalid argument supplied to oneOfType. Expected an array of check functions, but received " + getPostfixForTypeWarning(checker) + ' at index ' + i + '.');
                return emptyFunctionThatReturnsNull;
            }
        }
        function validate(props, propName, componentName, location, propFullName) {
            for(var i1 = 0; i1 < arrayOfTypeCheckers.length; i1++){
                var checker = arrayOfTypeCheckers[i1];
                if (checker(props, propName, componentName, location, propFullName, ReactPropTypesSecret) == null) return null;
            }
            return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` supplied to ' + ('`' + componentName + '`.'));
        }
        return createChainableTypeChecker(validate);
    }
    function createNodeChecker() {
        function validate(props, propName, componentName, location, propFullName) {
            if (!isNode(props[propName])) return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` supplied to ' + ('`' + componentName + '`, expected a ReactNode.'));
            return null;
        }
        return createChainableTypeChecker(validate);
    }
    function createShapeTypeChecker(shapeTypes) {
        function validate(props, propName, componentName, location, propFullName) {
            var propValue = props[propName];
            var propType = getPropType(propValue);
            if (propType !== 'object') return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type `' + propType + '` ' + ('supplied to `' + componentName + '`, expected `object`.'));
            for(var key in shapeTypes){
                var checker = shapeTypes[key];
                if (!checker) continue;
                var error = checker(propValue, key, componentName, location, propFullName + '.' + key, ReactPropTypesSecret);
                if (error) return error;
            }
            return null;
        }
        return createChainableTypeChecker(validate);
    }
    function createStrictShapeTypeChecker(shapeTypes) {
        function validate(props, propName, componentName, location, propFullName) {
            var propValue = props[propName];
            var propType = getPropType(propValue);
            if (propType !== 'object') return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type `' + propType + '` ' + ('supplied to `' + componentName + '`, expected `object`.'));
            // We need to check all keys in case some are required but missing from
            // props.
            var allKeys = assign({
            }, props[propName], shapeTypes);
            for(var key in allKeys){
                var checker = shapeTypes[key];
                if (!checker) return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` key `' + key + '` supplied to `' + componentName + '`.' + '\nBad object: ' + JSON.stringify(props[propName], null, '  ') + '\nValid keys: ' + JSON.stringify(Object.keys(shapeTypes), null, '  '));
                var error = checker(propValue, key, componentName, location, propFullName + '.' + key, ReactPropTypesSecret);
                if (error) return error;
            }
            return null;
        }
        return createChainableTypeChecker(validate);
    }
    function isNode(propValue) {
        switch(typeof propValue){
            case 'number':
            case 'string':
            case 'undefined':
                return true;
            case 'boolean':
                return !propValue;
            case 'object':
                if (Array.isArray(propValue)) return propValue.every(isNode);
                if (propValue === null || isValidElement(propValue)) return true;
                var iteratorFn = getIteratorFn(propValue);
                if (iteratorFn) {
                    var iterator = iteratorFn.call(propValue);
                    var step;
                    if (iteratorFn !== propValue.entries) while(!(step = iterator.next()).done){
                        if (!isNode(step.value)) return false;
                    }
                    else // Iterator will provide entry [k,v] tuples rather than values.
                    while(!(step = iterator.next()).done){
                        var entry = step.value;
                        if (entry) {
                            if (!isNode(entry[1])) return false;
                        }
                    }
                } else return false;
                return true;
            default:
                return false;
        }
    }
    function isSymbol(propType, propValue) {
        // Native Symbol.
        if (propType === 'symbol') return true;
        // falsy value can't be a Symbol
        if (!propValue) return false;
        // 19.4.3.5 Symbol.prototype[@@toStringTag] === 'Symbol'
        if (propValue['@@toStringTag'] === 'Symbol') return true;
        // Fallback for non-spec compliant Symbols which are polyfilled.
        if (typeof Symbol === 'function' && propValue instanceof Symbol) return true;
        return false;
    }
    // Equivalent of `typeof` but with special handling for array and regexp.
    function getPropType(propValue) {
        var propType = typeof propValue;
        if (Array.isArray(propValue)) return 'array';
        if (propValue instanceof RegExp) // Old webkits (at least until Android 4.0) return 'function' rather than
        // 'object' for typeof a RegExp. We'll normalize this here so that /bla/
        // passes PropTypes.object.
        return 'object';
        if (isSymbol(propType, propValue)) return 'symbol';
        return propType;
    }
    // This handles more types than `getPropType`. Only used for error messages.
    // See `createPrimitiveTypeChecker`.
    function getPreciseType(propValue) {
        if (typeof propValue === 'undefined' || propValue === null) return '' + propValue;
        var propType = getPropType(propValue);
        if (propType === 'object') {
            if (propValue instanceof Date) return 'date';
            else if (propValue instanceof RegExp) return 'regexp';
        }
        return propType;
    }
    // Returns a string that is postfixed to a warning about an invalid type.
    // For example, "undefined" or "of type array"
    function getPostfixForTypeWarning(value) {
        var type = getPreciseType(value);
        switch(type){
            case 'array':
            case 'object':
                return 'an ' + type;
            case 'boolean':
            case 'date':
            case 'regexp':
                return 'a ' + type;
            default:
                return type;
        }
    }
    // Returns class name of the object, if any.
    function getClassName(propValue) {
        if (!propValue.constructor || !propValue.constructor.name) return ANONYMOUS;
        return propValue.constructor.name;
    }
    ReactPropTypes.checkPropTypes = checkPropTypes;
    ReactPropTypes.resetWarningCache = checkPropTypes.resetWarningCache;
    ReactPropTypes.PropTypes = ReactPropTypes;
    return ReactPropTypes;
};

},{"react-is":"fN6Vw","object-assign":"11eso","./lib/ReactPropTypesSecret":"aN3R3","./checkPropTypes":"aiqo8"}],"11eso":[function(require,module,exports) {
/*
object-assign
(c) Sindre Sorhus
@license MIT
*/ 'use strict';
/* eslint-disable no-unused-vars */ var getOwnPropertySymbols = Object.getOwnPropertySymbols;
var hasOwnProperty = Object.prototype.hasOwnProperty;
var propIsEnumerable = Object.prototype.propertyIsEnumerable;
function toObject(val) {
    if (val === null || val === undefined) throw new TypeError('Object.assign cannot be called with null or undefined');
    return Object(val);
}
function shouldUseNative() {
    try {
        if (!Object.assign) return false;
        // Detect buggy property enumeration order in older V8 versions.
        // https://bugs.chromium.org/p/v8/issues/detail?id=4118
        var test1 = "abc"; // eslint-disable-line no-new-wrappers
        test1[5] = 'de';
        if (Object.getOwnPropertyNames(test1)[0] === '5') return false;
        // https://bugs.chromium.org/p/v8/issues/detail?id=3056
        var test2 = {
        };
        for(var i = 0; i < 10; i++)test2['_' + String.fromCharCode(i)] = i;
        var order2 = Object.getOwnPropertyNames(test2).map(function(n) {
            return test2[n];
        });
        if (order2.join('') !== '0123456789') return false;
        // https://bugs.chromium.org/p/v8/issues/detail?id=3056
        var test3 = {
        };
        'abcdefghijklmnopqrst'.split('').forEach(function(letter) {
            test3[letter] = letter;
        });
        if (Object.keys(Object.assign({
        }, test3)).join('') !== 'abcdefghijklmnopqrst') return false;
        return true;
    } catch (err) {
        // We don't expect any of the above to throw, but better to be safe.
        return false;
    }
}
module.exports = shouldUseNative() ? Object.assign : function(target, source) {
    var from;
    var to = toObject(target);
    var symbols;
    for(var s = 1; s < arguments.length; s++){
        from = Object(arguments[s]);
        for(var key in from)if (hasOwnProperty.call(from, key)) to[key] = from[key];
        if (getOwnPropertySymbols) {
            symbols = getOwnPropertySymbols(from);
            for(var i = 0; i < symbols.length; i++)if (propIsEnumerable.call(from, symbols[i])) to[symbols[i]] = from[symbols[i]];
        }
    }
    return to;
};

},{}],"aN3R3":[function(require,module,exports) {
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */ 'use strict';
var ReactPropTypesSecret = 'SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED';
module.exports = ReactPropTypesSecret;

},{}],"aiqo8":[function(require,module,exports) {
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */ 'use strict';
var printWarning = function() {
};
var ReactPropTypesSecret = require('./lib/ReactPropTypesSecret');
var loggedTypeFailures = {
};
var has = Function.call.bind(Object.prototype.hasOwnProperty);
printWarning = function(text) {
    var message = 'Warning: ' + text;
    if (typeof console !== 'undefined') console.error(message);
    try {
        // --- Welcome to debugging React ---
        // This error was thrown as a convenience so that you can use this stack
        // to find the callsite that caused this warning to fire.
        throw new Error(message);
    } catch (x) {
    }
};
/**
 * Assert that the values match with the type specs.
 * Error messages are memorized and will only be shown once.
 *
 * @param {object} typeSpecs Map of name to a ReactPropType
 * @param {object} values Runtime values that need to be type-checked
 * @param {string} location e.g. "prop", "context", "child context"
 * @param {string} componentName Name of the component for error messages.
 * @param {?Function} getStack Returns the component stack.
 * @private
 */ function checkPropTypes(typeSpecs, values, location, componentName, getStack) {
    for(var typeSpecName in typeSpecs)if (has(typeSpecs, typeSpecName)) {
        var error;
        // Prop type validation may throw. In case they do, we don't want to
        // fail the render phase where it didn't fail before. So we log it.
        // After these have been cleaned up, we'll let them throw.
        try {
            // This is intentionally an invariant that gets caught. It's the same
            // behavior as without this statement except with a better message.
            if (typeof typeSpecs[typeSpecName] !== 'function') {
                var err = Error((componentName || 'React class') + ': ' + location + ' type `' + typeSpecName + '` is invalid; ' + 'it must be a function, usually from the `prop-types` package, but received `' + typeof typeSpecs[typeSpecName] + '`.');
                err.name = 'Invariant Violation';
                throw err;
            }
            error = typeSpecs[typeSpecName](values, typeSpecName, componentName, location, null, ReactPropTypesSecret);
        } catch (ex) {
            error = ex;
        }
        if (error && !(error instanceof Error)) printWarning((componentName || 'React class') + ': type specification of ' + location + ' `' + typeSpecName + '` is invalid; the type checker ' + 'function must return `null` or an `Error` but returned a ' + typeof error + '. ' + 'You may have forgotten to pass an argument to the type checker ' + 'creator (arrayOf, instanceOf, objectOf, oneOf, oneOfType, and ' + 'shape all require an argument).');
        if (error instanceof Error && !(error.message in loggedTypeFailures)) {
            // Only monitor this failure once because there tends to be a lot of the
            // same error.
            loggedTypeFailures[error.message] = true;
            var stack = getStack ? getStack() : '';
            printWarning('Failed ' + location + ' type: ' + error.message + (stack != null ? stack : ''));
        }
    }
}
/**
 * Resets warning cache when testing.
 *
 * @private
 */ checkPropTypes.resetWarningCache = function() {
    loggedTypeFailures = {
    };
};
module.exports = checkPropTypes;

},{"./lib/ReactPropTypesSecret":"aN3R3"}],"kcrhl":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) throw new TypeError("Cannot call a class as a function");
}
exports.default = _classCallCheck;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"bETt6":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _defineProperties(target, props) {
    for(var i = 0; i < props.length; i++){
        var descriptor = props[i];
        descriptor.enumerable = descriptor.enumerable || false;
        descriptor.configurable = true;
        if ("value" in descriptor) descriptor.writable = true;
        Object.defineProperty(target, descriptor.key, descriptor);
    }
}
function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor;
}
exports.default = _createClass;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"1ybWu":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _setPrototypeOfJs = require("./setPrototypeOf.js");
var _setPrototypeOfJsDefault = parcelHelpers.interopDefault(_setPrototypeOfJs);
function _inherits(subClass, superClass) {
    if (typeof superClass !== "function" && superClass !== null) throw new TypeError("Super expression must either be null or a function");
    subClass.prototype = Object.create(superClass && superClass.prototype, {
        constructor: {
            value: subClass,
            writable: true,
            configurable: true
        }
    });
    if (superClass) _setPrototypeOfJsDefault.default(subClass, superClass);
}
exports.default = _inherits;

},{"./setPrototypeOf.js":"g3X5W","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"g3X5W":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _setPrototypeOf(o, p) {
    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf1(o1, p1) {
        o1.__proto__ = p1;
        return o1;
    };
    return _setPrototypeOf(o, p);
}
exports.default = _setPrototypeOf;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"bOy9j":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _defineProperty(obj, key, value) {
    if (key in obj) Object.defineProperty(obj, key, {
        value: value,
        enumerable: true,
        configurable: true,
        writable: true
    });
    else obj[key] = value;
    return obj;
}
exports.default = _defineProperty;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"ilX9M":[function(require,module,exports) {
module.exports = ReactDOM;

},{}],"1YmTR":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _arrayWithoutHolesJs = require("./arrayWithoutHoles.js");
var _arrayWithoutHolesJsDefault = parcelHelpers.interopDefault(_arrayWithoutHolesJs);
var _iterableToArrayJs = require("./iterableToArray.js");
var _iterableToArrayJsDefault = parcelHelpers.interopDefault(_iterableToArrayJs);
var _unsupportedIterableToArrayJs = require("./unsupportedIterableToArray.js");
var _unsupportedIterableToArrayJsDefault = parcelHelpers.interopDefault(_unsupportedIterableToArrayJs);
var _nonIterableSpreadJs = require("./nonIterableSpread.js");
var _nonIterableSpreadJsDefault = parcelHelpers.interopDefault(_nonIterableSpreadJs);
function _toConsumableArray(arr) {
    return _arrayWithoutHolesJsDefault.default(arr) || _iterableToArrayJsDefault.default(arr) || _unsupportedIterableToArrayJsDefault.default(arr) || _nonIterableSpreadJsDefault.default();
}
exports.default = _toConsumableArray;

},{"./arrayWithoutHoles.js":"fnyeV","./iterableToArray.js":"eTbyx","./unsupportedIterableToArray.js":"1giqg","./nonIterableSpread.js":"i1dyK","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"fnyeV":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _arrayLikeToArrayJs = require("./arrayLikeToArray.js");
var _arrayLikeToArrayJsDefault = parcelHelpers.interopDefault(_arrayLikeToArrayJs);
function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return _arrayLikeToArrayJsDefault.default(arr);
}
exports.default = _arrayWithoutHoles;

},{"./arrayLikeToArray.js":"54cWf","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"54cWf":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for(var i = 0, arr2 = new Array(len); i < len; i++)arr2[i] = arr[i];
    return arr2;
}
exports.default = _arrayLikeToArray;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"eTbyx":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _iterableToArray(iter) {
    if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
}
exports.default = _iterableToArray;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"1giqg":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var _arrayLikeToArrayJs = require("./arrayLikeToArray.js");
var _arrayLikeToArrayJsDefault = parcelHelpers.interopDefault(_arrayLikeToArrayJs);
function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === "string") return _arrayLikeToArrayJsDefault.default(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === "Object" && o.constructor) n = o.constructor.name;
    if (n === "Map" || n === "Set") return Array.from(o);
    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArrayJsDefault.default(o, minLen);
}
exports.default = _unsupportedIterableToArray;

},{"./arrayLikeToArray.js":"54cWf","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"i1dyK":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
exports.default = _nonIterableSpread;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"ikgKw":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
var safeIsNaN = Number.isNaN || function ponyfill(value) {
    return typeof value === 'number' && value !== value;
};
function isEqual(first, second) {
    if (first === second) return true;
    if (safeIsNaN(first) && safeIsNaN(second)) return true;
    return false;
}
function areInputsEqual(newInputs, lastInputs) {
    if (newInputs.length !== lastInputs.length) return false;
    for(var i = 0; i < newInputs.length; i++){
        if (!isEqual(newInputs[i], lastInputs[i])) return false;
    }
    return true;
}
function memoizeOne(resultFn, isEqual1) {
    if (isEqual1 === void 0) isEqual1 = areInputsEqual;
    var lastThis;
    var lastArgs = [];
    var lastResult;
    var calledOnce = false;
    function memoized() {
        var newArgs = [];
        for(var _i = 0; _i < arguments.length; _i++)newArgs[_i] = arguments[_i];
        if (calledOnce && lastThis === this && isEqual1(newArgs, lastArgs)) return lastResult;
        lastResult = resultFn.apply(this, newArgs);
        calledOnce = true;
        lastThis = this;
        lastArgs = newArgs;
        return lastResult;
    }
    return memoized;
}
exports.default = memoizeOne;

},{"@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"2QbkT":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "m", ()=>manageState
);
var _extends = require("@babel/runtime/helpers/esm/extends");
var _extendsDefault = parcelHelpers.interopDefault(_extends);
var _objectWithoutProperties = require("@babel/runtime/helpers/esm/objectWithoutProperties");
var _objectWithoutPropertiesDefault = parcelHelpers.interopDefault(_objectWithoutProperties);
var _classCallCheck = require("@babel/runtime/helpers/esm/classCallCheck");
var _classCallCheckDefault = parcelHelpers.interopDefault(_classCallCheck);
var _createClass = require("@babel/runtime/helpers/esm/createClass");
var _createClassDefault = parcelHelpers.interopDefault(_createClass);
var _inherits = require("@babel/runtime/helpers/esm/inherits");
var _inheritsDefault = parcelHelpers.interopDefault(_inherits);
var _index4Bd03571EsmJs = require("./index-4bd03571.esm.js");
var _react = require("react");
var _reactDefault = parcelHelpers.interopDefault(_react);
var defaultProps = {
    defaultInputValue: '',
    defaultMenuIsOpen: false,
    defaultValue: null
};
var manageState = function manageState1(SelectComponent) {
    var _class, _temp;
    return _temp = _class = /*#__PURE__*/ (function(_Component) {
        _inheritsDefault.default(StateManager, _Component);
        var _super = _index4Bd03571EsmJs._(StateManager);
        function StateManager() {
            var _this;
            _classCallCheckDefault.default(this, StateManager);
            for(var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++)args[_key] = arguments[_key];
            _this = _super.call.apply(_super, [
                this
            ].concat(args));
            _this.select = void 0;
            _this.state = {
                inputValue: _this.props.inputValue !== undefined ? _this.props.inputValue : _this.props.defaultInputValue,
                menuIsOpen: _this.props.menuIsOpen !== undefined ? _this.props.menuIsOpen : _this.props.defaultMenuIsOpen,
                value: _this.props.value !== undefined ? _this.props.value : _this.props.defaultValue
            };
            _this.onChange = function(value, actionMeta) {
                _this.callProp('onChange', value, actionMeta);
                _this.setState({
                    value: value
                });
            };
            _this.onInputChange = function(value, actionMeta) {
                // TODO: for backwards compatibility, we allow the prop to return a new
                // value, but now inputValue is a controllable prop we probably shouldn't
                var newValue = _this.callProp('onInputChange', value, actionMeta);
                _this.setState({
                    inputValue: newValue !== undefined ? newValue : value
                });
            };
            _this.onMenuOpen = function() {
                _this.callProp('onMenuOpen');
                _this.setState({
                    menuIsOpen: true
                });
            };
            _this.onMenuClose = function() {
                _this.callProp('onMenuClose');
                _this.setState({
                    menuIsOpen: false
                });
            };
            return _this;
        }
        _createClassDefault.default(StateManager, [
            {
                key: "focus",
                value: function focus() {
                    this.select.focus();
                }
            },
            {
                key: "blur",
                value: function blur() {
                    this.select.blur();
                } // FIXME: untyped flow code, return any
            },
            {
                key: "getProp",
                value: function getProp(key) {
                    return this.props[key] !== undefined ? this.props[key] : this.state[key];
                } // FIXME: untyped flow code, return any
            },
            {
                key: "callProp",
                value: function callProp(name) {
                    if (typeof this.props[name] === 'function') {
                        var _this$props;
                        for(var _len2 = arguments.length, args = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++)args[_key2 - 1] = arguments[_key2];
                        return (_this$props = this.props)[name].apply(_this$props, args);
                    }
                }
            },
            {
                key: "render",
                value: function render() {
                    var _this2 = this;
                    var _this$props2 = this.props;
                    _this$props2.defaultInputValue;
                    _this$props2.defaultMenuIsOpen;
                    _this$props2.defaultValue;
                    var props = _objectWithoutPropertiesDefault.default(_this$props2, [
                        "defaultInputValue",
                        "defaultMenuIsOpen",
                        "defaultValue"
                    ]);
                    return(/*#__PURE__*/ _reactDefault.default.createElement(SelectComponent, _extendsDefault.default({
                    }, props, {
                        ref: function ref(_ref) {
                            _this2.select = _ref;
                        },
                        inputValue: this.getProp('inputValue'),
                        menuIsOpen: this.getProp('menuIsOpen'),
                        onChange: this.onChange,
                        onInputChange: this.onInputChange,
                        onMenuClose: this.onMenuClose,
                        onMenuOpen: this.onMenuOpen,
                        value: this.getProp('value')
                    })));
                }
            }
        ]);
        return StateManager;
    })(_react.Component), _class.defaultProps = defaultProps, _temp;
};

},{"@babel/runtime/helpers/esm/extends":"6kJrr","@babel/runtime/helpers/esm/objectWithoutProperties":"hRPaM","@babel/runtime/helpers/esm/classCallCheck":"kcrhl","@babel/runtime/helpers/esm/createClass":"bETt6","@babel/runtime/helpers/esm/inherits":"1ybWu","./index-4bd03571.esm.js":"hhkYp","react":"bE4sN","@parcel/transformer-js/src/esmodule-helpers.js":"bdniN"}],"9RCJT":[function(require,module,exports) {
var arrayWithoutHoles = require("./arrayWithoutHoles.js");
var iterableToArray = require("./iterableToArray.js");
var unsupportedIterableToArray = require("./unsupportedIterableToArray.js");
var nonIterableSpread = require("./nonIterableSpread.js");
function _toConsumableArray(arr) {
    return arrayWithoutHoles(arr) || iterableToArray(arr) || unsupportedIterableToArray(arr) || nonIterableSpread();
}
module.exports = _toConsumableArray;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{"./arrayWithoutHoles.js":"lfuPS","./iterableToArray.js":"k7m7T","./unsupportedIterableToArray.js":"dADr7","./nonIterableSpread.js":"1qekZ"}],"lfuPS":[function(require,module,exports) {
var arrayLikeToArray = require("./arrayLikeToArray.js");
function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return arrayLikeToArray(arr);
}
module.exports = _arrayWithoutHoles;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{"./arrayLikeToArray.js":"io7n5"}],"io7n5":[function(require,module,exports) {
function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for(var i = 0, arr2 = new Array(len); i < len; i++)arr2[i] = arr[i];
    return arr2;
}
module.exports = _arrayLikeToArray;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{}],"k7m7T":[function(require,module,exports) {
function _iterableToArray(iter) {
    if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
}
module.exports = _iterableToArray;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{}],"dADr7":[function(require,module,exports) {
var arrayLikeToArray = require("./arrayLikeToArray.js");
function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === "string") return arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === "Object" && o.constructor) n = o.constructor.name;
    if (n === "Map" || n === "Set") return Array.from(o);
    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return arrayLikeToArray(o, minLen);
}
module.exports = _unsupportedIterableToArray;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{"./arrayLikeToArray.js":"io7n5"}],"1qekZ":[function(require,module,exports) {
function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
module.exports = _nonIterableSpread;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{}],"edAJZ":[function(require,module,exports) {
var objectWithoutPropertiesLoose = require("./objectWithoutPropertiesLoose.js");
function _objectWithoutProperties(source, excluded) {
    if (source == null) return {
    };
    var target = objectWithoutPropertiesLoose(source, excluded);
    var key, i;
    if (Object.getOwnPropertySymbols) {
        var sourceSymbolKeys = Object.getOwnPropertySymbols(source);
        for(i = 0; i < sourceSymbolKeys.length; i++){
            key = sourceSymbolKeys[i];
            if (excluded.indexOf(key) >= 0) continue;
            if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
            target[key] = source[key];
        }
    }
    return target;
}
module.exports = _objectWithoutProperties;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{"./objectWithoutPropertiesLoose.js":"04Ci9"}],"04Ci9":[function(require,module,exports) {
function _objectWithoutPropertiesLoose(source, excluded) {
    if (source == null) return {
    };
    var target = {
    };
    var sourceKeys = Object.keys(source);
    var key, i;
    for(i = 0; i < sourceKeys.length; i++){
        key = sourceKeys[i];
        if (excluded.indexOf(key) >= 0) continue;
        target[key] = source[key];
    }
    return target;
}
module.exports = _objectWithoutPropertiesLoose;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{}],"7t0wp":[function(require,module,exports) {
function _taggedTemplateLiteral(strings, raw) {
    if (!raw) raw = strings.slice(0);
    return Object.freeze(Object.defineProperties(strings, {
        raw: {
            value: Object.freeze(raw)
        }
    }));
}
module.exports = _taggedTemplateLiteral;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{}],"1h3OK":[function(require,module,exports) {
function _typeof(obj) {
    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
        module.exports = _typeof = function _typeof1(obj1) {
            return typeof obj1;
        };
        module.exports["default"] = module.exports, module.exports.__esModule = true;
    } else {
        module.exports = _typeof = function _typeof1(obj1) {
            return obj1 && typeof Symbol === "function" && obj1.constructor === Symbol && obj1 !== Symbol.prototype ? "symbol" : typeof obj1;
        };
        module.exports["default"] = module.exports, module.exports.__esModule = true;
    }
    return _typeof(obj);
}
module.exports = _typeof;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{}],"byUGB":[function(require,module,exports) {
function _defineProperty(obj, key, value) {
    if (key in obj) Object.defineProperty(obj, key, {
        value: value,
        enumerable: true,
        configurable: true,
        writable: true
    });
    else obj[key] = value;
    return obj;
}
module.exports = _defineProperty;
module.exports["default"] = module.exports, module.exports.__esModule = true;

},{}]},["jAg0Z","ecPDr","7Y5mU"], "7Y5mU", "parcelRequire5ac3")

//# sourceMappingURL=control.js.map
