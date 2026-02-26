import { o as onMounted, c as createElementBlock, a as openBlock, b as createVNode, u as unref, d as useRouter } from "../custom-dashboard.js";
import { u as useFeatureGate, a as useSampleData, U as UpsellModal } from "./useSampleData-WWO8wHOx.js";
const _hoisted_1 = { class: "monsterinsights-dashboard-list" };
const _sfc_main = {
  __name: "DashboardList.lite",
  setup(__props) {
    const router = useRouter();
    const {
      shouldShowUpsell,
      upsellContent,
      hasSampleData,
      openUpsellModal,
      closeUpsellModal,
      enableSampleMode
    } = useFeatureGate("custom-dashboard");
    const { sampleData: sampleViewData, loadSampleData: loadSampleView } = useSampleData("custom-dashboard", "sample-view");
    onMounted(async () => {
      await loadSampleView();
      openUpsellModal();
    });
    async function handleSeeSample() {
      var _a, _b;
      if (!sampleViewData.value) {
        await loadSampleView();
      }
      enableSampleMode();
      if ((_b = (_a = sampleViewData.value) == null ? void 0 : _a[0]) == null ? void 0 : _b.id) {
        router.push({
          name: "dashboard-view",
          params: { id: sampleViewData.value[0].id }
        });
      }
    }
    return (_ctx, _cache) => {
      return openBlock(), createElementBlock("div", _hoisted_1, [
        createVNode(UpsellModal, {
          isOpen: unref(shouldShowUpsell),
          feature: "custom-dashboard",
          content: unref(upsellContent),
          showSampleButton: unref(hasSampleData),
          customImage: "sample-image-monsterinsights.png",
          onClose: unref(closeUpsellModal),
          onSeeSample: handleSeeSample
        }, null, 8, ["isOpen", "content", "showSampleButton", "onClose"])
      ]);
    };
  }
};
export {
  _sfc_main as default
};
