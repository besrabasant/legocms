<template>
    <div class="form__translation-status">
        <legocms-accordion title="Translations">
            <div v-for="t in translations.all"  :key="t.value"
                class="form__translation-status-item">
                <span class="form__translation-label">
                    {{ t.label }}
                </span>
                <toggle-button @change="setTranslationActiveValue(t.value)"
                    :value="getPublishedStatus(t.value)"
                    :width="40"
                    :height="20"
                    :margin="5"
                    >
                </toggle-button>
            </div>
        </legocms-accordion>
    </div>
</template>

<script>
export default {
    methods:{
        isActiveTranslation(value) {
            return value === this.activeTranslation
        },
        getPublishedStatus(locale) {
            let translation = this.translations.all.find(t => t.value == locale)
            return translation? translation.published: false
        },
        setTranslationActiveValue(locale) {
            let value = this.$root.getFieldValue('active', locale)
            this.$root.setFieldValue('active', !value, locale)
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
}
</script>