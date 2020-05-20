<template>
    <div class="legocms">
        <div class="legocms__header">
            <slot name="header">
                Header
            </slot>
        </div>
        <div class="legocms__navigation">
            <slot name="navigation">
                Navigation
            </slot>
        </div>
        <div class="legocms__main">
            <slot>
                Main
            </slot>
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