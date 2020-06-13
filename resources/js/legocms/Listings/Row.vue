<template>
    <tr>
        <td class="listings__ghost-cell"></td>
        <td v-for="[key, item] in rowItems" :key="key">
            {{item}}
        </td>
        <td class="listings__col-actions">
            <RowActions/>
        </td>
    </tr>
</template>

<script>
import { mapGetters } from 'vuex'
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
            return Object.entries(this.$attrs)
            .filter(([column, value]) => column != this.primaryColumn)
        },
        ...mapGetters('Listings', [
            'columns',
            'primaryColumn'
        ])
    },
}
</script>