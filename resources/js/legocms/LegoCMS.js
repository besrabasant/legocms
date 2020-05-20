import Store from "./Store";
import Vuex from 'vuex';

class LegoCMS {
    constructor()
    {
        this.$event = new Vue();
        this.componentMap = new Map();
        this.$root = "__LEGOCMS__";
        this.$appInstance = null;
    }

    register(componentName, Component = null)
    {
        if(componentName instanceof Map) {
            this.componentMap = new Map([...this.componentMap, ...componentName]);
        } else {
            this.componentMap.set(componentName, Component);
        }
    }

    boot()
    {
        this.event().$emit("legocms::booting", this);
        
        document.addEventListener('turbolinks:load', () => {

            this.componentMap.forEach((Component, name) => {
                Vue.component(name, Component);
            });

            this.$appInstance = new Vue({
                name: "LegoCMS", 
                el: document.getElementById(this.$root),
                store: new Vuex.Store(Store)
            });
        });
        
        this.event().$emit("legocms::booted", this);
    }

    event(){
        return this.$event;
    }

}

export default LegoCMS;