<template>
    <section>
        <div class="container-alt">
            <div class="row">
                <div class="col-sm-12">

                    <div class="wrapper-page">

                        <div class="m-t-40 account-pages">
                            <div class="text-center account-logo-box">
                                <h2 class="text-uppercase cl-white fs-20">
                                    Đăng nhập
                                </h2>
                                <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                            </div>
                            <div class="account-content">

                                <el-form class="login-form" ref="form" :model="form" :rules="rules" label-width="0px">
                                    <el-form-item prop="email">
                                        <el-input v-model="form.email" placeholder="Email"
                                                  prefix-icon="el-icon-user-solid"></el-input>
                                    </el-form-item>
                                    <el-form-item prop="password">
                                        <el-input type="password" v-model="form.password" placeholder="Password"
                                                  prefix-icon="el-icon-lock"></el-input>
                                    </el-form-item>
                                    <div class="account-btn m-t-10">
                                        <div class="d-flex justify-content-center">
                                            <el-button class="login-button" type="primary" @click="loginUser">Đăng nhập
                                            </el-button>
                                            <a href="#" @click.prevent="loginGoogle">
                                                <img
                                                    src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"
                                                    style="margin-left: 3em;">
                                            </a>
                                        </div>
                                    </div>
                                </el-form>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <!-- end card-box-->


                        <div class="row m-t-50">
                            <div class="col-sm-12 text-center">
                                <p class="text-muted">Bạn chưa có tài khoản?
                                    <router-link to="/register" class="text-primary m-l-5">
                                        <b>Đăng ký</b></router-link>
                                </p>
                            </div>
                        </div>

                    </div>
                    <!-- end wrapper -->

                </div>
            </div>
        </div>
    </section>
    <!--    <div class="login">-->
    <!--        <el-card class="box-card">-->
    <!--                <h2>Login to your account</h2>-->

    <!--                <el-form class="login-form" ref="form" :model="form" :rules="rules" label-width="180px">-->
    <!--                    <el-form-item prop="email" label="Your e-mail">-->
    <!--                        <el-input v-model="form.email" placeholder="Email" prefix-icon="el-icon-user-solid"></el-input>-->
    <!--                    </el-form-item>-->
    <!--                    <el-form-item prop="password" label="Password">-->
    <!--                        <el-input type="password" v-model="form.password" placeholder="Password"-->
    <!--                                  prefix-icon="el-icon-lock"></el-input>-->
    <!--                    </el-form-item>-->
    <!--                    <el-form-item>-->
    <!--                        <el-button class="login-button" type="primary" @click="loginUser">Login</el-button>-->
    <!--                        <a href="#" @click.prevent="loginGoogle">-->
    <!--                            <img-->
    <!--                                src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"-->
    <!--                                style="margin-left: 3em;">-->
    <!--                        </a>-->
    <!--                    </el-form-item>-->
    <!--                </el-form>-->
    <!--        </el-card>-->
    <!--    </div>-->
</template>
<script>
import AuthMixin from "../mixins/auth-mixin"

export default {
    mixins: [ AuthMixin ],
    data() {
        return {
            token: localStorage.getItem('token'),
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
                    {min: 6, max: 20, message: 'Length should be 6 to 20', trigger: 'blur'}
                ],
            },
            errors: []
        }
    },
    created() {
        if (this.token) {
            this.checkAuthenticated()
        }
    },
    mounted() {
        window.addEventListener('message', this.onMessage, false)
    },

    beforeDestroy() {
        window.removeEventListener('message', this.onMessage)
    },
    methods: {
        loginUser() {
            this.$refs['form'].validate((valid) => {
                if (valid) {
                    this.startLoading()
                    axios.post('/api/login', this.form).then((response) => {
                        this.stopLoading()
                        localStorage.setItem('token', response.data.token);
                        this.$router.push({name: "Dashboard"});
                    }).catch((error) => {
                        this.stopLoading()
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
        },
        loginGoogle() {
            const newWindow = openWindow('', 'message')
            axios.get('/auth/google')
                .then(response => {
                    newWindow.location.href = response.data.url;
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        onMessage(e) {
            if (e.origin !== window.origin || !e.data.token) {
                return
            }
            localStorage.setItem('token', e.data.token)
            this.$router.push('/dashboard')
        }
    }
}

function openWindow(url, title, options = {}) {
    if (typeof url === 'object') {
        options = url
        url = ''
    }

    options = {url, title, width: 600, height: 720, ...options}

    const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
    const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
    const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
    const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height

    options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
    options.top = ((height / 2) - (options.height / 2)) + dualScreenTop

    const optionsStr = Object.keys(options).reduce((acc, key) => {
        acc.push(`${key}=${options[key]}`)
        return acc
    }, []).join(',')

    const newWindow = window.open(url, title, optionsStr)

    if (window.focus) {
        newWindow.focus()
    }

    return newWindow
}
</script>
<style scoped>
.container-alt {
    margin-left: auto;
    margin-right: auto;
    padding-left: 15px;
    padding-right: 15px;
}

.login {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-form {
    width: 360px;
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

.m-t-10 {
    margin-top: 10px !important;
}

.account-pages .account-btn {
    position: absolute;
    left: 0px;
    right: 0;
}
</style>
