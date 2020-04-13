export default {
    methods: {
        notify(title, text, type) {
            this.$notify({
            group: 'listings',
            type,
            title,
            text
        });
        }
    },
    mounted() {

        if(LEGOCMS.LISTINGS.notification) {
            let {type, title, message} = LEGOCMS.LISTINGS.notification;
            this.notify(title, message, type);
        }
    }
}
