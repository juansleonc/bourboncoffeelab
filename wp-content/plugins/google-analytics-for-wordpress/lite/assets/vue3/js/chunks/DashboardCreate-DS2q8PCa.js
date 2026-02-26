import { c as createElementBlock, a as openBlock, e as createBlock, f as createCommentVNode, g as createBaseVNode, t as toDisplayString, n as normalizeClass, h as computed, r as ref, u as unref, _ as __, b as createVNode, w as withDirectives, v as vModelText, i as withCtx, j as _export_sfc, k as watch, T as Transition, l as Teleport, m as getWidgetSupportForType, p as withModifiers, F as Fragment, q as renderList, s as reactive, o as onMounted, x as useRoute, y as onBeforeUnmount, d as useRouter } from "../custom-dashboard.js";
import { u as useCustomViewsStore, d as draggable, a as useAuthGate, c as customDashboardAPI, V as ViewNavigation, _ as _sfc_main$5, b as _sfc_main$6, e as _sfc_main$7, A as AuthModal, R as ReAuthModal, f as _sfc_main$8 } from "./useAuthGate-Bvb6NIwm.js";
import { I as Icon, b as useLicenseStore, u as useFeatureGate, a as useSampleData, U as UpsellModal } from "./useSampleData-WWO8wHOx.js";
const _hoisted_1$4 = { class: "monsterinsights-widget-item__name" };
const _sfc_main$4 = {
  __name: "WidgetItem",
  props: {
    widget: {
      type: Object,
      required: true
    }
  },
  emits: ["drag"],
  setup(__props, { emit: __emit }) {
    const emit = __emit;
    function handleDragStart(event) {
      emit("drag", event);
    }
    return (_ctx, _cache) => {
      return openBlock(), createElementBlock("div", {
        class: normalizeClass(["monsterinsights-widget-item", {
          "monsterinsights-widget-item--selected": __props.widget.selected
        }]),
        draggable: "true",
        onDragstart: handleDragStart
      }, [
        __props.widget.icon ? (openBlock(), createBlock(Icon, {
          key: 0,
          name: __props.widget.icon,
          size: 16
        }, null, 8, ["name"])) : createCommentVNode("", true),
        createBaseVNode("span", _hoisted_1$4, toDisplayString(__props.widget.name), 1)
      ], 34);
    };
  }
};
const _hoisted_1$3 = ["aria-label", "title"];
const _hoisted_2$3 = { class: "monsterinsights-widget-sidebar__content" };
const _hoisted_3$3 = {
  key: 0,
  class: "monsterinsights-widget-search"
};
const _hoisted_4$3 = ["placeholder"];
const _hoisted_5$2 = { class: "monsterinsights-widget-sections" };
const _hoisted_6$2 = {
  key: 0,
  class: "monsterinsights-widget-group"
};
const _hoisted_7$2 = { class: "monsterinsights-widget-group__title" };
const _hoisted_8$2 = {
  key: 1,
  class: "monsterinsights-widget-group"
};
const _hoisted_9$2 = { class: "monsterinsights-widget-group__title" };
const _hoisted_10$2 = {
  key: 2,
  class: "monsterinsights-widget-group"
};
const _hoisted_11$1 = { class: "monsterinsights-widget-group__title" };
const _hoisted_12$1 = {
  key: 3,
  class: "monsterinsights-widget-group"
};
const _hoisted_13 = { class: "monsterinsights-widget-group__title" };
const _sfc_main$3 = {
  __name: "WidgetsSidebar",
  setup(__props) {
    const store = useCustomViewsStore();
    const licenseStore = useLicenseStore();
    const isLite = computed(() => licenseStore.activeLicenseType === "Lite" || !licenseStore.activeLicenseType);
    const searchQuery = ref("");
    const isCollapsed = ref(false);
    function toggleCollapse() {
      isCollapsed.value = !isCollapsed.value;
    }
    const keyMetricsWidgets = computed(() => {
      return Object.entries(store.widgetMetadata).filter(([_, widget]) => widget.category === __("Key Metrics", "google-analytics-for-wordpress")).map(([type, widget]) => ({
        id: type,
        name: widget.title,
        icon: widget.icon || "icons/datetime"
      }));
    });
    const trafficSourceWidgets = computed(() => {
      return Object.entries(store.widgetMetadata).filter(([_, widget]) => widget.category === __("Traffic Source", "google-analytics-for-wordpress")).map(([type, widget]) => ({
        id: type,
        name: widget.title,
        icon: widget.icon || "icons/page-search"
      }));
    });
    const customDimensionWidgets = computed(() => {
      return Object.entries(store.widgetMetadata).filter(([_, widget]) => widget.category === __("Custom Dimensions", "google-analytics-for-wordpress")).map(([type, widget]) => ({
        id: type,
        name: widget.title,
        icon: widget.icon || "icons/category"
      }));
    });
    const trafficWidgets = computed(() => {
      return Object.entries(store.widgetMetadata).filter(([_, widget]) => widget.category === __("Traffic", "google-analytics-for-wordpress")).map(([type, widget]) => ({
        id: type,
        name: widget.title,
        icon: widget.icon || "icons/web-asset"
      }));
    });
    const filteredKeyMetricsWidgets = computed(
      () => keyMetricsWidgets.value.filter(
        (widget) => widget.name.toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    );
    const filteredTrafficSourceWidgets = computed(
      () => trafficSourceWidgets.value.filter(
        (widget) => widget.name.toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    );
    const filteredCustomDimensionWidgets = computed(
      () => customDimensionWidgets.value.filter(
        (widget) => widget.name.toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    );
    const filteredTrafficWidgets = computed(
      () => trafficWidgets.value.filter(
        (widget) => widget.name.toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    );
    function cloneWidget(widget) {
      const widgetType = widget.id;
      const widgetMeta = store.getWidgetByType(widgetType);
      const widgetTitle = (widgetMeta == null ? void 0 : widgetMeta.title) || widgetType;
      const widgetDefaults = (widgetMeta == null ? void 0 : widgetMeta.defaults) || {};
      const { type: _, ...apiDefaults } = widgetDefaults;
      const defaultDisplayType = widgetDefaults.type || "infobox";
      let defaultHeight = 1;
      if (defaultDisplayType === "table") {
        defaultHeight = 3;
      } else if (defaultDisplayType === "line-chart" || defaultDisplayType === "bar-chart" || defaultDisplayType === "pie-chart") {
        defaultHeight = 2;
      }
      const widgetInstance = {
        ...widget,
        id: `${widgetType}-${Date.now()}`,
        type: widgetType,
        // This is the widget data type (e.g., 'active-users')
        title: widgetTitle,
        displayType: defaultDisplayType,
        // Set the UI display type from widget defaults
        ...apiDefaults,
        // Spread only API-related defaults (metrics, dimensions, etc.)
        position: { x: 0, y: 0, w: 1, h: defaultHeight }
      };
      return widgetInstance;
    }
    return (_ctx, _cache) => {
      return openBlock(), createElementBlock("div", {
        class: normalizeClass(["monsterinsights-widget-sidebar", { "monsterinsights-widget-sidebar--collapsed": isCollapsed.value }])
      }, [
        createBaseVNode("button", {
          class: "monsterinsights-widget-sidebar__toggle",
          "aria-label": isCollapsed.value ? unref(__)("Expand sidebar", "google-analytics-for-wordpress") : unref(__)("Collapse sidebar", "google-analytics-for-wordpress"),
          title: isCollapsed.value ? unref(__)("Expand sidebar", "google-analytics-for-wordpress") : unref(__)("Collapse sidebar", "google-analytics-for-wordpress"),
          onClick: toggleCollapse
        }, [
          (openBlock(), createElementBlock("svg", {
            class: normalizeClass(["monsterinsights-widget-sidebar__toggle-icon", { "monsterinsights-widget-sidebar__toggle-icon--collapsed": isCollapsed.value }]),
            width: "8",
            height: "14",
            viewBox: "0 0 8 14",
            fill: "none",
            xmlns: "http://www.w3.org/2000/svg"
          }, [..._cache[1] || (_cache[1] = [
            createBaseVNode("path", {
              d: "M1 1L7 7L1 13",
              stroke: "currentColor",
              "stroke-width": "2",
              "stroke-linecap": "round",
              "stroke-linejoin": "round"
            }, null, -1)
          ])], 2))
        ], 8, _hoisted_1$3),
        createBaseVNode("div", _hoisted_2$3, [
          !isLite.value ? (openBlock(), createElementBlock("div", _hoisted_3$3, [
            createVNode(Icon, {
              name: "search",
              size: 20
            }),
            withDirectives(createBaseVNode("input", {
              "onUpdate:modelValue": _cache[0] || (_cache[0] = ($event) => searchQuery.value = $event),
              type: "text",
              placeholder: unref(__)("Search Widget", "google-analytics-for-wordpress")
            }, null, 8, _hoisted_4$3), [
              [vModelText, searchQuery.value]
            ])
          ])) : createCommentVNode("", true),
          createBaseVNode("div", _hoisted_5$2, [
            filteredKeyMetricsWidgets.value.length ? (openBlock(), createElementBlock("div", _hoisted_6$2, [
              createBaseVNode("h3", _hoisted_7$2, toDisplayString(unref(__)("Key Metrics", "google-analytics-for-wordpress")), 1),
              createVNode(unref(draggable), {
                "model-value": filteredKeyMetricsWidgets.value,
                "item-key": "id",
                class: "monsterinsights-widget-group__items",
                group: { name: "widgets", pull: "clone", put: false },
                sort: false,
                clone: cloneWidget
              }, {
                item: withCtx(({ element: widget }) => [
                  createVNode(_sfc_main$4, { widget }, null, 8, ["widget"])
                ]),
                _: 1
              }, 8, ["model-value"])
            ])) : createCommentVNode("", true),
            filteredTrafficSourceWidgets.value.length ? (openBlock(), createElementBlock("div", _hoisted_8$2, [
              createBaseVNode("h3", _hoisted_9$2, toDisplayString(unref(__)("Traffic Source", "google-analytics-for-wordpress")), 1),
              createVNode(unref(draggable), {
                "model-value": filteredTrafficSourceWidgets.value,
                "item-key": "id",
                class: "monsterinsights-widget-group__items",
                group: { name: "widgets", pull: "clone", put: false },
                sort: false,
                clone: cloneWidget
              }, {
                item: withCtx(({ element: widget }) => [
                  createVNode(_sfc_main$4, { widget }, null, 8, ["widget"])
                ]),
                _: 1
              }, 8, ["model-value"])
            ])) : createCommentVNode("", true),
            filteredCustomDimensionWidgets.value.length ? (openBlock(), createElementBlock("div", _hoisted_10$2, [
              createBaseVNode("h3", _hoisted_11$1, toDisplayString(unref(__)("Custom Dimensions", "google-analytics-for-wordpress")), 1),
              createVNode(unref(draggable), {
                "model-value": filteredCustomDimensionWidgets.value,
                "item-key": "id",
                class: "monsterinsights-widget-group__items",
                group: { name: "widgets", pull: "clone", put: false },
                sort: false,
                clone: cloneWidget
              }, {
                item: withCtx(({ element: widget }) => [
                  createVNode(_sfc_main$4, { widget }, null, 8, ["widget"])
                ]),
                _: 1
              }, 8, ["model-value"])
            ])) : createCommentVNode("", true),
            filteredTrafficWidgets.value.length ? (openBlock(), createElementBlock("div", _hoisted_12$1, [
              createBaseVNode("h3", _hoisted_13, toDisplayString(unref(__)("Traffic", "google-analytics-for-wordpress")), 1),
              createVNode(unref(draggable), {
                "model-value": filteredTrafficWidgets.value,
                "item-key": "id",
                class: "monsterinsights-widget-group__items",
                group: { name: "widgets", pull: "clone", put: false },
                sort: false,
                clone: cloneWidget
              }, {
                item: withCtx(({ element: widget }) => [
                  createVNode(_sfc_main$4, { widget }, null, 8, ["widget"])
                ]),
                _: 1
              }, 8, ["model-value"])
            ])) : createCommentVNode("", true)
          ])
        ])
      ], 2);
    };
  }
};
const _hoisted_1$2 = { class: "monsterinsights-modal-content" };
const _hoisted_2$2 = { class: "monsterinsights-modal-header" };
const _hoisted_3$2 = ["aria-label"];
const _hoisted_4$2 = ["aria-label"];
const _hoisted_5$1 = { class: "monsterinsights-modal-body" };
const _hoisted_6$1 = { class: "monsterinsights-radio-label" };
const _hoisted_7$1 = ["value", "checked", "disabled", "onChange"];
const _hoisted_8$1 = { class: "monsterinsights-radio-text" };
const _hoisted_9$1 = { class: "monsterinsights-checkbox-label" };
const _hoisted_10$1 = ["value", "checked", "disabled", "onChange"];
const _hoisted_11 = { class: "monsterinsights-checkbox-text" };
const _hoisted_12 = { class: "monsterinsights-modal-footer" };
const _sfc_main$2 = {
  __name: "EditMetricsModal",
  props: {
    isOpen: {
      type: Boolean,
      default: false
    },
    widget: {
      type: Object,
      default: null
    },
    widgetMetadata: {
      type: Object,
      default: null
    }
  },
  emits: ["close", "apply"],
  setup(__props, { emit: __emit }) {
    const props = __props;
    const emit = __emit;
    const selectedMetrics = ref([]);
    watch(() => props.widget, (newWidget) => {
      if (newWidget && newWidget.metrics) {
        selectedMetrics.value = [...newWidget.metrics];
      } else if (newWidget) {
        selectedMetrics.value = [];
      }
    }, { immediate: true });
    const currentDisplayType = computed(() => {
      var _a, _b, _c;
      return ((_a = props.widget) == null ? void 0 : _a.displayType) || ((_c = (_b = props.widgetMetadata) == null ? void 0 : _b.defaults) == null ? void 0 : _c.type) || "infobox";
    });
    const isSingleSelection = computed(() => {
      var _a, _b;
      const selectionConfig = (_b = (_a = props.widgetMetadata) == null ? void 0 : _a.support) == null ? void 0 : _b.metricSelection;
      if (!selectionConfig) return false;
      const displayType = currentDisplayType.value;
      if (typeof selectionConfig === "object" && !Array.isArray(selectionConfig)) {
        return selectionConfig[displayType] === "single";
      }
      return selectionConfig === "single";
    });
    const availableMetrics = computed(() => {
      if (!props.widgetMetadata || !props.widgetMetadata.support) {
        return [];
      }
      const typeSupport = getWidgetSupportForType(props.widgetMetadata.support, currentDisplayType.value);
      const supportedMetrics = typeSupport.metrics;
      const metricLabels = {
        "sessions": __("Sessions", "google-analytics-for-wordpress"),
        "activeUsers": __("Users", "google-analytics-for-wordpress"),
        "screenPageViews": __("Views", "google-analytics-for-wordpress"),
        "engagementRate": __("Engagement Rate", "google-analytics-for-wordpress"),
        "engagedSessions": __("Engaged Sessions", "google-analytics-for-wordpress"),
        "conversions": __("Conversions", "google-analytics-for-wordpress"),
        "conversionRate": __("Conversion Rate", "google-analytics-for-wordpress"),
        "totalRevenue": __("Revenue", "google-analytics-for-wordpress"),
        "bounceRate": __("Bounce Rate", "google-analytics-for-wordpress"),
        "averageSessionDuration": __("Avg Session Duration", "google-analytics-for-wordpress"),
        "newUsers": __("New Users", "google-analytics-for-wordpress"),
        "transactions": __("Purchases", "google-analytics-for-wordpress")
      };
      return supportedMetrics.map((metric) => ({
        value: metric,
        label: metricLabels[metric] || metric,
        disabled: false
        // TODO: Add logic for pro metrics if needed
      }));
    });
    function isMetricSelected(metricValue) {
      return selectedMetrics.value.includes(metricValue);
    }
    function selectMetric(metricValue) {
      selectedMetrics.value = [metricValue];
    }
    function toggleMetric(metricValue) {
      const index = selectedMetrics.value.indexOf(metricValue);
      if (index > -1) {
        selectedMetrics.value.splice(index, 1);
      } else {
        selectedMetrics.value.push(metricValue);
      }
    }
    function handleCancel() {
      emit("close");
    }
    function handleApply() {
      emit("apply", {
        widgetId: props.widget.id,
        metrics: selectedMetrics.value
      });
      emit("close");
    }
    return (_ctx, _cache) => {
      return openBlock(), createBlock(Teleport, { to: "body" }, [
        createVNode(Transition, { name: "modal-fade" }, {
          default: withCtx(() => [
            __props.isOpen ? (openBlock(), createElementBlock("div", {
              key: 0,
              class: "monsterinsights-modal-overlay",
              onClick: withModifiers(handleCancel, ["self"])
            }, [
              createBaseVNode("div", _hoisted_1$2, [
                createBaseVNode("div", _hoisted_2$2, [
                  createBaseVNode("button", {
                    class: "monsterinsights-modal-back",
                    onClick: handleCancel,
                    "aria-label": unref(__)("Back", "google-analytics-for-wordpress")
                  }, [
                    createVNode(Icon, {
                      name: "arrow-left",
                      size: 16
                    })
                  ], 8, _hoisted_3$2),
                  createBaseVNode("h3", null, toDisplayString(unref(__)("Customize Metrics", "google-analytics-for-wordpress")), 1),
                  createBaseVNode("button", {
                    class: "monsterinsights-modal-close",
                    onClick: handleCancel,
                    "aria-label": unref(__)("Close", "google-analytics-for-wordpress")
                  }, [
                    createVNode(Icon, {
                      name: "close",
                      size: 16
                    })
                  ], 8, _hoisted_4$2)
                ]),
                _cache[0] || (_cache[0] = createBaseVNode("div", { class: "monsterinsights-modal-divider" }, null, -1)),
                createBaseVNode("div", _hoisted_5$1, [
                  isSingleSelection.value ? (openBlock(true), createElementBlock(Fragment, { key: 0 }, renderList(availableMetrics.value, (metric) => {
                    return openBlock(), createElementBlock("div", {
                      key: metric.value,
                      class: normalizeClass(["monsterinsights-metric-option", { "monsterinsights-metric-option--disabled": metric.disabled }])
                    }, [
                      createBaseVNode("label", _hoisted_6$1, [
                        createBaseVNode("input", {
                          type: "radio",
                          value: metric.value,
                          checked: isMetricSelected(metric.value),
                          disabled: metric.disabled,
                          onChange: ($event) => selectMetric(metric.value),
                          class: "monsterinsights-radio",
                          name: "metric-selection"
                        }, null, 40, _hoisted_7$1),
                        createBaseVNode("span", _hoisted_8$1, toDisplayString(metric.label), 1)
                      ])
                    ], 2);
                  }), 128)) : (openBlock(true), createElementBlock(Fragment, { key: 1 }, renderList(availableMetrics.value, (metric) => {
                    return openBlock(), createElementBlock("div", {
                      key: metric.value,
                      class: normalizeClass(["monsterinsights-metric-option", { "monsterinsights-metric-option--disabled": metric.disabled }])
                    }, [
                      createBaseVNode("label", _hoisted_9$1, [
                        createBaseVNode("input", {
                          type: "checkbox",
                          value: metric.value,
                          checked: isMetricSelected(metric.value),
                          disabled: metric.disabled,
                          onChange: ($event) => toggleMetric(metric.value),
                          class: "monsterinsights-checkbox"
                        }, null, 40, _hoisted_10$1),
                        createBaseVNode("span", _hoisted_11, toDisplayString(metric.label), 1)
                      ])
                    ], 2);
                  }), 128))
                ]),
                createBaseVNode("div", _hoisted_12, [
                  createBaseVNode("button", {
                    class: "monsterinsights-button monsterinsights-button--secondary",
                    onClick: handleCancel
                  }, toDisplayString(unref(__)("Cancel", "google-analytics-for-wordpress")), 1),
                  createBaseVNode("button", {
                    class: "monsterinsights-button monsterinsights-button--primary",
                    onClick: handleApply
                  }, toDisplayString(unref(__)("Apply", "google-analytics-for-wordpress")), 1)
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
const EditMetricsModal = /* @__PURE__ */ _export_sfc(_sfc_main$2, [["__scopeId", "data-v-b0b3aae7"]]);
const _hoisted_1$1 = { class: "monsterinsights-modal-content" };
const _hoisted_2$1 = { class: "monsterinsights-modal-header" };
const _hoisted_3$1 = ["aria-label"];
const _hoisted_4$1 = ["aria-label"];
const _hoisted_5 = { class: "monsterinsights-modal-body" };
const _hoisted_6 = { class: "monsterinsights-modal-description" };
const _hoisted_7 = { class: "monsterinsights-radio-label" };
const _hoisted_8 = ["value", "checked", "onChange"];
const _hoisted_9 = { class: "monsterinsights-radio-text" };
const _hoisted_10 = { class: "monsterinsights-modal-footer" };
const _sfc_main$1 = {
  __name: "EditDimensionsModal",
  props: {
    isOpen: {
      type: Boolean,
      default: false
    },
    widget: {
      type: Object,
      default: null
    },
    widgetMetadata: {
      type: Object,
      default: null
    }
  },
  emits: ["close", "apply"],
  setup(__props, { emit: __emit }) {
    const props = __props;
    const emit = __emit;
    const selectedDimension = ref("");
    watch(() => props.widget, (newWidget) => {
      var _a, _b;
      if (newWidget && newWidget.dimensions && newWidget.dimensions.length > 0) {
        selectedDimension.value = newWidget.dimensions[0];
      } else if ((_b = (_a = props.widgetMetadata) == null ? void 0 : _a.defaults) == null ? void 0 : _b.dimensions) {
        selectedDimension.value = props.widgetMetadata.defaults.dimensions[0];
      }
    }, { immediate: true });
    const availableDimensions = computed(() => {
      var _a, _b;
      if (!props.widgetMetadata) return [];
      const displayType = ((_a = props.widget) == null ? void 0 : _a.displayType) || ((_b = props.widgetMetadata.defaults) == null ? void 0 : _b.type) || "table";
      const typeSupport = getWidgetSupportForType(props.widgetMetadata.support, displayType);
      const supportedDimensions = typeSupport.dimensions || [];
      const dimensionLabels = {
        "sessionSource": __("Source", "google-analytics-for-wordpress"),
        "sessionMedium": __("Medium", "google-analytics-for-wordpress"),
        "sessionDefaultChannelGrouping": __("Channel Grouping", "google-analytics-for-wordpress"),
        "country": __("Country", "google-analytics-for-wordpress"),
        "city": __("City", "google-analytics-for-wordpress"),
        "region": __("Region", "google-analytics-for-wordpress"),
        "deviceCategory": __("Device Category", "google-analytics-for-wordpress"),
        "browser": __("Browser", "google-analytics-for-wordpress"),
        "operatingSystem": __("Operating System", "google-analytics-for-wordpress"),
        "pagePath": __("Page Path", "google-analytics-for-wordpress"),
        "pageTitle": __("Page Title", "google-analytics-for-wordpress"),
        "landingPage": __("Landing Page", "google-analytics-for-wordpress"),
        "eventName": __("Event Name", "google-analytics-for-wordpress"),
        "date": __("Date", "google-analytics-for-wordpress"),
        // SEO Score dimensions
        "customEvent:seo_score": __("SEO Score (Generic)", "google-analytics-for-wordpress"),
        "customEvent:aioseo_truseo_score": __("All in One SEO (TruSEO Score)", "google-analytics-for-wordpress"),
        "customEvent:yoast_seo_score": __("Yoast SEO Score", "google-analytics-for-wordpress"),
        "customEvent:rankmath_seo_score": __("Rank Math SEO Score", "google-analytics-for-wordpress")
      };
      return supportedDimensions.map((dim) => ({
        value: dim,
        label: dimensionLabels[dim] || dim
      }));
    });
    function selectDimension(dimension) {
      selectedDimension.value = dimension;
    }
    function handleCancel() {
      emit("close");
    }
    function handleApply() {
      emit("apply", [selectedDimension.value]);
      emit("close");
    }
    return (_ctx, _cache) => {
      return openBlock(), createBlock(Teleport, { to: "body" }, [
        createVNode(Transition, { name: "modal-fade" }, {
          default: withCtx(() => [
            __props.isOpen ? (openBlock(), createElementBlock("div", {
              key: 0,
              class: "monsterinsights-modal-overlay",
              onClick: withModifiers(handleCancel, ["self"])
            }, [
              createBaseVNode("div", _hoisted_1$1, [
                createBaseVNode("div", _hoisted_2$1, [
                  createBaseVNode("button", {
                    class: "monsterinsights-modal-back",
                    onClick: handleCancel,
                    "aria-label": unref(__)("Back", "google-analytics-for-wordpress")
                  }, [
                    createVNode(Icon, {
                      name: "arrow-left",
                      size: 16
                    })
                  ], 8, _hoisted_3$1),
                  createBaseVNode("h3", null, toDisplayString(unref(__)("Customize Breakdown", "google-analytics-for-wordpress")), 1),
                  createBaseVNode("button", {
                    class: "monsterinsights-modal-close",
                    onClick: handleCancel,
                    "aria-label": unref(__)("Close", "google-analytics-for-wordpress")
                  }, [
                    createVNode(Icon, {
                      name: "close",
                      size: 16
                    })
                  ], 8, _hoisted_4$1)
                ]),
                _cache[0] || (_cache[0] = createBaseVNode("div", { class: "monsterinsights-modal-divider" }, null, -1)),
                createBaseVNode("div", _hoisted_5, [
                  createBaseVNode("p", _hoisted_6, toDisplayString(unref(__)("Select how you want to break down your data:", "google-analytics-for-wordpress")), 1),
                  (openBlock(true), createElementBlock(Fragment, null, renderList(availableDimensions.value, (dimension) => {
                    return openBlock(), createElementBlock("div", {
                      key: dimension.value,
                      class: "monsterinsights-dimension-option"
                    }, [
                      createBaseVNode("label", _hoisted_7, [
                        createBaseVNode("input", {
                          type: "radio",
                          value: dimension.value,
                          checked: selectedDimension.value === dimension.value,
                          onChange: ($event) => selectDimension(dimension.value),
                          class: "monsterinsights-radio",
                          name: "dimension"
                        }, null, 40, _hoisted_8),
                        createBaseVNode("span", _hoisted_9, toDisplayString(dimension.label), 1)
                      ])
                    ]);
                  }), 128))
                ]),
                createBaseVNode("div", _hoisted_10, [
                  createBaseVNode("button", {
                    class: "monsterinsights-button monsterinsights-button--secondary",
                    onClick: handleCancel
                  }, toDisplayString(unref(__)("Cancel", "google-analytics-for-wordpress")), 1),
                  createBaseVNode("button", {
                    class: "monsterinsights-button monsterinsights-button--primary",
                    onClick: handleApply
                  }, toDisplayString(unref(__)("Apply", "google-analytics-for-wordpress")), 1)
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
const EditDimensionsModal = /* @__PURE__ */ _export_sfc(_sfc_main$1, [["__scopeId", "data-v-78081b3f"]]);
const _hoisted_1 = { class: "monsterinsights-dashboard-create" };
const _hoisted_2 = { class: "monsterinsights-page-header" };
const _hoisted_3 = ["title"];
const _hoisted_4 = {
  key: 0,
  class: "monsterinsights-saving-overlay"
};
const _sfc_main = {
  __name: "DashboardCreate",
  setup(__props) {
    const router = useRouter();
    const route = useRoute();
    const store = useCustomViewsStore();
    const {
      hasAccess,
      isSampleMode,
      shouldBlurContent,
      shouldShowUpsell,
      upsellContent,
      hasSampleData,
      openUpsellModal,
      closeUpsellModal,
      enableSampleMode
    } = useFeatureGate("custom-dashboard");
    const {
      isAuthenticated,
      showAuthModal,
      showReAuthModal,
      shouldBlurContent: shouldBlurForAuth,
      openAuthModal,
      closeAuthModal
    } = useAuthGate();
    const { sampleData, loadSampleData } = useSampleData("custom-dashboard", "widgets-data");
    const { sampleData: sampleViewData, loadSampleData: loadSampleView } = useSampleData("custom-dashboard", "sample-view");
    const isDirty = ref(false);
    const autoSaveStatus = ref("saved");
    const widgets = reactive([]);
    const dateRange = reactive(getDefaultDateRange());
    watch(
      widgets,
      () => {
        isDirty.value = true;
        autoSaveStatus.value = "unsaved";
        debounceSave();
      },
      { deep: true }
    );
    let debounceTimer = null;
    const debounceSave = () => {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => {
        saveView();
      }, 100);
    };
    function handleWidgetsUpdate(newWidgets) {
      widgets.length = 0;
      widgets.push(...newWidgets);
    }
    const widgetData = reactive({});
    const widgetLoadingStates = reactive({});
    const currentView = computed(() => {
      var _a;
      if (isSampleMode.value && ((_a = sampleViewData.value) == null ? void 0 : _a[0])) {
        return sampleViewData.value[0];
      }
      return store.currentView;
    });
    const allViews = computed(() => {
      if (isSampleMode.value && sampleViewData.value) {
        return sampleViewData.value;
      }
      return store.allViews;
    });
    const displayWidgetData = computed(() => {
      var _a;
      if (isSampleMode.value && ((_a = sampleData.value) == null ? void 0 : _a.widgets)) {
        return sampleData.value.widgets;
      }
      return widgetData;
    });
    const dateRangeModel = computed({
      get() {
        return dateRange;
      },
      set(value) {
        Object.assign(dateRange, value);
      }
    });
    const isAnyWidgetLoading = computed(() => store.isLoading);
    onMounted(async () => {
      if (!isAuthenticated.value) {
        openAuthModal();
        return;
      }
      if (!hasAccess.value) {
        openUpsellModal();
        await Promise.all([
          loadSampleData(),
          loadSampleView(),
          store.loadWidgetMetadata()
          // Load widget metadata for sidebar
        ]);
        return;
      }
      store.setLoading(true);
      try {
        await Promise.all([
          store.loadViews(),
          store.loadWidgetMetadata()
        ]);
        await loadDashboard(route.params.id);
      } catch (err) {
        console.error("Error during initial load:", err);
        store.setLoading(false);
      }
    });
    async function handleSeeSample() {
      var _a, _b;
      enableSampleMode();
      if ((_b = (_a = sampleViewData.value) == null ? void 0 : _a[0]) == null ? void 0 : _b.layout) {
        widgets.length = 0;
        const sortedLayout = [...sampleViewData.value[0].layout].sort(
          (a, b) => a.position.y * 3 + a.position.x - (b.position.y * 3 + b.position.x)
        );
        widgets.push(...sortedLayout);
      }
    }
    watch(() => route.params.id, (newId, oldId) => {
      if (newId !== oldId) {
        loadDashboard(newId);
      }
    });
    async function loadDashboard(viewId) {
      var _a, _b;
      if (!hasAccess.value) {
        return;
      }
      store.setLoading(true);
      try {
        widgets.length = 0;
        Object.keys(widgetData).forEach((key) => delete widgetData[key]);
        Object.keys(widgetLoadingStates).forEach((key) => delete widgetLoadingStates[key]);
        if (viewId) {
          await store.loadViewForEdit(viewId);
          if ((_b = (_a = store.currentView) == null ? void 0 : _a.layout) == null ? void 0 : _b.length) {
            const sortedLayout = [...store.currentView.layout].sort(
              (a, b) => a.position.y * 3 + a.position.x - (b.position.y * 3 + b.position.x)
            );
            widgets.push(...sortedLayout);
            await fetchAllWidgetsData();
          } else {
            store.setLoading(false);
          }
        } else {
          const templateId = route.query.template;
          const title = templateId ? getTemplateTitle(templateId) : "";
          store.createNewView(title);
          store.setLoading(false);
        }
      } catch (err) {
        console.error("Error loading dashboard:", err);
        store.setLoading(false);
      }
    }
    onBeforeUnmount(() => {
      if (isDirty.value) ;
    });
    function getTemplateTitle(templateId) {
      const templates = {
        "blank": __("Blank Dashboard", "google-analytics-for-wordpress"),
        "ecommerce": __("eCommerce Dashboard", "google-analytics-for-wordpress"),
        "small-business": __("Small Business Dashboard", "google-analytics-for-wordpress"),
        "publisher": __("Publisher Dashboard", "google-analytics-for-wordpress"),
        "marketer": __("Marketer Dashboard", "google-analytics-for-wordpress")
      };
      return templates[templateId] || __("My Custom View", "google-analytics-for-wordpress");
    }
    async function onWidgetGridChange(event) {
      if (event.added) {
        const newWidget = event.added.element;
        if (newWidget) {
          await fetchWidgetData(newWidget);
        }
      }
      isDirty.value = true;
      debounceSave();
    }
    async function fetchAllWidgetsData() {
      var _a, _b;
      if (!widgets.length) {
        store.setLoading(false);
        return;
      }
      const BATCH_SIZE = 5;
      const batches = [];
      for (let i = 0; i < widgets.length; i += BATCH_SIZE) {
        batches.push(widgets.slice(i, i + BATCH_SIZE));
      }
      store.setLoading(true);
      widgets.forEach((widget) => {
        if (widget && widget.id) {
          widgetLoadingStates[widget.id] = true;
        }
      });
      for (let batchIndex = 0; batchIndex < batches.length; batchIndex++) {
        const batch = batches[batchIndex];
        try {
          const response = await customDashboardAPI.getDashboardData(batch, dateRange);
          const widgetsData = (response == null ? void 0 : response.widgets) || ((_a = response == null ? void 0 : response.data) == null ? void 0 : _a.widgets);
          const responseDateRange = ((_b = response == null ? void 0 : response.data) == null ? void 0 : _b.date_range) || (response == null ? void 0 : response.date_range);
          if (widgetsData) {
            Object.keys(widgetsData).forEach((widgetId) => {
              widgetData[widgetId] = {
                ...widgetsData[widgetId],
                dateRange: responseDateRange ? {
                  current: {
                    start: responseDateRange.start,
                    end: responseDateRange.end
                  },
                  previous: {
                    start: responseDateRange.compareStart || "",
                    end: responseDateRange.compareEnd || ""
                  }
                } : null
              };
            });
          } else {
          }
        } catch (error) {
          console.error(`Error fetching batch ${batchIndex + 1}:`, error);
          batch.forEach((widget) => {
            if (widget && widget.id) {
              widgetData[widget.id] = { error: true, message: error.message };
            }
          });
        } finally {
          batch.forEach((widget) => {
            if (widget && widget.id) {
              widgetLoadingStates[widget.id] = false;
            }
          });
        }
        if (batchIndex < batches.length - 1) {
          await new Promise((resolve) => setTimeout(resolve, 300));
        }
      }
      store.setLoading(false);
    }
    async function fetchWidgetData(widget) {
      var _a, _b;
      if (!widget || !widget.id) return;
      store.setLoading(true);
      widgetLoadingStates[widget.id] = true;
      try {
        const response = await customDashboardAPI.getDashboardData([widget], dateRange);
        const widgetsData = (response == null ? void 0 : response.widgets) || ((_a = response == null ? void 0 : response.data) == null ? void 0 : _a.widgets);
        const responseDateRange = ((_b = response == null ? void 0 : response.data) == null ? void 0 : _b.date_range) || (response == null ? void 0 : response.date_range);
        if (widgetsData && widgetsData[widget.id]) {
          widgetData[widget.id] = {
            ...widgetsData[widget.id],
            dateRange: responseDateRange ? {
              current: {
                start: responseDateRange.start,
                end: responseDateRange.end
              },
              previous: {
                start: responseDateRange.compareStart || "",
                end: responseDateRange.compareEnd || ""
              }
            } : null
          };
        }
      } catch (error) {
        console.error(`Error fetching data for widget ${widget.id}:`, error);
        widgetData[widget.id] = { error: true, message: error.message };
      } finally {
        widgetLoadingStates[widget.id] = false;
        store.setLoading(false);
      }
    }
    function getDefaultDateRange() {
      const end = /* @__PURE__ */ new Date();
      const start = /* @__PURE__ */ new Date();
      start.setDate(start.getDate() - 30);
      return {
        start: start.toISOString().split("T")[0],
        end: end.toISOString().split("T")[0],
        compareStart: "",
        compareEnd: "",
        interval: "last30days",
        compareReport: false,
        text: "",
        compareText: "",
        intervalText: "",
        intervalCompareText: ""
      };
    }
    async function handleDateChanged() {
      await fetchAllWidgetsData();
    }
    function removeWidget(widgetId) {
      const widgetIndex = widgets.findIndex((widget) => (widget == null ? void 0 : widget.id) === widgetId);
      if (widgetIndex !== -1) {
        widgets.splice(widgetIndex, 1);
        delete widgetData[widgetId];
        delete widgetLoadingStates[widgetId];
        isDirty.value = true;
      }
    }
    const isEditMetricsModalOpen = ref(false);
    const selectedWidgetForEdit = ref(null);
    const selectedWidgetMetadata = computed(() => {
      if (!selectedWidgetForEdit.value) return null;
      return store.getWidgetByType(selectedWidgetForEdit.value.type);
    });
    function configureWidget(widgetId) {
      const widget = widgets.find((w) => (w == null ? void 0 : w.id) === widgetId);
      if (widget) {
        selectedWidgetForEdit.value = widget;
        isEditMetricsModalOpen.value = true;
      }
    }
    function closeEditMetricsModal() {
      isEditMetricsModalOpen.value = false;
      selectedWidgetForEdit.value = null;
    }
    function handleApplyMetrics({ widgetId, metrics }) {
      const widgetIndex = widgets.findIndex((widget) => (widget == null ? void 0 : widget.id) === widgetId);
      if (widgetIndex !== -1 && widgets[widgetIndex]) {
        widgets[widgetIndex].metrics = metrics;
        isDirty.value = true;
        debounceSave();
        fetchWidgetData(widgets[widgetIndex]);
      }
    }
    const isEditDimensionsModalOpen = ref(false);
    function configureDimensions(widgetId) {
      const widget = widgets.find((w) => (w == null ? void 0 : w.id) === widgetId);
      if (widget) {
        selectedWidgetForEdit.value = widget;
        isEditDimensionsModalOpen.value = true;
      }
    }
    function closeEditDimensionsModal() {
      isEditDimensionsModalOpen.value = false;
      selectedWidgetForEdit.value = null;
    }
    function handleApplyDimensions(dimensions) {
      if (!selectedWidgetForEdit.value) return;
      const widgetIndex = widgets.findIndex((widget) => (widget == null ? void 0 : widget.id) === selectedWidgetForEdit.value.id);
      if (widgetIndex !== -1 && widgets[widgetIndex]) {
        widgets[widgetIndex].dimensions = dimensions;
        isDirty.value = true;
        debounceSave();
        fetchWidgetData(widgets[widgetIndex]);
      }
    }
    function handleToggleChart({ widgetId, chartType }) {
      const widgetIndex = widgets.findIndex((widget) => (widget == null ? void 0 : widget.id) === widgetId);
      if (widgetIndex !== -1 && widgets[widgetIndex]) {
        widgets[widgetIndex].displayType = chartType;
        if (!widgets[widgetIndex].position) {
          widgets[widgetIndex].position = { x: 0, y: 0, w: 1 };
        }
        isDirty.value = true;
        debounceSave();
        fetchWidgetData(widgets[widgetIndex]);
      }
    }
    function handleWidgetResize({ widgetId, width }) {
      const widgetIndex = widgets.findIndex((widget) => (widget == null ? void 0 : widget.id) === widgetId);
      if (widgetIndex !== -1 && widgets[widgetIndex]) {
        if (!widgets[widgetIndex].position) {
          widgets[widgetIndex].position = { x: 0, y: 0, w: 1 };
        }
        widgets[widgetIndex].position.w = width;
        isDirty.value = true;
        debounceSave();
      }
    }
    function handleToggleExtendedView(widgetId) {
      const widgetIndex = widgets.findIndex((widget) => (widget == null ? void 0 : widget.id) === widgetId);
      if (widgetIndex !== -1 && widgets[widgetIndex]) {
        widgets[widgetIndex].extendedView = !widgets[widgetIndex].extendedView;
        isDirty.value = true;
        debounceSave();
      }
    }
    function handleToggleComparison(widgetId) {
      const widgetIndex = widgets.findIndex((widget) => (widget == null ? void 0 : widget.id) === widgetId);
      if (widgetIndex !== -1 && widgets[widgetIndex]) {
        widgets[widgetIndex].compare = !widgets[widgetIndex].compare;
        isDirty.value = true;
        debounceSave();
        fetchWidgetData(widgets[widgetIndex]);
      }
    }
    function handleRenameWidget({ widgetId, title }) {
      const widgetIndex = widgets.findIndex((widget) => (widget == null ? void 0 : widget.id) === widgetId);
      if (widgetIndex !== -1 && widgets[widgetIndex]) {
        widgets[widgetIndex].title = title;
        isDirty.value = true;
        debounceSave();
      }
    }
    async function saveView() {
      var _a;
      if (!hasAccess.value || !store.currentView) {
        return;
      }
      autoSaveStatus.value = "saving";
      try {
        const layout = widgets.map((widget, index) => {
          var _a2;
          if (!widget) return null;
          const width = ((_a2 = widget.position) == null ? void 0 : _a2.w) || 1;
          return {
            ...widget,
            position: {
              x: index % 3,
              // Assuming 3 columns
              y: Math.floor(index / 3),
              w: width
              // Preserve widget width only, height is determined by widget type
            }
          };
        }).filter(Boolean);
        store.currentView.layout = layout;
        await store.saveCurrentView();
        isDirty.value = false;
        autoSaveStatus.value = "saved";
        if (route.name === "dashboard-create" && ((_a = store.currentView) == null ? void 0 : _a.id)) {
          router.push({
            name: "dashboard-edit",
            params: { id: store.currentView.id }
          });
        }
      } catch (err) {
        console.error("Error saving view:", err);
        autoSaveStatus.value = "error";
      }
    }
    async function handleRenameView({ name }) {
      if (store.currentView) {
        store.currentView.title = name;
        isDirty.value = true;
        await saveView();
      }
    }
    function selectView(viewId) {
      if (viewId === "new") {
        router.push({ name: "dashboard-create" });
      } else {
        router.push({ name: "dashboard-view", params: { id: viewId } });
      }
    }
    function addNewView() {
      if (!hasAccess.value) {
        openUpsellModal();
        return;
      }
      router.push({ name: "dashboard-add" });
    }
    async function handleDeleteView(id) {
      try {
        await store.deleteView(id);
        const remainingViews = store.allViews;
        const baseUrl = window.monsterinsights.custom_dashboard_url;
        if (remainingViews.length > 0) {
          window.location.href = `${baseUrl}#/dashboards/edit/${remainingViews[0].id}`;
        } else {
          window.location.href = `${baseUrl}#/`;
        }
      } catch (err) {
        console.error("Error deleting view:", err);
      }
    }
    return (_ctx, _cache) => {
      var _a, _b;
      return openBlock(), createElementBlock("div", _hoisted_1, [
        unref(isSampleMode) ? (openBlock(), createBlock(_sfc_main$8, {
          key: 0,
          feature: "custom-dashboard"
        })) : createCommentVNode("", true),
        createVNode(ViewNavigation, {
          "all-views": allViews.value,
          "current-view": currentView.value,
          "auto-save-status": autoSaveStatus.value,
          "is-new-view": !unref(route).params.id,
          "allow-reorder": true,
          onSelect: selectView,
          onRename: handleRenameView,
          onDelete: handleDeleteView,
          onAddNew: addNewView
        }, null, 8, ["all-views", "current-view", "auto-save-status", "is-new-view"]),
        createBaseVNode("div", {
          class: normalizeClass(["monsterinsights-dashboard-main-content", { "monsterinsights-dashboard-main-content--saving": autoSaveStatus.value === "saving" }])
        }, [
          createBaseVNode("div", {
            class: normalizeClass(["monsterinsights-dashboard-main", { "monsterinsights-content-blurred": unref(shouldBlurContent) || unref(shouldBlurForAuth) }])
          }, [
            createBaseVNode("div", _hoisted_2, [
              createBaseVNode("h1", null, toDisplayString(((_a = currentView.value) == null ? void 0 : _a.title) || unref(__)("New Dashboard", "google-analytics-for-wordpress")), 1),
              createBaseVNode("div", {
                class: normalizeClass(["monsterinsights-page-header__actions", { "monsterinsights-page-header__actions--disabled": isAnyWidgetLoading.value }]),
                title: isAnyWidgetLoading.value ? unref(__)("Please wait while data is loading...", "google-analytics-for-wordpress") : "",
                "data-html2canvas-ignore": "true"
              }, [
                createVNode(_sfc_main$5, {
                  "report-title": (_b = currentView.value) == null ? void 0 : _b.title,
                  disabled: isAnyWidgetLoading.value
                }, null, 8, ["report-title", "disabled"]),
                createVNode(unref(_sfc_main$6), {
                  modelValue: dateRangeModel.value,
                  "onUpdate:modelValue": _cache[0] || (_cache[0] = ($event) => dateRangeModel.value = $event),
                  disabled: isAnyWidgetLoading.value,
                  onDateChanged: handleDateChanged
                }, null, 8, ["modelValue", "disabled"])
              ], 10, _hoisted_3)
            ]),
            createVNode(_sfc_main$7, {
              ref: "widgetsGridRef",
              widgets,
              "widget-data": displayWidgetData.value,
              "widget-loading-states": widgetLoadingStates,
              "is-draggable": autoSaveStatus.value !== "saving",
              "onUpdate:widgets": handleWidgetsUpdate,
              onChange: onWidgetGridChange,
              onEnd: debounceSave,
              onRemove: removeWidget,
              onConfigure: configureWidget,
              onEditDimensions: configureDimensions,
              onToggleChart: handleToggleChart,
              onResize: handleWidgetResize,
              onToggleExtendedView: handleToggleExtendedView,
              onToggleComparison: handleToggleComparison,
              onRename: handleRenameWidget
            }, null, 8, ["widgets", "widget-data", "widget-loading-states", "is-draggable"])
          ], 2),
          createVNode(_sfc_main$3),
          autoSaveStatus.value === "saving" ? (openBlock(), createElementBlock("div", _hoisted_4, [..._cache[1] || (_cache[1] = [
            createBaseVNode("span", { class: "monsterinsights-saving-spinner" }, null, -1)
          ])])) : createCommentVNode("", true)
        ], 2),
        createVNode(AuthModal, {
          isOpen: unref(showAuthModal),
          onClose: unref(closeAuthModal)
        }, null, 8, ["isOpen", "onClose"]),
        createVNode(ReAuthModal, {
          isOpen: unref(showReAuthModal),
          onClose: unref(closeAuthModal)
        }, null, 8, ["isOpen", "onClose"]),
        createVNode(UpsellModal, {
          isOpen: unref(shouldShowUpsell),
          feature: "custom-dashboard",
          content: unref(upsellContent),
          showSampleButton: unref(hasSampleData),
          customImage: "sample-image-monsterinsights.png",
          onClose: unref(closeUpsellModal),
          onSeeSample: handleSeeSample
        }, null, 8, ["isOpen", "content", "showSampleButton", "onClose"]),
        createVNode(EditMetricsModal, {
          "is-open": isEditMetricsModalOpen.value,
          widget: selectedWidgetForEdit.value,
          "widget-metadata": selectedWidgetMetadata.value,
          onClose: closeEditMetricsModal,
          onApply: handleApplyMetrics
        }, null, 8, ["is-open", "widget", "widget-metadata"]),
        createVNode(EditDimensionsModal, {
          "is-open": isEditDimensionsModalOpen.value,
          widget: selectedWidgetForEdit.value,
          "widget-metadata": selectedWidgetMetadata.value,
          onClose: closeEditDimensionsModal,
          onApply: handleApplyDimensions
        }, null, 8, ["is-open", "widget", "widget-metadata"])
      ]);
    };
  }
};
export {
  _sfc_main as default
};
