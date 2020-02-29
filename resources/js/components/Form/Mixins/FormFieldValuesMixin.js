import deepMerge from "deepmerge";

const FormFieldValuesMixin = {
    data() {
        return {
            fieldValues: LEGOCMS.FORMS.fieldValues
        };
    },
    methods: {
        getFieldValue(name, locale = null) {
            if(locale) {
                return this.fieldValues[name][locale];
            }

            return this.fieldValues[name];
        },
        setFieldValue(name, value, locale = null) {
            if(locale) {
                this.fieldValues = deepMerge(this.fieldValues, {
                    [name]: {
                        [locale]: value
                    }
                });
            } else {   
                this.fieldValues = deepMerge(this.fieldValues, {
                    [name]: value
                });
            }
        }
    },
    mounted() {
    }
};

export default FormFieldValuesMixin;