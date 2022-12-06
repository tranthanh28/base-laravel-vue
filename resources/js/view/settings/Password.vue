<template>
    <el-card class="box-card">
        <div slot="header">
            <span>Profile</span>
        </div>
        <el-form ref="form" :model="form" :rules="rules" label-width="180px">
            <el-form-item prop="password" label="Password">
                <el-input type="password" v-model="form.password"></el-input>
            </el-form-item>
            <el-form-item prop="password_confirmation" label="Confirm password">
                <el-input type="password" v-model="form.password_confirmation"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="update">Update</el-button>
            </el-form-item>
        </el-form>
    </el-card>
</template>

<script>

export default {
    data() {
        const validatePass = (rule, value, callback) => {
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
                password: '',
                password_confirmation: ''
            },
            rules: {
                password: [
                    {required: true, message: 'Please input password', trigger: 'blur'},
                    { min: 6, max: 20, message: 'Length should be 6 to 20', trigger: 'blur' }
                ],
                password_confirmation: [
                    {validator: validatePass, trigger: 'blur'}]
            },
        }

    },

    methods: {
        update() {
            this.$refs['form'].validate((valid) => {
                if (valid) {
                    this.startLoading()
                    axios.put('/api/settings/password', this.form).then((response) => {
                        this.stopLoading()
                        this.$notify({
                            title: 'Success',
                            message: 'update password successfully',
                            type: 'success'
                        });
                    }).catch((error) => {
                        this.stopLoading()
                        this.$notify.error({
                            title: 'Error',
                            message: 'update password failed'
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
