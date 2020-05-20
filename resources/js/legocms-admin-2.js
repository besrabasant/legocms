import Turbolinks from 'turbolinks';
import Vue from "vue";
import Vuex from 'vuex';
import TurbolinksAdapter from 'vue-turbolinks';
import dd from "./utils/dd";
import LegoCMSApp from "./legocms/LegoCMS";

Vue.use(Vuex);
Vue.use(TurbolinksAdapter);

window.Turbolinks = Turbolinks;
window.Vue = Vue;
window.LegoCMS = new LegoCMSApp();
window.dd = dd;

require("./legocms/components");

(() => {
    Turbolinks.start();
    Turbolinks.setProgressBarDelay(100);
    LegoCMS.boot();
})();