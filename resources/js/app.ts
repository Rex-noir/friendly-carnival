import "./bootstrap";
import { DefineComponent, createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import MainLayout from "./Layout/MainLayout.vue";
import PrimeVue from "primevue/config";
import Aura from "./presets/aura";

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        const page = (await pages[`./Pages/${name}.vue`]) as DefineComponent;
        page.default.layout = page.default.layout || MainLayout;

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                unstyled: true,
                pt: Aura,
            })
            .mount(el);
    },
});
