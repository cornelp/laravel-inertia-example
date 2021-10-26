// src/plugins/vuetify.js

import Vue from "vue";
import Vuetify from "vuetify";
import ro from "vuetify/lib/locale/ro";
import "@mdi/font/css/materialdesignicons.css"; // Ensure you are using css-loader

Vue.use(Vuetify);

const opts = {
    lang: {
        locales: { ro },
        current: "ro"
    }
};

export default new Vuetify(opts);
