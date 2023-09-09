import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { createPinia } from "pinia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"

const appName = import.meta.env.VITE_APP_NAME || "BackOffice";
const pinia = createPinia();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    // resolve: (name) =>
    //     resolvePageComponent(
    //         `./Pages/${name}.vue`,
    //         import.meta.glob("./Pages/**/*.vue"),
    //     ),
    resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
      const page = pages[`./Pages/${name}.vue`];
      // page.default.layout = page.default.layout || App
      if (name.startsWith('Auth/')){
          page.default.layout ??= '';
    }else{
          page.default.layout ??= AuthenticatedLayout;
      }
      return page;
  },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component("Head", Head)
            .component("Link", Link)
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
