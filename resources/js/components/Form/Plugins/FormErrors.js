            import FormError from '../FormError';

function install(Vue, options) {

    // 1. add global method or property
    Vue.formErrors = {};
    Vue.formErrors.errorBag = [];

    Vue.component('legocms-form-error', FormError)

    //
    // // 2. add a global asset
    // Vue.directive('my-directive', {
    //     bind(el, binding, vnode, oldVnode) {
    //         // some logic ...
    //     }
    // });
    //
    // // 3. inject some component options
    // Vue.mixin({
    //     created: function () {
    //         // some logic ...
    //     }
    // });

    // 4. add an instance method
    Vue.prototype.$addErrors = function (errors) {
        Vue.formErrors.errorBag.concat(errors)
    };
};

export default install;