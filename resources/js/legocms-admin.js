import commonBootstrap from './common/bootstrap';
import axios from 'axios';
import Vue from 'vue';
import TurbolinksAdapter from 'vue-turbolinks';
import VModal from 'vue-js-modal';
import Fragment from 'vue-fragment';

import Common from "./components/common";
import Listings from "./components/Listings";
import Form from "./components/Form";

Vue.use(TurbolinksAdapter);
Vue.use(VModal, {dynamic: true});
Vue.use(Fragment.Plugin);

window.Axios = axios;
window.Vue = Vue;

function PageAnimation() {

    let enableAnimationForEnvs = [
        'local',
        'production',
        'development'
    ];

    let bodyClassList = document.body.classList;

    return {
        init: () => {
            if(enableAnimationForEnvs.some(env => bodyClassList.contains(`app-env--${env}`))) {
                document.querySelector('.page').classList.add('page--loaded');
            }
        }
    };
}

(function () {
    dd('LegoCMS Version: ', VERSION);

    commonBootstrap.init();

    document.addEventListener('turbolinks:load', () => {

        Common.init();

        Form.init();
        
        let listings = Listings.init();
        VModal.rootInstance = listings;
        
        PageAnimation().init();
    });

})();


