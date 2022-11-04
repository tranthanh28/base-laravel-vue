<template>
    <el-header style="height: 70px; background-color: #f3f3f3" class="d-flex align-items-center justify-content-between">
        <div style="width: 200px" class="d-flex align-items-center">
            <i @click="collapseMenu" class="el-icon-menu" style="margin-right: 10px; font-size: x-large"></i>
            <el-input
                class="custom-input"
                placeholder="Tìm kiếm ..."
                suffix-icon="el-icon-search"
                v-model="search">
            </el-input>
        </div>

        <div class="d-flex align-items-center float-end">
            <el-badge :value="12" class="item">
                <i style="font-size: x-large" class="el-icon-bell"/>
            </el-badge>

            <el-dropdown trigger="click">
                        <div class="el-dropdown-link d-flex align-items-center">
                            <el-avatar icon="el-icon-user-solid"></el-avatar>
                            <i class="el-icon-arrow-down el-icon--right"></i>
                        </div>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item icon="el-icon-user-solid">Thông tin</el-dropdown-item>
                    <el-dropdown-item icon="el-icon-s-tools">
                        <router-link to="/settings" exact>Cài đặt</router-link>
                    </el-dropdown-item>
                    <el-dropdown-item @click="logout">
                        <font-awesome-icon icon="fa-solid fa-arrow-right-from-bracket"/>
                        Đăng xuât
                    </el-dropdown-item>
                    <el-dropdown-item icon="el-icon-user-solid">Đổi mật khẩu</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>

    </el-header>
</template>
<script>
import {mapGetters} from 'vuex'

export default {
    name: 'Navbar',
    data() {
        return {
            search: '',
            defaultActive: "1",
            token: localStorage.getItem('token'),
        }
    },
    computed: mapGetters({
        user: 'auth/user',
        collapse: 'common/collapse'
    }),
    methods: {
        logout() {
            axios.post('/api/logout').then(() => {
                localStorage.removeItem('token')
                this.$store.dispatch('auth/logout')
                this.$router.push('/login')
            }).catch((errors) => {
                console.log(errors)
            })
        },
        collapseMenu() {
            this.$store.dispatch('common/toggleCollapse');
        }
    }
}
</script>
<style>
.custom-input input {
    border-radius: 30px;
}
</style>
<style scoped>
.item {
    margin-top: 10px;
    margin-right: 40px;
}
</style>
