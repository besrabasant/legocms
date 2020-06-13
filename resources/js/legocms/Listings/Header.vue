<template>
    <th v-if="!primary">
        <slot></slot>
    </th>
</template>

<script>
import { mapActions } from 'vuex'
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
    },
    created() {
        this.registerColumn({
            key: this.$props.column,
            column: {
               primary: this.$props.primary 
            }
        })
    },
    methods: {
        ...mapActions('Listings',[
            'registerColumn',
        ])
    }
}
</script>