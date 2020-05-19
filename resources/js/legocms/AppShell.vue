<template>
    <div class="legocms">
        <div class="legocms__header">
            Header
            <slot name="header"></slot>
        </div>
        <div class="legocms__navigation">
            Navigation
            <slot name="navigation"></slot>
        </div>
        <div class="legocms__main">
            Main
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "LegoCMSShell",
    props: {
        token: {
            type: String,
            required: true
        }
    }
}
</script>