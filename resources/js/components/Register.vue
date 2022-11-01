<template>
    <div>
        <h1>Register an account</h1>

        <el-form ref="form" :model="form" label-width="120px">
            <el-form-item label="Name">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="Your e-mail">
                <el-input v-model="form.email"></el-input>
            </el-form-item>
            <el-form-item label="Password">
                <el-input type="password" v-model="form.password"></el-input>
            </el-form-item>
            <el-form-item label="Confirm password">
                <el-input type="password" v-model="form.password_confirmation"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="saveForm">Login</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: []
        }
    },
    methods: {
        saveForm() {
            axios.post('/api/register', this.form).then((response) => {
                this.$notify({
                    title: 'Success',
                    message: 'register successfully',
                    type: 'success'
                });
                localStorage.setItem('token', response.data.token);
                this.$router.push({name: "Dashboard"});
            }).catch((error) => {
                this.errors = error.response.data.errors;
            })
        }
    }
}
</script>
