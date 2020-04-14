<template>
    <legocms-accordion title="Revisions">
        <div class="revisions">
            <a class="revisions__item"
                v-for="revision in revisions" 
                :key="revision.id"
                :href="revision.url"
                >
                on {{revision.datetime}} by {{revision.author}}
            </a>
        </div>
    </legocms-accordion>
</template>

<script>
export default {
    computed: {
        revisions() {
            return LEGOCMS.FORMS.revisions;
        }
    }
}
</script>