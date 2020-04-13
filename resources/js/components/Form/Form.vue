<template>
    <form  class="form"  method="POST" ref="form" v-bind="$attrs">
        <div class="form__container">
            <FormTranslatableTabs v-if="handlesTranslations"></FormTranslatableTabs>
            <slot></slot>
        </div>
    </form>    
</template>

<script>
import serialize from "../../utils/serialize";
import { submitForm } from "../../utils/api";
import { serializeFormData } from "../../utils/form";
import FormTranslatableTabs from"./FormTranslatableTabs"

export default {
    components: {
        FormTranslatableTabs
    },
    props: {
        handlesTranslations: {
            type: Boolean,
            default: false
        }
    },
    created() {
        this.$root.setFormTranslatable(this.handlesTranslations)
    },
    mounted(){
        this.$on('submitForm', this.submitForm)
    },
    methods: {
        debugFormData() {
            let data = this.getFormData()
            dd('Form data: ', data)
        },
        getFormData() {
            return this.$root.fieldValues
        },
        async submitForm() {
            let $form = this.$refs.form;
            let formData = serializeFormData(this.getFormData());

            this.debugFormData()

            await submitForm($form.getAttribute('action'), formData)
        },
    }
}
</script>