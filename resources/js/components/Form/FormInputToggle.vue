<template>
    <FormField>
        <input class="form__input form__input--toggle" 
            type="checkbox" 
            :name="name"
            v-model="value"
            :dusk="dusk && `${dusk}__input`"
            @input="setFieldValue"
            v-bind="$attrs" 
            />
    </FormField>
</template>
<script>
import FormFieldMixin from "./Mixins/FormFieldMixin"
export default {
    mixins: [FormFieldMixin]
}
</script>