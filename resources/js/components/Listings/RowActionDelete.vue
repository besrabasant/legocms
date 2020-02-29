<template>
    <a class="row-action row-action--delete" :id="elementId" :href="url" @click.stop.prevent="showDeleteConfirmation">{{label}}</a>
</template>

<script>
    export default {
        props: ["resourceId", "url", "label"],
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
                let response = await Axios.post(this.url, {'_method': "DELETE"});
                await this.$modal.hide('delete-confirmation');
                Turbolinks.visit(response.headers['turbolinks-location']);
            }
        }
    }
</script>