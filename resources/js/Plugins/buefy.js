import Vue from "vue";
import Buefy from "buefy";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

Vue.component("vue-fontawesome", FontAwesomeIcon);

Vue.use(Buefy, {
    defaultIconComponent: "vue-fontawesome",
    defaultIconPack: "fas"
});
