<template>
    <div class="panel">
        <slot></slot>
    </div>  
</template>

<script>
export default {
    name: "LegoCMSPanel",
    props: {
        name: {
            type: String,
            required: true
        }
    }
}
</script>