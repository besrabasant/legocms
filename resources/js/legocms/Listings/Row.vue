<template>
    <tr>
        <td class="listings__ghost-item"></td>
        <td v-for="(item, key) in rowItems" :key="key">
            {{item}}
        </td>
    </tr>
</template>

<script>
export default {
    inheritAttrs: false,
    name: "LegoCMSListingsRow",
    props: {},
    computed: {
        rowItems() {
            return this.$attrs
        }
    },
}
</script>