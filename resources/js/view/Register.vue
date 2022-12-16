<template>
    <section>
        <div class="container-alt">
            <div class="row">
                <div class="col-sm-12">

                    <div class="wrapper-page">

                        <div class="m-t-40 account-pages">
                            <div class="text-center account-logo-box">
                                <h2 class="text-uppercase cl-white fs-20">
                                    Đăng ký
                                </h2>
                                <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                            </div>
                            <div class="account-content">
                                <el-form ref="form" class="register-form" :model="form" :rules="rules">
                                    <el-form-item prop="name">
                                        <el-input placeholder="Username" v-model="form.name"></el-input>
                                    </el-form-item>
                                    <el-form-item prop="email">
                                        <el-input placeholder="Email" v-model="form.email"></el-input>
                                    </el-form-item>
                                    <el-form-item prop="password">
                                        <el-input placeholder="Password" type="password"
                                                  v-model="form.password"></el-input>
                                    </el-form-item>
                                    <el-form-item prop="password_confirmation">
                                        <el-input placeholder="Password Confirmation" type="password"
                                                  v-model="form.password_confirmation"></el-input>
                                    </el-form-item>
                                    <div class="m-t-10 account-btn">
                                        <div class="d-flex justify-content-center">
                                            <el-button type="primary" @click="saveForm">Đăng ký</el-button>
                                        </div>
                                    </div>
                                </el-form>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <!-- end card-box-->


                        <div class="row m-t-50">
                            <div class="col-sm-12 text-center">
                                <p class="text-muted">Bạn đã có tài khoản?
                                    <router-link to="/login" class="text-primary m-l-5">
                                        <b>Đăng nhập</b></router-link>
                                </p>
                            </div>
                        </div>

                    </div>
                    <!-- end wrapper -->

                </div>
            </div>
        </div>
    </section>

    <!--    <div class="register">-->
    <!--        <el-card class="box-card">-->
    <!--            <h2>Register an account</h2>-->
    <!--            <el-form ref="form" class="register-form" :model="form" :rules="rules" label-width="180px">-->
    <!--                <el-form-item prop="name" label="Name">-->
    <!--                    <el-input v-model="form.name"></el-input>-->
    <!--                </el-form-item>-->
    <!--                <el-form-item prop="email" label="Your e-mail">-->
    <!--                    <el-input v-model="form.email"></el-input>-->
    <!--                </el-form-item>-->
    <!--                <el-form-item prop="password" label="Password">-->
    <!--                    <el-input type="password" v-model="form.password"></el-input>-->
    <!--                </el-form-item>-->
    <!--                <el-form-item prop="password_confirmation" label="Confirm password">-->
    <!--                    <el-input type="password" v-model="form.password_confirmation"></el-input>-->
    <!--                </el-form-item>-->
    <!--                <div class="d-flex justify-content-center">-->
    <!--                    <el-button type="primary" @click="saveForm">Register</el-button>-->
    <!--                </div>-->
    <!--            </el-form>-->
    <!--        </el-card>-->
    <!--    </div>-->
</template>
<script>
import AuthMinxin from "../mixins/auth-mixin"
export default {
    mixins: [AuthMinxin],
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
            token: localStorage.getItem('token'),
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
                    {min: 6, max: 20, message: 'Length should be 6 to 20', trigger: 'blur'}
                ],
                password_confirmation: [
                    {validator: validatePass, trigger: 'blur'}]
            },
            errors: []
        }
    },
    created() {
        if (this.token) {
            this.checkAuthenticated()
        }
    },
    methods: {
        saveForm() {
            this.$refs['form'].validate((valid) => {
                if (valid) {
                    this.startLoading()
                    axios.post('/api/register', this.form).then((response) => {
                        this.stopLoading()
                        this.$notify({
                            title: 'Success',
                            message: 'register successfully',
                            type: 'success'
                        });
                        localStorage.setItem('token', response.data.token);
                        this.$router.push({name: "Dashboard"});
                    }).catch((error) => {
                        this.stopLoading()
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
<style scoped>
.container-alt {
    margin-left: auto;
    margin-right: auto;
    padding-left: 15px;
    padding-right: 15px;
}

.wrapper-page {
    margin: 5% auto;
    position: relative;
    max-width: 420px;
}

.account-pages {
    box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);
    border-radius: 5px;
}

.m-t-40 {
    margin-top: 40px !important;
}

.m-t-10 {
    margin-top: 10px !important;
}

.text-center {
    text-align: center;
}

.account-logo-box {
    background-color: #505458;
    padding: 10px;
    border-radius: 5px 5px 0 0;
}

.text-uppercase {
    text-transform: uppercase;
}

.cl-white {
    color: #fff;
}

.fs-20 {
    font-size: 20px;
}

.account-pages .account-content {
    padding: 30px;
}

.m-l-5 {
    margin-left: 5px !important;
}

.m-t-50 {
    margin-top: 50px !important;
}

.register {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.register-form {
    width: 360px;
}

.account-pages .account-btn {
    position: absolute;
    left: 0px;
    right: 0;
}

</style>
