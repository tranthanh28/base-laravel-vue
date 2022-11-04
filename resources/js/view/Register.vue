<template>
    <div>
        <h1>Register an account</h1>

        <el-form ref="form" :model="form" :rules="rules" label-width="180px">
            <el-form-item prop="name" label="Name">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item prop="email" label="Your e-mail">
                <el-input v-model="form.email"></el-input>
            </el-form-item>
            <el-form-item prop="password" label="Password">
                <el-input type="password" v-model="form.password"></el-input>
            </el-form-item>
            <el-form-item prop="password_confirmation" label="Confirm password">
                <el-input type="password" v-model="form.password_confirmation"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="saveForm">Register</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>

export default {
    data() {
        var validatePass = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Please input the password again'));
            } else if (value !== this.form.password) {
                callback(new Error('Two inputs don\'t match!'));
            } else {
                callback();
            }
        };
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            rules: {
                name: [
                    {required: true, message: 'Please input Activity name', trigger: 'blur'},
                    {min: 3, max: 40, message: 'Length should be 3 to 40', trigger: 'blur'}
                ],
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
                password_confirmation: [
                    {validator: validatePass, trigger: 'blur'}]
            },
            errors: []
        }
    },
    methods: {
        saveForm() {
            this.$refs['form'].validate((valid) => {
                if (valid) {
                    axios.post('/api/register', this.form).then((response) => {
                        this.$notify({
                            title: 'Success',
                            message: 'register successfully',
                            type: 'success'
                        });
                        localStorage.setItem('token', response.data.token);
                        this.$router.push({name: "Dashboard"});
                    }).catch((error) => {
                        this.$notify.error({
                            title: 'Error',
                            message: 'register failed'
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
