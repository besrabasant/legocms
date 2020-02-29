<template>
    <div class="form__field">
        <label :for="$parent.name" class="form__label" :dusk="dusk && `${dusk}__label`">
            {{$parent.label}} :
            <span class="form__field-locale" v-if="locale">{{locale}}</span>
            <span class="form__help" v-html="help" v-if="errors || help"></span>
        </label>
        <slot></slot>
        <div v-show="errors" class="form__errors" :dusk="dusk && `${dusk}__errors`">
            <span v-for="(error, id) in errors" :key="id">{{error}}</span>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        help() {
            return (this.$parent.help !== undefined) && this.$parent.help;
        },
        errors() {
            return (this.$parent.errors !== undefined) && this.$parent.errors;
        },
        dusk() {
            return (this.$parent.dusk !== undefined) && this.$parent.dusk;
        },
        locale() {
            return this.$parent.translatable && 
                this.$root.translations.all.find(t => t.value == this.$parent.locale).shortlabel
        }
    },
    mounted() {
    }
}
</script>