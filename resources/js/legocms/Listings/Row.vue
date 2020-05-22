<template>
    <tr>
        <td class="listings__ghost-cell"></td>
        <td v-for="(item, key) in rowItems" :key="key">
            {{item}}
        </td>
        <td class="listings__col-actions">
            <RowActions/>
        </td>
    </tr>
</template>

<script>
import RowActions from "./RowActions";

export default {
    inheritAttrs: false,
    name: "LegoCMSListingsRow",
    components: {
        RowActions
    },
    props: {},
    computed: {
        rowItems() {
            return this.$attrs
        }
    },
}
</script>