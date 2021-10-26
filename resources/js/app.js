import Vue from "vue";
import dayjs from "dayjs";
import { createInertiaApp } from "@inertiajs/inertia-vue";
import { InertiaProgress } from "@inertiajs/progress";
import vuetify from "./Plugins/vuetify";

Vue.component("date-picker", require("./Components/DatePicker.vue").default);
Vue.component("delete-modal", require("./Components/DeleteModal.vue").default);
Vue.component(
    "range-date-picker",
    require("./Components/RangeDatePicker.vue").default
);

require("./filters");
require("./Plugins/dayjs");

InertiaProgress.init();

Object.defineProperties(Vue.prototype, {
    $date: {
        get() {
            return dayjs;
        }
    }
});

createInertiaApp({
    resolve: name => {
        return require(`./Pages/${name}`);
    },
    setup({ el, app, props }) {
        new Vue({
            render: h => h(app, props),
            vuetify
        }).$mount(el);
    }
});
