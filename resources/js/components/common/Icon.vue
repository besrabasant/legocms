<template>
    <svg :class="`symbol symbol--${name}`">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" 
            :xlink:href="`#symbol--${name}`">
        </use>
    </svg>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true
        }
    }
}
</script>