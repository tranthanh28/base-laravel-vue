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
import {mapGetters} from 'vuex'

export default {
    data() {
        return {
            options: {
                height: '100%',
            },
            token: localStorage.getItem('token')
        }
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
    methods: {},
    created() {
    }

}
</script>
<style scoped>
</style>
