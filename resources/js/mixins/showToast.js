export default {
    methods: {
        showToast(variant = null, title, text) {
            this.$bvToast.toast(text, {
                title: title,
                variant: variant,
                solid: true,
                autoHideDelay: 3000,
            })
        }
    }
}