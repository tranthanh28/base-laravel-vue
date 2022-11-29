<template>
    <div class="login">
        <el-card class="box-card">
                <h2>Login to your account</h2>

                <el-form class="login-form" ref="form" :model="form" :rules="rules" label-width="180px">
                    <el-form-item prop="email" label="Your e-mail">
                        <el-input v-model="form.email" placeholder="Email" prefix-icon="el-icon-user-solid"></el-input>
                    </el-form-item>
                    <el-form-item prop="password" label="Password">
                        <el-input type="password" v-model="form.password" placeholder="Password"
                                  prefix-icon="el-icon-lock"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button class="login-button" type="primary" @click="loginUser">Login</el-button>
                        <a href="#" @click.prevent="loginGoogle">
                            <img
                                src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"
                                style="margin-left: 3em;">
                        </a>
                    </el-form-item>
                </el-form>
        </el-card>
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
                    {min: 6, max: 20, message: 'Length should be 6 to 20', trigger: 'blur'}
                ],
            },
            errors: []
        }
    },
    mounted() {
        console.log('mounted')
        window.addEventListener('message', this.onMessage, false)
    },

    beforeDestroy() {
        window.removeEventListener('message', this.onMessage)
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
.login {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-form {
    width: 600px;
}

</style>
