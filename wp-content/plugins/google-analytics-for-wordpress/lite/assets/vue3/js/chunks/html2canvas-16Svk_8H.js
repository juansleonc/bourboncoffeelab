import { bU as getDefaultExportFromCjs } from "../custom-dashboard.js";
import { r as requireHtml2canvas } from "./useAuthGate-Bvb6NIwm.js";
function _mergeNamespaces(n, m) {
  for (var i = 0; i < m.length; i++) {
    const e = m[i];
    if (typeof e !== "string" && !Array.isArray(e)) {
      for (const k in e) {
        if (k !== "default" && !(k in n)) {
          const d = Object.getOwnPropertyDescriptor(e, k);
          if (d) {
            Object.defineProperty(n, k, d.get ? d : {
              enumerable: true,
              get: () => e[k]
            });
          }
        }
      }
    }
  }
  return Object.freeze(Object.defineProperty(n, Symbol.toStringTag, { value: "Module" }));
}
var html2canvasExports = requireHtml2canvas();
const html2canvas = /* @__PURE__ */ getDefaultExportFromCjs(html2canvasExports);
const html2canvas$1 = /* @__PURE__ */ _mergeNamespaces({
  __proto__: null,
  default: html2canvas
}, [html2canvasExports]);
export {
  html2canvas$1 as h
};
