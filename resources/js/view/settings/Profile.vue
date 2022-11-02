<template>
    <el-card class="box-card">
        <div slot="header">
            <span>Profile</span>
        </div>
        <el-form ref="form" :model="data" label-width="180px">
            <el-form-item label="Name">
                <el-input v-model="data.name"></el-input>
            </el-form-item>
            <el-form-item label="Your e-mail">
                <el-input v-model="data.email"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="update">Update</el-button>
            </el-form-item>
        </el-form>
    </el-card>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    data: () => ({
        data: {}
    }),

    computed: mapGetters({
        user: 'auth/user'
    }),
    created() {
        this.data = {...this.user}
    },
    methods: {
        async update() {
            axios.put('/api/settings/profile', this.data).then((response) => {
                this.$notify({
                    title: 'Success',
                    message: 'update user successfully',
                    type: 'success'
                });
                this.$store.dispatch('auth/updateUser', {user: this.data})
            }).catch((error) => {
                this.errors = error.response.data.errors;
            })
        }
    }
}
</script>
