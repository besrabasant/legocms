import FormFieldWrapper from "../FormFieldWrapper";

const FormFieldMixin  = {
    components: {
        FormField: FormFieldWrapper
    },
    props: {
        label: String,
        name: String,
        help: {
            type: String,
            default: null
        },
        dusk: {
            type: String,
            default: null
        },
        translatable: {
            type: Boolean,
            default: false
        },
        locale:String,
        originalName: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            value: "",
        };
    },
    methods: {
        setFieldValue() {
            if(this.translatable) {
                return this.$root.setFieldValue(this.$props.originalName, this.value, this.$props.locale);
            }

            return this.$root.setFieldValue(this.$props.name, this.value);
        },
        updateFieldValue() {
            this.value = this.fieldValue
        }
    },
    computed: {
        errors() {
            if (LEGOCMS.FORMS.errors && LEGOCMS.FORMS.errors.hasOwnProperty(this.$props.name)) {
                return LEGOCMS.FORMS.errors[this.$props.name];
            }
            return false;
        },
        fieldValue() {
            if(this.translatable) {
                return this.$root.getFieldValue(this.$props.originalName, this.$props.locale);
            }
            
            return this.$root.getFieldValue(this.$props.name);
        },
        
    },
    mounted() {
        this.updateFieldValue();
        this.$root.$on('updateFieldValue', this.updateFieldValue);
    }
};

export default FormFieldMixin;