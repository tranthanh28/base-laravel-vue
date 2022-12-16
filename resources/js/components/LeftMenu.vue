<template>
    <div>
<!--        v-slimscroll="options"-->
        <el-menu
            class="el-menu-vertical-demo side-menu"
            background-color="#36404e"
            text-color="#98a6ad"
            :collapse="collapse"
            @select="menuSelected"
            active-text-color="#7fc1fc"
            :collapse-transition="false"
        >
            <div v-for="(item, index) in menuList" :key="index">
                <el-submenu v-if="item.child && item.child.length > 0" :index="item.route">
                    <template slot="title">
                        <i :class="item.icon"></i>
                        <span>{{ item.title }}</span>
                    </template>
                    <el-menu-item v-for="childItem in item.child" :key="childItem.title" :index="childItem.route">
                        <span>{{ childItem.title }}</span>
                    </el-menu-item>
                </el-submenu>
                <el-menu-item v-else :index="item.route">
                    <i :class="item.icon"></i>
                    <span>{{
                            item.title
                        }}</span>

                </el-menu-item>
            </div>
        </el-menu>
    </div>
</template>

<script>
import LeftMenu from '../constant.json'
import {mapGetters} from 'vuex'

export default {
    data() {
        return {
            options: {
                height: "auto",
                position: "right",
                size: "5px",
                color: "#dcdcdc",
                wheelStep: 5
            },
            totalMsgUnread: '',
            role: '',
            activeName: 'first',
            menuList: [
                {
                    path: '#',
                    title: "",
                },
            ],
        }
    },
    computed: {
        ...mapGetters({
            collapse: 'common/collapse'
        })
    },
    created() {
        this.menuList = LeftMenu.leftMenu.default
    },
    methods: {
        menuSelected(index) {
            this.$router.push(`${index}`);
        }
    }
}
</script>

<style lang="scss">
.el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 200px;
    min-height: 400px;
}

.el-menu--collapse .el-menu-item [class^=el-icon-],
.el-menu--collapse .el-submenu > .el-submenu__title [class^=el-icon-] {
    margin: 0;
    vertical-align: middle;
    width: 24px;
    text-align: center;
}

.el-menu--collapse .el-menu-item span,
.el-menu--collapse .el-submenu > .el-submenu__title span {
    height: 0;
    width: 0;
    overflow: hidden;
    visibility: hidden;
    display: inline-block;
}
</style>
<style scoped>
/*body.fixed-left .side-menu {*/
/*    bottom: 50px;*/
/*    margin-bottom: -70px;*/
/*    margin-top: 0;*/
/*    padding-bottom: 70px;*/
/*    position: fixed;*/
/*}*/

.side-menu {
    /*position: absolute;*/
    z-index: 10;
    height: 100vh;
}

/*.side-menu {*/
/*    !*width: 225px;*!*/
/*    padding-top: 10px;*/
/*    z-index: 10;*/
/*    !*background: #36404e;*!*/
/*    bottom: 50px;*/
/*    margin-top: 0;*/
/*    padding-bottom: 70px;*/
/*    !*position: fixed;*!*/
/*    top: 0;*/
/*    box-shadow: 0 0 24px 0 rgba(0,0,0,.06),0 1px 0 0 rgba(0,0,0,.02);*/
/*}*/
</style>
