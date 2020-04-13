<template>
    <notifications 
        group="listings"
        position="bottom right"
        :width="350"
        :duration="5000"
        >
         <template slot="body" slot-scope="props">
            <div :class="`listings-notification listings-notification--${props.item.type}`"
                @click="props.close"
            >
                <div class="listings-notification__icon">
                    <legocms-icon :name="iconMap[props.item.type]" />
                </div>
                <div class="listings-notification__content">
                    <div class="listings-notification__title">
                    {{props.item.title}}
                    </div>
                    <p  v-html="props.item.text">
                    </p>
                </div>
            </div>
        </template>
    </notifications>
</template>

<script>
export default {
    data() {
        return {
            iconMap: {
                success: 'check',
                error: 'error',
                info: 'info',
                warning: 'warning'
            }
        }
    }
}
</script>