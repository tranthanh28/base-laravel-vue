<template>
    <el-header style="height: 70px; background-color: #f3f3f3; padding-left:0px"
               class="topbar">

        <!-- LOGO -->
        <!--            <div class="topbar-left">-->
        <!--                <a href="http://app.monitaz.asia/dashboard" class="logo"><span>M<span>onitaz</span></span><i class="mdi mdi-layers"></i></a>-->
        <!--            </div>-->

        <!--            &lt;!&ndash; Button mobile view to collapse sidebar menu &ndash;&gt;-->
        <!--            <div class="navbar navbar-default" role="navigation">-->
        <!--                <div class="container">-->

        <!--                    &lt;!&ndash; Navbar-left &ndash;&gt;-->
        <!--                    <ul class="nav navbar-nav navbar-left">-->
        <!--                        <li>-->
        <!--                            <button class="button-menu-mobile open-left waves-effect" fdprocessedid="1wdgtr">-->
        <!--                                <i class="mdi mdi-menu"></i>-->
        <!--                            </button>-->
        <!--                        </li>-->
        <!--                        <li class="hidden-xs">-->
        <!--                            <form role="search" class="app-search">-->
        <!--                                <input type="text" placeholder="Tìm kiếm..." class="form-control" fdprocessedid="ckpsh">-->
        <!--                                <a href="#"><i class="fa fa-search"></i></a>-->
        <!--                            </form>-->
        <!--                        </li>-->
        <!--                    </ul>-->

        <!--                    &lt;!&ndash; Right(Notification) &ndash;&gt;-->
        <!--                    <ul class="nav navbar-nav navbar-right">-->
        <!--                        <li>-->
        <!--                            <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">-->
        <!--                                <i class="mdi mdi-bell"></i>-->
        <!--                                <span class="badge up bg-success">4</span>-->
        <!--                            </a>-->

        <!--                            <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right dropdown-lg user-list notify-list">-->
        <!--                                <li>-->
        <!--                                    <h5>Thông báo</h5>-->
        <!--                                </li>-->
        <!--                                <li class="all-msgs text-center">-->
        <!--                                    <p class="m-0"><a href="#">Xem tất cả thông báo</a></p>-->
        <!--                                </li>-->
        <!--                            </ul>-->
        <!--                        </li>-->

        <!--                        <li class="dropdown user-box">-->
        <!--                            <a href="#" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">-->
        <!--                                <img src="https://www.vhv.rs/dpng/d/421-4213265_transparent-no-avatar-png-avatar-user-login-icon.png" alt="user-img" class="img-circle user-img">-->
        <!--                            </a>-->

        <!--                            <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">-->
        <!--                                <li>-->
        <!--                                    <h5>Chào Admin</h5>-->
        <!--                                </li>-->
        <!--                                <li><a href="javascript:void(0)"><i class="ti-user m-r-5"></i> Thông tin</a></li>-->
        <!--                                <li><a href="javascript:void(0)"><i class="ti-settings m-r-5"></i> Cài đặt</a></li>-->
        <!--                                <li><a class="dropdown-item" href="http://app.monitaz.asia/logout" onclick="event.preventDefault();-->
        <!--                                                     document.getElementById('logout-form').submit();">-->
        <!--                                    <i class="fa fa-sign-out m-r-5"></i> Đăng xuất-->
        <!--                                </a></li>-->

        <!--                                <form id="logout-form" action="http://app.monitaz.asia/logout" method="POST" style="display: none;">-->
        <!--                                    <input type="hidden" name="_token" value="1ZiCb9GHldqTMku0e8PVo2CWmkl5dykAU5hjexDQ">                                </form>-->

        <!--                                <li><a href="/password/reset"><i class="ti-user m-r-5"></i> Đổi mật khẩu</a></li>-->
        <!--                            </ul>-->
        <!--                        </li>-->

        <!--                    </ul>-->
        <!--                    &lt;!&ndash; end navbar-right &ndash;&gt;-->

        <!--                </div>-->
        <!--                &lt;!&ndash; end container &ndash;&gt;-->
        <!--            </div>-->


        <div>
            <div class="topbar-left" :class="[collapse ? 'topbar-left-collapse' : 'topbar-left-not-collapse']">
                <div v-if="!collapse">
                    <div>
                        <router-link to="/dashboard" class="logo"><span>M<span>onitaz</span></span></router-link>
                    </div>
                </div>
                <img v-else src="/image/logo-thumb3.png" alt="Monitaz"
                     style="width:28px; height: auto; margin: 5px auto 0px;">
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between align-content-stretch">
            <div style="width: 200px" class="d-flex align-items-center">
                <button @click.exact="collapseMenu" class="button-menu-mobile" v-waves>
                    <mdicon name="menu"/>
                </button>
                <el-input
                    class="custom-input"
                    placeholder="Tìm kiếm ..."
                    suffix-icon="el-icon-search"
                    v-model="search">
                </el-input>
            </div>

            <div class="d-flex align-items-center float-end right-menu-item navbar-default">
                <el-dropdown trigger="click">
                    <el-badge :value="12" class="item right-menu-item d-flex justify-content-center align-items-center">
                        <mdicon name="bell" :size="18"/>
                    </el-badge>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item disabled style="background-color: #f3f3f3;">Thông báo
                        </el-dropdown-item>
                        <el-dropdown-item> Xem tất cả thông báo
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
                <el-dropdown trigger="click">
                    <div class="el-dropdown-link d-flex align-items-center">
                        <el-avatar icon="el-icon-user-solid"></el-avatar>
                        <i class="el-icon-arrow-down el-icon--right"></i>
                    </div>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item disabled style="background-color: #f3f3f3;">Chào {{
                                user.name
                            }}
                        </el-dropdown-item>
                        <el-dropdown-item icon="el-icon-user-solid" @click.native="toProfile" divided>Thông tin
                        </el-dropdown-item>
                        <el-dropdown-item icon="el-icon-s-tools" @click.native="setting">
                            Cài đặt
                        </el-dropdown-item>
                        <el-dropdown-item @click.native="logout">
                            <font-awesome-icon icon="fa-solid fa-arrow-right-from-bracket"/>
                            Đăng xuất
                        </el-dropdown-item>
                        <el-dropdown-item icon="el-icon-user-solid" @click.native="toChangePass">Đổi mật khẩu
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </div>
        </div>

    </el-header>
