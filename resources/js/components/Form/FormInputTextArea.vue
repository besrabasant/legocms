<template>
    <FormField>
        <textarea 
            class="form__input form__input--textarea" 
            type="text" 
            :name="name" 
            v-bind="$attrs" 
            v-model="value"
            @input="setFieldValue"
            :dusk="dusk && `${dusk}__input`" />
    </FormField>
</template>

<script>
import FormFieldMixin from "./Mixins/FormFieldMixin"
export default {
    name: "legocms-form-input-textarea",
    mixins: [FormFieldMixin],
}
</script>