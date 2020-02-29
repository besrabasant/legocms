<template>
    <div class="form__locale-field">
        <component 
            v-for="t in translations.all"
            :key="t.value" 
            v-bind:is="type"
            v-show="isActiveTranslation(t.value)"
            v-bind="translatedAttributes(t.value)" 
            :translatable="true"
            :locale="t.value">
        </component>
    </div>
</template>

<script>
export default {
    props: {
        type: String,
        attributes: Object
    },
    data() {
        return {
            count: [1,2]
        }
    },
    computed: {
        translations() {
            return this.$root.translations;
        },
        activeTranslation() {
            return this.$root.activeTranslation;
        }
    },
    methods: {
        isActiveTranslation(value) {
            return value === this.activeTranslation
        },
        translatedAttributes(locale) {
            let attributes = Object.assign({}, this.$props.attributes);

            attributes.name = `${locale}[${this.$props.attributes.name}]`
            attributes.id = `${locale}[${this.$props.attributes.name}]`
            attributes['original-name'] = this.$props.attributes.name;

            return attributes
        },
    },
    mounted() {
    }
}
</script>
