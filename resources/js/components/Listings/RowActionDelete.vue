<template>
    <a class="row-action row-action--delete" :id="elementId" :href="url" @click.stop.prevent="showDeleteConfirmation">{{label}}</a>
</template>

<script>
import { submitForm } from "../../utils/api";
import { serializeFormData } from "../../utils/form";

export default {
    props: {
        resourceId: [String, Number], 
        url: String,
        label: String,
    },
    computed: {
        elementId() {
            return `deleteUser__${this.resourceId}`
        }
    },
    methods: {
        showDeleteConfirmation() {
            this.$modal.show('delete-confirmation', {
                confirmCb: this.sendDeleteRequest
            });
        },
        async sendDeleteRequest() {
            let formData = {
                '_token': LEGOCMS.LISTINGS._token,
                '_method': 'DELETE'
            };
            await submitForm(this.url, serializeFormData(formData));
        }
    }
}
</script>