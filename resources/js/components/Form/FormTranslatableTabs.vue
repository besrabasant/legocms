<template>
    <div class="form__translation">
        <div class="form__translation-selector">
            <div v-for="t in translations.all" :key="t.value" 
                class="form__translation-btn"
                @click="selectTranslation(t.value)"
                :class="{'form__translation-btn--active': isActiveTranslation(t.value) }">
                {{t.shortlabel}}
            </div>
            
        </div>
        <legocms-translatable-formfield 
            type="legocms-form-input-hidden"
            :attributes="{
                id: 'active',
                name: 'active'
            }"
            >
        </legocms-translatable-formfield>
    </div>
</template>

<script>
export default {
    methods:{
        selectTranslation(value){
            this.$root.activeLocale = value;
        },
        isActiveTranslation(value) {
            return value === this.activeTranslation
        },
    },
    computed: {
        translations() {
            return this.$root.translations;
        },
        activeTranslation() {
            return this.$root.activeTranslation;
        }
    },
    created() {
        this.translations.all.forEach(t => {
            this.$root.setFieldValue('active', t.published, t.value)
        })
    }
}
</script>