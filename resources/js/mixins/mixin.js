export default {
    data() {
        return {
            loading: false,
        }
    },
    methods: {
        startLoading() {
            this.loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
        },
        stopLoading() {
            this.loading.close();
        }
    }
}
