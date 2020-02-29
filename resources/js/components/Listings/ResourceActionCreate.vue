<template>
    <a class="page__action page__action--create" id="createUser" :href="url">
        <svg class="symbol symbol--create">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#symbol--create"></use>
        </svg>
        {{label}}
    </a>
</template>

<script>
    export default {
        props: ["resourceId", "url", "label"]
    }
</script>