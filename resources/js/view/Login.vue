<template>
    <div>
        <h1>Login to your account</h1>

        <el-form ref="form" :model="form" :rules="rules" label-width="180px">
            <el-form-item prop="email" label="Your e-mail">
                <el-input v-model="form.email"></el-input>
            </el-form-item>
            <el-form-item prop="password" label="Password">
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
            rules: {
                email: [
                    {
                        required: true,
                        pattern: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,
                        message: 'Please input mail',
                        trigger: 'blur'
                    }
                ],
                password: [
                    {required: true, message: 'Please input password', trigger: 'blur'},
                    { min: 6, max: 20, message: 'Length should be 6 to 20', trigger: 'blur' }
                ],
            },
            errors: []
        }
    },
    methods: {
        loginUser() {
            this.$refs['form'].validate((valid) => {
                if (valid) {
                    axios.post('/api/login', this.form).then((response) => {
                        localStorage.setItem('token', response.data.token);
                        this.$router.push({name: "Dashboard"});
                    }).catch((error) => {
                        this.$notify.error({
                            title: 'Error',
                            message: 'login failed'
                        });
                        this.errors = error.response.data.errors;
                    })

                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        }
    }
}
</script>