</template>
<script>
import {mapGetters} from 'vuex'

export default {
    name: 'Navbar',
    data() {
        return {
            search: '',
            defaultActive: "1",
            token: localStorage.getItem('token'),
        }
    },
    computed: mapGetters({
        user: 'auth/user',
        collapse: 'common/collapse'
    }),
    methods: {
        setting() {
            this.$router.push("/settings")
        },
        toChangePass() {
            this.$router.push({name: "settings.password"})
        },
        toProfile() {
            this.$router.push("/dashboard")
        },
        logout() {
            axios.post('/api/logout').then(() => {
                localStorage.removeItem('token')
                this.$store.dispatch('auth/logout')
                this.$router.push('/login')
            }).catch((errors) => {
                console.log(errors)
            })
        },
        collapseMenu() {
            this.$store.dispatch('common/toggleCollapse');
        }
    }
}
</script>
<style>
.custom-input input {
    border-radius: 30px;
}

.mdi-bell:hover {
    color: #333;
}
</style>
<style scoped>
.topbar .topbar-left {
    background: #36404e;
    float: left;
    text-align: center;
    height: 70px;
    position: relative;
    z-index: 1;
}

.topbar-left-collapse {
    width: 63px;
}

.topbar-left-not-collapse {
    width: 199px
}

.topbar {
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 999;
}

.navbar-default .right-menu-item {
    height: 36px;
    width: 36px;
    padding: 0;
    font-size: 18px;
    border: 2px solid #ccc !important;
    line-height: 35px;
    text-align: center;
    border-radius: 50%;
    margin: 9px 30px;
}

.item {
    margin-top: 10px;
    margin-right: 40px;
}

.logo {
    color: #fff !important;
    font-size: 24px;
    font-family: 'Hind Madurai', sans-serif;
    font-weight: 600;
    letter-spacing: 1px;
    line-height: 70px;
    text-decoration: none;
    text-transform: uppercase;

}

.logo span span {
    color: #7fc1fc;
}
</style>
