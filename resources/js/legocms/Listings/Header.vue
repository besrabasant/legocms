<template>
    <th>
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
        }
    }
}
</script>