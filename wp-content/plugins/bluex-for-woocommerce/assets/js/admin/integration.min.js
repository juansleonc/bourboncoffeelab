(function polyfill() {
  const relList = document.createElement("link").relList;
  if (relList && relList.supports && relList.supports("modulepreload")) {
    return;
  }
  for (const link2 of document.querySelectorAll('link[rel="modulepreload"]')) {
    processPreload(link2);
  }
  new MutationObserver((mutations) => {
    for (const mutation of mutations) {
      if (mutation.type !== "childList") {
        continue;
      }
      for (const node of mutation.addedNodes) {
        if (node.tagName === "LINK" && node.rel === "modulepreload")
          processPreload(node);
      }
    }
  }).observe(document, { childList: true, subtree: true });
  function getFetchOpts(link2) {
    const fetchOpts = {};
    if (link2.integrity) fetchOpts.integrity = link2.integrity;
    if (link2.referrerPolicy) fetchOpts.referrerPolicy = link2.referrerPolicy;
    if (link2.crossOrigin === "use-credentials")
      fetchOpts.credentials = "include";
    else if (link2.crossOrigin === "anonymous") fetchOpts.credentials = "omit";
    else fetchOpts.credentials = "same-origin";
    return fetchOpts;
  }
  function processPreload(link2) {
    if (link2.ep)
      return;
    link2.ep = true;
    const fetchOpts = getFetchOpts(link2);
    fetch(link2.href, fetchOpts);
  }
})();
function getDefaultExportFromCjs(x) {
  return x && x.__esModule && Object.prototype.hasOwnProperty.call(x, "default") ? x["default"] : x;
}
var jsxRuntime = { exports: {} };
var reactJsxRuntime_production_min = {};
var react = { exports: {} };
var react_production_min = {};
/**
 * @license React
 * react.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
var hasRequiredReact_production_min;
function requireReact_production_min() {
  if (hasRequiredReact_production_min) return react_production_min;
  hasRequiredReact_production_min = 1;
  var l = Symbol.for("react.element"), n = Symbol.for("react.portal"), p = Symbol.for("react.fragment"), q = Symbol.for("react.strict_mode"), r = Symbol.for("react.profiler"), t = Symbol.for("react.provider"), u = Symbol.for("react.context"), v = Symbol.for("react.forward_ref"), w = Symbol.for("react.suspense"), x = Symbol.for("react.memo"), y = Symbol.for("react.lazy"), z = Symbol.iterator;
  function A(a) {
    if (null === a || "object" !== typeof a) return null;
    a = z && a[z] || a["@@iterator"];
    return "function" === typeof a ? a : null;
  }
  var B = { isMounted: function() {
    return false;
  }, enqueueForceUpdate: function() {
  }, enqueueReplaceState: function() {
  }, enqueueSetState: function() {
  } }, C = Object.assign, D = {};
  function E(a, b, e) {
    this.props = a;
    this.context = b;
    this.refs = D;
    this.updater = e || B;
  }
  E.prototype.isReactComponent = {};
  E.prototype.setState = function(a, b) {
    if ("object" !== typeof a && "function" !== typeof a && null != a) throw Error("setState(...): takes an object of state variables to update or a function which returns an object of state variables.");
    this.updater.enqueueSetState(this, a, b, "setState");
  };
  E.prototype.forceUpdate = function(a) {
    this.updater.enqueueForceUpdate(this, a, "forceUpdate");
  };
  function F() {
  }
  F.prototype = E.prototype;
  function G(a, b, e) {
    this.props = a;
    this.context = b;
    this.refs = D;
    this.updater = e || B;
  }
  var H = G.prototype = new F();
  H.constructor = G;
  C(H, E.prototype);
  H.isPureReactComponent = true;
  var I = Array.isArray, J = Object.prototype.hasOwnProperty, K = { current: null }, L = { key: true, ref: true, __self: true, __source: true };
  function M(a, b, e) {
    var d, c = {}, k = null, h = null;
    if (null != b) for (d in void 0 !== b.ref && (h = b.ref), void 0 !== b.key && (k = "" + b.key), b) J.call(b, d) && !L.hasOwnProperty(d) && (c[d] = b[d]);
    var g = arguments.length - 2;
    if (1 === g) c.children = e;
    else if (1 < g) {
      for (var f = Array(g), m = 0; m < g; m++) f[m] = arguments[m + 2];
      c.children = f;
    }
    if (a && a.defaultProps) for (d in g = a.defaultProps, g) void 0 === c[d] && (c[d] = g[d]);
    return { $$typeof: l, type: a, key: k, ref: h, props: c, _owner: K.current };
  }
  function N(a, b) {
    return { $$typeof: l, type: a.type, key: b, ref: a.ref, props: a.props, _owner: a._owner };
  }
  function O(a) {
    return "object" === typeof a && null !== a && a.$$typeof === l;
  }
  function escape(a) {
    var b = { "=": "=0", ":": "=2" };
    return "$" + a.replace(/[=:]/g, function(a2) {
      return b[a2];
    });
  }
  var P = /\/+/g;
  function Q(a, b) {
    return "object" === typeof a && null !== a && null != a.key ? escape("" + a.key) : b.toString(36);
  }
  function R(a, b, e, d, c) {
    var k = typeof a;
    if ("undefined" === k || "boolean" === k) a = null;
    var h = false;
    if (null === a) h = true;
    else switch (k) {
      case "string":
      case "number":
        h = true;
        break;
      case "object":
        switch (a.$$typeof) {
          case l:
          case n:
            h = true;
        }
    }
    if (h) return h = a, c = c(h), a = "" === d ? "." + Q(h, 0) : d, I(c) ? (e = "", null != a && (e = a.replace(P, "$&/") + "/"), R(c, b, e, "", function(a2) {
      return a2;
    })) : null != c && (O(c) && (c = N(c, e + (!c.key || h && h.key === c.key ? "" : ("" + c.key).replace(P, "$&/") + "/") + a)), b.push(c)), 1;
    h = 0;
    d = "" === d ? "." : d + ":";
    if (I(a)) for (var g = 0; g < a.length; g++) {
      k = a[g];
      var f = d + Q(k, g);
      h += R(k, b, e, f, c);
    }
    else if (f = A(a), "function" === typeof f) for (a = f.call(a), g = 0; !(k = a.next()).done; ) k = k.value, f = d + Q(k, g++), h += R(k, b, e, f, c);
    else if ("object" === k) throw b = String(a), Error("Objects are not valid as a React child (found: " + ("[object Object]" === b ? "object with keys {" + Object.keys(a).join(", ") + "}" : b) + "). If you meant to render a collection of children, use an array instead.");
    return h;
  }
  function S(a, b, e) {
    if (null == a) return a;
    var d = [], c = 0;
    R(a, d, "", "", function(a2) {
      return b.call(e, a2, c++);
    });
    return d;
  }
  function T(a) {
    if (-1 === a._status) {
      var b = a._result;
      b = b();
      b.then(function(b2) {
        if (0 === a._status || -1 === a._status) a._status = 1, a._result = b2;
      }, function(b2) {
        if (0 === a._status || -1 === a._status) a._status = 2, a._result = b2;
      });
      -1 === a._status && (a._status = 0, a._result = b);
    }
    if (1 === a._status) return a._result.default;
    throw a._result;
  }
  var U = { current: null }, V = { transition: null }, W = { ReactCurrentDispatcher: U, ReactCurrentBatchConfig: V, ReactCurrentOwner: K };
  function X() {
    throw Error("act(...) is not supported in production builds of React.");
  }
  react_production_min.Children = { map: S, forEach: function(a, b, e) {
    S(a, function() {
      b.apply(this, arguments);
    }, e);
  }, count: function(a) {
    var b = 0;
    S(a, function() {
      b++;
    });
    return b;
  }, toArray: function(a) {
    return S(a, function(a2) {
      return a2;
    }) || [];
  }, only: function(a) {
    if (!O(a)) throw Error("React.Children.only expected to receive a single React element child.");
    return a;
  } };
  react_production_min.Component = E;
  react_production_min.Fragment = p;
  react_production_min.Profiler = r;
  react_production_min.PureComponent = G;
  react_production_min.StrictMode = q;
  react_production_min.Suspense = w;
  react_production_min.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED = W;
  react_production_min.act = X;
  react_production_min.cloneElement = function(a, b, e) {
    if (null === a || void 0 === a) throw Error("React.cloneElement(...): The argument must be a React element, but you passed " + a + ".");
    var d = C({}, a.props), c = a.key, k = a.ref, h = a._owner;
    if (null != b) {
      void 0 !== b.ref && (k = b.ref, h = K.current);
      void 0 !== b.key && (c = "" + b.key);
      if (a.type && a.type.defaultProps) var g = a.type.defaultProps;
      for (f in b) J.call(b, f) && !L.hasOwnProperty(f) && (d[f] = void 0 === b[f] && void 0 !== g ? g[f] : b[f]);
    }
    var f = arguments.length - 2;
    if (1 === f) d.children = e;
    else if (1 < f) {
      g = Array(f);
      for (var m = 0; m < f; m++) g[m] = arguments[m + 2];
      d.children = g;
    }
    return { $$typeof: l, type: a.type, key: c, ref: k, props: d, _owner: h };
  };
  react_production_min.createContext = function(a) {
    a = { $$typeof: u, _currentValue: a, _currentValue2: a, _threadCount: 0, Provider: null, Consumer: null, _defaultValue: null, _globalName: null };
    a.Provider = { $$typeof: t, _context: a };
    return a.Consumer = a;
  };
  react_production_min.createElement = M;
  react_production_min.createFactory = function(a) {
    var b = M.bind(null, a);
    b.type = a;
    return b;
  };
  react_production_min.createRef = function() {
    return { current: null };
  };
  react_production_min.forwardRef = function(a) {
    return { $$typeof: v, render: a };
  };
  react_production_min.isValidElement = O;
  react_production_min.lazy = function(a) {
    return { $$typeof: y, _payload: { _status: -1, _result: a }, _init: T };
  };
  react_production_min.memo = function(a, b) {
    return { $$typeof: x, type: a, compare: void 0 === b ? null : b };
  };
  react_production_min.startTransition = function(a) {
    var b = V.transition;
    V.transition = {};
    try {
      a();
    } finally {
      V.transition = b;
    }
  };
  react_production_min.unstable_act = X;
  react_production_min.useCallback = function(a, b) {
    return U.current.useCallback(a, b);
  };
  react_production_min.useContext = function(a) {
    return U.current.useContext(a);
  };
  react_production_min.useDebugValue = function() {
  };
  react_production_min.useDeferredValue = function(a) {
    return U.current.useDeferredValue(a);
  };
  react_production_min.useEffect = function(a, b) {
    return U.current.useEffect(a, b);
  };
  react_production_min.useId = function() {
    return U.current.useId();
  };
  react_production_min.useImperativeHandle = function(a, b, e) {
    return U.current.useImperativeHandle(a, b, e);
  };
  react_production_min.useInsertionEffect = function(a, b) {
    return U.current.useInsertionEffect(a, b);
  };
  react_production_min.useLayoutEffect = function(a, b) {
    return U.current.useLayoutEffect(a, b);
  };
  react_production_min.useMemo = function(a, b) {
    return U.current.useMemo(a, b);
  };
  react_production_min.useReducer = function(a, b, e) {
    return U.current.useReducer(a, b, e);
  };
  react_production_min.useRef = function(a) {
    return U.current.useRef(a);
  };
  react_production_min.useState = function(a) {
    return U.current.useState(a);
  };
  react_production_min.useSyncExternalStore = function(a, b, e) {
    return U.current.useSyncExternalStore(a, b, e);
  };
  react_production_min.useTransition = function() {
    return U.current.useTransition();
  };
  react_production_min.version = "18.3.1";
  return react_production_min;
}
var hasRequiredReact;
function requireReact() {
  if (hasRequiredReact) return react.exports;
  hasRequiredReact = 1;
  {
    react.exports = requireReact_production_min();
  }
  return react.exports;
}
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
var hasRequiredReactJsxRuntime_production_min;
function requireReactJsxRuntime_production_min() {
  if (hasRequiredReactJsxRuntime_production_min) return reactJsxRuntime_production_min;
  hasRequiredReactJsxRuntime_production_min = 1;
  var f = requireReact(), k = Symbol.for("react.element"), l = Symbol.for("react.fragment"), m = Object.prototype.hasOwnProperty, n = f.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner, p = { key: true, ref: true, __self: true, __source: true };
  function q(c, a, g) {
    var b, d = {}, e = null, h = null;
    void 0 !== g && (e = "" + g);
    void 0 !== a.key && (e = "" + a.key);
    void 0 !== a.ref && (h = a.ref);
    for (b in a) m.call(a, b) && !p.hasOwnProperty(b) && (d[b] = a[b]);
    if (c && c.defaultProps) for (b in a = c.defaultProps, a) void 0 === d[b] && (d[b] = a[b]);
    return { $$typeof: k, type: c, key: e, ref: h, props: d, _owner: n.current };
  }
  reactJsxRuntime_production_min.Fragment = l;
  reactJsxRuntime_production_min.jsx = q;
  reactJsxRuntime_production_min.jsxs = q;
  return reactJsxRuntime_production_min;
}
var hasRequiredJsxRuntime;
function requireJsxRuntime() {
  if (hasRequiredJsxRuntime) return jsxRuntime.exports;
  hasRequiredJsxRuntime = 1;
  {
    jsxRuntime.exports = requireReactJsxRuntime_production_min();
  }
  return jsxRuntime.exports;
}
var jsxRuntimeExports = requireJsxRuntime();
var reactExports = requireReact();
const React = /* @__PURE__ */ getDefaultExportFromCjs(reactExports);
var client = {};
var reactDom = { exports: {} };
var reactDom_production_min = {};
var scheduler = { exports: {} };
var scheduler_production_min = {};
/**
 * @license React
 * scheduler.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
var hasRequiredScheduler_production_min;
function requireScheduler_production_min() {
  if (hasRequiredScheduler_production_min) return scheduler_production_min;
  hasRequiredScheduler_production_min = 1;
  (function(exports) {
    function f(a, b) {
      var c = a.length;
      a.push(b);
      a: for (; 0 < c; ) {
        var d = c - 1 >>> 1, e = a[d];
        if (0 < g(e, b)) a[d] = b, a[c] = e, c = d;
        else break a;
      }
    }
    function h(a) {
      return 0 === a.length ? null : a[0];
    }
    function k(a) {
      if (0 === a.length) return null;
      var b = a[0], c = a.pop();
      if (c !== b) {
        a[0] = c;
        a: for (var d = 0, e = a.length, w = e >>> 1; d < w; ) {
          var m = 2 * (d + 1) - 1, C = a[m], n = m + 1, x = a[n];
          if (0 > g(C, c)) n < e && 0 > g(x, C) ? (a[d] = x, a[n] = c, d = n) : (a[d] = C, a[m] = c, d = m);
          else if (n < e && 0 > g(x, c)) a[d] = x, a[n] = c, d = n;
          else break a;
        }
      }
      return b;
    }
    function g(a, b) {
      var c = a.sortIndex - b.sortIndex;
      return 0 !== c ? c : a.id - b.id;
    }
    if ("object" === typeof performance && "function" === typeof performance.now) {
      var l = performance;
      exports.unstable_now = function() {
        return l.now();
      };
    } else {
      var p = Date, q = p.now();
      exports.unstable_now = function() {
        return p.now() - q;
      };
    }
    var r = [], t = [], u = 1, v = null, y = 3, z = false, A = false, B = false, D = "function" === typeof setTimeout ? setTimeout : null, E = "function" === typeof clearTimeout ? clearTimeout : null, F = "undefined" !== typeof setImmediate ? setImmediate : null;
    "undefined" !== typeof navigator && void 0 !== navigator.scheduling && void 0 !== navigator.scheduling.isInputPending && navigator.scheduling.isInputPending.bind(navigator.scheduling);
    function G(a) {
      for (var b = h(t); null !== b; ) {
        if (null === b.callback) k(t);
        else if (b.startTime <= a) k(t), b.sortIndex = b.expirationTime, f(r, b);
        else break;
        b = h(t);
      }
    }
    function H(a) {
      B = false;
      G(a);
      if (!A) if (null !== h(r)) A = true, I(J);
      else {
        var b = h(t);
        null !== b && K(H, b.startTime - a);
      }
    }
    function J(a, b) {
      A = false;
      B && (B = false, E(L), L = -1);
      z = true;
      var c = y;
      try {
        G(b);
        for (v = h(r); null !== v && (!(v.expirationTime > b) || a && !M()); ) {
          var d = v.callback;
          if ("function" === typeof d) {
            v.callback = null;
            y = v.priorityLevel;
            var e = d(v.expirationTime <= b);
            b = exports.unstable_now();
            "function" === typeof e ? v.callback = e : v === h(r) && k(r);
            G(b);
          } else k(r);
          v = h(r);
        }
        if (null !== v) var w = true;
        else {
          var m = h(t);
          null !== m && K(H, m.startTime - b);
          w = false;
        }
        return w;
      } finally {
        v = null, y = c, z = false;
      }
    }
    var N = false, O = null, L = -1, P = 5, Q = -1;
    function M() {
      return exports.unstable_now() - Q < P ? false : true;
    }
    function R() {
      if (null !== O) {
        var a = exports.unstable_now();
        Q = a;
        var b = true;
        try {
          b = O(true, a);
        } finally {
          b ? S() : (N = false, O = null);
        }
      } else N = false;
    }
    var S;
    if ("function" === typeof F) S = function() {
      F(R);
    };
    else if ("undefined" !== typeof MessageChannel) {
      var T = new MessageChannel(), U = T.port2;
      T.port1.onmessage = R;
      S = function() {
        U.postMessage(null);
      };
    } else S = function() {
      D(R, 0);
    };
    function I(a) {
      O = a;
      N || (N = true, S());
    }
    function K(a, b) {
      L = D(function() {
        a(exports.unstable_now());
      }, b);
    }
    exports.unstable_IdlePriority = 5;
    exports.unstable_ImmediatePriority = 1;
    exports.unstable_LowPriority = 4;
    exports.unstable_NormalPriority = 3;
    exports.unstable_Profiling = null;
    exports.unstable_UserBlockingPriority = 2;
    exports.unstable_cancelCallback = function(a) {
      a.callback = null;
    };
    exports.unstable_continueExecution = function() {
      A || z || (A = true, I(J));
    };
    exports.unstable_forceFrameRate = function(a) {
      0 > a || 125 < a ? console.error("forceFrameRate takes a positive int between 0 and 125, forcing frame rates higher than 125 fps is not supported") : P = 0 < a ? Math.floor(1e3 / a) : 5;
    };
    exports.unstable_getCurrentPriorityLevel = function() {
      return y;
    };
    exports.unstable_getFirstCallbackNode = function() {
      return h(r);
    };
    exports.unstable_next = function(a) {
      switch (y) {
        case 1:
        case 2:
        case 3:
          var b = 3;
          break;
        default:
          b = y;
      }
      var c = y;
      y = b;
      try {
        return a();
      } finally {
        y = c;
      }
    };
    exports.unstable_pauseExecution = function() {
    };
    exports.unstable_requestPaint = function() {
    };
    exports.unstable_runWithPriority = function(a, b) {
      switch (a) {
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
          break;
        default:
          a = 3;
      }
      var c = y;
      y = a;
      try {
        return b();
      } finally {
        y = c;
      }
    };
    exports.unstable_scheduleCallback = function(a, b, c) {
      var d = exports.unstable_now();
      "object" === typeof c && null !== c ? (c = c.delay, c = "number" === typeof c && 0 < c ? d + c : d) : c = d;
      switch (a) {
        case 1:
          var e = -1;
          break;
        case 2:
          e = 250;
          break;
        case 5:
          e = 1073741823;
          break;
        case 4:
          e = 1e4;
          break;
        default:
          e = 5e3;
      }
      e = c + e;
      a = { id: u++, callback: b, priorityLevel: a, startTime: c, expirationTime: e, sortIndex: -1 };
      c > d ? (a.sortIndex = c, f(t, a), null === h(r) && a === h(t) && (B ? (E(L), L = -1) : B = true, K(H, c - d))) : (a.sortIndex = e, f(r, a), A || z || (A = true, I(J)));
      return a;
    };
    exports.unstable_shouldYield = M;
    exports.unstable_wrapCallback = function(a) {
      var b = y;
      return function() {
        var c = y;
        y = b;
        try {
          return a.apply(this, arguments);
        } finally {
          y = c;
        }
      };
    };
  })(scheduler_production_min);
  return scheduler_production_min;
}
var hasRequiredScheduler;
function requireScheduler() {
  if (hasRequiredScheduler) return scheduler.exports;
  hasRequiredScheduler = 1;
  {
    scheduler.exports = requireScheduler_production_min();
  }
  return scheduler.exports;
}
/**
 * @license React
 * react-dom.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
var hasRequiredReactDom_production_min;
function requireReactDom_production_min() {
  if (hasRequiredReactDom_production_min) return reactDom_production_min;
  hasRequiredReactDom_production_min = 1;
  var aa = requireReact(), ca = requireScheduler();
  function p(a) {
    for (var b = "https://reactjs.org/docs/error-decoder.html?invariant=" + a, c = 1; c < arguments.length; c++) b += "&args[]=" + encodeURIComponent(arguments[c]);
    return "Minified React error #" + a + "; visit " + b + " for the full message or use the non-minified dev environment for full errors and additional helpful warnings.";
  }
  var da = /* @__PURE__ */ new Set(), ea = {};
  function fa(a, b) {
    ha(a, b);
    ha(a + "Capture", b);
  }
  function ha(a, b) {
    ea[a] = b;
    for (a = 0; a < b.length; a++) da.add(b[a]);
  }
  var ia = !("undefined" === typeof window || "undefined" === typeof window.document || "undefined" === typeof window.document.createElement), ja = Object.prototype.hasOwnProperty, ka = /^[:A-Z_a-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C-\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD][:A-Z_a-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C-\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD\-.0-9\u00B7\u0300-\u036F\u203F-\u2040]*$/, la = {}, ma = {};
  function oa(a) {
    if (ja.call(ma, a)) return true;
    if (ja.call(la, a)) return false;
    if (ka.test(a)) return ma[a] = true;
    la[a] = true;
    return false;
  }
  function pa(a, b, c, d) {
    if (null !== c && 0 === c.type) return false;
    switch (typeof b) {
      case "function":
      case "symbol":
        return true;
      case "boolean":
        if (d) return false;
        if (null !== c) return !c.acceptsBooleans;
        a = a.toLowerCase().slice(0, 5);
        return "data-" !== a && "aria-" !== a;
      default:
        return false;
    }
  }
  function qa(a, b, c, d) {
    if (null === b || "undefined" === typeof b || pa(a, b, c, d)) return true;
    if (d) return false;
    if (null !== c) switch (c.type) {
      case 3:
        return !b;
      case 4:
        return false === b;
      case 5:
        return isNaN(b);
      case 6:
        return isNaN(b) || 1 > b;
    }
    return false;
  }
  function v(a, b, c, d, e, f, g) {
    this.acceptsBooleans = 2 === b || 3 === b || 4 === b;
    this.attributeName = d;
    this.attributeNamespace = e;
    this.mustUseProperty = c;
    this.propertyName = a;
    this.type = b;
    this.sanitizeURL = f;
    this.removeEmptyString = g;
  }
  var z = {};
  "children dangerouslySetInnerHTML defaultValue defaultChecked innerHTML suppressContentEditableWarning suppressHydrationWarning style".split(" ").forEach(function(a) {
    z[a] = new v(a, 0, false, a, null, false, false);
  });
  [["acceptCharset", "accept-charset"], ["className", "class"], ["htmlFor", "for"], ["httpEquiv", "http-equiv"]].forEach(function(a) {
    var b = a[0];
    z[b] = new v(b, 1, false, a[1], null, false, false);
  });
  ["contentEditable", "draggable", "spellCheck", "value"].forEach(function(a) {
    z[a] = new v(a, 2, false, a.toLowerCase(), null, false, false);
  });
  ["autoReverse", "externalResourcesRequired", "focusable", "preserveAlpha"].forEach(function(a) {
    z[a] = new v(a, 2, false, a, null, false, false);
  });
  "allowFullScreen async autoFocus autoPlay controls default defer disabled disablePictureInPicture disableRemotePlayback formNoValidate hidden loop noModule noValidate open playsInline readOnly required reversed scoped seamless itemScope".split(" ").forEach(function(a) {
    z[a] = new v(a, 3, false, a.toLowerCase(), null, false, false);
  });
  ["checked", "multiple", "muted", "selected"].forEach(function(a) {
    z[a] = new v(a, 3, true, a, null, false, false);
  });
  ["capture", "download"].forEach(function(a) {
    z[a] = new v(a, 4, false, a, null, false, false);
  });
  ["cols", "rows", "size", "span"].forEach(function(a) {
    z[a] = new v(a, 6, false, a, null, false, false);
  });
  ["rowSpan", "start"].forEach(function(a) {
    z[a] = new v(a, 5, false, a.toLowerCase(), null, false, false);
  });
  var ra = /[\-:]([a-z])/g;
  function sa(a) {
    return a[1].toUpperCase();
  }
  "accent-height alignment-baseline arabic-form baseline-shift cap-height clip-path clip-rule color-interpolation color-interpolation-filters color-profile color-rendering dominant-baseline enable-background fill-opacity fill-rule flood-color flood-opacity font-family font-size font-size-adjust font-stretch font-style font-variant font-weight glyph-name glyph-orientation-horizontal glyph-orientation-vertical horiz-adv-x horiz-origin-x image-rendering letter-spacing lighting-color marker-end marker-mid marker-start overline-position overline-thickness paint-order panose-1 pointer-events rendering-intent shape-rendering stop-color stop-opacity strikethrough-position strikethrough-thickness stroke-dasharray stroke-dashoffset stroke-linecap stroke-linejoin stroke-miterlimit stroke-opacity stroke-width text-anchor text-decoration text-rendering underline-position underline-thickness unicode-bidi unicode-range units-per-em v-alphabetic v-hanging v-ideographic v-mathematical vector-effect vert-adv-y vert-origin-x vert-origin-y word-spacing writing-mode xmlns:xlink x-height".split(" ").forEach(function(a) {
    var b = a.replace(
      ra,
      sa
    );
    z[b] = new v(b, 1, false, a, null, false, false);
  });
  "xlink:actuate xlink:arcrole xlink:role xlink:show xlink:title xlink:type".split(" ").forEach(function(a) {
    var b = a.replace(ra, sa);
    z[b] = new v(b, 1, false, a, "http://www.w3.org/1999/xlink", false, false);
  });
  ["xml:base", "xml:lang", "xml:space"].forEach(function(a) {
    var b = a.replace(ra, sa);
    z[b] = new v(b, 1, false, a, "http://www.w3.org/XML/1998/namespace", false, false);
  });
  ["tabIndex", "crossOrigin"].forEach(function(a) {
    z[a] = new v(a, 1, false, a.toLowerCase(), null, false, false);
  });
  z.xlinkHref = new v("xlinkHref", 1, false, "xlink:href", "http://www.w3.org/1999/xlink", true, false);
  ["src", "href", "action", "formAction"].forEach(function(a) {
    z[a] = new v(a, 1, false, a.toLowerCase(), null, true, true);
  });
  function ta(a, b, c, d) {
    var e = z.hasOwnProperty(b) ? z[b] : null;
    if (null !== e ? 0 !== e.type : d || !(2 < b.length) || "o" !== b[0] && "O" !== b[0] || "n" !== b[1] && "N" !== b[1]) qa(b, c, e, d) && (c = null), d || null === e ? oa(b) && (null === c ? a.removeAttribute(b) : a.setAttribute(b, "" + c)) : e.mustUseProperty ? a[e.propertyName] = null === c ? 3 === e.type ? false : "" : c : (b = e.attributeName, d = e.attributeNamespace, null === c ? a.removeAttribute(b) : (e = e.type, c = 3 === e || 4 === e && true === c ? "" : "" + c, d ? a.setAttributeNS(d, b, c) : a.setAttribute(b, c)));
  }
  var ua = aa.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED, va = Symbol.for("react.element"), wa = Symbol.for("react.portal"), ya = Symbol.for("react.fragment"), za = Symbol.for("react.strict_mode"), Aa = Symbol.for("react.profiler"), Ba = Symbol.for("react.provider"), Ca = Symbol.for("react.context"), Da = Symbol.for("react.forward_ref"), Ea = Symbol.for("react.suspense"), Fa = Symbol.for("react.suspense_list"), Ga = Symbol.for("react.memo"), Ha = Symbol.for("react.lazy");
  var Ia = Symbol.for("react.offscreen");
  var Ja = Symbol.iterator;
  function Ka(a) {
    if (null === a || "object" !== typeof a) return null;
    a = Ja && a[Ja] || a["@@iterator"];
    return "function" === typeof a ? a : null;
  }
  var A = Object.assign, La;
  function Ma(a) {
    if (void 0 === La) try {
      throw Error();
    } catch (c) {
      var b = c.stack.trim().match(/\n( *(at )?)/);
      La = b && b[1] || "";
    }
    return "\n" + La + a;
  }
  var Na = false;
  function Oa(a, b) {
    if (!a || Na) return "";
    Na = true;
    var c = Error.prepareStackTrace;
    Error.prepareStackTrace = void 0;
    try {
      if (b) if (b = function() {
        throw Error();
      }, Object.defineProperty(b.prototype, "props", { set: function() {
        throw Error();
      } }), "object" === typeof Reflect && Reflect.construct) {
        try {
          Reflect.construct(b, []);
        } catch (l) {
          var d = l;
        }
        Reflect.construct(a, [], b);
      } else {
        try {
          b.call();
        } catch (l) {
          d = l;
        }
        a.call(b.prototype);
      }
      else {
        try {
          throw Error();
        } catch (l) {
          d = l;
        }
        a();
      }
    } catch (l) {
      if (l && d && "string" === typeof l.stack) {
        for (var e = l.stack.split("\n"), f = d.stack.split("\n"), g = e.length - 1, h = f.length - 1; 1 <= g && 0 <= h && e[g] !== f[h]; ) h--;
        for (; 1 <= g && 0 <= h; g--, h--) if (e[g] !== f[h]) {
          if (1 !== g || 1 !== h) {
            do
              if (g--, h--, 0 > h || e[g] !== f[h]) {
                var k = "\n" + e[g].replace(" at new ", " at ");
                a.displayName && k.includes("<anonymous>") && (k = k.replace("<anonymous>", a.displayName));
                return k;
              }
            while (1 <= g && 0 <= h);
          }
          break;
        }
      }
    } finally {
      Na = false, Error.prepareStackTrace = c;
    }
    return (a = a ? a.displayName || a.name : "") ? Ma(a) : "";
  }
  function Pa(a) {
    switch (a.tag) {
      case 5:
        return Ma(a.type);
      case 16:
        return Ma("Lazy");
      case 13:
        return Ma("Suspense");
      case 19:
        return Ma("SuspenseList");
      case 0:
      case 2:
      case 15:
        return a = Oa(a.type, false), a;
      case 11:
        return a = Oa(a.type.render, false), a;
      case 1:
        return a = Oa(a.type, true), a;
      default:
        return "";
    }
  }
  function Qa(a) {
    if (null == a) return null;
    if ("function" === typeof a) return a.displayName || a.name || null;
    if ("string" === typeof a) return a;
    switch (a) {
      case ya:
        return "Fragment";
      case wa:
        return "Portal";
      case Aa:
        return "Profiler";
      case za:
        return "StrictMode";
      case Ea:
        return "Suspense";
      case Fa:
        return "SuspenseList";
    }
    if ("object" === typeof a) switch (a.$$typeof) {
      case Ca:
        return (a.displayName || "Context") + ".Consumer";
      case Ba:
        return (a._context.displayName || "Context") + ".Provider";
      case Da:
        var b = a.render;
        a = a.displayName;
        a || (a = b.displayName || b.name || "", a = "" !== a ? "ForwardRef(" + a + ")" : "ForwardRef");
        return a;
      case Ga:
        return b = a.displayName || null, null !== b ? b : Qa(a.type) || "Memo";
      case Ha:
        b = a._payload;
        a = a._init;
        try {
          return Qa(a(b));
        } catch (c) {
        }
    }
    return null;
  }
  function Ra(a) {
    var b = a.type;
    switch (a.tag) {
      case 24:
        return "Cache";
      case 9:
        return (b.displayName || "Context") + ".Consumer";
      case 10:
        return (b._context.displayName || "Context") + ".Provider";
      case 18:
        return "DehydratedFragment";
      case 11:
        return a = b.render, a = a.displayName || a.name || "", b.displayName || ("" !== a ? "ForwardRef(" + a + ")" : "ForwardRef");
      case 7:
        return "Fragment";
      case 5:
        return b;
      case 4:
        return "Portal";
      case 3:
        return "Root";
      case 6:
        return "Text";
      case 16:
        return Qa(b);
      case 8:
        return b === za ? "StrictMode" : "Mode";
      case 22:
        return "Offscreen";
      case 12:
        return "Profiler";
      case 21:
        return "Scope";
      case 13:
        return "Suspense";
      case 19:
        return "SuspenseList";
      case 25:
        return "TracingMarker";
      case 1:
      case 0:
      case 17:
      case 2:
      case 14:
      case 15:
        if ("function" === typeof b) return b.displayName || b.name || null;
        if ("string" === typeof b) return b;
    }
    return null;
  }
  function Sa(a) {
    switch (typeof a) {
      case "boolean":
      case "number":
      case "string":
      case "undefined":
        return a;
      case "object":
        return a;
      default:
        return "";
    }
  }
  function Ta(a) {
    var b = a.type;
    return (a = a.nodeName) && "input" === a.toLowerCase() && ("checkbox" === b || "radio" === b);
  }
  function Ua(a) {
    var b = Ta(a) ? "checked" : "value", c = Object.getOwnPropertyDescriptor(a.constructor.prototype, b), d = "" + a[b];
    if (!a.hasOwnProperty(b) && "undefined" !== typeof c && "function" === typeof c.get && "function" === typeof c.set) {
      var e = c.get, f = c.set;
      Object.defineProperty(a, b, { configurable: true, get: function() {
        return e.call(this);
      }, set: function(a2) {
        d = "" + a2;
        f.call(this, a2);
      } });
      Object.defineProperty(a, b, { enumerable: c.enumerable });
      return { getValue: function() {
        return d;
      }, setValue: function(a2) {
        d = "" + a2;
      }, stopTracking: function() {
        a._valueTracker = null;
        delete a[b];
      } };
    }
  }
  function Va(a) {
    a._valueTracker || (a._valueTracker = Ua(a));
  }
  function Wa(a) {
    if (!a) return false;
    var b = a._valueTracker;
    if (!b) return true;
    var c = b.getValue();
    var d = "";
    a && (d = Ta(a) ? a.checked ? "true" : "false" : a.value);
    a = d;
    return a !== c ? (b.setValue(a), true) : false;
  }
  function Xa(a) {
    a = a || ("undefined" !== typeof document ? document : void 0);
    if ("undefined" === typeof a) return null;
    try {
      return a.activeElement || a.body;
    } catch (b) {
      return a.body;
    }
  }
  function Ya(a, b) {
    var c = b.checked;
    return A({}, b, { defaultChecked: void 0, defaultValue: void 0, value: void 0, checked: null != c ? c : a._wrapperState.initialChecked });
  }
  function Za(a, b) {
    var c = null == b.defaultValue ? "" : b.defaultValue, d = null != b.checked ? b.checked : b.defaultChecked;
    c = Sa(null != b.value ? b.value : c);
    a._wrapperState = { initialChecked: d, initialValue: c, controlled: "checkbox" === b.type || "radio" === b.type ? null != b.checked : null != b.value };
  }
  function ab(a, b) {
    b = b.checked;
    null != b && ta(a, "checked", b, false);
  }
  function bb(a, b) {
    ab(a, b);
    var c = Sa(b.value), d = b.type;
    if (null != c) if ("number" === d) {
      if (0 === c && "" === a.value || a.value != c) a.value = "" + c;
    } else a.value !== "" + c && (a.value = "" + c);
    else if ("submit" === d || "reset" === d) {
      a.removeAttribute("value");
      return;
    }
    b.hasOwnProperty("value") ? cb(a, b.type, c) : b.hasOwnProperty("defaultValue") && cb(a, b.type, Sa(b.defaultValue));
    null == b.checked && null != b.defaultChecked && (a.defaultChecked = !!b.defaultChecked);
  }
  function db(a, b, c) {
    if (b.hasOwnProperty("value") || b.hasOwnProperty("defaultValue")) {
      var d = b.type;
      if (!("submit" !== d && "reset" !== d || void 0 !== b.value && null !== b.value)) return;
      b = "" + a._wrapperState.initialValue;
      c || b === a.value || (a.value = b);
      a.defaultValue = b;
    }
    c = a.name;
    "" !== c && (a.name = "");
    a.defaultChecked = !!a._wrapperState.initialChecked;
    "" !== c && (a.name = c);
  }
  function cb(a, b, c) {
    if ("number" !== b || Xa(a.ownerDocument) !== a) null == c ? a.defaultValue = "" + a._wrapperState.initialValue : a.defaultValue !== "" + c && (a.defaultValue = "" + c);
  }
  var eb = Array.isArray;
  function fb(a, b, c, d) {
    a = a.options;
    if (b) {
      b = {};
      for (var e = 0; e < c.length; e++) b["$" + c[e]] = true;
      for (c = 0; c < a.length; c++) e = b.hasOwnProperty("$" + a[c].value), a[c].selected !== e && (a[c].selected = e), e && d && (a[c].defaultSelected = true);
    } else {
      c = "" + Sa(c);
      b = null;
      for (e = 0; e < a.length; e++) {
        if (a[e].value === c) {
          a[e].selected = true;
          d && (a[e].defaultSelected = true);
          return;
        }
        null !== b || a[e].disabled || (b = a[e]);
      }
      null !== b && (b.selected = true);
    }
  }
  function gb(a, b) {
    if (null != b.dangerouslySetInnerHTML) throw Error(p(91));
    return A({}, b, { value: void 0, defaultValue: void 0, children: "" + a._wrapperState.initialValue });
  }
  function hb(a, b) {
    var c = b.value;
    if (null == c) {
      c = b.children;
      b = b.defaultValue;
      if (null != c) {
        if (null != b) throw Error(p(92));
        if (eb(c)) {
          if (1 < c.length) throw Error(p(93));
          c = c[0];
        }
        b = c;
      }
      null == b && (b = "");
      c = b;
    }
    a._wrapperState = { initialValue: Sa(c) };
  }
  function ib(a, b) {
    var c = Sa(b.value), d = Sa(b.defaultValue);
    null != c && (c = "" + c, c !== a.value && (a.value = c), null == b.defaultValue && a.defaultValue !== c && (a.defaultValue = c));
    null != d && (a.defaultValue = "" + d);
  }
  function jb(a) {
    var b = a.textContent;
    b === a._wrapperState.initialValue && "" !== b && null !== b && (a.value = b);
  }
  function kb(a) {
    switch (a) {
      case "svg":
        return "http://www.w3.org/2000/svg";
      case "math":
        return "http://www.w3.org/1998/Math/MathML";
      default:
        return "http://www.w3.org/1999/xhtml";
    }
  }
  function lb(a, b) {
    return null == a || "http://www.w3.org/1999/xhtml" === a ? kb(b) : "http://www.w3.org/2000/svg" === a && "foreignObject" === b ? "http://www.w3.org/1999/xhtml" : a;
  }
  var mb, nb = function(a) {
    return "undefined" !== typeof MSApp && MSApp.execUnsafeLocalFunction ? function(b, c, d, e) {
      MSApp.execUnsafeLocalFunction(function() {
        return a(b, c, d, e);
      });
    } : a;
  }(function(a, b) {
    if ("http://www.w3.org/2000/svg" !== a.namespaceURI || "innerHTML" in a) a.innerHTML = b;
    else {
      mb = mb || document.createElement("div");
      mb.innerHTML = "<svg>" + b.valueOf().toString() + "</svg>";
      for (b = mb.firstChild; a.firstChild; ) a.removeChild(a.firstChild);
      for (; b.firstChild; ) a.appendChild(b.firstChild);
    }
  });
  function ob(a, b) {
    if (b) {
      var c = a.firstChild;
      if (c && c === a.lastChild && 3 === c.nodeType) {
        c.nodeValue = b;
        return;
      }
    }
    a.textContent = b;
  }
  var pb = {
    animationIterationCount: true,
    aspectRatio: true,
    borderImageOutset: true,
    borderImageSlice: true,
    borderImageWidth: true,
    boxFlex: true,
    boxFlexGroup: true,
    boxOrdinalGroup: true,
    columnCount: true,
    columns: true,
    flex: true,
    flexGrow: true,
    flexPositive: true,
    flexShrink: true,
    flexNegative: true,
    flexOrder: true,
    gridArea: true,
    gridRow: true,
    gridRowEnd: true,
    gridRowSpan: true,
    gridRowStart: true,
    gridColumn: true,
    gridColumnEnd: true,
    gridColumnSpan: true,
    gridColumnStart: true,
    fontWeight: true,
    lineClamp: true,
    lineHeight: true,
    opacity: true,
    order: true,
    orphans: true,
    tabSize: true,
    widows: true,
    zIndex: true,
    zoom: true,
    fillOpacity: true,
    floodOpacity: true,
    stopOpacity: true,
    strokeDasharray: true,
    strokeDashoffset: true,
    strokeMiterlimit: true,
    strokeOpacity: true,
    strokeWidth: true
  }, qb = ["Webkit", "ms", "Moz", "O"];
  Object.keys(pb).forEach(function(a) {
    qb.forEach(function(b) {
      b = b + a.charAt(0).toUpperCase() + a.substring(1);
      pb[b] = pb[a];
    });
  });
  function rb(a, b, c) {
    return null == b || "boolean" === typeof b || "" === b ? "" : c || "number" !== typeof b || 0 === b || pb.hasOwnProperty(a) && pb[a] ? ("" + b).trim() : b + "px";
  }
  function sb(a, b) {
    a = a.style;
    for (var c in b) if (b.hasOwnProperty(c)) {
      var d = 0 === c.indexOf("--"), e = rb(c, b[c], d);
      "float" === c && (c = "cssFloat");
      d ? a.setProperty(c, e) : a[c] = e;
    }
  }
  var tb = A({ menuitem: true }, { area: true, base: true, br: true, col: true, embed: true, hr: true, img: true, input: true, keygen: true, link: true, meta: true, param: true, source: true, track: true, wbr: true });
  function ub(a, b) {
    if (b) {
      if (tb[a] && (null != b.children || null != b.dangerouslySetInnerHTML)) throw Error(p(137, a));
      if (null != b.dangerouslySetInnerHTML) {
        if (null != b.children) throw Error(p(60));
        if ("object" !== typeof b.dangerouslySetInnerHTML || !("__html" in b.dangerouslySetInnerHTML)) throw Error(p(61));
      }
      if (null != b.style && "object" !== typeof b.style) throw Error(p(62));
    }
  }
  function vb(a, b) {
    if (-1 === a.indexOf("-")) return "string" === typeof b.is;
    switch (a) {
      case "annotation-xml":
      case "color-profile":
      case "font-face":
      case "font-face-src":
      case "font-face-uri":
      case "font-face-format":
      case "font-face-name":
      case "missing-glyph":
        return false;
      default:
        return true;
    }
  }
  var wb = null;
  function xb(a) {
    a = a.target || a.srcElement || window;
    a.correspondingUseElement && (a = a.correspondingUseElement);
    return 3 === a.nodeType ? a.parentNode : a;
  }
  var yb = null, zb = null, Ab = null;
  function Bb(a) {
    if (a = Cb(a)) {
      if ("function" !== typeof yb) throw Error(p(280));
      var b = a.stateNode;
      b && (b = Db(b), yb(a.stateNode, a.type, b));
    }
  }
  function Eb(a) {
    zb ? Ab ? Ab.push(a) : Ab = [a] : zb = a;
  }
  function Fb() {
    if (zb) {
      var a = zb, b = Ab;
      Ab = zb = null;
      Bb(a);
      if (b) for (a = 0; a < b.length; a++) Bb(b[a]);
    }
  }
  function Gb(a, b) {
    return a(b);
  }
  function Hb() {
  }
  var Ib = false;
  function Jb(a, b, c) {
    if (Ib) return a(b, c);
    Ib = true;
    try {
      return Gb(a, b, c);
    } finally {
      if (Ib = false, null !== zb || null !== Ab) Hb(), Fb();
    }
  }
  function Kb(a, b) {
    var c = a.stateNode;
    if (null === c) return null;
    var d = Db(c);
    if (null === d) return null;
    c = d[b];
    a: switch (b) {
      case "onClick":
      case "onClickCapture":
      case "onDoubleClick":
      case "onDoubleClickCapture":
      case "onMouseDown":
      case "onMouseDownCapture":
      case "onMouseMove":
      case "onMouseMoveCapture":
      case "onMouseUp":
      case "onMouseUpCapture":
      case "onMouseEnter":
        (d = !d.disabled) || (a = a.type, d = !("button" === a || "input" === a || "select" === a || "textarea" === a));
        a = !d;
        break a;
      default:
        a = false;
    }
    if (a) return null;
    if (c && "function" !== typeof c) throw Error(p(231, b, typeof c));
    return c;
  }
  var Lb = false;
  if (ia) try {
    var Mb = {};
    Object.defineProperty(Mb, "passive", { get: function() {
      Lb = true;
    } });
    window.addEventListener("test", Mb, Mb);
    window.removeEventListener("test", Mb, Mb);
  } catch (a) {
    Lb = false;
  }
  function Nb(a, b, c, d, e, f, g, h, k) {
    var l = Array.prototype.slice.call(arguments, 3);
    try {
      b.apply(c, l);
    } catch (m) {
      this.onError(m);
    }
  }
  var Ob = false, Pb = null, Qb = false, Rb = null, Sb = { onError: function(a) {
    Ob = true;
    Pb = a;
  } };
  function Tb(a, b, c, d, e, f, g, h, k) {
    Ob = false;
    Pb = null;
    Nb.apply(Sb, arguments);
  }
  function Ub(a, b, c, d, e, f, g, h, k) {
    Tb.apply(this, arguments);
    if (Ob) {
      if (Ob) {
        var l = Pb;
        Ob = false;
        Pb = null;
      } else throw Error(p(198));
      Qb || (Qb = true, Rb = l);
    }
  }
  function Vb(a) {
    var b = a, c = a;
    if (a.alternate) for (; b.return; ) b = b.return;
    else {
      a = b;
      do
        b = a, 0 !== (b.flags & 4098) && (c = b.return), a = b.return;
      while (a);
    }
    return 3 === b.tag ? c : null;
  }
  function Wb(a) {
    if (13 === a.tag) {
      var b = a.memoizedState;
      null === b && (a = a.alternate, null !== a && (b = a.memoizedState));
      if (null !== b) return b.dehydrated;
    }
    return null;
  }
  function Xb(a) {
    if (Vb(a) !== a) throw Error(p(188));
  }
  function Yb(a) {
    var b = a.alternate;
    if (!b) {
      b = Vb(a);
      if (null === b) throw Error(p(188));
      return b !== a ? null : a;
    }
    for (var c = a, d = b; ; ) {
      var e = c.return;
      if (null === e) break;
      var f = e.alternate;
      if (null === f) {
        d = e.return;
        if (null !== d) {
          c = d;
          continue;
        }
        break;
      }
      if (e.child === f.child) {
        for (f = e.child; f; ) {
          if (f === c) return Xb(e), a;
          if (f === d) return Xb(e), b;
          f = f.sibling;
        }
        throw Error(p(188));
      }
      if (c.return !== d.return) c = e, d = f;
      else {
        for (var g = false, h = e.child; h; ) {
          if (h === c) {
            g = true;
            c = e;
            d = f;
            break;
          }
          if (h === d) {
            g = true;
            d = e;
            c = f;
            break;
          }
          h = h.sibling;
        }
        if (!g) {
          for (h = f.child; h; ) {
            if (h === c) {
              g = true;
              c = f;
              d = e;
              break;
            }
            if (h === d) {
              g = true;
              d = f;
              c = e;
              break;
            }
            h = h.sibling;
          }
          if (!g) throw Error(p(189));
        }
      }
      if (c.alternate !== d) throw Error(p(190));
    }
    if (3 !== c.tag) throw Error(p(188));
    return c.stateNode.current === c ? a : b;
  }
  function Zb(a) {
    a = Yb(a);
    return null !== a ? $b(a) : null;
  }
  function $b(a) {
    if (5 === a.tag || 6 === a.tag) return a;
    for (a = a.child; null !== a; ) {
      var b = $b(a);
      if (null !== b) return b;
      a = a.sibling;
    }
    return null;
  }
  var ac = ca.unstable_scheduleCallback, bc = ca.unstable_cancelCallback, cc = ca.unstable_shouldYield, dc = ca.unstable_requestPaint, B = ca.unstable_now, ec = ca.unstable_getCurrentPriorityLevel, fc = ca.unstable_ImmediatePriority, gc = ca.unstable_UserBlockingPriority, hc = ca.unstable_NormalPriority, ic = ca.unstable_LowPriority, jc = ca.unstable_IdlePriority, kc = null, lc = null;
  function mc(a) {
    if (lc && "function" === typeof lc.onCommitFiberRoot) try {
      lc.onCommitFiberRoot(kc, a, void 0, 128 === (a.current.flags & 128));
    } catch (b) {
    }
  }
  var oc = Math.clz32 ? Math.clz32 : nc, pc = Math.log, qc = Math.LN2;
  function nc(a) {
    a >>>= 0;
    return 0 === a ? 32 : 31 - (pc(a) / qc | 0) | 0;
  }
  var rc = 64, sc = 4194304;
  function tc(a) {
    switch (a & -a) {
      case 1:
        return 1;
      case 2:
        return 2;
      case 4:
        return 4;
      case 8:
        return 8;
      case 16:
        return 16;
      case 32:
        return 32;
      case 64:
      case 128:
      case 256:
      case 512:
      case 1024:
      case 2048:
      case 4096:
      case 8192:
      case 16384:
      case 32768:
      case 65536:
      case 131072:
      case 262144:
      case 524288:
      case 1048576:
      case 2097152:
        return a & 4194240;
      case 4194304:
      case 8388608:
      case 16777216:
      case 33554432:
      case 67108864:
        return a & 130023424;
      case 134217728:
        return 134217728;
      case 268435456:
        return 268435456;
      case 536870912:
        return 536870912;
      case 1073741824:
        return 1073741824;
      default:
        return a;
    }
  }
  function uc(a, b) {
    var c = a.pendingLanes;
    if (0 === c) return 0;
    var d = 0, e = a.suspendedLanes, f = a.pingedLanes, g = c & 268435455;
    if (0 !== g) {
      var h = g & ~e;
      0 !== h ? d = tc(h) : (f &= g, 0 !== f && (d = tc(f)));
    } else g = c & ~e, 0 !== g ? d = tc(g) : 0 !== f && (d = tc(f));
    if (0 === d) return 0;
    if (0 !== b && b !== d && 0 === (b & e) && (e = d & -d, f = b & -b, e >= f || 16 === e && 0 !== (f & 4194240))) return b;
    0 !== (d & 4) && (d |= c & 16);
    b = a.entangledLanes;
    if (0 !== b) for (a = a.entanglements, b &= d; 0 < b; ) c = 31 - oc(b), e = 1 << c, d |= a[c], b &= ~e;
    return d;
  }
  function vc(a, b) {
    switch (a) {
      case 1:
      case 2:
      case 4:
        return b + 250;
      case 8:
      case 16:
      case 32:
      case 64:
      case 128:
      case 256:
      case 512:
      case 1024:
      case 2048:
      case 4096:
      case 8192:
      case 16384:
      case 32768:
      case 65536:
      case 131072:
      case 262144:
      case 524288:
      case 1048576:
      case 2097152:
        return b + 5e3;
      case 4194304:
      case 8388608:
      case 16777216:
      case 33554432:
      case 67108864:
        return -1;
      case 134217728:
      case 268435456:
      case 536870912:
      case 1073741824:
        return -1;
      default:
        return -1;
    }
  }
  function wc(a, b) {
    for (var c = a.suspendedLanes, d = a.pingedLanes, e = a.expirationTimes, f = a.pendingLanes; 0 < f; ) {
      var g = 31 - oc(f), h = 1 << g, k = e[g];
      if (-1 === k) {
        if (0 === (h & c) || 0 !== (h & d)) e[g] = vc(h, b);
      } else k <= b && (a.expiredLanes |= h);
      f &= ~h;
    }
  }
  function xc(a) {
    a = a.pendingLanes & -1073741825;
    return 0 !== a ? a : a & 1073741824 ? 1073741824 : 0;
  }
  function yc() {
    var a = rc;
    rc <<= 1;
    0 === (rc & 4194240) && (rc = 64);
    return a;
  }
  function zc(a) {
    for (var b = [], c = 0; 31 > c; c++) b.push(a);
    return b;
  }
  function Ac(a, b, c) {
    a.pendingLanes |= b;
    536870912 !== b && (a.suspendedLanes = 0, a.pingedLanes = 0);
    a = a.eventTimes;
    b = 31 - oc(b);
    a[b] = c;
  }
  function Bc(a, b) {
    var c = a.pendingLanes & ~b;
    a.pendingLanes = b;
    a.suspendedLanes = 0;
    a.pingedLanes = 0;
    a.expiredLanes &= b;
    a.mutableReadLanes &= b;
    a.entangledLanes &= b;
    b = a.entanglements;
    var d = a.eventTimes;
    for (a = a.expirationTimes; 0 < c; ) {
      var e = 31 - oc(c), f = 1 << e;
      b[e] = 0;
      d[e] = -1;
      a[e] = -1;
      c &= ~f;
    }
  }
  function Cc(a, b) {
    var c = a.entangledLanes |= b;
    for (a = a.entanglements; c; ) {
      var d = 31 - oc(c), e = 1 << d;
      e & b | a[d] & b && (a[d] |= b);
      c &= ~e;
    }
  }
  var C = 0;
  function Dc(a) {
    a &= -a;
    return 1 < a ? 4 < a ? 0 !== (a & 268435455) ? 16 : 536870912 : 4 : 1;
  }
  var Ec, Fc, Gc, Hc, Ic, Jc = false, Kc = [], Lc = null, Mc = null, Nc = null, Oc = /* @__PURE__ */ new Map(), Pc = /* @__PURE__ */ new Map(), Qc = [], Rc = "mousedown mouseup touchcancel touchend touchstart auxclick dblclick pointercancel pointerdown pointerup dragend dragstart drop compositionend compositionstart keydown keypress keyup input textInput copy cut paste click change contextmenu reset submit".split(" ");
  function Sc(a, b) {
    switch (a) {
      case "focusin":
      case "focusout":
        Lc = null;
        break;
      case "dragenter":
      case "dragleave":
        Mc = null;
        break;
      case "mouseover":
      case "mouseout":
        Nc = null;
        break;
      case "pointerover":
      case "pointerout":
        Oc.delete(b.pointerId);
        break;
      case "gotpointercapture":
      case "lostpointercapture":
        Pc.delete(b.pointerId);
    }
  }
  function Tc(a, b, c, d, e, f) {
    if (null === a || a.nativeEvent !== f) return a = { blockedOn: b, domEventName: c, eventSystemFlags: d, nativeEvent: f, targetContainers: [e] }, null !== b && (b = Cb(b), null !== b && Fc(b)), a;
    a.eventSystemFlags |= d;
    b = a.targetContainers;
    null !== e && -1 === b.indexOf(e) && b.push(e);
    return a;
  }
  function Uc(a, b, c, d, e) {
    switch (b) {
      case "focusin":
        return Lc = Tc(Lc, a, b, c, d, e), true;
      case "dragenter":
        return Mc = Tc(Mc, a, b, c, d, e), true;
      case "mouseover":
        return Nc = Tc(Nc, a, b, c, d, e), true;
      case "pointerover":
        var f = e.pointerId;
        Oc.set(f, Tc(Oc.get(f) || null, a, b, c, d, e));
        return true;
      case "gotpointercapture":
        return f = e.pointerId, Pc.set(f, Tc(Pc.get(f) || null, a, b, c, d, e)), true;
    }
    return false;
  }
  function Vc(a) {
    var b = Wc(a.target);
    if (null !== b) {
      var c = Vb(b);
      if (null !== c) {
        if (b = c.tag, 13 === b) {
          if (b = Wb(c), null !== b) {
            a.blockedOn = b;
            Ic(a.priority, function() {
              Gc(c);
            });
            return;
          }
        } else if (3 === b && c.stateNode.current.memoizedState.isDehydrated) {
          a.blockedOn = 3 === c.tag ? c.stateNode.containerInfo : null;
          return;
        }
      }
    }
    a.blockedOn = null;
  }
  function Xc(a) {
    if (null !== a.blockedOn) return false;
    for (var b = a.targetContainers; 0 < b.length; ) {
      var c = Yc(a.domEventName, a.eventSystemFlags, b[0], a.nativeEvent);
      if (null === c) {
        c = a.nativeEvent;
        var d = new c.constructor(c.type, c);
        wb = d;
        c.target.dispatchEvent(d);
        wb = null;
      } else return b = Cb(c), null !== b && Fc(b), a.blockedOn = c, false;
      b.shift();
    }
    return true;
  }
  function Zc(a, b, c) {
    Xc(a) && c.delete(b);
  }
  function $c() {
    Jc = false;
    null !== Lc && Xc(Lc) && (Lc = null);
    null !== Mc && Xc(Mc) && (Mc = null);
    null !== Nc && Xc(Nc) && (Nc = null);
    Oc.forEach(Zc);
    Pc.forEach(Zc);
  }
  function ad(a, b) {
    a.blockedOn === b && (a.blockedOn = null, Jc || (Jc = true, ca.unstable_scheduleCallback(ca.unstable_NormalPriority, $c)));
  }
  function bd(a) {
    function b(b2) {
      return ad(b2, a);
    }
    if (0 < Kc.length) {
      ad(Kc[0], a);
      for (var c = 1; c < Kc.length; c++) {
        var d = Kc[c];
        d.blockedOn === a && (d.blockedOn = null);
      }
    }
    null !== Lc && ad(Lc, a);
    null !== Mc && ad(Mc, a);
    null !== Nc && ad(Nc, a);
    Oc.forEach(b);
    Pc.forEach(b);
    for (c = 0; c < Qc.length; c++) d = Qc[c], d.blockedOn === a && (d.blockedOn = null);
    for (; 0 < Qc.length && (c = Qc[0], null === c.blockedOn); ) Vc(c), null === c.blockedOn && Qc.shift();
  }
  var cd = ua.ReactCurrentBatchConfig, dd = true;
  function ed(a, b, c, d) {
    var e = C, f = cd.transition;
    cd.transition = null;
    try {
      C = 1, fd(a, b, c, d);
    } finally {
      C = e, cd.transition = f;
    }
  }
  function gd(a, b, c, d) {
    var e = C, f = cd.transition;
    cd.transition = null;
    try {
      C = 4, fd(a, b, c, d);
    } finally {
      C = e, cd.transition = f;
    }
  }
  function fd(a, b, c, d) {
    if (dd) {
      var e = Yc(a, b, c, d);
      if (null === e) hd(a, b, d, id, c), Sc(a, d);
      else if (Uc(e, a, b, c, d)) d.stopPropagation();
      else if (Sc(a, d), b & 4 && -1 < Rc.indexOf(a)) {
        for (; null !== e; ) {
          var f = Cb(e);
          null !== f && Ec(f);
          f = Yc(a, b, c, d);
          null === f && hd(a, b, d, id, c);
          if (f === e) break;
          e = f;
        }
        null !== e && d.stopPropagation();
      } else hd(a, b, d, null, c);
    }
  }
  var id = null;
  function Yc(a, b, c, d) {
    id = null;
    a = xb(d);
    a = Wc(a);
    if (null !== a) if (b = Vb(a), null === b) a = null;
    else if (c = b.tag, 13 === c) {
      a = Wb(b);
      if (null !== a) return a;
      a = null;
    } else if (3 === c) {
      if (b.stateNode.current.memoizedState.isDehydrated) return 3 === b.tag ? b.stateNode.containerInfo : null;
      a = null;
    } else b !== a && (a = null);
    id = a;
    return null;
  }
  function jd(a) {
    switch (a) {
      case "cancel":
      case "click":
      case "close":
      case "contextmenu":
      case "copy":
      case "cut":
      case "auxclick":
      case "dblclick":
      case "dragend":
      case "dragstart":
      case "drop":
      case "focusin":
      case "focusout":
      case "input":
      case "invalid":
      case "keydown":
      case "keypress":
      case "keyup":
      case "mousedown":
      case "mouseup":
      case "paste":
      case "pause":
      case "play":
      case "pointercancel":
      case "pointerdown":
      case "pointerup":
      case "ratechange":
      case "reset":
      case "resize":
      case "seeked":
      case "submit":
      case "touchcancel":
      case "touchend":
      case "touchstart":
      case "volumechange":
      case "change":
      case "selectionchange":
      case "textInput":
      case "compositionstart":
      case "compositionend":
      case "compositionupdate":
      case "beforeblur":
      case "afterblur":
      case "beforeinput":
      case "blur":
      case "fullscreenchange":
      case "focus":
      case "hashchange":
      case "popstate":
      case "select":
      case "selectstart":
        return 1;
      case "drag":
      case "dragenter":
      case "dragexit":
      case "dragleave":
      case "dragover":
      case "mousemove":
      case "mouseout":
      case "mouseover":
      case "pointermove":
      case "pointerout":
      case "pointerover":
      case "scroll":
      case "toggle":
      case "touchmove":
      case "wheel":
      case "mouseenter":
      case "mouseleave":
      case "pointerenter":
      case "pointerleave":
        return 4;
      case "message":
        switch (ec()) {
          case fc:
            return 1;
          case gc:
            return 4;
          case hc:
          case ic:
            return 16;
          case jc:
            return 536870912;
          default:
            return 16;
        }
      default:
        return 16;
    }
  }
  var kd = null, ld = null, md = null;
  function nd() {
    if (md) return md;
    var a, b = ld, c = b.length, d, e = "value" in kd ? kd.value : kd.textContent, f = e.length;
    for (a = 0; a < c && b[a] === e[a]; a++) ;
    var g = c - a;
    for (d = 1; d <= g && b[c - d] === e[f - d]; d++) ;
    return md = e.slice(a, 1 < d ? 1 - d : void 0);
  }
  function od(a) {
    var b = a.keyCode;
    "charCode" in a ? (a = a.charCode, 0 === a && 13 === b && (a = 13)) : a = b;
    10 === a && (a = 13);
    return 32 <= a || 13 === a ? a : 0;
  }
  function pd() {
    return true;
  }
  function qd() {
    return false;
  }
  function rd(a) {
    function b(b2, d, e, f, g) {
      this._reactName = b2;
      this._targetInst = e;
      this.type = d;
      this.nativeEvent = f;
      this.target = g;
      this.currentTarget = null;
      for (var c in a) a.hasOwnProperty(c) && (b2 = a[c], this[c] = b2 ? b2(f) : f[c]);
      this.isDefaultPrevented = (null != f.defaultPrevented ? f.defaultPrevented : false === f.returnValue) ? pd : qd;
      this.isPropagationStopped = qd;
      return this;
    }
    A(b.prototype, { preventDefault: function() {
      this.defaultPrevented = true;
      var a2 = this.nativeEvent;
      a2 && (a2.preventDefault ? a2.preventDefault() : "unknown" !== typeof a2.returnValue && (a2.returnValue = false), this.isDefaultPrevented = pd);
    }, stopPropagation: function() {
      var a2 = this.nativeEvent;
      a2 && (a2.stopPropagation ? a2.stopPropagation() : "unknown" !== typeof a2.cancelBubble && (a2.cancelBubble = true), this.isPropagationStopped = pd);
    }, persist: function() {
    }, isPersistent: pd });
    return b;
  }
  var sd = { eventPhase: 0, bubbles: 0, cancelable: 0, timeStamp: function(a) {
    return a.timeStamp || Date.now();
  }, defaultPrevented: 0, isTrusted: 0 }, td = rd(sd), ud = A({}, sd, { view: 0, detail: 0 }), vd = rd(ud), wd, xd, yd, Ad = A({}, ud, { screenX: 0, screenY: 0, clientX: 0, clientY: 0, pageX: 0, pageY: 0, ctrlKey: 0, shiftKey: 0, altKey: 0, metaKey: 0, getModifierState: zd, button: 0, buttons: 0, relatedTarget: function(a) {
    return void 0 === a.relatedTarget ? a.fromElement === a.srcElement ? a.toElement : a.fromElement : a.relatedTarget;
  }, movementX: function(a) {
    if ("movementX" in a) return a.movementX;
    a !== yd && (yd && "mousemove" === a.type ? (wd = a.screenX - yd.screenX, xd = a.screenY - yd.screenY) : xd = wd = 0, yd = a);
    return wd;
  }, movementY: function(a) {
    return "movementY" in a ? a.movementY : xd;
  } }), Bd = rd(Ad), Cd = A({}, Ad, { dataTransfer: 0 }), Dd = rd(Cd), Ed = A({}, ud, { relatedTarget: 0 }), Fd = rd(Ed), Gd = A({}, sd, { animationName: 0, elapsedTime: 0, pseudoElement: 0 }), Hd = rd(Gd), Id = A({}, sd, { clipboardData: function(a) {
    return "clipboardData" in a ? a.clipboardData : window.clipboardData;
  } }), Jd = rd(Id), Kd = A({}, sd, { data: 0 }), Ld = rd(Kd), Md = {
    Esc: "Escape",
    Spacebar: " ",
    Left: "ArrowLeft",
    Up: "ArrowUp",
    Right: "ArrowRight",
    Down: "ArrowDown",
    Del: "Delete",
    Win: "OS",
    Menu: "ContextMenu",
    Apps: "ContextMenu",
    Scroll: "ScrollLock",
    MozPrintableKey: "Unidentified"
  }, Nd = {
    8: "Backspace",
    9: "Tab",
    12: "Clear",
    13: "Enter",
    16: "Shift",
    17: "Control",
    18: "Alt",
    19: "Pause",
    20: "CapsLock",
    27: "Escape",
    32: " ",
    33: "PageUp",
    34: "PageDown",
    35: "End",
    36: "Home",
    37: "ArrowLeft",
    38: "ArrowUp",
    39: "ArrowRight",
    40: "ArrowDown",
    45: "Insert",
    46: "Delete",
    112: "F1",
    113: "F2",
    114: "F3",
    115: "F4",
    116: "F5",
    117: "F6",
    118: "F7",
    119: "F8",
    120: "F9",
    121: "F10",
    122: "F11",
    123: "F12",
    144: "NumLock",
    145: "ScrollLock",
    224: "Meta"
  }, Od = { Alt: "altKey", Control: "ctrlKey", Meta: "metaKey", Shift: "shiftKey" };
  function Pd(a) {
    var b = this.nativeEvent;
    return b.getModifierState ? b.getModifierState(a) : (a = Od[a]) ? !!b[a] : false;
  }
  function zd() {
    return Pd;
  }
  var Qd = A({}, ud, { key: function(a) {
    if (a.key) {
      var b = Md[a.key] || a.key;
      if ("Unidentified" !== b) return b;
    }
    return "keypress" === a.type ? (a = od(a), 13 === a ? "Enter" : String.fromCharCode(a)) : "keydown" === a.type || "keyup" === a.type ? Nd[a.keyCode] || "Unidentified" : "";
  }, code: 0, location: 0, ctrlKey: 0, shiftKey: 0, altKey: 0, metaKey: 0, repeat: 0, locale: 0, getModifierState: zd, charCode: function(a) {
    return "keypress" === a.type ? od(a) : 0;
  }, keyCode: function(a) {
    return "keydown" === a.type || "keyup" === a.type ? a.keyCode : 0;
  }, which: function(a) {
    return "keypress" === a.type ? od(a) : "keydown" === a.type || "keyup" === a.type ? a.keyCode : 0;
  } }), Rd = rd(Qd), Sd = A({}, Ad, { pointerId: 0, width: 0, height: 0, pressure: 0, tangentialPressure: 0, tiltX: 0, tiltY: 0, twist: 0, pointerType: 0, isPrimary: 0 }), Td = rd(Sd), Ud = A({}, ud, { touches: 0, targetTouches: 0, changedTouches: 0, altKey: 0, metaKey: 0, ctrlKey: 0, shiftKey: 0, getModifierState: zd }), Vd = rd(Ud), Wd = A({}, sd, { propertyName: 0, elapsedTime: 0, pseudoElement: 0 }), Xd = rd(Wd), Yd = A({}, Ad, {
    deltaX: function(a) {
      return "deltaX" in a ? a.deltaX : "wheelDeltaX" in a ? -a.wheelDeltaX : 0;
    },
    deltaY: function(a) {
      return "deltaY" in a ? a.deltaY : "wheelDeltaY" in a ? -a.wheelDeltaY : "wheelDelta" in a ? -a.wheelDelta : 0;
    },
    deltaZ: 0,
    deltaMode: 0
  }), Zd = rd(Yd), $d = [9, 13, 27, 32], ae = ia && "CompositionEvent" in window, be = null;
  ia && "documentMode" in document && (be = document.documentMode);
  var ce = ia && "TextEvent" in window && !be, de = ia && (!ae || be && 8 < be && 11 >= be), ee = String.fromCharCode(32), fe = false;
  function ge(a, b) {
    switch (a) {
      case "keyup":
        return -1 !== $d.indexOf(b.keyCode);
      case "keydown":
        return 229 !== b.keyCode;
      case "keypress":
      case "mousedown":
      case "focusout":
        return true;
      default:
        return false;
    }
  }
  function he(a) {
    a = a.detail;
    return "object" === typeof a && "data" in a ? a.data : null;
  }
  var ie = false;
  function je(a, b) {
    switch (a) {
      case "compositionend":
        return he(b);
      case "keypress":
        if (32 !== b.which) return null;
        fe = true;
        return ee;
      case "textInput":
        return a = b.data, a === ee && fe ? null : a;
      default:
        return null;
    }
  }
  function ke(a, b) {
    if (ie) return "compositionend" === a || !ae && ge(a, b) ? (a = nd(), md = ld = kd = null, ie = false, a) : null;
    switch (a) {
      case "paste":
        return null;
      case "keypress":
        if (!(b.ctrlKey || b.altKey || b.metaKey) || b.ctrlKey && b.altKey) {
          if (b.char && 1 < b.char.length) return b.char;
          if (b.which) return String.fromCharCode(b.which);
        }
        return null;
      case "compositionend":
        return de && "ko" !== b.locale ? null : b.data;
      default:
        return null;
    }
  }
  var le = { color: true, date: true, datetime: true, "datetime-local": true, email: true, month: true, number: true, password: true, range: true, search: true, tel: true, text: true, time: true, url: true, week: true };
  function me(a) {
    var b = a && a.nodeName && a.nodeName.toLowerCase();
    return "input" === b ? !!le[a.type] : "textarea" === b ? true : false;
  }
  function ne(a, b, c, d) {
    Eb(d);
    b = oe(b, "onChange");
    0 < b.length && (c = new td("onChange", "change", null, c, d), a.push({ event: c, listeners: b }));
  }
  var pe = null, qe = null;
  function re(a) {
    se(a, 0);
  }
  function te(a) {
    var b = ue(a);
    if (Wa(b)) return a;
  }
  function ve(a, b) {
    if ("change" === a) return b;
  }
  var we = false;
  if (ia) {
    var xe;
    if (ia) {
      var ye = "oninput" in document;
      if (!ye) {
        var ze = document.createElement("div");
        ze.setAttribute("oninput", "return;");
        ye = "function" === typeof ze.oninput;
      }
      xe = ye;
    } else xe = false;
    we = xe && (!document.documentMode || 9 < document.documentMode);
  }
  function Ae() {
    pe && (pe.detachEvent("onpropertychange", Be), qe = pe = null);
  }
  function Be(a) {
    if ("value" === a.propertyName && te(qe)) {
      var b = [];
      ne(b, qe, a, xb(a));
      Jb(re, b);
    }
  }
  function Ce(a, b, c) {
    "focusin" === a ? (Ae(), pe = b, qe = c, pe.attachEvent("onpropertychange", Be)) : "focusout" === a && Ae();
  }
  function De(a) {
    if ("selectionchange" === a || "keyup" === a || "keydown" === a) return te(qe);
  }
  function Ee(a, b) {
    if ("click" === a) return te(b);
  }
  function Fe(a, b) {
    if ("input" === a || "change" === a) return te(b);
  }
  function Ge(a, b) {
    return a === b && (0 !== a || 1 / a === 1 / b) || a !== a && b !== b;
  }
  var He = "function" === typeof Object.is ? Object.is : Ge;
  function Ie(a, b) {
    if (He(a, b)) return true;
    if ("object" !== typeof a || null === a || "object" !== typeof b || null === b) return false;
    var c = Object.keys(a), d = Object.keys(b);
    if (c.length !== d.length) return false;
    for (d = 0; d < c.length; d++) {
      var e = c[d];
      if (!ja.call(b, e) || !He(a[e], b[e])) return false;
    }
    return true;
  }
  function Je(a) {
    for (; a && a.firstChild; ) a = a.firstChild;
    return a;
  }
  function Ke(a, b) {
    var c = Je(a);
    a = 0;
    for (var d; c; ) {
      if (3 === c.nodeType) {
        d = a + c.textContent.length;
        if (a <= b && d >= b) return { node: c, offset: b - a };
        a = d;
      }
      a: {
        for (; c; ) {
          if (c.nextSibling) {
            c = c.nextSibling;
            break a;
          }
          c = c.parentNode;
        }
        c = void 0;
      }
      c = Je(c);
    }
  }
  function Le(a, b) {
    return a && b ? a === b ? true : a && 3 === a.nodeType ? false : b && 3 === b.nodeType ? Le(a, b.parentNode) : "contains" in a ? a.contains(b) : a.compareDocumentPosition ? !!(a.compareDocumentPosition(b) & 16) : false : false;
  }
  function Me() {
    for (var a = window, b = Xa(); b instanceof a.HTMLIFrameElement; ) {
      try {
        var c = "string" === typeof b.contentWindow.location.href;
      } catch (d) {
        c = false;
      }
      if (c) a = b.contentWindow;
      else break;
      b = Xa(a.document);
    }
    return b;
  }
  function Ne(a) {
    var b = a && a.nodeName && a.nodeName.toLowerCase();
    return b && ("input" === b && ("text" === a.type || "search" === a.type || "tel" === a.type || "url" === a.type || "password" === a.type) || "textarea" === b || "true" === a.contentEditable);
  }
  function Oe(a) {
    var b = Me(), c = a.focusedElem, d = a.selectionRange;
    if (b !== c && c && c.ownerDocument && Le(c.ownerDocument.documentElement, c)) {
      if (null !== d && Ne(c)) {
        if (b = d.start, a = d.end, void 0 === a && (a = b), "selectionStart" in c) c.selectionStart = b, c.selectionEnd = Math.min(a, c.value.length);
        else if (a = (b = c.ownerDocument || document) && b.defaultView || window, a.getSelection) {
          a = a.getSelection();
          var e = c.textContent.length, f = Math.min(d.start, e);
          d = void 0 === d.end ? f : Math.min(d.end, e);
          !a.extend && f > d && (e = d, d = f, f = e);
          e = Ke(c, f);
          var g = Ke(
            c,
            d
          );
          e && g && (1 !== a.rangeCount || a.anchorNode !== e.node || a.anchorOffset !== e.offset || a.focusNode !== g.node || a.focusOffset !== g.offset) && (b = b.createRange(), b.setStart(e.node, e.offset), a.removeAllRanges(), f > d ? (a.addRange(b), a.extend(g.node, g.offset)) : (b.setEnd(g.node, g.offset), a.addRange(b)));
        }
      }
      b = [];
      for (a = c; a = a.parentNode; ) 1 === a.nodeType && b.push({ element: a, left: a.scrollLeft, top: a.scrollTop });
      "function" === typeof c.focus && c.focus();
      for (c = 0; c < b.length; c++) a = b[c], a.element.scrollLeft = a.left, a.element.scrollTop = a.top;
    }
  }
  var Pe = ia && "documentMode" in document && 11 >= document.documentMode, Qe = null, Re = null, Se = null, Te = false;
  function Ue(a, b, c) {
    var d = c.window === c ? c.document : 9 === c.nodeType ? c : c.ownerDocument;
    Te || null == Qe || Qe !== Xa(d) || (d = Qe, "selectionStart" in d && Ne(d) ? d = { start: d.selectionStart, end: d.selectionEnd } : (d = (d.ownerDocument && d.ownerDocument.defaultView || window).getSelection(), d = { anchorNode: d.anchorNode, anchorOffset: d.anchorOffset, focusNode: d.focusNode, focusOffset: d.focusOffset }), Se && Ie(Se, d) || (Se = d, d = oe(Re, "onSelect"), 0 < d.length && (b = new td("onSelect", "select", null, b, c), a.push({ event: b, listeners: d }), b.target = Qe)));
  }
  function Ve(a, b) {
    var c = {};
    c[a.toLowerCase()] = b.toLowerCase();
    c["Webkit" + a] = "webkit" + b;
    c["Moz" + a] = "moz" + b;
    return c;
  }
  var We = { animationend: Ve("Animation", "AnimationEnd"), animationiteration: Ve("Animation", "AnimationIteration"), animationstart: Ve("Animation", "AnimationStart"), transitionend: Ve("Transition", "TransitionEnd") }, Xe = {}, Ye = {};
  ia && (Ye = document.createElement("div").style, "AnimationEvent" in window || (delete We.animationend.animation, delete We.animationiteration.animation, delete We.animationstart.animation), "TransitionEvent" in window || delete We.transitionend.transition);
  function Ze(a) {
    if (Xe[a]) return Xe[a];
    if (!We[a]) return a;
    var b = We[a], c;
    for (c in b) if (b.hasOwnProperty(c) && c in Ye) return Xe[a] = b[c];
    return a;
  }
  var $e = Ze("animationend"), af = Ze("animationiteration"), bf = Ze("animationstart"), cf = Ze("transitionend"), df = /* @__PURE__ */ new Map(), ef = "abort auxClick cancel canPlay canPlayThrough click close contextMenu copy cut drag dragEnd dragEnter dragExit dragLeave dragOver dragStart drop durationChange emptied encrypted ended error gotPointerCapture input invalid keyDown keyPress keyUp load loadedData loadedMetadata loadStart lostPointerCapture mouseDown mouseMove mouseOut mouseOver mouseUp paste pause play playing pointerCancel pointerDown pointerMove pointerOut pointerOver pointerUp progress rateChange reset resize seeked seeking stalled submit suspend timeUpdate touchCancel touchEnd touchStart volumeChange scroll toggle touchMove waiting wheel".split(" ");
  function ff(a, b) {
    df.set(a, b);
    fa(b, [a]);
  }
  for (var gf = 0; gf < ef.length; gf++) {
    var hf = ef[gf], jf = hf.toLowerCase(), kf = hf[0].toUpperCase() + hf.slice(1);
    ff(jf, "on" + kf);
  }
  ff($e, "onAnimationEnd");
  ff(af, "onAnimationIteration");
  ff(bf, "onAnimationStart");
  ff("dblclick", "onDoubleClick");
  ff("focusin", "onFocus");
  ff("focusout", "onBlur");
  ff(cf, "onTransitionEnd");
  ha("onMouseEnter", ["mouseout", "mouseover"]);
  ha("onMouseLeave", ["mouseout", "mouseover"]);
  ha("onPointerEnter", ["pointerout", "pointerover"]);
  ha("onPointerLeave", ["pointerout", "pointerover"]);
  fa("onChange", "change click focusin focusout input keydown keyup selectionchange".split(" "));
  fa("onSelect", "focusout contextmenu dragend focusin keydown keyup mousedown mouseup selectionchange".split(" "));
  fa("onBeforeInput", ["compositionend", "keypress", "textInput", "paste"]);
  fa("onCompositionEnd", "compositionend focusout keydown keypress keyup mousedown".split(" "));
  fa("onCompositionStart", "compositionstart focusout keydown keypress keyup mousedown".split(" "));
  fa("onCompositionUpdate", "compositionupdate focusout keydown keypress keyup mousedown".split(" "));
  var lf = "abort canplay canplaythrough durationchange emptied encrypted ended error loadeddata loadedmetadata loadstart pause play playing progress ratechange resize seeked seeking stalled suspend timeupdate volumechange waiting".split(" "), mf = new Set("cancel close invalid load scroll toggle".split(" ").concat(lf));
  function nf(a, b, c) {
    var d = a.type || "unknown-event";
    a.currentTarget = c;
    Ub(d, b, void 0, a);
    a.currentTarget = null;
  }
  function se(a, b) {
    b = 0 !== (b & 4);
    for (var c = 0; c < a.length; c++) {
      var d = a[c], e = d.event;
      d = d.listeners;
      a: {
        var f = void 0;
        if (b) for (var g = d.length - 1; 0 <= g; g--) {
          var h = d[g], k = h.instance, l = h.currentTarget;
          h = h.listener;
          if (k !== f && e.isPropagationStopped()) break a;
          nf(e, h, l);
          f = k;
        }
        else for (g = 0; g < d.length; g++) {
          h = d[g];
          k = h.instance;
          l = h.currentTarget;
          h = h.listener;
          if (k !== f && e.isPropagationStopped()) break a;
          nf(e, h, l);
          f = k;
        }
      }
    }
    if (Qb) throw a = Rb, Qb = false, Rb = null, a;
  }
  function D(a, b) {
    var c = b[of];
    void 0 === c && (c = b[of] = /* @__PURE__ */ new Set());
    var d = a + "__bubble";
    c.has(d) || (pf(b, a, 2, false), c.add(d));
  }
  function qf(a, b, c) {
    var d = 0;
    b && (d |= 4);
    pf(c, a, d, b);
  }
  var rf = "_reactListening" + Math.random().toString(36).slice(2);
  function sf(a) {
    if (!a[rf]) {
      a[rf] = true;
      da.forEach(function(b2) {
        "selectionchange" !== b2 && (mf.has(b2) || qf(b2, false, a), qf(b2, true, a));
      });
      var b = 9 === a.nodeType ? a : a.ownerDocument;
      null === b || b[rf] || (b[rf] = true, qf("selectionchange", false, b));
    }
  }
  function pf(a, b, c, d) {
    switch (jd(b)) {
      case 1:
        var e = ed;
        break;
      case 4:
        e = gd;
        break;
      default:
        e = fd;
    }
    c = e.bind(null, b, c, a);
    e = void 0;
    !Lb || "touchstart" !== b && "touchmove" !== b && "wheel" !== b || (e = true);
    d ? void 0 !== e ? a.addEventListener(b, c, { capture: true, passive: e }) : a.addEventListener(b, c, true) : void 0 !== e ? a.addEventListener(b, c, { passive: e }) : a.addEventListener(b, c, false);
  }
  function hd(a, b, c, d, e) {
    var f = d;
    if (0 === (b & 1) && 0 === (b & 2) && null !== d) a: for (; ; ) {
      if (null === d) return;
      var g = d.tag;
      if (3 === g || 4 === g) {
        var h = d.stateNode.containerInfo;
        if (h === e || 8 === h.nodeType && h.parentNode === e) break;
        if (4 === g) for (g = d.return; null !== g; ) {
          var k = g.tag;
          if (3 === k || 4 === k) {
            if (k = g.stateNode.containerInfo, k === e || 8 === k.nodeType && k.parentNode === e) return;
          }
          g = g.return;
        }
        for (; null !== h; ) {
          g = Wc(h);
          if (null === g) return;
          k = g.tag;
          if (5 === k || 6 === k) {
            d = f = g;
            continue a;
          }
          h = h.parentNode;
        }
      }
      d = d.return;
    }
    Jb(function() {
      var d2 = f, e2 = xb(c), g2 = [];
      a: {
        var h2 = df.get(a);
        if (void 0 !== h2) {
          var k2 = td, n = a;
          switch (a) {
            case "keypress":
              if (0 === od(c)) break a;
            case "keydown":
            case "keyup":
              k2 = Rd;
              break;
            case "focusin":
              n = "focus";
              k2 = Fd;
              break;
            case "focusout":
              n = "blur";
              k2 = Fd;
              break;
            case "beforeblur":
            case "afterblur":
              k2 = Fd;
              break;
            case "click":
              if (2 === c.button) break a;
            case "auxclick":
            case "dblclick":
            case "mousedown":
            case "mousemove":
            case "mouseup":
            case "mouseout":
            case "mouseover":
            case "contextmenu":
              k2 = Bd;
              break;
            case "drag":
            case "dragend":
            case "dragenter":
            case "dragexit":
            case "dragleave":
            case "dragover":
            case "dragstart":
            case "drop":
              k2 = Dd;
              break;
            case "touchcancel":
            case "touchend":
            case "touchmove":
            case "touchstart":
              k2 = Vd;
              break;
            case $e:
            case af:
            case bf:
              k2 = Hd;
              break;
            case cf:
              k2 = Xd;
              break;
            case "scroll":
              k2 = vd;
              break;
            case "wheel":
              k2 = Zd;
              break;
            case "copy":
            case "cut":
            case "paste":
              k2 = Jd;
              break;
            case "gotpointercapture":
            case "lostpointercapture":
            case "pointercancel":
            case "pointerdown":
            case "pointermove":
            case "pointerout":
            case "pointerover":
            case "pointerup":
              k2 = Td;
          }
          var t = 0 !== (b & 4), J = !t && "scroll" === a, x = t ? null !== h2 ? h2 + "Capture" : null : h2;
          t = [];
          for (var w = d2, u; null !== w; ) {
            u = w;
            var F = u.stateNode;
            5 === u.tag && null !== F && (u = F, null !== x && (F = Kb(w, x), null != F && t.push(tf(w, F, u))));
            if (J) break;
            w = w.return;
          }
          0 < t.length && (h2 = new k2(h2, n, null, c, e2), g2.push({ event: h2, listeners: t }));
        }
      }
      if (0 === (b & 7)) {
        a: {
          h2 = "mouseover" === a || "pointerover" === a;
          k2 = "mouseout" === a || "pointerout" === a;
          if (h2 && c !== wb && (n = c.relatedTarget || c.fromElement) && (Wc(n) || n[uf])) break a;
          if (k2 || h2) {
            h2 = e2.window === e2 ? e2 : (h2 = e2.ownerDocument) ? h2.defaultView || h2.parentWindow : window;
            if (k2) {
              if (n = c.relatedTarget || c.toElement, k2 = d2, n = n ? Wc(n) : null, null !== n && (J = Vb(n), n !== J || 5 !== n.tag && 6 !== n.tag)) n = null;
            } else k2 = null, n = d2;
            if (k2 !== n) {
              t = Bd;
              F = "onMouseLeave";
              x = "onMouseEnter";
              w = "mouse";
              if ("pointerout" === a || "pointerover" === a) t = Td, F = "onPointerLeave", x = "onPointerEnter", w = "pointer";
              J = null == k2 ? h2 : ue(k2);
              u = null == n ? h2 : ue(n);
              h2 = new t(F, w + "leave", k2, c, e2);
              h2.target = J;
              h2.relatedTarget = u;
              F = null;
              Wc(e2) === d2 && (t = new t(x, w + "enter", n, c, e2), t.target = u, t.relatedTarget = J, F = t);
              J = F;
              if (k2 && n) b: {
                t = k2;
                x = n;
                w = 0;
                for (u = t; u; u = vf(u)) w++;
                u = 0;
                for (F = x; F; F = vf(F)) u++;
                for (; 0 < w - u; ) t = vf(t), w--;
                for (; 0 < u - w; ) x = vf(x), u--;
                for (; w--; ) {
                  if (t === x || null !== x && t === x.alternate) break b;
                  t = vf(t);
                  x = vf(x);
                }
                t = null;
              }
              else t = null;
              null !== k2 && wf(g2, h2, k2, t, false);
              null !== n && null !== J && wf(g2, J, n, t, true);
            }
          }
        }
        a: {
          h2 = d2 ? ue(d2) : window;
          k2 = h2.nodeName && h2.nodeName.toLowerCase();
          if ("select" === k2 || "input" === k2 && "file" === h2.type) var na = ve;
          else if (me(h2)) if (we) na = Fe;
          else {
            na = De;
            var xa = Ce;
          }
          else (k2 = h2.nodeName) && "input" === k2.toLowerCase() && ("checkbox" === h2.type || "radio" === h2.type) && (na = Ee);
          if (na && (na = na(a, d2))) {
            ne(g2, na, c, e2);
            break a;
          }
          xa && xa(a, h2, d2);
          "focusout" === a && (xa = h2._wrapperState) && xa.controlled && "number" === h2.type && cb(h2, "number", h2.value);
        }
        xa = d2 ? ue(d2) : window;
        switch (a) {
          case "focusin":
            if (me(xa) || "true" === xa.contentEditable) Qe = xa, Re = d2, Se = null;
            break;
          case "focusout":
            Se = Re = Qe = null;
            break;
          case "mousedown":
            Te = true;
            break;
          case "contextmenu":
          case "mouseup":
          case "dragend":
            Te = false;
            Ue(g2, c, e2);
            break;
          case "selectionchange":
            if (Pe) break;
          case "keydown":
          case "keyup":
            Ue(g2, c, e2);
        }
        var $a;
        if (ae) b: {
          switch (a) {
            case "compositionstart":
              var ba = "onCompositionStart";
              break b;
            case "compositionend":
              ba = "onCompositionEnd";
              break b;
            case "compositionupdate":
              ba = "onCompositionUpdate";
              break b;
          }
          ba = void 0;
        }
        else ie ? ge(a, c) && (ba = "onCompositionEnd") : "keydown" === a && 229 === c.keyCode && (ba = "onCompositionStart");
        ba && (de && "ko" !== c.locale && (ie || "onCompositionStart" !== ba ? "onCompositionEnd" === ba && ie && ($a = nd()) : (kd = e2, ld = "value" in kd ? kd.value : kd.textContent, ie = true)), xa = oe(d2, ba), 0 < xa.length && (ba = new Ld(ba, a, null, c, e2), g2.push({ event: ba, listeners: xa }), $a ? ba.data = $a : ($a = he(c), null !== $a && (ba.data = $a))));
        if ($a = ce ? je(a, c) : ke(a, c)) d2 = oe(d2, "onBeforeInput"), 0 < d2.length && (e2 = new Ld("onBeforeInput", "beforeinput", null, c, e2), g2.push({ event: e2, listeners: d2 }), e2.data = $a);
      }
      se(g2, b);
    });
  }
  function tf(a, b, c) {
    return { instance: a, listener: b, currentTarget: c };
  }
  function oe(a, b) {
    for (var c = b + "Capture", d = []; null !== a; ) {
      var e = a, f = e.stateNode;
      5 === e.tag && null !== f && (e = f, f = Kb(a, c), null != f && d.unshift(tf(a, f, e)), f = Kb(a, b), null != f && d.push(tf(a, f, e)));
      a = a.return;
    }
    return d;
  }
  function vf(a) {
    if (null === a) return null;
    do
      a = a.return;
    while (a && 5 !== a.tag);
    return a ? a : null;
  }
  function wf(a, b, c, d, e) {
    for (var f = b._reactName, g = []; null !== c && c !== d; ) {
      var h = c, k = h.alternate, l = h.stateNode;
      if (null !== k && k === d) break;
      5 === h.tag && null !== l && (h = l, e ? (k = Kb(c, f), null != k && g.unshift(tf(c, k, h))) : e || (k = Kb(c, f), null != k && g.push(tf(c, k, h))));
      c = c.return;
    }
    0 !== g.length && a.push({ event: b, listeners: g });
  }
  var xf = /\r\n?/g, yf = /\u0000|\uFFFD/g;
  function zf(a) {
    return ("string" === typeof a ? a : "" + a).replace(xf, "\n").replace(yf, "");
  }
  function Af(a, b, c) {
    b = zf(b);
    if (zf(a) !== b && c) throw Error(p(425));
  }
  function Bf() {
  }
  var Cf = null, Df = null;
  function Ef(a, b) {
    return "textarea" === a || "noscript" === a || "string" === typeof b.children || "number" === typeof b.children || "object" === typeof b.dangerouslySetInnerHTML && null !== b.dangerouslySetInnerHTML && null != b.dangerouslySetInnerHTML.__html;
  }
  var Ff = "function" === typeof setTimeout ? setTimeout : void 0, Gf = "function" === typeof clearTimeout ? clearTimeout : void 0, Hf = "function" === typeof Promise ? Promise : void 0, Jf = "function" === typeof queueMicrotask ? queueMicrotask : "undefined" !== typeof Hf ? function(a) {
    return Hf.resolve(null).then(a).catch(If);
  } : Ff;
  function If(a) {
    setTimeout(function() {
      throw a;
    });
  }
  function Kf(a, b) {
    var c = b, d = 0;
    do {
      var e = c.nextSibling;
      a.removeChild(c);
      if (e && 8 === e.nodeType) if (c = e.data, "/$" === c) {
        if (0 === d) {
          a.removeChild(e);
          bd(b);
          return;
        }
        d--;
      } else "$" !== c && "$?" !== c && "$!" !== c || d++;
      c = e;
    } while (c);
    bd(b);
  }
  function Lf(a) {
    for (; null != a; a = a.nextSibling) {
      var b = a.nodeType;
      if (1 === b || 3 === b) break;
      if (8 === b) {
        b = a.data;
        if ("$" === b || "$!" === b || "$?" === b) break;
        if ("/$" === b) return null;
      }
    }
    return a;
  }
  function Mf(a) {
    a = a.previousSibling;
    for (var b = 0; a; ) {
      if (8 === a.nodeType) {
        var c = a.data;
        if ("$" === c || "$!" === c || "$?" === c) {
          if (0 === b) return a;
          b--;
        } else "/$" === c && b++;
      }
      a = a.previousSibling;
    }
    return null;
  }
  var Nf = Math.random().toString(36).slice(2), Of = "__reactFiber$" + Nf, Pf = "__reactProps$" + Nf, uf = "__reactContainer$" + Nf, of = "__reactEvents$" + Nf, Qf = "__reactListeners$" + Nf, Rf = "__reactHandles$" + Nf;
  function Wc(a) {
    var b = a[Of];
    if (b) return b;
    for (var c = a.parentNode; c; ) {
      if (b = c[uf] || c[Of]) {
        c = b.alternate;
        if (null !== b.child || null !== c && null !== c.child) for (a = Mf(a); null !== a; ) {
          if (c = a[Of]) return c;
          a = Mf(a);
        }
        return b;
      }
      a = c;
      c = a.parentNode;
    }
    return null;
  }
  function Cb(a) {
    a = a[Of] || a[uf];
    return !a || 5 !== a.tag && 6 !== a.tag && 13 !== a.tag && 3 !== a.tag ? null : a;
  }
  function ue(a) {
    if (5 === a.tag || 6 === a.tag) return a.stateNode;
    throw Error(p(33));
  }
  function Db(a) {
    return a[Pf] || null;
  }
  var Sf = [], Tf = -1;
  function Uf(a) {
    return { current: a };
  }
  function E(a) {
    0 > Tf || (a.current = Sf[Tf], Sf[Tf] = null, Tf--);
  }
  function G(a, b) {
    Tf++;
    Sf[Tf] = a.current;
    a.current = b;
  }
  var Vf = {}, H = Uf(Vf), Wf = Uf(false), Xf = Vf;
  function Yf(a, b) {
    var c = a.type.contextTypes;
    if (!c) return Vf;
    var d = a.stateNode;
    if (d && d.__reactInternalMemoizedUnmaskedChildContext === b) return d.__reactInternalMemoizedMaskedChildContext;
    var e = {}, f;
    for (f in c) e[f] = b[f];
    d && (a = a.stateNode, a.__reactInternalMemoizedUnmaskedChildContext = b, a.__reactInternalMemoizedMaskedChildContext = e);
    return e;
  }
  function Zf(a) {
    a = a.childContextTypes;
    return null !== a && void 0 !== a;
  }
  function $f() {
    E(Wf);
    E(H);
  }
  function ag(a, b, c) {
    if (H.current !== Vf) throw Error(p(168));
    G(H, b);
    G(Wf, c);
  }
  function bg(a, b, c) {
    var d = a.stateNode;
    b = b.childContextTypes;
    if ("function" !== typeof d.getChildContext) return c;
    d = d.getChildContext();
    for (var e in d) if (!(e in b)) throw Error(p(108, Ra(a) || "Unknown", e));
    return A({}, c, d);
  }
  function cg(a) {
    a = (a = a.stateNode) && a.__reactInternalMemoizedMergedChildContext || Vf;
    Xf = H.current;
    G(H, a);
    G(Wf, Wf.current);
    return true;
  }
  function dg(a, b, c) {
    var d = a.stateNode;
    if (!d) throw Error(p(169));
    c ? (a = bg(a, b, Xf), d.__reactInternalMemoizedMergedChildContext = a, E(Wf), E(H), G(H, a)) : E(Wf);
    G(Wf, c);
  }
  var eg = null, fg = false, gg = false;
  function hg(a) {
    null === eg ? eg = [a] : eg.push(a);
  }
  function ig(a) {
    fg = true;
    hg(a);
  }
  function jg() {
    if (!gg && null !== eg) {
      gg = true;
      var a = 0, b = C;
      try {
        var c = eg;
        for (C = 1; a < c.length; a++) {
          var d = c[a];
          do
            d = d(true);
          while (null !== d);
        }
        eg = null;
        fg = false;
      } catch (e) {
        throw null !== eg && (eg = eg.slice(a + 1)), ac(fc, jg), e;
      } finally {
        C = b, gg = false;
      }
    }
    return null;
  }
  var kg = [], lg = 0, mg = null, ng = 0, og = [], pg = 0, qg = null, rg = 1, sg = "";
  function tg(a, b) {
    kg[lg++] = ng;
    kg[lg++] = mg;
    mg = a;
    ng = b;
  }
  function ug(a, b, c) {
    og[pg++] = rg;
    og[pg++] = sg;
    og[pg++] = qg;
    qg = a;
    var d = rg;
    a = sg;
    var e = 32 - oc(d) - 1;
    d &= ~(1 << e);
    c += 1;
    var f = 32 - oc(b) + e;
    if (30 < f) {
      var g = e - e % 5;
      f = (d & (1 << g) - 1).toString(32);
      d >>= g;
      e -= g;
      rg = 1 << 32 - oc(b) + e | c << e | d;
      sg = f + a;
    } else rg = 1 << f | c << e | d, sg = a;
  }
  function vg(a) {
    null !== a.return && (tg(a, 1), ug(a, 1, 0));
  }
  function wg(a) {
    for (; a === mg; ) mg = kg[--lg], kg[lg] = null, ng = kg[--lg], kg[lg] = null;
    for (; a === qg; ) qg = og[--pg], og[pg] = null, sg = og[--pg], og[pg] = null, rg = og[--pg], og[pg] = null;
  }
  var xg = null, yg = null, I = false, zg = null;
  function Ag(a, b) {
    var c = Bg(5, null, null, 0);
    c.elementType = "DELETED";
    c.stateNode = b;
    c.return = a;
    b = a.deletions;
    null === b ? (a.deletions = [c], a.flags |= 16) : b.push(c);
  }
  function Cg(a, b) {
    switch (a.tag) {
      case 5:
        var c = a.type;
        b = 1 !== b.nodeType || c.toLowerCase() !== b.nodeName.toLowerCase() ? null : b;
        return null !== b ? (a.stateNode = b, xg = a, yg = Lf(b.firstChild), true) : false;
      case 6:
        return b = "" === a.pendingProps || 3 !== b.nodeType ? null : b, null !== b ? (a.stateNode = b, xg = a, yg = null, true) : false;
      case 13:
        return b = 8 !== b.nodeType ? null : b, null !== b ? (c = null !== qg ? { id: rg, overflow: sg } : null, a.memoizedState = { dehydrated: b, treeContext: c, retryLane: 1073741824 }, c = Bg(18, null, null, 0), c.stateNode = b, c.return = a, a.child = c, xg = a, yg = null, true) : false;
      default:
        return false;
    }
  }
  function Dg(a) {
    return 0 !== (a.mode & 1) && 0 === (a.flags & 128);
  }
  function Eg(a) {
    if (I) {
      var b = yg;
      if (b) {
        var c = b;
        if (!Cg(a, b)) {
          if (Dg(a)) throw Error(p(418));
          b = Lf(c.nextSibling);
          var d = xg;
          b && Cg(a, b) ? Ag(d, c) : (a.flags = a.flags & -4097 | 2, I = false, xg = a);
        }
      } else {
        if (Dg(a)) throw Error(p(418));
        a.flags = a.flags & -4097 | 2;
        I = false;
        xg = a;
      }
    }
  }
  function Fg(a) {
    for (a = a.return; null !== a && 5 !== a.tag && 3 !== a.tag && 13 !== a.tag; ) a = a.return;
    xg = a;
  }
  function Gg(a) {
    if (a !== xg) return false;
    if (!I) return Fg(a), I = true, false;
    var b;
    (b = 3 !== a.tag) && !(b = 5 !== a.tag) && (b = a.type, b = "head" !== b && "body" !== b && !Ef(a.type, a.memoizedProps));
    if (b && (b = yg)) {
      if (Dg(a)) throw Hg(), Error(p(418));
      for (; b; ) Ag(a, b), b = Lf(b.nextSibling);
    }
    Fg(a);
    if (13 === a.tag) {
      a = a.memoizedState;
      a = null !== a ? a.dehydrated : null;
      if (!a) throw Error(p(317));
      a: {
        a = a.nextSibling;
        for (b = 0; a; ) {
          if (8 === a.nodeType) {
            var c = a.data;
            if ("/$" === c) {
              if (0 === b) {
                yg = Lf(a.nextSibling);
                break a;
              }
              b--;
            } else "$" !== c && "$!" !== c && "$?" !== c || b++;
          }
          a = a.nextSibling;
        }
        yg = null;
      }
    } else yg = xg ? Lf(a.stateNode.nextSibling) : null;
    return true;
  }
  function Hg() {
    for (var a = yg; a; ) a = Lf(a.nextSibling);
  }
  function Ig() {
    yg = xg = null;
    I = false;
  }
  function Jg(a) {
    null === zg ? zg = [a] : zg.push(a);
  }
  var Kg = ua.ReactCurrentBatchConfig;
  function Lg(a, b, c) {
    a = c.ref;
    if (null !== a && "function" !== typeof a && "object" !== typeof a) {
      if (c._owner) {
        c = c._owner;
        if (c) {
          if (1 !== c.tag) throw Error(p(309));
          var d = c.stateNode;
        }
        if (!d) throw Error(p(147, a));
        var e = d, f = "" + a;
        if (null !== b && null !== b.ref && "function" === typeof b.ref && b.ref._stringRef === f) return b.ref;
        b = function(a2) {
          var b2 = e.refs;
          null === a2 ? delete b2[f] : b2[f] = a2;
        };
        b._stringRef = f;
        return b;
      }
      if ("string" !== typeof a) throw Error(p(284));
      if (!c._owner) throw Error(p(290, a));
    }
    return a;
  }
  function Mg(a, b) {
    a = Object.prototype.toString.call(b);
    throw Error(p(31, "[object Object]" === a ? "object with keys {" + Object.keys(b).join(", ") + "}" : a));
  }
  function Ng(a) {
    var b = a._init;
    return b(a._payload);
  }
  function Og(a) {
    function b(b2, c2) {
      if (a) {
        var d2 = b2.deletions;
        null === d2 ? (b2.deletions = [c2], b2.flags |= 16) : d2.push(c2);
      }
    }
    function c(c2, d2) {
      if (!a) return null;
      for (; null !== d2; ) b(c2, d2), d2 = d2.sibling;
      return null;
    }
    function d(a2, b2) {
      for (a2 = /* @__PURE__ */ new Map(); null !== b2; ) null !== b2.key ? a2.set(b2.key, b2) : a2.set(b2.index, b2), b2 = b2.sibling;
      return a2;
    }
    function e(a2, b2) {
      a2 = Pg(a2, b2);
      a2.index = 0;
      a2.sibling = null;
      return a2;
    }
    function f(b2, c2, d2) {
      b2.index = d2;
      if (!a) return b2.flags |= 1048576, c2;
      d2 = b2.alternate;
      if (null !== d2) return d2 = d2.index, d2 < c2 ? (b2.flags |= 2, c2) : d2;
      b2.flags |= 2;
      return c2;
    }
    function g(b2) {
      a && null === b2.alternate && (b2.flags |= 2);
      return b2;
    }
    function h(a2, b2, c2, d2) {
      if (null === b2 || 6 !== b2.tag) return b2 = Qg(c2, a2.mode, d2), b2.return = a2, b2;
      b2 = e(b2, c2);
      b2.return = a2;
      return b2;
    }
    function k(a2, b2, c2, d2) {
      var f2 = c2.type;
      if (f2 === ya) return m(a2, b2, c2.props.children, d2, c2.key);
      if (null !== b2 && (b2.elementType === f2 || "object" === typeof f2 && null !== f2 && f2.$$typeof === Ha && Ng(f2) === b2.type)) return d2 = e(b2, c2.props), d2.ref = Lg(a2, b2, c2), d2.return = a2, d2;
      d2 = Rg(c2.type, c2.key, c2.props, null, a2.mode, d2);
      d2.ref = Lg(a2, b2, c2);
      d2.return = a2;
      return d2;
    }
    function l(a2, b2, c2, d2) {
      if (null === b2 || 4 !== b2.tag || b2.stateNode.containerInfo !== c2.containerInfo || b2.stateNode.implementation !== c2.implementation) return b2 = Sg(c2, a2.mode, d2), b2.return = a2, b2;
      b2 = e(b2, c2.children || []);
      b2.return = a2;
      return b2;
    }
    function m(a2, b2, c2, d2, f2) {
      if (null === b2 || 7 !== b2.tag) return b2 = Tg(c2, a2.mode, d2, f2), b2.return = a2, b2;
      b2 = e(b2, c2);
      b2.return = a2;
      return b2;
    }
    function q(a2, b2, c2) {
      if ("string" === typeof b2 && "" !== b2 || "number" === typeof b2) return b2 = Qg("" + b2, a2.mode, c2), b2.return = a2, b2;
      if ("object" === typeof b2 && null !== b2) {
        switch (b2.$$typeof) {
          case va:
            return c2 = Rg(b2.type, b2.key, b2.props, null, a2.mode, c2), c2.ref = Lg(a2, null, b2), c2.return = a2, c2;
          case wa:
            return b2 = Sg(b2, a2.mode, c2), b2.return = a2, b2;
          case Ha:
            var d2 = b2._init;
            return q(a2, d2(b2._payload), c2);
        }
        if (eb(b2) || Ka(b2)) return b2 = Tg(b2, a2.mode, c2, null), b2.return = a2, b2;
        Mg(a2, b2);
      }
      return null;
    }
    function r(a2, b2, c2, d2) {
      var e2 = null !== b2 ? b2.key : null;
      if ("string" === typeof c2 && "" !== c2 || "number" === typeof c2) return null !== e2 ? null : h(a2, b2, "" + c2, d2);
      if ("object" === typeof c2 && null !== c2) {
        switch (c2.$$typeof) {
          case va:
            return c2.key === e2 ? k(a2, b2, c2, d2) : null;
          case wa:
            return c2.key === e2 ? l(a2, b2, c2, d2) : null;
          case Ha:
            return e2 = c2._init, r(
              a2,
              b2,
              e2(c2._payload),
              d2
            );
        }
        if (eb(c2) || Ka(c2)) return null !== e2 ? null : m(a2, b2, c2, d2, null);
        Mg(a2, c2);
      }
      return null;
    }
    function y(a2, b2, c2, d2, e2) {
      if ("string" === typeof d2 && "" !== d2 || "number" === typeof d2) return a2 = a2.get(c2) || null, h(b2, a2, "" + d2, e2);
      if ("object" === typeof d2 && null !== d2) {
        switch (d2.$$typeof) {
          case va:
            return a2 = a2.get(null === d2.key ? c2 : d2.key) || null, k(b2, a2, d2, e2);
          case wa:
            return a2 = a2.get(null === d2.key ? c2 : d2.key) || null, l(b2, a2, d2, e2);
          case Ha:
            var f2 = d2._init;
            return y(a2, b2, c2, f2(d2._payload), e2);
        }
        if (eb(d2) || Ka(d2)) return a2 = a2.get(c2) || null, m(b2, a2, d2, e2, null);
        Mg(b2, d2);
      }
      return null;
    }
    function n(e2, g2, h2, k2) {
      for (var l2 = null, m2 = null, u = g2, w = g2 = 0, x = null; null !== u && w < h2.length; w++) {
        u.index > w ? (x = u, u = null) : x = u.sibling;
        var n2 = r(e2, u, h2[w], k2);
        if (null === n2) {
          null === u && (u = x);
          break;
        }
        a && u && null === n2.alternate && b(e2, u);
        g2 = f(n2, g2, w);
        null === m2 ? l2 = n2 : m2.sibling = n2;
        m2 = n2;
        u = x;
      }
      if (w === h2.length) return c(e2, u), I && tg(e2, w), l2;
      if (null === u) {
        for (; w < h2.length; w++) u = q(e2, h2[w], k2), null !== u && (g2 = f(u, g2, w), null === m2 ? l2 = u : m2.sibling = u, m2 = u);
        I && tg(e2, w);
        return l2;
      }
      for (u = d(e2, u); w < h2.length; w++) x = y(u, e2, w, h2[w], k2), null !== x && (a && null !== x.alternate && u.delete(null === x.key ? w : x.key), g2 = f(x, g2, w), null === m2 ? l2 = x : m2.sibling = x, m2 = x);
      a && u.forEach(function(a2) {
        return b(e2, a2);
      });
      I && tg(e2, w);
      return l2;
    }
    function t(e2, g2, h2, k2) {
      var l2 = Ka(h2);
      if ("function" !== typeof l2) throw Error(p(150));
      h2 = l2.call(h2);
      if (null == h2) throw Error(p(151));
      for (var u = l2 = null, m2 = g2, w = g2 = 0, x = null, n2 = h2.next(); null !== m2 && !n2.done; w++, n2 = h2.next()) {
        m2.index > w ? (x = m2, m2 = null) : x = m2.sibling;
        var t2 = r(e2, m2, n2.value, k2);
        if (null === t2) {
          null === m2 && (m2 = x);
          break;
        }
        a && m2 && null === t2.alternate && b(e2, m2);
        g2 = f(t2, g2, w);
        null === u ? l2 = t2 : u.sibling = t2;
        u = t2;
        m2 = x;
      }
      if (n2.done) return c(
        e2,
        m2
      ), I && tg(e2, w), l2;
      if (null === m2) {
        for (; !n2.done; w++, n2 = h2.next()) n2 = q(e2, n2.value, k2), null !== n2 && (g2 = f(n2, g2, w), null === u ? l2 = n2 : u.sibling = n2, u = n2);
        I && tg(e2, w);
        return l2;
      }
      for (m2 = d(e2, m2); !n2.done; w++, n2 = h2.next()) n2 = y(m2, e2, w, n2.value, k2), null !== n2 && (a && null !== n2.alternate && m2.delete(null === n2.key ? w : n2.key), g2 = f(n2, g2, w), null === u ? l2 = n2 : u.sibling = n2, u = n2);
      a && m2.forEach(function(a2) {
        return b(e2, a2);
      });
      I && tg(e2, w);
      return l2;
    }
    function J(a2, d2, f2, h2) {
      "object" === typeof f2 && null !== f2 && f2.type === ya && null === f2.key && (f2 = f2.props.children);
      if ("object" === typeof f2 && null !== f2) {
        switch (f2.$$typeof) {
          case va:
            a: {
              for (var k2 = f2.key, l2 = d2; null !== l2; ) {
                if (l2.key === k2) {
                  k2 = f2.type;
                  if (k2 === ya) {
                    if (7 === l2.tag) {
                      c(a2, l2.sibling);
                      d2 = e(l2, f2.props.children);
                      d2.return = a2;
                      a2 = d2;
                      break a;
                    }
                  } else if (l2.elementType === k2 || "object" === typeof k2 && null !== k2 && k2.$$typeof === Ha && Ng(k2) === l2.type) {
                    c(a2, l2.sibling);
                    d2 = e(l2, f2.props);
                    d2.ref = Lg(a2, l2, f2);
                    d2.return = a2;
                    a2 = d2;
                    break a;
                  }
                  c(a2, l2);
                  break;
                } else b(a2, l2);
                l2 = l2.sibling;
              }
              f2.type === ya ? (d2 = Tg(f2.props.children, a2.mode, h2, f2.key), d2.return = a2, a2 = d2) : (h2 = Rg(f2.type, f2.key, f2.props, null, a2.mode, h2), h2.ref = Lg(a2, d2, f2), h2.return = a2, a2 = h2);
            }
            return g(a2);
          case wa:
            a: {
              for (l2 = f2.key; null !== d2; ) {
                if (d2.key === l2) if (4 === d2.tag && d2.stateNode.containerInfo === f2.containerInfo && d2.stateNode.implementation === f2.implementation) {
                  c(a2, d2.sibling);
                  d2 = e(d2, f2.children || []);
                  d2.return = a2;
                  a2 = d2;
                  break a;
                } else {
                  c(a2, d2);
                  break;
                }
                else b(a2, d2);
                d2 = d2.sibling;
              }
              d2 = Sg(f2, a2.mode, h2);
              d2.return = a2;
              a2 = d2;
            }
            return g(a2);
          case Ha:
            return l2 = f2._init, J(a2, d2, l2(f2._payload), h2);
        }
        if (eb(f2)) return n(a2, d2, f2, h2);
        if (Ka(f2)) return t(a2, d2, f2, h2);
        Mg(a2, f2);
      }
      return "string" === typeof f2 && "" !== f2 || "number" === typeof f2 ? (f2 = "" + f2, null !== d2 && 6 === d2.tag ? (c(a2, d2.sibling), d2 = e(d2, f2), d2.return = a2, a2 = d2) : (c(a2, d2), d2 = Qg(f2, a2.mode, h2), d2.return = a2, a2 = d2), g(a2)) : c(a2, d2);
    }
    return J;
  }
  var Ug = Og(true), Vg = Og(false), Wg = Uf(null), Xg = null, Yg = null, Zg = null;
  function $g() {
    Zg = Yg = Xg = null;
  }
  function ah(a) {
    var b = Wg.current;
    E(Wg);
    a._currentValue = b;
  }
  function bh(a, b, c) {
    for (; null !== a; ) {
      var d = a.alternate;
      (a.childLanes & b) !== b ? (a.childLanes |= b, null !== d && (d.childLanes |= b)) : null !== d && (d.childLanes & b) !== b && (d.childLanes |= b);
      if (a === c) break;
      a = a.return;
    }
  }
  function ch(a, b) {
    Xg = a;
    Zg = Yg = null;
    a = a.dependencies;
    null !== a && null !== a.firstContext && (0 !== (a.lanes & b) && (dh = true), a.firstContext = null);
  }
  function eh(a) {
    var b = a._currentValue;
    if (Zg !== a) if (a = { context: a, memoizedValue: b, next: null }, null === Yg) {
      if (null === Xg) throw Error(p(308));
      Yg = a;
      Xg.dependencies = { lanes: 0, firstContext: a };
    } else Yg = Yg.next = a;
    return b;
  }
  var fh = null;
  function gh(a) {
    null === fh ? fh = [a] : fh.push(a);
  }
  function hh(a, b, c, d) {
    var e = b.interleaved;
    null === e ? (c.next = c, gh(b)) : (c.next = e.next, e.next = c);
    b.interleaved = c;
    return ih(a, d);
  }
  function ih(a, b) {
    a.lanes |= b;
    var c = a.alternate;
    null !== c && (c.lanes |= b);
    c = a;
    for (a = a.return; null !== a; ) a.childLanes |= b, c = a.alternate, null !== c && (c.childLanes |= b), c = a, a = a.return;
    return 3 === c.tag ? c.stateNode : null;
  }
  var jh = false;
  function kh(a) {
    a.updateQueue = { baseState: a.memoizedState, firstBaseUpdate: null, lastBaseUpdate: null, shared: { pending: null, interleaved: null, lanes: 0 }, effects: null };
  }
  function lh(a, b) {
    a = a.updateQueue;
    b.updateQueue === a && (b.updateQueue = { baseState: a.baseState, firstBaseUpdate: a.firstBaseUpdate, lastBaseUpdate: a.lastBaseUpdate, shared: a.shared, effects: a.effects });
  }
  function mh(a, b) {
    return { eventTime: a, lane: b, tag: 0, payload: null, callback: null, next: null };
  }
  function nh(a, b, c) {
    var d = a.updateQueue;
    if (null === d) return null;
    d = d.shared;
    if (0 !== (K & 2)) {
      var e = d.pending;
      null === e ? b.next = b : (b.next = e.next, e.next = b);
      d.pending = b;
      return ih(a, c);
    }
    e = d.interleaved;
    null === e ? (b.next = b, gh(d)) : (b.next = e.next, e.next = b);
    d.interleaved = b;
    return ih(a, c);
  }
  function oh(a, b, c) {
    b = b.updateQueue;
    if (null !== b && (b = b.shared, 0 !== (c & 4194240))) {
      var d = b.lanes;
      d &= a.pendingLanes;
      c |= d;
      b.lanes = c;
      Cc(a, c);
    }
  }
  function ph(a, b) {
    var c = a.updateQueue, d = a.alternate;
    if (null !== d && (d = d.updateQueue, c === d)) {
      var e = null, f = null;
      c = c.firstBaseUpdate;
      if (null !== c) {
        do {
          var g = { eventTime: c.eventTime, lane: c.lane, tag: c.tag, payload: c.payload, callback: c.callback, next: null };
          null === f ? e = f = g : f = f.next = g;
          c = c.next;
        } while (null !== c);
        null === f ? e = f = b : f = f.next = b;
      } else e = f = b;
      c = { baseState: d.baseState, firstBaseUpdate: e, lastBaseUpdate: f, shared: d.shared, effects: d.effects };
      a.updateQueue = c;
      return;
    }
    a = c.lastBaseUpdate;
    null === a ? c.firstBaseUpdate = b : a.next = b;
    c.lastBaseUpdate = b;
  }
  function qh(a, b, c, d) {
    var e = a.updateQueue;
    jh = false;
    var f = e.firstBaseUpdate, g = e.lastBaseUpdate, h = e.shared.pending;
    if (null !== h) {
      e.shared.pending = null;
      var k = h, l = k.next;
      k.next = null;
      null === g ? f = l : g.next = l;
      g = k;
      var m = a.alternate;
      null !== m && (m = m.updateQueue, h = m.lastBaseUpdate, h !== g && (null === h ? m.firstBaseUpdate = l : h.next = l, m.lastBaseUpdate = k));
    }
    if (null !== f) {
      var q = e.baseState;
      g = 0;
      m = l = k = null;
      h = f;
      do {
        var r = h.lane, y = h.eventTime;
        if ((d & r) === r) {
          null !== m && (m = m.next = {
            eventTime: y,
            lane: 0,
            tag: h.tag,
            payload: h.payload,
            callback: h.callback,
            next: null
          });
          a: {
            var n = a, t = h;
            r = b;
            y = c;
            switch (t.tag) {
              case 1:
                n = t.payload;
                if ("function" === typeof n) {
                  q = n.call(y, q, r);
                  break a;
                }
                q = n;
                break a;
              case 3:
                n.flags = n.flags & -65537 | 128;
              case 0:
                n = t.payload;
                r = "function" === typeof n ? n.call(y, q, r) : n;
                if (null === r || void 0 === r) break a;
                q = A({}, q, r);
                break a;
              case 2:
                jh = true;
            }
          }
          null !== h.callback && 0 !== h.lane && (a.flags |= 64, r = e.effects, null === r ? e.effects = [h] : r.push(h));
        } else y = { eventTime: y, lane: r, tag: h.tag, payload: h.payload, callback: h.callback, next: null }, null === m ? (l = m = y, k = q) : m = m.next = y, g |= r;
        h = h.next;
        if (null === h) if (h = e.shared.pending, null === h) break;
        else r = h, h = r.next, r.next = null, e.lastBaseUpdate = r, e.shared.pending = null;
      } while (1);
      null === m && (k = q);
      e.baseState = k;
      e.firstBaseUpdate = l;
      e.lastBaseUpdate = m;
      b = e.shared.interleaved;
      if (null !== b) {
        e = b;
        do
          g |= e.lane, e = e.next;
        while (e !== b);
      } else null === f && (e.shared.lanes = 0);
      rh |= g;
      a.lanes = g;
      a.memoizedState = q;
    }
  }
  function sh(a, b, c) {
    a = b.effects;
    b.effects = null;
    if (null !== a) for (b = 0; b < a.length; b++) {
      var d = a[b], e = d.callback;
      if (null !== e) {
        d.callback = null;
        d = c;
        if ("function" !== typeof e) throw Error(p(191, e));
        e.call(d);
      }
    }
  }
  var th = {}, uh = Uf(th), vh = Uf(th), wh = Uf(th);
  function xh(a) {
    if (a === th) throw Error(p(174));
    return a;
  }
  function yh(a, b) {
    G(wh, b);
    G(vh, a);
    G(uh, th);
    a = b.nodeType;
    switch (a) {
      case 9:
      case 11:
        b = (b = b.documentElement) ? b.namespaceURI : lb(null, "");
        break;
      default:
        a = 8 === a ? b.parentNode : b, b = a.namespaceURI || null, a = a.tagName, b = lb(b, a);
    }
    E(uh);
    G(uh, b);
  }
  function zh() {
    E(uh);
    E(vh);
    E(wh);
  }
  function Ah(a) {
    xh(wh.current);
    var b = xh(uh.current);
    var c = lb(b, a.type);
    b !== c && (G(vh, a), G(uh, c));
  }
  function Bh(a) {
    vh.current === a && (E(uh), E(vh));
  }
  var L = Uf(0);
  function Ch(a) {
    for (var b = a; null !== b; ) {
      if (13 === b.tag) {
        var c = b.memoizedState;
        if (null !== c && (c = c.dehydrated, null === c || "$?" === c.data || "$!" === c.data)) return b;
      } else if (19 === b.tag && void 0 !== b.memoizedProps.revealOrder) {
        if (0 !== (b.flags & 128)) return b;
      } else if (null !== b.child) {
        b.child.return = b;
        b = b.child;
        continue;
      }
      if (b === a) break;
      for (; null === b.sibling; ) {
        if (null === b.return || b.return === a) return null;
        b = b.return;
      }
      b.sibling.return = b.return;
      b = b.sibling;
    }
    return null;
  }
  var Dh = [];
  function Eh() {
    for (var a = 0; a < Dh.length; a++) Dh[a]._workInProgressVersionPrimary = null;
    Dh.length = 0;
  }
  var Fh = ua.ReactCurrentDispatcher, Gh = ua.ReactCurrentBatchConfig, Hh = 0, M = null, N = null, O = null, Ih = false, Jh = false, Kh = 0, Lh = 0;
  function P() {
    throw Error(p(321));
  }
  function Mh(a, b) {
    if (null === b) return false;
    for (var c = 0; c < b.length && c < a.length; c++) if (!He(a[c], b[c])) return false;
    return true;
  }
  function Nh(a, b, c, d, e, f) {
    Hh = f;
    M = b;
    b.memoizedState = null;
    b.updateQueue = null;
    b.lanes = 0;
    Fh.current = null === a || null === a.memoizedState ? Oh : Ph;
    a = c(d, e);
    if (Jh) {
      f = 0;
      do {
        Jh = false;
        Kh = 0;
        if (25 <= f) throw Error(p(301));
        f += 1;
        O = N = null;
        b.updateQueue = null;
        Fh.current = Qh;
        a = c(d, e);
      } while (Jh);
    }
    Fh.current = Rh;
    b = null !== N && null !== N.next;
    Hh = 0;
    O = N = M = null;
    Ih = false;
    if (b) throw Error(p(300));
    return a;
  }
  function Sh() {
    var a = 0 !== Kh;
    Kh = 0;
    return a;
  }
  function Th() {
    var a = { memoizedState: null, baseState: null, baseQueue: null, queue: null, next: null };
    null === O ? M.memoizedState = O = a : O = O.next = a;
    return O;
  }
  function Uh() {
    if (null === N) {
      var a = M.alternate;
      a = null !== a ? a.memoizedState : null;
    } else a = N.next;
    var b = null === O ? M.memoizedState : O.next;
    if (null !== b) O = b, N = a;
    else {
      if (null === a) throw Error(p(310));
      N = a;
      a = { memoizedState: N.memoizedState, baseState: N.baseState, baseQueue: N.baseQueue, queue: N.queue, next: null };
      null === O ? M.memoizedState = O = a : O = O.next = a;
    }
    return O;
  }
  function Vh(a, b) {
    return "function" === typeof b ? b(a) : b;
  }
  function Wh(a) {
    var b = Uh(), c = b.queue;
    if (null === c) throw Error(p(311));
    c.lastRenderedReducer = a;
    var d = N, e = d.baseQueue, f = c.pending;
    if (null !== f) {
      if (null !== e) {
        var g = e.next;
        e.next = f.next;
        f.next = g;
      }
      d.baseQueue = e = f;
      c.pending = null;
    }
    if (null !== e) {
      f = e.next;
      d = d.baseState;
      var h = g = null, k = null, l = f;
      do {
        var m = l.lane;
        if ((Hh & m) === m) null !== k && (k = k.next = { lane: 0, action: l.action, hasEagerState: l.hasEagerState, eagerState: l.eagerState, next: null }), d = l.hasEagerState ? l.eagerState : a(d, l.action);
        else {
          var q = {
            lane: m,
            action: l.action,
            hasEagerState: l.hasEagerState,
            eagerState: l.eagerState,
            next: null
          };
          null === k ? (h = k = q, g = d) : k = k.next = q;
          M.lanes |= m;
          rh |= m;
        }
        l = l.next;
      } while (null !== l && l !== f);
      null === k ? g = d : k.next = h;
      He(d, b.memoizedState) || (dh = true);
      b.memoizedState = d;
      b.baseState = g;
      b.baseQueue = k;
      c.lastRenderedState = d;
    }
    a = c.interleaved;
    if (null !== a) {
      e = a;
      do
        f = e.lane, M.lanes |= f, rh |= f, e = e.next;
      while (e !== a);
    } else null === e && (c.lanes = 0);
    return [b.memoizedState, c.dispatch];
  }
  function Xh(a) {
    var b = Uh(), c = b.queue;
    if (null === c) throw Error(p(311));
    c.lastRenderedReducer = a;
    var d = c.dispatch, e = c.pending, f = b.memoizedState;
    if (null !== e) {
      c.pending = null;
      var g = e = e.next;
      do
        f = a(f, g.action), g = g.next;
      while (g !== e);
      He(f, b.memoizedState) || (dh = true);
      b.memoizedState = f;
      null === b.baseQueue && (b.baseState = f);
      c.lastRenderedState = f;
    }
    return [f, d];
  }
  function Yh() {
  }
  function Zh(a, b) {
    var c = M, d = Uh(), e = b(), f = !He(d.memoizedState, e);
    f && (d.memoizedState = e, dh = true);
    d = d.queue;
    $h(ai.bind(null, c, d, a), [a]);
    if (d.getSnapshot !== b || f || null !== O && O.memoizedState.tag & 1) {
      c.flags |= 2048;
      bi(9, ci.bind(null, c, d, e, b), void 0, null);
      if (null === Q) throw Error(p(349));
      0 !== (Hh & 30) || di(c, b, e);
    }
    return e;
  }
  function di(a, b, c) {
    a.flags |= 16384;
    a = { getSnapshot: b, value: c };
    b = M.updateQueue;
    null === b ? (b = { lastEffect: null, stores: null }, M.updateQueue = b, b.stores = [a]) : (c = b.stores, null === c ? b.stores = [a] : c.push(a));
  }
  function ci(a, b, c, d) {
    b.value = c;
    b.getSnapshot = d;
    ei(b) && fi(a);
  }
  function ai(a, b, c) {
    return c(function() {
      ei(b) && fi(a);
    });
  }
  function ei(a) {
    var b = a.getSnapshot;
    a = a.value;
    try {
      var c = b();
      return !He(a, c);
    } catch (d) {
      return true;
    }
  }
  function fi(a) {
    var b = ih(a, 1);
    null !== b && gi(b, a, 1, -1);
  }
  function hi(a) {
    var b = Th();
    "function" === typeof a && (a = a());
    b.memoizedState = b.baseState = a;
    a = { pending: null, interleaved: null, lanes: 0, dispatch: null, lastRenderedReducer: Vh, lastRenderedState: a };
    b.queue = a;
    a = a.dispatch = ii.bind(null, M, a);
    return [b.memoizedState, a];
  }
  function bi(a, b, c, d) {
    a = { tag: a, create: b, destroy: c, deps: d, next: null };
    b = M.updateQueue;
    null === b ? (b = { lastEffect: null, stores: null }, M.updateQueue = b, b.lastEffect = a.next = a) : (c = b.lastEffect, null === c ? b.lastEffect = a.next = a : (d = c.next, c.next = a, a.next = d, b.lastEffect = a));
    return a;
  }
  function ji() {
    return Uh().memoizedState;
  }
  function ki(a, b, c, d) {
    var e = Th();
    M.flags |= a;
    e.memoizedState = bi(1 | b, c, void 0, void 0 === d ? null : d);
  }
  function li(a, b, c, d) {
    var e = Uh();
    d = void 0 === d ? null : d;
    var f = void 0;
    if (null !== N) {
      var g = N.memoizedState;
      f = g.destroy;
      if (null !== d && Mh(d, g.deps)) {
        e.memoizedState = bi(b, c, f, d);
        return;
      }
    }
    M.flags |= a;
    e.memoizedState = bi(1 | b, c, f, d);
  }
  function mi(a, b) {
    return ki(8390656, 8, a, b);
  }
  function $h(a, b) {
    return li(2048, 8, a, b);
  }
  function ni(a, b) {
    return li(4, 2, a, b);
  }
  function oi(a, b) {
    return li(4, 4, a, b);
  }
  function pi(a, b) {
    if ("function" === typeof b) return a = a(), b(a), function() {
      b(null);
    };
    if (null !== b && void 0 !== b) return a = a(), b.current = a, function() {
      b.current = null;
    };
  }
  function qi(a, b, c) {
    c = null !== c && void 0 !== c ? c.concat([a]) : null;
    return li(4, 4, pi.bind(null, b, a), c);
  }
  function ri() {
  }
  function si(a, b) {
    var c = Uh();
    b = void 0 === b ? null : b;
    var d = c.memoizedState;
    if (null !== d && null !== b && Mh(b, d[1])) return d[0];
    c.memoizedState = [a, b];
    return a;
  }
  function ti(a, b) {
    var c = Uh();
    b = void 0 === b ? null : b;
    var d = c.memoizedState;
    if (null !== d && null !== b && Mh(b, d[1])) return d[0];
    a = a();
    c.memoizedState = [a, b];
    return a;
  }
  function ui(a, b, c) {
    if (0 === (Hh & 21)) return a.baseState && (a.baseState = false, dh = true), a.memoizedState = c;
    He(c, b) || (c = yc(), M.lanes |= c, rh |= c, a.baseState = true);
    return b;
  }
  function vi(a, b) {
    var c = C;
    C = 0 !== c && 4 > c ? c : 4;
    a(true);
    var d = Gh.transition;
    Gh.transition = {};
    try {
      a(false), b();
    } finally {
      C = c, Gh.transition = d;
    }
  }
  function wi() {
    return Uh().memoizedState;
  }
  function xi(a, b, c) {
    var d = yi(a);
    c = { lane: d, action: c, hasEagerState: false, eagerState: null, next: null };
    if (zi(a)) Ai(b, c);
    else if (c = hh(a, b, c, d), null !== c) {
      var e = R();
      gi(c, a, d, e);
      Bi(c, b, d);
    }
  }
  function ii(a, b, c) {
    var d = yi(a), e = { lane: d, action: c, hasEagerState: false, eagerState: null, next: null };
    if (zi(a)) Ai(b, e);
    else {
      var f = a.alternate;
      if (0 === a.lanes && (null === f || 0 === f.lanes) && (f = b.lastRenderedReducer, null !== f)) try {
        var g = b.lastRenderedState, h = f(g, c);
        e.hasEagerState = true;
        e.eagerState = h;
        if (He(h, g)) {
          var k = b.interleaved;
          null === k ? (e.next = e, gh(b)) : (e.next = k.next, k.next = e);
          b.interleaved = e;
          return;
        }
      } catch (l) {
      } finally {
      }
      c = hh(a, b, e, d);
      null !== c && (e = R(), gi(c, a, d, e), Bi(c, b, d));
    }
  }
  function zi(a) {
    var b = a.alternate;
    return a === M || null !== b && b === M;
  }
  function Ai(a, b) {
    Jh = Ih = true;
    var c = a.pending;
    null === c ? b.next = b : (b.next = c.next, c.next = b);
    a.pending = b;
  }
  function Bi(a, b, c) {
    if (0 !== (c & 4194240)) {
      var d = b.lanes;
      d &= a.pendingLanes;
      c |= d;
      b.lanes = c;
      Cc(a, c);
    }
  }
  var Rh = { readContext: eh, useCallback: P, useContext: P, useEffect: P, useImperativeHandle: P, useInsertionEffect: P, useLayoutEffect: P, useMemo: P, useReducer: P, useRef: P, useState: P, useDebugValue: P, useDeferredValue: P, useTransition: P, useMutableSource: P, useSyncExternalStore: P, useId: P, unstable_isNewReconciler: false }, Oh = { readContext: eh, useCallback: function(a, b) {
    Th().memoizedState = [a, void 0 === b ? null : b];
    return a;
  }, useContext: eh, useEffect: mi, useImperativeHandle: function(a, b, c) {
    c = null !== c && void 0 !== c ? c.concat([a]) : null;
    return ki(
      4194308,
      4,
      pi.bind(null, b, a),
      c
    );
  }, useLayoutEffect: function(a, b) {
    return ki(4194308, 4, a, b);
  }, useInsertionEffect: function(a, b) {
    return ki(4, 2, a, b);
  }, useMemo: function(a, b) {
    var c = Th();
    b = void 0 === b ? null : b;
    a = a();
    c.memoizedState = [a, b];
    return a;
  }, useReducer: function(a, b, c) {
    var d = Th();
    b = void 0 !== c ? c(b) : b;
    d.memoizedState = d.baseState = b;
    a = { pending: null, interleaved: null, lanes: 0, dispatch: null, lastRenderedReducer: a, lastRenderedState: b };
    d.queue = a;
    a = a.dispatch = xi.bind(null, M, a);
    return [d.memoizedState, a];
  }, useRef: function(a) {
    var b = Th();
    a = { current: a };
    return b.memoizedState = a;
  }, useState: hi, useDebugValue: ri, useDeferredValue: function(a) {
    return Th().memoizedState = a;
  }, useTransition: function() {
    var a = hi(false), b = a[0];
    a = vi.bind(null, a[1]);
    Th().memoizedState = a;
    return [b, a];
  }, useMutableSource: function() {
  }, useSyncExternalStore: function(a, b, c) {
    var d = M, e = Th();
    if (I) {
      if (void 0 === c) throw Error(p(407));
      c = c();
    } else {
      c = b();
      if (null === Q) throw Error(p(349));
      0 !== (Hh & 30) || di(d, b, c);
    }
    e.memoizedState = c;
    var f = { value: c, getSnapshot: b };
    e.queue = f;
    mi(ai.bind(
      null,
      d,
      f,
      a
    ), [a]);
    d.flags |= 2048;
    bi(9, ci.bind(null, d, f, c, b), void 0, null);
    return c;
  }, useId: function() {
    var a = Th(), b = Q.identifierPrefix;
    if (I) {
      var c = sg;
      var d = rg;
      c = (d & ~(1 << 32 - oc(d) - 1)).toString(32) + c;
      b = ":" + b + "R" + c;
      c = Kh++;
      0 < c && (b += "H" + c.toString(32));
      b += ":";
    } else c = Lh++, b = ":" + b + "r" + c.toString(32) + ":";
    return a.memoizedState = b;
  }, unstable_isNewReconciler: false }, Ph = {
    readContext: eh,
    useCallback: si,
    useContext: eh,
    useEffect: $h,
    useImperativeHandle: qi,
    useInsertionEffect: ni,
    useLayoutEffect: oi,
    useMemo: ti,
    useReducer: Wh,
    useRef: ji,
    useState: function() {
      return Wh(Vh);
    },
    useDebugValue: ri,
    useDeferredValue: function(a) {
      var b = Uh();
      return ui(b, N.memoizedState, a);
    },
    useTransition: function() {
      var a = Wh(Vh)[0], b = Uh().memoizedState;
      return [a, b];
    },
    useMutableSource: Yh,
    useSyncExternalStore: Zh,
    useId: wi,
    unstable_isNewReconciler: false
  }, Qh = { readContext: eh, useCallback: si, useContext: eh, useEffect: $h, useImperativeHandle: qi, useInsertionEffect: ni, useLayoutEffect: oi, useMemo: ti, useReducer: Xh, useRef: ji, useState: function() {
    return Xh(Vh);
  }, useDebugValue: ri, useDeferredValue: function(a) {
    var b = Uh();
    return null === N ? b.memoizedState = a : ui(b, N.memoizedState, a);
  }, useTransition: function() {
    var a = Xh(Vh)[0], b = Uh().memoizedState;
    return [a, b];
  }, useMutableSource: Yh, useSyncExternalStore: Zh, useId: wi, unstable_isNewReconciler: false };
  function Ci(a, b) {
    if (a && a.defaultProps) {
      b = A({}, b);
      a = a.defaultProps;
      for (var c in a) void 0 === b[c] && (b[c] = a[c]);
      return b;
    }
    return b;
  }
  function Di(a, b, c, d) {
    b = a.memoizedState;
    c = c(d, b);
    c = null === c || void 0 === c ? b : A({}, b, c);
    a.memoizedState = c;
    0 === a.lanes && (a.updateQueue.baseState = c);
  }
  var Ei = { isMounted: function(a) {
    return (a = a._reactInternals) ? Vb(a) === a : false;
  }, enqueueSetState: function(a, b, c) {
    a = a._reactInternals;
    var d = R(), e = yi(a), f = mh(d, e);
    f.payload = b;
    void 0 !== c && null !== c && (f.callback = c);
    b = nh(a, f, e);
    null !== b && (gi(b, a, e, d), oh(b, a, e));
  }, enqueueReplaceState: function(a, b, c) {
    a = a._reactInternals;
    var d = R(), e = yi(a), f = mh(d, e);
    f.tag = 1;
    f.payload = b;
    void 0 !== c && null !== c && (f.callback = c);
    b = nh(a, f, e);
    null !== b && (gi(b, a, e, d), oh(b, a, e));
  }, enqueueForceUpdate: function(a, b) {
    a = a._reactInternals;
    var c = R(), d = yi(a), e = mh(c, d);
    e.tag = 2;
    void 0 !== b && null !== b && (e.callback = b);
    b = nh(a, e, d);
    null !== b && (gi(b, a, d, c), oh(b, a, d));
  } };
  function Fi(a, b, c, d, e, f, g) {
    a = a.stateNode;
    return "function" === typeof a.shouldComponentUpdate ? a.shouldComponentUpdate(d, f, g) : b.prototype && b.prototype.isPureReactComponent ? !Ie(c, d) || !Ie(e, f) : true;
  }
  function Gi(a, b, c) {
    var d = false, e = Vf;
    var f = b.contextType;
    "object" === typeof f && null !== f ? f = eh(f) : (e = Zf(b) ? Xf : H.current, d = b.contextTypes, f = (d = null !== d && void 0 !== d) ? Yf(a, e) : Vf);
    b = new b(c, f);
    a.memoizedState = null !== b.state && void 0 !== b.state ? b.state : null;
    b.updater = Ei;
    a.stateNode = b;
    b._reactInternals = a;
    d && (a = a.stateNode, a.__reactInternalMemoizedUnmaskedChildContext = e, a.__reactInternalMemoizedMaskedChildContext = f);
    return b;
  }
  function Hi(a, b, c, d) {
    a = b.state;
    "function" === typeof b.componentWillReceiveProps && b.componentWillReceiveProps(c, d);
    "function" === typeof b.UNSAFE_componentWillReceiveProps && b.UNSAFE_componentWillReceiveProps(c, d);
    b.state !== a && Ei.enqueueReplaceState(b, b.state, null);
  }
  function Ii(a, b, c, d) {
    var e = a.stateNode;
    e.props = c;
    e.state = a.memoizedState;
    e.refs = {};
    kh(a);
    var f = b.contextType;
    "object" === typeof f && null !== f ? e.context = eh(f) : (f = Zf(b) ? Xf : H.current, e.context = Yf(a, f));
    e.state = a.memoizedState;
    f = b.getDerivedStateFromProps;
    "function" === typeof f && (Di(a, b, f, c), e.state = a.memoizedState);
    "function" === typeof b.getDerivedStateFromProps || "function" === typeof e.getSnapshotBeforeUpdate || "function" !== typeof e.UNSAFE_componentWillMount && "function" !== typeof e.componentWillMount || (b = e.state, "function" === typeof e.componentWillMount && e.componentWillMount(), "function" === typeof e.UNSAFE_componentWillMount && e.UNSAFE_componentWillMount(), b !== e.state && Ei.enqueueReplaceState(e, e.state, null), qh(a, c, e, d), e.state = a.memoizedState);
    "function" === typeof e.componentDidMount && (a.flags |= 4194308);
  }
  function Ji(a, b) {
    try {
      var c = "", d = b;
      do
        c += Pa(d), d = d.return;
      while (d);
      var e = c;
    } catch (f) {
      e = "\nError generating stack: " + f.message + "\n" + f.stack;
    }
    return { value: a, source: b, stack: e, digest: null };
  }
  function Ki(a, b, c) {
    return { value: a, source: null, stack: null != c ? c : null, digest: null != b ? b : null };
  }
  function Li(a, b) {
    try {
      console.error(b.value);
    } catch (c) {
      setTimeout(function() {
        throw c;
      });
    }
  }
  var Mi = "function" === typeof WeakMap ? WeakMap : Map;
  function Ni(a, b, c) {
    c = mh(-1, c);
    c.tag = 3;
    c.payload = { element: null };
    var d = b.value;
    c.callback = function() {
      Oi || (Oi = true, Pi = d);
      Li(a, b);
    };
    return c;
  }
  function Qi(a, b, c) {
    c = mh(-1, c);
    c.tag = 3;
    var d = a.type.getDerivedStateFromError;
    if ("function" === typeof d) {
      var e = b.value;
      c.payload = function() {
        return d(e);
      };
      c.callback = function() {
        Li(a, b);
      };
    }
    var f = a.stateNode;
    null !== f && "function" === typeof f.componentDidCatch && (c.callback = function() {
      Li(a, b);
      "function" !== typeof d && (null === Ri ? Ri = /* @__PURE__ */ new Set([this]) : Ri.add(this));
      var c2 = b.stack;
      this.componentDidCatch(b.value, { componentStack: null !== c2 ? c2 : "" });
    });
    return c;
  }
  function Si(a, b, c) {
    var d = a.pingCache;
    if (null === d) {
      d = a.pingCache = new Mi();
      var e = /* @__PURE__ */ new Set();
      d.set(b, e);
    } else e = d.get(b), void 0 === e && (e = /* @__PURE__ */ new Set(), d.set(b, e));
    e.has(c) || (e.add(c), a = Ti.bind(null, a, b, c), b.then(a, a));
  }
  function Ui(a) {
    do {
      var b;
      if (b = 13 === a.tag) b = a.memoizedState, b = null !== b ? null !== b.dehydrated ? true : false : true;
      if (b) return a;
      a = a.return;
    } while (null !== a);
    return null;
  }
  function Vi(a, b, c, d, e) {
    if (0 === (a.mode & 1)) return a === b ? a.flags |= 65536 : (a.flags |= 128, c.flags |= 131072, c.flags &= -52805, 1 === c.tag && (null === c.alternate ? c.tag = 17 : (b = mh(-1, 1), b.tag = 2, nh(c, b, 1))), c.lanes |= 1), a;
    a.flags |= 65536;
    a.lanes = e;
    return a;
  }
  var Wi = ua.ReactCurrentOwner, dh = false;
  function Xi(a, b, c, d) {
    b.child = null === a ? Vg(b, null, c, d) : Ug(b, a.child, c, d);
  }
  function Yi(a, b, c, d, e) {
    c = c.render;
    var f = b.ref;
    ch(b, e);
    d = Nh(a, b, c, d, f, e);
    c = Sh();
    if (null !== a && !dh) return b.updateQueue = a.updateQueue, b.flags &= -2053, a.lanes &= ~e, Zi(a, b, e);
    I && c && vg(b);
    b.flags |= 1;
    Xi(a, b, d, e);
    return b.child;
  }
  function $i(a, b, c, d, e) {
    if (null === a) {
      var f = c.type;
      if ("function" === typeof f && !aj(f) && void 0 === f.defaultProps && null === c.compare && void 0 === c.defaultProps) return b.tag = 15, b.type = f, bj(a, b, f, d, e);
      a = Rg(c.type, null, d, b, b.mode, e);
      a.ref = b.ref;
      a.return = b;
      return b.child = a;
    }
    f = a.child;
    if (0 === (a.lanes & e)) {
      var g = f.memoizedProps;
      c = c.compare;
      c = null !== c ? c : Ie;
      if (c(g, d) && a.ref === b.ref) return Zi(a, b, e);
    }
    b.flags |= 1;
    a = Pg(f, d);
    a.ref = b.ref;
    a.return = b;
    return b.child = a;
  }
  function bj(a, b, c, d, e) {
    if (null !== a) {
      var f = a.memoizedProps;
      if (Ie(f, d) && a.ref === b.ref) if (dh = false, b.pendingProps = d = f, 0 !== (a.lanes & e)) 0 !== (a.flags & 131072) && (dh = true);
      else return b.lanes = a.lanes, Zi(a, b, e);
    }
    return cj(a, b, c, d, e);
  }
  function dj(a, b, c) {
    var d = b.pendingProps, e = d.children, f = null !== a ? a.memoizedState : null;
    if ("hidden" === d.mode) if (0 === (b.mode & 1)) b.memoizedState = { baseLanes: 0, cachePool: null, transitions: null }, G(ej, fj), fj |= c;
    else {
      if (0 === (c & 1073741824)) return a = null !== f ? f.baseLanes | c : c, b.lanes = b.childLanes = 1073741824, b.memoizedState = { baseLanes: a, cachePool: null, transitions: null }, b.updateQueue = null, G(ej, fj), fj |= a, null;
      b.memoizedState = { baseLanes: 0, cachePool: null, transitions: null };
      d = null !== f ? f.baseLanes : c;
      G(ej, fj);
      fj |= d;
    }
    else null !== f ? (d = f.baseLanes | c, b.memoizedState = null) : d = c, G(ej, fj), fj |= d;
    Xi(a, b, e, c);
    return b.child;
  }
  function gj(a, b) {
    var c = b.ref;
    if (null === a && null !== c || null !== a && a.ref !== c) b.flags |= 512, b.flags |= 2097152;
  }
  function cj(a, b, c, d, e) {
    var f = Zf(c) ? Xf : H.current;
    f = Yf(b, f);
    ch(b, e);
    c = Nh(a, b, c, d, f, e);
    d = Sh();
    if (null !== a && !dh) return b.updateQueue = a.updateQueue, b.flags &= -2053, a.lanes &= ~e, Zi(a, b, e);
    I && d && vg(b);
    b.flags |= 1;
    Xi(a, b, c, e);
    return b.child;
  }
  function hj(a, b, c, d, e) {
    if (Zf(c)) {
      var f = true;
      cg(b);
    } else f = false;
    ch(b, e);
    if (null === b.stateNode) ij(a, b), Gi(b, c, d), Ii(b, c, d, e), d = true;
    else if (null === a) {
      var g = b.stateNode, h = b.memoizedProps;
      g.props = h;
      var k = g.context, l = c.contextType;
      "object" === typeof l && null !== l ? l = eh(l) : (l = Zf(c) ? Xf : H.current, l = Yf(b, l));
      var m = c.getDerivedStateFromProps, q = "function" === typeof m || "function" === typeof g.getSnapshotBeforeUpdate;
      q || "function" !== typeof g.UNSAFE_componentWillReceiveProps && "function" !== typeof g.componentWillReceiveProps || (h !== d || k !== l) && Hi(b, g, d, l);
      jh = false;
      var r = b.memoizedState;
      g.state = r;
      qh(b, d, g, e);
      k = b.memoizedState;
      h !== d || r !== k || Wf.current || jh ? ("function" === typeof m && (Di(b, c, m, d), k = b.memoizedState), (h = jh || Fi(b, c, h, d, r, k, l)) ? (q || "function" !== typeof g.UNSAFE_componentWillMount && "function" !== typeof g.componentWillMount || ("function" === typeof g.componentWillMount && g.componentWillMount(), "function" === typeof g.UNSAFE_componentWillMount && g.UNSAFE_componentWillMount()), "function" === typeof g.componentDidMount && (b.flags |= 4194308)) : ("function" === typeof g.componentDidMount && (b.flags |= 4194308), b.memoizedProps = d, b.memoizedState = k), g.props = d, g.state = k, g.context = l, d = h) : ("function" === typeof g.componentDidMount && (b.flags |= 4194308), d = false);
    } else {
      g = b.stateNode;
      lh(a, b);
      h = b.memoizedProps;
      l = b.type === b.elementType ? h : Ci(b.type, h);
      g.props = l;
      q = b.pendingProps;
      r = g.context;
      k = c.contextType;
      "object" === typeof k && null !== k ? k = eh(k) : (k = Zf(c) ? Xf : H.current, k = Yf(b, k));
      var y = c.getDerivedStateFromProps;
      (m = "function" === typeof y || "function" === typeof g.getSnapshotBeforeUpdate) || "function" !== typeof g.UNSAFE_componentWillReceiveProps && "function" !== typeof g.componentWillReceiveProps || (h !== q || r !== k) && Hi(b, g, d, k);
      jh = false;
      r = b.memoizedState;
      g.state = r;
      qh(b, d, g, e);
      var n = b.memoizedState;
      h !== q || r !== n || Wf.current || jh ? ("function" === typeof y && (Di(b, c, y, d), n = b.memoizedState), (l = jh || Fi(b, c, l, d, r, n, k) || false) ? (m || "function" !== typeof g.UNSAFE_componentWillUpdate && "function" !== typeof g.componentWillUpdate || ("function" === typeof g.componentWillUpdate && g.componentWillUpdate(d, n, k), "function" === typeof g.UNSAFE_componentWillUpdate && g.UNSAFE_componentWillUpdate(d, n, k)), "function" === typeof g.componentDidUpdate && (b.flags |= 4), "function" === typeof g.getSnapshotBeforeUpdate && (b.flags |= 1024)) : ("function" !== typeof g.componentDidUpdate || h === a.memoizedProps && r === a.memoizedState || (b.flags |= 4), "function" !== typeof g.getSnapshotBeforeUpdate || h === a.memoizedProps && r === a.memoizedState || (b.flags |= 1024), b.memoizedProps = d, b.memoizedState = n), g.props = d, g.state = n, g.context = k, d = l) : ("function" !== typeof g.componentDidUpdate || h === a.memoizedProps && r === a.memoizedState || (b.flags |= 4), "function" !== typeof g.getSnapshotBeforeUpdate || h === a.memoizedProps && r === a.memoizedState || (b.flags |= 1024), d = false);
    }
    return jj(a, b, c, d, f, e);
  }
  function jj(a, b, c, d, e, f) {
    gj(a, b);
    var g = 0 !== (b.flags & 128);
    if (!d && !g) return e && dg(b, c, false), Zi(a, b, f);
    d = b.stateNode;
    Wi.current = b;
    var h = g && "function" !== typeof c.getDerivedStateFromError ? null : d.render();
    b.flags |= 1;
    null !== a && g ? (b.child = Ug(b, a.child, null, f), b.child = Ug(b, null, h, f)) : Xi(a, b, h, f);
    b.memoizedState = d.state;
    e && dg(b, c, true);
    return b.child;
  }
  function kj(a) {
    var b = a.stateNode;
    b.pendingContext ? ag(a, b.pendingContext, b.pendingContext !== b.context) : b.context && ag(a, b.context, false);
    yh(a, b.containerInfo);
  }
  function lj(a, b, c, d, e) {
    Ig();
    Jg(e);
    b.flags |= 256;
    Xi(a, b, c, d);
    return b.child;
  }
  var mj = { dehydrated: null, treeContext: null, retryLane: 0 };
  function nj(a) {
    return { baseLanes: a, cachePool: null, transitions: null };
  }
  function oj(a, b, c) {
    var d = b.pendingProps, e = L.current, f = false, g = 0 !== (b.flags & 128), h;
    (h = g) || (h = null !== a && null === a.memoizedState ? false : 0 !== (e & 2));
    if (h) f = true, b.flags &= -129;
    else if (null === a || null !== a.memoizedState) e |= 1;
    G(L, e & 1);
    if (null === a) {
      Eg(b);
      a = b.memoizedState;
      if (null !== a && (a = a.dehydrated, null !== a)) return 0 === (b.mode & 1) ? b.lanes = 1 : "$!" === a.data ? b.lanes = 8 : b.lanes = 1073741824, null;
      g = d.children;
      a = d.fallback;
      return f ? (d = b.mode, f = b.child, g = { mode: "hidden", children: g }, 0 === (d & 1) && null !== f ? (f.childLanes = 0, f.pendingProps = g) : f = pj(g, d, 0, null), a = Tg(a, d, c, null), f.return = b, a.return = b, f.sibling = a, b.child = f, b.child.memoizedState = nj(c), b.memoizedState = mj, a) : qj(b, g);
    }
    e = a.memoizedState;
    if (null !== e && (h = e.dehydrated, null !== h)) return rj(a, b, g, d, h, e, c);
    if (f) {
      f = d.fallback;
      g = b.mode;
      e = a.child;
      h = e.sibling;
      var k = { mode: "hidden", children: d.children };
      0 === (g & 1) && b.child !== e ? (d = b.child, d.childLanes = 0, d.pendingProps = k, b.deletions = null) : (d = Pg(e, k), d.subtreeFlags = e.subtreeFlags & 14680064);
      null !== h ? f = Pg(h, f) : (f = Tg(f, g, c, null), f.flags |= 2);
      f.return = b;
      d.return = b;
      d.sibling = f;
      b.child = d;
      d = f;
      f = b.child;
      g = a.child.memoizedState;
      g = null === g ? nj(c) : { baseLanes: g.baseLanes | c, cachePool: null, transitions: g.transitions };
      f.memoizedState = g;
      f.childLanes = a.childLanes & ~c;
      b.memoizedState = mj;
      return d;
    }
    f = a.child;
    a = f.sibling;
    d = Pg(f, { mode: "visible", children: d.children });
    0 === (b.mode & 1) && (d.lanes = c);
    d.return = b;
    d.sibling = null;
    null !== a && (c = b.deletions, null === c ? (b.deletions = [a], b.flags |= 16) : c.push(a));
    b.child = d;
    b.memoizedState = null;
    return d;
  }
  function qj(a, b) {
    b = pj({ mode: "visible", children: b }, a.mode, 0, null);
    b.return = a;
    return a.child = b;
  }
  function sj(a, b, c, d) {
    null !== d && Jg(d);
    Ug(b, a.child, null, c);
    a = qj(b, b.pendingProps.children);
    a.flags |= 2;
    b.memoizedState = null;
    return a;
  }
  function rj(a, b, c, d, e, f, g) {
    if (c) {
      if (b.flags & 256) return b.flags &= -257, d = Ki(Error(p(422))), sj(a, b, g, d);
      if (null !== b.memoizedState) return b.child = a.child, b.flags |= 128, null;
      f = d.fallback;
      e = b.mode;
      d = pj({ mode: "visible", children: d.children }, e, 0, null);
      f = Tg(f, e, g, null);
      f.flags |= 2;
      d.return = b;
      f.return = b;
      d.sibling = f;
      b.child = d;
      0 !== (b.mode & 1) && Ug(b, a.child, null, g);
      b.child.memoizedState = nj(g);
      b.memoizedState = mj;
      return f;
    }
    if (0 === (b.mode & 1)) return sj(a, b, g, null);
    if ("$!" === e.data) {
      d = e.nextSibling && e.nextSibling.dataset;
      if (d) var h = d.dgst;
      d = h;
      f = Error(p(419));
      d = Ki(f, d, void 0);
      return sj(a, b, g, d);
    }
    h = 0 !== (g & a.childLanes);
    if (dh || h) {
      d = Q;
      if (null !== d) {
        switch (g & -g) {
          case 4:
            e = 2;
            break;
          case 16:
            e = 8;
            break;
          case 64:
          case 128:
          case 256:
          case 512:
          case 1024:
          case 2048:
          case 4096:
          case 8192:
          case 16384:
          case 32768:
          case 65536:
          case 131072:
          case 262144:
          case 524288:
          case 1048576:
          case 2097152:
          case 4194304:
          case 8388608:
          case 16777216:
          case 33554432:
          case 67108864:
            e = 32;
            break;
          case 536870912:
            e = 268435456;
            break;
          default:
            e = 0;
        }
        e = 0 !== (e & (d.suspendedLanes | g)) ? 0 : e;
        0 !== e && e !== f.retryLane && (f.retryLane = e, ih(a, e), gi(d, a, e, -1));
      }
      tj();
      d = Ki(Error(p(421)));
      return sj(a, b, g, d);
    }
    if ("$?" === e.data) return b.flags |= 128, b.child = a.child, b = uj.bind(null, a), e._reactRetry = b, null;
    a = f.treeContext;
    yg = Lf(e.nextSibling);
    xg = b;
    I = true;
    zg = null;
    null !== a && (og[pg++] = rg, og[pg++] = sg, og[pg++] = qg, rg = a.id, sg = a.overflow, qg = b);
    b = qj(b, d.children);
    b.flags |= 4096;
    return b;
  }
  function vj(a, b, c) {
    a.lanes |= b;
    var d = a.alternate;
    null !== d && (d.lanes |= b);
    bh(a.return, b, c);
  }
  function wj(a, b, c, d, e) {
    var f = a.memoizedState;
    null === f ? a.memoizedState = { isBackwards: b, rendering: null, renderingStartTime: 0, last: d, tail: c, tailMode: e } : (f.isBackwards = b, f.rendering = null, f.renderingStartTime = 0, f.last = d, f.tail = c, f.tailMode = e);
  }
  function xj(a, b, c) {
    var d = b.pendingProps, e = d.revealOrder, f = d.tail;
    Xi(a, b, d.children, c);
    d = L.current;
    if (0 !== (d & 2)) d = d & 1 | 2, b.flags |= 128;
    else {
      if (null !== a && 0 !== (a.flags & 128)) a: for (a = b.child; null !== a; ) {
        if (13 === a.tag) null !== a.memoizedState && vj(a, c, b);
        else if (19 === a.tag) vj(a, c, b);
        else if (null !== a.child) {
          a.child.return = a;
          a = a.child;
          continue;
        }
        if (a === b) break a;
        for (; null === a.sibling; ) {
          if (null === a.return || a.return === b) break a;
          a = a.return;
        }
        a.sibling.return = a.return;
        a = a.sibling;
      }
      d &= 1;
    }
    G(L, d);
    if (0 === (b.mode & 1)) b.memoizedState = null;
    else switch (e) {
      case "forwards":
        c = b.child;
        for (e = null; null !== c; ) a = c.alternate, null !== a && null === Ch(a) && (e = c), c = c.sibling;
        c = e;
        null === c ? (e = b.child, b.child = null) : (e = c.sibling, c.sibling = null);
        wj(b, false, e, c, f);
        break;
      case "backwards":
        c = null;
        e = b.child;
        for (b.child = null; null !== e; ) {
          a = e.alternate;
          if (null !== a && null === Ch(a)) {
            b.child = e;
            break;
          }
          a = e.sibling;
          e.sibling = c;
          c = e;
          e = a;
        }
        wj(b, true, c, null, f);
        break;
      case "together":
        wj(b, false, null, null, void 0);
        break;
      default:
        b.memoizedState = null;
    }
    return b.child;
  }
  function ij(a, b) {
    0 === (b.mode & 1) && null !== a && (a.alternate = null, b.alternate = null, b.flags |= 2);
  }
  function Zi(a, b, c) {
    null !== a && (b.dependencies = a.dependencies);
    rh |= b.lanes;
    if (0 === (c & b.childLanes)) return null;
    if (null !== a && b.child !== a.child) throw Error(p(153));
    if (null !== b.child) {
      a = b.child;
      c = Pg(a, a.pendingProps);
      b.child = c;
      for (c.return = b; null !== a.sibling; ) a = a.sibling, c = c.sibling = Pg(a, a.pendingProps), c.return = b;
      c.sibling = null;
    }
    return b.child;
  }
  function yj(a, b, c) {
    switch (b.tag) {
      case 3:
        kj(b);
        Ig();
        break;
      case 5:
        Ah(b);
        break;
      case 1:
        Zf(b.type) && cg(b);
        break;
      case 4:
        yh(b, b.stateNode.containerInfo);
        break;
      case 10:
        var d = b.type._context, e = b.memoizedProps.value;
        G(Wg, d._currentValue);
        d._currentValue = e;
        break;
      case 13:
        d = b.memoizedState;
        if (null !== d) {
          if (null !== d.dehydrated) return G(L, L.current & 1), b.flags |= 128, null;
          if (0 !== (c & b.child.childLanes)) return oj(a, b, c);
          G(L, L.current & 1);
          a = Zi(a, b, c);
          return null !== a ? a.sibling : null;
        }
        G(L, L.current & 1);
        break;
      case 19:
        d = 0 !== (c & b.childLanes);
        if (0 !== (a.flags & 128)) {
          if (d) return xj(a, b, c);
          b.flags |= 128;
        }
        e = b.memoizedState;
        null !== e && (e.rendering = null, e.tail = null, e.lastEffect = null);
        G(L, L.current);
        if (d) break;
        else return null;
      case 22:
      case 23:
        return b.lanes = 0, dj(a, b, c);
    }
    return Zi(a, b, c);
  }
  var zj, Aj, Bj, Cj;
  zj = function(a, b) {
    for (var c = b.child; null !== c; ) {
      if (5 === c.tag || 6 === c.tag) a.appendChild(c.stateNode);
      else if (4 !== c.tag && null !== c.child) {
        c.child.return = c;
        c = c.child;
        continue;
      }
      if (c === b) break;
      for (; null === c.sibling; ) {
        if (null === c.return || c.return === b) return;
        c = c.return;
      }
      c.sibling.return = c.return;
      c = c.sibling;
    }
  };
  Aj = function() {
  };
  Bj = function(a, b, c, d) {
    var e = a.memoizedProps;
    if (e !== d) {
      a = b.stateNode;
      xh(uh.current);
      var f = null;
      switch (c) {
        case "input":
          e = Ya(a, e);
          d = Ya(a, d);
          f = [];
          break;
        case "select":
          e = A({}, e, { value: void 0 });
          d = A({}, d, { value: void 0 });
          f = [];
          break;
        case "textarea":
          e = gb(a, e);
          d = gb(a, d);
          f = [];
          break;
        default:
          "function" !== typeof e.onClick && "function" === typeof d.onClick && (a.onclick = Bf);
      }
      ub(c, d);
      var g;
      c = null;
      for (l in e) if (!d.hasOwnProperty(l) && e.hasOwnProperty(l) && null != e[l]) if ("style" === l) {
        var h = e[l];
        for (g in h) h.hasOwnProperty(g) && (c || (c = {}), c[g] = "");
      } else "dangerouslySetInnerHTML" !== l && "children" !== l && "suppressContentEditableWarning" !== l && "suppressHydrationWarning" !== l && "autoFocus" !== l && (ea.hasOwnProperty(l) ? f || (f = []) : (f = f || []).push(l, null));
      for (l in d) {
        var k = d[l];
        h = null != e ? e[l] : void 0;
        if (d.hasOwnProperty(l) && k !== h && (null != k || null != h)) if ("style" === l) if (h) {
          for (g in h) !h.hasOwnProperty(g) || k && k.hasOwnProperty(g) || (c || (c = {}), c[g] = "");
          for (g in k) k.hasOwnProperty(g) && h[g] !== k[g] && (c || (c = {}), c[g] = k[g]);
        } else c || (f || (f = []), f.push(
          l,
          c
        )), c = k;
        else "dangerouslySetInnerHTML" === l ? (k = k ? k.__html : void 0, h = h ? h.__html : void 0, null != k && h !== k && (f = f || []).push(l, k)) : "children" === l ? "string" !== typeof k && "number" !== typeof k || (f = f || []).push(l, "" + k) : "suppressContentEditableWarning" !== l && "suppressHydrationWarning" !== l && (ea.hasOwnProperty(l) ? (null != k && "onScroll" === l && D("scroll", a), f || h === k || (f = [])) : (f = f || []).push(l, k));
      }
      c && (f = f || []).push("style", c);
      var l = f;
      if (b.updateQueue = l) b.flags |= 4;
    }
  };
  Cj = function(a, b, c, d) {
    c !== d && (b.flags |= 4);
  };
  function Dj(a, b) {
    if (!I) switch (a.tailMode) {
      case "hidden":
        b = a.tail;
        for (var c = null; null !== b; ) null !== b.alternate && (c = b), b = b.sibling;
        null === c ? a.tail = null : c.sibling = null;
        break;
      case "collapsed":
        c = a.tail;
        for (var d = null; null !== c; ) null !== c.alternate && (d = c), c = c.sibling;
        null === d ? b || null === a.tail ? a.tail = null : a.tail.sibling = null : d.sibling = null;
    }
  }
  function S(a) {
    var b = null !== a.alternate && a.alternate.child === a.child, c = 0, d = 0;
    if (b) for (var e = a.child; null !== e; ) c |= e.lanes | e.childLanes, d |= e.subtreeFlags & 14680064, d |= e.flags & 14680064, e.return = a, e = e.sibling;
    else for (e = a.child; null !== e; ) c |= e.lanes | e.childLanes, d |= e.subtreeFlags, d |= e.flags, e.return = a, e = e.sibling;
    a.subtreeFlags |= d;
    a.childLanes = c;
    return b;
  }
  function Ej(a, b, c) {
    var d = b.pendingProps;
    wg(b);
    switch (b.tag) {
      case 2:
      case 16:
      case 15:
      case 0:
      case 11:
      case 7:
      case 8:
      case 12:
      case 9:
      case 14:
        return S(b), null;
      case 1:
        return Zf(b.type) && $f(), S(b), null;
      case 3:
        d = b.stateNode;
        zh();
        E(Wf);
        E(H);
        Eh();
        d.pendingContext && (d.context = d.pendingContext, d.pendingContext = null);
        if (null === a || null === a.child) Gg(b) ? b.flags |= 4 : null === a || a.memoizedState.isDehydrated && 0 === (b.flags & 256) || (b.flags |= 1024, null !== zg && (Fj(zg), zg = null));
        Aj(a, b);
        S(b);
        return null;
      case 5:
        Bh(b);
        var e = xh(wh.current);
        c = b.type;
        if (null !== a && null != b.stateNode) Bj(a, b, c, d, e), a.ref !== b.ref && (b.flags |= 512, b.flags |= 2097152);
        else {
          if (!d) {
            if (null === b.stateNode) throw Error(p(166));
            S(b);
            return null;
          }
          a = xh(uh.current);
          if (Gg(b)) {
            d = b.stateNode;
            c = b.type;
            var f = b.memoizedProps;
            d[Of] = b;
            d[Pf] = f;
            a = 0 !== (b.mode & 1);
            switch (c) {
              case "dialog":
                D("cancel", d);
                D("close", d);
                break;
              case "iframe":
              case "object":
              case "embed":
                D("load", d);
                break;
              case "video":
              case "audio":
                for (e = 0; e < lf.length; e++) D(lf[e], d);
                break;
              case "source":
                D("error", d);
                break;
              case "img":
              case "image":
              case "link":
                D(
                  "error",
                  d
                );
                D("load", d);
                break;
              case "details":
                D("toggle", d);
                break;
              case "input":
                Za(d, f);
                D("invalid", d);
                break;
              case "select":
                d._wrapperState = { wasMultiple: !!f.multiple };
                D("invalid", d);
                break;
              case "textarea":
                hb(d, f), D("invalid", d);
            }
            ub(c, f);
            e = null;
            for (var g in f) if (f.hasOwnProperty(g)) {
              var h = f[g];
              "children" === g ? "string" === typeof h ? d.textContent !== h && (true !== f.suppressHydrationWarning && Af(d.textContent, h, a), e = ["children", h]) : "number" === typeof h && d.textContent !== "" + h && (true !== f.suppressHydrationWarning && Af(
                d.textContent,
                h,
                a
              ), e = ["children", "" + h]) : ea.hasOwnProperty(g) && null != h && "onScroll" === g && D("scroll", d);
            }
            switch (c) {
              case "input":
                Va(d);
                db(d, f, true);
                break;
              case "textarea":
                Va(d);
                jb(d);
                break;
              case "select":
              case "option":
                break;
              default:
                "function" === typeof f.onClick && (d.onclick = Bf);
            }
            d = e;
            b.updateQueue = d;
            null !== d && (b.flags |= 4);
          } else {
            g = 9 === e.nodeType ? e : e.ownerDocument;
            "http://www.w3.org/1999/xhtml" === a && (a = kb(c));
            "http://www.w3.org/1999/xhtml" === a ? "script" === c ? (a = g.createElement("div"), a.innerHTML = "<script><\/script>", a = a.removeChild(a.firstChild)) : "string" === typeof d.is ? a = g.createElement(c, { is: d.is }) : (a = g.createElement(c), "select" === c && (g = a, d.multiple ? g.multiple = true : d.size && (g.size = d.size))) : a = g.createElementNS(a, c);
            a[Of] = b;
            a[Pf] = d;
            zj(a, b, false, false);
            b.stateNode = a;
            a: {
              g = vb(c, d);
              switch (c) {
                case "dialog":
                  D("cancel", a);
                  D("close", a);
                  e = d;
                  break;
                case "iframe":
                case "object":
                case "embed":
                  D("load", a);
                  e = d;
                  break;
                case "video":
                case "audio":
                  for (e = 0; e < lf.length; e++) D(lf[e], a);
                  e = d;
                  break;
                case "source":
                  D("error", a);
                  e = d;
                  break;
                case "img":
                case "image":
                case "link":
                  D(
                    "error",
                    a
                  );
                  D("load", a);
                  e = d;
                  break;
                case "details":
                  D("toggle", a);
                  e = d;
                  break;
                case "input":
                  Za(a, d);
                  e = Ya(a, d);
                  D("invalid", a);
                  break;
                case "option":
                  e = d;
                  break;
                case "select":
                  a._wrapperState = { wasMultiple: !!d.multiple };
                  e = A({}, d, { value: void 0 });
                  D("invalid", a);
                  break;
                case "textarea":
                  hb(a, d);
                  e = gb(a, d);
                  D("invalid", a);
                  break;
                default:
                  e = d;
              }
              ub(c, e);
              h = e;
              for (f in h) if (h.hasOwnProperty(f)) {
                var k = h[f];
                "style" === f ? sb(a, k) : "dangerouslySetInnerHTML" === f ? (k = k ? k.__html : void 0, null != k && nb(a, k)) : "children" === f ? "string" === typeof k ? ("textarea" !== c || "" !== k) && ob(a, k) : "number" === typeof k && ob(a, "" + k) : "suppressContentEditableWarning" !== f && "suppressHydrationWarning" !== f && "autoFocus" !== f && (ea.hasOwnProperty(f) ? null != k && "onScroll" === f && D("scroll", a) : null != k && ta(a, f, k, g));
              }
              switch (c) {
                case "input":
                  Va(a);
                  db(a, d, false);
                  break;
                case "textarea":
                  Va(a);
                  jb(a);
                  break;
                case "option":
                  null != d.value && a.setAttribute("value", "" + Sa(d.value));
                  break;
                case "select":
                  a.multiple = !!d.multiple;
                  f = d.value;
                  null != f ? fb(a, !!d.multiple, f, false) : null != d.defaultValue && fb(
                    a,
                    !!d.multiple,
                    d.defaultValue,
                    true
                  );
                  break;
                default:
                  "function" === typeof e.onClick && (a.onclick = Bf);
              }
              switch (c) {
                case "button":
                case "input":
                case "select":
                case "textarea":
                  d = !!d.autoFocus;
                  break a;
                case "img":
                  d = true;
                  break a;
                default:
                  d = false;
              }
            }
            d && (b.flags |= 4);
          }
          null !== b.ref && (b.flags |= 512, b.flags |= 2097152);
        }
        S(b);
        return null;
      case 6:
        if (a && null != b.stateNode) Cj(a, b, a.memoizedProps, d);
        else {
          if ("string" !== typeof d && null === b.stateNode) throw Error(p(166));
          c = xh(wh.current);
          xh(uh.current);
          if (Gg(b)) {
            d = b.stateNode;
            c = b.memoizedProps;
            d[Of] = b;
            if (f = d.nodeValue !== c) {
              if (a = xg, null !== a) switch (a.tag) {
                case 3:
                  Af(d.nodeValue, c, 0 !== (a.mode & 1));
                  break;
                case 5:
                  true !== a.memoizedProps.suppressHydrationWarning && Af(d.nodeValue, c, 0 !== (a.mode & 1));
              }
            }
            f && (b.flags |= 4);
          } else d = (9 === c.nodeType ? c : c.ownerDocument).createTextNode(d), d[Of] = b, b.stateNode = d;
        }
        S(b);
        return null;
      case 13:
        E(L);
        d = b.memoizedState;
        if (null === a || null !== a.memoizedState && null !== a.memoizedState.dehydrated) {
          if (I && null !== yg && 0 !== (b.mode & 1) && 0 === (b.flags & 128)) Hg(), Ig(), b.flags |= 98560, f = false;
          else if (f = Gg(b), null !== d && null !== d.dehydrated) {
            if (null === a) {
              if (!f) throw Error(p(318));
              f = b.memoizedState;
              f = null !== f ? f.dehydrated : null;
              if (!f) throw Error(p(317));
              f[Of] = b;
            } else Ig(), 0 === (b.flags & 128) && (b.memoizedState = null), b.flags |= 4;
            S(b);
            f = false;
          } else null !== zg && (Fj(zg), zg = null), f = true;
          if (!f) return b.flags & 65536 ? b : null;
        }
        if (0 !== (b.flags & 128)) return b.lanes = c, b;
        d = null !== d;
        d !== (null !== a && null !== a.memoizedState) && d && (b.child.flags |= 8192, 0 !== (b.mode & 1) && (null === a || 0 !== (L.current & 1) ? 0 === T && (T = 3) : tj()));
        null !== b.updateQueue && (b.flags |= 4);
        S(b);
        return null;
      case 4:
        return zh(), Aj(a, b), null === a && sf(b.stateNode.containerInfo), S(b), null;
      case 10:
        return ah(b.type._context), S(b), null;
      case 17:
        return Zf(b.type) && $f(), S(b), null;
      case 19:
        E(L);
        f = b.memoizedState;
        if (null === f) return S(b), null;
        d = 0 !== (b.flags & 128);
        g = f.rendering;
        if (null === g) if (d) Dj(f, false);
        else {
          if (0 !== T || null !== a && 0 !== (a.flags & 128)) for (a = b.child; null !== a; ) {
            g = Ch(a);
            if (null !== g) {
              b.flags |= 128;
              Dj(f, false);
              d = g.updateQueue;
              null !== d && (b.updateQueue = d, b.flags |= 4);
              b.subtreeFlags = 0;
              d = c;
              for (c = b.child; null !== c; ) f = c, a = d, f.flags &= 14680066, g = f.alternate, null === g ? (f.childLanes = 0, f.lanes = a, f.child = null, f.subtreeFlags = 0, f.memoizedProps = null, f.memoizedState = null, f.updateQueue = null, f.dependencies = null, f.stateNode = null) : (f.childLanes = g.childLanes, f.lanes = g.lanes, f.child = g.child, f.subtreeFlags = 0, f.deletions = null, f.memoizedProps = g.memoizedProps, f.memoizedState = g.memoizedState, f.updateQueue = g.updateQueue, f.type = g.type, a = g.dependencies, f.dependencies = null === a ? null : { lanes: a.lanes, firstContext: a.firstContext }), c = c.sibling;
              G(L, L.current & 1 | 2);
              return b.child;
            }
            a = a.sibling;
          }
          null !== f.tail && B() > Gj && (b.flags |= 128, d = true, Dj(f, false), b.lanes = 4194304);
        }
        else {
          if (!d) if (a = Ch(g), null !== a) {
            if (b.flags |= 128, d = true, c = a.updateQueue, null !== c && (b.updateQueue = c, b.flags |= 4), Dj(f, true), null === f.tail && "hidden" === f.tailMode && !g.alternate && !I) return S(b), null;
          } else 2 * B() - f.renderingStartTime > Gj && 1073741824 !== c && (b.flags |= 128, d = true, Dj(f, false), b.lanes = 4194304);
          f.isBackwards ? (g.sibling = b.child, b.child = g) : (c = f.last, null !== c ? c.sibling = g : b.child = g, f.last = g);
        }
        if (null !== f.tail) return b = f.tail, f.rendering = b, f.tail = b.sibling, f.renderingStartTime = B(), b.sibling = null, c = L.current, G(L, d ? c & 1 | 2 : c & 1), b;
        S(b);
        return null;
      case 22:
      case 23:
        return Hj(), d = null !== b.memoizedState, null !== a && null !== a.memoizedState !== d && (b.flags |= 8192), d && 0 !== (b.mode & 1) ? 0 !== (fj & 1073741824) && (S(b), b.subtreeFlags & 6 && (b.flags |= 8192)) : S(b), null;
      case 24:
        return null;
      case 25:
        return null;
    }
    throw Error(p(156, b.tag));
  }
  function Ij(a, b) {
    wg(b);
    switch (b.tag) {
      case 1:
        return Zf(b.type) && $f(), a = b.flags, a & 65536 ? (b.flags = a & -65537 | 128, b) : null;
      case 3:
        return zh(), E(Wf), E(H), Eh(), a = b.flags, 0 !== (a & 65536) && 0 === (a & 128) ? (b.flags = a & -65537 | 128, b) : null;
      case 5:
        return Bh(b), null;
      case 13:
        E(L);
        a = b.memoizedState;
        if (null !== a && null !== a.dehydrated) {
          if (null === b.alternate) throw Error(p(340));
          Ig();
        }
        a = b.flags;
        return a & 65536 ? (b.flags = a & -65537 | 128, b) : null;
      case 19:
        return E(L), null;
      case 4:
        return zh(), null;
      case 10:
        return ah(b.type._context), null;
      case 22:
      case 23:
        return Hj(), null;
      case 24:
        return null;
      default:
        return null;
    }
  }
  var Jj = false, U = false, Kj = "function" === typeof WeakSet ? WeakSet : Set, V = null;
  function Lj(a, b) {
    var c = a.ref;
    if (null !== c) if ("function" === typeof c) try {
      c(null);
    } catch (d) {
      W(a, b, d);
    }
    else c.current = null;
  }
  function Mj(a, b, c) {
    try {
      c();
    } catch (d) {
      W(a, b, d);
    }
  }
  var Nj = false;
  function Oj(a, b) {
    Cf = dd;
    a = Me();
    if (Ne(a)) {
      if ("selectionStart" in a) var c = { start: a.selectionStart, end: a.selectionEnd };
      else a: {
        c = (c = a.ownerDocument) && c.defaultView || window;
        var d = c.getSelection && c.getSelection();
        if (d && 0 !== d.rangeCount) {
          c = d.anchorNode;
          var e = d.anchorOffset, f = d.focusNode;
          d = d.focusOffset;
          try {
            c.nodeType, f.nodeType;
          } catch (F) {
            c = null;
            break a;
          }
          var g = 0, h = -1, k = -1, l = 0, m = 0, q = a, r = null;
          b: for (; ; ) {
            for (var y; ; ) {
              q !== c || 0 !== e && 3 !== q.nodeType || (h = g + e);
              q !== f || 0 !== d && 3 !== q.nodeType || (k = g + d);
              3 === q.nodeType && (g += q.nodeValue.length);
              if (null === (y = q.firstChild)) break;
              r = q;
              q = y;
            }
            for (; ; ) {
              if (q === a) break b;
              r === c && ++l === e && (h = g);
              r === f && ++m === d && (k = g);
              if (null !== (y = q.nextSibling)) break;
              q = r;
              r = q.parentNode;
            }
            q = y;
          }
          c = -1 === h || -1 === k ? null : { start: h, end: k };
        } else c = null;
      }
      c = c || { start: 0, end: 0 };
    } else c = null;
    Df = { focusedElem: a, selectionRange: c };
    dd = false;
    for (V = b; null !== V; ) if (b = V, a = b.child, 0 !== (b.subtreeFlags & 1028) && null !== a) a.return = b, V = a;
    else for (; null !== V; ) {
      b = V;
      try {
        var n = b.alternate;
        if (0 !== (b.flags & 1024)) switch (b.tag) {
          case 0:
          case 11:
          case 15:
            break;
          case 1:
            if (null !== n) {
              var t = n.memoizedProps, J = n.memoizedState, x = b.stateNode, w = x.getSnapshotBeforeUpdate(b.elementType === b.type ? t : Ci(b.type, t), J);
              x.__reactInternalSnapshotBeforeUpdate = w;
            }
            break;
          case 3:
            var u = b.stateNode.containerInfo;
            1 === u.nodeType ? u.textContent = "" : 9 === u.nodeType && u.documentElement && u.removeChild(u.documentElement);
            break;
          case 5:
          case 6:
          case 4:
          case 17:
            break;
          default:
            throw Error(p(163));
        }
      } catch (F) {
        W(b, b.return, F);
      }
      a = b.sibling;
      if (null !== a) {
        a.return = b.return;
        V = a;
        break;
      }
      V = b.return;
    }
    n = Nj;
    Nj = false;
    return n;
  }
  function Pj(a, b, c) {
    var d = b.updateQueue;
    d = null !== d ? d.lastEffect : null;
    if (null !== d) {
      var e = d = d.next;
      do {
        if ((e.tag & a) === a) {
          var f = e.destroy;
          e.destroy = void 0;
          void 0 !== f && Mj(b, c, f);
        }
        e = e.next;
      } while (e !== d);
    }
  }
  function Qj(a, b) {
    b = b.updateQueue;
    b = null !== b ? b.lastEffect : null;
    if (null !== b) {
      var c = b = b.next;
      do {
        if ((c.tag & a) === a) {
          var d = c.create;
          c.destroy = d();
        }
        c = c.next;
      } while (c !== b);
    }
  }
  function Rj(a) {
    var b = a.ref;
    if (null !== b) {
      var c = a.stateNode;
      switch (a.tag) {
        case 5:
          a = c;
          break;
        default:
          a = c;
      }
      "function" === typeof b ? b(a) : b.current = a;
    }
  }
  function Sj(a) {
    var b = a.alternate;
    null !== b && (a.alternate = null, Sj(b));
    a.child = null;
    a.deletions = null;
    a.sibling = null;
    5 === a.tag && (b = a.stateNode, null !== b && (delete b[Of], delete b[Pf], delete b[of], delete b[Qf], delete b[Rf]));
    a.stateNode = null;
    a.return = null;
    a.dependencies = null;
    a.memoizedProps = null;
    a.memoizedState = null;
    a.pendingProps = null;
    a.stateNode = null;
    a.updateQueue = null;
  }
  function Tj(a) {
    return 5 === a.tag || 3 === a.tag || 4 === a.tag;
  }
  function Uj(a) {
    a: for (; ; ) {
      for (; null === a.sibling; ) {
        if (null === a.return || Tj(a.return)) return null;
        a = a.return;
      }
      a.sibling.return = a.return;
      for (a = a.sibling; 5 !== a.tag && 6 !== a.tag && 18 !== a.tag; ) {
        if (a.flags & 2) continue a;
        if (null === a.child || 4 === a.tag) continue a;
        else a.child.return = a, a = a.child;
      }
      if (!(a.flags & 2)) return a.stateNode;
    }
  }
  function Vj(a, b, c) {
    var d = a.tag;
    if (5 === d || 6 === d) a = a.stateNode, b ? 8 === c.nodeType ? c.parentNode.insertBefore(a, b) : c.insertBefore(a, b) : (8 === c.nodeType ? (b = c.parentNode, b.insertBefore(a, c)) : (b = c, b.appendChild(a)), c = c._reactRootContainer, null !== c && void 0 !== c || null !== b.onclick || (b.onclick = Bf));
    else if (4 !== d && (a = a.child, null !== a)) for (Vj(a, b, c), a = a.sibling; null !== a; ) Vj(a, b, c), a = a.sibling;
  }
  function Wj(a, b, c) {
    var d = a.tag;
    if (5 === d || 6 === d) a = a.stateNode, b ? c.insertBefore(a, b) : c.appendChild(a);
    else if (4 !== d && (a = a.child, null !== a)) for (Wj(a, b, c), a = a.sibling; null !== a; ) Wj(a, b, c), a = a.sibling;
  }
  var X = null, Xj = false;
  function Yj(a, b, c) {
    for (c = c.child; null !== c; ) Zj(a, b, c), c = c.sibling;
  }
  function Zj(a, b, c) {
    if (lc && "function" === typeof lc.onCommitFiberUnmount) try {
      lc.onCommitFiberUnmount(kc, c);
    } catch (h) {
    }
    switch (c.tag) {
      case 5:
        U || Lj(c, b);
      case 6:
        var d = X, e = Xj;
        X = null;
        Yj(a, b, c);
        X = d;
        Xj = e;
        null !== X && (Xj ? (a = X, c = c.stateNode, 8 === a.nodeType ? a.parentNode.removeChild(c) : a.removeChild(c)) : X.removeChild(c.stateNode));
        break;
      case 18:
        null !== X && (Xj ? (a = X, c = c.stateNode, 8 === a.nodeType ? Kf(a.parentNode, c) : 1 === a.nodeType && Kf(a, c), bd(a)) : Kf(X, c.stateNode));
        break;
      case 4:
        d = X;
        e = Xj;
        X = c.stateNode.containerInfo;
        Xj = true;
        Yj(a, b, c);
        X = d;
        Xj = e;
        break;
      case 0:
      case 11:
      case 14:
      case 15:
        if (!U && (d = c.updateQueue, null !== d && (d = d.lastEffect, null !== d))) {
          e = d = d.next;
          do {
            var f = e, g = f.destroy;
            f = f.tag;
            void 0 !== g && (0 !== (f & 2) ? Mj(c, b, g) : 0 !== (f & 4) && Mj(c, b, g));
            e = e.next;
          } while (e !== d);
        }
        Yj(a, b, c);
        break;
      case 1:
        if (!U && (Lj(c, b), d = c.stateNode, "function" === typeof d.componentWillUnmount)) try {
          d.props = c.memoizedProps, d.state = c.memoizedState, d.componentWillUnmount();
        } catch (h) {
          W(c, b, h);
        }
        Yj(a, b, c);
        break;
      case 21:
        Yj(a, b, c);
        break;
      case 22:
        c.mode & 1 ? (U = (d = U) || null !== c.memoizedState, Yj(a, b, c), U = d) : Yj(a, b, c);
        break;
      default:
        Yj(a, b, c);
    }
  }
  function ak(a) {
    var b = a.updateQueue;
    if (null !== b) {
      a.updateQueue = null;
      var c = a.stateNode;
      null === c && (c = a.stateNode = new Kj());
      b.forEach(function(b2) {
        var d = bk.bind(null, a, b2);
        c.has(b2) || (c.add(b2), b2.then(d, d));
      });
    }
  }
  function ck(a, b) {
    var c = b.deletions;
    if (null !== c) for (var d = 0; d < c.length; d++) {
      var e = c[d];
      try {
        var f = a, g = b, h = g;
        a: for (; null !== h; ) {
          switch (h.tag) {
            case 5:
              X = h.stateNode;
              Xj = false;
              break a;
            case 3:
              X = h.stateNode.containerInfo;
              Xj = true;
              break a;
            case 4:
              X = h.stateNode.containerInfo;
              Xj = true;
              break a;
          }
          h = h.return;
        }
        if (null === X) throw Error(p(160));
        Zj(f, g, e);
        X = null;
        Xj = false;
        var k = e.alternate;
        null !== k && (k.return = null);
        e.return = null;
      } catch (l) {
        W(e, b, l);
      }
    }
    if (b.subtreeFlags & 12854) for (b = b.child; null !== b; ) dk(b, a), b = b.sibling;
  }
  function dk(a, b) {
    var c = a.alternate, d = a.flags;
    switch (a.tag) {
      case 0:
      case 11:
      case 14:
      case 15:
        ck(b, a);
        ek(a);
        if (d & 4) {
          try {
            Pj(3, a, a.return), Qj(3, a);
          } catch (t) {
            W(a, a.return, t);
          }
          try {
            Pj(5, a, a.return);
          } catch (t) {
            W(a, a.return, t);
          }
        }
        break;
      case 1:
        ck(b, a);
        ek(a);
        d & 512 && null !== c && Lj(c, c.return);
        break;
      case 5:
        ck(b, a);
        ek(a);
        d & 512 && null !== c && Lj(c, c.return);
        if (a.flags & 32) {
          var e = a.stateNode;
          try {
            ob(e, "");
          } catch (t) {
            W(a, a.return, t);
          }
        }
        if (d & 4 && (e = a.stateNode, null != e)) {
          var f = a.memoizedProps, g = null !== c ? c.memoizedProps : f, h = a.type, k = a.updateQueue;
          a.updateQueue = null;
          if (null !== k) try {
            "input" === h && "radio" === f.type && null != f.name && ab(e, f);
            vb(h, g);
            var l = vb(h, f);
            for (g = 0; g < k.length; g += 2) {
              var m = k[g], q = k[g + 1];
              "style" === m ? sb(e, q) : "dangerouslySetInnerHTML" === m ? nb(e, q) : "children" === m ? ob(e, q) : ta(e, m, q, l);
            }
            switch (h) {
              case "input":
                bb(e, f);
                break;
              case "textarea":
                ib(e, f);
                break;
              case "select":
                var r = e._wrapperState.wasMultiple;
                e._wrapperState.wasMultiple = !!f.multiple;
                var y = f.value;
                null != y ? fb(e, !!f.multiple, y, false) : r !== !!f.multiple && (null != f.defaultValue ? fb(
                  e,
                  !!f.multiple,
                  f.defaultValue,
                  true
                ) : fb(e, !!f.multiple, f.multiple ? [] : "", false));
            }
            e[Pf] = f;
          } catch (t) {
            W(a, a.return, t);
          }
        }
        break;
      case 6:
        ck(b, a);
        ek(a);
        if (d & 4) {
          if (null === a.stateNode) throw Error(p(162));
          e = a.stateNode;
          f = a.memoizedProps;
          try {
            e.nodeValue = f;
          } catch (t) {
            W(a, a.return, t);
          }
        }
        break;
      case 3:
        ck(b, a);
        ek(a);
        if (d & 4 && null !== c && c.memoizedState.isDehydrated) try {
          bd(b.containerInfo);
        } catch (t) {
          W(a, a.return, t);
        }
        break;
      case 4:
        ck(b, a);
        ek(a);
        break;
      case 13:
        ck(b, a);
        ek(a);
        e = a.child;
        e.flags & 8192 && (f = null !== e.memoizedState, e.stateNode.isHidden = f, !f || null !== e.alternate && null !== e.alternate.memoizedState || (fk = B()));
        d & 4 && ak(a);
        break;
      case 22:
        m = null !== c && null !== c.memoizedState;
        a.mode & 1 ? (U = (l = U) || m, ck(b, a), U = l) : ck(b, a);
        ek(a);
        if (d & 8192) {
          l = null !== a.memoizedState;
          if ((a.stateNode.isHidden = l) && !m && 0 !== (a.mode & 1)) for (V = a, m = a.child; null !== m; ) {
            for (q = V = m; null !== V; ) {
              r = V;
              y = r.child;
              switch (r.tag) {
                case 0:
                case 11:
                case 14:
                case 15:
                  Pj(4, r, r.return);
                  break;
                case 1:
                  Lj(r, r.return);
                  var n = r.stateNode;
                  if ("function" === typeof n.componentWillUnmount) {
                    d = r;
                    c = r.return;
                    try {
                      b = d, n.props = b.memoizedProps, n.state = b.memoizedState, n.componentWillUnmount();
                    } catch (t) {
                      W(d, c, t);
                    }
                  }
                  break;
                case 5:
                  Lj(r, r.return);
                  break;
                case 22:
                  if (null !== r.memoizedState) {
                    gk(q);
                    continue;
                  }
              }
              null !== y ? (y.return = r, V = y) : gk(q);
            }
            m = m.sibling;
          }
          a: for (m = null, q = a; ; ) {
            if (5 === q.tag) {
              if (null === m) {
                m = q;
                try {
                  e = q.stateNode, l ? (f = e.style, "function" === typeof f.setProperty ? f.setProperty("display", "none", "important") : f.display = "none") : (h = q.stateNode, k = q.memoizedProps.style, g = void 0 !== k && null !== k && k.hasOwnProperty("display") ? k.display : null, h.style.display = rb("display", g));
                } catch (t) {
                  W(a, a.return, t);
                }
              }
            } else if (6 === q.tag) {
              if (null === m) try {
                q.stateNode.nodeValue = l ? "" : q.memoizedProps;
              } catch (t) {
                W(a, a.return, t);
              }
            } else if ((22 !== q.tag && 23 !== q.tag || null === q.memoizedState || q === a) && null !== q.child) {
              q.child.return = q;
              q = q.child;
              continue;
            }
            if (q === a) break a;
            for (; null === q.sibling; ) {
              if (null === q.return || q.return === a) break a;
              m === q && (m = null);
              q = q.return;
            }
            m === q && (m = null);
            q.sibling.return = q.return;
            q = q.sibling;
          }
        }
        break;
      case 19:
        ck(b, a);
        ek(a);
        d & 4 && ak(a);
        break;
      case 21:
        break;
      default:
        ck(
          b,
          a
        ), ek(a);
    }
  }
  function ek(a) {
    var b = a.flags;
    if (b & 2) {
      try {
        a: {
          for (var c = a.return; null !== c; ) {
            if (Tj(c)) {
              var d = c;
              break a;
            }
            c = c.return;
          }
          throw Error(p(160));
        }
        switch (d.tag) {
          case 5:
            var e = d.stateNode;
            d.flags & 32 && (ob(e, ""), d.flags &= -33);
            var f = Uj(a);
            Wj(a, f, e);
            break;
          case 3:
          case 4:
            var g = d.stateNode.containerInfo, h = Uj(a);
            Vj(a, h, g);
            break;
          default:
            throw Error(p(161));
        }
      } catch (k) {
        W(a, a.return, k);
      }
      a.flags &= -3;
    }
    b & 4096 && (a.flags &= -4097);
  }
  function hk(a, b, c) {
    V = a;
    ik(a);
  }
  function ik(a, b, c) {
    for (var d = 0 !== (a.mode & 1); null !== V; ) {
      var e = V, f = e.child;
      if (22 === e.tag && d) {
        var g = null !== e.memoizedState || Jj;
        if (!g) {
          var h = e.alternate, k = null !== h && null !== h.memoizedState || U;
          h = Jj;
          var l = U;
          Jj = g;
          if ((U = k) && !l) for (V = e; null !== V; ) g = V, k = g.child, 22 === g.tag && null !== g.memoizedState ? jk(e) : null !== k ? (k.return = g, V = k) : jk(e);
          for (; null !== f; ) V = f, ik(f), f = f.sibling;
          V = e;
          Jj = h;
          U = l;
        }
        kk(a);
      } else 0 !== (e.subtreeFlags & 8772) && null !== f ? (f.return = e, V = f) : kk(a);
    }
  }
  function kk(a) {
    for (; null !== V; ) {
      var b = V;
      if (0 !== (b.flags & 8772)) {
        var c = b.alternate;
        try {
          if (0 !== (b.flags & 8772)) switch (b.tag) {
            case 0:
            case 11:
            case 15:
              U || Qj(5, b);
              break;
            case 1:
              var d = b.stateNode;
              if (b.flags & 4 && !U) if (null === c) d.componentDidMount();
              else {
                var e = b.elementType === b.type ? c.memoizedProps : Ci(b.type, c.memoizedProps);
                d.componentDidUpdate(e, c.memoizedState, d.__reactInternalSnapshotBeforeUpdate);
              }
              var f = b.updateQueue;
              null !== f && sh(b, f, d);
              break;
            case 3:
              var g = b.updateQueue;
              if (null !== g) {
                c = null;
                if (null !== b.child) switch (b.child.tag) {
                  case 5:
                    c = b.child.stateNode;
                    break;
                  case 1:
                    c = b.child.stateNode;
                }
                sh(b, g, c);
              }
              break;
            case 5:
              var h = b.stateNode;
              if (null === c && b.flags & 4) {
                c = h;
                var k = b.memoizedProps;
                switch (b.type) {
                  case "button":
                  case "input":
                  case "select":
                  case "textarea":
                    k.autoFocus && c.focus();
                    break;
                  case "img":
                    k.src && (c.src = k.src);
                }
              }
              break;
            case 6:
              break;
            case 4:
              break;
            case 12:
              break;
            case 13:
              if (null === b.memoizedState) {
                var l = b.alternate;
                if (null !== l) {
                  var m = l.memoizedState;
                  if (null !== m) {
                    var q = m.dehydrated;
                    null !== q && bd(q);
                  }
                }
              }
              break;
            case 19:
            case 17:
            case 21:
            case 22:
            case 23:
            case 25:
              break;
            default:
              throw Error(p(163));
          }
          U || b.flags & 512 && Rj(b);
        } catch (r) {
          W(b, b.return, r);
        }
      }
      if (b === a) {
        V = null;
        break;
      }
      c = b.sibling;
      if (null !== c) {
        c.return = b.return;
        V = c;
        break;
      }
      V = b.return;
    }
  }
  function gk(a) {
    for (; null !== V; ) {
      var b = V;
      if (b === a) {
        V = null;
        break;
      }
      var c = b.sibling;
      if (null !== c) {
        c.return = b.return;
        V = c;
        break;
      }
      V = b.return;
    }
  }
  function jk(a) {
    for (; null !== V; ) {
      var b = V;
      try {
        switch (b.tag) {
          case 0:
          case 11:
          case 15:
            var c = b.return;
            try {
              Qj(4, b);
            } catch (k) {
              W(b, c, k);
            }
            break;
          case 1:
            var d = b.stateNode;
            if ("function" === typeof d.componentDidMount) {
              var e = b.return;
              try {
                d.componentDidMount();
              } catch (k) {
                W(b, e, k);
              }
            }
            var f = b.return;
            try {
              Rj(b);
            } catch (k) {
              W(b, f, k);
            }
            break;
          case 5:
            var g = b.return;
            try {
              Rj(b);
            } catch (k) {
              W(b, g, k);
            }
        }
      } catch (k) {
        W(b, b.return, k);
      }
      if (b === a) {
        V = null;
        break;
      }
      var h = b.sibling;
      if (null !== h) {
        h.return = b.return;
        V = h;
        break;
      }
      V = b.return;
    }
  }
  var lk = Math.ceil, mk = ua.ReactCurrentDispatcher, nk = ua.ReactCurrentOwner, ok = ua.ReactCurrentBatchConfig, K = 0, Q = null, Y = null, Z = 0, fj = 0, ej = Uf(0), T = 0, pk = null, rh = 0, qk = 0, rk = 0, sk = null, tk = null, fk = 0, Gj = Infinity, uk = null, Oi = false, Pi = null, Ri = null, vk = false, wk = null, xk = 0, yk = 0, zk = null, Ak = -1, Bk = 0;
  function R() {
    return 0 !== (K & 6) ? B() : -1 !== Ak ? Ak : Ak = B();
  }
  function yi(a) {
    if (0 === (a.mode & 1)) return 1;
    if (0 !== (K & 2) && 0 !== Z) return Z & -Z;
    if (null !== Kg.transition) return 0 === Bk && (Bk = yc()), Bk;
    a = C;
    if (0 !== a) return a;
    a = window.event;
    a = void 0 === a ? 16 : jd(a.type);
    return a;
  }
  function gi(a, b, c, d) {
    if (50 < yk) throw yk = 0, zk = null, Error(p(185));
    Ac(a, c, d);
    if (0 === (K & 2) || a !== Q) a === Q && (0 === (K & 2) && (qk |= c), 4 === T && Ck(a, Z)), Dk(a, d), 1 === c && 0 === K && 0 === (b.mode & 1) && (Gj = B() + 500, fg && jg());
  }
  function Dk(a, b) {
    var c = a.callbackNode;
    wc(a, b);
    var d = uc(a, a === Q ? Z : 0);
    if (0 === d) null !== c && bc(c), a.callbackNode = null, a.callbackPriority = 0;
    else if (b = d & -d, a.callbackPriority !== b) {
      null != c && bc(c);
      if (1 === b) 0 === a.tag ? ig(Ek.bind(null, a)) : hg(Ek.bind(null, a)), Jf(function() {
        0 === (K & 6) && jg();
      }), c = null;
      else {
        switch (Dc(d)) {
          case 1:
            c = fc;
            break;
          case 4:
            c = gc;
            break;
          case 16:
            c = hc;
            break;
          case 536870912:
            c = jc;
            break;
          default:
            c = hc;
        }
        c = Fk(c, Gk.bind(null, a));
      }
      a.callbackPriority = b;
      a.callbackNode = c;
    }
  }
  function Gk(a, b) {
    Ak = -1;
    Bk = 0;
    if (0 !== (K & 6)) throw Error(p(327));
    var c = a.callbackNode;
    if (Hk() && a.callbackNode !== c) return null;
    var d = uc(a, a === Q ? Z : 0);
    if (0 === d) return null;
    if (0 !== (d & 30) || 0 !== (d & a.expiredLanes) || b) b = Ik(a, d);
    else {
      b = d;
      var e = K;
      K |= 2;
      var f = Jk();
      if (Q !== a || Z !== b) uk = null, Gj = B() + 500, Kk(a, b);
      do
        try {
          Lk();
          break;
        } catch (h) {
          Mk(a, h);
        }
      while (1);
      $g();
      mk.current = f;
      K = e;
      null !== Y ? b = 0 : (Q = null, Z = 0, b = T);
    }
    if (0 !== b) {
      2 === b && (e = xc(a), 0 !== e && (d = e, b = Nk(a, e)));
      if (1 === b) throw c = pk, Kk(a, 0), Ck(a, d), Dk(a, B()), c;
      if (6 === b) Ck(a, d);
      else {
        e = a.current.alternate;
        if (0 === (d & 30) && !Ok(e) && (b = Ik(a, d), 2 === b && (f = xc(a), 0 !== f && (d = f, b = Nk(a, f))), 1 === b)) throw c = pk, Kk(a, 0), Ck(a, d), Dk(a, B()), c;
        a.finishedWork = e;
        a.finishedLanes = d;
        switch (b) {
          case 0:
          case 1:
            throw Error(p(345));
          case 2:
            Pk(a, tk, uk);
            break;
          case 3:
            Ck(a, d);
            if ((d & 130023424) === d && (b = fk + 500 - B(), 10 < b)) {
              if (0 !== uc(a, 0)) break;
              e = a.suspendedLanes;
              if ((e & d) !== d) {
                R();
                a.pingedLanes |= a.suspendedLanes & e;
                break;
              }
              a.timeoutHandle = Ff(Pk.bind(null, a, tk, uk), b);
              break;
            }
            Pk(a, tk, uk);
            break;
          case 4:
            Ck(a, d);
            if ((d & 4194240) === d) break;
            b = a.eventTimes;
            for (e = -1; 0 < d; ) {
              var g = 31 - oc(d);
              f = 1 << g;
              g = b[g];
              g > e && (e = g);
              d &= ~f;
            }
            d = e;
            d = B() - d;
            d = (120 > d ? 120 : 480 > d ? 480 : 1080 > d ? 1080 : 1920 > d ? 1920 : 3e3 > d ? 3e3 : 4320 > d ? 4320 : 1960 * lk(d / 1960)) - d;
            if (10 < d) {
              a.timeoutHandle = Ff(Pk.bind(null, a, tk, uk), d);
              break;
            }
            Pk(a, tk, uk);
            break;
          case 5:
            Pk(a, tk, uk);
            break;
          default:
            throw Error(p(329));
        }
      }
    }
    Dk(a, B());
    return a.callbackNode === c ? Gk.bind(null, a) : null;
  }
  function Nk(a, b) {
    var c = sk;
    a.current.memoizedState.isDehydrated && (Kk(a, b).flags |= 256);
    a = Ik(a, b);
    2 !== a && (b = tk, tk = c, null !== b && Fj(b));
    return a;
  }
  function Fj(a) {
    null === tk ? tk = a : tk.push.apply(tk, a);
  }
  function Ok(a) {
    for (var b = a; ; ) {
      if (b.flags & 16384) {
        var c = b.updateQueue;
        if (null !== c && (c = c.stores, null !== c)) for (var d = 0; d < c.length; d++) {
          var e = c[d], f = e.getSnapshot;
          e = e.value;
          try {
            if (!He(f(), e)) return false;
          } catch (g) {
            return false;
          }
        }
      }
      c = b.child;
      if (b.subtreeFlags & 16384 && null !== c) c.return = b, b = c;
      else {
        if (b === a) break;
        for (; null === b.sibling; ) {
          if (null === b.return || b.return === a) return true;
          b = b.return;
        }
        b.sibling.return = b.return;
        b = b.sibling;
      }
    }
    return true;
  }
  function Ck(a, b) {
    b &= ~rk;
    b &= ~qk;
    a.suspendedLanes |= b;
    a.pingedLanes &= ~b;
    for (a = a.expirationTimes; 0 < b; ) {
      var c = 31 - oc(b), d = 1 << c;
      a[c] = -1;
      b &= ~d;
    }
  }
  function Ek(a) {
    if (0 !== (K & 6)) throw Error(p(327));
    Hk();
    var b = uc(a, 0);
    if (0 === (b & 1)) return Dk(a, B()), null;
    var c = Ik(a, b);
    if (0 !== a.tag && 2 === c) {
      var d = xc(a);
      0 !== d && (b = d, c = Nk(a, d));
    }
    if (1 === c) throw c = pk, Kk(a, 0), Ck(a, b), Dk(a, B()), c;
    if (6 === c) throw Error(p(345));
    a.finishedWork = a.current.alternate;
    a.finishedLanes = b;
    Pk(a, tk, uk);
    Dk(a, B());
    return null;
  }
  function Qk(a, b) {
    var c = K;
    K |= 1;
    try {
      return a(b);
    } finally {
      K = c, 0 === K && (Gj = B() + 500, fg && jg());
    }
  }
  function Rk(a) {
    null !== wk && 0 === wk.tag && 0 === (K & 6) && Hk();
    var b = K;
    K |= 1;
    var c = ok.transition, d = C;
    try {
      if (ok.transition = null, C = 1, a) return a();
    } finally {
      C = d, ok.transition = c, K = b, 0 === (K & 6) && jg();
    }
  }
  function Hj() {
    fj = ej.current;
    E(ej);
  }
  function Kk(a, b) {
    a.finishedWork = null;
    a.finishedLanes = 0;
    var c = a.timeoutHandle;
    -1 !== c && (a.timeoutHandle = -1, Gf(c));
    if (null !== Y) for (c = Y.return; null !== c; ) {
      var d = c;
      wg(d);
      switch (d.tag) {
        case 1:
          d = d.type.childContextTypes;
          null !== d && void 0 !== d && $f();
          break;
        case 3:
          zh();
          E(Wf);
          E(H);
          Eh();
          break;
        case 5:
          Bh(d);
          break;
        case 4:
          zh();
          break;
        case 13:
          E(L);
          break;
        case 19:
          E(L);
          break;
        case 10:
          ah(d.type._context);
          break;
        case 22:
        case 23:
          Hj();
      }
      c = c.return;
    }
    Q = a;
    Y = a = Pg(a.current, null);
    Z = fj = b;
    T = 0;
    pk = null;
    rk = qk = rh = 0;
    tk = sk = null;
    if (null !== fh) {
      for (b = 0; b < fh.length; b++) if (c = fh[b], d = c.interleaved, null !== d) {
        c.interleaved = null;
        var e = d.next, f = c.pending;
        if (null !== f) {
          var g = f.next;
          f.next = e;
          d.next = g;
        }
        c.pending = d;
      }
      fh = null;
    }
    return a;
  }
  function Mk(a, b) {
    do {
      var c = Y;
      try {
        $g();
        Fh.current = Rh;
        if (Ih) {
          for (var d = M.memoizedState; null !== d; ) {
            var e = d.queue;
            null !== e && (e.pending = null);
            d = d.next;
          }
          Ih = false;
        }
        Hh = 0;
        O = N = M = null;
        Jh = false;
        Kh = 0;
        nk.current = null;
        if (null === c || null === c.return) {
          T = 1;
          pk = b;
          Y = null;
          break;
        }
        a: {
          var f = a, g = c.return, h = c, k = b;
          b = Z;
          h.flags |= 32768;
          if (null !== k && "object" === typeof k && "function" === typeof k.then) {
            var l = k, m = h, q = m.tag;
            if (0 === (m.mode & 1) && (0 === q || 11 === q || 15 === q)) {
              var r = m.alternate;
              r ? (m.updateQueue = r.updateQueue, m.memoizedState = r.memoizedState, m.lanes = r.lanes) : (m.updateQueue = null, m.memoizedState = null);
            }
            var y = Ui(g);
            if (null !== y) {
              y.flags &= -257;
              Vi(y, g, h, f, b);
              y.mode & 1 && Si(f, l, b);
              b = y;
              k = l;
              var n = b.updateQueue;
              if (null === n) {
                var t = /* @__PURE__ */ new Set();
                t.add(k);
                b.updateQueue = t;
              } else n.add(k);
              break a;
            } else {
              if (0 === (b & 1)) {
                Si(f, l, b);
                tj();
                break a;
              }
              k = Error(p(426));
            }
          } else if (I && h.mode & 1) {
            var J = Ui(g);
            if (null !== J) {
              0 === (J.flags & 65536) && (J.flags |= 256);
              Vi(J, g, h, f, b);
              Jg(Ji(k, h));
              break a;
            }
          }
          f = k = Ji(k, h);
          4 !== T && (T = 2);
          null === sk ? sk = [f] : sk.push(f);
          f = g;
          do {
            switch (f.tag) {
              case 3:
                f.flags |= 65536;
                b &= -b;
                f.lanes |= b;
                var x = Ni(f, k, b);
                ph(f, x);
                break a;
              case 1:
                h = k;
                var w = f.type, u = f.stateNode;
                if (0 === (f.flags & 128) && ("function" === typeof w.getDerivedStateFromError || null !== u && "function" === typeof u.componentDidCatch && (null === Ri || !Ri.has(u)))) {
                  f.flags |= 65536;
                  b &= -b;
                  f.lanes |= b;
                  var F = Qi(f, h, b);
                  ph(f, F);
                  break a;
                }
            }
            f = f.return;
          } while (null !== f);
        }
        Sk(c);
      } catch (na) {
        b = na;
        Y === c && null !== c && (Y = c = c.return);
        continue;
      }
      break;
    } while (1);
  }
  function Jk() {
    var a = mk.current;
    mk.current = Rh;
    return null === a ? Rh : a;
  }
  function tj() {
    if (0 === T || 3 === T || 2 === T) T = 4;
    null === Q || 0 === (rh & 268435455) && 0 === (qk & 268435455) || Ck(Q, Z);
  }
  function Ik(a, b) {
    var c = K;
    K |= 2;
    var d = Jk();
    if (Q !== a || Z !== b) uk = null, Kk(a, b);
    do
      try {
        Tk();
        break;
      } catch (e) {
        Mk(a, e);
      }
    while (1);
    $g();
    K = c;
    mk.current = d;
    if (null !== Y) throw Error(p(261));
    Q = null;
    Z = 0;
    return T;
  }
  function Tk() {
    for (; null !== Y; ) Uk(Y);
  }
  function Lk() {
    for (; null !== Y && !cc(); ) Uk(Y);
  }
  function Uk(a) {
    var b = Vk(a.alternate, a, fj);
    a.memoizedProps = a.pendingProps;
    null === b ? Sk(a) : Y = b;
    nk.current = null;
  }
  function Sk(a) {
    var b = a;
    do {
      var c = b.alternate;
      a = b.return;
      if (0 === (b.flags & 32768)) {
        if (c = Ej(c, b, fj), null !== c) {
          Y = c;
          return;
        }
      } else {
        c = Ij(c, b);
        if (null !== c) {
          c.flags &= 32767;
          Y = c;
          return;
        }
        if (null !== a) a.flags |= 32768, a.subtreeFlags = 0, a.deletions = null;
        else {
          T = 6;
          Y = null;
          return;
        }
      }
      b = b.sibling;
      if (null !== b) {
        Y = b;
        return;
      }
      Y = b = a;
    } while (null !== b);
    0 === T && (T = 5);
  }
  function Pk(a, b, c) {
    var d = C, e = ok.transition;
    try {
      ok.transition = null, C = 1, Wk(a, b, c, d);
    } finally {
      ok.transition = e, C = d;
    }
    return null;
  }
  function Wk(a, b, c, d) {
    do
      Hk();
    while (null !== wk);
    if (0 !== (K & 6)) throw Error(p(327));
    c = a.finishedWork;
    var e = a.finishedLanes;
    if (null === c) return null;
    a.finishedWork = null;
    a.finishedLanes = 0;
    if (c === a.current) throw Error(p(177));
    a.callbackNode = null;
    a.callbackPriority = 0;
    var f = c.lanes | c.childLanes;
    Bc(a, f);
    a === Q && (Y = Q = null, Z = 0);
    0 === (c.subtreeFlags & 2064) && 0 === (c.flags & 2064) || vk || (vk = true, Fk(hc, function() {
      Hk();
      return null;
    }));
    f = 0 !== (c.flags & 15990);
    if (0 !== (c.subtreeFlags & 15990) || f) {
      f = ok.transition;
      ok.transition = null;
      var g = C;
      C = 1;
      var h = K;
      K |= 4;
      nk.current = null;
      Oj(a, c);
      dk(c, a);
      Oe(Df);
      dd = !!Cf;
      Df = Cf = null;
      a.current = c;
      hk(c);
      dc();
      K = h;
      C = g;
      ok.transition = f;
    } else a.current = c;
    vk && (vk = false, wk = a, xk = e);
    f = a.pendingLanes;
    0 === f && (Ri = null);
    mc(c.stateNode);
    Dk(a, B());
    if (null !== b) for (d = a.onRecoverableError, c = 0; c < b.length; c++) e = b[c], d(e.value, { componentStack: e.stack, digest: e.digest });
    if (Oi) throw Oi = false, a = Pi, Pi = null, a;
    0 !== (xk & 1) && 0 !== a.tag && Hk();
    f = a.pendingLanes;
    0 !== (f & 1) ? a === zk ? yk++ : (yk = 0, zk = a) : yk = 0;
    jg();
    return null;
  }
  function Hk() {
    if (null !== wk) {
      var a = Dc(xk), b = ok.transition, c = C;
      try {
        ok.transition = null;
        C = 16 > a ? 16 : a;
        if (null === wk) var d = false;
        else {
          a = wk;
          wk = null;
          xk = 0;
          if (0 !== (K & 6)) throw Error(p(331));
          var e = K;
          K |= 4;
          for (V = a.current; null !== V; ) {
            var f = V, g = f.child;
            if (0 !== (V.flags & 16)) {
              var h = f.deletions;
              if (null !== h) {
                for (var k = 0; k < h.length; k++) {
                  var l = h[k];
                  for (V = l; null !== V; ) {
                    var m = V;
                    switch (m.tag) {
                      case 0:
                      case 11:
                      case 15:
                        Pj(8, m, f);
                    }
                    var q = m.child;
                    if (null !== q) q.return = m, V = q;
                    else for (; null !== V; ) {
                      m = V;
                      var r = m.sibling, y = m.return;
                      Sj(m);
                      if (m === l) {
                        V = null;
                        break;
                      }
                      if (null !== r) {
                        r.return = y;
                        V = r;
                        break;
                      }
                      V = y;
                    }
                  }
                }
                var n = f.alternate;
                if (null !== n) {
                  var t = n.child;
                  if (null !== t) {
                    n.child = null;
                    do {
                      var J = t.sibling;
                      t.sibling = null;
                      t = J;
                    } while (null !== t);
                  }
                }
                V = f;
              }
            }
            if (0 !== (f.subtreeFlags & 2064) && null !== g) g.return = f, V = g;
            else b: for (; null !== V; ) {
              f = V;
              if (0 !== (f.flags & 2048)) switch (f.tag) {
                case 0:
                case 11:
                case 15:
                  Pj(9, f, f.return);
              }
              var x = f.sibling;
              if (null !== x) {
                x.return = f.return;
                V = x;
                break b;
              }
              V = f.return;
            }
          }
          var w = a.current;
          for (V = w; null !== V; ) {
            g = V;
            var u = g.child;
            if (0 !== (g.subtreeFlags & 2064) && null !== u) u.return = g, V = u;
            else b: for (g = w; null !== V; ) {
              h = V;
              if (0 !== (h.flags & 2048)) try {
                switch (h.tag) {
                  case 0:
                  case 11:
                  case 15:
                    Qj(9, h);
                }
              } catch (na) {
                W(h, h.return, na);
              }
              if (h === g) {
                V = null;
                break b;
              }
              var F = h.sibling;
              if (null !== F) {
                F.return = h.return;
                V = F;
                break b;
              }
              V = h.return;
            }
          }
          K = e;
          jg();
          if (lc && "function" === typeof lc.onPostCommitFiberRoot) try {
            lc.onPostCommitFiberRoot(kc, a);
          } catch (na) {
          }
          d = true;
        }
        return d;
      } finally {
        C = c, ok.transition = b;
      }
    }
    return false;
  }
  function Xk(a, b, c) {
    b = Ji(c, b);
    b = Ni(a, b, 1);
    a = nh(a, b, 1);
    b = R();
    null !== a && (Ac(a, 1, b), Dk(a, b));
  }
  function W(a, b, c) {
    if (3 === a.tag) Xk(a, a, c);
    else for (; null !== b; ) {
      if (3 === b.tag) {
        Xk(b, a, c);
        break;
      } else if (1 === b.tag) {
        var d = b.stateNode;
        if ("function" === typeof b.type.getDerivedStateFromError || "function" === typeof d.componentDidCatch && (null === Ri || !Ri.has(d))) {
          a = Ji(c, a);
          a = Qi(b, a, 1);
          b = nh(b, a, 1);
          a = R();
          null !== b && (Ac(b, 1, a), Dk(b, a));
          break;
        }
      }
      b = b.return;
    }
  }
  function Ti(a, b, c) {
    var d = a.pingCache;
    null !== d && d.delete(b);
    b = R();
    a.pingedLanes |= a.suspendedLanes & c;
    Q === a && (Z & c) === c && (4 === T || 3 === T && (Z & 130023424) === Z && 500 > B() - fk ? Kk(a, 0) : rk |= c);
    Dk(a, b);
  }
  function Yk(a, b) {
    0 === b && (0 === (a.mode & 1) ? b = 1 : (b = sc, sc <<= 1, 0 === (sc & 130023424) && (sc = 4194304)));
    var c = R();
    a = ih(a, b);
    null !== a && (Ac(a, b, c), Dk(a, c));
  }
  function uj(a) {
    var b = a.memoizedState, c = 0;
    null !== b && (c = b.retryLane);
    Yk(a, c);
  }
  function bk(a, b) {
    var c = 0;
    switch (a.tag) {
      case 13:
        var d = a.stateNode;
        var e = a.memoizedState;
        null !== e && (c = e.retryLane);
        break;
      case 19:
        d = a.stateNode;
        break;
      default:
        throw Error(p(314));
    }
    null !== d && d.delete(b);
    Yk(a, c);
  }
  var Vk;
  Vk = function(a, b, c) {
    if (null !== a) if (a.memoizedProps !== b.pendingProps || Wf.current) dh = true;
    else {
      if (0 === (a.lanes & c) && 0 === (b.flags & 128)) return dh = false, yj(a, b, c);
      dh = 0 !== (a.flags & 131072) ? true : false;
    }
    else dh = false, I && 0 !== (b.flags & 1048576) && ug(b, ng, b.index);
    b.lanes = 0;
    switch (b.tag) {
      case 2:
        var d = b.type;
        ij(a, b);
        a = b.pendingProps;
        var e = Yf(b, H.current);
        ch(b, c);
        e = Nh(null, b, d, a, e, c);
        var f = Sh();
        b.flags |= 1;
        "object" === typeof e && null !== e && "function" === typeof e.render && void 0 === e.$$typeof ? (b.tag = 1, b.memoizedState = null, b.updateQueue = null, Zf(d) ? (f = true, cg(b)) : f = false, b.memoizedState = null !== e.state && void 0 !== e.state ? e.state : null, kh(b), e.updater = Ei, b.stateNode = e, e._reactInternals = b, Ii(b, d, a, c), b = jj(null, b, d, true, f, c)) : (b.tag = 0, I && f && vg(b), Xi(null, b, e, c), b = b.child);
        return b;
      case 16:
        d = b.elementType;
        a: {
          ij(a, b);
          a = b.pendingProps;
          e = d._init;
          d = e(d._payload);
          b.type = d;
          e = b.tag = Zk(d);
          a = Ci(d, a);
          switch (e) {
            case 0:
              b = cj(null, b, d, a, c);
              break a;
            case 1:
              b = hj(null, b, d, a, c);
              break a;
            case 11:
              b = Yi(null, b, d, a, c);
              break a;
            case 14:
              b = $i(null, b, d, Ci(d.type, a), c);
              break a;
          }
          throw Error(p(
            306,
            d,
            ""
          ));
        }
        return b;
      case 0:
        return d = b.type, e = b.pendingProps, e = b.elementType === d ? e : Ci(d, e), cj(a, b, d, e, c);
      case 1:
        return d = b.type, e = b.pendingProps, e = b.elementType === d ? e : Ci(d, e), hj(a, b, d, e, c);
      case 3:
        a: {
          kj(b);
          if (null === a) throw Error(p(387));
          d = b.pendingProps;
          f = b.memoizedState;
          e = f.element;
          lh(a, b);
          qh(b, d, null, c);
          var g = b.memoizedState;
          d = g.element;
          if (f.isDehydrated) if (f = { element: d, isDehydrated: false, cache: g.cache, pendingSuspenseBoundaries: g.pendingSuspenseBoundaries, transitions: g.transitions }, b.updateQueue.baseState = f, b.memoizedState = f, b.flags & 256) {
            e = Ji(Error(p(423)), b);
            b = lj(a, b, d, c, e);
            break a;
          } else if (d !== e) {
            e = Ji(Error(p(424)), b);
            b = lj(a, b, d, c, e);
            break a;
          } else for (yg = Lf(b.stateNode.containerInfo.firstChild), xg = b, I = true, zg = null, c = Vg(b, null, d, c), b.child = c; c; ) c.flags = c.flags & -3 | 4096, c = c.sibling;
          else {
            Ig();
            if (d === e) {
              b = Zi(a, b, c);
              break a;
            }
            Xi(a, b, d, c);
          }
          b = b.child;
        }
        return b;
      case 5:
        return Ah(b), null === a && Eg(b), d = b.type, e = b.pendingProps, f = null !== a ? a.memoizedProps : null, g = e.children, Ef(d, e) ? g = null : null !== f && Ef(d, f) && (b.flags |= 32), gj(a, b), Xi(a, b, g, c), b.child;
      case 6:
        return null === a && Eg(b), null;
      case 13:
        return oj(a, b, c);
      case 4:
        return yh(b, b.stateNode.containerInfo), d = b.pendingProps, null === a ? b.child = Ug(b, null, d, c) : Xi(a, b, d, c), b.child;
      case 11:
        return d = b.type, e = b.pendingProps, e = b.elementType === d ? e : Ci(d, e), Yi(a, b, d, e, c);
      case 7:
        return Xi(a, b, b.pendingProps, c), b.child;
      case 8:
        return Xi(a, b, b.pendingProps.children, c), b.child;
      case 12:
        return Xi(a, b, b.pendingProps.children, c), b.child;
      case 10:
        a: {
          d = b.type._context;
          e = b.pendingProps;
          f = b.memoizedProps;
          g = e.value;
          G(Wg, d._currentValue);
          d._currentValue = g;
          if (null !== f) if (He(f.value, g)) {
            if (f.children === e.children && !Wf.current) {
              b = Zi(a, b, c);
              break a;
            }
          } else for (f = b.child, null !== f && (f.return = b); null !== f; ) {
            var h = f.dependencies;
            if (null !== h) {
              g = f.child;
              for (var k = h.firstContext; null !== k; ) {
                if (k.context === d) {
                  if (1 === f.tag) {
                    k = mh(-1, c & -c);
                    k.tag = 2;
                    var l = f.updateQueue;
                    if (null !== l) {
                      l = l.shared;
                      var m = l.pending;
                      null === m ? k.next = k : (k.next = m.next, m.next = k);
                      l.pending = k;
                    }
                  }
                  f.lanes |= c;
                  k = f.alternate;
                  null !== k && (k.lanes |= c);
                  bh(
                    f.return,
                    c,
                    b
                  );
                  h.lanes |= c;
                  break;
                }
                k = k.next;
              }
            } else if (10 === f.tag) g = f.type === b.type ? null : f.child;
            else if (18 === f.tag) {
              g = f.return;
              if (null === g) throw Error(p(341));
              g.lanes |= c;
              h = g.alternate;
              null !== h && (h.lanes |= c);
              bh(g, c, b);
              g = f.sibling;
            } else g = f.child;
            if (null !== g) g.return = f;
            else for (g = f; null !== g; ) {
              if (g === b) {
                g = null;
                break;
              }
              f = g.sibling;
              if (null !== f) {
                f.return = g.return;
                g = f;
                break;
              }
              g = g.return;
            }
            f = g;
          }
          Xi(a, b, e.children, c);
          b = b.child;
        }
        return b;
      case 9:
        return e = b.type, d = b.pendingProps.children, ch(b, c), e = eh(e), d = d(e), b.flags |= 1, Xi(a, b, d, c), b.child;
      case 14:
        return d = b.type, e = Ci(d, b.pendingProps), e = Ci(d.type, e), $i(a, b, d, e, c);
      case 15:
        return bj(a, b, b.type, b.pendingProps, c);
      case 17:
        return d = b.type, e = b.pendingProps, e = b.elementType === d ? e : Ci(d, e), ij(a, b), b.tag = 1, Zf(d) ? (a = true, cg(b)) : a = false, ch(b, c), Gi(b, d, e), Ii(b, d, e, c), jj(null, b, d, true, a, c);
      case 19:
        return xj(a, b, c);
      case 22:
        return dj(a, b, c);
    }
    throw Error(p(156, b.tag));
  };
  function Fk(a, b) {
    return ac(a, b);
  }
  function $k(a, b, c, d) {
    this.tag = a;
    this.key = c;
    this.sibling = this.child = this.return = this.stateNode = this.type = this.elementType = null;
    this.index = 0;
    this.ref = null;
    this.pendingProps = b;
    this.dependencies = this.memoizedState = this.updateQueue = this.memoizedProps = null;
    this.mode = d;
    this.subtreeFlags = this.flags = 0;
    this.deletions = null;
    this.childLanes = this.lanes = 0;
    this.alternate = null;
  }
  function Bg(a, b, c, d) {
    return new $k(a, b, c, d);
  }
  function aj(a) {
    a = a.prototype;
    return !(!a || !a.isReactComponent);
  }
  function Zk(a) {
    if ("function" === typeof a) return aj(a) ? 1 : 0;
    if (void 0 !== a && null !== a) {
      a = a.$$typeof;
      if (a === Da) return 11;
      if (a === Ga) return 14;
    }
    return 2;
  }
  function Pg(a, b) {
    var c = a.alternate;
    null === c ? (c = Bg(a.tag, b, a.key, a.mode), c.elementType = a.elementType, c.type = a.type, c.stateNode = a.stateNode, c.alternate = a, a.alternate = c) : (c.pendingProps = b, c.type = a.type, c.flags = 0, c.subtreeFlags = 0, c.deletions = null);
    c.flags = a.flags & 14680064;
    c.childLanes = a.childLanes;
    c.lanes = a.lanes;
    c.child = a.child;
    c.memoizedProps = a.memoizedProps;
    c.memoizedState = a.memoizedState;
    c.updateQueue = a.updateQueue;
    b = a.dependencies;
    c.dependencies = null === b ? null : { lanes: b.lanes, firstContext: b.firstContext };
    c.sibling = a.sibling;
    c.index = a.index;
    c.ref = a.ref;
    return c;
  }
  function Rg(a, b, c, d, e, f) {
    var g = 2;
    d = a;
    if ("function" === typeof a) aj(a) && (g = 1);
    else if ("string" === typeof a) g = 5;
    else a: switch (a) {
      case ya:
        return Tg(c.children, e, f, b);
      case za:
        g = 8;
        e |= 8;
        break;
      case Aa:
        return a = Bg(12, c, b, e | 2), a.elementType = Aa, a.lanes = f, a;
      case Ea:
        return a = Bg(13, c, b, e), a.elementType = Ea, a.lanes = f, a;
      case Fa:
        return a = Bg(19, c, b, e), a.elementType = Fa, a.lanes = f, a;
      case Ia:
        return pj(c, e, f, b);
      default:
        if ("object" === typeof a && null !== a) switch (a.$$typeof) {
          case Ba:
            g = 10;
            break a;
          case Ca:
            g = 9;
            break a;
          case Da:
            g = 11;
            break a;
          case Ga:
            g = 14;
            break a;
          case Ha:
            g = 16;
            d = null;
            break a;
        }
        throw Error(p(130, null == a ? a : typeof a, ""));
    }
    b = Bg(g, c, b, e);
    b.elementType = a;
    b.type = d;
    b.lanes = f;
    return b;
  }
  function Tg(a, b, c, d) {
    a = Bg(7, a, d, b);
    a.lanes = c;
    return a;
  }
  function pj(a, b, c, d) {
    a = Bg(22, a, d, b);
    a.elementType = Ia;
    a.lanes = c;
    a.stateNode = { isHidden: false };
    return a;
  }
  function Qg(a, b, c) {
    a = Bg(6, a, null, b);
    a.lanes = c;
    return a;
  }
  function Sg(a, b, c) {
    b = Bg(4, null !== a.children ? a.children : [], a.key, b);
    b.lanes = c;
    b.stateNode = { containerInfo: a.containerInfo, pendingChildren: null, implementation: a.implementation };
    return b;
  }
  function al(a, b, c, d, e) {
    this.tag = b;
    this.containerInfo = a;
    this.finishedWork = this.pingCache = this.current = this.pendingChildren = null;
    this.timeoutHandle = -1;
    this.callbackNode = this.pendingContext = this.context = null;
    this.callbackPriority = 0;
    this.eventTimes = zc(0);
    this.expirationTimes = zc(-1);
    this.entangledLanes = this.finishedLanes = this.mutableReadLanes = this.expiredLanes = this.pingedLanes = this.suspendedLanes = this.pendingLanes = 0;
    this.entanglements = zc(0);
    this.identifierPrefix = d;
    this.onRecoverableError = e;
    this.mutableSourceEagerHydrationData = null;
  }
  function bl(a, b, c, d, e, f, g, h, k) {
    a = new al(a, b, c, h, k);
    1 === b ? (b = 1, true === f && (b |= 8)) : b = 0;
    f = Bg(3, null, null, b);
    a.current = f;
    f.stateNode = a;
    f.memoizedState = { element: d, isDehydrated: c, cache: null, transitions: null, pendingSuspenseBoundaries: null };
    kh(f);
    return a;
  }
  function cl(a, b, c) {
    var d = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : null;
    return { $$typeof: wa, key: null == d ? null : "" + d, children: a, containerInfo: b, implementation: c };
  }
  function dl(a) {
    if (!a) return Vf;
    a = a._reactInternals;
    a: {
      if (Vb(a) !== a || 1 !== a.tag) throw Error(p(170));
      var b = a;
      do {
        switch (b.tag) {
          case 3:
            b = b.stateNode.context;
            break a;
          case 1:
            if (Zf(b.type)) {
              b = b.stateNode.__reactInternalMemoizedMergedChildContext;
              break a;
            }
        }
        b = b.return;
      } while (null !== b);
      throw Error(p(171));
    }
    if (1 === a.tag) {
      var c = a.type;
      if (Zf(c)) return bg(a, c, b);
    }
    return b;
  }
  function el(a, b, c, d, e, f, g, h, k) {
    a = bl(c, d, true, a, e, f, g, h, k);
    a.context = dl(null);
    c = a.current;
    d = R();
    e = yi(c);
    f = mh(d, e);
    f.callback = void 0 !== b && null !== b ? b : null;
    nh(c, f, e);
    a.current.lanes = e;
    Ac(a, e, d);
    Dk(a, d);
    return a;
  }
  function fl(a, b, c, d) {
    var e = b.current, f = R(), g = yi(e);
    c = dl(c);
    null === b.context ? b.context = c : b.pendingContext = c;
    b = mh(f, g);
    b.payload = { element: a };
    d = void 0 === d ? null : d;
    null !== d && (b.callback = d);
    a = nh(e, b, g);
    null !== a && (gi(a, e, g, f), oh(a, e, g));
    return g;
  }
  function gl(a) {
    a = a.current;
    if (!a.child) return null;
    switch (a.child.tag) {
      case 5:
        return a.child.stateNode;
      default:
        return a.child.stateNode;
    }
  }
  function hl(a, b) {
    a = a.memoizedState;
    if (null !== a && null !== a.dehydrated) {
      var c = a.retryLane;
      a.retryLane = 0 !== c && c < b ? c : b;
    }
  }
  function il(a, b) {
    hl(a, b);
    (a = a.alternate) && hl(a, b);
  }
  var kl = "function" === typeof reportError ? reportError : function(a) {
    console.error(a);
  };
  function ll(a) {
    this._internalRoot = a;
  }
  ml.prototype.render = ll.prototype.render = function(a) {
    var b = this._internalRoot;
    if (null === b) throw Error(p(409));
    fl(a, b, null, null);
  };
  ml.prototype.unmount = ll.prototype.unmount = function() {
    var a = this._internalRoot;
    if (null !== a) {
      this._internalRoot = null;
      var b = a.containerInfo;
      Rk(function() {
        fl(null, a, null, null);
      });
      b[uf] = null;
    }
  };
  function ml(a) {
    this._internalRoot = a;
  }
  ml.prototype.unstable_scheduleHydration = function(a) {
    if (a) {
      var b = Hc();
      a = { blockedOn: null, target: a, priority: b };
      for (var c = 0; c < Qc.length && 0 !== b && b < Qc[c].priority; c++) ;
      Qc.splice(c, 0, a);
      0 === c && Vc(a);
    }
  };
  function nl(a) {
    return !(!a || 1 !== a.nodeType && 9 !== a.nodeType && 11 !== a.nodeType);
  }
  function ol(a) {
    return !(!a || 1 !== a.nodeType && 9 !== a.nodeType && 11 !== a.nodeType && (8 !== a.nodeType || " react-mount-point-unstable " !== a.nodeValue));
  }
  function pl() {
  }
  function ql(a, b, c, d, e) {
    if (e) {
      if ("function" === typeof d) {
        var f = d;
        d = function() {
          var a2 = gl(g);
          f.call(a2);
        };
      }
      var g = el(b, d, a, 0, null, false, false, "", pl);
      a._reactRootContainer = g;
      a[uf] = g.current;
      sf(8 === a.nodeType ? a.parentNode : a);
      Rk();
      return g;
    }
    for (; e = a.lastChild; ) a.removeChild(e);
    if ("function" === typeof d) {
      var h = d;
      d = function() {
        var a2 = gl(k);
        h.call(a2);
      };
    }
    var k = bl(a, 0, false, null, null, false, false, "", pl);
    a._reactRootContainer = k;
    a[uf] = k.current;
    sf(8 === a.nodeType ? a.parentNode : a);
    Rk(function() {
      fl(b, k, c, d);
    });
    return k;
  }
  function rl(a, b, c, d, e) {
    var f = c._reactRootContainer;
    if (f) {
      var g = f;
      if ("function" === typeof e) {
        var h = e;
        e = function() {
          var a2 = gl(g);
          h.call(a2);
        };
      }
      fl(b, g, a, e);
    } else g = ql(c, b, a, e, d);
    return gl(g);
  }
  Ec = function(a) {
    switch (a.tag) {
      case 3:
        var b = a.stateNode;
        if (b.current.memoizedState.isDehydrated) {
          var c = tc(b.pendingLanes);
          0 !== c && (Cc(b, c | 1), Dk(b, B()), 0 === (K & 6) && (Gj = B() + 500, jg()));
        }
        break;
      case 13:
        Rk(function() {
          var b2 = ih(a, 1);
          if (null !== b2) {
            var c2 = R();
            gi(b2, a, 1, c2);
          }
        }), il(a, 1);
    }
  };
  Fc = function(a) {
    if (13 === a.tag) {
      var b = ih(a, 134217728);
      if (null !== b) {
        var c = R();
        gi(b, a, 134217728, c);
      }
      il(a, 134217728);
    }
  };
  Gc = function(a) {
    if (13 === a.tag) {
      var b = yi(a), c = ih(a, b);
      if (null !== c) {
        var d = R();
        gi(c, a, b, d);
      }
      il(a, b);
    }
  };
  Hc = function() {
    return C;
  };
  Ic = function(a, b) {
    var c = C;
    try {
      return C = a, b();
    } finally {
      C = c;
    }
  };
  yb = function(a, b, c) {
    switch (b) {
      case "input":
        bb(a, c);
        b = c.name;
        if ("radio" === c.type && null != b) {
          for (c = a; c.parentNode; ) c = c.parentNode;
          c = c.querySelectorAll("input[name=" + JSON.stringify("" + b) + '][type="radio"]');
          for (b = 0; b < c.length; b++) {
            var d = c[b];
            if (d !== a && d.form === a.form) {
              var e = Db(d);
              if (!e) throw Error(p(90));
              Wa(d);
              bb(d, e);
            }
          }
        }
        break;
      case "textarea":
        ib(a, c);
        break;
      case "select":
        b = c.value, null != b && fb(a, !!c.multiple, b, false);
    }
  };
  Gb = Qk;
  Hb = Rk;
  var sl = { usingClientEntryPoint: false, Events: [Cb, ue, Db, Eb, Fb, Qk] }, tl = { findFiberByHostInstance: Wc, bundleType: 0, version: "18.3.1", rendererPackageName: "react-dom" };
  var ul = { bundleType: tl.bundleType, version: tl.version, rendererPackageName: tl.rendererPackageName, rendererConfig: tl.rendererConfig, overrideHookState: null, overrideHookStateDeletePath: null, overrideHookStateRenamePath: null, overrideProps: null, overridePropsDeletePath: null, overridePropsRenamePath: null, setErrorHandler: null, setSuspenseHandler: null, scheduleUpdate: null, currentDispatcherRef: ua.ReactCurrentDispatcher, findHostInstanceByFiber: function(a) {
    a = Zb(a);
    return null === a ? null : a.stateNode;
  }, findFiberByHostInstance: tl.findFiberByHostInstance, findHostInstancesForRefresh: null, scheduleRefresh: null, scheduleRoot: null, setRefreshHandler: null, getCurrentFiber: null, reconcilerVersion: "18.3.1-next-f1338f8080-20240426" };
  if ("undefined" !== typeof __REACT_DEVTOOLS_GLOBAL_HOOK__) {
    var vl = __REACT_DEVTOOLS_GLOBAL_HOOK__;
    if (!vl.isDisabled && vl.supportsFiber) try {
      kc = vl.inject(ul), lc = vl;
    } catch (a) {
    }
  }
  reactDom_production_min.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED = sl;
  reactDom_production_min.createPortal = function(a, b) {
    var c = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : null;
    if (!nl(b)) throw Error(p(200));
    return cl(a, b, null, c);
  };
  reactDom_production_min.createRoot = function(a, b) {
    if (!nl(a)) throw Error(p(299));
    var c = false, d = "", e = kl;
    null !== b && void 0 !== b && (true === b.unstable_strictMode && (c = true), void 0 !== b.identifierPrefix && (d = b.identifierPrefix), void 0 !== b.onRecoverableError && (e = b.onRecoverableError));
    b = bl(a, 1, false, null, null, c, false, d, e);
    a[uf] = b.current;
    sf(8 === a.nodeType ? a.parentNode : a);
    return new ll(b);
  };
  reactDom_production_min.findDOMNode = function(a) {
    if (null == a) return null;
    if (1 === a.nodeType) return a;
    var b = a._reactInternals;
    if (void 0 === b) {
      if ("function" === typeof a.render) throw Error(p(188));
      a = Object.keys(a).join(",");
      throw Error(p(268, a));
    }
    a = Zb(b);
    a = null === a ? null : a.stateNode;
    return a;
  };
  reactDom_production_min.flushSync = function(a) {
    return Rk(a);
  };
  reactDom_production_min.hydrate = function(a, b, c) {
    if (!ol(b)) throw Error(p(200));
    return rl(null, a, b, true, c);
  };
  reactDom_production_min.hydrateRoot = function(a, b, c) {
    if (!nl(a)) throw Error(p(405));
    var d = null != c && c.hydratedSources || null, e = false, f = "", g = kl;
    null !== c && void 0 !== c && (true === c.unstable_strictMode && (e = true), void 0 !== c.identifierPrefix && (f = c.identifierPrefix), void 0 !== c.onRecoverableError && (g = c.onRecoverableError));
    b = el(b, null, a, 1, null != c ? c : null, e, false, f, g);
    a[uf] = b.current;
    sf(a);
    if (d) for (a = 0; a < d.length; a++) c = d[a], e = c._getVersion, e = e(c._source), null == b.mutableSourceEagerHydrationData ? b.mutableSourceEagerHydrationData = [c, e] : b.mutableSourceEagerHydrationData.push(
      c,
      e
    );
    return new ml(b);
  };
  reactDom_production_min.render = function(a, b, c) {
    if (!ol(b)) throw Error(p(200));
    return rl(null, a, b, false, c);
  };
  reactDom_production_min.unmountComponentAtNode = function(a) {
    if (!ol(a)) throw Error(p(40));
    return a._reactRootContainer ? (Rk(function() {
      rl(null, null, a, false, function() {
        a._reactRootContainer = null;
        a[uf] = null;
      });
    }), true) : false;
  };
  reactDom_production_min.unstable_batchedUpdates = Qk;
  reactDom_production_min.unstable_renderSubtreeIntoContainer = function(a, b, c, d) {
    if (!ol(c)) throw Error(p(200));
    if (null == a || void 0 === a._reactInternals) throw Error(p(38));
    return rl(a, b, c, false, d);
  };
  reactDom_production_min.version = "18.3.1-next-f1338f8080-20240426";
  return reactDom_production_min;
}
var hasRequiredReactDom;
function requireReactDom() {
  if (hasRequiredReactDom) return reactDom.exports;
  hasRequiredReactDom = 1;
  function checkDCE() {
    if (typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ === "undefined" || typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.checkDCE !== "function") {
      return;
    }
    try {
      __REACT_DEVTOOLS_GLOBAL_HOOK__.checkDCE(checkDCE);
    } catch (err) {
      console.error(err);
    }
  }
  {
    checkDCE();
    reactDom.exports = requireReactDom_production_min();
  }
  return reactDom.exports;
}
var hasRequiredClient;
function requireClient() {
  if (hasRequiredClient) return client;
  hasRequiredClient = 1;
  var m = requireReactDom();
  {
    client.createRoot = m.createRoot;
    client.hydrateRoot = m.hydrateRoot;
  }
  return client;
}
var clientExports = requireClient();
const root = "_root_1wcjp_1";
const appLayout = "_appLayout_1wcjp_11";
const content = "_content_1wcjp_24";
const developerTools = "_developerTools_1wcjp_31";
const styles$e = {
  root,
  appLayout,
  content,
  developerTools
};
var propTypes = { exports: {} };
var ReactPropTypesSecret_1;
var hasRequiredReactPropTypesSecret;
function requireReactPropTypesSecret() {
  if (hasRequiredReactPropTypesSecret) return ReactPropTypesSecret_1;
  hasRequiredReactPropTypesSecret = 1;
  var ReactPropTypesSecret = "SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED";
  ReactPropTypesSecret_1 = ReactPropTypesSecret;
  return ReactPropTypesSecret_1;
}
var factoryWithThrowingShims;
var hasRequiredFactoryWithThrowingShims;
function requireFactoryWithThrowingShims() {
  if (hasRequiredFactoryWithThrowingShims) return factoryWithThrowingShims;
  hasRequiredFactoryWithThrowingShims = 1;
  var ReactPropTypesSecret = /* @__PURE__ */ requireReactPropTypesSecret();
  function emptyFunction() {
  }
  function emptyFunctionWithReset() {
  }
  emptyFunctionWithReset.resetWarningCache = emptyFunction;
  factoryWithThrowingShims = function() {
    function shim(props, propName, componentName, location, propFullName, secret) {
      if (secret === ReactPropTypesSecret) {
        return;
      }
      var err = new Error(
        "Calling PropTypes validators directly is not supported by the `prop-types` package. Use PropTypes.checkPropTypes() to call them. Read more at http://fb.me/use-check-prop-types"
      );
      err.name = "Invariant Violation";
      throw err;
    }
    shim.isRequired = shim;
    function getShim() {
      return shim;
    }
    var ReactPropTypes = {
      array: shim,
      bigint: shim,
      bool: shim,
      func: shim,
      number: shim,
      object: shim,
      string: shim,
      symbol: shim,
      any: shim,
      arrayOf: getShim,
      element: shim,
      elementType: shim,
      instanceOf: getShim,
      node: shim,
      objectOf: getShim,
      oneOf: getShim,
      oneOfType: getShim,
      shape: getShim,
      exact: getShim,
      checkPropTypes: emptyFunctionWithReset,
      resetWarningCache: emptyFunction
    };
    ReactPropTypes.PropTypes = ReactPropTypes;
    return ReactPropTypes;
  };
  return factoryWithThrowingShims;
}
var hasRequiredPropTypes;
function requirePropTypes() {
  if (hasRequiredPropTypes) return propTypes.exports;
  hasRequiredPropTypes = 1;
  {
    propTypes.exports = /* @__PURE__ */ requireFactoryWithThrowingShims()();
  }
  return propTypes.exports;
}
var propTypesExports = /* @__PURE__ */ requirePropTypes();
const PropTypes = /* @__PURE__ */ getDefaultExportFromCjs(propTypesExports);
const Loading = () => {
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { style: styles$d.container, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("style", { children: `
        div.lds-ripple {
          scale: 4;
        }
        .lds-ripple,
        .lds-ripple div {
          box-sizing: border-box;
        }
        .lds-ripple {
          display: inline-block;
          position: relative;
          width: 80px;
          height: 80px;
        }
        .lds-ripple div {
          position: absolute;
          border: 4px solid #ff7a00;
          opacity: 1;
          border-radius: 50%;
          animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
        }
        .lds-ripple div:nth-child(2) {
          animation-delay: -0.5s;
        }
        @keyframes lds-ripple {
          0% {
            top: 36px;
            left: 36px;
            width: 8px;
            height: 8px;
            opacity: 0;
          }
          4.9% {
            top: 36px;
            left: 36px;
            width: 8px;
            height: 8px;
            opacity: 0;
          }
          5% {
            top: 36px;
            left: 36px;
            width: 8px;
            height: 8px;
            opacity: 1;
          }
          100% {
            top: 0;
            left: 0;
            width: 80px;
            height: 80px;
            opacity: 0;
          }
        }
        ` }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: "lds-ripple", children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", {}),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", {})
    ] })
  ] });
};
Loading.propTypes = {
  size: PropTypes.number
};
const styles$d = {
  container: {
    display: "flex",
    flexDirection: "column",
    alignItems: "center",
    justifyContent: "center",
    position: "absolute",
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    width: "100%",
    height: "100%",
    backgroundColor: "rgba(255, 255, 255, 0.5)"
  }
};
var isCheckBoxInput = (element) => element.type === "checkbox";
var isDateObject = (value) => value instanceof Date;
var isNullOrUndefined = (value) => value == null;
const isObjectType = (value) => typeof value === "object";
var isObject = (value) => !isNullOrUndefined(value) && !Array.isArray(value) && isObjectType(value) && !isDateObject(value);
var getEventValue = (event) => isObject(event) && event.target ? isCheckBoxInput(event.target) ? event.target.checked : event.target.value : event;
var getNodeParentName = (name) => name.substring(0, name.search(/\.\d+(\.|$)/)) || name;
var isNameInFieldArray = (names, name) => names.has(getNodeParentName(name));
var isPlainObject = (tempObject) => {
  const prototypeCopy = tempObject.constructor && tempObject.constructor.prototype;
  return isObject(prototypeCopy) && prototypeCopy.hasOwnProperty("isPrototypeOf");
};
var isWeb = typeof window !== "undefined" && typeof window.HTMLElement !== "undefined" && typeof document !== "undefined";
function cloneObject(data) {
  let copy;
  const isArray = Array.isArray(data);
  const isFileListInstance = typeof FileList !== "undefined" ? data instanceof FileList : false;
  if (data instanceof Date) {
    copy = new Date(data);
  } else if (data instanceof Set) {
    copy = new Set(data);
  } else if (!(isWeb && (data instanceof Blob || isFileListInstance)) && (isArray || isObject(data))) {
    copy = isArray ? [] : {};
    if (!isArray && !isPlainObject(data)) {
      copy = data;
    } else {
      for (const key in data) {
        if (data.hasOwnProperty(key)) {
          copy[key] = cloneObject(data[key]);
        }
      }
    }
  } else {
    return data;
  }
  return copy;
}
var compact = (value) => Array.isArray(value) ? value.filter(Boolean) : [];
var isUndefined = (val) => val === void 0;
var get = (object, path, defaultValue) => {
  if (!path || !isObject(object)) {
    return defaultValue;
  }
  const result = compact(path.split(/[,[\].]+?/)).reduce((result2, key) => isNullOrUndefined(result2) ? result2 : result2[key], object);
  return isUndefined(result) || result === object ? isUndefined(object[path]) ? defaultValue : object[path] : result;
};
var isBoolean = (value) => typeof value === "boolean";
var isKey = (value) => /^\w*$/.test(value);
var stringToPath = (input2) => compact(input2.replace(/["|']|\]/g, "").split(/\.|\[/));
var set = (object, path, value) => {
  let index = -1;
  const tempPath = isKey(path) ? [path] : stringToPath(path);
  const length = tempPath.length;
  const lastIndex = length - 1;
  while (++index < length) {
    const key = tempPath[index];
    let newValue = value;
    if (index !== lastIndex) {
      const objValue = object[key];
      newValue = isObject(objValue) || Array.isArray(objValue) ? objValue : !isNaN(+tempPath[index + 1]) ? [] : {};
    }
    if (key === "__proto__" || key === "constructor" || key === "prototype") {
      return;
    }
    object[key] = newValue;
    object = object[key];
  }
  return object;
};
const EVENTS = {
  BLUR: "blur",
  FOCUS_OUT: "focusout",
  CHANGE: "change"
};
const VALIDATION_MODE = {
  onBlur: "onBlur",
  onChange: "onChange",
  onSubmit: "onSubmit",
  onTouched: "onTouched",
  all: "all"
};
const INPUT_VALIDATION_RULES = {
  max: "max",
  min: "min",
  maxLength: "maxLength",
  minLength: "minLength",
  pattern: "pattern",
  required: "required",
  validate: "validate"
};
React.createContext(null);
var getProxyFormState = (formState, control, localProxyFormState, isRoot = true) => {
  const result = {
    defaultValues: control._defaultValues
  };
  for (const key in formState) {
    Object.defineProperty(result, key, {
      get: () => {
        const _key = key;
        if (control._proxyFormState[_key] !== VALIDATION_MODE.all) {
          control._proxyFormState[_key] = !isRoot || VALIDATION_MODE.all;
        }
        return formState[_key];
      }
    });
  }
  return result;
};
var isEmptyObject = (value) => isObject(value) && !Object.keys(value).length;
var shouldRenderFormState = (formStateData, _proxyFormState, updateFormState, isRoot) => {
  updateFormState(formStateData);
  const { name, ...formState } = formStateData;
  return isEmptyObject(formState) || Object.keys(formState).length >= Object.keys(_proxyFormState).length || Object.keys(formState).find((key) => _proxyFormState[key] === VALIDATION_MODE.all);
};
var convertToArrayPayload = (value) => Array.isArray(value) ? value : [value];
function useSubscribe(props) {
  const _props = React.useRef(props);
  _props.current = props;
  React.useEffect(() => {
    const subscription = !props.disabled && _props.current.subject && _props.current.subject.subscribe({
      next: _props.current.next
    });
    return () => {
      subscription && subscription.unsubscribe();
    };
  }, [props.disabled]);
}
var isString = (value) => typeof value === "string";
var generateWatchOutput = (names, _names, formValues, isGlobal, defaultValue) => {
  if (isString(names)) {
    isGlobal && _names.watch.add(names);
    return get(formValues, names, defaultValue);
  }
  if (Array.isArray(names)) {
    return names.map((fieldName) => (isGlobal && _names.watch.add(fieldName), get(formValues, fieldName)));
  }
  isGlobal && (_names.watchAll = true);
  return formValues;
};
var appendErrors = (name, validateAllFieldCriteria, errors, type, message2) => validateAllFieldCriteria ? {
  ...errors[name],
  types: {
    ...errors[name] && errors[name].types ? errors[name].types : {},
    [type]: message2 || true
  }
} : {};
var getValidationModes = (mode) => ({
  isOnSubmit: !mode || mode === VALIDATION_MODE.onSubmit,
  isOnBlur: mode === VALIDATION_MODE.onBlur,
  isOnChange: mode === VALIDATION_MODE.onChange,
  isOnAll: mode === VALIDATION_MODE.all,
  isOnTouch: mode === VALIDATION_MODE.onTouched
});
var isWatched = (name, _names, isBlurEvent) => !isBlurEvent && (_names.watchAll || _names.watch.has(name) || [..._names.watch].some((watchName) => name.startsWith(watchName) && /^\.\w+/.test(name.slice(watchName.length))));
const iterateFieldsByAction = (fields, action, fieldsNames, abortEarly) => {
  for (const key of fieldsNames || Object.keys(fields)) {
    const field = get(fields, key);
    if (field) {
      const { _f, ...currentField } = field;
      if (_f) {
        if (_f.refs && _f.refs[0] && action(_f.refs[0], key) && !abortEarly) {
          return true;
        } else if (_f.ref && action(_f.ref, _f.name) && !abortEarly) {
          return true;
        } else {
          if (iterateFieldsByAction(currentField, action)) {
            break;
          }
        }
      } else if (isObject(currentField)) {
        if (iterateFieldsByAction(currentField, action)) {
          break;
        }
      }
    }
  }
  return;
};
var updateFieldArrayRootError = (errors, error2, name) => {
  const fieldArrayErrors = convertToArrayPayload(get(errors, name));
  set(fieldArrayErrors, "root", error2[name]);
  set(errors, name, fieldArrayErrors);
  return errors;
};
var isFileInput = (element) => element.type === "file";
var isFunction = (value) => typeof value === "function";
var isHTMLElement = (value) => {
  if (!isWeb) {
    return false;
  }
  const owner = value ? value.ownerDocument : 0;
  return value instanceof (owner && owner.defaultView ? owner.defaultView.HTMLElement : HTMLElement);
};
var isMessage = (value) => isString(value);
var isRadioInput = (element) => element.type === "radio";
var isRegex = (value) => value instanceof RegExp;
const defaultResult = {
  value: false,
  isValid: false
};
const validResult = { value: true, isValid: true };
var getCheckboxValue = (options) => {
  if (Array.isArray(options)) {
    if (options.length > 1) {
      const values = options.filter((option2) => option2 && option2.checked && !option2.disabled).map((option2) => option2.value);
      return { value: values, isValid: !!values.length };
    }
    return options[0].checked && !options[0].disabled ? (
      // @ts-expect-error expected to work in the browser
      options[0].attributes && !isUndefined(options[0].attributes.value) ? isUndefined(options[0].value) || options[0].value === "" ? validResult : { value: options[0].value, isValid: true } : validResult
    ) : defaultResult;
  }
  return defaultResult;
};
const defaultReturn = {
  isValid: false,
  value: null
};
var getRadioValue = (options) => Array.isArray(options) ? options.reduce((previous, option2) => option2 && option2.checked && !option2.disabled ? {
  isValid: true,
  value: option2.value
} : previous, defaultReturn) : defaultReturn;
function getValidateError(result, ref, type = "validate") {
  if (isMessage(result) || Array.isArray(result) && result.every(isMessage) || isBoolean(result) && !result) {
    return {
      type,
      message: isMessage(result) ? result : "",
      ref
    };
  }
}
var getValueAndMessage = (validationData) => isObject(validationData) && !isRegex(validationData) ? validationData : {
  value: validationData,
  message: ""
};
var validateField = async (field, disabledFieldNames, formValues, validateAllFieldCriteria, shouldUseNativeValidation, isFieldArray) => {
  const { ref, refs, required, maxLength, minLength, min, max, pattern, validate, name, valueAsNumber, mount } = field._f;
  const inputValue = get(formValues, name);
  if (!mount || disabledFieldNames.has(name)) {
    return {};
  }
  const inputRef = refs ? refs[0] : ref;
  const setCustomValidity = (message2) => {
    if (shouldUseNativeValidation && inputRef.reportValidity) {
      inputRef.setCustomValidity(isBoolean(message2) ? "" : message2 || "");
      inputRef.reportValidity();
    }
  };
  const error2 = {};
  const isRadio = isRadioInput(ref);
  const isCheckBox = isCheckBoxInput(ref);
  const isRadioOrCheckbox2 = isRadio || isCheckBox;
  const isEmpty = (valueAsNumber || isFileInput(ref)) && isUndefined(ref.value) && isUndefined(inputValue) || isHTMLElement(ref) && ref.value === "" || inputValue === "" || Array.isArray(inputValue) && !inputValue.length;
  const appendErrorsCurry = appendErrors.bind(null, name, validateAllFieldCriteria, error2);
  const getMinMaxMessage = (exceedMax, maxLengthMessage, minLengthMessage, maxType = INPUT_VALIDATION_RULES.maxLength, minType = INPUT_VALIDATION_RULES.minLength) => {
    const message2 = exceedMax ? maxLengthMessage : minLengthMessage;
    error2[name] = {
      type: exceedMax ? maxType : minType,
      message: message2,
      ref,
      ...appendErrorsCurry(exceedMax ? maxType : minType, message2)
    };
  };
  if (isFieldArray ? !Array.isArray(inputValue) || !inputValue.length : required && (!isRadioOrCheckbox2 && (isEmpty || isNullOrUndefined(inputValue)) || isBoolean(inputValue) && !inputValue || isCheckBox && !getCheckboxValue(refs).isValid || isRadio && !getRadioValue(refs).isValid)) {
    const { value, message: message2 } = isMessage(required) ? { value: !!required, message: required } : getValueAndMessage(required);
    if (value) {
      error2[name] = {
        type: INPUT_VALIDATION_RULES.required,
        message: message2,
        ref: inputRef,
        ...appendErrorsCurry(INPUT_VALIDATION_RULES.required, message2)
      };
      if (!validateAllFieldCriteria) {
        setCustomValidity(message2);
        return error2;
      }
    }
  }
  if (!isEmpty && (!isNullOrUndefined(min) || !isNullOrUndefined(max))) {
    let exceedMax;
    let exceedMin;
    const maxOutput = getValueAndMessage(max);
    const minOutput = getValueAndMessage(min);
    if (!isNullOrUndefined(inputValue) && !isNaN(inputValue)) {
      const valueNumber = ref.valueAsNumber || (inputValue ? +inputValue : inputValue);
      if (!isNullOrUndefined(maxOutput.value)) {
        exceedMax = valueNumber > maxOutput.value;
      }
      if (!isNullOrUndefined(minOutput.value)) {
        exceedMin = valueNumber < minOutput.value;
      }
    } else {
      const valueDate = ref.valueAsDate || new Date(inputValue);
      const convertTimeToDate = (time) => /* @__PURE__ */ new Date((/* @__PURE__ */ new Date()).toDateString() + " " + time);
      const isTime = ref.type == "time";
      const isWeek = ref.type == "week";
      if (isString(maxOutput.value) && inputValue) {
        exceedMax = isTime ? convertTimeToDate(inputValue) > convertTimeToDate(maxOutput.value) : isWeek ? inputValue > maxOutput.value : valueDate > new Date(maxOutput.value);
      }
      if (isString(minOutput.value) && inputValue) {
        exceedMin = isTime ? convertTimeToDate(inputValue) < convertTimeToDate(minOutput.value) : isWeek ? inputValue < minOutput.value : valueDate < new Date(minOutput.value);
      }
    }
    if (exceedMax || exceedMin) {
      getMinMaxMessage(!!exceedMax, maxOutput.message, minOutput.message, INPUT_VALIDATION_RULES.max, INPUT_VALIDATION_RULES.min);
      if (!validateAllFieldCriteria) {
        setCustomValidity(error2[name].message);
        return error2;
      }
    }
  }
  if ((maxLength || minLength) && !isEmpty && (isString(inputValue) || isFieldArray && Array.isArray(inputValue))) {
    const maxLengthOutput = getValueAndMessage(maxLength);
    const minLengthOutput = getValueAndMessage(minLength);
    const exceedMax = !isNullOrUndefined(maxLengthOutput.value) && inputValue.length > +maxLengthOutput.value;
    const exceedMin = !isNullOrUndefined(minLengthOutput.value) && inputValue.length < +minLengthOutput.value;
    if (exceedMax || exceedMin) {
      getMinMaxMessage(exceedMax, maxLengthOutput.message, minLengthOutput.message);
      if (!validateAllFieldCriteria) {
        setCustomValidity(error2[name].message);
        return error2;
      }
    }
  }
  if (pattern && !isEmpty && isString(inputValue)) {
    const { value: patternValue, message: message2 } = getValueAndMessage(pattern);
    if (isRegex(patternValue) && !inputValue.match(patternValue)) {
      error2[name] = {
        type: INPUT_VALIDATION_RULES.pattern,
        message: message2,
        ref,
        ...appendErrorsCurry(INPUT_VALIDATION_RULES.pattern, message2)
      };
      if (!validateAllFieldCriteria) {
        setCustomValidity(message2);
        return error2;
      }
    }
  }
  if (validate) {
    if (isFunction(validate)) {
      const result = await validate(inputValue, formValues);
      const validateError = getValidateError(result, inputRef);
      if (validateError) {
        error2[name] = {
          ...validateError,
          ...appendErrorsCurry(INPUT_VALIDATION_RULES.validate, validateError.message)
        };
        if (!validateAllFieldCriteria) {
          setCustomValidity(validateError.message);
          return error2;
        }
      }
    } else if (isObject(validate)) {
      let validationResult = {};
      for (const key in validate) {
        if (!isEmptyObject(validationResult) && !validateAllFieldCriteria) {
          break;
        }
        const validateError = getValidateError(await validate[key](inputValue, formValues), inputRef, key);
        if (validateError) {
          validationResult = {
            ...validateError,
            ...appendErrorsCurry(key, validateError.message)
          };
          setCustomValidity(validateError.message);
          if (validateAllFieldCriteria) {
            error2[name] = validationResult;
          }
        }
      }
      if (!isEmptyObject(validationResult)) {
        error2[name] = {
          ref: inputRef,
          ...validationResult
        };
        if (!validateAllFieldCriteria) {
          return error2;
        }
      }
    }
  }
  setCustomValidity(true);
  return error2;
};
function baseGet(object, updatePath) {
  const length = updatePath.slice(0, -1).length;
  let index = 0;
  while (index < length) {
    object = isUndefined(object) ? index++ : object[updatePath[index++]];
  }
  return object;
}
function isEmptyArray(obj) {
  for (const key in obj) {
    if (obj.hasOwnProperty(key) && !isUndefined(obj[key])) {
      return false;
    }
  }
  return true;
}
function unset(object, path) {
  const paths = Array.isArray(path) ? path : isKey(path) ? [path] : stringToPath(path);
  const childObject = paths.length === 1 ? object : baseGet(object, paths);
  const index = paths.length - 1;
  const key = paths[index];
  if (childObject) {
    delete childObject[key];
  }
  if (index !== 0 && (isObject(childObject) && isEmptyObject(childObject) || Array.isArray(childObject) && isEmptyArray(childObject))) {
    unset(object, paths.slice(0, -1));
  }
  return object;
}
var createSubject = () => {
  let _observers = [];
  const next = (value) => {
    for (const observer of _observers) {
      observer.next && observer.next(value);
    }
  };
  const subscribe = (observer) => {
    _observers.push(observer);
    return {
      unsubscribe: () => {
        _observers = _observers.filter((o) => o !== observer);
      }
    };
  };
  const unsubscribe = () => {
    _observers = [];
  };
  return {
    get observers() {
      return _observers;
    },
    next,
    subscribe,
    unsubscribe
  };
};
var isPrimitive = (value) => isNullOrUndefined(value) || !isObjectType(value);
function deepEqual(object1, object2) {
  if (isPrimitive(object1) || isPrimitive(object2)) {
    return object1 === object2;
  }
  if (isDateObject(object1) && isDateObject(object2)) {
    return object1.getTime() === object2.getTime();
  }
  const keys1 = Object.keys(object1);
  const keys2 = Object.keys(object2);
  if (keys1.length !== keys2.length) {
    return false;
  }
  for (const key of keys1) {
    const val1 = object1[key];
    if (!keys2.includes(key)) {
      return false;
    }
    if (key !== "ref") {
      const val2 = object2[key];
      if (isDateObject(val1) && isDateObject(val2) || isObject(val1) && isObject(val2) || Array.isArray(val1) && Array.isArray(val2) ? !deepEqual(val1, val2) : val1 !== val2) {
        return false;
      }
    }
  }
  return true;
}
var isMultipleSelect = (element) => element.type === `select-multiple`;
var isRadioOrCheckbox = (ref) => isRadioInput(ref) || isCheckBoxInput(ref);
var live = (ref) => isHTMLElement(ref) && ref.isConnected;
var objectHasFunction = (data) => {
  for (const key in data) {
    if (isFunction(data[key])) {
      return true;
    }
  }
  return false;
};
function markFieldsDirty(data, fields = {}) {
  const isParentNodeArray = Array.isArray(data);
  if (isObject(data) || isParentNodeArray) {
    for (const key in data) {
      if (Array.isArray(data[key]) || isObject(data[key]) && !objectHasFunction(data[key])) {
        fields[key] = Array.isArray(data[key]) ? [] : {};
        markFieldsDirty(data[key], fields[key]);
      } else if (!isNullOrUndefined(data[key])) {
        fields[key] = true;
      }
    }
  }
  return fields;
}
function getDirtyFieldsFromDefaultValues(data, formValues, dirtyFieldsFromValues) {
  const isParentNodeArray = Array.isArray(data);
  if (isObject(data) || isParentNodeArray) {
    for (const key in data) {
      if (Array.isArray(data[key]) || isObject(data[key]) && !objectHasFunction(data[key])) {
        if (isUndefined(formValues) || isPrimitive(dirtyFieldsFromValues[key])) {
          dirtyFieldsFromValues[key] = Array.isArray(data[key]) ? markFieldsDirty(data[key], []) : { ...markFieldsDirty(data[key]) };
        } else {
          getDirtyFieldsFromDefaultValues(data[key], isNullOrUndefined(formValues) ? {} : formValues[key], dirtyFieldsFromValues[key]);
        }
      } else {
        dirtyFieldsFromValues[key] = !deepEqual(data[key], formValues[key]);
      }
    }
  }
  return dirtyFieldsFromValues;
}
var getDirtyFields = (defaultValues, formValues) => getDirtyFieldsFromDefaultValues(defaultValues, formValues, markFieldsDirty(formValues));
var getFieldValueAs = (value, { valueAsNumber, valueAsDate, setValueAs }) => isUndefined(value) ? value : valueAsNumber ? value === "" ? NaN : value ? +value : value : valueAsDate && isString(value) ? new Date(value) : setValueAs ? setValueAs(value) : value;
function getFieldValue(_f) {
  const ref = _f.ref;
  if (isFileInput(ref)) {
    return ref.files;
  }
  if (isRadioInput(ref)) {
    return getRadioValue(_f.refs).value;
  }
  if (isMultipleSelect(ref)) {
    return [...ref.selectedOptions].map(({ value }) => value);
  }
  if (isCheckBoxInput(ref)) {
    return getCheckboxValue(_f.refs).value;
  }
  return getFieldValueAs(isUndefined(ref.value) ? _f.ref.value : ref.value, _f);
}
var getResolverOptions = (fieldsNames, _fields, criteriaMode, shouldUseNativeValidation) => {
  const fields = {};
  for (const name of fieldsNames) {
    const field = get(_fields, name);
    field && set(fields, name, field._f);
  }
  return {
    criteriaMode,
    names: [...fieldsNames],
    fields,
    shouldUseNativeValidation
  };
};
var getRuleValue = (rule) => isUndefined(rule) ? rule : isRegex(rule) ? rule.source : isObject(rule) ? isRegex(rule.value) ? rule.value.source : rule.value : rule;
const ASYNC_FUNCTION = "AsyncFunction";
var hasPromiseValidation = (fieldReference) => !!fieldReference && !!fieldReference.validate && !!(isFunction(fieldReference.validate) && fieldReference.validate.constructor.name === ASYNC_FUNCTION || isObject(fieldReference.validate) && Object.values(fieldReference.validate).find((validateFunction) => validateFunction.constructor.name === ASYNC_FUNCTION));
var hasValidation = (options) => options.mount && (options.required || options.min || options.max || options.maxLength || options.minLength || options.pattern || options.validate);
function schemaErrorLookup(errors, _fields, name) {
  const error2 = get(errors, name);
  if (error2 || isKey(name)) {
    return {
      error: error2,
      name
    };
  }
  const names = name.split(".");
  while (names.length) {
    const fieldName = names.join(".");
    const field = get(_fields, fieldName);
    const foundError = get(errors, fieldName);
    if (field && !Array.isArray(field) && name !== fieldName) {
      return { name };
    }
    if (foundError && foundError.type) {
      return {
        name: fieldName,
        error: foundError
      };
    }
    names.pop();
  }
  return {
    name
  };
}
var skipValidation = (isBlurEvent, isTouched, isSubmitted, reValidateMode, mode) => {
  if (mode.isOnAll) {
    return false;
  } else if (!isSubmitted && mode.isOnTouch) {
    return !(isTouched || isBlurEvent);
  } else if (isSubmitted ? reValidateMode.isOnBlur : mode.isOnBlur) {
    return !isBlurEvent;
  } else if (isSubmitted ? reValidateMode.isOnChange : mode.isOnChange) {
    return isBlurEvent;
  }
  return true;
};
var unsetEmptyArray = (ref, name) => !compact(get(ref, name)).length && unset(ref, name);
const defaultOptions = {
  mode: VALIDATION_MODE.onSubmit,
  reValidateMode: VALIDATION_MODE.onChange,
  shouldFocusError: true
};
function createFormControl(props = {}) {
  let _options = {
    ...defaultOptions,
    ...props
  };
  let _formState = {
    submitCount: 0,
    isDirty: false,
    isLoading: isFunction(_options.defaultValues),
    isValidating: false,
    isSubmitted: false,
    isSubmitting: false,
    isSubmitSuccessful: false,
    isValid: false,
    touchedFields: {},
    dirtyFields: {},
    validatingFields: {},
    errors: _options.errors || {},
    disabled: _options.disabled || false
  };
  let _fields = {};
  let _defaultValues = isObject(_options.defaultValues) || isObject(_options.values) ? cloneObject(_options.defaultValues || _options.values) || {} : {};
  let _formValues = _options.shouldUnregister ? {} : cloneObject(_defaultValues);
  let _state = {
    action: false,
    mount: false,
    watch: false
  };
  let _names = {
    mount: /* @__PURE__ */ new Set(),
    disabled: /* @__PURE__ */ new Set(),
    unMount: /* @__PURE__ */ new Set(),
    array: /* @__PURE__ */ new Set(),
    watch: /* @__PURE__ */ new Set()
  };
  let delayErrorCallback;
  let timer = 0;
  const _proxyFormState = {
    isDirty: false,
    dirtyFields: false,
    validatingFields: false,
    touchedFields: false,
    isValidating: false,
    isValid: false,
    errors: false
  };
  const _subjects = {
    values: createSubject(),
    array: createSubject(),
    state: createSubject()
  };
  const validationModeBeforeSubmit = getValidationModes(_options.mode);
  const validationModeAfterSubmit = getValidationModes(_options.reValidateMode);
  const shouldDisplayAllAssociatedErrors = _options.criteriaMode === VALIDATION_MODE.all;
  const debounce = (callback) => (wait) => {
    clearTimeout(timer);
    timer = setTimeout(callback, wait);
  };
  const _updateValid = async (shouldUpdateValid) => {
    if (!_options.disabled && (_proxyFormState.isValid || shouldUpdateValid)) {
      const isValid = _options.resolver ? isEmptyObject((await _executeSchema()).errors) : await executeBuiltInValidation(_fields, true);
      if (isValid !== _formState.isValid) {
        _subjects.state.next({
          isValid
        });
      }
    }
  };
  const _updateIsValidating = (names, isValidating) => {
    if (!_options.disabled && (_proxyFormState.isValidating || _proxyFormState.validatingFields)) {
      (names || Array.from(_names.mount)).forEach((name) => {
        if (name) {
          isValidating ? set(_formState.validatingFields, name, isValidating) : unset(_formState.validatingFields, name);
        }
      });
      _subjects.state.next({
        validatingFields: _formState.validatingFields,
        isValidating: !isEmptyObject(_formState.validatingFields)
      });
    }
  };
  const _updateFieldArray = (name, values = [], method, args, shouldSetValues = true, shouldUpdateFieldsAndState = true) => {
    if (args && method && !_options.disabled) {
      _state.action = true;
      if (shouldUpdateFieldsAndState && Array.isArray(get(_fields, name))) {
        const fieldValues = method(get(_fields, name), args.argA, args.argB);
        shouldSetValues && set(_fields, name, fieldValues);
      }
      if (shouldUpdateFieldsAndState && Array.isArray(get(_formState.errors, name))) {
        const errors = method(get(_formState.errors, name), args.argA, args.argB);
        shouldSetValues && set(_formState.errors, name, errors);
        unsetEmptyArray(_formState.errors, name);
      }
      if (_proxyFormState.touchedFields && shouldUpdateFieldsAndState && Array.isArray(get(_formState.touchedFields, name))) {
        const touchedFields = method(get(_formState.touchedFields, name), args.argA, args.argB);
        shouldSetValues && set(_formState.touchedFields, name, touchedFields);
      }
      if (_proxyFormState.dirtyFields) {
        _formState.dirtyFields = getDirtyFields(_defaultValues, _formValues);
      }
      _subjects.state.next({
        name,
        isDirty: _getDirty(name, values),
        dirtyFields: _formState.dirtyFields,
        errors: _formState.errors,
        isValid: _formState.isValid
      });
    } else {
      set(_formValues, name, values);
    }
  };
  const updateErrors = (name, error2) => {
    set(_formState.errors, name, error2);
    _subjects.state.next({
      errors: _formState.errors
    });
  };
  const _setErrors = (errors) => {
    _formState.errors = errors;
    _subjects.state.next({
      errors: _formState.errors,
      isValid: false
    });
  };
  const updateValidAndValue = (name, shouldSkipSetValueAs, value, ref) => {
    const field = get(_fields, name);
    if (field) {
      const defaultValue = get(_formValues, name, isUndefined(value) ? get(_defaultValues, name) : value);
      isUndefined(defaultValue) || ref && ref.defaultChecked || shouldSkipSetValueAs ? set(_formValues, name, shouldSkipSetValueAs ? defaultValue : getFieldValue(field._f)) : setFieldValue(name, defaultValue);
      _state.mount && _updateValid();
    }
  };
  const updateTouchAndDirty = (name, fieldValue, isBlurEvent, shouldDirty, shouldRender) => {
    let shouldUpdateField = false;
    let isPreviousDirty = false;
    const output = {
      name
    };
    if (!_options.disabled) {
      const disabledField = !!(get(_fields, name) && get(_fields, name)._f && get(_fields, name)._f.disabled);
      if (!isBlurEvent || shouldDirty) {
        if (_proxyFormState.isDirty) {
          isPreviousDirty = _formState.isDirty;
          _formState.isDirty = output.isDirty = _getDirty();
          shouldUpdateField = isPreviousDirty !== output.isDirty;
        }
        const isCurrentFieldPristine = disabledField || deepEqual(get(_defaultValues, name), fieldValue);
        isPreviousDirty = !!(!disabledField && get(_formState.dirtyFields, name));
        isCurrentFieldPristine || disabledField ? unset(_formState.dirtyFields, name) : set(_formState.dirtyFields, name, true);
        output.dirtyFields = _formState.dirtyFields;
        shouldUpdateField = shouldUpdateField || _proxyFormState.dirtyFields && isPreviousDirty !== !isCurrentFieldPristine;
      }
      if (isBlurEvent) {
        const isPreviousFieldTouched = get(_formState.touchedFields, name);
        if (!isPreviousFieldTouched) {
          set(_formState.touchedFields, name, isBlurEvent);
          output.touchedFields = _formState.touchedFields;
          shouldUpdateField = shouldUpdateField || _proxyFormState.touchedFields && isPreviousFieldTouched !== isBlurEvent;
        }
      }
      shouldUpdateField && shouldRender && _subjects.state.next(output);
    }
    return shouldUpdateField ? output : {};
  };
  const shouldRenderByError = (name, isValid, error2, fieldState) => {
    const previousFieldError = get(_formState.errors, name);
    const shouldUpdateValid = _proxyFormState.isValid && isBoolean(isValid) && _formState.isValid !== isValid;
    if (_options.delayError && error2) {
      delayErrorCallback = debounce(() => updateErrors(name, error2));
      delayErrorCallback(_options.delayError);
    } else {
      clearTimeout(timer);
      delayErrorCallback = null;
      error2 ? set(_formState.errors, name, error2) : unset(_formState.errors, name);
    }
    if ((error2 ? !deepEqual(previousFieldError, error2) : previousFieldError) || !isEmptyObject(fieldState) || shouldUpdateValid) {
      const updatedFormState = {
        ...fieldState,
        ...shouldUpdateValid && isBoolean(isValid) ? { isValid } : {},
        errors: _formState.errors,
        name
      };
      _formState = {
        ..._formState,
        ...updatedFormState
      };
      _subjects.state.next(updatedFormState);
    }
  };
  const _executeSchema = async (name) => {
    _updateIsValidating(name, true);
    const result = await _options.resolver(_formValues, _options.context, getResolverOptions(name || _names.mount, _fields, _options.criteriaMode, _options.shouldUseNativeValidation));
    _updateIsValidating(name);
    return result;
  };
  const executeSchemaAndUpdateState = async (names) => {
    const { errors } = await _executeSchema(names);
    if (names) {
      for (const name of names) {
        const error2 = get(errors, name);
        error2 ? set(_formState.errors, name, error2) : unset(_formState.errors, name);
      }
    } else {
      _formState.errors = errors;
    }
    return errors;
  };
  const executeBuiltInValidation = async (fields, shouldOnlyCheckValid, context = {
    valid: true
  }) => {
    for (const name in fields) {
      const field = fields[name];
      if (field) {
        const { _f, ...fieldValue } = field;
        if (_f) {
          const isFieldArrayRoot = _names.array.has(_f.name);
          const isPromiseFunction = field._f && hasPromiseValidation(field._f);
          if (isPromiseFunction && _proxyFormState.validatingFields) {
            _updateIsValidating([name], true);
          }
          const fieldError = await validateField(field, _names.disabled, _formValues, shouldDisplayAllAssociatedErrors, _options.shouldUseNativeValidation && !shouldOnlyCheckValid, isFieldArrayRoot);
          if (isPromiseFunction && _proxyFormState.validatingFields) {
            _updateIsValidating([name]);
          }
          if (fieldError[_f.name]) {
            context.valid = false;
            if (shouldOnlyCheckValid) {
              break;
            }
          }
          !shouldOnlyCheckValid && (get(fieldError, _f.name) ? isFieldArrayRoot ? updateFieldArrayRootError(_formState.errors, fieldError, _f.name) : set(_formState.errors, _f.name, fieldError[_f.name]) : unset(_formState.errors, _f.name));
        }
        !isEmptyObject(fieldValue) && await executeBuiltInValidation(fieldValue, shouldOnlyCheckValid, context);
      }
    }
    return context.valid;
  };
  const _removeUnmounted = () => {
    for (const name of _names.unMount) {
      const field = get(_fields, name);
      field && (field._f.refs ? field._f.refs.every((ref) => !live(ref)) : !live(field._f.ref)) && unregister(name);
    }
    _names.unMount = /* @__PURE__ */ new Set();
  };
  const _getDirty = (name, data) => !_options.disabled && (name && data && set(_formValues, name, data), !deepEqual(getValues(), _defaultValues));
  const _getWatch = (names, defaultValue, isGlobal) => generateWatchOutput(names, _names, {
    ..._state.mount ? _formValues : isUndefined(defaultValue) ? _defaultValues : isString(names) ? { [names]: defaultValue } : defaultValue
  }, isGlobal, defaultValue);
  const _getFieldArray = (name) => compact(get(_state.mount ? _formValues : _defaultValues, name, _options.shouldUnregister ? get(_defaultValues, name, []) : []));
  const setFieldValue = (name, value, options = {}) => {
    const field = get(_fields, name);
    let fieldValue = value;
    if (field) {
      const fieldReference = field._f;
      if (fieldReference) {
        !fieldReference.disabled && set(_formValues, name, getFieldValueAs(value, fieldReference));
        fieldValue = isHTMLElement(fieldReference.ref) && isNullOrUndefined(value) ? "" : value;
        if (isMultipleSelect(fieldReference.ref)) {
          [...fieldReference.ref.options].forEach((optionRef) => optionRef.selected = fieldValue.includes(optionRef.value));
        } else if (fieldReference.refs) {
          if (isCheckBoxInput(fieldReference.ref)) {
            fieldReference.refs.length > 1 ? fieldReference.refs.forEach((checkboxRef) => (!checkboxRef.defaultChecked || !checkboxRef.disabled) && (checkboxRef.checked = Array.isArray(fieldValue) ? !!fieldValue.find((data) => data === checkboxRef.value) : fieldValue === checkboxRef.value)) : fieldReference.refs[0] && (fieldReference.refs[0].checked = !!fieldValue);
          } else {
            fieldReference.refs.forEach((radioRef) => radioRef.checked = radioRef.value === fieldValue);
          }
        } else if (isFileInput(fieldReference.ref)) {
          fieldReference.ref.value = "";
        } else {
          fieldReference.ref.value = fieldValue;
          if (!fieldReference.ref.type) {
            _subjects.values.next({
              name,
              values: { ..._formValues }
            });
          }
        }
      }
    }
    (options.shouldDirty || options.shouldTouch) && updateTouchAndDirty(name, fieldValue, options.shouldTouch, options.shouldDirty, true);
    options.shouldValidate && trigger(name);
  };
  const setValues = (name, value, options) => {
    for (const fieldKey in value) {
      const fieldValue = value[fieldKey];
      const fieldName = `${name}.${fieldKey}`;
      const field = get(_fields, fieldName);
      (_names.array.has(name) || isObject(fieldValue) || field && !field._f) && !isDateObject(fieldValue) ? setValues(fieldName, fieldValue, options) : setFieldValue(fieldName, fieldValue, options);
    }
  };
  const setValue = (name, value, options = {}) => {
    const field = get(_fields, name);
    const isFieldArray = _names.array.has(name);
    const cloneValue = cloneObject(value);
    set(_formValues, name, cloneValue);
    if (isFieldArray) {
      _subjects.array.next({
        name,
        values: { ..._formValues }
      });
      if ((_proxyFormState.isDirty || _proxyFormState.dirtyFields) && options.shouldDirty) {
        _subjects.state.next({
          name,
          dirtyFields: getDirtyFields(_defaultValues, _formValues),
          isDirty: _getDirty(name, cloneValue)
        });
      }
    } else {
      field && !field._f && !isNullOrUndefined(cloneValue) ? setValues(name, cloneValue, options) : setFieldValue(name, cloneValue, options);
    }
    isWatched(name, _names) && _subjects.state.next({ ..._formState });
    _subjects.values.next({
      name: _state.mount ? name : void 0,
      values: { ..._formValues }
    });
  };
  const onChange = async (event) => {
    _state.mount = true;
    const target = event.target;
    let name = target.name;
    let isFieldValueUpdated = true;
    const field = get(_fields, name);
    const getCurrentFieldValue = () => target.type ? getFieldValue(field._f) : getEventValue(event);
    const _updateIsFieldValueUpdated = (fieldValue) => {
      isFieldValueUpdated = Number.isNaN(fieldValue) || isDateObject(fieldValue) && isNaN(fieldValue.getTime()) || deepEqual(fieldValue, get(_formValues, name, fieldValue));
    };
    if (field) {
      let error2;
      let isValid;
      const fieldValue = getCurrentFieldValue();
      const isBlurEvent = event.type === EVENTS.BLUR || event.type === EVENTS.FOCUS_OUT;
      const shouldSkipValidation = !hasValidation(field._f) && !_options.resolver && !get(_formState.errors, name) && !field._f.deps || skipValidation(isBlurEvent, get(_formState.touchedFields, name), _formState.isSubmitted, validationModeAfterSubmit, validationModeBeforeSubmit);
      const watched = isWatched(name, _names, isBlurEvent);
      set(_formValues, name, fieldValue);
      if (isBlurEvent) {
        field._f.onBlur && field._f.onBlur(event);
        delayErrorCallback && delayErrorCallback(0);
      } else if (field._f.onChange) {
        field._f.onChange(event);
      }
      const fieldState = updateTouchAndDirty(name, fieldValue, isBlurEvent, false);
      const shouldRender = !isEmptyObject(fieldState) || watched;
      !isBlurEvent && _subjects.values.next({
        name,
        type: event.type,
        values: { ..._formValues }
      });
      if (shouldSkipValidation) {
        if (_proxyFormState.isValid) {
          if (_options.mode === "onBlur" && isBlurEvent) {
            _updateValid();
          } else if (!isBlurEvent) {
            _updateValid();
          }
        }
        return shouldRender && _subjects.state.next({ name, ...watched ? {} : fieldState });
      }
      !isBlurEvent && watched && _subjects.state.next({ ..._formState });
      if (_options.resolver) {
        const { errors } = await _executeSchema([name]);
        _updateIsFieldValueUpdated(fieldValue);
        if (isFieldValueUpdated) {
          const previousErrorLookupResult = schemaErrorLookup(_formState.errors, _fields, name);
          const errorLookupResult = schemaErrorLookup(errors, _fields, previousErrorLookupResult.name || name);
          error2 = errorLookupResult.error;
          name = errorLookupResult.name;
          isValid = isEmptyObject(errors);
        }
      } else {
        _updateIsValidating([name], true);
        error2 = (await validateField(field, _names.disabled, _formValues, shouldDisplayAllAssociatedErrors, _options.shouldUseNativeValidation))[name];
        _updateIsValidating([name]);
        _updateIsFieldValueUpdated(fieldValue);
        if (isFieldValueUpdated) {
          if (error2) {
            isValid = false;
          } else if (_proxyFormState.isValid) {
            isValid = await executeBuiltInValidation(_fields, true);
          }
        }
      }
      if (isFieldValueUpdated) {
        field._f.deps && trigger(field._f.deps);
        shouldRenderByError(name, isValid, error2, fieldState);
      }
    }
  };
  const _focusInput = (ref, key) => {
    if (get(_formState.errors, key) && ref.focus) {
      ref.focus();
      return 1;
    }
    return;
  };
  const trigger = async (name, options = {}) => {
    let isValid;
    let validationResult;
    const fieldNames = convertToArrayPayload(name);
    if (_options.resolver) {
      const errors = await executeSchemaAndUpdateState(isUndefined(name) ? name : fieldNames);
      isValid = isEmptyObject(errors);
      validationResult = name ? !fieldNames.some((name2) => get(errors, name2)) : isValid;
    } else if (name) {
      validationResult = (await Promise.all(fieldNames.map(async (fieldName) => {
        const field = get(_fields, fieldName);
        return await executeBuiltInValidation(field && field._f ? { [fieldName]: field } : field);
      }))).every(Boolean);
      !(!validationResult && !_formState.isValid) && _updateValid();
    } else {
      validationResult = isValid = await executeBuiltInValidation(_fields);
    }
    _subjects.state.next({
      ...!isString(name) || _proxyFormState.isValid && isValid !== _formState.isValid ? {} : { name },
      ..._options.resolver || !name ? { isValid } : {},
      errors: _formState.errors
    });
    options.shouldFocus && !validationResult && iterateFieldsByAction(_fields, _focusInput, name ? fieldNames : _names.mount);
    return validationResult;
  };
  const getValues = (fieldNames) => {
    const values = {
      ..._state.mount ? _formValues : _defaultValues
    };
    return isUndefined(fieldNames) ? values : isString(fieldNames) ? get(values, fieldNames) : fieldNames.map((name) => get(values, name));
  };
  const getFieldState = (name, formState) => ({
    invalid: !!get((formState || _formState).errors, name),
    isDirty: !!get((formState || _formState).dirtyFields, name),
    error: get((formState || _formState).errors, name),
    isValidating: !!get(_formState.validatingFields, name),
    isTouched: !!get((formState || _formState).touchedFields, name)
  });
  const clearErrors = (name) => {
    name && convertToArrayPayload(name).forEach((inputName) => unset(_formState.errors, inputName));
    _subjects.state.next({
      errors: name ? _formState.errors : {}
    });
  };
  const setError = (name, error2, options) => {
    const ref = (get(_fields, name, { _f: {} })._f || {}).ref;
    const currentError = get(_formState.errors, name) || {};
    const { ref: currentRef, message: message2, type, ...restOfErrorTree } = currentError;
    set(_formState.errors, name, {
      ...restOfErrorTree,
      ...error2,
      ref
    });
    _subjects.state.next({
      name,
      errors: _formState.errors,
      isValid: false
    });
    options && options.shouldFocus && ref && ref.focus && ref.focus();
  };
  const watch = (name, defaultValue) => isFunction(name) ? _subjects.values.subscribe({
    next: (payload) => name(_getWatch(void 0, defaultValue), payload)
  }) : _getWatch(name, defaultValue, true);
  const unregister = (name, options = {}) => {
    for (const fieldName of name ? convertToArrayPayload(name) : _names.mount) {
      _names.mount.delete(fieldName);
      _names.array.delete(fieldName);
      if (!options.keepValue) {
        unset(_fields, fieldName);
        unset(_formValues, fieldName);
      }
      !options.keepError && unset(_formState.errors, fieldName);
      !options.keepDirty && unset(_formState.dirtyFields, fieldName);
      !options.keepTouched && unset(_formState.touchedFields, fieldName);
      !options.keepIsValidating && unset(_formState.validatingFields, fieldName);
      !_options.shouldUnregister && !options.keepDefaultValue && unset(_defaultValues, fieldName);
    }
    _subjects.values.next({
      values: { ..._formValues }
    });
    _subjects.state.next({
      ..._formState,
      ...!options.keepDirty ? {} : { isDirty: _getDirty() }
    });
    !options.keepIsValid && _updateValid();
  };
  const _updateDisabledField = ({ disabled, name, field, fields }) => {
    if (isBoolean(disabled) && _state.mount || !!disabled || _names.disabled.has(name)) {
      disabled ? _names.disabled.add(name) : _names.disabled.delete(name);
      updateTouchAndDirty(name, getFieldValue(field ? field._f : get(fields, name)._f), false, false, true);
    }
  };
  const register = (name, options = {}) => {
    let field = get(_fields, name);
    const disabledIsDefined = isBoolean(options.disabled) || isBoolean(_options.disabled);
    set(_fields, name, {
      ...field || {},
      _f: {
        ...field && field._f ? field._f : { ref: { name } },
        name,
        mount: true,
        ...options
      }
    });
    _names.mount.add(name);
    if (field) {
      _updateDisabledField({
        field,
        disabled: isBoolean(options.disabled) ? options.disabled : _options.disabled,
        name
      });
    } else {
      updateValidAndValue(name, true, options.value);
    }
    return {
      ...disabledIsDefined ? { disabled: options.disabled || _options.disabled } : {},
      ..._options.progressive ? {
        required: !!options.required,
        min: getRuleValue(options.min),
        max: getRuleValue(options.max),
        minLength: getRuleValue(options.minLength),
        maxLength: getRuleValue(options.maxLength),
        pattern: getRuleValue(options.pattern)
      } : {},
      name,
      onChange,
      onBlur: onChange,
      ref: (ref) => {
        if (ref) {
          register(name, options);
          field = get(_fields, name);
          const fieldRef = isUndefined(ref.value) ? ref.querySelectorAll ? ref.querySelectorAll("input,select,textarea")[0] || ref : ref : ref;
          const radioOrCheckbox = isRadioOrCheckbox(fieldRef);
          const refs = field._f.refs || [];
          if (radioOrCheckbox ? refs.find((option2) => option2 === fieldRef) : fieldRef === field._f.ref) {
            return;
          }
          set(_fields, name, {
            _f: {
              ...field._f,
              ...radioOrCheckbox ? {
                refs: [
                  ...refs.filter(live),
                  fieldRef,
                  ...Array.isArray(get(_defaultValues, name)) ? [{}] : []
                ],
                ref: { type: fieldRef.type, name }
              } : { ref: fieldRef }
            }
          });
          updateValidAndValue(name, false, void 0, fieldRef);
        } else {
          field = get(_fields, name, {});
          if (field._f) {
            field._f.mount = false;
          }
          (_options.shouldUnregister || options.shouldUnregister) && !(isNameInFieldArray(_names.array, name) && _state.action) && _names.unMount.add(name);
        }
      }
    };
  };
  const _focusError = () => _options.shouldFocusError && iterateFieldsByAction(_fields, _focusInput, _names.mount);
  const _disableForm = (disabled) => {
    if (isBoolean(disabled)) {
      _subjects.state.next({ disabled });
      iterateFieldsByAction(_fields, (ref, name) => {
        const currentField = get(_fields, name);
        if (currentField) {
          ref.disabled = currentField._f.disabled || disabled;
          if (Array.isArray(currentField._f.refs)) {
            currentField._f.refs.forEach((inputRef) => {
              inputRef.disabled = currentField._f.disabled || disabled;
            });
          }
        }
      }, 0, false);
    }
  };
  const handleSubmit = (onValid, onInvalid) => async (e) => {
    let onValidError = void 0;
    if (e) {
      e.preventDefault && e.preventDefault();
      e.persist && e.persist();
    }
    let fieldValues = cloneObject(_formValues);
    if (_names.disabled.size) {
      for (const name of _names.disabled) {
        set(fieldValues, name, void 0);
      }
    }
    _subjects.state.next({
      isSubmitting: true
    });
    if (_options.resolver) {
      const { errors, values } = await _executeSchema();
      _formState.errors = errors;
      fieldValues = values;
    } else {
      await executeBuiltInValidation(_fields);
    }
    unset(_formState.errors, "root");
    if (isEmptyObject(_formState.errors)) {
      _subjects.state.next({
        errors: {}
      });
      try {
        await onValid(fieldValues, e);
      } catch (error2) {
        onValidError = error2;
      }
    } else {
      if (onInvalid) {
        await onInvalid({ ..._formState.errors }, e);
      }
      _focusError();
      setTimeout(_focusError);
    }
    _subjects.state.next({
      isSubmitted: true,
      isSubmitting: false,
      isSubmitSuccessful: isEmptyObject(_formState.errors) && !onValidError,
      submitCount: _formState.submitCount + 1,
      errors: _formState.errors
    });
    if (onValidError) {
      throw onValidError;
    }
  };
  const resetField = (name, options = {}) => {
    if (get(_fields, name)) {
      if (isUndefined(options.defaultValue)) {
        setValue(name, cloneObject(get(_defaultValues, name)));
      } else {
        setValue(name, options.defaultValue);
        set(_defaultValues, name, cloneObject(options.defaultValue));
      }
      if (!options.keepTouched) {
        unset(_formState.touchedFields, name);
      }
      if (!options.keepDirty) {
        unset(_formState.dirtyFields, name);
        _formState.isDirty = options.defaultValue ? _getDirty(name, cloneObject(get(_defaultValues, name))) : _getDirty();
      }
      if (!options.keepError) {
        unset(_formState.errors, name);
        _proxyFormState.isValid && _updateValid();
      }
      _subjects.state.next({ ..._formState });
    }
  };
  const _reset = (formValues, keepStateOptions = {}) => {
    const updatedValues = formValues ? cloneObject(formValues) : _defaultValues;
    const cloneUpdatedValues = cloneObject(updatedValues);
    const isEmptyResetValues = isEmptyObject(formValues);
    const values = isEmptyResetValues ? _defaultValues : cloneUpdatedValues;
    if (!keepStateOptions.keepDefaultValues) {
      _defaultValues = updatedValues;
    }
    if (!keepStateOptions.keepValues) {
      if (keepStateOptions.keepDirtyValues) {
        const fieldsToCheck = /* @__PURE__ */ new Set([
          ..._names.mount,
          ...Object.keys(getDirtyFields(_defaultValues, _formValues))
        ]);
        for (const fieldName of Array.from(fieldsToCheck)) {
          get(_formState.dirtyFields, fieldName) ? set(values, fieldName, get(_formValues, fieldName)) : setValue(fieldName, get(values, fieldName));
        }
      } else {
        if (isWeb && isUndefined(formValues)) {
          for (const name of _names.mount) {
            const field = get(_fields, name);
            if (field && field._f) {
              const fieldReference = Array.isArray(field._f.refs) ? field._f.refs[0] : field._f.ref;
              if (isHTMLElement(fieldReference)) {
                const form2 = fieldReference.closest("form");
                if (form2) {
                  form2.reset();
                  break;
                }
              }
            }
          }
        }
        _fields = {};
      }
      _formValues = _options.shouldUnregister ? keepStateOptions.keepDefaultValues ? cloneObject(_defaultValues) : {} : cloneObject(values);
      _subjects.array.next({
        values: { ...values }
      });
      _subjects.values.next({
        values: { ...values }
      });
    }
    _names = {
      mount: keepStateOptions.keepDirtyValues ? _names.mount : /* @__PURE__ */ new Set(),
      unMount: /* @__PURE__ */ new Set(),
      array: /* @__PURE__ */ new Set(),
      disabled: /* @__PURE__ */ new Set(),
      watch: /* @__PURE__ */ new Set(),
      watchAll: false,
      focus: ""
    };
    _state.mount = !_proxyFormState.isValid || !!keepStateOptions.keepIsValid || !!keepStateOptions.keepDirtyValues;
    _state.watch = !!_options.shouldUnregister;
    _subjects.state.next({
      submitCount: keepStateOptions.keepSubmitCount ? _formState.submitCount : 0,
      isDirty: isEmptyResetValues ? false : keepStateOptions.keepDirty ? _formState.isDirty : !!(keepStateOptions.keepDefaultValues && !deepEqual(formValues, _defaultValues)),
      isSubmitted: keepStateOptions.keepIsSubmitted ? _formState.isSubmitted : false,
      dirtyFields: isEmptyResetValues ? {} : keepStateOptions.keepDirtyValues ? keepStateOptions.keepDefaultValues && _formValues ? getDirtyFields(_defaultValues, _formValues) : _formState.dirtyFields : keepStateOptions.keepDefaultValues && formValues ? getDirtyFields(_defaultValues, formValues) : keepStateOptions.keepDirty ? _formState.dirtyFields : {},
      touchedFields: keepStateOptions.keepTouched ? _formState.touchedFields : {},
      errors: keepStateOptions.keepErrors ? _formState.errors : {},
      isSubmitSuccessful: keepStateOptions.keepIsSubmitSuccessful ? _formState.isSubmitSuccessful : false,
      isSubmitting: false
    });
  };
  const reset = (formValues, keepStateOptions) => _reset(isFunction(formValues) ? formValues(_formValues) : formValues, keepStateOptions);
  const setFocus = (name, options = {}) => {
    const field = get(_fields, name);
    const fieldReference = field && field._f;
    if (fieldReference) {
      const fieldRef = fieldReference.refs ? fieldReference.refs[0] : fieldReference.ref;
      if (fieldRef.focus) {
        fieldRef.focus();
        options.shouldSelect && isFunction(fieldRef.select) && fieldRef.select();
      }
    }
  };
  const _updateFormState = (updatedFormState) => {
    _formState = {
      ..._formState,
      ...updatedFormState
    };
  };
  const _resetDefaultValues = () => isFunction(_options.defaultValues) && _options.defaultValues().then((values) => {
    reset(values, _options.resetOptions);
    _subjects.state.next({
      isLoading: false
    });
  });
  return {
    control: {
      register,
      unregister,
      getFieldState,
      handleSubmit,
      setError,
      _executeSchema,
      _getWatch,
      _getDirty,
      _updateValid,
      _removeUnmounted,
      _updateFieldArray,
      _updateDisabledField,
      _getFieldArray,
      _reset,
      _resetDefaultValues,
      _updateFormState,
      _disableForm,
      _subjects,
      _proxyFormState,
      _setErrors,
      get _fields() {
        return _fields;
      },
      get _formValues() {
        return _formValues;
      },
      get _state() {
        return _state;
      },
      set _state(value) {
        _state = value;
      },
      get _defaultValues() {
        return _defaultValues;
      },
      get _names() {
        return _names;
      },
      set _names(value) {
        _names = value;
      },
      get _formState() {
        return _formState;
      },
      set _formState(value) {
        _formState = value;
      },
      get _options() {
        return _options;
      },
      set _options(value) {
        _options = {
          ..._options,
          ...value
        };
      }
    },
    trigger,
    register,
    handleSubmit,
    watch,
    setValue,
    getValues,
    reset,
    resetField,
    clearErrors,
    unregister,
    setError,
    setFocus,
    getFieldState
  };
}
function useForm(props = {}) {
  const _formControl = React.useRef(void 0);
  const _values = React.useRef(void 0);
  const [formState, updateFormState] = React.useState({
    isDirty: false,
    isValidating: false,
    isLoading: isFunction(props.defaultValues),
    isSubmitted: false,
    isSubmitting: false,
    isSubmitSuccessful: false,
    isValid: false,
    submitCount: 0,
    dirtyFields: {},
    touchedFields: {},
    validatingFields: {},
    errors: props.errors || {},
    disabled: props.disabled || false,
    defaultValues: isFunction(props.defaultValues) ? void 0 : props.defaultValues
  });
  if (!_formControl.current) {
    _formControl.current = {
      ...createFormControl(props),
      formState
    };
  }
  const control = _formControl.current.control;
  control._options = props;
  useSubscribe({
    subject: control._subjects.state,
    next: (value) => {
      if (shouldRenderFormState(value, control._proxyFormState, control._updateFormState)) {
        updateFormState({ ...control._formState });
      }
    }
  });
  React.useEffect(() => control._disableForm(props.disabled), [control, props.disabled]);
  React.useEffect(() => {
    if (control._proxyFormState.isDirty) {
      const isDirty = control._getDirty();
      if (isDirty !== formState.isDirty) {
        control._subjects.state.next({
          isDirty
        });
      }
    }
  }, [control, formState.isDirty]);
  React.useEffect(() => {
    if (props.values && !deepEqual(props.values, _values.current)) {
      control._reset(props.values, control._options.resetOptions);
      _values.current = props.values;
      updateFormState((state) => ({ ...state }));
    } else {
      control._resetDefaultValues();
    }
  }, [props.values, control]);
  React.useEffect(() => {
    if (props.errors) {
      control._setErrors(props.errors);
    }
  }, [props.errors, control]);
  React.useEffect(() => {
    if (!control._state.mount) {
      control._updateValid();
      control._state.mount = true;
    }
    if (control._state.watch) {
      control._state.watch = false;
      control._subjects.state.next({ ...control._formState });
    }
    control._removeUnmounted();
  });
  React.useEffect(() => {
    props.shouldUnregister && control._subjects.values.next({
      values: control._getWatch()
    });
  }, [props.shouldUnregister, control]);
  _formControl.current.formState = getProxyFormState(formState, control);
  return _formControl.current;
}
const toast = "_toast_kwt6m_1";
const visible = "_visible_kwt6m_17";
const hidden = "_hidden_kwt6m_22";
const success = "_success_kwt6m_27";
const error$1 = "_error_kwt6m_31";
const info$1 = "_info_kwt6m_35";
const warning = "_warning_kwt6m_39";
const icon = "_icon_kwt6m_43";
const message = "_message_kwt6m_64";
const styles$c = {
  toast,
  visible,
  hidden,
  success,
  error: error$1,
  info: info$1,
  warning,
  icon,
  message
};
const Toast = ({ message: message2, type = "success", duration = 3e3, onClose }) => {
  const [visible2, setVisible] = reactExports.useState(true);
  reactExports.useEffect(() => {
    const timer = setTimeout(() => {
      setVisible(false);
      if (onClose) {
        setTimeout(onClose, 300);
      }
    }, duration);
    return () => clearTimeout(timer);
  }, [duration, onClose]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "div",
    {
      className: `${styles$c.toast} ${styles$c[type]} ${visible2 ? styles$c.visible : styles$c.hidden}`,
      children: [
        type === "success" && /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$c.icon, children: "✓" }),
        type === "error" && /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$c.icon, children: "✕" }),
        type === "info" && /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$c.icon, children: "ℹ" }),
        type === "warning" && /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$c.icon, children: "⚠" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: styles$c.message, children: message2 })
      ]
    }
  );
};
const label$1 = "_label_66y8x_1";
const styles$b = {
  label: label$1
};
const Label = ({ children }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsx("label", { className: styles$b.label, children });
};
const checkboxContainer = "_checkboxContainer_154vz_1";
const checkboxInput = "_checkboxInput_154vz_13";
const checkmark = "_checkmark_154vz_21";
const label = "_label_154vz_60";
const styles$a = {
  checkboxContainer,
  checkboxInput,
  checkmark,
  label
};
const Checkbox = ({
  label: label2,
  disabled = false,
  name,
  value,
  className = "",
  register,
  ...rest
}) => {
  const registration = register ? register(name) : {};
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("label", { className: `${styles$a.checkboxContainer} ${className}`, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx(
      "input",
      {
        type: "checkbox",
        className: styles$a.checkboxInput,
        disabled,
        ...registration,
        ...rest,
        value
      }
    ),
    label2 && /* @__PURE__ */ jsxRuntimeExports.jsx(Label, { children: label2 }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$a.checkmark })
  ] });
};
const formContainer$1 = "_formContainer_1huci_1";
const form$2 = "_form_1huci_1";
const formTitle$1 = "_formTitle_1huci_16";
const subTitle$1 = "_subTitle_1huci_23";
const notificationBanner = "_notificationBanner_1huci_31";
const notificationText = "_notificationText_1huci_42";
const errorText$1 = "_errorText_1huci_48";
const successText$1 = "_successText_1huci_56";
const checkboxSection = "_checkboxSection_1huci_64";
const checkboxSectionTitle = "_checkboxSectionTitle_1huci_72";
const button$2 = "_button_1huci_79";
const rowControls$1 = "_rowControls_1huci_102";
const rowControlsItem$1 = "_rowControlsItem_1huci_111";
const buttonSecondary = "_buttonSecondary_1huci_119";
const rowControlsItemLabel$1 = "_rowControlsItemLabel_1huci_138";
const inputContainer = "_inputContainer_1huci_145";
const buttonTest = "_buttonTest_1huci_149";
const link$1 = "_link_1huci_161";
const inputDisabled = "_inputDisabled_1huci_166";
const labelWithMargin = "_labelWithMargin_1huci_171";
const helpText$1 = "_helpText_1huci_175";
const styles$9 = {
  formContainer: formContainer$1,
  form: form$2,
  formTitle: formTitle$1,
  subTitle: subTitle$1,
  notificationBanner,
  notificationText,
  errorText: errorText$1,
  successText: successText$1,
  checkboxSection,
  checkboxSectionTitle,
  button: button$2,
  rowControls: rowControls$1,
  rowControlsItem: rowControlsItem$1,
  buttonSecondary,
  rowControlsItemLabel: rowControlsItemLabel$1,
  inputContainer,
  buttonTest,
  link: link$1,
  inputDisabled,
  labelWithMargin,
  helpText: helpText$1
};
async function validateIntegrationStatus() {
  try {
    const response = await fetch(
      // eslint-disable-next-line no-undef
      WCCorreiosIntegrationAdminParams.ajax_url,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          action: "validate_integration_is_active",
          // eslint-disable-next-line no-undef
          nonce: WCCorreiosIntegrationAdminParams.nonce
        })
      }
    );
    const data = await response.json();
    console.log("Integration Status:", data);
    return data;
  } catch (error2) {
    console.error("Error validating integration status:", error2);
    throw error2;
  }
}
async function updateIntegrationCredentials(storeId, credentials) {
  try {
    const response = await fetch(
      // eslint-disable-next-line no-undef
      WCCorreiosIntegrationAdminParams.ajax_url,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          action: "update_integration_credentials",
          // eslint-disable-next-line no-undef
          nonce: WCCorreiosIntegrationAdminParams.nonce,
          storeId,
          credentials: JSON.stringify(credentials)
        })
      }
    );
    const data = await response.json();
    console.log("Update Credentials Response:", data);
    return data;
  } catch (error2) {
    console.error("Error updating integration credentials:", error2);
    throw error2;
  }
}
async function saveDeveloperSettingsService(settings) {
  try {
    const response = await fetch(
      // eslint-disable-next-line no-undef
      WCCorreiosIntegrationAdminParams.ajax_url,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          action: "save_developer_settings",
          // eslint-disable-next-line no-undef
          nonce: WCCorreiosIntegrationAdminParams.nonce,
          devOptions: settings.devOptions,
          alternativeBasePath: settings.alternativeBasePath,
          tracking_bxkey: settings.tracking_bxkey
        })
      }
    );
    const data = await response.json();
    console.log("Save Developer Settings Response:", data);
    return data;
  } catch (error2) {
    console.error("Error saving developer settings:", error2);
    throw error2;
  }
}
async function saveSettings(settings) {
  try {
    const response = await fetch(
      // eslint-disable-next-line no-undef
      WCCorreiosIntegrationAdminParams.ajax_url,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          action: "save_integration_settings",
          // eslint-disable-next-line no-undef
          nonce: WCCorreiosIntegrationAdminParams.nonce,
          districtsEnable: settings.districtsEnable,
          pudoEnable: settings.pudoEnable,
          districtCode: settings.districtCode,
          noBlueStatus: settings.noBlueStatus,
          active_logs: settings.active_logs
        })
      }
    );
    const data = await response.json();
    console.log("Save Settings Response:", data);
    return data;
  } catch (error2) {
    console.error("Error saving settings:", error2);
    throw error2;
  }
}
async function testPricingService() {
  try {
    const response = await fetch(
      // eslint-disable-next-line no-undef
      WCCorreiosIntegrationAdminParams.ajax_url,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          action: "test_correios_integration",
          // eslint-disable-next-line no-undef
          nonce: WCCorreiosIntegrationAdminParams.nonce
        })
      }
    );
    const data = await response.json();
    return data;
  } catch (error2) {
    console.error("Error testing pricing:", error2);
    throw error2;
  }
}
async function shippingZonesCreate(params) {
  try {
    const restUrl = WCCorreiosIntegrationAdminParams.rest_url || "/wp-json/wc-bluex/v1/";
    const restNonce = WCCorreiosIntegrationAdminParams.rest_nonce;
    const response = await fetch(
      `${restUrl}shipping-zones-automation/create`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": restNonce
        },
        body: JSON.stringify(params)
      }
    );
    const data = await response.json();
    console.log("Shipping Zones Create Response:", data);
    if (!response.ok) {
      throw new Error(data.message || "Error al crear zonas de envío");
    }
    return data;
  } catch (error2) {
    console.error("Error creating shipping zones:", error2);
    throw error2;
  }
}
async function shippingZonesStatus() {
  try {
    const restUrl = WCCorreiosIntegrationAdminParams.rest_url || "/wp-json/wc-bluex/v1/";
    const restNonce = WCCorreiosIntegrationAdminParams.rest_nonce;
    const response = await fetch(
      `${restUrl}shipping-zones-automation/status`,
      {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": restNonce
        }
      }
    );
    const data = await response.json();
    console.log("Shipping Zones Status Response:", data);
    if (!response.ok) {
      throw new Error(data.message || "Error al obtener estado de zonas");
    }
    return data;
  } catch (error2) {
    console.error("Error getting shipping zones status:", error2);
    throw error2;
  }
}
const container$2 = "_container_qzsko_1";
const inputWrapper = "_inputWrapper_qzsko_11";
const input$1 = "_input_qzsko_11";
const toggle = "_toggle_qzsko_38";
const clear = "_clear_qzsko_51";
const dropdown = "_dropdown_qzsko_75";
const option = "_option_qzsko_89";
const highlight$1 = "_highlight_qzsko_95";
const empty = "_empty_qzsko_99";
const styles$8 = {
  container: container$2,
  inputWrapper,
  input: input$1,
  toggle,
  clear,
  dropdown,
  option,
  highlight: highlight$1,
  empty
};
const SearchableSelect = ({
  value,
  onChange,
  options = [],
  placeholder = "Seleccione una opción",
  disabled = false
}) => {
  const containerRef = reactExports.useRef(null);
  const [isOpen, setIsOpen] = reactExports.useState(false);
  const [query, setQuery] = reactExports.useState("");
  const [highlightIndex, setHighlightIndex] = reactExports.useState(0);
  const selectedOption = reactExports.useMemo(
    () => options.find((opt) => opt.value === value) || null,
    [options, value]
  );
  reactExports.useEffect(() => {
    if (selectedOption) {
      setQuery(selectedOption.label);
    } else if (!isOpen) {
      setQuery("");
    }
  }, [selectedOption, isOpen]);
  const filteredOptions = reactExports.useMemo(() => {
    if (!query) return options;
    const q = query.toLowerCase();
    return options.filter(
      (opt) => opt.label.toLowerCase().includes(q) || opt.value.toLowerCase().includes(q)
    );
  }, [options, query]);
  reactExports.useEffect(() => {
    const handleClickOutside = (event) => {
      if (containerRef.current && !containerRef.current.contains(event.target)) {
        setIsOpen(false);
      }
    };
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);
  const handleSelect = (opt) => {
    setIsOpen(false);
    setQuery(opt.label);
    if (onChange) {
      onChange({ target: { value: opt.value } });
    }
  };
  const handleClear = () => {
    setQuery("");
    setIsOpen(false);
    if (onChange) {
      onChange({ target: { value: "" } });
    }
  };
  const onKeyDown = (e) => {
    if (!isOpen) {
      if (e.key === "ArrowDown" || e.key === "ArrowUp") {
        setIsOpen(true);
        e.preventDefault();
      }
      return;
    }
    if (e.key === "ArrowDown") {
      e.preventDefault();
      setHighlightIndex(
        (prev) => Math.min(prev + 1, filteredOptions.length - 1)
      );
    } else if (e.key === "ArrowUp") {
      e.preventDefault();
      setHighlightIndex((prev) => Math.max(prev - 1, 0));
    } else if (e.key === "Enter") {
      e.preventDefault();
      const opt = filteredOptions[highlightIndex];
      if (opt) handleSelect(opt);
    } else if (e.key === "Escape") {
      e.preventDefault();
      setIsOpen(false);
    }
  };
  reactExports.useEffect(() => {
    setHighlightIndex(0);
  }, [query, isOpen]);
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { ref: containerRef, className: styles$8.container, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$8.inputWrapper, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "input",
        {
          type: "text",
          className: styles$8.input,
          placeholder,
          disabled,
          value: query,
          onChange: (e) => {
            setQuery(e.target.value);
            setIsOpen(true);
          },
          onFocus: () => setIsOpen(true),
          onKeyDown
        }
      ),
      isOpen && !disabled && (value || query) && /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          type: "button",
          className: styles$8.clear,
          onClick: handleClear,
          "aria-label": "Limpiar selección",
          children: "×"
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          type: "button",
          className: styles$8.toggle,
          onClick: () => !disabled && setIsOpen((o) => !o),
          "aria-label": "Toggle",
          disabled,
          children: "▾"
        }
      )
    ] }),
    isOpen && !disabled && /* @__PURE__ */ jsxRuntimeExports.jsxs("ul", { className: styles$8.dropdown, role: "listbox", children: [
      filteredOptions.length === 0 && /* @__PURE__ */ jsxRuntimeExports.jsx("li", { className: styles$8.empty, children: "Sin resultados" }),
      filteredOptions.map((opt, idx) => /* @__PURE__ */ jsxRuntimeExports.jsx(
        "li",
        {
          className: `${styles$8.option} ${idx === highlightIndex ? styles$8.highlight : ""}`,
          onMouseDown: (e) => e.preventDefault(),
          onClick: () => handleSelect(opt),
          role: "option",
          "aria-selected": opt.value === value,
          children: opt.label
        },
        opt.value
      ))
    ] })
  ] });
};
const comunas = [
  {
    "name": "Arica y Parinacota",
    "code": 15,
    "isocode": "AP",
    "ciudades": [
      {
        "name": "ARICA",
        "code": 15101,
        "defaultDistrict": "ARI",
        "districts": [
          {
            "name": "CODPA",
            "code": "ACZ"
          },
          {
            "name": "GUANACAHUA",
            "code": "AGN"
          },
          {
            "name": "MOLINOS",
            "code": "AMO"
          },
          {
            "name": "ARICA",
            "code": "ARI"
          },
          {
            "name": "ESQUINA",
            "code": "AQE"
          },
          {
            "name": "AUSIPAR",
            "code": "APR"
          },
          {
            "name": "ALTO RAMIREZ",
            "code": "ARZ"
          },
          {
            "name": "TIMAR",
            "code": "ATI"
          },
          {
            "name": "SOBRAYA",
            "code": "AYA"
          },
          {
            "name": "SORA",
            "code": "SOR"
          },
          {
            "name": "RANCHO ARICA",
            "code": "RAR"
          },
          {
            "name": "POCONCHILE",
            "code": "POC"
          },
          {
            "name": "CUZ CUZ - ARICA",
            "code": "CZZ"
          },
          {
            "name": "AZAPA",
            "code": "AZA"
          },
          {
            "name": "VILLA FRONTERA",
            "code": "AVF"
          }
        ]
      },
      {
        "name": "CAMARONES",
        "code": 15102,
        "defaultDistrict": "CAM",
        "districts": [
          {
            "name": "CAMARONES - ARICA",
            "code": "CAM"
          },
          {
            "name": "CUYA",
            "code": "ZYA"
          },
          {
            "name": "SUCA",
            "code": "UCA"
          },
          {
            "name": "QUIPINTA",
            "code": "QPT"
          },
          {
            "name": "MINIMINE",
            "code": "MMN"
          },
          {
            "name": "MINITA",
            "code": "MIY"
          },
          {
            "name": "CALETA CAMARONES",
            "code": "CTM"
          },
          {
            "name": "CALETA CHICA",
            "code": "ICC"
          }
        ]
      },
      {
        "name": "GENERAL LAGOS",
        "code": 15202,
        "defaultDistrict": "LGR",
        "districts": [
          {
            "name": "COSAPILLA",
            "code": "ACI"
          },
          {
            "name": "GENERAL LAGOS",
            "code": "LGR"
          },
          {
            "name": "VISVIRI",
            "code": "VIV"
          },
          {
            "name": "VILLA INDUSTRIAL",
            "code": "VIU"
          },
          {
            "name": "NASAHUENTO",
            "code": "NSH"
          },
          {
            "name": "GUACOLLO",
            "code": "GLL"
          },
          {
            "name": "AGUAS CALIENTES ",
            "code": "ATS"
          },
          {
            "name": "AZUFRERA TACORA",
            "code": "AZT"
          }
        ]
      },
      {
        "name": "PUTRE",
        "code": 15201,
        "defaultDistrict": "PTR",
        "districts": [
          {
            "name": "BRITANIA",
            "code": "ABT"
          },
          {
            "name": "CHOQUELIMPIE",
            "code": "ACL"
          },
          {
            "name": "CORONEL ALCERRECA",
            "code": "ACN"
          },
          {
            "name": "GUALLATIRI",
            "code": "ALL"
          },
          {
            "name": "PARINACOTA",
            "code": "API"
          },
          {
            "name": "TARUGUIRE",
            "code": "TRG"
          },
          {
            "name": "TIMALCHACA",
            "code": "TCA"
          },
          {
            "name": "PUTRE",
            "code": "PTR"
          },
          {
            "name": "JURASI",
            "code": "JRI"
          },
          {
            "name": "ITISA",
            "code": "ITT"
          },
          {
            "name": "LAGO CHUNGARA",
            "code": "CGA"
          },
          {
            "name": "BELEN",
            "code": "BNN"
          },
          {
            "name": "TERMAS DE CHITUNE",
            "code": "ATQ"
          },
          {
            "name": "TIGNAMAR",
            "code": "ATG"
          },
          {
            "name": "SOCOROMA",
            "code": "ASO"
          },
          {
            "name": "PACHAMA",
            "code": "APH"
          },
          {
            "name": "CHACUYO",
            "code": "ACC"
          },
          {
            "name": "CHAPIQUINA",
            "code": "ACP"
          },
          {
            "name": "PUQUISA",
            "code": "PQS"
          },
          {
            "name": "MAILLKU",
            "code": "MKU"
          },
          {
            "name": "CHICAYA",
            "code": "CYH"
          },
          {
            "name": "COPAQUILLA",
            "code": "CQY"
          },
          {
            "name": "CAQUENA",
            "code": "ACQ"
          }
        ]
      }
    ]
  },
  {
    "name": "Tarapacá",
    "code": 1,
    "isocode": "TA",
    "ciudades": [
      {
        "name": "ALTO HOSPICIO",
        "code": 1107,
        "defaultDistrict": "AHP",
        "districts": [
          {
            "name": "ALTO HOSPICIO",
            "code": "AHP"
          }
        ]
      },
      {
        "name": "CAMINA",
        "code": 1402,
        "defaultDistrict": "CMN",
        "districts": [
          {
            "name": "CAMINA",
            "code": "CMN"
          },
          {
            "name": "ALPAJERES",
            "code": "PJR"
          },
          {
            "name": "CARITAYA",
            "code": "RTA"
          },
          {
            "name": "CORSA",
            "code": "QCR"
          },
          {
            "name": "PALCA",
            "code": "PKA"
          },
          {
            "name": "PISAGUA",
            "code": "PIS"
          },
          {
            "name": "ALTUZA",
            "code": "IAL"
          },
          {
            "name": "CHAPIQUITA",
            "code": "ICY"
          },
          {
            "name": "NAMA",
            "code": "NMA"
          },
          {
            "name": "VILAVILA",
            "code": "IVV"
          },
          {
            "name": "CALATAMBO",
            "code": "CTA"
          }
        ]
      },
      {
        "name": "COLCHANE",
        "code": 1403,
        "defaultDistrict": "COE",
        "districts": [
          {
            "name": "ANAGUANI",
            "code": "ANG"
          },
          {
            "name": "SOTOCA",
            "code": "STA"
          },
          {
            "name": "ENQUELGA",
            "code": "QEP"
          },
          {
            "name": "MOCOMUCANE",
            "code": "MCL"
          },
          {
            "name": "ISLUGA",
            "code": "IIS"
          },
          {
            "name": "CARIQUIMA",
            "code": "ICQ"
          },
          {
            "name": "CHIAPA",
            "code": "ICI"
          },
          {
            "name": "COLCHANE",
            "code": "COE"
          },
          {
            "name": "ANCUAQUE",
            "code": "ANQ"
          },
          {
            "name": "ANCOVINTO",
            "code": "CVT"
          }
        ]
      },
      {
        "name": "HUARA",
        "code": 1404,
        "defaultDistrict": "HRA",
        "districts": [
          {
            "name": "HUARA",
            "code": "HRA"
          },
          {
            "name": "LIRIMA",
            "code": "ILI"
          },
          {
            "name": "POROMA",
            "code": "QPR"
          },
          {
            "name": "COLLACAGUA",
            "code": "QLG"
          },
          {
            "name": "TARAPACA",
            "code": "ITP"
          },
          {
            "name": "PACHICA",
            "code": "IPH"
          },
          {
            "name": "MOCHA",
            "code": "IMO"
          },
          {
            "name": "CANCOSA",
            "code": "ICO"
          },
          {
            "name": "CHUSMISA",
            "code": "ICA"
          }
        ]
      },
      {
        "name": "IQUIQUE",
        "code": 1101,
        "defaultDistrict": "IQQ",
        "districts": [
          {
            "name": "CALETA BUENA - IQUIQ",
            "code": "ICB"
          },
          {
            "name": "MINA FAKIR",
            "code": "IMF"
          },
          {
            "name": "MINA LOBOS",
            "code": "IML"
          },
          {
            "name": "IQUIQUE",
            "code": "IQQ"
          },
          {
            "name": "PLAYA BLANCA",
            "code": "ZPL"
          },
          {
            "name": "RIO SECO",
            "code": "RSC"
          },
          {
            "name": "SAN MARCOS - IQUIQUE",
            "code": "RFO"
          },
          {
            "name": "PUNTA LOBOS",
            "code": "QLB"
          },
          {
            "name": "CHIPANA",
            "code": "PQA"
          },
          {
            "name": "PUERTO PATILLOS",
            "code": "IPP"
          }
        ]
      },
      {
        "name": "PICA",
        "code": 1405,
        "defaultDistrict": "OPC",
        "districts": [
          {
            "name": "MINERA QUEBRADA BLAN",
            "code": "BQM"
          },
          {
            "name": "COLLAHUASI",
            "code": "CLH"
          },
          {
            "name": "COLONIA PINTADOS",
            "code": "ICP"
          },
          {
            "name": "LA HUAICA",
            "code": "LGC"
          },
          {
            "name": "OFICINA VICTORIA",
            "code": "IOV"
          },
          {
            "name": "PICA",
            "code": "OPC"
          },
          {
            "name": "GUATACONDO",
            "code": "ZRC"
          },
          {
            "name": "PUQUIOS - IQUIQUE",
            "code": "PQU"
          },
          {
            "name": "MATILLA",
            "code": "MTA"
          }
        ]
      },
      {
        "name": "POZO ALMONTE",
        "code": 1401,
        "defaultDistrict": "PAM",
        "districts": [
          {
            "name": "FUERTE BAQUEDANO",
            "code": "IFB"
          },
          {
            "name": "TAMBILLO",
            "code": "IUJ"
          },
          {
            "name": "MAMINA",
            "code": "MAN"
          },
          {
            "name": "POZO ALMONTE",
            "code": "PAM"
          },
          {
            "name": "LA TIRANA",
            "code": "LTI"
          },
          {
            "name": "MACAYA",
            "code": "IMA"
          }
        ]
      }
    ]
  },
  {
    "name": "Antofagasta",
    "code": 2,
    "isocode": "AN",
    "ciudades": [
      {
        "name": "ANTOFAGASTA",
        "code": 2101,
        "defaultDistrict": "ANF",
        "districts": [
          {
            "name": "AGUA VERDE",
            "code": "AAV"
          },
          {
            "name": "ISLA SANTA MARIA",
            "code": "ZSM"
          },
          {
            "name": "RANCHO ANTOFAGASTA",
            "code": "RAN"
          },
          {
            "name": "PARANAL",
            "code": "PRL"
          },
          {
            "name": "MANTOS BLANCOS",
            "code": "MTB"
          },
          {
            "name": "MINA LOMAS BAYAS",
            "code": "MIN"
          },
          {
            "name": "LA NEGRA",
            "code": "LNA"
          },
          {
            "name": "ESTACION AGUAS BLANC",
            "code": "AGC"
          },
          {
            "name": "EL WAY",
            "code": "AEW"
          },
          {
            "name": "ESTACION AUGUSTA VIC",
            "code": "AEV"
          },
          {
            "name": "ENSUENO",
            "code": "AEO"
          },
          {
            "name": "EL MEDANO",
            "code": "AEM"
          },
          {
            "name": "ESTACION LOS VIENTOS",
            "code": "AEL"
          },
          {
            "name": "ESTACION LA RIOJA",
            "code": "AEJ"
          },
          {
            "name": "ESTACION O`HIGGINS",
            "code": "AEH"
          },
          {
            "name": "BLANCO ENCALADA",
            "code": "ABL"
          },
          {
            "name": "CERRO PARANAL",
            "code": "CPL"
          },
          {
            "name": "CARMEN ALTO",
            "code": "CIN"
          },
          {
            "name": "PAPOSO",
            "code": "APP"
          },
          {
            "name": "ESTACION PALESTINA",
            "code": "APE"
          },
          {
            "name": "PUERTO COLOSO",
            "code": "APC"
          },
          {
            "name": "ANTOFAGASTA",
            "code": "ANF"
          },
          {
            "name": "ESTACION MONTURAQUI",
            "code": "AMQ"
          },
          {
            "name": "JUAN LOPEZ",
            "code": "AJL"
          },
          {
            "name": "CALETA BOTIJA",
            "code": "AJJ"
          },
          {
            "name": "ESTACION AGUA BUENA",
            "code": "AEB"
          },
          {
            "name": "ESTACION CATALINA",
            "code": "AEC"
          },
          {
            "name": "EL GUANACO",
            "code": "AEG"
          },
          {
            "name": "CALETA EL COBRE",
            "code": "AEE"
          },
          {
            "name": "ESTACION SOCOMPA",
            "code": "ESA"
          },
          {
            "name": "AZUFRERA",
            "code": "AZF"
          },
          {
            "name": "EX OFICINA FLOR DE C",
            "code": "AXF"
          },
          {
            "name": "EX OFICINA CHILE",
            "code": "AXC"
          },
          {
            "name": "EX OFICINA ALEMANIA",
            "code": "AXA"
          },
          {
            "name": "ESTACION VARILLA",
            "code": "AVE"
          },
          {
            "name": "AZUFRERA PLATO DE SO",
            "code": "ATM"
          },
          {
            "name": "SAN CRISTOBAL",
            "code": "ASC"
          },
          {
            "name": "ESTACION PAN DE AZUC",
            "code": "APZ"
          },
          {
            "name": "CERRO MORENO",
            "code": "ACM"
          },
          {
            "name": "BAQUEDANO",
            "code": "BQO"
          }
        ]
      },
      {
        "name": "CALAMA",
        "code": 2201,
        "defaultDistrict": "CJC",
        "districts": [
          {
            "name": "CASPANA",
            "code": "CAP"
          },
          {
            "name": "AYQUINA",
            "code": "CAY"
          },
          {
            "name": "CONCHI   ",
            "code": "CCI"
          },
          {
            "name": "CUPO",
            "code": "CEY"
          },
          {
            "name": "CALAMA",
            "code": "CJC"
          },
          {
            "name": "TOCONCE",
            "code": "COV"
          },
          {
            "name": "TUINA",
            "code": "CTN"
          },
          {
            "name": "CHUQUICAMATA",
            "code": "QUI"
          },
          {
            "name": "MINA RADOMIRO TOMIC",
            "code": "MRT"
          },
          {
            "name": "MINA EL LITIO",
            "code": "MLT"
          },
          {
            "name": "MINA GABY",
            "code": "MGY"
          },
          {
            "name": "MINA FARIDE",
            "code": "MFD"
          },
          {
            "name": "MINA CERRO DOMINADOR",
            "code": "MCD"
          },
          {
            "name": "LINZOR",
            "code": "LZR"
          },
          {
            "name": "MINA EL ABRA",
            "code": "ELA"
          },
          {
            "name": "LASANA",
            "code": "CXL"
          },
          {
            "name": "TURI",
            "code": "TTR"
          },
          {
            "name": "MINERA SPENCER",
            "code": "SPM"
          },
          {
            "name": "SAN JOSE  ",
            "code": "SJE"
          },
          {
            "name": "SANTA ROSA - CALAMA",
            "code": "CSR"
          },
          {
            "name": "INCACALIRI",
            "code": "CJI"
          },
          {
            "name": "CHIUCHIU",
            "code": "CHU"
          },
          {
            "name": "CONCHI VIEJO",
            "code": "CCV"
          },
          {
            "name": "ESTACION CERRITOS BAYOS",
            "code": "CCB"
          },
          {
            "name": "BANOS DE TURI",
            "code": "CBT"
          }
        ]
      },
      {
        "name": "MARIA ELENA",
        "code": 2302,
        "defaultDistrict": "MAE",
        "districts": [
          {
            "name": "ESTACION MIRAJE",
            "code": "AET"
          },
          {
            "name": "OFICINA PEDRO DE VAL",
            "code": "ALQ"
          },
          {
            "name": "OFICINA VERGARA",
            "code": "OVR"
          },
          {
            "name": "MARIA ELENA SOQUIMICH",
            "code": "MEQ"
          },
          {
            "name": "MARIA ELENA",
            "code": "MAE"
          },
          {
            "name": "QUILLAGUA",
            "code": "CQG"
          }
        ]
      },
      {
        "name": "MEJILLONES",
        "code": 2102,
        "defaultDistrict": "MJS",
        "districts": [
          {
            "name": "HORNITOS - ANTOFAGAS",
            "code": "AHO"
          },
          {
            "name": "MEJILLONES",
            "code": "MJS"
          }
        ]
      },
      {
        "name": "OLLAGUE",
        "code": 2202,
        "defaultDistrict": "OLL",
        "districts": [
          {
            "name": "AMINCHA",
            "code": "AMC"
          },
          {
            "name": "AUCANQUILCHA",
            "code": "QCA"
          },
          {
            "name": "SAN PEDRO DE ATACAMA",
            "code": "SPD"
          },
          {
            "name": "OLLAGUE",
            "code": "OLL"
          },
          {
            "name": "ESTACION CEBOLLAR",
            "code": "CEB"
          },
          {
            "name": "ESTACION CARCOTE",
            "code": "ETC"
          },
          {
            "name": "POLAN",
            "code": "CXP"
          },
          {
            "name": "LEQUENA",
            "code": "CLQ"
          },
          {
            "name": "CALACHUZ",
            "code": "CCZ"
          },
          {
            "name": "ASCOTAN",
            "code": "ASN"
          }
        ]
      },
      {
        "name": "SAN PEDRO DE ATACAMA",
        "code": 2203,
        "defaultDistrict": "SPX",
        "districts": [
          {
            "name": "AGUAS BLANCAS",
            "code": "CAA"
          },
          {
            "name": "TOCONAO",
            "code": "TCO"
          },
          {
            "name": "SAN PEDRO DE ATACAMA",
            "code": "SPX"
          },
          {
            "name": "PURITAMA",
            "code": "RMA"
          },
          {
            "name": "RIO GRANDE - CALAMA",
            "code": "RGS"
          },
          {
            "name": "PEINE",
            "code": "PNI"
          },
          {
            "name": "ALITAR",
            "code": "CTZ"
          },
          {
            "name": "TILO POZO",
            "code": "CTP"
          },
          {
            "name": "TALABRE",
            "code": "CTB"
          },
          {
            "name": "SOCAIRE",
            "code": "CSE"
          },
          {
            "name": "SAN BARTOLO",
            "code": "CSB"
          },
          {
            "name": "CAMAR",
            "code": "CMR"
          },
          {
            "name": "TILOMONTE",
            "code": "CIL"
          }
        ]
      },
      {
        "name": "SIERRA GORDA",
        "code": 2103,
        "defaultDistrict": "SGD",
        "districts": [
          {
            "name": "CARACOLES",
            "code": "CCR"
          },
          {
            "name": "SIERRA GORDA",
            "code": "SGD"
          },
          {
            "name": "MINERA ZALDIVAR",
            "code": "MZL"
          },
          {
            "name": "FLOR DEL DESIERTO",
            "code": "FDT"
          },
          {
            "name": "MELLIZOS",
            "code": "MLZ"
          },
          {
            "name": "CENTINELA",
            "code": "CDQ"
          }
        ]
      },
      {
        "name": "TALTAL",
        "code": 2104,
        "defaultDistrict": "TTL",
        "districts": [
          {
            "name": "ALTAMIRA",
            "code": "AMR"
          },
          {
            "name": "LA POLVORA",
            "code": "LPV"
          },
          {
            "name": "CIFUNCHO",
            "code": "CFI"
          },
          {
            "name": "TALTAL",
            "code": "TTL"
          },
          {
            "name": "ESMERALDA",
            "code": "SDA"
          }
        ]
      },
      {
        "name": "TOCOPILLA",
        "code": 2301,
        "defaultDistrict": "TOC",
        "districts": [
          {
            "name": "CALETA BOY",
            "code": "ACB"
          },
          {
            "name": "CALETA BUENA - ANTOF",
            "code": "ACE"
          },
          {
            "name": "TOCOPILLA",
            "code": "TOC"
          },
          {
            "name": "MINA MICHILLA",
            "code": "MIC"
          },
          {
            "name": "MICHILLA",
            "code": "AMI"
          },
          {
            "name": "COBIJA",
            "code": "ACJ"
          }
        ]
      }
    ]
  },
  {
    "name": "Atacama",
    "code": 3,
    "isocode": "AT",
    "ciudades": [
      {
        "name": "ALTO DEL CARMEN",
        "code": 3302,
        "defaultDistrict": "ADC",
        "districts": [
          {
            "name": "ALTO DEL CARMEN",
            "code": "ADC"
          },
          {
            "name": "LA HIGUERA",
            "code": "LHI"
          },
          {
            "name": "CONAY",
            "code": "VCO"
          },
          {
            "name": "JUNTA VALERIANO",
            "code": "VJU"
          },
          {
            "name": "LAGUNA GRANDE",
            "code": "ZTA"
          },
          {
            "name": "EL NEVADO",
            "code": "ZMJ"
          },
          {
            "name": "SAN FELIX",
            "code": "VSA"
          },
          {
            "name": "LA HIGUERITA",
            "code": "VLH"
          },
          {
            "name": "LA ARENA ",
            "code": "VLA"
          },
          {
            "name": "EL TRANSITO - SERENA",
            "code": "VET"
          },
          {
            "name": "EL RETAMO",
            "code": "TMO"
          }
        ]
      },
      {
        "name": "CALDERA",
        "code": 3102,
        "defaultDistrict": "CLR",
        "districts": [
          {
            "name": "BAHIA INGLESA",
            "code": "CBH"
          },
          {
            "name": "CALDERA",
            "code": "CLR"
          },
          {
            "name": "PUERTO VIEJO",
            "code": "CPV"
          },
          {
            "name": "RANCHO CALDERA",
            "code": "RCD"
          }
        ]
      },
      {
        "name": "CHANARAL",
        "code": 3201,
        "defaultDistrict": "CHN",
        "districts": [
          {
            "name": "FLAMENCO",
            "code": "CFL"
          },
          {
            "name": "PAN DE AZUCAR - COPI",
            "code": "CPZ"
          },
          {
            "name": "MINA ROSARIO",
            "code": "RSO"
          },
          {
            "name": "PLAYA REFUGIO",
            "code": "QPO"
          },
          {
            "name": "MINA LA ESTRELLA",
            "code": "QME"
          },
          {
            "name": "MINA DICHOSA",
            "code": "QMD"
          },
          {
            "name": "OBISPITO",
            "code": "OBT"
          },
          {
            "name": "CHANARAL - COPIAPO",
            "code": "CHN"
          },
          {
            "name": "PUERTO FINO",
            "code": "CPF"
          }
        ]
      },
      {
        "name": "COPIAPO",
        "code": 3101,
        "defaultDistrict": "CPO",
        "districts": [
          {
            "name": "BARRANQUILLAS",
            "code": "BQQ"
          },
          {
            "name": "CALETA PAJONAL",
            "code": "QCP"
          },
          {
            "name": "TOTORAL",
            "code": "CTX"
          },
          {
            "name": "COPIAPO",
            "code": "CPO"
          },
          {
            "name": "HACIENDA CASTILLA",
            "code": "CHX"
          },
          {
            "name": "CALETA DEL MEDIO",
            "code": "CCM"
          }
        ]
      },
      {
        "name": "DIEGO DE ALMAGRO",
        "code": 3202,
        "defaultDistrict": "DAG",
        "districts": [
          {
            "name": "FINCA DE CHANARAL",
            "code": "CFC"
          },
          {
            "name": "VEGAS DE CHANARAL AL",
            "code": "QVC"
          },
          {
            "name": "TERMAS DE RIO NEGRO",
            "code": "QTR"
          },
          {
            "name": "EL PINO",
            "code": "QPN"
          },
          {
            "name": "LA OLA",
            "code": "QLA"
          },
          {
            "name": "BOCAMINA",
            "code": "QBQ"
          },
          {
            "name": "POTRERILLOS",
            "code": "PTS"
          },
          {
            "name": "MONTANDON",
            "code": "MNN"
          },
          {
            "name": "LLANTA",
            "code": "LLT"
          },
          {
            "name": "INCA DE ORO",
            "code": "IRO"
          },
          {
            "name": "EL SALVADOR",
            "code": "ESR"
          },
          {
            "name": "EL SALADO",
            "code": "ESL"
          },
          {
            "name": "DIEGO DE ALMAGRO",
            "code": "DAG"
          },
          {
            "name": "MINA CHIVATO",
            "code": "CLC"
          }
        ]
      },
      {
        "name": "FREIRINA",
        "code": 3303,
        "defaultDistrict": "FRN",
        "districts": [
          {
            "name": "FREIRINA",
            "code": "FRN"
          },
          {
            "name": "MINA ALGARROBO",
            "code": "VMI"
          },
          {
            "name": "MAITENCILLO - CALERA",
            "code": "VMT"
          },
          {
            "name": "LABRAR",
            "code": "VLB"
          },
          {
            "name": "CALETA SARCO",
            "code": "TSC"
          },
          {
            "name": "CARRIZALILLO",
            "code": "VCI"
          },
          {
            "name": "LA FRAGUITA",
            "code": "VFR"
          },
          {
            "name": "CALETA CHANARAL",
            "code": "VCL"
          }
        ]
      },
      {
        "name": "HUASCO",
        "code": 3304,
        "defaultDistrict": "HCO",
        "districts": [
          {
            "name": "LOS TOYOS",
            "code": "CXQ"
          },
          {
            "name": "HUASCO BAJO",
            "code": "HCB"
          },
          {
            "name": "MIRAFLORES - SERENA",
            "code": "VMR"
          },
          {
            "name": "CARRIZAL BAJO",
            "code": "VCR"
          },
          {
            "name": "CANTO DE AGUA",
            "code": "TAG"
          },
          {
            "name": "HUASCO",
            "code": "HCO"
          }
        ]
      },
      {
        "name": "TIERRA AMARILLA",
        "code": 3103,
        "defaultDistrict": "TRM",
        "districts": [
          {
            "name": "AMOLANAS",
            "code": "AMN"
          },
          {
            "name": "LA GUARDIA",
            "code": "CGD"
          },
          {
            "name": "ELISA DE BORDO",
            "code": "CBD"
          },
          {
            "name": "LAS JUNTAS",
            "code": "CLJ"
          },
          {
            "name": "LOS AZULES",
            "code": "CLZ"
          },
          {
            "name": "MINA LA COIPA",
            "code": "CMQ"
          },
          {
            "name": "NANTOCO",
            "code": "CNN"
          },
          {
            "name": "TOTORALILLO",
            "code": "RQM"
          },
          {
            "name": "PUQUIOS",
            "code": "QPQ"
          },
          {
            "name": "PASTOS LARGOS",
            "code": "QPL"
          },
          {
            "name": "HORNITOS - COPIAPO",
            "code": "QHN"
          },
          {
            "name": "PAIPOTE",
            "code": "PPE"
          },
          {
            "name": "MINA MARTE",
            "code": "MTE"
          },
          {
            "name": "MINA CANDELARIA",
            "code": "MCR"
          },
          {
            "name": "CHANARCILLO",
            "code": "CYO"
          },
          {
            "name": "TIERRA AMARILLA",
            "code": "TRM"
          },
          {
            "name": "SAN ANTONIO - COPIAP",
            "code": "SAI"
          },
          {
            "name": "LA PUERTA",
            "code": "CXA"
          },
          {
            "name": "VALLE HERMOSO",
            "code": "CVX"
          },
          {
            "name": "EL VOLCAN",
            "code": "CVO"
          },
          {
            "name": "LOS LOROS",
            "code": "CLW"
          }
        ]
      },
      {
        "name": "VALLENAR",
        "code": 3301,
        "defaultDistrict": "VAL",
        "districts": [
          {
            "name": "DOMEYKO",
            "code": "DYK"
          },
          {
            "name": "OBSERVATORIO CAMPANA",
            "code": "VOS"
          },
          {
            "name": "ALGARROBAL",
            "code": "VZV"
          },
          {
            "name": "EL DONKEY",
            "code": "VOB"
          },
          {
            "name": "OBSERVATORIO LA SILL",
            "code": "LSX"
          },
          {
            "name": "CACHIYUYO",
            "code": "VCQ"
          },
          {
            "name": "LA HOYADA",
            "code": "VHY"
          },
          {
            "name": "LOS COLORADOS",
            "code": "VLO"
          },
          {
            "name": "VALLENAR",
            "code": "VAL"
          },
          {
            "name": "EL BORATILLO",
            "code": "EBL"
          }
        ]
      }
    ]
  },
  {
    "name": "Coquimbo",
    "code": 4,
    "isocode": "CO",
    "ciudades": [
      {
        "name": "ANDACOLLO",
        "code": 4103,
        "defaultDistrict": "ACO",
        "districts": [
          {
            "name": "ANDACOLLO - LA SEREN",
            "code": "ACO"
          },
          {
            "name": "BARRANCAS",
            "code": "BRR"
          }
        ]
      },
      {
        "name": "CANELA",
        "code": 4202,
        "defaultDistrict": "CNE",
        "districts": [
          {
            "name": "CANELA",
            "code": "CNE"
          },
          {
            "name": "PUERTO OSCURO",
            "code": "POZ"
          },
          {
            "name": "MANTOS DE HORNILLOS",
            "code": "RMH"
          },
          {
            "name": "POZA HONDA",
            "code": "XZH"
          },
          {
            "name": "CALETA MORRITOS",
            "code": "RCC"
          }
        ]
      },
      {
        "name": "COMBARBALA",
        "code": 4302,
        "defaultDistrict": "COB",
        "districts": [
          {
            "name": "COMBARBALA",
            "code": "COB"
          },
          {
            "name": "LLAHUIN",
            "code": "OLH"
          },
          {
            "name": "COGOTI",
            "code": "RCT"
          },
          {
            "name": "SANTA CECILIA",
            "code": "SSC"
          },
          {
            "name": "LA LIGUA BAJO",
            "code": "RLU"
          },
          {
            "name": "QUILITAPIA",
            "code": "QWQ"
          },
          {
            "name": "PARMA",
            "code": "OPA"
          },
          {
            "name": "CHINGAY",
            "code": "ONG"
          },
          {
            "name": "HILARICOS",
            "code": "OHY"
          },
          {
            "name": "CHINEO",
            "code": "OCH"
          },
          {
            "name": "LAS COLORADAS",
            "code": "LZZ"
          }
        ]
      },
      {
        "name": "COQUIMBO",
        "code": 4102,
        "defaultDistrict": "COQ",
        "districts": [
          {
            "name": "COQUIMBO",
            "code": "COQ"
          },
          {
            "name": "TOTORALILLO - COQUIM",
            "code": "TOT"
          },
          {
            "name": "TONGOY",
            "code": "TGY"
          },
          {
            "name": "RETIRO - COQUIMBO",
            "code": "RTO"
          },
          {
            "name": "PUERTO VELERO",
            "code": "PVO"
          },
          {
            "name": "EL PENON - LA SERENA",
            "code": "PON"
          },
          {
            "name": "PLACILLA - COQUIMBO",
            "code": "PLM"
          },
          {
            "name": "PENUELAS - LA SERENA",
            "code": "PLB"
          },
          {
            "name": "LA HERRADURA",
            "code": "LRR"
          },
          {
            "name": "LAS TACAS",
            "code": "LTC"
          },
          {
            "name": "TIERRAS BLANCAS",
            "code": "LTB"
          },
          {
            "name": "PAN DE AZUCAR - SERE",
            "code": "LPZ"
          },
          {
            "name": "GUACHALALUME",
            "code": "GHC"
          },
          {
            "name": "GUANAQUEROS",
            "code": "GQS"
          }
        ]
      },
      {
        "name": "ILLAPEL",
        "code": 4201,
        "defaultDistrict": "ILL",
        "districts": [
          {
            "name": "CUZ CUZ - CALERA",
            "code": "AZZ"
          },
          {
            "name": "CHOAPA",
            "code": "CPA"
          },
          {
            "name": "TUNGA NORTE",
            "code": "ZTU"
          },
          {
            "name": "TUNGA SUR",
            "code": "ZTN"
          },
          {
            "name": "RABANALES",
            "code": "ZTL"
          },
          {
            "name": "CAREN - CALERA",
            "code": "ZNK"
          },
          {
            "name": "MINCHA SUR",
            "code": "ZMM"
          },
          {
            "name": "MINCHA",
            "code": "ZMH"
          },
          {
            "name": "MATANCILLA",
            "code": "ZMC"
          },
          {
            "name": "LAS PIRCAS",
            "code": "ZKZ"
          },
          {
            "name": "HUENTELAUQUEN",
            "code": "ZHT"
          },
          {
            "name": "HUINTIL",
            "code": "ZHN"
          },
          {
            "name": "FARELLON SANCHEZ",
            "code": "ZFA"
          },
          {
            "name": "LAS CANAS",
            "code": "LZC"
          },
          {
            "name": "ILLAPEL",
            "code": "ILL"
          },
          {
            "name": "COCUA",
            "code": "CCY"
          }
        ]
      },
      {
        "name": "LA HIGUERA",
        "code": 4104,
        "defaultDistrict": "LHC",
        "districts": [
          {
            "name": "EL OLIVO",
            "code": "EOV"
          },
          {
            "name": "INCAGUASI",
            "code": "LIH"
          },
          {
            "name": "LAS BREAS - SERENA",
            "code": "MQZ"
          },
          {
            "name": "TRES CRUCES",
            "code": "TCS"
          },
          {
            "name": "EL TOFO",
            "code": "TFO"
          },
          {
            "name": "PUNTA CHOROS",
            "code": "PHS"
          },
          {
            "name": "TRAPICHE - LA SERENA",
            "code": "LTH"
          },
          {
            "name": "CHOROS BAJOS",
            "code": "LKM"
          },
          {
            "name": "LA HIGUERA - LA SERE",
            "code": "LHC"
          },
          {
            "name": "CHUNGUNGO",
            "code": "LGY"
          },
          {
            "name": "LOS HORNOS",
            "code": "LHB"
          }
        ]
      },
      {
        "name": "LA SERENA",
        "code": 4101,
        "defaultDistrict": "LSC",
        "districts": [
          {
            "name": "AGUA GRANDE",
            "code": "AGG"
          },
          {
            "name": "SAN PABLO",
            "code": "XPB"
          },
          {
            "name": "TEATINOS",
            "code": "TNS"
          },
          {
            "name": "LAS ROJAS",
            "code": "RSE"
          },
          {
            "name": "LA SERENA",
            "code": "LSC"
          },
          {
            "name": "EL ROMERAL - SERENA",
            "code": "LER"
          },
          {
            "name": "EL ISLON",
            "code": "LEI"
          },
          {
            "name": "COQUIMBITO",
            "code": "LCQ"
          },
          {
            "name": "LAMBERT",
            "code": "LBT"
          },
          {
            "name": "EL CHACAY",
            "code": "HAY"
          },
          {
            "name": "LA COMPANIA - SERENA",
            "code": "GOS"
          },
          {
            "name": "ALTOVALSOL",
            "code": "AVS"
          },
          {
            "name": "ALMIRANTE LATORRE",
            "code": "ALT"
          }
        ]
      },
      {
        "name": "LOS VILOS",
        "code": 4203,
        "defaultDistrict": "LVL",
        "districts": [
          {
            "name": "CAIMANES",
            "code": "ANS"
          },
          {
            "name": "LOS VILOS",
            "code": "LVL"
          },
          {
            "name": "GUANGALI",
            "code": "ZIV"
          },
          {
            "name": "MAURO",
            "code": "ZMR"
          },
          {
            "name": "CASUTO",
            "code": "ZOQ"
          },
          {
            "name": "QUELON",
            "code": "ZQO"
          },
          {
            "name": "TILAMA",
            "code": "ZTI"
          },
          {
            "name": "QUILIMARI",
            "code": "ZQM"
          },
          {
            "name": "CHIGUALOCO",
            "code": "ZOA"
          },
          {
            "name": "LOS ERMITANOS",
            "code": "ZKK"
          },
          {
            "name": "TOTORALILLO - CALERA",
            "code": "TTZ"
          },
          {
            "name": "PICHIDANGUI",
            "code": "PCH"
          },
          {
            "name": "LOS MOLLES",
            "code": "LMO"
          },
          {
            "name": "PUPIO",
            "code": "LOI"
          }
        ]
      },
      {
        "name": "MONTE PATRIA",
        "code": 4303,
        "defaultDistrict": "MPC",
        "districts": [
          {
            "name": "CHANARAL ALTO - OVAL",
            "code": "CHZ"
          },
          {
            "name": "VALDIVIA - OVALLE",
            "code": "ZOV"
          },
          {
            "name": "BOCATOMA",
            "code": "XBC"
          },
          {
            "name": "EL CARRIZAL",
            "code": "OEC"
          },
          {
            "name": "CHILECITO",
            "code": "OCT"
          },
          {
            "name": "BANOS DEL GORDITO",
            "code": "OBG"
          },
          {
            "name": "MONTE PATRIA",
            "code": "MPC"
          },
          {
            "name": "LAS MOLLACAS",
            "code": "LMS"
          },
          {
            "name": "CAREN - OVALLE",
            "code": "KEN"
          },
          {
            "name": "GUATULAME",
            "code": "GUT"
          },
          {
            "name": "EL PALQUI",
            "code": "EPI"
          },
          {
            "name": "TULAHUEN",
            "code": "TNH"
          },
          {
            "name": "SAN MARCOS - OVALLE",
            "code": "SMC"
          },
          {
            "name": "RAPEL - OVALLE",
            "code": "RQW"
          },
          {
            "name": "EL MAQUI ",
            "code": "RMQ"
          },
          {
            "name": "LAS RAMADAS",
            "code": "RLR"
          },
          {
            "name": "LAS JUNTAS - OVALLE",
            "code": "RLJ"
          },
          {
            "name": "PEDREGAL",
            "code": "RGR"
          },
          {
            "name": "SAN LORENZO - OVALLE",
            "code": "RFG"
          },
          {
            "name": "EL MAITEN",
            "code": "REM"
          },
          {
            "name": "CENTRAL LOS MOLLES",
            "code": "RCM"
          }
        ]
      },
      {
        "name": "OVALLE",
        "code": 4301,
        "defaultDistrict": "OVL",
        "districts": [
          {
            "name": "CHALINGA",
            "code": "AGA"
          },
          {
            "name": "LAS CARDAS",
            "code": "LLS"
          },
          {
            "name": "LA TORRE",
            "code": "LAT"
          },
          {
            "name": "LA CHIMBA",
            "code": "OLB"
          },
          {
            "name": "OVALLE",
            "code": "OVL"
          },
          {
            "name": "TERMAS DE SOCO",
            "code": "SQT"
          },
          {
            "name": "SOTAQUI",
            "code": "SOZ"
          },
          {
            "name": "SAMO ALTO",
            "code": "RVG"
          },
          {
            "name": "SAMO BAJO",
            "code": "RVF"
          },
          {
            "name": "RECOLETA",
            "code": "RTG"
          },
          {
            "name": "ALGARROBITO - OVALLE",
            "code": "RRG"
          },
          {
            "name": "BARRAZA",
            "code": "RRB"
          },
          {
            "name": "CAMARICO VIEJO",
            "code": "RQV"
          },
          {
            "name": "PEJERREYES",
            "code": "RPJ"
          },
          {
            "name": "LIMARI",
            "code": "RLI"
          },
          {
            "name": "HIGUERITAS",
            "code": "RHG"
          },
          {
            "name": "GUAMPULLA",
            "code": "RGU"
          },
          {
            "name": "EL ALTAR",
            "code": "REA"
          },
          {
            "name": "QUEBRADA SECA",
            "code": "QWR"
          },
          {
            "name": "PACHINGO",
            "code": "PIC"
          },
          {
            "name": "OTAROLA",
            "code": "OTR"
          },
          {
            "name": "GUAMALATA",
            "code": "OGT"
          },
          {
            "name": "CERRILLOS DE TAMAYA",
            "code": "CTY"
          },
          {
            "name": "CAMARICO",
            "code": "CRI"
          }
        ]
      },
      {
        "name": "PAIGUANO",
        "code": 4105,
        "defaultDistrict": "PHO",
        "districts": [
          {
            "name": "COCHIGUAS",
            "code": "CGS"
          },
          {
            "name": "MINA DEL INDIO",
            "code": "LMX"
          },
          {
            "name": "MONTE GRANDE",
            "code": "LMG"
          },
          {
            "name": "LLANOS DE GUANTA",
            "code": "LLG"
          },
          {
            "name": "CHAPILCA",
            "code": "LKK"
          },
          {
            "name": "JUNTAS DEL TORO",
            "code": "LJZ"
          },
          {
            "name": "LAS HEDIONDAS",
            "code": "LHD"
          },
          {
            "name": "GUANTA",
            "code": "LGU"
          },
          {
            "name": "BALALA",
            "code": "LBW"
          },
          {
            "name": "SOL NACIENTE",
            "code": "TAL"
          },
          {
            "name": "PAIHUANO",
            "code": "PHO"
          },
          {
            "name": "NUEVA ELQUI",
            "code": "NEQ"
          },
          {
            "name": "ALCOHUAS",
            "code": "MRR"
          },
          {
            "name": "VARILLAR",
            "code": "LVR"
          },
          {
            "name": "RIVADAVIA",
            "code": "LRV"
          },
          {
            "name": "BANOS DEL TORO",
            "code": "LBJ"
          },
          {
            "name": "PISCO ELQUI",
            "code": "ELQ"
          }
        ]
      },
      {
        "name": "PUNITAQUI",
        "code": 4304,
        "defaultDistrict": "PTQ",
        "districts": [
          {
            "name": "LOS PERALES - OVALLE",
            "code": "LZP"
          },
          {
            "name": "PUNITAQUI",
            "code": "PTQ"
          },
          {
            "name": "LA AGUADA",
            "code": "RLG"
          },
          {
            "name": "LITIPAMPA",
            "code": "RLL"
          },
          {
            "name": "PENA BLANCA",
            "code": "OPB"
          },
          {
            "name": "LA PLACILLA",
            "code": "OLP"
          }
        ]
      },
      {
        "name": "RIO HURTADO",
        "code": 4305,
        "defaultDistrict": "RHU",
        "districts": [
          {
            "name": "CHANAR ",
            "code": "LHH"
          },
          {
            "name": "CORRAL QUEMADO",
            "code": "RQO"
          },
          {
            "name": "PICHASCA",
            "code": "RPI"
          },
          {
            "name": "PABELLON - OVALLE",
            "code": "RPB"
          },
          {
            "name": "LA FUNDINA",
            "code": "RLF"
          },
          {
            "name": "LAS BREAS - OVALLE",
            "code": "RLB"
          },
          {
            "name": "RIO HURTADO",
            "code": "RHU"
          },
          {
            "name": "HURTADO",
            "code": "RHT"
          },
          {
            "name": "ALTO BUEY",
            "code": "OAY"
          },
          {
            "name": "HACIENDA LOS ANDES",
            "code": "XMR"
          }
        ]
      },
      {
        "name": "SALAMANCA",
        "code": 4204,
        "defaultDistrict": "SCA",
        "districts": [
          {
            "name": "ARBOLEDA GRANDE",
            "code": "ABG"
          },
          {
            "name": "LOS PELADEROS",
            "code": "LSO"
          },
          {
            "name": "CHELLEPIN",
            "code": "LNI"
          },
          {
            "name": "PALQUIAL",
            "code": "PZC"
          },
          {
            "name": "BATUCO - CALERA",
            "code": "ZBG"
          },
          {
            "name": "JORQUERA",
            "code": "ZJO"
          },
          {
            "name": "ZAPALLAR",
            "code": "ZPF"
          },
          {
            "name": "LIMAHUIDA",
            "code": "ZVH"
          },
          {
            "name": "SAN AGUSTIN",
            "code": "ZSG"
          },
          {
            "name": "COIRON",
            "code": "ZNP"
          },
          {
            "name": "EL TAMBO - CALERA",
            "code": "ZET"
          },
          {
            "name": "ALMENDRALILLO",
            "code": "ZAM"
          },
          {
            "name": "SALAMANCA",
            "code": "SCA"
          },
          {
            "name": "LLIMPO",
            "code": "LLP"
          }
        ]
      },
      {
        "name": "VICUNA",
        "code": 4106,
        "defaultDistrict": "VCA",
        "districts": [
          {
            "name": "ANDACOLLO HOLDING",
            "code": "AVU"
          },
          {
            "name": "CORTADERA",
            "code": "CEA"
          },
          {
            "name": "CASERONES",
            "code": "LCR"
          },
          {
            "name": "LA LAJA",
            "code": "YCV"
          },
          {
            "name": "VICUNA",
            "code": "VCA"
          },
          {
            "name": "EL TAMBO - LA SERENA",
            "code": "TBE"
          },
          {
            "name": "PERALILLO - SERENA",
            "code": "PLV"
          },
          {
            "name": "VINITA BAJA",
            "code": "LVT"
          },
          {
            "name": "OBSERVATORIO TOLOLO",
            "code": "LOO"
          },
          {
            "name": "EL ROMERAL - SERENA",
            "code": "LEM"
          },
          {
            "name": "CONDORIACO",
            "code": "LCO"
          },
          {
            "name": "DIAGUITAS",
            "code": "DTS"
          }
        ]
      }
    ]
  },
  {
    "name": "Valparaiso",
    "code": 5,
    "isocode": "VS",
    "ciudades": [
      {
        "name": "ALGARROBO",
        "code": 5602,
        "defaultDistrict": "ABO",
        "districts": [
          {
            "name": "ALGARROBO - MELIPILL",
            "code": "ABO"
          },
          {
            "name": "QUINTAY",
            "code": "QTY"
          },
          {
            "name": "MIRASOL",
            "code": "MRL"
          }
        ]
      },
      {
        "name": "CABILDO",
        "code": 5402,
        "defaultDistrict": "CDO",
        "districts": [
          {
            "name": "CABILDO",
            "code": "CDO"
          },
          {
            "name": "LA MORA",
            "code": "LAO"
          },
          {
            "name": "ALICAHUE",
            "code": "ZAI"
          },
          {
            "name": "EL GUAYACAN",
            "code": "ZEG"
          },
          {
            "name": "SAN LORENZO - CALERA",
            "code": "ZSL"
          },
          {
            "name": "SANTA MARTA - CALERA",
            "code": "ZST"
          },
          {
            "name": "ARTIFICIO",
            "code": "ZAT"
          },
          {
            "name": "LA VINA ",
            "code": "XLV"
          },
          {
            "name": "PEDEGUA",
            "code": "PUA"
          },
          {
            "name": "LAS PALMAS",
            "code": "LSA"
          }
        ]
      },
      {
        "name": "CALERA",
        "code": 5502,
        "defaultDistrict": "ZLC",
        "districts": [
          {
            "name": "LA CALERA",
            "code": "ZLC"
          }
        ]
      },
      {
        "name": "CALLE LARGA",
        "code": 5302,
        "defaultDistrict": "CLG",
        "districts": [
          {
            "name": "CALLE LARGA",
            "code": "CLG"
          }
        ]
      },
      {
        "name": "CARTAGENA",
        "code": 5603,
        "defaultDistrict": "CRT",
        "districts": [
          {
            "name": "LO ABARCA",
            "code": "ABA"
          },
          {
            "name": "SAN SEBASTIAN - MELI",
            "code": "SSB"
          },
          {
            "name": "LAS CRUCES",
            "code": "LCX"
          },
          {
            "name": "EL TURCO",
            "code": "KER"
          },
          {
            "name": "CARTAGENA",
            "code": "CRT"
          }
        ]
      },
      {
        "name": "CASABLANCA",
        "code": 5102,
        "defaultDistrict": "CBC",
        "districts": [
          {
            "name": "CASABLANCA",
            "code": "CBC"
          },
          {
            "name": "LAS DICHAS",
            "code": "KHD"
          },
          {
            "name": "LO OROZCO",
            "code": "KLO"
          },
          {
            "name": "LAS MERCEDES",
            "code": "KME"
          },
          {
            "name": "TAPIHUE",
            "code": "KTH"
          },
          {
            "name": "SAN GERONIMO",
            "code": "KSG"
          },
          {
            "name": "LO VASQUEZ",
            "code": "KLV"
          },
          {
            "name": "LAGUNILLAS",
            "code": "KLL"
          },
          {
            "name": "EL CARPINTERO",
            "code": "KEC"
          }
        ]
      },
      {
        "name": "CATEMU",
        "code": 5702,
        "defaultDistrict": "CAT",
        "districts": [
          {
            "name": "CATEMU",
            "code": "CAT"
          },
          {
            "name": "EL CERRADO",
            "code": "SWC"
          },
          {
            "name": "CHAGRES",
            "code": "SHW"
          },
          {
            "name": "NILHUE",
            "code": "SNW"
          },
          {
            "name": "EL COBRE - LOS ANDES",
            "code": "SOW"
          }
        ]
      },
      {
        "name": "CONCON",
        "code": 5103,
        "defaultDistrict": "CON",
        "districts": [
          {
            "name": "CONCON",
            "code": "CON"
          }
        ]
      },
      {
        "name": "EL QUISCO",
        "code": 5604,
        "defaultDistrict": "EQO",
        "districts": [
          {
            "name": "COSTA AZUL",
            "code": "AZU"
          },
          {
            "name": "PUNTA DE TRALCA",
            "code": "KPT"
          },
          {
            "name": "ISLA NEGRA",
            "code": "INE"
          },
          {
            "name": "EL QUISCO",
            "code": "EQO"
          }
        ]
      },
      {
        "name": "EL TABO",
        "code": 5605,
        "defaultDistrict": "ETB",
        "districts": [
          {
            "name": "EL TABO",
            "code": "ETB"
          }
        ]
      },
      {
        "name": "HIJUELAS",
        "code": 5503,
        "defaultDistrict": "HJS",
        "districts": [
          {
            "name": "HIJUELAS",
            "code": "HJS"
          }
        ]
      },
      {
        "name": "ISLA DE PASCUA",
        "code": 5201,
        "defaultDistrict": "IPC",
        "districts": [
          {
            "name": "ISLA DE PASCUA",
            "code": "IPC"
          }
        ]
      },
      {
        "name": "JUAN FERNANDEZ",
        "code": 5104,
        "defaultDistrict": "JFZ",
        "districts": [
          {
            "name": "ISLA JUAN FERNANDEZ",
            "code": "JFZ"
          }
        ]
      },
      {
        "name": "LA CRUZ",
        "code": 5504,
        "defaultDistrict": "LCZ",
        "districts": [
          {
            "name": "LA CRUZ - CALERA",
            "code": "LCZ"
          },
          {
            "name": "OCOA",
            "code": "SOX"
          }
        ]
      },
      {
        "name": "LA LIGUA",
        "code": 5401,
        "defaultDistrict": "LLC",
        "districts": [
          {
            "name": "LONGOTOMA",
            "code": "GMA"
          },
          {
            "name": "LA LIGUA",
            "code": "LLC"
          },
          {
            "name": "PICHICUY",
            "code": "PZY"
          },
          {
            "name": "TRAPICHE - CALERA",
            "code": "ZEW"
          },
          {
            "name": "LA PATAGUA",
            "code": "ZGC"
          },
          {
            "name": "QUINQUIMO",
            "code": "ZQQ"
          },
          {
            "name": "EL INGENIO",
            "code": "ZEI"
          },
          {
            "name": "CALETA POLCURA",
            "code": "LAR"
          }
        ]
      },
      {
        "name": "LIMACHE",
        "code": 5505,
        "defaultDistrict": "LIC",
        "districts": [
          {
            "name": "LIMACHE",
            "code": "LIC"
          },
          {
            "name": "QUEBRADA ALVARADO",
            "code": "ZQB"
          }
        ]
      },
      {
        "name": "LLAILLAY",
        "code": 5703,
        "defaultDistrict": "LLY",
        "districts": [
          {
            "name": "LLAILLAY",
            "code": "LLY"
          },
          {
            "name": "MONTENEGRO",
            "code": "SMQ"
          },
          {
            "name": "RUNGUE",
            "code": "SER"
          }
        ]
      },
      {
        "name": "LOS ANDES",
        "code": 5301,
        "defaultDistrict": "LOB",
        "districts": [
          {
            "name": "LOS ANDES",
            "code": "LOB"
          },
          {
            "name": "GUARDIA VIEJA",
            "code": "SGZ"
          },
          {
            "name": "RIO BLANCO",
            "code": "SRB"
          },
          {
            "name": "SALTO DEL SOLDADO",
            "code": "SSD"
          },
          {
            "name": "JUNCAL",
            "code": "SJH"
          },
          {
            "name": "SALADILLO",
            "code": "SDO"
          },
          {
            "name": "PORTILLO",
            "code": "PRT"
          }
        ]
      },
      {
        "name": "NOGALES",
        "code": 5506,
        "defaultDistrict": "NOG",
        "districts": [
          {
            "name": "EL MELON",
            "code": "EML"
          },
          {
            "name": "EL COBRE - CALERA",
            "code": "ZEC"
          },
          {
            "name": "NOGALES",
            "code": "NOG"
          }
        ]
      },
      {
        "name": "OLMUE",
        "code": 5507,
        "defaultDistrict": "OLM",
        "districts": [
          {
            "name": "OLMUE",
            "code": "OLM"
          },
          {
            "name": "GRANIZO",
            "code": "ZGR"
          },
          {
            "name": "SAN PEDRO - CALERA",
            "code": "ZDD"
          }
        ]
      },
      {
        "name": "PANQUEHUE",
        "code": 5704,
        "defaultDistrict": "PNQ",
        "districts": [
          {
            "name": "PANQUEHUE",
            "code": "PNQ"
          },
          {
            "name": "LO  ERRAZURIZ",
            "code": "SLZ"
          }
        ]
      },
      {
        "name": "PAPUDO",
        "code": 5403,
        "defaultDistrict": "PPO",
        "districts": [
          {
            "name": "PAPUDO",
            "code": "PPO"
          }
        ]
      },
      {
        "name": "PETORCA",
        "code": 5404,
        "defaultDistrict": "PTK",
        "districts": [
          {
            "name": "CHALACO",
            "code": "LOA"
          },
          {
            "name": "PETORCA",
            "code": "PTK"
          },
          {
            "name": "PEDERNAL",
            "code": "ZDR"
          },
          {
            "name": "CHINCOLCO",
            "code": "OLC"
          },
          {
            "name": "MINA EL ROSARIO",
            "code": "ZMS"
          },
          {
            "name": "MANUEL MONTT",
            "code": "ZMU"
          },
          {
            "name": "HIERRO VIEJO",
            "code": "ZHR"
          }
        ]
      },
      {
        "name": "PUCHUNCAVI",
        "code": 5105,
        "defaultDistrict": "PCV",
        "districts": [
          {
            "name": "CANELA BAJA",
            "code": "CNB"
          },
          {
            "name": "LA LAGUNA",
            "code": "LGN"
          },
          {
            "name": "MAITENCILLO - CALERA",
            "code": "MTC"
          },
          {
            "name": "CALETA HORCON",
            "code": "LNO"
          },
          {
            "name": "CANELA ALTA",
            "code": "ZZC"
          },
          {
            "name": "EL RINCON",
            "code": "ZQD"
          },
          {
            "name": "VENTANAS",
            "code": "VTA"
          },
          {
            "name": "LA QUEBRADA - CALERA",
            "code": "QZC"
          },
          {
            "name": "PUCHUNCAVI",
            "code": "PCV"
          }
        ]
      },
      {
        "name": "PUTAENDO",
        "code": 5705,
        "defaultDistrict": "PUT",
        "districts": [
          {
            "name": "PUTAENDO",
            "code": "PUT"
          },
          {
            "name": "GRANALLA",
            "code": "SGY"
          },
          {
            "name": "RINCONADA DE GUZMAN",
            "code": "SRG"
          },
          {
            "name": "RINCONADA DE SILVA",
            "code": "SRS"
          },
          {
            "name": "TRES FUERTES",
            "code": "TRE"
          },
          {
            "name": "EL TARTARO",
            "code": "STY"
          },
          {
            "name": "RESGUARDO LOS PATOS",
            "code": "SRP"
          }
        ]
      },
      {
        "name": "QUILLOTA",
        "code": 5501,
        "defaultDistrict": "QTA",
        "districts": [
          {
            "name": "QUILLOTA",
            "code": "QTA"
          }
        ]
      },
      {
        "name": "QUILPUE",
        "code": 5106,
        "defaultDistrict": "QPE",
        "districts": [
          {
            "name": "EL BELLOTO",
            "code": "EBT"
          },
          {
            "name": "LA RETUCA",
            "code": "KLR"
          },
          {
            "name": "QUILPUE",
            "code": "QPE"
          }
        ]
      },
      {
        "name": "QUINTERO",
        "code": 5107,
        "defaultDistrict": "QTO",
        "districts": [
          {
            "name": "VALLE ALEGRE",
            "code": "BAG"
          },
          {
            "name": "RITOQUE",
            "code": "ZRV"
          },
          {
            "name": "QUINTERO",
            "code": "QTO"
          }
        ]
      },
      {
        "name": "RINCONADA",
        "code": 5303,
        "defaultDistrict": "RDA",
        "districts": [
          {
            "name": "RINCONADA - LOS ANDE",
            "code": "RDA"
          }
        ]
      },
      {
        "name": "SAN ANTONIO",
        "code": 5601,
        "defaultDistrict": "SNT",
        "districts": [
          {
            "name": "LLO-LLEO",
            "code": "LLO"
          },
          {
            "name": "SAN ANTONIO - MELIP.",
            "code": "SNT"
          }
        ]
      },
      {
        "name": "SAN ESTEBAN",
        "code": 5304,
        "defaultDistrict": "SEN",
        "districts": [
          {
            "name": "SAN ESTEBAN",
            "code": "SEN"
          }
        ]
      },
      {
        "name": "SAN FELIPE",
        "code": 5701,
        "defaultDistrict": "SFP",
        "districts": [
          {
            "name": "CURIMON",
            "code": "CRM"
          },
          {
            "name": "CERRILLOS DE SAN FEL",
            "code": "CSP"
          },
          {
            "name": "SAN FELIPE",
            "code": "SFP"
          }
        ]
      },
      {
        "name": "SANTA MARIA",
        "code": 5706,
        "defaultDistrict": "SRI",
        "districts": [
          {
            "name": "JAHUEL",
            "code": "JHL"
          },
          {
            "name": "SANTA MARIA",
            "code": "SRI"
          },
          {
            "name": "TERMAS DE JAHUEL",
            "code": "TJL"
          }
        ]
      },
      {
        "name": "SANTO DOMINGO",
        "code": 5606,
        "defaultDistrict": "SDC",
        "districts": [
          {
            "name": "LO GALLARDO",
            "code": "KLG"
          },
          {
            "name": "SANTO DOMINGO",
            "code": "SDC"
          },
          {
            "name": "LEYDA",
            "code": "KLY"
          }
        ]
      },
      {
        "name": "VALPARAISO",
        "code": 5101,
        "defaultDistrict": "VAP",
        "districts": [
          {
            "name": "CALETAS LAS DOCAS",
            "code": "KCD"
          },
          {
            "name": "PUNTA CURAUMILLA",
            "code": "KPC"
          },
          {
            "name": "LAS TABLAS",
            "code": "KLT"
          },
          {
            "name": "VALPARAISO",
            "code": "VAP"
          },
          {
            "name": "PLACILLA - V DEL MAR",
            "code": "PLP"
          },
          {
            "name": "PENUELAS - V DEL MAR",
            "code": "KPE"
          },
          {
            "name": "LAGUNA VERDE",
            "code": "LAV"
          }
        ]
      },
      {
        "name": "VILLA ALEMANA",
        "code": 5108,
        "defaultDistrict": "VIA",
        "districts": [
          {
            "name": "PENABLANCA",
            "code": "PBA"
          },
          {
            "name": "VILLA ALEMANA",
            "code": "VIA"
          }
        ]
      },
      {
        "name": "VINA DEL MAR",
        "code": 5109,
        "defaultDistrict": "KNA",
        "districts": [
          {
            "name": "VINA DEL MAR",
            "code": "KNA"
          },
          {
            "name": "RENACA",
            "code": "RCA"
          }
        ]
      },
      {
        "name": "ZAPALLAR",
        "code": 5405,
        "defaultDistrict": "ZAR",
        "districts": [
          {
            "name": "CACHAGUA",
            "code": "CGU"
          },
          {
            "name": "ZAPALLAR - CALERA",
            "code": "ZAR"
          },
          {
            "name": "CATAPILCO",
            "code": "PIL"
          }
        ]
      }
    ]
  },
  {
    "name": "Metropolitana de Santiago",
    "code": 13,
    "isocode": "RM",
    "ciudades": [
      {
        "name": "ALHUE",
        "code": 13502,
        "defaultDistrict": "ALH",
        "districts": [
          {
            "name": "ALHUE",
            "code": "ALH"
          },
          {
            "name": "VILLA ALHUE",
            "code": "SVH"
          },
          {
            "name": "LONCHA",
            "code": "ZKU"
          },
          {
            "name": "LO CHACON",
            "code": "HAC"
          },
          {
            "name": "EL MEMBRILLO",
            "code": "MMZ"
          },
          {
            "name": "LA CRUZ MELIPILLA",
            "code": "LZU"
          }
        ]
      },
      {
        "name": "BUIN",
        "code": 13402,
        "defaultDistrict": "ZBU",
        "districts": [
          {
            "name": "MAIPO",
            "code": "MIP"
          },
          {
            "name": "BUIN",
            "code": "ZBU"
          }
        ]
      },
      {
        "name": "CALERA DE TANGO",
        "code": 13403,
        "defaultDistrict": "CDT",
        "districts": [
          {
            "name": "CALERA DE TANGO",
            "code": "CDT"
          },
          {
            "name": "ALTO JAHUEL",
            "code": "SAJ"
          }
        ]
      },
      {
        "name": "CERRILLOS",
        "code": 13102,
        "defaultDistrict": "RRI",
        "districts": [
          {
            "name": "CERRILLOS",
            "code": "RRI"
          }
        ]
      },
      {
        "name": "CERRO NAVIA",
        "code": 13103,
        "defaultDistrict": "CNV",
        "districts": [
          {
            "name": "CERRO NAVIA",
            "code": "CNV"
          }
        ]
      },
      {
        "name": "COLINA",
        "code": 13301,
        "defaultDistrict": "COL",
        "districts": [
          {
            "name": "CHICUREO",
            "code": "CHW"
          },
          {
            "name": "COLINA",
            "code": "COL"
          },
          {
            "name": "LAS CANTERAS",
            "code": "SLN"
          },
          {
            "name": "ESMERALDA",
            "code": "ESB"
          }
        ]
      },
      {
        "name": "CONCHALI",
        "code": 13104,
        "defaultDistrict": "CNH",
        "districts": [
          {
            "name": "CONCHALI",
            "code": "CNH"
          }
        ]
      },
      {
        "name": "CURACAVI",
        "code": 13503,
        "defaultDistrict": "CVI",
        "districts": [
          {
            "name": "EL TREBOL",
            "code": "TRB"
          },
          {
            "name": "LOS ARRAYANES",
            "code": "LYR"
          },
          {
            "name": "CURACAVI",
            "code": "CVI"
          }
        ]
      },
      {
        "name": "EL BOSQUE",
        "code": 13105,
        "defaultDistrict": "EBO",
        "districts": [
          {
            "name": "EL BOSQUE",
            "code": "EBO"
          }
        ]
      },
      {
        "name": "EL MONTE",
        "code": 13602,
        "defaultDistrict": "ZTE",
        "districts": [
          {
            "name": "EL PAICO",
            "code": "EPC"
          },
          {
            "name": "EL MONTE",
            "code": "ZTE"
          }
        ]
      },
      {
        "name": "ESTACION CENTRAL",
        "code": 13106,
        "defaultDistrict": "ECE",
        "districts": [
          {
            "name": "ESTACION CENTRAL",
            "code": "ECE"
          }
        ]
      },
      {
        "name": "HUECHURABA",
        "code": 13107,
        "defaultDistrict": "HRB",
        "districts": [
          {
            "name": "HUECHURABA",
            "code": "HRB"
          }
        ]
      },
      {
        "name": "INDEPENDENCIA",
        "code": 13108,
        "defaultDistrict": "IDP",
        "districts": [
          {
            "name": "INDEPENDENCIA",
            "code": "IDP"
          }
        ]
      },
      {
        "name": "ISLA DE MAIPO",
        "code": 13603,
        "defaultDistrict": "IDM",
        "districts": [
          {
            "name": "ISLA DE MAIPO",
            "code": "IDM"
          }
        ]
      },
      {
        "name": "LA CISTERNA",
        "code": 13109,
        "defaultDistrict": "LCN",
        "districts": [
          {
            "name": "LA CISTERNA",
            "code": "LCN"
          }
        ]
      },
      {
        "name": "LA FLORIDA",
        "code": 13110,
        "defaultDistrict": "LFD",
        "districts": [
          {
            "name": "LA FLORIDA",
            "code": "LFD"
          }
        ]
      },
      {
        "name": "LA GRANJA",
        "code": 13111,
        "defaultDistrict": "LGJ",
        "districts": [
          {
            "name": "LA GRANJA",
            "code": "LGJ"
          }
        ]
      },
      {
        "name": "LA PINTANA",
        "code": 13112,
        "defaultDistrict": "LPT",
        "districts": [
          {
            "name": "LA PINTANA",
            "code": "LPT"
          }
        ]
      },
      {
        "name": "LA REINA",
        "code": 13113,
        "defaultDistrict": "LRN",
        "districts": [
          {
            "name": "LA REINA",
            "code": "LRN"
          }
        ]
      },
      {
        "name": "LAMPA",
        "code": 13302,
        "defaultDistrict": "LSG",
        "districts": [
          {
            "name": "LAMPA",
            "code": "LSG"
          },
          {
            "name": "BATUCO",
            "code": "SBX"
          }
        ]
      },
      {
        "name": "LAS CONDES",
        "code": 13114,
        "defaultDistrict": "LCD",
        "districts": [
          {
            "name": "LAS CONDES",
            "code": "LCD"
          }
        ]
      },
      {
        "name": "LO BARNECHEA",
        "code": 13115,
        "defaultDistrict": "LBR",
        "districts": [
          {
            "name": "FARELLONES",
            "code": "FAR"
          },
          {
            "name": "LO BARNECHEA",
            "code": "LBR"
          }
        ]
      },
      {
        "name": "LO ESPEJO",
        "code": 13116,
        "defaultDistrict": "LEP",
        "districts": [
          {
            "name": "LO ESPEJO",
            "code": "LEP"
          }
        ]
      },
      {
        "name": "LO PRADO",
        "code": 13117,
        "defaultDistrict": "LPR",
        "districts": [
          {
            "name": "LO PRADO",
            "code": "LPR"
          }
        ]
      },
      {
        "name": "MACUL",
        "code": 13118,
        "defaultDistrict": "MAC",
        "districts": [
          {
            "name": "MACUL",
            "code": "MAC"
          }
        ]
      },
      {
        "name": "MAIPU",
        "code": 13119,
        "defaultDistrict": "MAI",
        "districts": [
          {
            "name": "MAIPU",
            "code": "MAI"
          }
        ]
      },
      {
        "name": "MARIA PINTO",
        "code": 13504,
        "defaultDistrict": "MPO",
        "districts": [
          {
            "name": "LOLENCO - MELIPILLA",
            "code": "KET"
          },
          {
            "name": "LOS RULOS",
            "code": "SLR"
          },
          {
            "name": "SANTA INES",
            "code": "SIS"
          },
          {
            "name": "MARIA PINTO",
            "code": "MPO"
          },
          {
            "name": "CHOROMBO",
            "code": "SCM"
          },
          {
            "name": "BOLLENAR",
            "code": "SBR"
          }
        ]
      },
      {
        "name": "MELIPILLA",
        "code": 13501,
        "defaultDistrict": "ZMP",
        "districts": [
          {
            "name": "CHOCALAN ",
            "code": "AAN"
          },
          {
            "name": "MELIPILLA",
            "code": "ZMP"
          },
          {
            "name": "CODIGUA",
            "code": "ZCD"
          },
          {
            "name": "PABELLON - MELIPILLA",
            "code": "SPB"
          },
          {
            "name": "SAN MANUEL",
            "code": "SMN"
          },
          {
            "name": "MANDINGA",
            "code": "SMD"
          },
          {
            "name": "LAS MARIPOSAS - MELI",
            "code": "SLM"
          },
          {
            "name": "POMAIRE",
            "code": "IRE"
          },
          {
            "name": "CULIPRAN",
            "code": "CLP"
          }
        ]
      },
      {
        "name": "NUNOA",
        "code": 13120,
        "defaultDistrict": "NNA",
        "districts": [
          {
            "name": "NUNOA",
            "code": "NNA"
          }
        ]
      },
      {
        "name": "PADRE HURTADO",
        "code": 13604,
        "defaultDistrict": "PHT",
        "districts": [
          {
            "name": "LONQUEN",
            "code": "LQN"
          },
          {
            "name": "PADRE HURTADO",
            "code": "PHT"
          }
        ]
      },
      {
        "name": "PAINE",
        "code": 13404,
        "defaultDistrict": "ZPN",
        "districts": [
          {
            "name": "CHAMPA",
            "code": "CHP"
          },
          {
            "name": "HUELQUEN",
            "code": "SHU"
          },
          {
            "name": "PINTUE",
            "code": "SPT"
          },
          {
            "name": "PAINE",
            "code": "ZPN"
          },
          {
            "name": "RANGUE",
            "code": "ZUU"
          },
          {
            "name": "EL TRANSITO - SANTIA",
            "code": "TTO"
          },
          {
            "name": "SANTA MARTA",
            "code": "SMP"
          },
          {
            "name": "LINDEROS",
            "code": "SLD"
          },
          {
            "name": "HOSPITAL",
            "code": "HOS"
          }
        ]
      },
      {
        "name": "PEDRO AGUIRRE CERDA",
        "code": 13121,
        "defaultDistrict": "PAC",
        "districts": [
          {
            "name": "PEDRO AGUIRRE CERDA",
            "code": "PAC"
          }
        ]
      },
      {
        "name": "PENAFLOR",
        "code": 13605,
        "defaultDistrict": "PFL",
        "districts": [
          {
            "name": "MALLOCO",
            "code": "MLL"
          },
          {
            "name": "PENAFLOR",
            "code": "PFL"
          }
        ]
      },
      {
        "name": "PENALOLEN",
        "code": 13122,
        "defaultDistrict": "PNL",
        "districts": [
          {
            "name": "PENALOLEN",
            "code": "PNL"
          }
        ]
      },
      {
        "name": "PIRQUE",
        "code": 13202,
        "defaultDistrict": "PIR",
        "districts": [
          {
            "name": "ISLA DE PIRQUE",
            "code": "IPQ"
          },
          {
            "name": "PIRQUE",
            "code": "PIR"
          }
        ]
      },
      {
        "name": "PROVIDENCIA",
        "code": 13123,
        "defaultDistrict": "PRO",
        "districts": [
          {
            "name": "PROVIDENCIA",
            "code": "PRO"
          }
        ]
      },
      {
        "name": "PUDAHUEL",
        "code": 13124,
        "defaultDistrict": "PUD",
        "districts": [
          {
            "name": "AEROPUERTO ARTURO ME",
            "code": "AMB"
          },
          {
            "name": "PUDAHUEL",
            "code": "PUD"
          }
        ]
      },
      {
        "name": "PUENTE ALTO",
        "code": 13201,
        "defaultDistrict": "PAL",
        "districts": [
          {
            "name": "PUENTE ALTO",
            "code": "PAL"
          },
          {
            "name": "LA OBRA",
            "code": "SLO"
          },
          {
            "name": "LAS VERTIENTES",
            "code": "SLV"
          },
          {
            "name": "EL CANELO",
            "code": "SEC"
          }
        ]
      },
      {
        "name": "QUILICURA",
        "code": 13125,
        "defaultDistrict": "QLC",
        "districts": [
          {
            "name": "QUILICURA",
            "code": "QLC"
          }
        ]
      },
      {
        "name": "QUINTA NORMAL",
        "code": 13126,
        "defaultDistrict": "QTN",
        "districts": [
          {
            "name": "QUINTA NORMAL",
            "code": "QTN"
          }
        ]
      },
      {
        "name": "RECOLETA",
        "code": 13127,
        "defaultDistrict": "RLT",
        "districts": [
          {
            "name": "RECOLETA",
            "code": "RLT"
          }
        ]
      },
      {
        "name": "RENCA",
        "code": 13128,
        "defaultDistrict": "REN",
        "districts": [
          {
            "name": "RENCA",
            "code": "REN"
          }
        ]
      },
      {
        "name": "SAN BERNARDO",
        "code": 13401,
        "defaultDistrict": "SBD",
        "districts": [
          {
            "name": "SAN BERNARDO",
            "code": "SBD"
          }
        ]
      },
      {
        "name": "SAN JOAQUIN",
        "code": 13129,
        "defaultDistrict": "SJQ",
        "districts": [
          {
            "name": "SAN JOAQUIN",
            "code": "SJQ"
          }
        ]
      },
      {
        "name": "SAN JOSE DE MAIPO",
        "code": 13203,
        "defaultDistrict": "SJS",
        "districts": [
          {
            "name": "EL MELOCOTON",
            "code": "EME"
          },
          {
            "name": "SAN GABRIEL",
            "code": "SGB"
          },
          {
            "name": "LAS MELOSAS",
            "code": "SLS"
          },
          {
            "name": "EL MANZANILLO",
            "code": "SMI"
          },
          {
            "name": "VILLA DEL VALLE",
            "code": "SRV"
          },
          {
            "name": "EL VOLCAN",
            "code": "SVV"
          },
          {
            "name": "LOS QUELTEHUES",
            "code": "XQT"
          },
          {
            "name": "GUAYACAN",
            "code": "SYY"
          },
          {
            "name": "LO VALDES",
            "code": "STQ"
          },
          {
            "name": "LOS MAITENES",
            "code": "SMT"
          },
          {
            "name": "SAN JOSE DE MAIPO",
            "code": "SJS"
          },
          {
            "name": "CHACAY",
            "code": "SCY"
          },
          {
            "name": "SAN ALFONSO",
            "code": "SAF"
          }
        ]
      },
      {
        "name": "SAN MIGUEL",
        "code": 13130,
        "defaultDistrict": "SMG",
        "districts": [
          {
            "name": "SAN MIGUEL",
            "code": "SMG"
          }
        ]
      },
      {
        "name": "SAN PEDRO",
        "code": 13505,
        "defaultDistrict": "SPO",
        "districts": [
          {
            "name": "BUCALEMU",
            "code": "BUU"
          },
          {
            "name": "LOYCA",
            "code": "ZXX"
          },
          {
            "name": "QUIMCAHUE",
            "code": "SQM"
          },
          {
            "name": "SAN PEDRO - MELIPILL",
            "code": "SPO"
          },
          {
            "name": "PUEBLO HUNDIDO",
            "code": "SPH"
          },
          {
            "name": "PUNTA TORO",
            "code": "KPR"
          },
          {
            "name": "CRUCE LAS ARANAS",
            "code": "CZA"
          }
        ]
      },
      {
        "name": "SAN RAMON",
        "code": 13131,
        "defaultDistrict": "SRN",
        "districts": [
          {
            "name": "SAN RAMON",
            "code": "SRN"
          }
        ]
      },
      {
        "name": "SANTIAGO",
        "code": 13101,
        "defaultDistrict": "SCL",
        "districts": [
          {
            "name": "SANTIAGO",
            "code": "SCL"
          }
        ]
      },
      {
        "name": "TALAGANTE",
        "code": 13601,
        "defaultDistrict": "TNT",
        "districts": [
          {
            "name": "TALAGANTE",
            "code": "TNT"
          }
        ]
      },
      {
        "name": "TILTIL",
        "code": 13303,
        "defaultDistrict": "TIL",
        "districts": [
          {
            "name": "CERRO BLANCO",
            "code": "CBO"
          },
          {
            "name": "TIL TIL",
            "code": "TIL"
          },
          {
            "name": "POLPAICO",
            "code": "POL"
          }
        ]
      },
      {
        "name": "VITACURA",
        "code": 13132,
        "defaultDistrict": "VTC",
        "districts": [
          {
            "name": "VITACURA",
            "code": "VTC"
          }
        ]
      }
    ]
  },
  {
    "name": "Libertador General Bernardo O`Higgins",
    "code": 6,
    "isocode": "LI",
    "ciudades": [
      {
        "name": "CHEPICA",
        "code": 6302,
        "defaultDistrict": "CHE",
        "districts": [
          {
            "name": "AUQUINCO",
            "code": "AQQ"
          },
          {
            "name": "CHEPICA",
            "code": "CHE"
          },
          {
            "name": "QUINAHUE - CURICO",
            "code": "QQW"
          }
        ]
      },
      {
        "name": "CHIMBARONGO",
        "code": 6303,
        "defaultDistrict": "CHB",
        "districts": [
          {
            "name": "CHIMBARONGO",
            "code": "CHB"
          },
          {
            "name": "HUEMUL",
            "code": "HXO"
          },
          {
            "name": "CONVENTO VIEJO",
            "code": "CVQ"
          },
          {
            "name": "QUINTA",
            "code": "QPX"
          },
          {
            "name": "MORZA",
            "code": "MOX"
          }
        ]
      },
      {
        "name": "CODEGUA",
        "code": 6102,
        "defaultDistrict": "ZDE",
        "districts": [
          {
            "name": "LA LEONERA - RANCAGU",
            "code": "LRW"
          },
          {
            "name": "LA PUNTA",
            "code": "RLP"
          },
          {
            "name": "CODEGUA",
            "code": "ZDE"
          },
          {
            "name": "LA COMPANÍA - RANCAG",
            "code": "RLC"
          }
        ]
      },
      {
        "name": "COINCO",
        "code": 6103,
        "defaultDistrict": "CNO",
        "districts": [
          {
            "name": "COINCO - RANCAGUA",
            "code": "CNO"
          }
        ]
      },
      {
        "name": "COLTAUCO",
        "code": 6104,
        "defaultDistrict": "CTO",
        "districts": [
          {
            "name": "COLTAUCO",
            "code": "CTO"
          },
          {
            "name": "ZUNIGA",
            "code": "RZU"
          }
        ]
      },
      {
        "name": "DONIHUE",
        "code": 6105,
        "defaultDistrict": "DNE",
        "districts": [
          {
            "name": "DONIHUE",
            "code": "DNE"
          },
          {
            "name": "PUREN VI - RANCAGUA",
            "code": "PRN"
          }
        ]
      },
      {
        "name": "GRANEROS",
        "code": 6106,
        "defaultDistrict": "GRA",
        "districts": [
          {
            "name": "GRANEROS",
            "code": "GRA"
          }
        ]
      },
      {
        "name": "LA ESTRELLA",
        "code": 6202,
        "defaultDistrict": "LAE",
        "districts": [
          {
            "name": "LAS DAMAS",
            "code": "KLD"
          },
          {
            "name": "LA ESTRELLA",
            "code": "LAE"
          }
        ]
      },
      {
        "name": "LAS CABRAS",
        "code": 6107,
        "defaultDistrict": "LCB",
        "districts": [
          {
            "name": "COCALAN",
            "code": "CCN"
          },
          {
            "name": "PUNTA VERDE",
            "code": "RPN"
          },
          {
            "name": "LA CEBADA",
            "code": "RLA"
          },
          {
            "name": "EL MANZANO - RANCAGU",
            "code": "MZN"
          },
          {
            "name": "LAS CABRAS",
            "code": "LCB"
          }
        ]
      },
      {
        "name": "LITUECHE",
        "code": 6203,
        "defaultDistrict": "LTU",
        "districts": [
          {
            "name": "TOPOCALMA",
            "code": "KTL"
          },
          {
            "name": "LITUECHE",
            "code": "LTU"
          }
        ]
      },
      {
        "name": "LOLOL",
        "code": 6304,
        "defaultDistrict": "LOL",
        "districts": [
          {
            "name": "EL GUAICO",
            "code": "EGQ"
          },
          {
            "name": "LOLOL",
            "code": "LOL"
          },
          {
            "name": "SAN PEDRO - RANCAGUA",
            "code": "SPW"
          },
          {
            "name": "RANGUIL",
            "code": "RQQ"
          }
        ]
      },
      {
        "name": "MACHALI",
        "code": 6108,
        "defaultDistrict": "MCH",
        "districts": [
          {
            "name": "CHAPA VERDE",
            "code": "CHV"
          },
          {
            "name": "COLON",
            "code": "CLN"
          },
          {
            "name": "SEWELL",
            "code": "SEW"
          },
          {
            "name": "COYA",
            "code": "OCY"
          },
          {
            "name": "MINA LA JUANITA",
            "code": "MJT"
          },
          {
            "name": "MACHALI",
            "code": "MCH"
          },
          {
            "name": "CALETONES",
            "code": "CTS"
          }
        ]
      },
      {
        "name": "MALLOA",
        "code": 6109,
        "defaultDistrict": "ZML",
        "districts": [
          {
            "name": "MALLOA",
            "code": "ZML"
          }
        ]
      },
      {
        "name": "MARCHIHUE",
        "code": 6204,
        "defaultDistrict": "MRH",
        "districts": [
          {
            "name": "ALCONES",
            "code": "LNE"
          },
          {
            "name": "LAS PATAGUAS",
            "code": "LPG"
          },
          {
            "name": "MARCHIHUE",
            "code": "MRH"
          },
          {
            "name": "MARCHANT",
            "code": "RMT"
          },
          {
            "name": "ESPERANZA",
            "code": "RZE"
          },
          {
            "name": "SAN JOSE MARCHIHUE",
            "code": "RSA"
          },
          {
            "name": "LA QUEBRADA - RANCAG",
            "code": "RQE"
          }
        ]
      },
      {
        "name": "MOSTAZAL",
        "code": 6110,
        "defaultDistrict": "SFM",
        "districts": [
          {
            "name": "SAN FCO DE MOSTAZAL",
            "code": "SFM"
          }
        ]
      },
      {
        "name": "NANCAGUA",
        "code": 6305,
        "defaultDistrict": "NGA",
        "districts": [
          {
            "name": "NANCAGUA",
            "code": "NGA"
          }
        ]
      },
      {
        "name": "NAVIDAD",
        "code": 6205,
        "defaultDistrict": "NAV",
        "districts": [
          {
            "name": "MATANZAS",
            "code": "KMT"
          },
          {
            "name": "PUNTA PERRO",
            "code": "KPP"
          },
          {
            "name": "SAN ENRIQUE",
            "code": "KSE"
          },
          {
            "name": "CORNECHE",
            "code": "KRC"
          },
          {
            "name": "PUERTECILLO",
            "code": "KPU"
          },
          {
            "name": "PUNTA BARRANCA",
            "code": "KPB"
          },
          {
            "name": "SAN VICENTE DE PUCAL",
            "code": "KVP"
          },
          {
            "name": "LA BOCA - MELIPILLA",
            "code": "ZRW"
          },
          {
            "name": "RAPEL - MELIPILLA",
            "code": "RPL"
          },
          {
            "name": "NAVIDAD",
            "code": "NAV"
          }
        ]
      },
      {
        "name": "OLIVAR",
        "code": 6111,
        "defaultDistrict": "OAL",
        "districts": [
          {
            "name": "LO MIRANDA",
            "code": "LMI"
          },
          {
            "name": "OLIVAR BAJO",
            "code": "ROL"
          },
          {
            "name": "OLIVAR ALTO",
            "code": "OAL"
          }
        ]
      },
      {
        "name": "PALMILLA",
        "code": 6306,
        "defaultDistrict": "PLA",
        "districts": [
          {
            "name": "PALMILLA - RANCAGUA",
            "code": "PLA"
          }
        ]
      },
      {
        "name": "PAREDONES",
        "code": 6206,
        "defaultDistrict": "PDS",
        "districts": [
          {
            "name": "BOYERUCA",
            "code": "BYY"
          },
          {
            "name": "PAREDONES",
            "code": "PDS"
          },
          {
            "name": "BUCALEMU - RANCAGUA",
            "code": "PRM"
          },
          {
            "name": "LO VALDIVIA",
            "code": "LVQ"
          }
        ]
      },
      {
        "name": "PERALILLO",
        "code": 6307,
        "defaultDistrict": "ZPE",
        "districts": [
          {
            "name": "LIHUEIMO",
            "code": "LHX"
          },
          {
            "name": "PERALILLO - RANCAGUA",
            "code": "ZPE"
          },
          {
            "name": "POBLACION",
            "code": "RQT"
          }
        ]
      },
      {
        "name": "PEUMO",
        "code": 6112,
        "defaultDistrict": "PEO",
        "districts": [
          {
            "name": "PEUMO",
            "code": "PEO"
          },
          {
            "name": "TUNCA ARRIBA",
            "code": "TZV"
          }
        ]
      },
      {
        "name": "PICHIDEGUA",
        "code": 6113,
        "defaultDistrict": "PHA",
        "districts": [
          {
            "name": "LARMAHUE",
            "code": "LQX"
          },
          {
            "name": "EL TOCO",
            "code": "RET"
          },
          {
            "name": "PICHIDEGUA",
            "code": "PHA"
          }
        ]
      },
      {
        "name": "PICHILEMU",
        "code": 6201,
        "defaultDistrict": "PMU",
        "districts": [
          {
            "name": "PICHILEMU",
            "code": "PMU"
          },
          {
            "name": "ALTO COLORADO",
            "code": "RAC"
          },
          {
            "name": "CAHUIL",
            "code": "RHL"
          },
          {
            "name": "CIRUELOS",
            "code": "RJC"
          },
          {
            "name": "EL PUESTO",
            "code": "RPS"
          },
          {
            "name": "SANTA GRACIELA ALCON",
            "code": "RGQ"
          }
        ]
      },
      {
        "name": "PLACILLA",
        "code": 6308,
        "defaultDistrict": "PLL",
        "districts": [
          {
            "name": "PLACILLA - RANCAGUA",
            "code": "PLL"
          }
        ]
      },
      {
        "name": "PUMANQUE",
        "code": 6309,
        "defaultDistrict": "PMQ",
        "districts": [
          {
            "name": "PUMANQUE",
            "code": "PMQ"
          },
          {
            "name": "NILAHUE",
            "code": "RNI"
          }
        ]
      },
      {
        "name": "QUINTA DE TILCOCO",
        "code": 6114,
        "defaultDistrict": "QCC",
        "districts": [
          {
            "name": "QUINTA DE TILCOCO",
            "code": "QCC"
          }
        ]
      },
      {
        "name": "RANCAGUA",
        "code": 6101,
        "defaultDistrict": "RCG",
        "districts": [
          {
            "name": "RANCAGUA",
            "code": "RCG"
          },
          {
            "name": "PUNTA DE CORTES",
            "code": "TPC"
          }
        ]
      },
      {
        "name": "RENGO",
        "code": 6115,
        "defaultDistrict": "ZRG",
        "districts": [
          {
            "name": "CERRILLOS",
            "code": "CRE"
          },
          {
            "name": "HACIENDA LOS LINGUES",
            "code": "HRQ"
          },
          {
            "name": "RENGO",
            "code": "ZRG"
          },
          {
            "name": "POPETA",
            "code": "RPO"
          },
          {
            "name": "LAS NIEVES - RANCAGU",
            "code": "RLS"
          },
          {
            "name": "LOS MAQUIS",
            "code": "RLM"
          },
          {
            "name": "PELEQUEN",
            "code": "PEQ"
          }
        ]
      },
      {
        "name": "REQUINOA",
        "code": 6116,
        "defaultDistrict": "REQ",
        "districts": [
          {
            "name": "REQUINOA",
            "code": "REQ"
          },
          {
            "name": "PIMPINELA",
            "code": "RMC"
          },
          {
            "name": "ROSARIO",
            "code": "RSS"
          }
        ]
      },
      {
        "name": "SAN FERNANDO",
        "code": 6301,
        "defaultDistrict": "SFR",
        "districts": [
          {
            "name": "AGUA BUENA",
            "code": "AQB"
          },
          {
            "name": "LA RUFINA",
            "code": "LRF"
          },
          {
            "name": "ROMA",
            "code": "RMY"
          },
          {
            "name": "SIERRA BELLAVISTA",
            "code": "ZSB"
          },
          {
            "name": "TROMPETILLA",
            "code": "TZT"
          },
          {
            "name": "TERMAS DEL FLACO",
            "code": "TZF"
          },
          {
            "name": "TINGUIRIRICA",
            "code": "TGR"
          },
          {
            "name": "SAN FERNANDO",
            "code": "SFR"
          },
          {
            "name": "TERMAS DE CAUQUENES",
            "code": "RTE"
          },
          {
            "name": "PUENTE NEGRO",
            "code": "RPT"
          }
        ]
      },
      {
        "name": "SAN VICENTE",
        "code": 6117,
        "defaultDistrict": "SVT",
        "districts": [
          {
            "name": "MILLAHUE",
            "code": "MLX"
          },
          {
            "name": "SAN VICENTE DE TAGUA TAGUA",
            "code": "SVT"
          }
        ]
      },
      {
        "name": "SANTA CRUZ",
        "code": 6310,
        "defaultDistrict": "ZSC",
        "districts": [
          {
            "name": "LA LAJUELA",
            "code": "LLW"
          },
          {
            "name": "PANIAHUE",
            "code": "PHU"
          },
          {
            "name": "RINCONADA DE YAQUIL",
            "code": "RQY"
          },
          {
            "name": "SANTA CRUZ",
            "code": "ZSC"
          },
          {
            "name": "CUNACO",
            "code": "ZCU"
          },
          {
            "name": "NERQUIHUE",
            "code": "RNH"
          }
        ]
      }
    ]
  },
  {
    "name": "Maule",
    "code": 7,
    "isocode": "ML",
    "ciudades": [
      {
        "name": "CAUQUENES",
        "code": 7201,
        "defaultDistrict": "CQE",
        "districts": [
          {
            "name": "CAUQUENES",
            "code": "CQE"
          },
          {
            "name": "UNICAVEN",
            "code": "ZUV"
          },
          {
            "name": "LOS PERALES",
            "code": "ZHH"
          },
          {
            "name": "QUELLA",
            "code": "XQL"
          },
          {
            "name": "LOS NABOS",
            "code": "XNY"
          },
          {
            "name": "PASO HONDO - TALCA",
            "code": "XEI"
          },
          {
            "name": "HUALVE",
            "code": "XHR"
          }
        ]
      },
      {
        "name": "CHANCO",
        "code": 7202,
        "defaultDistrict": "CNC",
        "districts": [
          {
            "name": "CHANCO",
            "code": "CNC"
          },
          {
            "name": "CURANIPE",
            "code": "CNP"
          }
        ]
      },
      {
        "name": "COLBUN",
        "code": 7402,
        "defaultDistrict": "CLB",
        "districts": [
          {
            "name": "BARRERA",
            "code": "BYQ"
          },
          {
            "name": "SANTA ANA",
            "code": "ZSN"
          },
          {
            "name": "COLBUN",
            "code": "CLB"
          }
        ]
      },
      {
        "name": "CONSTITUCION",
        "code": 7102,
        "defaultDistrict": "CTT",
        "districts": [
          {
            "name": "CONSTITUCION",
            "code": "CTT"
          },
          {
            "name": "JUNQUILLAR",
            "code": "ZJU"
          },
          {
            "name": "QUIVOLGO",
            "code": "ZQI"
          },
          {
            "name": "PUTU",
            "code": "PUU"
          }
        ]
      },
      {
        "name": "CUREPTO",
        "code": 7103,
        "defaultDistrict": "CUR",
        "districts": [
          {
            "name": "CUREPTO",
            "code": "CUR"
          },
          {
            "name": "LA LORA",
            "code": "XLA"
          }
        ]
      },
      {
        "name": "CURICO",
        "code": 7301,
        "defaultDistrict": "CCO",
        "districts": [
          {
            "name": "CURICO",
            "code": "CCO"
          },
          {
            "name": "LOS NICHES",
            "code": "LNH"
          },
          {
            "name": "QUEBRADA HONDA",
            "code": "ZQH"
          },
          {
            "name": "UPEO",
            "code": "ZUO"
          },
          {
            "name": "MONTE OSCURO",
            "code": "ZPA"
          },
          {
            "name": "POTRERO GRANDE",
            "code": "PTG"
          }
        ]
      },
      {
        "name": "EMPEDRADO",
        "code": 7104,
        "defaultDistrict": "EMP",
        "districts": [
          {
            "name": "EMPEDRADO",
            "code": "EMP"
          },
          {
            "name": "NIRIVILO",
            "code": "ZNI"
          }
        ]
      },
      {
        "name": "HUALANE",
        "code": 7302,
        "defaultDistrict": "HNE",
        "districts": [
          {
            "name": "HUALANE",
            "code": "HNE"
          }
        ]
      },
      {
        "name": "LICANTEN",
        "code": 7303,
        "defaultDistrict": "LCT",
        "districts": [
          {
            "name": "LICANTEN",
            "code": "LCT"
          }
        ]
      },
      {
        "name": "LINARES",
        "code": 7401,
        "defaultDistrict": "LNR",
        "districts": [
          {
            "name": "ADUANA PEJERREY",
            "code": "ADJ"
          },
          {
            "name": "LINARES",
            "code": "LNR"
          },
          {
            "name": "LLEPO",
            "code": "XBL"
          },
          {
            "name": "MELADO",
            "code": "XMK"
          },
          {
            "name": "ROBLERIA",
            "code": "XRI"
          },
          {
            "name": "EL SALTO",
            "code": "XSE"
          },
          {
            "name": "MIRAFLORES - TALCA",
            "code": "ZMI"
          },
          {
            "name": "LOS RABONES",
            "code": "XRX"
          },
          {
            "name": "PALMILLA",
            "code": "XPE"
          },
          {
            "name": "CAMPAMENTO ANCOA",
            "code": "CPQ"
          }
        ]
      },
      {
        "name": "LONGAVI",
        "code": 7403,
        "defaultDistrict": "LGV",
        "districts": [
          {
            "name": "LONGAVI",
            "code": "LGV"
          },
          {
            "name": "EL TRANSITO - TALCA",
            "code": "XTD"
          },
          {
            "name": "VILLA SECA",
            "code": "ZVS"
          },
          {
            "name": "MELAO",
            "code": "ZMG"
          },
          {
            "name": "LOS CRISTALES",
            "code": "XLY"
          },
          {
            "name": "MESAMAVIDA",
            "code": "XME"
          }
        ]
      },
      {
        "name": "MAULE",
        "code": 7105,
        "defaultDistrict": "ZMA",
        "districts": [
          {
            "name": "DUAO",
            "code": "UAO"
          },
          {
            "name": "MAULE",
            "code": "ZMA"
          }
        ]
      },
      {
        "name": "MOLINA",
        "code": 7304,
        "defaultDistrict": "ZMO",
        "districts": [
          {
            "name": "ADUANA  ",
            "code": "ADW"
          },
          {
            "name": "MOLINA",
            "code": "ZMO"
          },
          {
            "name": "YACEL",
            "code": "XYY"
          },
          {
            "name": "RADAL - CURICO",
            "code": "XXR"
          },
          {
            "name": "LONTUE",
            "code": "LTE"
          }
        ]
      },
      {
        "name": "PARRAL",
        "code": 7404,
        "defaultDistrict": "PRR",
        "districts": [
          {
            "name": "AJIAL",
            "code": "JJZ"
          },
          {
            "name": "BULLILLEO",
            "code": "LLZ"
          },
          {
            "name": "PERQUILAUQUEN",
            "code": "PQQ"
          },
          {
            "name": "EL PENON - TALCA",
            "code": "PXQ"
          },
          {
            "name": "QUINCHIMAVIDA",
            "code": "QQH"
          },
          {
            "name": "PARRAL",
            "code": "PRR"
          },
          {
            "name": "TERMAS DE CATILLO",
            "code": "TQC"
          },
          {
            "name": "VILLA ROSAS",
            "code": "VZQ"
          },
          {
            "name": "SAN PABLO",
            "code": "SZS"
          }
        ]
      },
      {
        "name": "PELARCO",
        "code": 7106,
        "defaultDistrict": "PLC",
        "districts": [
          {
            "name": "PELARCO",
            "code": "PLC"
          },
          {
            "name": "ASTILLERO",
            "code": "ZAS"
          }
        ]
      },
      {
        "name": "PELLUHUE",
        "code": 7203,
        "defaultDistrict": "PEL",
        "districts": [
          {
            "name": "PELLUHUE",
            "code": "PEL"
          }
        ]
      },
      {
        "name": "PENCAHUE",
        "code": 7107,
        "defaultDistrict": "PEH",
        "districts": [
          {
            "name": "PENCAHUE",
            "code": "PEH"
          },
          {
            "name": "GUALLECO",
            "code": "ZGU"
          },
          {
            "name": "PICHAMAN",
            "code": "ZKQ"
          },
          {
            "name": "COIPUE",
            "code": "ZCP"
          },
          {
            "name": "BATUCO - TALCA",
            "code": "ZBA"
          }
        ]
      },
      {
        "name": "RAUCO",
        "code": 7305,
        "defaultDistrict": "RAU",
        "districts": [
          {
            "name": "RAUCO",
            "code": "RAU"
          },
          {
            "name": "TRINCAO - CURICO",
            "code": "SAR"
          },
          {
            "name": "PALQUIBUDA",
            "code": "XQB"
          }
        ]
      },
      {
        "name": "RETIRO",
        "code": 7405,
        "defaultDistrict": "RTR",
        "districts": [
          {
            "name": "RETIRO - TALCA",
            "code": "RTR"
          }
        ]
      },
      {
        "name": "RIO CLARO",
        "code": 7108,
        "defaultDistrict": "RCL",
        "districts": [
          {
            "name": "CUMPEO",
            "code": "CUM"
          },
          {
            "name": "ITAHUE",
            "code": "ZIK"
          },
          {
            "name": "RIO CLARO - TALCA",
            "code": "RCL"
          }
        ]
      },
      {
        "name": "ROMERAL",
        "code": 7306,
        "defaultDistrict": "RML",
        "districts": [
          {
            "name": "ROMERAL",
            "code": "RML"
          },
          {
            "name": "EL PLANCHON",
            "code": "XPO"
          },
          {
            "name": "LOS QUENES",
            "code": "ZQX"
          },
          {
            "name": "POTRERO GRANDE CHICO",
            "code": "XPC"
          }
        ]
      },
      {
        "name": "SAGRADA FAMILIA",
        "code": 7307,
        "defaultDistrict": "SFA",
        "districts": [
          {
            "name": "SAGRADA FAMILIA",
            "code": "SFA"
          },
          {
            "name": "VILLA PRAT",
            "code": "ZVO"
          }
        ]
      },
      {
        "name": "SAN CLEMENTE",
        "code": 7109,
        "defaultDistrict": "STE",
        "districts": [
          {
            "name": "ARMERILLO",
            "code": "BWP"
          },
          {
            "name": "ENDESA ",
            "code": "ZED"
          },
          {
            "name": "LA MINA",
            "code": "ZLM"
          },
          {
            "name": "LAS GARZAS",
            "code": "ZLG"
          },
          {
            "name": "EL COLORADO",
            "code": "ZEL"
          },
          {
            "name": "CORRALONES",
            "code": "ZCS"
          },
          {
            "name": "SAN CLEMENTE",
            "code": "STE"
          },
          {
            "name": "PASO NEVADO",
            "code": "XPS"
          },
          {
            "name": "AURORA ",
            "code": "ZAU"
          }
        ]
      },
      {
        "name": "SAN JAVIER",
        "code": 7406,
        "defaultDistrict": "SJA",
        "districts": [
          {
            "name": "SAN JAVIER",
            "code": "SJA"
          }
        ]
      },
      {
        "name": "SAN RAFAEL",
        "code": 7110,
        "defaultDistrict": "SRF",
        "districts": [
          {
            "name": "LITU",
            "code": "CUT"
          },
          {
            "name": "SAN RAFAEL",
            "code": "SRF"
          }
        ]
      },
      {
        "name": "TALCA",
        "code": 7101,
        "defaultDistrict": "ZCA",
        "districts": [
          {
            "name": "BOTALCURA",
            "code": "ZBO"
          },
          {
            "name": "CURTIDURIA",
            "code": "ZCE"
          },
          {
            "name": "COLIN",
            "code": "ZCL"
          },
          {
            "name": "TALCA",
            "code": "ZCA"
          },
          {
            "name": "CORINTO",
            "code": "ZNM"
          }
        ]
      },
      {
        "name": "TENO",
        "code": 7308,
        "defaultDistrict": "TEN",
        "districts": [
          {
            "name": "LA MONTANA",
            "code": "LMN"
          },
          {
            "name": "TENO",
            "code": "TEN"
          },
          {
            "name": "CULENAR",
            "code": "XQP"
          },
          {
            "name": "REBECA",
            "code": "ZRB"
          },
          {
            "name": "EL MANZANO - CURICO",
            "code": "XMM"
          }
        ]
      },
      {
        "name": "VICHUQUEN",
        "code": 7309,
        "defaultDistrict": "VCH",
        "districts": [
          {
            "name": "PICHIBUDI",
            "code": "BCH"
          },
          {
            "name": "LLICO - CURICO",
            "code": "ZYC"
          },
          {
            "name": "LIPIMAVIDA",
            "code": "ZVU"
          },
          {
            "name": "LA TRINCHERA",
            "code": "ZLT"
          },
          {
            "name": "VICHUQUEN",
            "code": "VCH"
          },
          {
            "name": "ILOCA",
            "code": "ILO"
          }
        ]
      },
      {
        "name": "VILLA ALEGRE",
        "code": 7407,
        "defaultDistrict": "VGE",
        "districts": [
          {
            "name": "ARBOLILLO",
            "code": "ARB"
          },
          {
            "name": "VILLA ALEGRE - TALCA",
            "code": "VGE"
          },
          {
            "name": "LAS CAMPANAS",
            "code": "ZLJ"
          },
          {
            "name": "MELOZAL",
            "code": "XMD"
          }
        ]
      },
      {
        "name": "YERBAS BUENAS",
        "code": 7408,
        "defaultDistrict": "YBB",
        "districts": [
          {
            "name": "PANIMAVIDA",
            "code": "PNV"
          },
          {
            "name": "QUINMAVIDA",
            "code": "ZQV"
          },
          {
            "name": "YERBAS BUENAS",
            "code": "YBB"
          }
        ]
      }
    ]
  },
  {
    "name": "Ñuble",
    "code": 16,
    "isocode": "NB",
    "ciudades": [
      {
        "name": "BULNES",
        "code": 16102,
        "defaultDistrict": "BLN",
        "districts": [
          {
            "name": "BULNES",
            "code": "BLN"
          },
          {
            "name": "QUINCHAMALI",
            "code": "QML"
          }
        ]
      },
      {
        "name": "CHILLAN",
        "code": 16101,
        "defaultDistrict": "YAI",
        "districts": [
          {
            "name": "CHILLAN",
            "code": "YAI"
          }
        ]
      },
      {
        "name": "CHILLAN VIEJO",
        "code": 16103,
        "defaultDistrict": "YAV",
        "districts": [
          {
            "name": "CHILLAN VIEJO",
            "code": "YAV"
          },
          {
            "name": "RUCAPEQUEN",
            "code": "YRU"
          }
        ]
      },
      {
        "name": "COBQUECURA",
        "code": 16202,
        "defaultDistrict": "CQU",
        "districts": [
          {
            "name": "COBQUECURA",
            "code": "CQU"
          },
          {
            "name": "PULLAY",
            "code": "YPL"
          },
          {
            "name": "BUCHUPUREO",
            "code": "YBU"
          }
        ]
      },
      {
        "name": "COELEMU",
        "code": 16203,
        "defaultDistrict": "ZOU",
        "districts": [
          {
            "name": "SAN IGNACIO - CONCEP",
            "code": "ZCG"
          },
          {
            "name": "RAQUIL",
            "code": "ZER"
          },
          {
            "name": "CONAIR",
            "code": "ZIR"
          },
          {
            "name": "NUEVA ALDEA",
            "code": "ZNA"
          },
          {
            "name": "COELEMU",
            "code": "ZOU"
          },
          {
            "name": "NIPAS",
            "code": "ZNY"
          }
        ]
      },
      {
        "name": "COIHUECO",
        "code": 16302,
        "defaultDistrict": "CUH",
        "districts": [
          {
            "name": "COIHUECO",
            "code": "CUH"
          },
          {
            "name": "MINAS DEL PRADO",
            "code": "MPD"
          },
          {
            "name": "LA CAPILLA - CHILLAN",
            "code": "LQP"
          },
          {
            "name": "TANILVORO",
            "code": "YTA"
          },
          {
            "name": "FUNDO LOS ROBLES",
            "code": "FRQ"
          }
        ]
      },
      {
        "name": "EL CARMEN",
        "code": 16104,
        "defaultDistrict": "YCX",
        "districts": [
          {
            "name": "QUIRIQUINA",
            "code": "QNA"
          },
          {
            "name": "LOS CASTANOS",
            "code": "YLO"
          },
          {
            "name": "TREGUALEMU",
            "code": "YTU"
          },
          {
            "name": "PUEBLO SECO",
            "code": "YPU"
          },
          {
            "name": "EL CARMEN - CHILLAN",
            "code": "YCX"
          }
        ]
      },
      {
        "name": "NINHUE",
        "code": 16204,
        "defaultDistrict": "NIN",
        "districts": [
          {
            "name": "NINHUE",
            "code": "NIN"
          },
          {
            "name": "TORRECILLA",
            "code": "YTR"
          },
          {
            "name": "EL PARRON",
            "code": "YEL"
          },
          {
            "name": "POCILLAS",
            "code": "YPO"
          },
          {
            "name": "COIPIN",
            "code": "YCO"
          },
          {
            "name": "CANCHA ALEGRE",
            "code": "YCN"
          }
        ]
      },
      {
        "name": "NIQUEN",
        "code": 16303,
        "defaultDistrict": "NYY",
        "districts": [
          {
            "name": "NIQUEN",
            "code": "NYY"
          }
        ]
      },
      {
        "name": "PEMUCO",
        "code": 16105,
        "defaultDistrict": "ZPC",
        "districts": [
          {
            "name": "SAN PEDRO - CHILLAN",
            "code": "SQZ"
          },
          {
            "name": "PEMUCO",
            "code": "ZPC"
          },
          {
            "name": "GENERAL CRUZ",
            "code": "YGE"
          }
        ]
      },
      {
        "name": "PINTO",
        "code": 16106,
        "defaultDistrict": "PNO",
        "districts": [
          {
            "name": "PINTO",
            "code": "PNO"
          }
        ]
      },
      {
        "name": "PORTEZUELO",
        "code": 16205,
        "defaultDistrict": "49H",
        "districts": [
          {
            "name": "PORTEZUELO",
            "code": "49H"
          },
          {
            "name": "CONFLUENCIA",
            "code": "YCF"
          }
        ]
      },
      {
        "name": "QUILLON",
        "code": 16107,
        "defaultDistrict": "QLL",
        "districts": [
          {
            "name": "QUILLON",
            "code": "QLL"
          }
        ]
      },
      {
        "name": "QUIRIHUE",
        "code": 16201,
        "defaultDistrict": "QIH",
        "districts": [
          {
            "name": "QUIRIHUE",
            "code": "QIH"
          }
        ]
      },
      {
        "name": "RANQUIL",
        "code": 16206,
        "defaultDistrict": "RNQ",
        "districts": [
          {
            "name": "RANQUIL",
            "code": "RNQ"
          }
        ]
      },
      {
        "name": "SAN CARLOS",
        "code": 16301,
        "defaultDistrict": "SCS",
        "districts": [
          {
            "name": "SAN CARLOS - CHILLAN",
            "code": "SCS"
          },
          {
            "name": "NAHUELTORO",
            "code": "YNA"
          },
          {
            "name": "ZEMITA",
            "code": "YZE"
          },
          {
            "name": "SAN GREGORIO NIQUEN ",
            "code": "YSN"
          },
          {
            "name": "CACHAPOAL - CHILLAN",
            "code": "YCA"
          },
          {
            "name": "EL SAUCE",
            "code": "YES"
          }
        ]
      },
      {
        "name": "SAN FABIAN",
        "code": 16304,
        "defaultDistrict": "SFB",
        "districts": [
          {
            "name": "SAN FABIAN DE ALICO",
            "code": "SFB"
          },
          {
            "name": "LOS PUQUIOS",
            "code": "YLP"
          },
          {
            "name": "LA PUNTILLA",
            "code": "YLA"
          }
        ]
      },
      {
        "name": "SAN IGNACIO",
        "code": 16108,
        "defaultDistrict": "SIG",
        "districts": [
          {
            "name": "SAN IGNACIO - CHILLA",
            "code": "SIG"
          },
          {
            "name": "SAN MIGUEL",
            "code": "SMW"
          },
          {
            "name": "ZAPALLAR - CHILLAN",
            "code": "ZAY"
          },
          {
            "name": "TERMAS DE CHILLAN",
            "code": "YTE"
          },
          {
            "name": "RECINTO",
            "code": "YRE"
          },
          {
            "name": "LAS TRANCAS",
            "code": "YLS"
          }
        ]
      },
      {
        "name": "SAN NICOLAS",
        "code": 16305,
        "defaultDistrict": "SNL",
        "districts": [
          {
            "name": "SAN NICOLAS",
            "code": "SNL"
          }
        ]
      },
      {
        "name": "TREHUACO",
        "code": 16207,
        "defaultDistrict": "TRH",
        "districts": [
          {
            "name": "TREHUACO",
            "code": "TRH"
          },
          {
            "name": "TREGUACO",
            "code": "YTG"
          },
          {
            "name": "MELA",
            "code": "YME"
          },
          {
            "name": "COLMUYAO",
            "code": "YCL"
          }
        ]
      },
      {
        "name": "YUNGAY",
        "code": 16109,
        "defaultDistrict": "YGY",
        "districts": [
          {
            "name": "CHOLGUAN",
            "code": "YCH"
          },
          {
            "name": "CAMPANARIO",
            "code": "YCM"
          },
          {
            "name": "EL SALTILLO",
            "code": "YEY"
          },
          {
            "name": "PANGAL - LOS ANGELES",
            "code": "ZPP"
          },
          {
            "name": "YUNGAY",
            "code": "YGY"
          }
        ]
      }
    ]
  },
  {
    "name": "Bío - Bío",
    "code": 8,
    "isocode": "BI",
    "ciudades": [
      {
        "name": "ALTO BIOBIO",
        "code": 8314,
        "defaultDistrict": "AOO",
        "districts": [
          {
            "name": "ALTO BIO BIO",
            "code": "AOO"
          },
          {
            "name": "PANGUE",
            "code": "ZLL"
          },
          {
            "name": "RALCO",
            "code": "RCO"
          },
          {
            "name": "RALCO LEPOY",
            "code": "ZLN"
          },
          {
            "name": "TERMAS DEL AVELLANO",
            "code": "ZTV"
          },
          {
            "name": "COMUNIDAD CANICU",
            "code": "ZRI"
          },
          {
            "name": "CASA LOLCO",
            "code": "ZOT"
          }
        ]
      },
      {
        "name": "ANTUCO",
        "code": 8302,
        "defaultDistrict": "ANT",
        "districts": [
          {
            "name": "ANTUCO",
            "code": "ANT"
          },
          {
            "name": "LOS BARROS",
            "code": "LLB"
          },
          {
            "name": "EL TORO",
            "code": "LTW"
          },
          {
            "name": "EL ABANICO",
            "code": "LEA"
          }
        ]
      },
      {
        "name": "ARAUCO",
        "code": 8202,
        "defaultDistrict": "ARA",
        "districts": [
          {
            "name": "ARAUCO",
            "code": "ARA"
          },
          {
            "name": "RAQUI",
            "code": "ZUQ"
          },
          {
            "name": "QUIDICO - CONCEPCION",
            "code": "ZQR"
          },
          {
            "name": "RAMADILLA",
            "code": "ZMD"
          },
          {
            "name": "LLICO - CONCEPCION",
            "code": "ZCF"
          },
          {
            "name": "EL BOLDO",
            "code": "ZBC"
          },
          {
            "name": "VILLA ALEGRE - CONCE",
            "code": "VAG"
          },
          {
            "name": "CARAMPANGUE",
            "code": "PAN"
          },
          {
            "name": "LARAQUETE",
            "code": "LAQ"
          }
        ]
      },
      {
        "name": "CABRERO",
        "code": 8303,
        "defaultDistrict": "CRO",
        "districts": [
          {
            "name": "SANTA CLARA",
            "code": "CLA"
          },
          {
            "name": "PASO HONDO",
            "code": "PHY"
          },
          {
            "name": "LIUCURA",
            "code": "YCU"
          },
          {
            "name": "PASO HONDO - CHILLAN",
            "code": "YCR"
          },
          {
            "name": "TOMECO",
            "code": "TMK"
          },
          {
            "name": "CABRERO",
            "code": "CRO"
          }
        ]
      },
      {
        "name": "CANETE",
        "code": 8203,
        "defaultDistrict": "CTE",
        "districts": [
          {
            "name": "SAN ALFONSO - CONCEP",
            "code": "CFF"
          },
          {
            "name": "CAYUCUPIL",
            "code": "ZZW"
          },
          {
            "name": "CANETE",
            "code": "CTE"
          }
        ]
      },
      {
        "name": "CHIGUAYANTE",
        "code": 8103,
        "defaultDistrict": "CYE",
        "districts": [
          {
            "name": "CHIGUAYANTE",
            "code": "CYE"
          }
        ]
      },
      {
        "name": "CONCEPCION",
        "code": 8101,
        "defaultDistrict": "CCP",
        "districts": [
          {
            "name": "CONCEPCION",
            "code": "CCP"
          },
          {
            "name": "RANGUELMO",
            "code": "GUO"
          }
        ]
      },
      {
        "name": "CONTULMO",
        "code": 8204,
        "defaultDistrict": "CTU",
        "districts": [
          {
            "name": "CONTULMO",
            "code": "CTU"
          },
          {
            "name": "RINCONADA - CONCEPCI",
            "code": "ZWE"
          },
          {
            "name": "ANTIQUINA",
            "code": "ZQG"
          }
        ]
      },
      {
        "name": "CORONEL",
        "code": 8102,
        "defaultDistrict": "CRN",
        "districts": [
          {
            "name": "CORONEL",
            "code": "CRN"
          }
        ]
      },
      {
        "name": "CURANILAHUE",
        "code": 8205,
        "defaultDistrict": "ZHE",
        "districts": [
          {
            "name": "SAN JOSE DE COLICO",
            "code": "SJL"
          },
          {
            "name": "CURANILAHUE",
            "code": "ZHE"
          }
        ]
      },
      {
        "name": "FLORIDA",
        "code": 8104,
        "defaultDistrict": "FLO",
        "districts": [
          {
            "name": "FLORIDA",
            "code": "FLO"
          },
          {
            "name": "AGUAS DE LA GLORIA",
            "code": "ZGG"
          },
          {
            "name": "COPIULEMU",
            "code": "ZUM"
          }
        ]
      },
      {
        "name": "HUALPEN",
        "code": 8112,
        "defaultDistrict": "HLP",
        "districts": [
          {
            "name": "HUALPEN",
            "code": "HLP"
          },
          {
            "name": "LA BOCA - CONCEPCION",
            "code": "ZBB"
          }
        ]
      },
      {
        "name": "HUALQUI",
        "code": 8105,
        "defaultDistrict": "HLQ",
        "districts": [
          {
            "name": "TALCAMAVIDA",
            "code": "CTV"
          },
          {
            "name": "QUILACOYA",
            "code": "ZIQ"
          },
          {
            "name": "HUALQUI",
            "code": "HLQ"
          }
        ]
      },
      {
        "name": "LAJA",
        "code": 8304,
        "defaultDistrict": "LLJ",
        "districts": [
          {
            "name": "COLONIA",
            "code": "LCI"
          },
          {
            "name": "LAJA",
            "code": "LLJ"
          }
        ]
      },
      {
        "name": "LEBU",
        "code": 8201,
        "defaultDistrict": "ZLB",
        "districts": [
          {
            "name": "CURACO - CONCEPCION",
            "code": "MLC"
          },
          {
            "name": "SARA DE LEBU",
            "code": "ZBL"
          },
          {
            "name": "LEBU",
            "code": "ZLB"
          },
          {
            "name": "MILLONHUE",
            "code": "ZNG"
          },
          {
            "name": "YENECO",
            "code": "ZYY"
          },
          {
            "name": "RUCARAQUIL",
            "code": "ZYR"
          },
          {
            "name": "RANQUILCO",
            "code": "ZRQ"
          },
          {
            "name": "QUINAHUE - CONCEPCIO",
            "code": "ZQA"
          },
          {
            "name": "PEHUEN",
            "code": "ZPQ"
          }
        ]
      },
      {
        "name": "LOS ALAMOS",
        "code": 8206,
        "defaultDistrict": "LAL",
        "districts": [
          {
            "name": "LOS ALAMOS",
            "code": "LAL"
          },
          {
            "name": "ANTIGUALA",
            "code": "ZNT"
          },
          {
            "name": "TRES PINOS",
            "code": "ZTP"
          },
          {
            "name": "PILPILCO",
            "code": "ZWP"
          }
        ]
      },
      {
        "name": "LOS ANGELES",
        "code": 8301,
        "defaultDistrict": "LSQ",
        "districts": [
          {
            "name": "EL ALAMO",
            "code": "LEL"
          },
          {
            "name": "SANTA CLARA",
            "code": "LST"
          },
          {
            "name": "SAN CARLOS PUREN - L",
            "code": "SCP"
          },
          {
            "name": "SAN CARLOS PUREN - L",
            "code": "SCW"
          },
          {
            "name": "LOS ANGELES",
            "code": "LSQ"
          }
        ]
      },
      {
        "name": "LOTA",
        "code": 8106,
        "defaultDistrict": "LOT",
        "districts": [
          {
            "name": "LOTA",
            "code": "LOT"
          }
        ]
      },
      {
        "name": "MULCHEN",
        "code": 8305,
        "defaultDistrict": "MUL",
        "districts": [
          {
            "name": "EL AVELLANO",
            "code": "LEV"
          },
          {
            "name": "MAITENES",
            "code": "LLM"
          },
          {
            "name": "EL MORRO",
            "code": "LMR"
          },
          {
            "name": "LOS MAICAS",
            "code": "LZX"
          },
          {
            "name": "MULCHEN",
            "code": "MUL"
          },
          {
            "name": "MELICA",
            "code": "MEA"
          },
          {
            "name": "SAN MIGUEL",
            "code": "LSM"
          }
        ]
      },
      {
        "name": "NACIMIENTO",
        "code": 8306,
        "defaultDistrict": "NAC",
        "districts": [
          {
            "name": "CHOROICO",
            "code": "CIO"
          },
          {
            "name": "COIHUE",
            "code": "LCE"
          },
          {
            "name": "DIUQUIN",
            "code": "LDQ"
          },
          {
            "name": "PROGRESO",
            "code": "PGS"
          },
          {
            "name": "NACIMIENTO",
            "code": "NAC"
          },
          {
            "name": "SANTA FE",
            "code": "LSF"
          }
        ]
      },
      {
        "name": "NEGRETE",
        "code": 8307,
        "defaultDistrict": "NRE",
        "districts": [
          {
            "name": "NEGRETE",
            "code": "NRE"
          },
          {
            "name": "RIHUE",
            "code": "RIE"
          }
        ]
      },
      {
        "name": "PENCO",
        "code": 8107,
        "defaultDistrict": "PCO",
        "districts": [
          {
            "name": "LIRQUEN",
            "code": "LIR"
          },
          {
            "name": "PENCO",
            "code": "PCO"
          },
          {
            "name": "ROA",
            "code": "ZRO"
          }
        ]
      },
      {
        "name": "QUILACO",
        "code": 8308,
        "defaultDistrict": "QCO",
        "districts": [
          {
            "name": "ALTO CALEDONIA",
            "code": "ANI"
          },
          {
            "name": "QUILACO",
            "code": "QCO"
          },
          {
            "name": "LONCOPANGUE",
            "code": "LGE"
          },
          {
            "name": "CERRO DEL PADRE",
            "code": "LCP"
          },
          {
            "name": "RUCALHUE",
            "code": "LRH"
          }
        ]
      },
      {
        "name": "QUILLECO",
        "code": 8309,
        "defaultDistrict": "QLO",
        "districts": [
          {
            "name": "CANTERAS",
            "code": "CNT"
          },
          {
            "name": "QUILLECO",
            "code": "QLO"
          },
          {
            "name": "CANICURA",
            "code": "CRA"
          },
          {
            "name": "VILLA MERCEDES",
            "code": "LVM"
          }
        ]
      },
      {
        "name": "SAN PEDRO DE LA PAZ",
        "code": 8108,
        "defaultDistrict": "SPP",
        "districts": [
          {
            "name": "SAN PEDRO DE LA PAZ",
            "code": "SPP"
          }
        ]
      },
      {
        "name": "SAN ROSENDO",
        "code": 8310,
        "defaultDistrict": "SRO",
        "districts": [
          {
            "name": "BUENURAQUI",
            "code": "LBQ"
          },
          {
            "name": "SAN ROSENDO",
            "code": "SRO"
          }
        ]
      },
      {
        "name": "SANTA BARBARA",
        "code": 8311,
        "defaultDistrict": "SBB",
        "districts": [
          {
            "name": "LOLCO",
            "code": "COC"
          },
          {
            "name": "SANTA BARBARA",
            "code": "SBB"
          },
          {
            "name": "VILLUCURA",
            "code": "LVU"
          },
          {
            "name": "LAS NIEVES",
            "code": "LNV"
          },
          {
            "name": "EL GUACHI",
            "code": "LGH"
          },
          {
            "name": "LOS BRUJOS",
            "code": "LBS"
          },
          {
            "name": "LOS PLACERES",
            "code": "LBO"
          }
        ]
      },
      {
        "name": "SANTA JUANA",
        "code": 8109,
        "defaultDistrict": "SJN",
        "districts": [
          {
            "name": "SANTA JUANA",
            "code": "SJN"
          }
        ]
      },
      {
        "name": "TALCAHUANO",
        "code": 8110,
        "defaultDistrict": "ZTO",
        "districts": [
          {
            "name": "ISLA QUIRIQUINA",
            "code": "IQR"
          },
          {
            "name": "TALCAHUANO",
            "code": "ZTO"
          },
          {
            "name": "SAN VICENTE",
            "code": "SVC"
          },
          {
            "name": "RANCHO TALCAHUANO",
            "code": "RTH"
          }
        ]
      },
      {
        "name": "TIRUA",
        "code": 8207,
        "defaultDistrict": "TUA",
        "districts": [
          {
            "name": "PAILACO",
            "code": "PLO"
          },
          {
            "name": "TIRUA",
            "code": "TUA"
          },
          {
            "name": "QUIDICO - TEMUCO",
            "code": "ZDQ"
          }
        ]
      },
      {
        "name": "TOME",
        "code": 8111,
        "defaultDistrict": "TMC",
        "districts": [
          {
            "name": "DICHATO",
            "code": "DTO"
          },
          {
            "name": "TOME",
            "code": "TMC"
          },
          {
            "name": "MENQUE",
            "code": "ZQW"
          },
          {
            "name": "VEGAS DE ITATA",
            "code": "ZTT"
          },
          {
            "name": "RAFAEL",
            "code": "ZRA"
          }
        ]
      },
      {
        "name": "TUCAPEL",
        "code": 8312,
        "defaultDistrict": "TCP",
        "districts": [
          {
            "name": "HUEPIL",
            "code": "HUP"
          },
          {
            "name": "TRUPAN",
            "code": "LTP"
          },
          {
            "name": "TUCAPEL",
            "code": "TCP"
          },
          {
            "name": "POLCURA",
            "code": "LPO"
          }
        ]
      },
      {
        "name": "YUMBEL",
        "code": 8313,
        "defaultDistrict": "ZYU",
        "districts": [
          {
            "name": "ESTACION YUMBEL",
            "code": "EYY"
          },
          {
            "name": "MONTE AGUILA",
            "code": "ZLA"
          },
          {
            "name": "YUMBEL",
            "code": "ZYU"
          },
          {
            "name": "RIO CLARO - LOS ANGE",
            "code": "LRC"
          }
        ]
      }
    ]
  },
  {
    "name": "Araucanía",
    "code": 9,
    "isocode": "AR",
    "ciudades": [
      {
        "name": "ANGOL",
        "code": 9201,
        "defaultDistrict": "ZOL",
        "districts": [
          {
            "name": "MAITENREHUE",
            "code": "LLH"
          },
          {
            "name": "PIEDRA DEL AGUILA",
            "code": "PDA"
          },
          {
            "name": "ANGOL",
            "code": "ZOL"
          },
          {
            "name": "VEGAS BLANCAS",
            "code": "LVB"
          }
        ]
      },
      {
        "name": "CARAHUE",
        "code": 9102,
        "defaultDistrict": "CRH",
        "districts": [
          {
            "name": "CARAHUE",
            "code": "CRH"
          },
          {
            "name": "VILLA ARAUCANIA",
            "code": "VZA"
          },
          {
            "name": "LOBERIA",
            "code": "ZLE"
          },
          {
            "name": "TROVOLHUE",
            "code": "ZTK"
          },
          {
            "name": "NEHUENTUE",
            "code": "ZNH"
          },
          {
            "name": "CAMARONES - TEMUCO",
            "code": "VAC"
          }
        ]
      },
      {
        "name": "CHOL CHOL",
        "code": 9121,
        "defaultDistrict": "CHL",
        "districts": [
          {
            "name": "CHOLCHOL",
            "code": "CHL"
          }
        ]
      },
      {
        "name": "COLLIPULLI",
        "code": 9202,
        "defaultDistrict": "CPI",
        "districts": [
          {
            "name": "CANADA",
            "code": "CDA"
          },
          {
            "name": "PORVENIR",
            "code": "ZPB"
          },
          {
            "name": "TRINTRE",
            "code": "TTE"
          },
          {
            "name": "TERMAS DE PEMEHUE",
            "code": "MTW"
          },
          {
            "name": "NANCO",
            "code": "LYY"
          },
          {
            "name": "LOLENCO",
            "code": "LLE"
          },
          {
            "name": "CURACO ",
            "code": "HDF"
          },
          {
            "name": "EL AMARGO",
            "code": "EAG"
          },
          {
            "name": "COLLIPULLI",
            "code": "CPI"
          }
        ]
      },
      {
        "name": "CUNCO",
        "code": 9103,
        "defaultDistrict": "NCO",
        "districts": [
          {
            "name": "PLAYA NEGRA",
            "code": "MFN"
          },
          {
            "name": "TERMAS DE SAN SEBAST",
            "code": "ZTB"
          },
          {
            "name": "LOS LAURELES",
            "code": "ZSO"
          },
          {
            "name": "CUNCO",
            "code": "NCO"
          },
          {
            "name": "PUERTO PUMA",
            "code": "PPM"
          },
          {
            "name": "HELO SUR",
            "code": "ZHL"
          },
          {
            "name": "LAS HORTENCIAS",
            "code": "ZLH"
          }
        ]
      },
      {
        "name": "CURACAUTIN",
        "code": 9203,
        "defaultDistrict": "CCC",
        "districts": [
          {
            "name": "CURACAUTIN",
            "code": "CCC"
          },
          {
            "name": "MANZANAR",
            "code": "ZMN"
          },
          {
            "name": "TERMAS DE RIO BLANCO",
            "code": "ZTS"
          },
          {
            "name": "MALALCAHUELO ",
            "code": "ZOH"
          },
          {
            "name": "LA SOMBRA",
            "code": "ZBN"
          }
        ]
      },
      {
        "name": "CURARREHUE",
        "code": 9104,
        "defaultDistrict": "RRH",
        "districts": [
          {
            "name": "TERMAS DE PANGUI",
            "code": "GAR"
          },
          {
            "name": "REIGOLIL",
            "code": "ZGO"
          },
          {
            "name": "TERMAS DE SAN LUIS",
            "code": "TSL"
          },
          {
            "name": "CURARREHUE",
            "code": "RRH"
          },
          {
            "name": "PUESCO",
            "code": "PUE"
          }
        ]
      },
      {
        "name": "ERCILLA",
        "code": 9204,
        "defaultDistrict": "ERL",
        "districts": [
          {
            "name": "ERCILLA",
            "code": "ERL"
          },
          {
            "name": "PAILAHUENQUE",
            "code": "ZPH"
          }
        ]
      },
      {
        "name": "FREIRE",
        "code": 9105,
        "defaultDistrict": "FIE",
        "districts": [
          {
            "name": "FREIRE",
            "code": "FIE"
          },
          {
            "name": "MISION BOROA",
            "code": "MBA"
          },
          {
            "name": "QUEPE",
            "code": "QUP"
          }
        ]
      },
      {
        "name": "GALVARINO",
        "code": 9106,
        "defaultDistrict": "GAL",
        "districts": [
          {
            "name": "GALVARINO",
            "code": "GAL"
          },
          {
            "name": "RUCATRARO",
            "code": "ZXR"
          }
        ]
      },
      {
        "name": "GORBEA",
        "code": 9107,
        "defaultDistrict": "GEA",
        "districts": [
          {
            "name": "GORBEA",
            "code": "GEA"
          },
          {
            "name": "QUITRATUE",
            "code": "ZQT"
          },
          {
            "name": "LASTARRIA",
            "code": "ZLR"
          }
        ]
      },
      {
        "name": "LAUTARO",
        "code": 9108,
        "defaultDistrict": "LTR",
        "districts": [
          {
            "name": "AGUA SANTA",
            "code": "AST"
          },
          {
            "name": "COLONIA LAUTARO",
            "code": "CLU"
          },
          {
            "name": "PUA",
            "code": "CAU"
          },
          {
            "name": "RETEN DOLLINCO",
            "code": "ZRT"
          },
          {
            "name": "LOS PRADOS",
            "code": "ZLD"
          },
          {
            "name": "LAUTARO",
            "code": "LTR"
          }
        ]
      },
      {
        "name": "LONCOCHE",
        "code": 9109,
        "defaultDistrict": "LOC",
        "districts": [
          {
            "name": "CRUCES",
            "code": "CRS"
          },
          {
            "name": "LONCOCHE",
            "code": "LOC"
          }
        ]
      },
      {
        "name": "LONQUIMAY",
        "code": 9205,
        "defaultDistrict": "LQY",
        "districts": [
          {
            "name": "LIUCURA - TEMUCO",
            "code": "IRA"
          },
          {
            "name": "LONQUIMAY",
            "code": "LQY"
          },
          {
            "name": "TROYO",
            "code": "ZTY"
          },
          {
            "name": "SIERRA NEVADA",
            "code": "ZSI"
          },
          {
            "name": "QUINQUEN",
            "code": "ZQN"
          },
          {
            "name": "LOLEN",
            "code": "LLN"
          }
        ]
      },
      {
        "name": "LOS SAUCES",
        "code": 9206,
        "defaultDistrict": "SUS",
        "districts": [
          {
            "name": "NAHUELVE",
            "code": "NNH"
          },
          {
            "name": "SANTA ROSA - TEMUCO",
            "code": "SZZ"
          },
          {
            "name": "CENTENARIO",
            "code": "ZCT"
          },
          {
            "name": "LOS SAUCES",
            "code": "SUS"
          }
        ]
      },
      {
        "name": "LUMACO",
        "code": 9207,
        "defaultDistrict": "LUM",
        "districts": [
          {
            "name": "CAPITAN PASTENE",
            "code": "CPP"
          },
          {
            "name": "RELUN",
            "code": "ZRL"
          },
          {
            "name": "PICHIPELLAHUEN",
            "code": "ZNN"
          },
          {
            "name": "LUMACO",
            "code": "LUM"
          }
        ]
      },
      {
        "name": "MELIPEUCO",
        "code": 9110,
        "defaultDistrict": "MLP",
        "districts": [
          {
            "name": "MELIPEUCO",
            "code": "MLP"
          },
          {
            "name": "TERMAS DE MOLULCO",
            "code": "ZMY"
          },
          {
            "name": "LOMACURA",
            "code": "ZLV"
          },
          {
            "name": "ICALMA",
            "code": "ZIC"
          }
        ]
      },
      {
        "name": "NUEVA IMPERIAL",
        "code": 9111,
        "defaultDistrict": "NIP",
        "districts": [
          {
            "name": "BOROA",
            "code": "BOA"
          },
          {
            "name": "NUEVA IMPERIAL",
            "code": "NIP"
          },
          {
            "name": "ALMAGRO",
            "code": "ZGV"
          }
        ]
      },
      {
        "name": "PADRE LAS CASAS",
        "code": 9112,
        "defaultDistrict": "PCS",
        "districts": [
          {
            "name": "PADRE LAS CASAS",
            "code": "PCS"
          },
          {
            "name": "EL ALAMBRADO",
            "code": "ZEA"
          }
        ]
      },
      {
        "name": "PERQUENCO",
        "code": 9113,
        "defaultDistrict": "PQO",
        "districts": [
          {
            "name": "PERQUENCO",
            "code": "PQO"
          },
          {
            "name": "SELVA OSCURA",
            "code": "SSO"
          }
        ]
      },
      {
        "name": "PITRUFQUEN",
        "code": 9114,
        "defaultDistrict": "PQN",
        "districts": [
          {
            "name": "PITRUFQUEN",
            "code": "PQN"
          },
          {
            "name": "RADAL - TEMUCO",
            "code": "ZLK"
          }
        ]
      },
      {
        "name": "PUCON",
        "code": 9115,
        "defaultDistrict": "ZPU",
        "districts": [
          {
            "name": "SAN PEDRO - TEMUCO",
            "code": "SSP"
          },
          {
            "name": "CABURGUA",
            "code": "ZCB"
          },
          {
            "name": "TERMAS DE MENETUE",
            "code": "ZMT"
          },
          {
            "name": "PUCON",
            "code": "ZPU"
          },
          {
            "name": "TERMAS DE PALGUIN",
            "code": "ZTM"
          },
          {
            "name": "HUIFE",
            "code": "ZTZ"
          },
          {
            "name": "TERMAS DE HUIFE",
            "code": "ZTR"
          },
          {
            "name": "REFUGIO",
            "code": "ZRE"
          },
          {
            "name": "PEMUCO",
            "code": "ZPC"
          }
        ]
      },
      {
        "name": "PUREN",
        "code": 9208,
        "defaultDistrict": "PUR",
        "districts": [
          {
            "name": "PUREN - TEMUCO",
            "code": "PUR"
          }
        ]
      },
      {
        "name": "RENAICO",
        "code": 9209,
        "defaultDistrict": "RNA",
        "districts": [
          {
            "name": "TIJERAL",
            "code": "LTJ"
          },
          {
            "name": "MININCO",
            "code": "MNC"
          },
          {
            "name": "RENAICO",
            "code": "RNA"
          }
        ]
      },
      {
        "name": "SAAVEDRA",
        "code": 9116,
        "defaultDistrict": "ZPS",
        "districts": [
          {
            "name": "BOCA BUDI",
            "code": "BBD"
          },
          {
            "name": "PUERTO SAAVEDRA",
            "code": "ZPS"
          }
        ]
      },
      {
        "name": "TEMUCO",
        "code": 9101,
        "defaultDistrict": "ZCO",
        "districts": [
          {
            "name": "CAJON",
            "code": "CJN"
          },
          {
            "name": "MAQUEHUE",
            "code": "MQH"
          },
          {
            "name": "LABRANZA",
            "code": "LZA"
          },
          {
            "name": "METRENCO",
            "code": "MTR"
          },
          {
            "name": "TEMUCO",
            "code": "ZCO"
          },
          {
            "name": "PILLANLELBUN",
            "code": "ZUN"
          },
          {
            "name": "GENERAL LOPEZ",
            "code": "ZGE"
          }
        ]
      },
      {
        "name": "TEODORO SCHMIDT",
        "code": 9117,
        "defaultDistrict": "TEO",
        "districts": [
          {
            "name": "PELECO",
            "code": "PEC"
          },
          {
            "name": "TEODORO SCHMIDT",
            "code": "TEO"
          },
          {
            "name": "PUERTO DOMINGUEZ",
            "code": "ZPM"
          },
          {
            "name": "BARROS ARANA",
            "code": "ZBR"
          }
        ]
      },
      {
        "name": "TOLTEN",
        "code": 9118,
        "defaultDistrict": "TOL",
        "districts": [
          {
            "name": "TOLTEN",
            "code": "TOL"
          },
          {
            "name": "HUALPIN",
            "code": "UAL"
          },
          {
            "name": "QUILQUE",
            "code": "ZQL"
          },
          {
            "name": "COMUY",
            "code": "ZCM"
          }
        ]
      },
      {
        "name": "TRAIGUEN",
        "code": 9210,
        "defaultDistrict": "ZEN",
        "districts": [
          {
            "name": "TRAIGUEN",
            "code": "ZEN"
          },
          {
            "name": "QUECHEREGUAS",
            "code": "ZQE"
          }
        ]
      },
      {
        "name": "VICTORIA",
        "code": 9211,
        "defaultDistrict": "VIC",
        "districts": [
          {
            "name": "VICTORIA",
            "code": "VIC"
          },
          {
            "name": "TERMAS DE TOLHUACA",
            "code": "ZTD"
          },
          {
            "name": "TRES ESQUINAS",
            "code": "ZTQ"
          },
          {
            "name": "LAS MARIPOSAS - TEMU",
            "code": "ZJM"
          }
        ]
      },
      {
        "name": "VILCUN",
        "code": 9119,
        "defaultDistrict": "VIL",
        "districts": [
          {
            "name": "VILCUN",
            "code": "VIL"
          },
          {
            "name": "REFUGIO LLAIMA",
            "code": "ZRF"
          },
          {
            "name": "SAN PATRICIO",
            "code": "ZSP"
          },
          {
            "name": "CHERQUENCO",
            "code": "ZCC"
          }
        ]
      },
      {
        "name": "VILLARRICA",
        "code": 9120,
        "defaultDistrict": "VRR",
        "districts": [
          {
            "name": "VILLARRICA",
            "code": "VRR"
          },
          {
            "name": "PEDREGOSO",
            "code": "ZPD"
          },
          {
            "name": "HUISCAPI",
            "code": "ZHS"
          }
        ]
      }
    ]
  },
  {
    "name": "Los Ríos",
    "code": 14,
    "isocode": "LR",
    "ciudades": [
      {
        "name": "CORRAL",
        "code": 14102,
        "defaultDistrict": "ZCR",
        "districts": [
          {
            "name": "PUNTA CHAIHUIN",
            "code": "PTC"
          },
          {
            "name": "CORRAL",
            "code": "ZCR"
          }
        ]
      },
      {
        "name": "FUTRONO",
        "code": 14202,
        "defaultDistrict": "FTR",
        "districts": [
          {
            "name": "COIQUE",
            "code": "COI"
          },
          {
            "name": "FUTRONO",
            "code": "FTR"
          },
          {
            "name": "LLIFEN",
            "code": "LLI"
          },
          {
            "name": "EL MUNDIAL",
            "code": "EMN"
          },
          {
            "name": "CHABRANCO",
            "code": "ZXB"
          },
          {
            "name": "MONTUELA",
            "code": "ZMB"
          },
          {
            "name": "LOS LLOLLES",
            "code": "ZLO"
          },
          {
            "name": "HUEQUECURA",
            "code": "ZHU"
          },
          {
            "name": "DOLLINCO",
            "code": "ZDO"
          },
          {
            "name": "BANOS DE CHIHUIO",
            "code": "ZBZ"
          },
          {
            "name": "MAIHUE",
            "code": "MLE"
          }
        ]
      },
      {
        "name": "LA UNION",
        "code": 14201,
        "defaultDistrict": "ZLU",
        "districts": [
          {
            "name": "LAS VENTANAS",
            "code": "LVS"
          },
          {
            "name": "EL MIRADOR",
            "code": "ORO"
          },
          {
            "name": "TRUMAO",
            "code": "TMA"
          },
          {
            "name": "TRINIDAD",
            "code": "ODA"
          },
          {
            "name": "LA BARRA",
            "code": "OAA"
          },
          {
            "name": "SANTA ELISA",
            "code": "ZSS"
          },
          {
            "name": "RAPACO",
            "code": "ZRP"
          },
          {
            "name": "LA UNION",
            "code": "ZLU"
          },
          {
            "name": "HUEICOLLA",
            "code": "ZHC"
          },
          {
            "name": "LOS CONALES - OSORNO",
            "code": "ZAQ"
          }
        ]
      },
      {
        "name": "LAGO RANCO",
        "code": 14203,
        "defaultDistrict": "LRO",
        "districts": [
          {
            "name": "LAGO RANCO",
            "code": "LRO"
          },
          {
            "name": "TRAPI",
            "code": "OIP"
          },
          {
            "name": "LLIHUE",
            "code": "OEU"
          },
          {
            "name": "IGNAO",
            "code": "ZIG"
          },
          {
            "name": "RININAHUE",
            "code": "ZZR"
          },
          {
            "name": "VIVANCO",
            "code": "ZVV"
          },
          {
            "name": "ILIHUE",
            "code": "ZEQ"
          }
        ]
      },
      {
        "name": "LANCO",
        "code": 14103,
        "defaultDistrict": "LNC",
        "districts": [
          {
            "name": "LANCO",
            "code": "LNC"
          },
          {
            "name": "LA CAPILLA - VALDIV",
            "code": "ZLW"
          },
          {
            "name": "SALTO DEL AGUA",
            "code": "ZSA"
          },
          {
            "name": "PURULON",
            "code": "ZPO"
          },
          {
            "name": "LA LEONERA - VALDIVI",
            "code": "LRA"
          },
          {
            "name": "MALALHUE",
            "code": "MAL"
          }
        ]
      },
      {
        "name": "LOS LAGOS",
        "code": 14104,
        "defaultDistrict": "LAG",
        "districts": [
          {
            "name": "ANTILHUE",
            "code": "ANH"
          },
          {
            "name": "RUNCA",
            "code": "ZRU"
          },
          {
            "name": "PUCARA",
            "code": "ZPX"
          },
          {
            "name": "HUITE",
            "code": "ZHI"
          },
          {
            "name": "FOLILCO",
            "code": "ZFO"
          },
          {
            "name": "RINIHUE",
            "code": "XGR"
          },
          {
            "name": "PUCONO",
            "code": "PUC"
          },
          {
            "name": "LIPINGUE",
            "code": "OSN"
          },
          {
            "name": "LOS LAGOS",
            "code": "LAG"
          },
          {
            "name": "HUICHACO",
            "code": "HIC"
          },
          {
            "name": "COLEGUAL - VALDIVIA",
            "code": "COA"
          }
        ]
      },
      {
        "name": "MAFIL",
        "code": 14105,
        "defaultDistrict": "MFL",
        "districts": [
          {
            "name": "FUNDO ALTUE",
            "code": "FAE"
          },
          {
            "name": "PUERTO PAICO",
            "code": "ZAE"
          },
          {
            "name": "CHANCOYAN",
            "code": "ZAX"
          },
          {
            "name": "MAFIL",
            "code": "MFL"
          }
        ]
      },
      {
        "name": "MARIQUINA",
        "code": 14106,
        "defaultDistrict": "MQA",
        "districts": [
          {
            "name": "PICHOY",
            "code": "CHY"
          },
          {
            "name": "QUEULE - VALDIVIA",
            "code": "ZQU"
          },
          {
            "name": "PURINGUE",
            "code": "ZPG"
          },
          {
            "name": "FUERTE SAN LUIS",
            "code": "ZFF"
          },
          {
            "name": "CIRUELOS - VALDIVIA",
            "code": "ZCI"
          },
          {
            "name": "MEHUIN",
            "code": "MEH"
          },
          {
            "name": "S.J. DE LA MARIQUINA",
            "code": "MQA"
          }
        ]
      },
      {
        "name": "PAILLACO",
        "code": 14107,
        "defaultDistrict": "PAI",
        "districts": [
          {
            "name": "MANAO - VALDIVIA",
            "code": "MMO"
          },
          {
            "name": "LA PENA",
            "code": "ZLP"
          },
          {
            "name": "PICHIRROPULLI",
            "code": "ZPI"
          },
          {
            "name": "LOS ULMOS",
            "code": "ZLX"
          },
          {
            "name": "REUMEN",
            "code": "RMN"
          },
          {
            "name": "TRAITRACO",
            "code": "TRR"
          },
          {
            "name": "PAILLACO",
            "code": "PAI"
          },
          {
            "name": "LOS CONALES - OSORNO",
            "code": "OSE"
          }
        ]
      },
      {
        "name": "PANGUIPULLI",
        "code": 14108,
        "defaultDistrict": "PGP",
        "districts": [
          {
            "name": "CHOSHUENCO",
            "code": "CHS"
          },
          {
            "name": "LICAN RAY",
            "code": "LCY"
          },
          {
            "name": "CARIRRINGUE",
            "code": "ZZQ"
          },
          {
            "name": "LIQUINE",
            "code": "ZVC"
          },
          {
            "name": "PUERTO PIRIHUEICO",
            "code": "ZPT"
          },
          {
            "name": "ENCO",
            "code": "ZNC"
          },
          {
            "name": "LOS TALLOS",
            "code": "ZLS"
          },
          {
            "name": "PUERTO FUY",
            "code": "ZFQ"
          },
          {
            "name": "CALAFQUEN",
            "code": "ZCZ"
          },
          {
            "name": "TERMAS DE CONARIPE",
            "code": "TRC"
          },
          {
            "name": "PANGUIPULLI",
            "code": "PGP"
          },
          {
            "name": "PULLINGUE",
            "code": "PGE"
          },
          {
            "name": "NELTUME",
            "code": "NTM"
          },
          {
            "name": "NANCUL",
            "code": "NCU"
          },
          {
            "name": "CONARIPE",
            "code": "CPE"
          }
        ]
      },
      {
        "name": "RIO BUENO",
        "code": 14204,
        "defaultDistrict": "RBN",
        "districts": [
          {
            "name": "LOS CHILCOS",
            "code": "LCL"
          },
          {
            "name": "RIO BUENO",
            "code": "RBN"
          },
          {
            "name": "PUERTO NUEVO",
            "code": "ZXN"
          },
          {
            "name": "SANTA ROSA - OSORNO",
            "code": "ZSR"
          },
          {
            "name": "CHANCHAN",
            "code": "ZNX"
          },
          {
            "name": "CAYURRUCA",
            "code": "ZCY"
          }
        ]
      },
      {
        "name": "VALDIVIA",
        "code": 14101,
        "defaultDistrict": "ZAL",
        "districts": [
          {
            "name": "CURINANCO",
            "code": "CNA"
          },
          {
            "name": "PUNUCAPA",
            "code": "NUC"
          },
          {
            "name": "LOS MOLINOS",
            "code": "LML"
          },
          {
            "name": "HUEYELHUE",
            "code": "ZYH"
          },
          {
            "name": "NIEBLA",
            "code": "NBL"
          },
          {
            "name": "TRALCAO",
            "code": "ZAP"
          },
          {
            "name": "VALDIVIA",
            "code": "ZAL"
          },
          {
            "name": "LOS PELLINES - VALDI",
            "code": "LPS"
          }
        ]
      }
    ]
  },
  {
    "name": "Los Lagos",
    "code": 10,
    "isocode": "LL",
    "ciudades": [
      {
        "name": "ANCUD",
        "code": 10202,
        "defaultDistrict": "ACD",
        "districts": [
          {
            "name": "ANCUD",
            "code": "ACD"
          },
          {
            "name": "CHACAO",
            "code": "CAO"
          },
          {
            "name": "CAULIN",
            "code": "CHG"
          },
          {
            "name": "QUETELMAHUE",
            "code": "PQT"
          },
          {
            "name": "GUALBUN",
            "code": "GBN"
          }
        ]
      },
      {
        "name": "CALBUCO",
        "code": 10102,
        "defaultDistrict": "CBU",
        "districts": [
          {
            "name": "CALBUCO",
            "code": "CBU"
          },
          {
            "name": "HUELMO",
            "code": "PXY"
          }
        ]
      },
      {
        "name": "CASTRO",
        "code": 10201,
        "defaultDistrict": "CTR",
        "districts": [
          {
            "name": "CURAHUE",
            "code": "CGE"
          },
          {
            "name": "ABTAO",
            "code": "PAB"
          },
          {
            "name": "CASTRO",
            "code": "CTR"
          }
        ]
      },
      {
        "name": "CHAITEN",
        "code": 10401,
        "defaultDistrict": "ZCN",
        "districts": [
          {
            "name": "CALETA SANTA BARBARA",
            "code": "PBB"
          },
          {
            "name": "CHAITEN",
            "code": "ZCN"
          },
          {
            "name": "BUILL",
            "code": "PBX"
          },
          {
            "name": "CALETA GONZALO",
            "code": "PCG"
          },
          {
            "name": "TERMAS EL AMARILLO",
            "code": "PTM"
          },
          {
            "name": "PUERTO CARDENAS",
            "code": "TCD"
          }
        ]
      },
      {
        "name": "CHONCHI",
        "code": 10203,
        "defaultDistrict": "ZCH",
        "districts": [
          {
            "name": "CUCAO",
            "code": "CUO"
          },
          {
            "name": "CHADMO CENTRAL",
            "code": "PDN"
          },
          {
            "name": "CHONCHI",
            "code": "ZCH"
          },
          {
            "name": "TEUPA",
            "code": "PTU"
          }
        ]
      },
      {
        "name": "COCHAMO",
        "code": 10103,
        "defaultDistrict": "CMO",
        "districts": [
          {
            "name": "COCHAMO",
            "code": "CMO"
          },
          {
            "name": "ROLLIZO",
            "code": "PWZ"
          },
          {
            "name": "CANUTILLAR",
            "code": "PWC"
          },
          {
            "name": "EL BARRACO",
            "code": "PWA"
          },
          {
            "name": "RALUN",
            "code": "PRA"
          },
          {
            "name": "PUELO",
            "code": "PPL"
          },
          {
            "name": "BANOS DE SOTOMO",
            "code": "PBS"
          }
        ]
      },
      {
        "name": "CURACO DE VELEZ",
        "code": 10204,
        "defaultDistrict": "CVL",
        "districts": [
          {
            "name": "CURACO DE VELEZ",
            "code": "CVL"
          },
          {
            "name": "QUINCHAO",
            "code": "QCH"
          }
        ]
      },
      {
        "name": "DALCAHUE",
        "code": 10205,
        "defaultDistrict": "DLE",
        "districts": [
          {
            "name": "DALCAHUE",
            "code": "DLE"
          },
          {
            "name": "MECHUQUE",
            "code": "PME"
          },
          {
            "name": "ALTO BUTALCURA",
            "code": "PAT"
          },
          {
            "name": "SAN JUAN",
            "code": "JJN"
          },
          {
            "name": "QUICAVI",
            "code": "QIA"
          }
        ]
      },
      {
        "name": "FRESIA",
        "code": 10104,
        "defaultDistrict": "FSA",
        "districts": [
          {
            "name": "FRESIA",
            "code": "FSA"
          },
          {
            "name": "MAICHIHUE",
            "code": "PMA"
          },
          {
            "name": "PARGA",
            "code": "PPD"
          }
        ]
      },
      {
        "name": "FRUTILLAR",
        "code": 10105,
        "defaultDistrict": "FRT",
        "districts": [
          {
            "name": "FRUTILLAR",
            "code": "FRT"
          },
          {
            "name": "PARAGUAY",
            "code": "ZPY"
          },
          {
            "name": "TEGUALDA",
            "code": "ZTG"
          }
        ]
      },
      {
        "name": "FUTALEUFU",
        "code": 10402,
        "defaultDistrict": "FTF",
        "districts": [
          {
            "name": "FUTALEUFU",
            "code": "FTF"
          },
          {
            "name": "LAGO YELCHO",
            "code": "PLG"
          },
          {
            "name": "PUERTO RAMIREZ",
            "code": "PRZ"
          },
          {
            "name": "VILLA SANTA LUCIA",
            "code": "PVI"
          },
          {
            "name": "PUERTO PIEDRA",
            "code": "PIE"
          }
        ]
      },
      {
        "name": "HUALAIHUE",
        "code": 10403,
        "defaultDistrict": "HLH",
        "districts": [
          {
            "name": "AULEN",
            "code": "ALN"
          },
          {
            "name": "TERMAS DE LLANCATUE",
            "code": "TLE"
          },
          {
            "name": "POYO",
            "code": "PWY"
          },
          {
            "name": "CALETA HUALAIHUE",
            "code": "PWX"
          },
          {
            "name": "CHOLGO",
            "code": "PWS"
          },
          {
            "name": "CHAPARANO",
            "code": "PWQ"
          },
          {
            "name": "SEGUNDO CORRAL",
            "code": "PSE"
          },
          {
            "name": "PRIMER CORRAL",
            "code": "PPR"
          },
          {
            "name": "PICHANCO",
            "code": "PPI"
          },
          {
            "name": "HUINAY",
            "code": "PHN"
          },
          {
            "name": "LLANADA GRANDE",
            "code": "PGX"
          },
          {
            "name": "CONTAO",
            "code": "PCM"
          },
          {
            "name": "AYACARA",
            "code": "PAY"
          },
          {
            "name": "HORNOPIREN",
            "code": "HRP"
          },
          {
            "name": "HUALAIHUE",
            "code": "HLH"
          }
        ]
      },
      {
        "name": "LLANQUIHUE",
        "code": 10107,
        "defaultDistrict": "LLQ",
        "districts": [
          {
            "name": "LLANQUIHUE",
            "code": "LLQ"
          },
          {
            "name": "LONCOTORO",
            "code": "LNT"
          },
          {
            "name": "LOS PELLINES - PUERT",
            "code": "PWT"
          },
          {
            "name": "COLEGUAL - PUERTO MO",
            "code": "PCL"
          }
        ]
      },
      {
        "name": "LOS MUERMOS",
        "code": 10106,
        "defaultDistrict": "LMU",
        "districts": [
          {
            "name": "LOLCURA",
            "code": "LLA"
          },
          {
            "name": "RIO FRIO",
            "code": "PWF"
          },
          {
            "name": "LAS QUEMAS",
            "code": "PLS"
          },
          {
            "name": "LOS MUERMOS",
            "code": "LMU"
          }
        ]
      },
      {
        "name": "MAULLIN",
        "code": 10108,
        "defaultDistrict": "MAU",
        "districts": [
          {
            "name": "CARELMAPU",
            "code": "CRU"
          },
          {
            "name": "MISQUIHUE",
            "code": "MSQ"
          },
          {
            "name": "MAULLIN",
            "code": "MAU"
          },
          {
            "name": "PUELPUN",
            "code": "PPP"
          },
          {
            "name": "PARGUA",
            "code": "ZGA"
          },
          {
            "name": "PANGAL - PUERTO MONT",
            "code": "PPA"
          }
        ]
      },
      {
        "name": "OSORNO",
        "code": 10301,
        "defaultDistrict": "ZOS",
        "districts": [
          {
            "name": "CANCURA",
            "code": "OAR"
          },
          {
            "name": "PICHI DAMAS",
            "code": "OSD"
          },
          {
            "name": "MONTE VERDE",
            "code": "ZMV"
          },
          {
            "name": "REMEHUE",
            "code": "ZRM"
          },
          {
            "name": "OSORNO",
            "code": "ZOS"
          },
          {
            "name": "LAS LUMAS",
            "code": "OSM"
          }
        ]
      },
      {
        "name": "PALENA",
        "code": 10404,
        "defaultDistrict": "PLE",
        "districts": [
          {
            "name": "PALENA",
            "code": "PLE"
          },
          {
            "name": "VILLA VANGUARDIA",
            "code": "PVL"
          }
        ]
      },
      {
        "name": "PUERTO MONTT",
        "code": 10101,
        "defaultDistrict": "PMC",
        "districts": [
          {
            "name": "ALERCE",
            "code": "ALE"
          },
          {
            "name": "RANCHO PUERTO MONTT",
            "code": "RPM"
          },
          {
            "name": "CHAMIZA",
            "code": "PZH"
          },
          {
            "name": "QUILLAIPE",
            "code": "PTE"
          },
          {
            "name": "PUERTO MONTT",
            "code": "PMC"
          },
          {
            "name": "LENCA",
            "code": "PLW"
          },
          {
            "name": "CORRENTOSO",
            "code": "PCT"
          },
          {
            "name": "CALETA LA ARENA",
            "code": "PCA"
          },
          {
            "name": "EL TEPUAL",
            "code": "ETL"
          }
        ]
      },
      {
        "name": "PUERTO OCTAY",
        "code": 10302,
        "defaultDistrict": "PCY",
        "districts": [
          {
            "name": "LAS CASCADAS",
            "code": "LDS"
          },
          {
            "name": "PIEDRAS NEGRAS",
            "code": "PNG"
          },
          {
            "name": "REFUGIO LA PICADA",
            "code": "ZRD"
          },
          {
            "name": "PUERTO CLOCKER",
            "code": "ZPK"
          },
          {
            "name": "LOS BAJOS",
            "code": "ZEP"
          },
          {
            "name": "PUERTO FONCK",
            "code": "XPF"
          },
          {
            "name": "CENTRAL RUPANCO",
            "code": "OOC"
          },
          {
            "name": "PUERTO OCTAY",
            "code": "PCY"
          }
        ]
      },
      {
        "name": "PUERTO VARAS",
        "code": 10109,
        "defaultDistrict": "ZPV",
        "districts": [
          {
            "name": "ENSENADA",
            "code": "ENS"
          },
          {
            "name": "NUEVA BRAUNAU",
            "code": "NBR"
          },
          {
            "name": "PUERTO VARAS",
            "code": "ZPV"
          },
          {
            "name": "LA POSA",
            "code": "PWP"
          },
          {
            "name": "RIO SUR",
            "code": "RIS"
          },
          {
            "name": "PETROHUE",
            "code": "PTH"
          },
          {
            "name": "LOS RISCOS",
            "code": "OSC"
          }
        ]
      },
      {
        "name": "PUQUELDON",
        "code": 10206,
        "defaultDistrict": "PQE",
        "districts": [
          {
            "name": "ALDACHILDO",
            "code": "ADO"
          },
          {
            "name": "PUQUELDON",
            "code": "PQE"
          }
        ]
      },
      {
        "name": "PURRANQUE",
        "code": 10303,
        "defaultDistrict": "PRE",
        "districts": [
          {
            "name": "CASMA",
            "code": "OAM"
          },
          {
            "name": "CONCORDIA",
            "code": "ZIX"
          },
          {
            "name": "HUEYUSCA",
            "code": "ZHY"
          },
          {
            "name": "LOS CORRALES",
            "code": "ZEU"
          },
          {
            "name": "PURRANQUE",
            "code": "PRE"
          },
          {
            "name": "CRUCERO",
            "code": "OOR"
          },
          {
            "name": "CORTE ALTO",
            "code": "OOT"
          }
        ]
      },
      {
        "name": "PUYEHUE",
        "code": 10304,
        "defaultDistrict": "PYH",
        "districts": [
          {
            "name": "ENTRE LAGOS",
            "code": "ENL"
          },
          {
            "name": "AGUAS CALIENTES - OS",
            "code": "ZAA"
          },
          {
            "name": "TERMAS DE PUYEHUE",
            "code": "ZTH"
          },
          {
            "name": "REFUGIO ANTILLANCA",
            "code": "ZRN"
          },
          {
            "name": "PAJARITOS",
            "code": "ZPJ"
          },
          {
            "name": "NILQUE",
            "code": "ZLY"
          },
          {
            "name": "EL ENCANTO ",
            "code": "ZEE"
          },
          {
            "name": "EL ISLOTE",
            "code": "ZEO"
          },
          {
            "name": "ANTICURA",
            "code": "ZAC"
          },
          {
            "name": "PUYEHUE",
            "code": "PYH"
          },
          {
            "name": "PUERTO RICO",
            "code": "OOI"
          }
        ]
      },
      {
        "name": "QUEILEN",
        "code": 10207,
        "defaultDistrict": "QLE",
        "districts": [
          {
            "name": "AHONI",
            "code": "AHI"
          },
          {
            "name": "PAILDAD",
            "code": "PPU"
          },
          {
            "name": "CONTAY",
            "code": "PCN"
          },
          {
            "name": "QUEILEN",
            "code": "QLE"
          },
          {
            "name": "AITUI",
            "code": "PWU"
          }
        ]
      },
      {
        "name": "QUELLON",
        "code": 10208,
        "defaultDistrict": "QLN",
        "districts": [
          {
            "name": "HUILDAD",
            "code": "PHI"
          },
          {
            "name": "QUELLON",
            "code": "QLN"
          },
          {
            "name": "RANCHO QUELLON",
            "code": "RQL"
          },
          {
            "name": "QUELLON VIEJO",
            "code": "QUV"
          },
          {
            "name": "YALDAD",
            "code": "PYA"
          },
          {
            "name": "TRINCAO - CASTRO",
            "code": "PWD"
          },
          {
            "name": "COINCO - CASTRO",
            "code": "PWI"
          }
        ]
      },
      {
        "name": "QUEMCHI",
        "code": 10209,
        "defaultDistrict": "QUE",
        "districts": [
          {
            "name": "HUILLINCO",
            "code": "HNO"
          },
          {
            "name": "QUEMCHI",
            "code": "QUE"
          },
          {
            "name": "AGUAS  BUENAS",
            "code": "PZG"
          },
          {
            "name": "BELBEN",
            "code": "PZB"
          },
          {
            "name": "LINAO",
            "code": "PLI"
          },
          {
            "name": "LLIUCO",
            "code": "PLU"
          },
          {
            "name": "MANAO - CASTRO",
            "code": "PMN"
          },
          {
            "name": "DEGAN",
            "code": "PDG"
          },
          {
            "name": "AUCAR",
            "code": "PAU"
          }
        ]
      },
      {
        "name": "QUINCHAO",
        "code": 10210,
        "defaultDistrict": "ZAO",
        "districts": [
          {
            "name": "APIAO",
            "code": "APO"
          },
          {
            "name": "ACHAO",
            "code": "ZAO"
          },
          {
            "name": "CHAULINEC",
            "code": "PHC"
          }
        ]
      },
      {
        "name": "RIO NEGRO",
        "code": 10305,
        "defaultDistrict": "RNC",
        "districts": [
          {
            "name": "MILLANTUE",
            "code": "OET"
          },
          {
            "name": "CHAHUILCO",
            "code": "OOL"
          },
          {
            "name": "HUILMA",
            "code": "ZHM"
          },
          {
            "name": "EL BOLSON",
            "code": "ZEB"
          },
          {
            "name": "RIO NEGRO",
            "code": "RNC"
          }
        ]
      },
      {
        "name": "SAN JUAN DE LA COSTA",
        "code": 10306,
        "defaultDistrict": "SJD",
        "districts": [
          {
            "name": "PUCATRIHUE",
            "code": "OEH"
          },
          {
            "name": "PUAUCHO",
            "code": "OOH"
          },
          {
            "name": "S.JUAN DE LA COSTA",
            "code": "SJD"
          },
          {
            "name": "MAICOLPUE",
            "code": "ZWQ"
          },
          {
            "name": "BAHIA MANSA",
            "code": "ZBH"
          },
          {
            "name": "CONTACO",
            "code": "OOA"
          }
        ]
      },
      {
        "name": "SAN PABLO",
        "code": 10307,
        "defaultDistrict": "SPL",
        "districts": [
          {
            "name": "CHIRRE",
            "code": "OER"
          },
          {
            "name": "CARACOL",
            "code": "OLO"
          },
          {
            "name": "FILUCO",
            "code": "ZFI"
          },
          {
            "name": "PURRAPEL",
            "code": "OLE"
          },
          {
            "name": "SAN PABLO - OSORNO",
            "code": "SPL"
          }
        ]
      }
    ]
  },
  {
    "name": "Aysén",
    "code": 11,
    "isocode": "AI",
    "ciudades": [
      {
        "name": "AYSEN",
        "code": 11201,
        "defaultDistrict": "WPA",
        "districts": [
          {
            "name": "PUERTO AGUIRRE",
            "code": "AGR"
          },
          {
            "name": "MANIHUALES",
            "code": "GMH"
          },
          {
            "name": "MINA EL TOQUI",
            "code": "GMT"
          },
          {
            "name": "PUERTO AYSEN",
            "code": "WPA"
          },
          {
            "name": "PUERTO CHACABUCO",
            "code": "PCC"
          },
          {
            "name": "SANTA MARIA DEL MAR",
            "code": "GSM"
          },
          {
            "name": "EL GATO",
            "code": "IAU"
          },
          {
            "name": "VILLA MANIHUALES",
            "code": "MHS"
          },
          {
            "name": "PUERTO GAVIOTA",
            "code": "GVH"
          }
        ]
      },
      {
        "name": "CHILE CHICO",
        "code": 11401,
        "defaultDistrict": "CCH",
        "districts": [
          {
            "name": "CHILE CHICO",
            "code": "CCH"
          },
          {
            "name": "PUERTO FACHINAL",
            "code": "GPF"
          },
          {
            "name": "PUERTO MURTA",
            "code": "GPX"
          },
          {
            "name": "PUERTO SANCHEZ",
            "code": "GPZ"
          },
          {
            "name": "PUERTO TRANQUILO",
            "code": "TGL"
          },
          {
            "name": "PUERTO GUADAL",
            "code": "PGU"
          },
          {
            "name": "PUERTO BERTRAND",
            "code": "PBI"
          }
        ]
      },
      {
        "name": "CISNES",
        "code": 11202,
        "defaultDistrict": "CNS",
        "districts": [
          {
            "name": "CISNES",
            "code": "CNS"
          },
          {
            "name": "LA TAPERA",
            "code": "GLT"
          },
          {
            "name": "PUERTO CISNES",
            "code": "PCI"
          },
          {
            "name": "TERMAS DE PUYUHUAPI",
            "code": "GTP"
          },
          {
            "name": "VILLA AMENGUAL",
            "code": "VGL"
          },
          {
            "name": "PUYUHUAPI",
            "code": "YUH"
          },
          {
            "name": "RIO CISNES",
            "code": "GRC"
          }
        ]
      },
      {
        "name": "COCHRANE",
        "code": 11301,
        "defaultDistrict": "CCL",
        "districts": [
          {
            "name": "LAGO COCHRANE",
            "code": "ANE"
          },
          {
            "name": "PUERTO HERRADURA",
            "code": "GXP"
          },
          {
            "name": "COCHRANE",
            "code": "CCL"
          },
          {
            "name": "VILLA CHACABUCO",
            "code": "GVC"
          }
        ]
      },
      {
        "name": "COYHAIQUE",
        "code": 11101,
        "defaultDistrict": "GXQ",
        "districts": [
          {
            "name": "BALMACEDA",
            "code": "BBA"
          },
          {
            "name": "COYHAIQUE ALTO",
            "code": "GAX"
          },
          {
            "name": "BANO NUEVO",
            "code": "BNO"
          },
          {
            "name": "COYHAIQUE",
            "code": "GXQ"
          },
          {
            "name": "VILLA ORTEGA",
            "code": "GVZ"
          },
          {
            "name": "NIREGUAO",
            "code": "GNG"
          },
          {
            "name": "LAGUNA SAN RAFAEL",
            "code": "GLS"
          }
        ]
      },
      {
        "name": "GUAITECAS",
        "code": 11203,
        "defaultDistrict": "GCA",
        "districts": [
          {
            "name": "GUAITECAS",
            "code": "GCA"
          },
          {
            "name": "ISLA ANGAMOS",
            "code": "GIA"
          },
          {
            "name": "ISLA IPUN",
            "code": "GII"
          },
          {
            "name": "ISLA MELCHOR",
            "code": "GIM"
          },
          {
            "name": "ISLA CUPTANA",
            "code": "GIP"
          },
          {
            "name": "ISLA VICTORIA",
            "code": "GIV"
          },
          {
            "name": "ISLA IZAZO",
            "code": "GIZ"
          },
          {
            "name": "MELINKA",
            "code": "NKA"
          },
          {
            "name": "ISLA NALCAYEC",
            "code": "GIN"
          },
          {
            "name": "ISLA LEVEL",
            "code": "GIL"
          },
          {
            "name": "ISLA BENJAMIN",
            "code": "GIB"
          }
        ]
      },
      {
        "name": "LAGO VERDE",
        "code": 11102,
        "defaultDistrict": "LVE",
        "districts": [
          {
            "name": "LA JUNTA - COYHAIQUE",
            "code": "JUN"
          },
          {
            "name": "LAGO VERDE",
            "code": "LVE"
          }
        ]
      },
      {
        "name": "OHIGGINS",
        "code": 11302,
        "defaultDistrict": "OHG",
        "districts": [
          {
            "name": "O HIGGINS",
            "code": "OHG"
          },
          {
            "name": "VILLA OHIGGINS",
            "code": "VOH"
          }
        ]
      },
      {
        "name": "RIO IBANEZ",
        "code": 11402,
        "defaultDistrict": "RIB",
        "districts": [
          {
            "name": "PUERTO ING.IBANEZ",
            "code": "GIQ"
          },
          {
            "name": "VILLA CERRO CASTILLO",
            "code": "VCC"
          },
          {
            "name": "LEVICAN",
            "code": "GLV"
          },
          {
            "name": "RIO IBANEZ",
            "code": "RIB"
          }
        ]
      },
      {
        "name": "TORTEL",
        "code": 11303,
        "defaultDistrict": "TRT",
        "districts": [
          {
            "name": "ISLA CAMPANA",
            "code": "GIC"
          },
          {
            "name": "CALETA TORTEL",
            "code": "TOR"
          },
          {
            "name": "TORTEL",
            "code": "TRT"
          },
          {
            "name": "ISLA MERINO JARPA",
            "code": "GMJ"
          },
          {
            "name": "PUERTO YUNGAY",
            "code": "GPY"
          },
          {
            "name": "ISLA PATRICIO LYNCH",
            "code": "GIY"
          }
        ]
      }
    ]
  },
  {
    "name": "Magallanes y la Antartica Chilena",
    "code": 12,
    "isocode": "MA",
    "ciudades": [
      {
        "name": "ANTARTICA",
        "code": 12202,
        "defaultDistrict": "ATC",
        "districts": [
          {
            "name": "ANTARTICA",
            "code": "ATC"
          }
        ]
      },
      {
        "name": "CABO DE HORNOS",
        "code": 12201,
        "defaultDistrict": "HOR",
        "districts": [
          {
            "name": "CALETA EUGENIA",
            "code": "CEU"
          },
          {
            "name": "CABO DE HORNOS",
            "code": "HOR"
          },
          {
            "name": "PUERTO TORO",
            "code": "PTO"
          },
          {
            "name": "YENDEGAIA",
            "code": "YEN"
          },
          {
            "name": "PUERTO WILLIAMS",
            "code": "PWL"
          },
          {
            "name": "ISLA NAVARINO",
            "code": "INV"
          },
          {
            "name": "LAPATAIA",
            "code": "LTA"
          }
        ]
      },
      {
        "name": "LAGUNA BLANCA",
        "code": 12102,
        "defaultDistrict": "LBL",
        "districts": [
          {
            "name": "LAGUNA BLANCA",
            "code": "LBL"
          }
        ]
      },
      {
        "name": "NATALES",
        "code": 12401,
        "defaultDistrict": "PNT",
        "districts": [
          {
            "name": "CERRO CASTILLO ",
            "code": "CEC"
          },
          {
            "name": "LA JUNTA  ",
            "code": "PLJ"
          },
          {
            "name": "PUERTO NATALES",
            "code": "PNT"
          },
          {
            "name": "RUBENS",
            "code": "RBS"
          },
          {
            "name": "RIO TURBIO",
            "code": "RTT"
          },
          {
            "name": "PUERTO BORIES",
            "code": "PPB"
          }
        ]
      },
      {
        "name": "PORVENIR",
        "code": 12301,
        "defaultDistrict": "ZPR",
        "districts": [
          {
            "name": "ARMONIA",
            "code": "ARM"
          },
          {
            "name": "ISLA DAWSON",
            "code": "IDW"
          },
          {
            "name": "PORVENIR - PUNTA ARE",
            "code": "ZPR"
          },
          {
            "name": "SECCION RUSSFIN",
            "code": "SRU"
          },
          {
            "name": "PUERTO PERCY",
            "code": "PZP"
          },
          {
            "name": "PAMPA GUANACOS",
            "code": "PPG"
          }
        ]
      },
      {
        "name": "PRIMAVERA",
        "code": 12302,
        "defaultDistrict": "PRI",
        "districts": [
          {
            "name": "CERRO SOMBRERO",
            "code": "CSM"
          },
          {
            "name": "ESTANCIA CHINA CR.",
            "code": "ECH"
          },
          {
            "name": "SAN SEBASTIAN",
            "code": "KSB"
          },
          {
            "name": "CULLEN",
            "code": "QEN"
          },
          {
            "name": "PRIMAVERA",
            "code": "PRI"
          },
          {
            "name": "ONAISIN",
            "code": "ONA"
          },
          {
            "name": "MANANTIALES",
            "code": "MTS"
          },
          {
            "name": "ESTANCIA LOS OLIVOS",
            "code": "ELO"
          }
        ]
      },
      {
        "name": "PUNTA ARENAS",
        "code": 12101,
        "defaultDistrict": "PUQ",
        "districts": [
          {
            "name": "CABEZA DE MAR",
            "code": "CAB"
          },
          {
            "name": "ESTANCIA SAN JUAN",
            "code": "ESJ"
          },
          {
            "name": "TERMINAL CABO NEGRO",
            "code": "TCN"
          },
          {
            "name": "RANCHO PUNTA ARENAS",
            "code": "RPU"
          },
          {
            "name": "PUNTA ARENAS",
            "code": "PUQ"
          },
          {
            "name": "MINA PECKET",
            "code": "MPK"
          },
          {
            "name": "FUERTE BULNES",
            "code": "FBL"
          }
        ]
      },
      {
        "name": "RIO VERDE",
        "code": 12103,
        "defaultDistrict": "RVE",
        "districts": [
          {
            "name": "ENTRE VIENTOS",
            "code": "EVT"
          },
          {
            "name": "VILLA TEHUELCHES",
            "code": "VTT"
          },
          {
            "name": "RIO VERDE",
            "code": "RVE"
          },
          {
            "name": "RIO GRANDE",
            "code": "RGG"
          },
          {
            "name": "PUERTO ALTAMIRANO",
            "code": "PPN"
          },
          {
            "name": "MORRO CHICO",
            "code": "MRC"
          }
        ]
      },
      {
        "name": "SAN GREGORIO",
        "code": 12104,
        "defaultDistrict": "SGG",
        "districts": [
          {
            "name": "GAIKE",
            "code": "GKE"
          },
          {
            "name": "GALLEGOS CHICOS",
            "code": "PGL"
          },
          {
            "name": "ESTANCIA SN GREGORIO",
            "code": "PES"
          },
          {
            "name": "SAN GREGORIO - PUNTA",
            "code": "SGG"
          },
          {
            "name": "TERMINAL SAN GREGORI",
            "code": "PZA"
          },
          {
            "name": "MONTE AYMOND",
            "code": "MAY"
          },
          {
            "name": "PUNTA DELGADA",
            "code": "PDU"
          }
        ]
      },
      {
        "name": "TIMAUKEL",
        "code": 12303,
        "defaultDistrict": "PTI",
        "districts": [
          {
            "name": "CAMERON",
            "code": "PCX"
          },
          {
            "name": "PUERTO YARTAU",
            "code": "PPY"
          },
          {
            "name": "PUERTO ARTURO",
            "code": "UOR"
          },
          {
            "name": "TIMAUKEL",
            "code": "PTI"
          },
          {
            "name": "PUERTO CONDOR",
            "code": "PPC"
          }
        ]
      },
      {
        "name": "TORRES DEL PAINE",
        "code": 12402,
        "defaultDistrict": "TRP",
        "districts": [
          {
            "name": "ESTANCIA VICTORINA",
            "code": "ESV"
          },
          {
            "name": "PEHOE",
            "code": "PHE"
          },
          {
            "name": "TORRES DEL PAINE",
            "code": "TRP"
          }
        ]
      }
    ]
  }
];
const container$1 = "_container_1ehjy_1";
const selectWrapper = "_selectWrapper_1ehjy_7";
const styles$7 = {
  container: container$1,
  selectWrapper
};
const findLocationByDistrictCode = (code) => {
  for (const region of comunas) {
    for (const city of region.ciudades) {
      const district = city.districts.find((d) => d.code === code);
      if (district) {
        return {
          regionName: region.name,
          cityName: city.name,
          cities: region.ciudades,
          districts: city.districts
        };
      }
    }
  }
  return null;
};
const DistrictSelector = ({
  register,
  setValue,
  initialValue,
  name
}) => {
  const [selectedRegion, setSelectedRegion] = reactExports.useState("");
  const [selectedDistrict, setSelectedDistrict] = reactExports.useState("");
  const [districts, setDistricts] = reactExports.useState([]);
  const [initialized, setInitialized] = reactExports.useState(false);
  const getDistrictsForRegion = (regionName) => {
    const regionData = comunas.find((r) => r.name === regionName);
    if (!regionData) return [];
    return regionData.ciudades.reduce(
      (acc, city) => acc.concat(city.districts),
      []
    );
  };
  reactExports.useEffect(() => {
    if (initialValue) {
      const location = findLocationByDistrictCode(initialValue);
      if (location) {
        setSelectedRegion(location.regionName);
        setDistricts(getDistrictsForRegion(location.regionName));
        setSelectedDistrict(initialValue);
        setValue(name, initialValue);
        setInitialized(true);
      }
    }
  }, [initialValue, setValue, name]);
  reactExports.useEffect(() => {
    if (selectedDistrict && districts.length > 0) {
      const districtExists = districts.find((d) => d.code === selectedDistrict);
      if (districtExists) {
        setValue(name, selectedDistrict);
      }
    }
  }, [selectedDistrict, districts, setValue, name]);
  reactExports.useEffect(() => {
    register(name);
  }, [register, name]);
  reactExports.useEffect(() => {
    var _a;
    if (!initialized && initialValue) {
      return;
    }
    if (selectedRegion) {
      setDistricts(getDistrictsForRegion(selectedRegion));
      if (!initialValue || ((_a = findLocationByDistrictCode(initialValue)) == null ? void 0 : _a.regionName) !== selectedRegion) {
        setSelectedDistrict("");
        setValue(name, "");
      }
    } else {
      if (initialized) {
        setDistricts([]);
        setSelectedDistrict("");
        setValue(name, "");
      }
    }
  }, [selectedRegion, setValue, name, initialValue, initialized]);
  const handleRegionChange = (e) => {
    setSelectedRegion(e.target.value);
    setSelectedDistrict("");
    setDistricts([]);
    setValue(name, "");
  };
  const handleDistrictChange = (e) => {
    setSelectedDistrict(e.target.value);
    setValue(name, e.target.value);
  };
  const regionOptions = comunas.map((region) => ({
    value: region.name,
    label: region.name
  }));
  const districtOptions = districts.map((district) => ({
    value: district.code,
    label: district.name
  }));
  const filteredDistrictOptions = districtOptions;
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$7.container, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$7.selectWrapper, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(Label, { children: "Región de origen" }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        SearchableSelect,
        {
          value: selectedRegion,
          onChange: handleRegionChange,
          placeholder: "Seleccione o busque una región",
          options: regionOptions
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$7.selectWrapper, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(Label, { children: "Comuna de origen" }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        SearchableSelect,
        {
          value: selectedDistrict,
          onChange: handleDistrictChange,
          options: filteredDistrictOptions,
          placeholder: "Seleccione o busque una comuna",
          disabled: !selectedRegion
        },
        selectedRegion
      )
    ] })
  ] });
};
const ENABLE_DEVTOOLS$1 = String("false") === "true";
const FormConfig = ({
  storeId,
  errorValidation,
  settings,
  optionsEmissionOs = [],
  setActiveSection,
  setDeveloperToolsOpen,
  OnSaveSettings
}) => {
  const [toast2, setToast] = reactExports.useState(null);
  const {
    register,
    handleSubmit,
    watch,
    setValue,
    formState: { isSubmitting }
  } = useForm({
    defaultValues: {
      storeId,
      ...settings,
      districtsEnable: (settings == null ? void 0 : settings.districtsEnable) === "yes" ? true : false,
      pudoEnable: (settings == null ? void 0 : settings.pudoEnable) === "yes" ? true : false,
      active_logs: (settings == null ? void 0 : settings.active_logs) === "yes" ? true : false
    }
  });
  const [error2, setError] = reactExports.useState(null);
  const onSubmit = async (data) => {
    try {
      setToast({
        message: "Guardando configuración...",
        type: "info"
      });
      await saveSettings({
        ...data,
        districtsEnable: (data == null ? void 0 : data.districtsEnable) ? "yes" : "no",
        pudoEnable: (data == null ? void 0 : data.pudoEnable) ? "yes" : "no",
        active_logs: (data == null ? void 0 : data.active_logs) ? "yes" : "no"
      });
      OnSaveSettings();
      setToast({
        message: "Configuración guardada correctamente",
        type: "success"
      });
    } catch (error22) {
      setError(error22);
      setToast({
        message: "Error al guardar la configuración",
        type: "error"
      });
    }
  };
  const isEnabledLogs = watch("active_logs");
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$9.formContainer, children: [
    toast2 && /* @__PURE__ */ jsxRuntimeExports.jsx(
      Toast,
      {
        message: toast2.message,
        type: toast2.type,
        onClose: () => setToast(null)
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsx("h2", { className: styles$9.formTitle, children: "Configuración" }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("form", { onSubmit: handleSubmit(onSubmit), className: styles$9.form, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$9.notificationBanner, children: /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$9.notificationText, children: "Termina la configuración de tu tienda para que puedas empezar a gestionar tus envíos con Blue Express." }) }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("h3", { className: styles$9.subTitle, children: "Configura tu tienda" }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$9.rowControls, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$9.rowControlsItem, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
          DistrictSelector,
          {
            register,
            setValue,
            initialValue: settings == null ? void 0 : settings.districtCode,
            name: "districtCode"
          }
        ) }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$9.rowControlsItem, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(Label, { children: "Estado para crear orden en Ecommerce Blue Express" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            SearchableSelect,
            {
              value: watch("noBlueStatus") || "",
              onChange: (e) => setValue("noBlueStatus", e.target.value),
              options: optionsEmissionOs,
              placeholder: "Seleccione o busque un estado"
            }
          )
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$9.checkboxSection, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("h4", { className: styles$9.checkboxSectionTitle, children: "Opciones generales" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$9.rowControls, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$9.rowControlsItem, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
          Checkbox,
          {
            register,
            name: "pudoEnable",
            label: "Habilitar Puntos de retiro Blue Express"
          }
        ) }) })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$9.checkboxSection, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("h4", { className: styles$9.checkboxSectionTitle, children: "Checkout y Direcciones" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$9.rowControls, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$9.rowControlsItem, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            Checkbox,
            {
              register,
              name: "districtsEnable",
              label: "Activación de comunas y regiones en checkout"
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: styles$9.helpText, children: "Convierte los campos de región y ciudad en listas desplegables con opciones predefinidas de Chile." })
        ] }) })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$9.checkboxSection, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("h4", { className: styles$9.checkboxSectionTitle, children: "Logs y Soporte" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$9.rowControls, children: /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$9.rowControlsItem, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
          Checkbox,
          {
            register,
            name: "active_logs",
            label: "Habilitar logs"
          }
        ) }) }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$9.rowControls, children: [
          isEnabledLogs && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$9.rowControlsItem, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            "button",
            {
              type: "button",
              className: styles$9.buttonSecondary,
              onClick: () => setActiveSection("logs"),
              children: "Logs de sistema"
            }
          ) }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$9.rowControlsItem, children: ENABLE_DEVTOOLS$1 && /* @__PURE__ */ jsxRuntimeExports.jsx(
            "button",
            {
              type: "button",
              className: styles$9.buttonSecondary,
              onClick: () => setDeveloperToolsOpen(true),
              children: "Herramientas de desarrollo"
            }
          ) })
        ] })
      ] }),
      errorValidation && /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: styles$9.errorText, children: errorValidation }),
      error2 && /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: styles$9.errorText, children: error2 }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("button", { type: "submit", disabled: isSubmitting, className: styles$9.button, children: "Guardar configuración" })
    ] })
  ] });
};
const formContainer = "_formContainer_ecg4b_1";
const form$1 = "_form_ecg4b_1";
const formTitle = "_formTitle_ecg4b_16";
const formDescription = "_formDescription_ecg4b_23";
const storeIdInput = "_storeIdInput_ecg4b_30";
const subTitle = "_subTitle_ecg4b_46";
const tooltip = "_tooltip_ecg4b_55";
const tooltipIcon = "_tooltipIcon_ecg4b_62";
const tooltipText = "_tooltipText_ecg4b_74";
const errorText = "_errorText_ecg4b_110";
const successText = "_successText_ecg4b_118";
const input = "_input_ecg4b_126";
const button$1 = "_button_ecg4b_144";
const link = "_link_ecg4b_167";
const rowControls = "_rowControls_ecg4b_179";
const rowControlsItem = "_rowControlsItem_ecg4b_187";
const rowControlsItemLabel = "_rowControlsItemLabel_ecg4b_194";
const createAccountText = "_createAccountText_ecg4b_201";
const helperText = "_helperText_ecg4b_208";
const styles$6 = {
  formContainer,
  form: form$1,
  formTitle,
  formDescription,
  storeIdInput,
  subTitle,
  tooltip,
  tooltipIcon,
  tooltipText,
  errorText,
  successText,
  input,
  button: button$1,
  link,
  rowControls,
  rowControlsItem,
  rowControlsItemLabel,
  createAccountText,
  helperText
};
const FormNewIntegrate = ({
  storeId,
  error: error2,
  setLoading,
  validateIntegration,
  isActiveIntegration
}) => {
  const [toast2, setToast] = reactExports.useState(null);
  const {
    register,
    handleSubmit,
    formState: { isSubmitting }
  } = useForm({
    defaultValues: {
      storeId: storeId || "",
      clientKey: "",
      clientSecret: ""
    }
  });
  const onSubmit = async (data) => {
    if (!data.storeId || !data.clientKey || !data.clientSecret) {
      setToast({
        message: "Por favor completa todos los campos",
        type: "warning"
      });
      return;
    }
    try {
      setLoading(true);
      const response = await updateIntegrationCredentials(data.storeId, {
        clientKey: data.clientKey,
        clientSecret: data.clientSecret
      });
      if (response.activeIntegration === false) {
        setToast({
          message: response.message || "Error al actualizar las credenciales",
          type: "error"
        });
      } else {
        await validateIntegration();
        setToast({
          message: "¡Conexión establecida correctamente!",
          type: "success"
        });
      }
    } catch (error22) {
      console.error("Error updating integration credentials:", error22);
      setToast({
        message: "Error al actualizar las credenciales",
        type: "error"
      });
    } finally {
      setLoading(false);
    }
  };
  const renderText = (errorMsg) => {
    const normalizedError = (errorMsg || "").toLowerCase();
    if (normalizedError.includes("cloudflare")) {
      return "La IP de tu servidor está siendo bloqueada por Cloudflare, nuestro proveedor de seguridad. Comunícate con el soporte de Blue Express para ayudarte con la guía.";
    }
    if (errorMsg.includes("401")) {
      return "La Url o Api Key de Blue Express no son correctas";
    }
    if (errorMsg.includes("404") || normalizedError.includes("no encontramos tu dominio")) {
      return /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
        "¿Aún no estás registrado? Ingresa a",
        " ",
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "a",
          {
            href: "https://ecommerce.blue.cl",
            className: styles$6.link,
            target: "_blank",
            rel: "noopener noreferrer",
            children: "ecommerce.blue.cl"
          }
        ),
        " ",
        "y regístrate para empezar a disfrutar de nuestros beneficios."
      ] });
    }
    return errorMsg;
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$6.formContainer, children: [
    toast2 && /* @__PURE__ */ jsxRuntimeExports.jsx(
      Toast,
      {
        message: toast2.message,
        type: toast2.type,
        onClose: () => setToast(null)
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsx("h2", { className: styles$6.formTitle, children: "Conexión con Blue Express" }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: styles$6.formDescription, children: "Completa la siguiente información para conectar tu tienda con Blue Express y disfrutar de todas las funcionalidades de envío." }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("form", { onSubmit: handleSubmit(onSubmit), className: styles$6.form, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$6.rowControlsItem, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("label", { className: styles$6.rowControlsItemLabel, children: "ID de integración" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: styles$6.helperText, children: "Ingresa el ID de integración que obtuviste al pasar por el recomendador en el portal Ecommerce de Blue Express" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "input",
          {
            type: "text",
            placeholder: "ID de integración",
            ...register("storeId"),
            className: styles$6.storeIdInput
          }
        )
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
        error2 && /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$6.errorText, children: renderText(error2) }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$6.subTitle, children: [
          "Credenciales de Woocommerce",
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$6.tooltip, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$6.tooltipIcon, children: "?" }),
            /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { className: styles$6.tooltipText, children: [
              "Credenciales obligatorias para la integración de Woocommerce. Se obtienen en el panel de administración de woocommerce en la sección de Ajustes → Avanzado → API REST → Añadir clave.",
              /* @__PURE__ */ jsxRuntimeExports.jsx("br", {}),
              "Clave del cliente inicia con “ck_“",
              /* @__PURE__ */ jsxRuntimeExports.jsx("br", {}),
              "Clave secreta del cliente inicia con “cs_“"
            ] })
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$6.rowControls, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$6.rowControlsItem, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("label", { className: styles$6.rowControlsItemLabel, children: "Clave del cliente" }),
            /* @__PURE__ */ jsxRuntimeExports.jsx(
              "input",
              {
                type: "text",
                placeholder: "Ingrese la clave del cliente",
                ...register("clientKey"),
                className: styles$6.input
              }
            )
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$6.rowControlsItem, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("label", { className: styles$6.rowControlsItemLabel, children: "Clave secreta de cliente" }),
            /* @__PURE__ */ jsxRuntimeExports.jsx(
              "input",
              {
                type: "text",
                placeholder: "Ingrese la clave secreta del cliente",
                ...register("clientSecret"),
                className: styles$6.input
              }
            )
          ] })
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("button", { type: "submit", disabled: isSubmitting, className: styles$6.button, children: storeId && isActiveIntegration ? "Actualizar integración" : "Crear integración" })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("p", { className: styles$6.createAccountText, children: [
      "¿No tienes un ID de integración?",
      " ",
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "a",
        {
          href: "https://ecommerce.blue.cl",
          className: styles$6.link,
          target: "_blank",
          rel: "noopener noreferrer",
          children: "Crea tu cuenta aquí"
        }
      )
    ] })
  ] });
};
const modalOverlay = "_modalOverlay_x9myy_1";
const modalContent$1 = "_modalContent_x9myy_14";
const warningBox$1 = "_warningBox_x9myy_31";
const formFields = "_formFields_x9myy_41";
const fieldGroup = "_fieldGroup_x9myy_48";
const buttonGroup = "_buttonGroup_x9myy_73";
const button = "_button_x9myy_73";
const primaryButton = "_primaryButton_x9myy_89";
const secondaryButton = "_secondaryButton_x9myy_103";
const styles$5 = {
  modalOverlay,
  modalContent: modalContent$1,
  warningBox: warningBox$1,
  formFields,
  fieldGroup,
  buttonGroup,
  button,
  primaryButton,
  secondaryButton
};
const DeveloperToolsForm = ({
  open,
  onClose,
  saveSettings: saveSettings2,
  validateIntegration,
  ...props
}) => {
  var _a, _b, _c;
  const [loading, setLoading] = reactExports.useState(false);
  const [url, setUrl] = reactExports.useState((_a = props.settings) == null ? void 0 : _a.alternativeBasePath);
  const [bxKey, setBxKey] = reactExports.useState((_b = props.settings) == null ? void 0 : _b.tracking_bxkey);
  const [isEnabled, setIsEnabled] = reactExports.useState(
    ((_c = props.settings) == null ? void 0 : _c.devOptions) === "yes"
  );
  const handleSave = async () => {
    setLoading(true);
    try {
      await saveSettings2({
        devOptions: isEnabled ? "yes" : "no",
        alternativeBasePath: url,
        tracking_bxkey: bxKey
      });
      await validateIntegration();
    } catch (error2) {
      console.error(error2);
    } finally {
      setLoading(false);
      onClose();
    }
  };
  if (!open) return null;
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$5.modalOverlay, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$5.modalContent, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("h2", { children: "Herramientas de desarrollo" }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$5.warningBox, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("strong", { children: "Advertencia:" }),
      " No modifique estas configuraciones a menos que tenga un conocimiento claro de lo que está haciendo. Una mala configuración puede provocar que su plugin deje de funcionar."
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$5.formFields, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$5.fieldGroup, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("label", { htmlFor: "dev-enabled-checkbox", children: "Habilitar opciones de desarrollo" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "input",
          {
            id: "dev-enabled-checkbox",
            type: "checkbox",
            checked: isEnabled,
            onChange: (e) => setIsEnabled(e.target.checked)
          }
        )
      ] }),
      isEnabled && /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$5.fieldGroup, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("label", { htmlFor: "alternative-url-input", children: "URL alternativa" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "input",
            {
              id: "alternative-url-input",
              type: "text",
              value: url,
              onChange: (e) => setUrl(e.target.value)
            }
          )
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$5.fieldGroup, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("label", { htmlFor: "tracking-key-input", children: "Tracking BX key" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "input",
            {
              id: "tracking-key-input",
              type: "text",
              value: bxKey,
              onChange: (e) => setBxKey(e.target.value)
            }
          )
        ] })
      ] })
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$5.buttonGroup, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          type: "button",
          onClick: onClose,
          className: `${styles$5.button} ${styles$5.secondaryButton}`,
          children: "Cancelar"
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          type: "button",
          disabled: loading,
          onClick: handleSave,
          className: `${styles$5.button} ${styles$5.primaryButton}`,
          children: loading ? "Guardando..." : "Guardar"
        }
      )
    ] })
  ] }) });
};
const logsContainer = "_logsContainer_171sx_1";
const backButton = "_backButton_171sx_10";
const logsTable = "_logsTable_171sx_22";
const tableRow = "_tableRow_171sx_42";
const selected = "_selected_171sx_51";
const logType = "_logType_171sx_55";
const error = "_error_171sx_62";
const info = "_info_171sx_67";
const logDetail = "_logDetail_171sx_72";
const pagination = "_pagination_171sx_104";
const logsDisabledContainer = "_logsDisabledContainer_171sx_135";
const logsDisabledMessage = "_logsDisabledMessage_171sx_145";
const styles$4 = {
  logsContainer,
  backButton,
  logsTable,
  tableRow,
  selected,
  logType,
  error,
  info,
  logDetail,
  pagination,
  logsDisabledContainer,
  logsDisabledMessage
};
const BASE_URL = "/wp-json/wc-bluex/v1";
const defaultHeaders = {
  "Content-Type": "application/json"
};
class ApiError extends Error {
  constructor(message2, status2, data) {
    super(message2);
    this.status = status2;
    this.data = data;
    this.name = "ApiError";
  }
}
const fetchWrapper = async (endpoint, options = {}) => {
  const url = `${BASE_URL}${endpoint}`;
  const fetchOptions = {
    ...options,
    headers: {
      ...defaultHeaders,
      ...options.headers
    }
  };
  try {
    const response = await fetch(url, fetchOptions);
    const data = await response.json();
    if (!response.ok) {
      throw new ApiError(
        data.message || "An error occurred",
        response.status,
        data
      );
    }
    return data;
  } catch (error2) {
    if (error2 instanceof ApiError) {
      throw error2;
    }
    throw new ApiError(
      "Network error or invalid JSON response",
      500,
      { originalError: error2.message }
    );
  }
};
const http = {
  get: (endpoint, options = {}) => fetchWrapper(endpoint, { ...options, method: "GET" }),
  post: (endpoint, data, options = {}) => fetchWrapper(endpoint, {
    ...options,
    method: "POST",
    body: JSON.stringify(data)
  }),
  delete: (endpoint, options = {}) => fetchWrapper(endpoint, { ...options, method: "DELETE" })
};
const blueExpressService = {
  /**
   * Test the integration with Blue Express
   * @param {Object} data - Integration test data
   * @returns {Promise} - Test results
   */
  testIntegration: (data) => {
    return http.post("/test-integration", data);
  },
  /**
   * Validate the integration status
   * @returns {Promise} - Integration status
   */
  validateIntegration: () => {
    return http.get("/validate-integration");
  },
  /**
   * Update integration credentials
   * @param {Object} credentials - New credentials
   * @returns {Promise} - Update result
   */
  updateCredentials: (credentials) => {
    return http.post("/update-credentials", credentials);
  },
  /**
   * Save integration settings
   * @param {Object} settings - Settings to save
   * @returns {Promise} - Save result
   */
  saveSettings: (settings) => {
    return http.post("/save-settings", settings);
  },
  /**
   * Get current integration settings
   * @returns {Promise} - Current settings
   */
  getSettings: () => {
    return http.get("/get-settings");
  },
  /**
   * Save developer settings
   * @param {Object} devSettings - Developer settings to save
   * @returns {Promise} - Save result
   */
  saveDevSettings: (devSettings) => {
    return http.post("/save-dev-settings", devSettings);
  },
  /**
   * Empty the autofill database
   * @returns {Promise} - Operation result
   */
  emptyAutofillDb: () => {
    return http.post("/empty-autofill-db");
  },
  /**
   * Get logs with optional filtering
   * @param {Object} params - Query parameters
   * @param {number} [params.page=1] - Page number
   * @param {number} [params.per_page=10] - Items per page
   * @param {string} [params.type] - Log type filter
   * @param {string} [params.start_date] - Start date filter (YYYY-MM-DD)
   * @param {string} [params.end_date] - End date filter (YYYY-MM-DD)
   * @returns {Promise} - Logs data
   */
  getLogs: (params = {}) => {
    const queryParams = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
      if (value !== void 0 && value !== null && value !== "") {
        queryParams.append(key, value);
      }
    });
    const queryString = queryParams.toString();
    return http.get(`/get-logs${queryString ? `?${queryString}` : ""}`);
  },
  /**
   * Delete all logs
   * @returns {Promise} - Operation result
   */
  deleteLogs: () => {
    return http.delete("/delete-logs");
  }
};
const Logs = ({ settings, setActiveSection }) => {
  const [logs, setLogs] = reactExports.useState([]);
  const [currentPage, setCurrentPage] = reactExports.useState(1);
  const [totalPages, setTotalPages] = reactExports.useState(1);
  const [selectedLog, setSelectedLog] = reactExports.useState(null);
  const [loading, setLoading] = reactExports.useState(false);
  const [deleting, setDeleting] = reactExports.useState(false);
  const logsEnabled = (settings == null ? void 0 : settings.active_logs) === "yes";
  reactExports.useEffect(() => {
    if (logsEnabled) {
      fetchLogs(currentPage);
    }
  }, [currentPage, logsEnabled]);
  const fetchLogs = async (page) => {
    setLoading(true);
    try {
      const response = await blueExpressService.getLogs({ page });
      setLogs(response.items);
      setTotalPages(response.total_pages);
    } catch (error2) {
      console.error("Error fetching logs:", error2);
    } finally {
      setLoading(false);
    }
  };
  const handleLogClick = (log) => {
    setSelectedLog((selectedLog == null ? void 0 : selectedLog.id) === log.id ? null : log);
  };
  const handleGoToConfig = (e) => {
    e.preventDefault();
    setActiveSection("configuracion");
  };
  const handleDeleteLogs = async () => {
    if (window.confirm(
      "¿Estás seguro de que deseas eliminar todos los logs? Esta acción no se puede deshacer."
    )) {
      setDeleting(true);
      try {
        await blueExpressService.deleteLogs();
        setLogs([]);
        setTotalPages(1);
        setCurrentPage(1);
        setSelectedLog(null);
        alert("Logs eliminados correctamente.");
      } catch (error2) {
        console.error("Error deleting logs:", error2);
        alert("Error al eliminar los logs.");
      } finally {
        setDeleting(false);
      }
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$4.logsContainer, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$4.headerControls, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          type: "button",
          className: styles$4.backButton,
          onClick: () => setActiveSection("configuracion"),
          children: "← Volver"
        }
      ),
      logsEnabled && logs.length > 0 && /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          type: "button",
          className: styles$4.deleteButton,
          onClick: handleDeleteLogs,
          disabled: deleting,
          style: {
            backgroundColor: "#dc3545",
            color: "white",
            border: "none",
            padding: "8px 16px",
            borderRadius: "4px",
            cursor: deleting ? "not-allowed" : "pointer",
            marginLeft: "auto"
          },
          children: deleting ? "Eliminando..." : "Borrar Logs"
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("h2", { children: "Logs del Sistema" }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("p", { children: "Visualiza registros del funcionamiento del plugin. Uso exclusivo para soporte y monitoreo. No realices cambios sin la asesoría de Blue." }),
    !logsEnabled ? /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$4.logsDisabledContainer, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("p", { className: styles$4.logsDisabledMessage, children: [
      'Para ver los logs, por favor activa la opción "Habilitar logs" en la sección de',
      " ",
      /* @__PURE__ */ jsxRuntimeExports.jsx("a", { href: "#", onClick: handleGoToConfig, children: "Configuración" }),
      "."
    ] }) }) : loading ? /* @__PURE__ */ jsxRuntimeExports.jsx("p", { children: "Cargando logs..." }) : /* @__PURE__ */ jsxRuntimeExports.jsxs(jsxRuntimeExports.Fragment, { children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("table", { className: styles$4.logsTable, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("thead", { children: /* @__PURE__ */ jsxRuntimeExports.jsxs("tr", { children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("th", { children: "Fecha" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("th", { children: "Tipo" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("th", { children: "Mensaje" })
        ] }) }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("tbody", { children: logs.map((log) => /* @__PURE__ */ jsxRuntimeExports.jsxs(
          "tr",
          {
            onClick: () => handleLogClick(log),
            className: `${styles$4.tableRow} ${(selectedLog == null ? void 0 : selectedLog.id) === log.id ? styles$4.selected : ""}`,
            children: [
              /* @__PURE__ */ jsxRuntimeExports.jsx("td", { children: new Date(log.log_timestamp).toLocaleString() }),
              /* @__PURE__ */ jsxRuntimeExports.jsx("td", { children: /* @__PURE__ */ jsxRuntimeExports.jsx(
                "span",
                {
                  className: `${styles$4.logType} ${styles$4[log.log_type]}`,
                  children: log.log_type
                }
              ) }),
              /* @__PURE__ */ jsxRuntimeExports.jsxs("td", { children: [
                log.log_body.substring(0, 100),
                "..."
              ] })
            ]
          },
          log.id
        )) })
      ] }),
      selectedLog && /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$4.logDetail, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("h3", { children: "Detalle del Log" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("pre", { children: /* @__PURE__ */ jsxRuntimeExports.jsx("code", { children: selectedLog.log_body }) })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$4.pagination, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "button",
          {
            onClick: () => setCurrentPage((prev) => Math.max(prev - 1, 1)),
            disabled: currentPage === 1,
            type: "button",
            children: "Anterior"
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { children: [
          "Página ",
          currentPage,
          " de ",
          totalPages
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "button",
          {
            onClick: () => setCurrentPage((prev) => Math.min(prev + 1, totalPages)),
            disabled: currentPage === totalPages,
            type: "button",
            children: "Siguiente"
          }
        )
      ] })
    ] })
  ] });
};
const sidebar = "_sidebar_h80jo_1";
const logo = "_logo_h80jo_13";
const logo__image = "_logo__image_h80jo_20";
const menu = "_menu_h80jo_25";
const menu__item = "_menu__item_h80jo_32";
const menu__item_active = "_menu__item_active_h80jo_49";
const styles$3 = {
  sidebar,
  logo,
  logo__image,
  menu,
  menu__item,
  menu__item_active
};
const Sidebar = ({ activeSection, setActiveSection }) => {
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$3.sidebar, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$3.logo, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
      "img",
      {
        src: "/wp-content/plugins/bluex-for-woocommerce/assets/images/blueexpress.webp",
        alt: "Blue Express",
        className: styles$3.logo__image
      }
    ) }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("nav", { className: styles$3.menu, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          className: `${styles$3.menu__item} ${activeSection === "inicio" ? styles$3.menu__item_active : ""}`,
          onClick: () => setActiveSection("inicio"),
          type: "button",
          children: "Resumen"
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          className: `${styles$3.menu__item} ${activeSection === "configuracion" ? styles$3.menu__item_active : ""}`,
          onClick: () => setActiveSection("configuracion"),
          type: "button",
          children: "Configuración"
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          className: `${styles$3.menu__item} ${activeSection === "zonas-envio" ? styles$3.menu__item_active : ""}`,
          onClick: () => setActiveSection("zonas-envio"),
          type: "button",
          children: "Zonas de Envío"
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          className: `${styles$3.menu__item} ${activeSection === "conexion" ? styles$3.menu__item_active : ""}`,
          onClick: () => setActiveSection("conexion"),
          type: "button",
          children: "Conexión"
        }
      )
    ] })
  ] });
};
const Sidebar$1 = reactExports.memo(Sidebar);
const home = "_home_15mjt_1";
const hero = "_hero_15mjt_6";
const hero__image = "_hero__image_15mjt_20";
const description = "_description_15mjt_25";
const highlight = "_highlight_15mjt_32";
const cards = "_cards_15mjt_37";
const card = "_card_15mjt_37";
const status = "_status_15mjt_58";
const statusContainer = "_statusContainer_15mjt_65";
const statusSuccess = "_statusSuccess_15mjt_72";
const statusError = "_statusError_15mjt_73";
const statusIcon = "_statusIcon_15mjt_88";
const connectButton = "_connectButton_15mjt_93";
const configSummary = "_configSummary_15mjt_108";
const configList = "_configList_15mjt_112";
const helpText = "_helpText_15mjt_122";
const helpLink = "_helpLink_15mjt_129";
const styles$2 = {
  home,
  hero,
  hero__image,
  description,
  highlight,
  cards,
  card,
  status,
  statusContainer,
  statusSuccess,
  statusError,
  statusIcon,
  connectButton,
  configSummary,
  configList,
  helpText,
  helpLink
};
const getComunaForCode = (codeSelected) => {
  const district = comunas.flatMap(
    ({ ciudades }) => ciudades.flatMap(({ districts }) => districts)
  ).find((district2) => district2.code === codeSelected);
  return district ? district.name : "No configurado";
};
const Home = ({
  connectionStatus = false,
  config = null,
  setActiveSection,
  optionsEmissionOs = []
}) => {
  const statusLabel2 = reactExports.useMemo(() => {
    if (!(config == null ? void 0 : config.noBlueStatus)) return "No configurado";
    const option2 = optionsEmissionOs.find((opt) => opt.value === config.noBlueStatus);
    return option2 ? option2.label : config.noBlueStatus;
  }, [config == null ? void 0 : config.noBlueStatus, optionsEmissionOs]);
  const comunaName = reactExports.useMemo(
    () => getComunaForCode(config == null ? void 0 : config.districtCode),
    [config == null ? void 0 : config.districtCode]
  );
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$2.home, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$2.hero, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("h1", { children: "Bienvenido a Blue Express" }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "img",
        {
          src: "/wp-content/plugins/bluex-for-woocommerce/assets/images/blueexpress.webp",
          alt: "Blue Express",
          className: styles$2.hero__image
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: styles$2.description, children: "Primero realiza las configuraciones, luego conecta tu tienda y entonces podrás realizar el envío de tus pedidos con Blue Express" }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$2.cards, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$2.card, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("h3", { children: "Resumen de la configuración" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$2.configSummary, children: config ? /* @__PURE__ */ jsxRuntimeExports.jsxs("ul", { className: styles$2.configList, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("li", { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("strong", { children: "Comuna de origen:" }),
            " ",
            comunaName
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("li", { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("strong", { children: "Estado para crear orden en Ecommerce Blue Express:" }),
            " ",
            statusLabel2
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("li", { children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("strong", { children: "¿Puntos de retiro Blue Express?:" }),
            " ",
            config.pudoEnable === "yes" ? "Sí" : "No"
          ] })
        ] }) : /* @__PURE__ */ jsxRuntimeExports.jsx("p", { children: "No hay configuración disponible" }) })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$2.card, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("h3", { children: "Estado de la conexión" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$2.status, children: connectionStatus ? /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$2.statusSuccess, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$2.statusIcon, children: "✓" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: "Conectado" })
        ] }) : /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$2.statusContainer, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$2.statusError, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$2.statusIcon, children: "✕" }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { children: "Desconectado" })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            "button",
            {
              className: styles$2.connectButton,
              onClick: () => setActiveSection("conexion"),
              children: "Ir a Conexión"
            }
          )
        ] }) })
      ] })
    ] }),
    !connectionStatus && /* @__PURE__ */ jsxRuntimeExports.jsxs("p", { className: styles$2.helpText, children: [
      "¿Necesitas ayuda con tu integración? ",
      /* @__PURE__ */ jsxRuntimeExports.jsx("a", { href: "https://app.puente.xyz/public/243/", className: styles$2.helpLink, target: "_blank", rel: "noopener noreferrer", children: "Agenda una integración asistida" })
    ] })
  ] });
};
const container = "_container_urh6r_1";
const header = "_header_urh6r_7";
const title = "_title_urh6r_11";
const subtitle = "_subtitle_urh6r_18";
const statusPanel = "_statusPanel_urh6r_24";
const statusGrid = "_statusGrid_urh6r_32";
const statusCard = "_statusCard_urh6r_39";
const statusLabel = "_statusLabel_urh6r_46";
const statusValue = "_statusValue_urh6r_53";
const warningBadge = "_warningBadge_urh6r_60";
const refreshButton = "_refreshButton_urh6r_71";
const warningMessage = "_warningMessage_urh6r_92";
const infoMessage = "_infoMessage_urh6r_103";
const form = "_form_urh6r_114";
const section = "_section_urh6r_121";
const sectionTitle = "_sectionTitle_urh6r_133";
const formRow = "_formRow_urh6r_140";
const formGroup = "_formGroup_urh6r_147";
const formHint = "_formHint_urh6r_153";
const regionSelector = "_regionSelector_urh6r_159";
const regionActions = "_regionActions_urh6r_163";
const btnSmall = "_btnSmall_urh6r_169";
const regionGrid = "_regionGrid_urh6r_185";
const regionItem = "_regionItem_urh6r_197";
const methodsGrid = "_methodsGrid_urh6r_204";
const methodCard = "_methodCard_urh6r_210";
const methodDesc = "_methodDesc_urh6r_218";
const optionsGrid = "_optionsGrid_urh6r_226";
const resultPanel = "_resultPanel_urh6r_232";
const summaryGrid = "_summaryGrid_urh6r_240";
const summaryItem = "_summaryItem_urh6r_247";
const summaryLabel = "_summaryLabel_urh6r_254";
const summaryValue = "_summaryValue_urh6r_261";
const warningBox = "_warningBox_urh6r_268";
const detailsBox = "_detailsBox_urh6r_281";
const detailsList = "_detailsList_urh6r_289";
const detailItem = "_detailItem_urh6r_295";
const detailIcon = "_detailIcon_urh6r_307";
const detailText = "_detailText_urh6r_312";
const linkBox = "_linkBox_urh6r_317";
const linkButton = "_linkButton_urh6r_322";
const actions = "_actions_urh6r_339";
const btnPrimary = "_btnPrimary_urh6r_348";
const btnSecondary = "_btnSecondary_urh6r_372";
const modal = "_modal_urh6r_395";
const modalContent = "_modalContent_urh6r_408";
const modalActions = "_modalActions_urh6r_427";
const styles$1 = {
  container,
  header,
  title,
  subtitle,
  statusPanel,
  statusGrid,
  statusCard,
  statusLabel,
  statusValue,
  warningBadge,
  refreshButton,
  warningMessage,
  infoMessage,
  form,
  section,
  sectionTitle,
  formRow,
  formGroup,
  formHint,
  regionSelector,
  regionActions,
  btnSmall,
  regionGrid,
  regionItem,
  methodsGrid,
  methodCard,
  methodDesc,
  optionsGrid,
  resultPanel,
  summaryGrid,
  summaryItem,
  summaryLabel,
  summaryValue,
  warningBox,
  detailsBox,
  detailsList,
  detailItem,
  detailIcon,
  detailText,
  linkBox,
  linkButton,
  actions,
  btnPrimary,
  btnSecondary,
  modal,
  modalContent,
  modalActions
};
const select__container = "_select__container_1opku_1";
const select = "_select_1opku_1";
const styles = {
  select__container,
  select
};
const Select = ({
  register,
  name,
  placeholder,
  options = [],
  disabled = false,
  defaultValue = "",
  value,
  onChange
}) => {
  const selectProps = register ? register(name) : { value, onChange };
  return /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles.select__container, children: /* @__PURE__ */ jsxRuntimeExports.jsxs(
    "select",
    {
      ...selectProps,
      disabled,
      defaultValue,
      value: register ? void 0 : value,
      className: styles.select,
      children: [
        placeholder && /* @__PURE__ */ jsxRuntimeExports.jsx("option", { value: "", disabled: true, children: placeholder }),
        options.map((option2) => /* @__PURE__ */ jsxRuntimeExports.jsx("option", { value: option2.value, children: option2.label }, option2.value))
      ]
    }
  ) });
};
function ShippingZones() {
  var _a, _b, _c, _d, _e, _f;
  const { register, handleSubmit, setValue, getValues } = useForm({
    defaultValues: {
      strategy: "by_region",
      mode: "create_new",
      methods: ["bluex-ex"],
      regions: [],
      dry_run: false,
      backup_existing: false,
      exclude_islands: true
    }
  });
  const [toast2, setToast] = reactExports.useState(null);
  const [loading, setLoading] = reactExports.useState(false);
  const [statusData, setStatusData] = reactExports.useState(null);
  const [lastResult, setLastResult] = reactExports.useState(null);
  const [showConfirmDialog, setShowConfirmDialog] = reactExports.useState(false);
  const [pendingAction, setPendingAction] = reactExports.useState(null);
  reactExports.useEffect(() => {
    loadStatus();
  }, []);
  const loadStatus = async () => {
    try {
      const data = await shippingZonesStatus();
      setStatusData(data);
    } catch (error2) {
      console.error("Error loading status:", error2);
      setToast({
        message: "Error al cargar el estado de las zonas: " + error2.message,
        type: "error"
      });
    }
  };
  const availableMethods = [
    { id: "bluex-ex", name: "Express", description: "Entrega rápida y segura" },
    { id: "bluex-py", name: "Priority", description: "Tiempos optimizados" },
    { id: "bluex-md", name: "SameDay", description: "Entrega el mismo día" }
  ];
  const modes = [
    { value: "create_new", label: "Crear nuevas zonas" },
    { value: "add_to_existing", label: "Agregar a zonas existentes" },
    { value: "replace_existing", label: "Editar zonas existentes" }
  ];
  const chileanRegions = (statusData == null ? void 0 : statusData.chilean_regions) || {
    "CL-AP": "Arica y Parinacota",
    "CL-TA": "Tarapacá",
    "CL-AN": "Antofagasta",
    "CL-AT": "Atacama",
    "CL-CO": "Coquimbo",
    "CL-VS": "Valparaíso",
    "CL-RM": "Región Metropolitana",
    "CL-LI": "O'Higgins",
    "CL-ML": "Maule",
    "CL-NB": "Ñuble",
    "CL-BI": "Biobío",
    "CL-AR": "La Araucanía",
    "CL-LR": "Los Ríos",
    "CL-LL": "Los Lagos",
    "CL-AI": "Aysén",
    "CL-MA": "Magallanes"
  };
  const handleSimulate = async (data) => {
    executeZoneCreation({ ...data, dry_run: true });
  };
  const handleApply = async (data) => {
    if (data.mode === "create_new" && (statusData == null ? void 0 : statusData.zones_with_bluex) > 0) {
      setShowConfirmDialog(true);
      setPendingAction(() => () => executeZoneCreation({ ...data, dry_run: false }));
    } else {
      executeZoneCreation({ ...data, dry_run: false });
    }
  };
  const executeZoneCreation = async (formData) => {
    try {
      setLoading(true);
      setShowConfirmDialog(false);
      const currentValues = getValues();
      console.log("Form Data:", formData);
      console.log("Current Values:", currentValues);
      console.log("Selected Methods:", currentValues.methods);
      console.log("Selected Regions:", currentValues.regions);
      const params = {
        strategy: "by_region",
        mode: formData.mode,
        methods: Array.isArray(currentValues.methods) ? currentValues.methods : [],
        dry_run: formData.dry_run,
        backup_existing: false,
        // Forzar false
        exclude_islands: formData.exclude_islands,
        vat: "19%"
        // IVA fijo según ley chilena
      };
      if (Array.isArray(currentValues.regions) && currentValues.regions.length > 0) {
        params.regions = currentValues.regions;
      }
      console.log("Final params:", params);
      const result = await shippingZonesCreate(params);
      setLastResult(result);
      const isDryRun = formData.dry_run;
      const summary = result.summary || {};
      let message2 = isDryRun ? "Simulación completada: " : "Operación completada: ";
      const parts = [];
      if (summary.zones_created > 0) parts.push(`${summary.zones_created} zona(s) ${isDryRun ? "a crear" : "creada(s)"}`);
      if (summary.zones_updated > 0) parts.push(`${summary.zones_updated} zona(s) ${isDryRun ? "a actualizar" : "actualizada(s)"}`);
      if (summary.zones_skipped > 0) parts.push(`${summary.zones_skipped} zona(s) omitida(s)`);
      if (summary.methods_added > 0) parts.push(`${summary.methods_added} método(s) ${isDryRun ? "a agregar" : "agregado(s)"}`);
      message2 += parts.join(", ");
      setToast({
        message: message2,
        type: summary.errors_count > 0 ? "warning" : "success"
      });
      await loadStatus();
    } catch (error2) {
      setToast({
        message: "Error: " + error2.message,
        type: "error"
      });
    } finally {
      setLoading(false);
    }
  };
  const toggleAllRegions = (select2) => {
    if (select2) {
      setValue("regions", Object.keys(chileanRegions));
    } else {
      setValue("regions", []);
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.container, children: [
    toast2 && /* @__PURE__ */ jsxRuntimeExports.jsx(
      Toast,
      {
        message: toast2.message,
        type: toast2.type,
        onClose: () => setToast(null)
      }
    ),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.header, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("h2", { className: styles$1.title, children: "Automatización de Zonas de Envío Blue Express" }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("p", { className: styles$1.subtitle, children: "Configure automáticamente las zonas de envío para los métodos Blue Express" })
    ] }),
    statusData && /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.statusPanel, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("h3", { className: styles$1.sectionTitle, children: "Estado Actual" }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.statusGrid, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.statusCard, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.statusLabel, children: "Zonas totales:" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.statusValue, children: statusData.total_zones })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.statusCard, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.statusLabel, children: "Zonas con Blue Express:" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.statusValue, children: statusData.zones_with_bluex })
        ] }),
        statusData.bluex_methods_count && Object.keys(statusData.bluex_methods_count).length > 0 && /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.statusCard, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.statusLabel, children: "Métodos configurados:" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.statusValue, children: Object.entries(statusData.bluex_methods_count).map(([method, count]) => {
            var _a2;
            const methodName = ((_a2 = availableMethods.find((m) => m.id === method)) == null ? void 0 : _a2.name) || method;
            return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { children: [
              methodName,
              ": ",
              count
            ] }, method);
          }) })
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        "button",
        {
          type: "button",
          onClick: loadStatus,
          className: styles$1.refreshButton,
          disabled: loading,
          children: "🔄 Actualizar estado"
        }
      )
    ] }),
    /* @__PURE__ */ jsxRuntimeExports.jsxs("form", { className: styles$1.form, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.section, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("h3", { className: styles$1.sectionTitle, children: "Configuración de Zonas" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$1.formRow, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.formGroup, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(Label, { children: "Modo de Operación" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            Select,
            {
              register,
              name: "mode",
              options: modes
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx("small", { className: styles$1.formHint, children: "Define cómo manejar zonas existentes" })
        ] }) }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.regionSelector, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(Label, { children: "Regiones a Incluir" }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.regionActions, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("button", { type: "button", onClick: () => toggleAllRegions(true), className: styles$1.btnSmall, children: "Seleccionar todas" }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("button", { type: "button", onClick: () => toggleAllRegions(false), className: styles$1.btnSmall, children: "Limpiar selección" })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$1.regionGrid, children: Object.entries(chileanRegions).map(([code, name]) => /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$1.regionItem, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
            Checkbox,
            {
              register,
              name: "regions",
              value: code,
              label: `${name} (${code})`
            }
          ) }, code)) }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("small", { className: styles$1.formHint, children: "Deja vacío para incluir todas las regiones" })
        ] })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.section, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx("h3", { className: styles$1.sectionTitle, children: "Métodos de Envío" }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$1.methodsGrid, children: [availableMethods[0]].map((method) => /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.methodCard, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx(
            Checkbox,
            {
              register,
              name: "methods",
              value: method.id,
              label: method.name
            }
          ),
          /* @__PURE__ */ jsxRuntimeExports.jsx("small", { className: styles$1.methodDesc, children: method.description })
        ] }, method.id)) })
      ] }),
      lastResult && /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.resultPanel, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsxs("h3", { className: styles$1.sectionTitle, children: [
          ((_a = lastResult.summary) == null ? void 0 : _a.zones_created) > 0 || ((_b = lastResult.summary) == null ? void 0 : _b.zones_updated) > 0 ? "✅" : "ℹ️",
          " ",
          "Resultado de la Operación"
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.summaryGrid, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.summaryItem, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.summaryLabel, children: "Zonas creadas:" }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.summaryValue, children: ((_c = lastResult.summary) == null ? void 0 : _c.zones_created) || 0 })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.summaryItem, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.summaryLabel, children: "Zonas actualizadas:" }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.summaryValue, children: ((_d = lastResult.summary) == null ? void 0 : _d.zones_updated) || 0 })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.summaryItem, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.summaryLabel, children: "Zonas omitidas:" }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.summaryValue, children: ((_e = lastResult.summary) == null ? void 0 : _e.zones_skipped) || 0 })
          ] }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.summaryItem, children: [
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.summaryLabel, children: "Métodos agregados:" }),
            /* @__PURE__ */ jsxRuntimeExports.jsx("span", { className: styles$1.summaryValue, children: ((_f = lastResult.summary) == null ? void 0 : _f.methods_added) || 0 })
          ] })
        ] }),
        lastResult.duplicates && lastResult.duplicates.length > 0 && /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.warningBox, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("strong", { children: "⚠️ Zonas duplicadas encontradas:" }),
          /* @__PURE__ */ jsxRuntimeExports.jsx("ul", { children: lastResult.duplicates.map((dup, idx) => /* @__PURE__ */ jsxRuntimeExports.jsx("li", { children: dup }, idx)) })
        ] }),
        lastResult.details && lastResult.details.length > 0 && /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.detailsBox, children: [
          /* @__PURE__ */ jsxRuntimeExports.jsx("strong", { children: "Detalles:" }),
          /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.detailsList, children: [
            lastResult.details.slice(0, 10).map((detail, idx) => /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.detailItem, children: [
              /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { className: styles$1.detailIcon, children: [
                detail.status === "created" && "✅",
                detail.status === "updated" && "🔄",
                detail.status === "skipped" && "⏭️",
                detail.status === "simulated" && "🎭"
              ] }),
              /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { className: styles$1.detailText, children: [
                detail.zone_name || detail.region_name || detail.commune_name,
                detail.reason && ` - ${detail.reason}`,
                (detail.fee_set || detail.fee_updated) && " - 💰 IVA actualizado"
              ] })
            ] }, idx)),
            lastResult.details.length > 10 && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$1.detailItem, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("span", { className: styles$1.detailText, children: [
              "...y ",
              lastResult.details.length - 10,
              " más"
            ] }) })
          ] })
        ] }),
        /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$1.linkBox, children: /* @__PURE__ */ jsxRuntimeExports.jsx(
          "a",
          {
            href: "/wp-admin/admin.php?page=wc-settings&tab=shipping",
            target: "_blank",
            rel: "noopener noreferrer",
            className: styles$1.linkButton,
            children: "📦 Ver Zonas de Envío en WooCommerce"
          }
        ) })
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.actions, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "button",
          {
            type: "button",
            onClick: handleSubmit(handleSimulate),
            className: styles$1.btnSecondary,
            disabled: loading,
            children: loading ? "⏳ Simulando..." : "🎭 Simular Cambios"
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "button",
          {
            type: "button",
            onClick: handleSubmit(handleApply),
            className: styles$1.btnPrimary,
            disabled: loading,
            children: loading ? "⏳ Aplicando..." : "🚀 Aplicar Cambios"
          }
        )
      ] })
    ] }),
    showConfirmDialog && /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$1.modal, children: /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.modalContent, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx("h3", { children: "⚠️ Confirmar Creación de Zonas" }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("p", { children: [
        "Ya existen ",
        statusData.zones_with_bluex,
        " zona(s) con métodos BlueX. Al crear nuevas zonas con modo “Crear nuevas”, las zonas duplicadas serán omitidas."
      ] }),
      /* @__PURE__ */ jsxRuntimeExports.jsx("p", { children: /* @__PURE__ */ jsxRuntimeExports.jsx("strong", { children: "¿Deseas continuar?" }) }),
      /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$1.modalActions, children: [
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "button",
          {
            type: "button",
            onClick: () => setShowConfirmDialog(false),
            className: styles$1.btnSecondary,
            children: "Cancelar"
          }
        ),
        /* @__PURE__ */ jsxRuntimeExports.jsx(
          "button",
          {
            type: "button",
            onClick: () => {
              if (pendingAction) pendingAction();
            },
            className: styles$1.btnPrimary,
            children: "Sí, continuar"
          }
        )
      ] })
    ] }) })
  ] });
}
const ENABLE_DEVTOOLS = String("false") === "true";
const App = () => {
  const [loading, setLoading] = reactExports.useState(true);
  const [storeId, setStoreId] = reactExports.useState(void 0);
  const [error2, setError] = reactExports.useState(void 0);
  const [settings, setSettings] = reactExports.useState(void 0);
  const [developerToolsOpen, setDeveloperToolsOpen] = reactExports.useState(false);
  const [activeSection, setActiveSection] = reactExports.useState("inicio");
  const [optionsEmissionOs, setOptionsEmissionOs] = reactExports.useState([]);
  const [activeIntegration, setActiveIntegration] = reactExports.useState(false);
  const handleError = (error22) => {
    console.log("handleError", error22);
  };
  const validateIntegration = reactExports.useCallback(async () => {
    setError(void 0);
    setLoading(true);
    try {
      const response = await validateIntegrationStatus();
      console.log("response validateIntegration ", response);
      if (response.storeId) {
        setStoreId(response.storeId);
        if (response.activeIntegration === false) {
          response.message && setError(response.message);
        } else {
          setActiveIntegration(true);
        }
      } else {
        setError(response.message);
      }
      setSettings(response.settings);
      setOptionsEmissionOs(response.optionsEmissionOs || []);
    } catch (error22) {
      handleError(error22);
    } finally {
      setLoading(false);
    }
  }, []);
  reactExports.useEffect(() => {
    validateIntegration();
  }, []);
  const saveSettingsDeveloperTools = reactExports.useCallback(async (settings2) => {
    try {
      await saveDeveloperSettingsService(settings2);
    } catch (error22) {
      console.error(error22);
      alert("Error al guardar las configuraciones de desarrollo");
    }
  }, []);
  const testPricing = reactExports.useCallback(async () => {
    setLoading(true);
    try {
      await testPricingService();
    } catch (error22) {
      console.error(error22);
      alert("Error al probar la obtención de precios");
    } finally {
      setLoading(false);
    }
  }, []);
  const DeveloperToolsMemo = reactExports.useMemo(() => {
    if (!ENABLE_DEVTOOLS) return null;
    return developerToolsOpen ? /* @__PURE__ */ jsxRuntimeExports.jsx(
      DeveloperToolsForm,
      {
        open: developerToolsOpen,
        settings,
        validateIntegration,
        onClose: () => setDeveloperToolsOpen(false),
        saveSettings: saveSettingsDeveloperTools
      }
    ) : null;
  }, [developerToolsOpen, settings]);
  const renderContent = () => {
    switch (activeSection) {
      case "inicio":
        return /* @__PURE__ */ jsxRuntimeExports.jsx(
          Home,
          {
            connectionStatus: activeIntegration,
            config: settings,
            setActiveSection,
            optionsEmissionOs
          }
        );
      case "configuracion":
        return /* @__PURE__ */ jsxRuntimeExports.jsx(
          FormConfig,
          {
            storeId,
            error: error2,
            setLoading,
            settings,
            testPricing,
            optionsEmissionOs,
            setActiveSection,
            setDeveloperToolsOpen,
            OnSaveSettings: validateIntegration
          }
        );
      case "zonas-envio":
        return /* @__PURE__ */ jsxRuntimeExports.jsx(ShippingZones, {});
      case "conexion":
        return /* @__PURE__ */ jsxRuntimeExports.jsx(
          FormNewIntegrate,
          {
            storeId,
            error: error2,
            setLoading,
            validateIntegration,
            isActiveIntegration: activeIntegration
          }
        );
      case "logs":
        return /* @__PURE__ */ jsxRuntimeExports.jsx(Logs, { settings, setActiveSection });
      default:
        return /* @__PURE__ */ jsxRuntimeExports.jsx(
          Home,
          {
            connectionStatus: activeIntegration,
            config: settings,
            setActiveSection,
            optionsEmissionOs
          }
        );
    }
  };
  return /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$e.root, children: [
    /* @__PURE__ */ jsxRuntimeExports.jsxs("div", { className: styles$e.appLayout, children: [
      /* @__PURE__ */ jsxRuntimeExports.jsx(
        Sidebar$1,
        {
          activeSection,
          setActiveSection
        }
      ),
      /* @__PURE__ */ jsxRuntimeExports.jsx("div", { className: styles$e.content, children: renderContent() })
    ] }),
    DeveloperToolsMemo,
    loading && /* @__PURE__ */ jsxRuntimeExports.jsx(Loading, { size: 100 })
  ] });
};
clientExports.createRoot(document.getElementById("integration-react-form")).render(
  /* @__PURE__ */ jsxRuntimeExports.jsx(reactExports.StrictMode, { children: /* @__PURE__ */ jsxRuntimeExports.jsx(App, {}) })
);
