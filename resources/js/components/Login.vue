<template>
    <div>
        <h1>Login to your account</h1>

        <el-form ref="form" :model="form" label-width="120px">
            <el-form-item label="Your e-mail">
                <el-input v-model="form.email"></el-input>
            </el-form-item>
            <el-form-item label="Password">
                <el-input type="password" v-model="form.password"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="loginUser">Login</el-button>
            </el-form-item>
        </el-form>
    </div>

</template>
<script>
export default {
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            errors: []
        }
    },
    methods: {
        loginUser() {
            axios.post('/api/login', this.form).then((response) => {
                localStorage.setItem('token', response.data.token);
                this.$router.push({name: "Dashboard"});
            }).catch((error) => {
                this.errors = error.response.data.errors;
            })
        }
    }
}
</script>
