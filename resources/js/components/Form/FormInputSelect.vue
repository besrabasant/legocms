<template>
    <FormField>
        <select class="form__input form__input--select" 
            :name="name" 
            v-model="value"
            :dusk="dusk && `${dusk}__input`"
            @change="setFieldValue"
            v-bind="$attrs"
            >
            <option value="">{{defaultLabel}}</option>
            <option v-for="(label, value) in options" :key="value" :value="value">{{label}}</option>
        </select>
    </FormField>
</template>

<script>
import FormFieldMixin from "./Mixins/FormFieldMixin"
export default {
    mixins: [FormFieldMixin],
    props: ['options', 'defaultLabel', 'selectedValue'],
    methods: {
        isSelected(value) {
            return value === this.selectedValue;
        }
    }
}
</script>