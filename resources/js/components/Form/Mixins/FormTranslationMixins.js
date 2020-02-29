const FormTranslationMixins = {
    data(){
        return {
            isTranslatable: false,
            translations: LEGOCMS.FORMS.translations,
            activeLocale: null,
        };
    },
    computed: {
        activeTranslation() {
            return this.activeLocale || 
                (this.translations.active &&  this.translations.active.value)  || 
                LEGOCMS.APP.locale;
        }
    },
    methods: {
        setFormTranslatable(value) {
            this.isTranslatable = value;
        }         
    },
    watch: {
        activeLocale: function (val, oldVal) {
            this.$emit('updateFieldValue')
        }
    },
    created() {
    }
};

export default FormTranslationMixins;