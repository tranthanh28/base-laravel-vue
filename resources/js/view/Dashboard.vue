<template>
    <div class="container">
        Dashboard <br>
        <div v-if="user">
            Name: {{ user.name }} <br>
            Email: {{ user.email }}<br><br>
            <button @click.prevent="logout">Logout</button>
        </div>

    </div>
</template>
<script>
export default {
    data() {
        return {
            user: null,
            token: localStorage.getItem('token')
        }
    },
    methods: {
        logout() {
            axios.post('api/logout').then((response) => {
                localStorage.removeItem('token')
                this.$store.dispatch('auth/logout')
                this.$router.push('/login')
            }).catch((errors) => {
                console.log(errors)
            })
        },
        getUser() {
            axios.get('api/user').then((response) => {
                this.user = response.data
                this.$store.dispatch('auth/updateUser', {user: this.user})
            }).catch((errors) => {
                this.$router.push('/login')
                console.log(errors)
            })
        }
    },
    created() {
        // window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        this.getUser()
    }

}
</script>
