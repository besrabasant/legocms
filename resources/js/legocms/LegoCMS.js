import dd from "../utils/dd";

class LegoCMS {
    constructor()
    {
        this.$event = new Vue();
        this.componentMap = new Map();
        this.$root = "__LEGOCMS__";
        this.$appInstance = null;
    }

    register(componentName, Component)
    {
        this.componentMap.set(componentName, Component);
    }

    boot()
    {
        this.event().$emit("legocms::booting", this);
        
        document.addEventListener('turbolinks:load', () => {

            let components = {};

            this.componentMap.forEach((Component, name) => {
                components[name] = Component;
            });

            this.$appInstance = new Vue({name: "LegoCMS", el: document.getElementById(this.$root), components});
        });
        
        this.event().$emit("legocms::booted", this);
    }

    event(){
        return this.$event;
    }

}

export default LegoCMS;