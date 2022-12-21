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
                <el-menu-item index="2">
                    <router-link to='/about'>About</router-link>
                </el-menu-item>
                <el-submenu class="float-end" v-if="user" index="3">
                    <template slot="title">{{ user.name }}</template>
                    <el-menu-item index="3-1">
                        <router-link to="/settings" exact>Setting</router-link>
                    </el-menu-item>
                    <el-menu-item index="3-2" @click="logout">Logout</el-menu-item>
                </el-submenu>
                <template v-else>
                    <el-menu-item class="float-end" index="4">
                        <router-link class="mr-4" to='/login' exact>Login</router-link>
                    </el-menu-item>
                    <el-menu-item class="float-end" index="5">
                        <router-link to='/register'>Register</router-link>
                    </el-menu-item>
                </template>
            </el-menu>
        </div>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
import AuthMinxin from "../mixins/auth-mixin"

export default {
    name: 'Navbar',
    mixins: [AuthMinxin],
    data() {
        return {
            defaultActive: "1",
            token: localStorage.getItem('token'),
        }
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
    methods: {
    }
}
</script>
<style scoped>
</style>
