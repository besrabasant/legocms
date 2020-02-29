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
import FormTranslatableTabs from"./FormTranslatableTabs"

function prepareRequestHeaders() {
    return {
        'Accept': 'text/html, application/xhtml+xml',
        'Turbolinks-Referrer': `${window.location.href}`,
        'Content-Type': 'application/x-www-form-urlencoded'
    }
}

function serializeFieldValue(field, value) {
    if(typeof value === 'boolean') {
        value = +value
    }
    return `${encodeURIComponent(field)}=${encodeURIComponent(value)}`
}

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
        serializeForm() {
            let data = this.getFormData()
            let formArr = []
            
            for(let field in data) {
                let value = data[field]

                if(typeof value === 'object') {
                    for(let locale in value) {
                        let val = value[locale],
                        localefield = `${locale}[${field}]`

                        formArr.push(serializeFieldValue(localefield, val))
                    }
                } else {
                    formArr.push(serializeFieldValue(field, value))
                }
            }

            return formArr.join('&')
        },
        debugFormData() {
            let data = this.getFormData()
            dd('Form data: ', data)
        },
        getFormData() {
            return this.$root.fieldValues
        },
        async submitForm() {
            let $form = this.$refs.form;
            let formData = this.serializeForm();

            this.debugFormData()

            Turbolinks.controller.adapter.showProgressBarAfterDelay();

            try {
                let response = await fetch($form.getAttribute('action'), {
                    method: 'POST',
                    headers: prepareRequestHeaders(),
                    body: formData
                });

                this.handleResponse(response)
            } catch (error) {
                console.log(error)
            } finally {
                Turbolinks.controller.adapter.hideProgressBar();
            }
        },
        async handleResponse(response) {
            let responseHtml = await response.text();
            let location = response.headers.get('Turbolinks-Location');
            let snapshot = Turbolinks.Snapshot.wrap(responseHtml);

            if (!location) {
                location = window.location.href;
            }

            Turbolinks.controller.cache.put(location, snapshot);
            Turbolinks.visit(location, {action: 'restore'});
        }
    }
}
</script>