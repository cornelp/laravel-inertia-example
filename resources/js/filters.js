import Vue from "vue";
import dayjs from "dayjs";

Vue.filter("fullDate", item => item && dayjs(item).format("DD.MM.YYYY"));

Vue.filter(
    "fullDateTime",
    item => item && dayjs(item).format("DD.MM.YYYY HH:mm:ss")
);

Vue.filter("float", item => parseFloat(item).toFixed(2));
Vue.filter("integer", item => parseInt(item));
Vue.filter("status", item => (item ? "Da" : "Nu"));
