import ToggleButton from 'vue-js-toggle-button'

import Form from "./Form";
import TranslatableFormField from "./TranslatableFormField";
import FormTranslationStatus from "./FormTranslationStatus";
import FormSubmit from "./FormSubmit";
import Revisions from "./Revisions";

import FormInputHidden from "./FormInputHidden";
import FormInputText from "./FormInputText";
import FormInputTextArea from "./FormInputTextArea";
import FormInputEmail from "./FormInputEmail";
import FormInputSelect from "./FormInputSelect";
import FormInputToggle from "./FormInputToggle";
import FormErrors from './Plugins/FormErrors';

import FormTranslationsMixins from "./Mixins/FormTranslationMixins";
import FormFieldValuesMixin from "./Mixins/FormFieldValuesMixin";

export default {
    init() {
        
        Vue.use(ToggleButton)
        Vue.use(FormErrors);
        
        Vue.component('legocms-translatable-formfield',  TranslatableFormField);
        Vue.component('legocms-form-translation-status',  FormTranslationStatus);
        Vue.component('legocms-form-input-hidden', FormInputHidden);
        Vue.component('legocms-form-input-text', FormInputText);
        Vue.component('legocms-form-input-email', FormInputEmail);
        Vue.component('legocms-form-input-textarea', FormInputTextArea);
        Vue.component('legocms-form-input-select', FormInputSelect);
        Vue.component('legocms-form-input-toggle', FormInputToggle);
        Vue.component('legocms-revisions', Revisions);

        var $rootEL = document.getElementById("form");

        if ($rootEL != null) {
            return new Vue({
                name: "legoCMS-form",
                el: $rootEL,
                mixins: [FormTranslationsMixins, FormFieldValuesMixin],
                components: {
                    'legocms-form': Form,
                    'legocms-form-submit': FormSubmit
                }
            });
        }

        return false;
    }
};
