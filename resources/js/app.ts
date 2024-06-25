import "./bootstrap";
import { DefineComponent, createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import MainLayout from "./Layout/MainLayout.vue";
import PrimeVue from "primevue/config";
import Aura from "./presets/aura";
import Ripple from "primevue/ripple";

import AuthLayout from "./Layout/AuthLayout.vue";
import ripple from "./presets/aura/ripple";

const layoutMap = {
    "Auth/": AuthLayout,
};

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        const page = (await pages[`./Pages/${name}.vue`]) as DefineComponent;

        for (const [prefix, layout] of Object.entries(layoutMap)) {
            if (name.startsWith(prefix)) {
                page.default.layout = layout;
                return page;
            }
        }

        page.default.layout = MainLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                unstyled: true,
                pt: Aura,
                ripple: true,
            })
            .directive("ripple", Ripple)
            .mount(el);
    },
});
