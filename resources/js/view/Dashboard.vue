<template>
    <div class="swap-content">
        <div class="col-xs-12">
            <div class="page-title-box d-flex justify-content-between">
                <h4 class="page-title"></h4>
                <el-breadcrumb>
                    <el-breadcrumb-item :to="{ path: '/dashboard' }">Dashboard</el-breadcrumb-item>
                </el-breadcrumb>
            </div>
        </div>

        <div class="content" v-if="user">
            Name: {{ user.name }} <br>
            Email: {{ user.email }}<br><br>
        </div>

    </div>
</template>
<script>
export default {
    data() {
        return {
            options: {
                height: '100%',
            },
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
            this.startLoading()
            axios.get('api/user').then((response) => {
                this.stopLoading()
                this.user = response.data
                this.$store.dispatch('auth/updateUser', {user: this.user})
            }).catch((errors) => {
                this.stopLoading()
                this.$router.push('/login')
                console.log(errors)
            })
        }
    },
    created() {
        this.getUser()
    }

}
</script>
<style scoped>
</style>
