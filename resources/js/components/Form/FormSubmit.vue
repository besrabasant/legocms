<template>
    <input 
        type="submit" 
        class="form__btn form__btn--primary" 
        :value="label" 
        @click.prevent="submitForm" 
        v-bind="$attrs"/>
</template>

<script>
    export default {
        props: ["label"],
        methods: {
            submitForm() {
                this.$parent.$emit('submitForm')
            }
        }
    }
</script>