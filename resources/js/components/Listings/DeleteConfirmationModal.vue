<template>
    <modal name="delete-confirmation" width="400" height="auto" @before-open="beforeOpen">
        <div class="modal">
            <div class="modal__header">
                <h3 class="modal__title">{{title}}</h3>
            </div>
            <div class="modal__body" v-html="content">
            </div>
            <div class="modal__footer">
                <button class="modal__btn modal__btn--secondary" @click="$modal.hide('delete-confirmation')">{{cancelBtnLabel}}</button>
                <button class="modal__btn modal__btn--primary" @click="confirmModal">{{confirmBtnLabel}}</button>
            </div>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                ...window.LEGOCMS.LISTINGS.modals.delete_confirmation,
                confirmCb: () => {}
            }
        },
        methods: {
            beforeOpen(e) {
                this.confirmCb = e.params.confirmCb;
            },
            confirmModal() {
                this.confirmCb()
            },
        },
        mounted() {
        }
    }
</script>