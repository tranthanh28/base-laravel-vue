<template>
    <div>
        <div>
            <el-menu
                :default-active="defaultActive"
                class="el-menu-demo"
                mode="horizontal"
                background-color="#545c64"
                text-color="#fff"
                active-text-color="#ffd04b">
                <el-menu-item index="1">
                    <router-link class="mr-4" to='/' exact>Home</router-link>
                </el-menu-item>
                <el-menu-item index="2">
                    <router-link to='/about'>About</router-link>
                </el-menu-item>
                <el-menu-item index="3">
                    <router-link class="mr-4" to='/login' exact>Login</router-link>
                </el-menu-item>
                <el-menu-item index="4">
                    <router-link to='/register'>Register</router-link>
                </el-menu-item>
                <ul class="navbar-nav ms-auto">
                    <!-- Authenticated -->
                    <li v-if="user" class="nav-item dropdown">
                        <div class="dropdown-menu">
                            <router-link :to="{ name: 'settings.profile' }" class="dropdown-item ps-3">
                                Settings
                            </router-link>

                            <div class="dropdown-divider"/>
                            <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
                                logout
                            </a>
                        </div>
                    </li>
                    <!-- Guest -->
                </ul>
            </el-menu>
        </div>
        <div class="container mx-auto py-2">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
import {computed} from "vue";

export default {
    name: 'app',
    data() {
        return {
            defaultActive: "1",
            token: localStorage.getItem('token'),
        }
    },
    created() {
        if (this.token) {
            this.getUser()
        }
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
    methods: {
        getUser() {
            axios.get('api/user').then((response) => {
                this.user = response.data
            }).catch((errors) => {
                console.log(errors)
            })
        },
        logout() {
            axios.post('api/logout').then(() => {
                localStorage.removeItem('token')
                this.$store.dispatch('auth/logout')
                this.$router.push('/login')
            }).catch((errors) => {
                console.log(errors)
            })
        },
    }
}
</script>
