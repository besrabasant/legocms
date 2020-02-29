<template>
    <input
        type="hidden" 
        :name="name"
        v-model="value"
        :dusk="dusk && `${dusk}__input`"
        @input="setFieldValue"
        v-bind="$attrs" 
        />
</template>

<script>
import FormFieldMixin from "./Mixins/FormFieldMixin"
export default {
    mixins: [FormFieldMixin]
}
</script>