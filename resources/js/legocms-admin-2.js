import Turbolinks from 'turbolinks';
import Vue from "vue";
import TurbolinksAdapter from 'vue-turbolinks';
import dd from "./utils/dd";
import LegoCMSApp from "./legocms/LegoCMS";

Vue.use(TurbolinksAdapter);

window.Turbolinks = Turbolinks;
window.Vue = Vue;
window.LegoCMS = new LegoCMSApp();
window.dd = dd;

LegoCMS.register('legocms-shell', require('./legocms/AppShell').default);
LegoCMS.register('legocms-listings', require('./legocms/LegoCMSListings').default);

(() => {
    Turbolinks.start();
    Turbolinks.setProgressBarDelay(100);
    LegoCMS.boot();
})();