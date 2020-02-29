<template>
    <a class="row-action row-action--edit" :id="elementId" :href="url">{{label}}</a>
</template>

<script>
    export default {
        props: ["resourceId", "url", "label"],
        computed: {
            elementId() {
                return `editUser__${this.resourceId}`
            }
        }
    }
</script>