import { bZ as getMiGlobal, j as _export_sfc, h as computed, c as createElementBlock, f as createCommentVNode, a as openBlock, aN as normalizeStyle, n as normalizeClass, b_ as getMonsterInsightsUrl, s as reactive, bW as defineStore, b$ as isNetworkAdmin, c0 as getUrl, c1 as useErrorHandling, e as createBlock, b as createVNode, i as withCtx, T as Transition, l as Teleport, bX as sprintf$1, _ as __$2, c2 as getUpgradeUrl, p as withModifiers, g as createBaseVNode, t as toDisplayString, u as unref, F as Fragment, q as renderList, r as ref, c3 as getSampleData } from "../custom-dashboard.js";
function useIcon() {
  function getIcon(iconPath) {
    if (!iconPath || typeof iconPath !== "string") {
      console.warn("[useIcon] Invalid iconPath:", iconPath);
      return null;
    }
    {
      const assetsUrl = getMiGlobal("assets_url", "");
      if (!assetsUrl) {
        console.warn("[useIcon] assets_url not found in global config");
        return null;
      }
      return `${assetsUrl}/icons/${iconPath}`;
    }
  }
  function getTemplateIcon(templateName) {
    const brand = getMiGlobal("brand", "MonsterInsights").toLowerCase();
    return getIcon(`templates/${brand}/${templateName}.svg`);
  }
  return {
    getIcon,
    getTemplateIcon
  };
}
const _hoisted_1$1 = ["aria-label"];
const _hoisted_2$1 = ["src", "alt", "aria-label"];
const _sfc_main$1 = {
  __name: "Icon",
  props: {
    name: { type: String, required: true },
    size: { type: [Number, String], default: 48 },
    width: { type: [Number, String], default: null },
    height: { type: [Number, String], default: null },
    color: { type: String, default: "currentColor" },
    title: { type: String, default: "" }
  },
  setup(__props) {
    const props = __props;
    const isDashicon = computed(() => props.name.startsWith("dashicons-"));
    const { getIcon } = useIcon();
    const iconUrl = computed(() => {
      if (isDashicon.value) return null;
      if (!props.name) {
        console.warn("[Icon] name prop is required");
        return null;
      }
      const iconPath = props.name.endsWith(".svg") ? props.name : `${props.name}.svg`;
      return getIcon(iconPath);
    });
    const styleVars = computed(() => {
      const width = props.width || props.size;
      const height = props.height || props.size;
      return {
        "--mi-icon-width": typeof width === "number" ? `${width}px` : String(width),
        "--mi-icon-height": typeof height === "number" ? `${height}px` : String(height),
        "--mi-icon-color": props.color
      };
    });
    const dashiconStyles = computed(() => {
      const size = props.width || props.height || props.size;
      const sizeValue = typeof size === "number" ? `${size}px` : String(size);
      return {
        fontSize: sizeValue,
        width: sizeValue,
        height: sizeValue,
        color: props.color,
        lineHeight: sizeValue
      };
    });
    return (_ctx, _cache) => {
      return isDashicon.value ? (openBlock(), createElementBlock("span", {
        key: 0,
        class: normalizeClass(["dashicons", props.name]),
        style: normalizeStyle(dashiconStyles.value),
        role: "img",
        "aria-label": __props.title || void 0
      }, null, 14, _hoisted_1$1)) : iconUrl.value ? (openBlock(), createElementBlock("img", {
        key: 1,
        src: iconUrl.value,
        style: normalizeStyle(styleVars.value),
        class: "mi-icon",
        role: "img",
        alt: __props.title || props.name,
        "aria-label": __props.title || void 0
      }, null, 12, _hoisted_2$1)) : createCommentVNode("", true);
    };
  }
};
const Icon = /* @__PURE__ */ _export_sfc(_sfc_main$1, [["__scopeId", "data-v-2dfff0ed"]]);
const { __: __$1, sprintf } = wp.i18n;
const fetchLicense = () => new Promise((resolve, reject) => {
  const action = "monsterinsights_vue_get_license";
  const ajaxData = {
    nonce: getMiGlobal("nonce")
  };
  wp.ajax.post(action, ajaxData).done((response) => {
    resolve(response);
  }).fail((response) => {
    let message = "";
    const support_url = getMonsterInsightsUrl(
      "admin-notices",
      "error-loading-license",
      "https://www.monsterinsights.com/my-account/support/"
    );
    const title = sprintf(
      // Translators: %1$s: Support Link tag start with URL, %2$s: Support link tag ends.
      __$1(
        "Oops! There was an issue fetching your license details, please try again. If the issue persists, please %1$scontact our support team%2$s.",
        "google-analytics-for-wordpress"
      ),
      `<a target="_blank" href="${support_url}">`,
      `</a>`
    );
    if (response == null ? void 0 : response.error) {
      message = response.error;
    } else if (typeof response === "string" && response.length > 0) {
      message = response;
    } else {
      message = __$1(
        "An unknown error occurred while fetching license.",
        "google-analytics-for-wordpress"
      );
    }
    reject({ title, message, support_url });
  });
});
const verifyLicense = (license_key, isNetwork = false) => {
  return new Promise((resolve, reject) => {
    const action = "monsterinsights_verify_license";
    const ajaxData = {
      nonce: getMiGlobal("nonce"),
      license: license_key,
      network: isNetwork ? true : void 0
    };
    wp.ajax.post(action, ajaxData).done((response) => {
      resolve(response);
    }).fail((response) => {
      let message = "";
      const support_url = getMonsterInsightsUrl(
        "admin-notices",
        "error-verifying-license",
        "https://www.monsterinsights.com/my-account/support/"
      );
      const title = sprintf(
        // Translators: %1$s: Support Link tag start with URL, %2$s: Support link tag ends.
        __$1(
          "Oops! There was an issue verifying your license, please try again. If the issue persists, please %1$scontact our support team%2$s.",
          "google-analytics-for-wordpress"
        ),
        `<a target="_blank" href="${support_url}">`,
        `</a>`
      );
      if (response == null ? void 0 : response.error) {
        message = response.error;
      } else if (typeof response === "string" && response.length > 0) {
        message = response;
      } else {
        message = __$1(
          "An unknown error occurred during license verification.",
          "google-analytics-for-wordpress"
        );
      }
      reject({ title, message, support_url });
    });
  });
};
const validateLicense = (isNetwork = false) => {
  return new Promise((resolve, reject) => {
    const action = "monsterinsights_validate_license";
    const ajaxData = {
      nonce: getMiGlobal("nonce"),
      network: isNetwork ? true : void 0
    };
    wp.ajax.post(action, ajaxData).done((response) => {
      resolve(response);
    }).fail((response) => {
      let message = "";
      const support_url = getMonsterInsightsUrl(
        "admin-notices",
        "error-validating-license",
        "https://www.monsterinsights.com/my-account/support/"
      );
      const title = sprintf(
        // Translators: %1$s: Support Link tag start with URL, %2$s: Support link tag ends.
        __$1(
          "Oops! There was an issue validating your license, please try again. If the issue persists, please %1$scontact our support team%2$s.",
          "google-analytics-for-wordpress"
        ),
        `<a target="_blank" href="${support_url}">`,
        `</a>`
      );
      if (response == null ? void 0 : response.error) {
        message = response.error;
      } else if (typeof response === "string" && response.length > 0) {
        message = response;
      } else {
        message = __$1(
          "An unknown error occurred while validating license.",
          "google-analytics-for-wordpress"
        );
      }
      reject({ title, message, support_url });
    });
  });
};
const deactivateLicense = (license_key, isNetwork = false) => {
  return new Promise((resolve, reject) => {
    const action = "monsterinsights_deactivate_license";
    const ajaxData = {
      nonce: getMiGlobal("nonce"),
      license: license_key,
      network: isNetwork ? true : void 0
    };
    wp.ajax.post(action, ajaxData).done((response) => {
      resolve(response);
    }).fail((response) => {
      let message = "";
      const support_url = getMonsterInsightsUrl(
        "admin-notices",
        "error-deactivating-license",
        "https://www.monsterinsights.com/my-account/support/"
      );
      const title = sprintf(
        // Translators: %1$s: Support Link tag start with URL, %2$s: Support link tag ends.
        __$1(
          "Oops! There was an issue deactivating your license, please try again. If the issue persists, please %1$scontact our support team%2$s.",
          "google-analytics-for-wordpress"
        ),
        `<a target="_blank" href="${support_url}">`,
        `</a>`
      );
      if (response == null ? void 0 : response.error) {
        message = response.error;
      } else if (typeof response === "string" && response.length > 0) {
        message = response;
      } else {
        message = __$1(
          "An unknown error occurred while deactivating license.",
          "google-analytics-for-wordpress"
        );
      }
      reject({ title, message, support_url });
    });
  });
};
const deactivateExpiredLicense = (license_key, isNetwork = false) => {
  return new Promise((resolve, reject) => {
    const action = "monsterinsights_deactivate_expired_license";
    const ajaxData = {
      nonce: getMiGlobal("nonce"),
      license: license_key,
      network: isNetwork ? true : void 0
    };
    wp.ajax.post(action, ajaxData).done((response) => {
      resolve(response);
    }).fail((response) => {
      let message = "";
      const support_url = getMonsterInsightsUrl(
        "admin-notices",
        "error-deactivating-expired-license",
        "https://www.monsterinsights.com/my-account/support/"
      );
      const title = sprintf(
        // Translators: %1$s: Support Link tag start with URL, %2$s: Support link tag ends.
        __$1(
          "Oops! There was an issue deactivating your expired license, please try again. If the issue persists, please %1$scontact our support team%2$s.",
          "google-analytics-for-wordpress"
        ),
        `<a target="_blank" href="${support_url}">`,
        `</a>`
      );
      if (response == null ? void 0 : response.error) {
        message = response.error;
      } else if (typeof response === "string" && response.length > 0) {
        message = response;
      } else {
        message = __$1(
          "An unknown error occurred while deactivating your expired license.",
          "google-analytics-for-wordpress"
        );
      }
      reject({ title, message, support_url });
    });
  });
};
const getUpgradeLink = (key) => {
  return new Promise((resolve, reject) => {
    const actionValue = "monsterinsights_connect_url";
    const ajaxData = {
      nonce: getMiGlobal("nonce"),
      network: getMiGlobal("network"),
      // Use global data for network flag
      key
    };
    wp.ajax.post(actionValue, ajaxData).done((response) => {
      if (response) {
        resolve(response);
      } else {
        reject({
          title: __$1(
            "Error Getting Upgrade Link",
            "google-analytics-for-wordpress"
          ),
          message: __$1(
            "Empty response from server when trying to get upgrade link.",
            "google-analytics-for-wordpress"
          ),
          support_url: getMonsterInsightsUrl(
            "admin-notices",
            "error-upgrading-license",
            "https://www.monsterinsights.com/my-account/support/"
          )
        });
      }
    }).fail((response) => {
      let message = "";
      const support_url = getMonsterInsightsUrl(
        "admin-notices",
        "error-upgrading-license",
        "https://www.monsterinsights.com/my-account/support/"
      );
      const title = sprintf(
        // Translators: %1$s: Support Link tag start with URL, %2$s: Support link tag ends.
        __$1(
          "Oops! There was an issue getting your upgrade link, please try again. If the issue persists, please %1$scontact our support team%2$s.",
          "google-analytics-for-wordpress"
        ),
        `<a target="_blank" href="${support_url}">`,
        `</a>`
      );
      if (response == null ? void 0 : response.error) {
        message = response.error;
      } else if (typeof response === "string" && response.length > 0) {
        message = response;
      } else {
        message = __$1(
          "An unknown error occurred while getting your upgrade link.",
          "google-analytics-for-wordpress"
        );
      }
      reject({ title, message, support_url });
    });
  });
};
const api = {
  fetchLicense,
  verifyLicense,
  validateLicense,
  deactivateLicense,
  deactivateExpiredLicense,
  getUpgradeLink
};
function useNotices() {
  const state = reactive({
    notices: {}
  });
  const allNotices = computed(() => state.notices);
  const hasNotices = computed(() => Object.keys(state.notices).length > 0);
  const addNotice = (noticeObject) => {
    state.notices = { ...state.notices, [noticeObject.id]: noticeObject };
  };
  const removeNotice = (noticeId) => {
    const { [noticeId]: _, ...rest } = state.notices;
    state.notices = rest;
  };
  const resetNotices = () => {
    state.notices = {};
  };
  const getNotice = (noticeId) => {
    return state.notices[noticeId] || null;
  };
  return {
    allNotices,
    hasNotices,
    addNotice,
    removeNotice,
    resetNotices,
    getNotice
  };
}
const { __ } = wp.i18n;
function getLicenseFromGlobals() {
  const license = getMiGlobal("license", {});
  return {
    key: license.key || "",
    type: license.type || "",
    is_expired: license.is_expired || false,
    is_disabled: license.is_disabled || false,
    is_invalid: license.is_invalid !== false,
    // Default to true if not explicitly false
    expiry_date: license.expiry_date || ""
  };
}
function getNetworkLicenseFromGlobals() {
  const license = getMiGlobal("license_network", {});
  return {
    key: license.key || "",
    type: license.type || "",
    is_expired: license.is_expired || false,
    is_disabled: license.is_disabled || false,
    is_invalid: license.is_invalid !== false,
    // Default to true if not explicitly false
    expiry_date: license.expiry_date || ""
  };
}
const useLicenseStore = defineStore("license", {
  state: () => ({
    license: getLicenseFromGlobals(),
    license_network: getNetworkLicenseFromGlobals(),
    isLoading: false
    // For UI feedback during API calls
  }),
  getters: {
    // Direct state access is common in Pinia, but getters can be defined for computed/derived state
    // Or to maintain a similar interface to the old Vuex getters if preferred by components
    getLicenseDetails: (state) => state.license,
    getLicenseNetworkDetails: (state) => state.license_network,
    activeLicense(state) {
      return isNetworkAdmin() ? state.license_network : state.license;
    },
    activeLicenseType() {
      return this.activeLicense ? this.activeLicense.type : "";
    },
    isCurrentLicenseActive() {
      const license = this.activeLicense;
      return (license == null ? void 0 : license.type) && !license.is_expired && !license.is_disabled && !license.is_invalid;
    },
    // Example of a more specific getter if needed
    isLicenseActive: (state) => state.license.type && !state.license.is_expired && !state.license.is_disabled && !state.license.is_invalid,
    isNetworkLicenseActive: (state) => state.license_network.type && !state.license_network.is_expired && !state.license_network.is_disabled && !state.license_network.is_invalid,
    isLicenseExpired: (state) => {
      var _a, _b;
      const siteLicenseIsExpired = (_a = state.license) == null ? void 0 : _a.is_expired;
      const networkLicenseIsExpired = (_b = state.license_network) == null ? void 0 : _b.is_expired;
      return !!(siteLicenseIsExpired || networkLicenseIsExpired);
    },
    activeLicenseExpiryDate: (state) => {
      const licenseToUse = isNetworkAdmin() ? state.license_network : state.license;
      return (licenseToUse == null ? void 0 : licenseToUse.expiry_date) ? licenseToUse.expiry_date : "";
    },
    // Feature Access Getters for Upsell System
    /**
     * Check if user has Pro or higher license
     * @returns {boolean}
     */
    hasProAccess() {
      const licenseType = this.activeLicenseType;
      return ["Pro", "Elite"].includes(licenseType);
    },
    /**
     * Check if user has Plus or higher license
     * @returns {boolean}
     */
    hasPlusAccess() {
      const licenseType = this.activeLicenseType;
      return ["Plus", "Pro", "Elite"].includes(licenseType);
    },
    /**
     * Check if user is on Lite license
     * @returns {boolean}
     */
    isLiteLicense() {
      const licenseType = this.activeLicenseType;
      return licenseType === "Lite" || !licenseType;
    },
    /**
     * Check if specific feature is available for current license
     * @returns {function(string): boolean}
     */
    hasFeatureAccess() {
      return (feature) => {
        var _a;
        const licenseType = this.activeLicenseType;
        const featureMap = {
          "custom-dashboard": ["Pro", "Elite"],
          ecommerce: ["Plus", "Pro", "Elite"],
          forms: ["Plus", "Pro", "Elite"],
          "search-console": ["Plus", "Pro", "Elite"],
          "real-time": ["Plus", "Pro", "Elite"],
          publishers: ["Pro", "Elite"],
          media: ["Plus", "Pro", "Elite"],
          dimensions: ["Plus", "Pro", "Elite"],
          "popular-products": ["Plus", "Pro", "Elite"]
        };
        return ((_a = featureMap[feature]) == null ? void 0 : _a.includes(licenseType)) || false;
      };
    },
    /**
     * Get minimum required license for a feature
     * @returns {function(string): string}
     */
    getMinimumLicenseForFeature() {
      return (feature) => {
        const featureMap = {
          "custom-dashboard": "Pro",
          ecommerce: "Plus",
          forms: "Plus",
          "search-console": "Plus",
          "real-time": "Plus",
          publishers: "Pro",
          media: "Plus",
          dimensions: "Plus",
          "popular-products": "Plus"
        };
        return featureMap[feature] || "Plus";
      };
    }
  },
  actions: {
    // Mutations from Vuex are converted into direct state modifications here
    updateLicenseKey(key) {
      this.license.key = key;
    },
    updateLicenseData(licenseData) {
      this.license = { ...this.license, ...licenseData };
    },
    updateNetworkLicenseKey(key) {
      this.license_network.key = key;
    },
    updateNetworkLicenseData(licenseData) {
      this.license_network = { ...this.license_network, ...licenseData };
    },
    // Initial actions based on Vuex store
    async fetchLicenseData() {
      const { setActionError } = useErrorHandling();
      this.isLoading = true;
      try {
        const response = await api.fetchLicense();
        if (response.network) {
          this.updateNetworkLicenseData(response.network);
        }
        if (response.site) {
          this.updateLicenseData(response.site);
        }
        this.addLicenseNotices();
      } catch (errorDetails) {
        setActionError({
          title: errorDetails.title || __("Error Fetching License", "google-analytics-for-wordpress"),
          message: errorDetails.message,
          support_url: errorDetails.support_url
        });
      } finally {
        this.isLoading = false;
      }
    },
    async verifyLicense(licenseKey, isNetwork = false) {
      const { setActionError } = useErrorHandling();
      this.isLoading = true;
      try {
        const response = await api.verifyLicense(licenseKey, isNetwork);
        const licenseData = {
          key: licenseKey,
          type: response.license_type || "",
          is_expired: false,
          is_disabled: false,
          is_invalid: false
        };
        if (isNetwork) {
          this.updateNetworkLicenseData(licenseData);
        } else {
          this.updateLicenseData(licenseData);
        }
        this.addLicenseNotices();
        return response;
      } catch (errorDetails) {
        setActionError({
          title: errorDetails.title || __("Error Verifying License", "google-analytics-for-wordpress"),
          message: errorDetails.message,
          support_url: errorDetails.support_url
        });
        throw errorDetails;
      } finally {
        this.isLoading = false;
      }
    },
    // Debounced version - apiVerifyLicense in Vuex
    // We can define it within the store or call a debounced api function directly.
    // For simplicity, let's assume api.verifyLicense can be called directly and components can debounce if needed,
    // or we create a debounced version of the above action if used frequently from multiple places.
    async updateLicense(newLicenseKey) {
      return this.verifyLicense(newLicenseKey, false);
    },
    async updateNetworkLicense(newLicenseKey) {
      this.updateNetworkLicenseKey(newLicenseKey);
      return this.verifyLicense(newLicenseKey, true);
    },
    async validateLicense(isNetwork = false) {
      var _a;
      const { setActionError } = useErrorHandling();
      this.isLoading = true;
      try {
        const response = await api.validateLicense(isNetwork);
        if ((_a = response == null ? void 0 : response.data) == null ? void 0 : _a.success) {
          if (isNetwork) {
            if (response.data.license) {
              this.updateNetworkLicenseData(response.data.license);
            }
          } else {
            if (response.data.license) {
              this.updateLicenseData(response.data.license);
            }
          }
          this.addLicenseNotices();
        }
        return response;
      } catch (errorDetails) {
        setActionError({
          title: errorDetails.title || __("Error Validating License", "google-analytics-for-wordpress"),
          message: errorDetails.message,
          support_url: errorDetails.support_url
        });
        throw errorDetails;
      } finally {
        this.isLoading = false;
      }
    },
    async deactivateLicense(isNetwork = false) {
      const { setActionError } = useErrorHandling();
      this.isLoading = true;
      try {
        const licenseKeyToDeactivate = isNetwork ? this.license_network.key : this.license.key;
        const response = await api.deactivateLicense(
          licenseKeyToDeactivate,
          isNetwork
        );
        const clearedLicense = {
          key: "",
          type: "",
          is_expired: false,
          is_disabled: false,
          is_invalid: true
        };
        if (isNetwork) {
          this.updateNetworkLicenseData(clearedLicense);
        } else {
          this.updateLicenseData(clearedLicense);
        }
        this.addLicenseNotices();
        return response;
      } catch (errorDetails) {
        setActionError({
          title: errorDetails.title || __("Error Deactivating License", "google-analytics-for-wordpress"),
          message: errorDetails.message,
          support_url: errorDetails.support_url
        });
        throw errorDetails;
      } finally {
        this.isLoading = false;
      }
    },
    async deactivateExpiredLicense(isNetwork = false) {
      const { setActionError } = useErrorHandling();
      this.isLoading = true;
      try {
        const licenseKeyToDeactivate = isNetwork ? this.license_network.key : this.license.key;
        const response = await api.deactivateExpiredLicense(
          licenseKeyToDeactivate,
          isNetwork
        );
        const clearedLicense = {
          key: "",
          type: "",
          is_expired: false,
          is_disabled: false,
          is_invalid: true
        };
        if (isNetwork) {
          this.updateNetworkLicenseData(clearedLicense);
        } else {
          this.updateLicenseData(clearedLicense);
        }
        this.addLicenseNotices();
        return response;
      } catch (errorDetails) {
        setActionError({
          title: errorDetails.title || __(
            "Error Deactivating Expired License",
            "google-analytics-for-wordpress"
          ),
          message: errorDetails.message,
          support_url: errorDetails.support_url
        });
        throw errorDetails;
      } finally {
        this.isLoading = false;
      }
    },
    removeLicenseNotices() {
      const { removeNotice } = useNotices();
      removeNotice("license_expired");
      removeNotice("license_disabled");
      removeNotice("license_invalid");
    },
    addLicenseNotices() {
      const { addNotice } = useNotices();
      this.removeLicenseNotices();
      const licenseToUse = isNetworkAdmin() ? this.license_network : this.license;
      licenseToUse.type;
      getUrl("pricing", "license-notice");
      __("Upgrade Now", "google-analytics-dashboard-for-wp");
      if (licenseToUse.is_expired) {
        addNotice({
          id: "license_expired",
          title: __(
            "Your license has expired.",
            "google-analytics-for-wordpress"
          ),
          content: __(
            "To ensure tracking works properly, reactivate your license",
            "google-analytics-for-wordpress"
          ),
          button: {
            enabled: true,
            text: __("Reactivate License", "google-analytics-for-wordpress"),
            link: getUrl(
              "admin-notices",
              "expired-license",
              "https://www.monsterinsights.com/login/"
            )
          },
          icon: '<svg width="27" height="23" viewBox="0 0 27 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M25.5742 19.6992L15.2617 1.78125C14.4883 0.449219 12.4688 0.40625 11.6953 1.78125L1.38281 19.6992C0.609375 21.0312 1.59766 22.75 3.1875 22.75H23.7695C25.3594 22.75 26.3477 21.0742 25.5742 19.6992ZM13.5 15.9609C14.5742 15.9609 15.4766 16.8633 15.4766 17.9375C15.4766 19.0547 14.5742 19.9141 13.5 19.9141C12.3828 19.9141 11.5234 19.0547 11.5234 17.9375C11.5234 16.8633 12.3828 15.9609 13.5 15.9609ZM11.6094 8.87109C11.5664 8.57031 11.8242 8.3125 12.125 8.3125H14.832C15.1328 8.3125 15.3906 8.57031 15.3477 8.87109L15.0469 14.7148C15.0039 15.0156 14.7891 15.1875 14.5312 15.1875H12.4258C12.168 15.1875 11.9531 15.0156 11.9102 14.7148L11.6094 8.87109Z" fill="#E64949"/></svg>',
          type: "error"
        });
        return;
      }
      if (licenseToUse.is_disabled) {
        addNotice({
          id: "license_disabled",
          content: __(
            "Your license key for MonsterInsights has been disabled. Please use a different key.",
            "google-analytics-for-wordpress"
          ),
          type: "error"
        });
        return;
      }
      if (licenseToUse.is_invalid) {
        addNotice({
          id: "license_invalid",
          content: __(
            "Your license key for MonsterInsights is invalid. The key no longer exists or the user associated with the key has been deleted. Please use a different key.",
            "google-analytics-for-wordpress"
          ),
          type: "error"
        });
      }
    }
  }
});
const _hoisted_1 = { class: "monsterinsights-upsell-modal" };
const _hoisted_2 = { class: "monsterinsights-upsell-top" };
const _hoisted_3 = ["textContent"];
const _hoisted_4 = ["aria-label"];
const _hoisted_5 = { class: "monsterinsights-upsell-content" };
const _hoisted_6 = { class: "monsterinsights-upsell-content__features" };
const _hoisted_7 = ["textContent"];
const _hoisted_8 = ["textContent"];
const _hoisted_9 = ["textContent"];
const _hoisted_10 = { class: "monsterinsights-upsell-content__features-cliff" };
const _hoisted_11 = ["innerHTML"];
const _hoisted_12 = { class: "monsterinsights-upsell-content-buttons" };
const _sfc_main = {
  __name: "UpsellModal",
  props: {
    isOpen: {
      type: Boolean,
      default: false
    },
    dismissible: {
      type: Boolean,
      default: true
    },
    feature: {
      type: String,
      required: true
    },
    content: {
      type: Object,
      required: true
    },
    customSubheading: {
      type: String,
      default: null
    },
    showSampleButton: {
      type: Boolean,
      default: true
    },
    noImage: {
      type: Boolean,
      default: false
    },
    forceTwoColumns: {
      type: Boolean,
      default: false
    },
    customImage: {
      type: String,
      default: null
    }
  },
  emits: ["close", "upgrade", "see-sample", "learn-more"],
  setup(__props, { emit: __emit }) {
    const props = __props;
    const emit = __emit;
    const licenseStore = useLicenseStore();
    const currentLicense = computed(() => {
      return licenseStore.activeLicenseType || "Lite";
    });
    computed(() => {
      return ["Pro", "Elite"].includes(currentLicense.value);
    });
    const minimumLicense = computed(() => {
      return licenseStore.getMinimumLicenseForFeature(props.feature);
    });
    const brand = computed(() => {
      return getMiGlobal("brand", "MonsterInsights");
    });
    const buttonText = computed(() => {
      if (!props.content.buttonText) {
        return `Upgrade to ${minimumLicense.value}`;
      }
      if (typeof props.content.buttonText === "object") {
        return props.content.buttonText[currentLicense.value] || `Upgrade to ${minimumLicense.value}`;
      }
      return props.content.buttonText;
    });
    const subheading = computed(() => {
      if (props.customSubheading) {
        return props.customSubheading;
      }
      if (props.content.mainHeading) {
        return sprintf$1(
          __$2("What's in the %s?", "google-analytics-for-wordpress"),
          props.content.mainHeading
        );
      }
      return "";
    });
    const footerNotice = computed(() => {
      const upgradeLevel = minimumLicense.value;
      return sprintf$1(
        __$2("%1$sPlus%2$s, upgrading to %5$s will unlock %1$sall%2$s advanced reports, tracking, and integrations. %3$sLearn more about %5$s%4$s", "google-analytics-for-wordpress"),
        "<strong>",
        "</strong>",
        `<a target="_blank" href="${getUpgradeLink2()}" class="monsterinsights-upsell-learn-more">`,
        "</a>",
        upgradeLevel
      );
    });
    const featuresClass = computed(() => {
      var _a;
      const featureCount = ((_a = props.content.features) == null ? void 0 : _a.length) || 0;
      return featureCount > 4 || props.forceTwoColumns ? "columns-2" : "columns-1";
    });
    const hasSampleData = computed(() => {
      return props.content.sampleDataAvailable !== false;
    });
    const imageClass = computed(() => {
      return `upsell-${props.feature}`;
    });
    const imageStyle = computed(() => {
      if (props.customImage) {
        {
          const assetsUrl = getMiGlobal("assets_url", "");
          return {
            "--upsell-image": `url(${assetsUrl}/assets/${props.customImage})`
          };
        }
      }
      return {};
    });
    function getUpgradeLink2() {
      return getUpgradeUrl(
        "custom-dashboard-upsell",
        `upgrade-${props.feature}`,
        props.content.learnMoreUrl || `https://www.${brand.value.toLowerCase()}.com/pricing/`
      );
    }
    function handleClose() {
      emit("close");
    }
    function handleUpgrade() {
      const upgradeUrl = getUpgradeLink2();
      window.open(upgradeUrl, "_blank");
      emit("upgrade", upgradeUrl);
    }
    function handleSeeSample() {
      emit("see-sample");
    }
    return (_ctx, _cache) => {
      return openBlock(), createBlock(Teleport, { to: "body" }, [
        createVNode(Transition, { name: "upsell-fade" }, {
          default: withCtx(() => [
            __props.isOpen ? (openBlock(), createElementBlock("div", {
              key: 0,
              class: "monsterinsights-upsell-overlay",
              onClick: _cache[0] || (_cache[0] = withModifiers(($event) => __props.dismissible ? handleClose() : null, ["self"]))
            }, [
              createBaseVNode("div", _hoisted_1, [
                createBaseVNode("div", _hoisted_2, [
                  __props.content.mainHeading ? (openBlock(), createElementBlock("h3", {
                    key: 0,
                    textContent: toDisplayString(__props.content.mainHeading)
                  }, null, 8, _hoisted_3)) : createCommentVNode("", true),
                  __props.dismissible ? (openBlock(), createElementBlock("button", {
                    key: 1,
                    class: "monsterinsights-upsell-close",
                    onClick: handleClose,
                    "aria-label": unref(__$2)("Close", "google-analytics-for-wordpress")
                  }, [
                    createVNode(Icon, {
                      name: "dashicons-no-alt",
                      size: 24
                    })
                  ], 8, _hoisted_4)) : createCommentVNode("", true)
                ]),
                createBaseVNode("div", _hoisted_5, [
                  createBaseVNode("div", _hoisted_6, [
                    __props.content.title ? (openBlock(), createElementBlock("h3", {
                      key: 0,
                      textContent: toDisplayString(__props.content.title)
                    }, null, 8, _hoisted_7)) : createCommentVNode("", true),
                    subheading.value ? (openBlock(), createElementBlock("h4", {
                      key: 1,
                      textContent: toDisplayString(subheading.value)
                    }, null, 8, _hoisted_8)) : createCommentVNode("", true),
                    __props.content.features && __props.content.features.length ? (openBlock(), createElementBlock("ul", {
                      key: 2,
                      class: normalizeClass(featuresClass.value)
                    }, [
                      (openBlock(true), createElementBlock(Fragment, null, renderList(__props.content.features, (feature, index) => {
                        return openBlock(), createElementBlock("li", { key: index }, [
                          createVNode(Icon, {
                            name: "dashicons-yes",
                            size: 16,
                            class: "feature-checkmark"
                          }),
                          createBaseVNode("span", {
                            textContent: toDisplayString(feature)
                          }, null, 8, _hoisted_9)
                        ]);
                      }), 128))
                    ], 2)) : createCommentVNode("", true),
                    createBaseVNode("div", _hoisted_10, [
                      createBaseVNode("p", null, toDisplayString(unref(__$2)("And more!", "google-analytics-for-wordpress")), 1)
                    ]),
                    createBaseVNode("p", { innerHTML: footerNotice.value }, null, 8, _hoisted_11),
                    createBaseVNode("div", _hoisted_12, [
                      createBaseVNode("button", {
                        class: "monsterinsights-button monsterinsights-button-upgrade",
                        onClick: handleUpgrade
                      }, toDisplayString(buttonText.value), 1),
                      __props.showSampleButton && hasSampleData.value ? (openBlock(), createElementBlock("button", {
                        key: 0,
                        class: "monsterinsights-upsell-content-button-sample-report",
                        onClick: handleSeeSample
                      }, toDisplayString(unref(__$2)("See a Sample Report", "google-analytics-for-wordpress")), 1)) : createCommentVNode("", true)
                    ])
                  ]),
                  !__props.noImage ? (openBlock(), createElementBlock("div", {
                    key: 0,
                    class: normalizeClass([imageClass.value, "monsterinsights-upsell-content__img"]),
                    style: normalizeStyle(imageStyle.value)
                  }, null, 6)) : createCommentVNode("", true)
                ])
              ])
            ])) : createCommentVNode("", true)
          ]),
          _: 1
        })
      ]);
    };
  }
};
const UpsellModal = /* @__PURE__ */ _export_sfc(_sfc_main, [["__scopeId", "data-v-494dd58d"]]);
function useUpsellContent() {
  function getUpsellContent(feature) {
    const upsellTexts = {
      "custom-dashboard": {
        mainHeading: __$2("Custom Dashboard", "google-analytics-for-wordpress"),
        title: __$2(
          "Create Your Perfect Analytics Dashboard",
          "google-analytics-for-wordpress"
        ),
        features: [
          __$2("Build unlimited custom dashboards", "google-analytics-for-wordpress"),
          __$2("Choose from 20+ designed templates", "google-analytics-for-wordpress"),
          __$2("Drag-and-drop widgets", "google-analytics-for-wordpress"),
          __$2("Track metrics that matter most", "google-analytics-for-wordpress"),
          __$2(
            "Share custom dashboards with your team",
            "google-analytics-for-wordpress"
          ),
          __$2("Export dashboards as PDF reports", "google-analytics-for-wordpress")
        ],
        buttonText: {
          Lite: __$2("Upgrade to Pro", "google-analytics-for-wordpress"),
          Plus: __$2("Upgrade to Pro", "google-analytics-for-wordpress")
        },
        learnMoreUrl: "https://www.monsterinsights.com/features/custom-dashboard/",
        sampleDataAvailable: true,
        requiredLicense: "Pro"
      },
      ecommerce: {
        mainHeading: __$2("eCommerce Report", "google-analytics-for-wordpress"),
        title: __$2(
          "Increase Sales and Make More Money With Enhanced eCommerce Insights",
          "google-analytics-for-wordpress"
        ),
        features: [
          __$2("10+ eCommerce Integrations", "google-analytics-for-wordpress"),
          __$2("Average Order Value", "google-analytics-for-wordpress"),
          __$2("Total Revenue", "google-analytics-for-wordpress"),
          __$2("Sessions to Purchase", "google-analytics-for-wordpress"),
          __$2("Top Conversion Sources", "google-analytics-for-wordpress"),
          __$2("Top Products", "google-analytics-for-wordpress"),
          __$2("Number of Transactions", "google-analytics-for-wordpress"),
          __$2("Time to Purchase", "google-analytics-for-wordpress")
        ],
        buttonText: {
          Lite: __$2("Upgrade to Plus", "google-analytics-for-wordpress")
        },
        learnMoreUrl: "https://www.monsterinsights.com/addon/ecommerce/",
        sampleDataAvailable: true,
        requiredLicense: "Plus"
      },
      forms: {
        mainHeading: __$2("Forms Report", "google-analytics-for-wordpress"),
        title: __$2(
          "Track Every Type of Web Form and Gain Visibility Into Your Customer Journey",
          "google-analytics-for-wordpress"
        ),
        features: [
          __$2("Conversion Counts", "google-analytics-for-wordpress"),
          __$2("Impression Counts", "google-analytics-for-wordpress"),
          __$2("Conversion Rates", "google-analytics-for-wordpress")
        ],
        buttonText: {
          Lite: __$2("Upgrade to Plus", "google-analytics-for-wordpress")
        },
        learnMoreUrl: "https://www.monsterinsights.com/addon/forms/",
        sampleDataAvailable: true,
        requiredLicense: "Plus"
      },
      publisher: {
        mainHeading: __$2("Publishers Report", "google-analytics-for-wordpress"),
        title: __$2(
          "Improve Your Conversion Rate With Insights Into Which Content Works Best",
          "google-analytics-for-wordpress"
        ),
        features: [
          __$2("Top Landing Pages", "google-analytics-for-wordpress"),
          __$2("Top Affilliate Links", "google-analytics-for-wordpress"),
          __$2("Top Exit Pages", "google-analytics-for-wordpress"),
          __$2("Top Download Links", "google-analytics-for-wordpress"),
          __$2("Top Outbound Links", "google-analytics-for-wordpress"),
          __$2("Scroll Depth", "google-analytics-for-wordpress")
        ],
        buttonText: {
          Lite: __$2("Upgrade to Pro", "google-analytics-for-wordpress"),
          Plus: __$2("Upgrade to Pro", "google-analytics-for-wordpress")
        },
        learnMoreUrl: "https://www.monsterinsights.com/addon/publisher/",
        sampleDataAvailable: true,
        requiredLicense: "Pro"
      },
      dimensions: {
        mainHeading: __$2("Dimensions Report", "google-analytics-for-wordpress"),
        title: __$2(
          "Increase Engagement and Unlock New Insights About Your Site",
          "google-analytics-for-wordpress"
        ),
        features: [
          __$2("Author Tracking", "google-analytics-for-wordpress"),
          __$2("User ID Tracking", "google-analytics-for-wordpress"),
          __$2("Post Types", "google-analytics-for-wordpress"),
          __$2("Tag Tracking", "google-analytics-for-wordpress"),
          __$2("Categories", "google-analytics-for-wordpress"),
          __$2("SEO Scores", "google-analytics-for-wordpress"),
          __$2("Publish Times", "google-analytics-for-wordpress"),
          __$2("Focus Keywords", "google-analytics-for-wordpress")
        ],
        buttonText: {
          Lite: __$2("Upgrade to Plus", "google-analytics-for-wordpress")
        },
        learnMoreUrl: "https://www.monsterinsights.com/addon/dimensions/",
        sampleDataAvailable: true,
        requiredLicense: "Plus"
      }
    };
    return upsellTexts[feature] || null;
  }
  return {
    getUpsellContent
  };
}
function useFeatureGate(feature) {
  const { getUpsellContent } = useUpsellContent();
  const isUpsellModalOpen = ref(false);
  const isSampleMode = ref(false);
  const hasAccess = computed(() => {
    const license = getMiGlobal("license", {});
    const licenseType = (license.type || "").toLowerCase();
    return licenseType === "pro" || licenseType === "elite";
  });
  const upsellContent = computed(() => {
    return getUpsellContent(feature);
  });
  const minimumLicense = computed(() => {
    return __$2("Pro", "google-analytics-for-wordpress");
  });
  const currentLicense = computed(() => {
    const license = getMiGlobal("license", {});
    const type = license.type || "";
    return type.charAt(0).toUpperCase() + type.slice(1) || __$2("Lite", "google-analytics-for-wordpress");
  });
  const upgradeButtonText = computed(() => {
    if (!upsellContent.value) {
      return __$2("Upgrade Now", "google-analytics-for-wordpress");
    }
    const buttonTextConfig = upsellContent.value.buttonText;
    if (typeof buttonTextConfig === "object") {
      return buttonTextConfig[currentLicense.value] || // translators: %s is the license level (e.g., "Pro", "Plus")
      __$2("Upgrade to %s", "google-analytics-for-wordpress").replace(
        "%s",
        minimumLicense.value
      );
    }
    return buttonTextConfig || __$2("Upgrade to %s", "google-analytics-for-wordpress").replace(
      "%s",
      minimumLicense.value
    );
  });
  const hasSampleData = computed(() => {
    var _a;
    return ((_a = upsellContent.value) == null ? void 0 : _a.sampleDataAvailable) || false;
  });
  const openUpsellModal = () => {
    isUpsellModalOpen.value = true;
    isSampleMode.value = false;
  };
  const closeUpsellModal = () => {
    isUpsellModalOpen.value = false;
  };
  const enableSampleMode = () => {
    isSampleMode.value = true;
    closeUpsellModal();
  };
  const disableSampleMode = () => {
    isSampleMode.value = false;
  };
  const handleUpgrade = () => {
    var _a;
    const learnMoreUrl = ((_a = upsellContent.value) == null ? void 0 : _a.learnMoreUrl) || "https://www.monsterinsights.com/pricing/";
    const upgradeUrl = getUpgradeUrl(
      "custom-dashboard-upsell",
      `upgrade-${feature}`,
      learnMoreUrl
    );
    window.open(upgradeUrl, "_blank");
  };
  const handleLearnMore = () => {
    var _a;
    const learnMoreUrl = ((_a = upsellContent.value) == null ? void 0 : _a.learnMoreUrl) || "https://www.monsterinsights.com/";
    window.open(learnMoreUrl, "_blank");
  };
  const shouldBlurContent = computed(() => {
    return !hasAccess.value && !isSampleMode.value;
  });
  const shouldShowUpsell = computed(() => {
    return !hasAccess.value && isUpsellModalOpen.value && !isSampleMode.value;
  });
  return {
    // Access control
    hasAccess,
    minimumLicense,
    currentLicense,
    // Upsell content
    upsellContent,
    upgradeButtonText,
    hasSampleData,
    // Modal state
    isUpsellModalOpen,
    isSampleMode,
    shouldBlurContent,
    shouldShowUpsell,
    // Actions
    openUpsellModal,
    closeUpsellModal,
    enableSampleMode,
    disableSampleMode,
    handleUpgrade,
    handleLearnMore
  };
}
function useSampleData(feature, dataType = "overview") {
  const sampleData = ref(null);
  const isLoading = ref(false);
  const error = ref(null);
  const loadSampleData = async () => {
    if (sampleData.value) {
      return;
    }
    isLoading.value = true;
    error.value = null;
    try {
      const path = `${feature}/${dataType}`;
      const data = await getSampleData(path);
      if (!data) {
        throw new Error(`Sample data not found for ${path}`);
      }
      if (data.widgets) {
        Object.values(data.widgets).forEach((widget) => {
          if (!widget.chart) {
            widget.chart = {
              labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
              datasets: [{
                label: "Sample Data",
                data: [12, 19, 3, 5, 2, 3],
                fill: true,
                backgroundColor: "rgba(54, 162, 235, 0.2)",
                borderColor: "rgb(54, 162, 235)",
                borderWidth: 1
              }]
            };
          }
        });
      }
      sampleData.value = data;
    } catch (err) {
      error.value = err.message;
      console.error("[useSampleData] Error loading sample data:", err);
    } finally {
      isLoading.value = false;
    }
  };
  const clearSampleData = () => {
    sampleData.value = null;
    error.value = null;
  };
  return {
    sampleData,
    isLoading,
    error,
    loadSampleData,
    clearSampleData
  };
}
export {
  Icon as I,
  UpsellModal as U,
  useSampleData as a,
  useLicenseStore as b,
  useFeatureGate as u
};
