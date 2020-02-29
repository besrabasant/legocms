<template>
    <div class="accordion" 
        :class="{
            'accordion--expanded': !collapsed 
            }"
        >
        <div class="accordion__header" @click="toggleCollapse">
            {{ title }}
            <legocms-icon name="expand" ></legocms-icon>
        </div>
        <transition name="expand">
            <div class="accordion__body" v-show="!collapsed">
                <div class="accordion__content">
                <slot></slot>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        expanded: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            collapsed: !this.$props.expanded
        }
    },
    methods: {
        toggleCollapse() {
            this.collapsed = !this.collapsed
        },
    }
}
</script>

<style scoped>
* {
  will-change: height;
  transform: translateZ(0);
  backface-visibility: hidden;
  perspective: 1000px;
}
</style>