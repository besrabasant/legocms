<template>
    <th v-if="!primary">
        <slot></slot>
    </th>
</template>

<script>
export default {
    name: "LegoCMSListingsHeader",
    props: {
        column: {
            type: String,
            required: true
        },
        primary: {
            type: Boolean,
            default: false
        }
    }
}
</script>