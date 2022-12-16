export default {
    methods: {
        checkAuthenticated() {
            this.startLoading()
            axios.get('/api/authenticated').then((response) => {
                this.stopLoading()
                this.$router.push('/dashboard')
            }).catch(error => {
                this.stopLoading()
                console.error(error)
            })
        },
    }
}
