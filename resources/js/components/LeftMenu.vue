<template>
    <div>

        <el-menu
            class="el-menu-vertical-demo"
            background-color="#545c64"
            text-color="#fff"
            :collapse="collapse"
            @select="menuSelected"
            active-text-color="#ffd04b"
        >
            <div class="d-flex justify-content-center">
                <h2 v-if="!collapse">Monitaz</h2>
                <img v-else src="/image/logo-thumb3.png" alt="Monitaz" style="width:28px; height: auto; margin: 5px auto 0px;">
            </div>
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
    <!--  <aside-->
    <!--    class="overflow-auto w-fix-280 flex-shrink-0 flex-grow-0 position-relative border-right left-menu"-->
    <!--  >-->
    <!--    <div class="container-fluid py-3">-->
    <!--      <ul class="nav flex-column">-->
    <!--        <li-->
    <!--          v-for="(item, index) in menuList"-->
    <!--          :key="index"-->
    <!--          :class="item.lineBottom ? 'nav-item line-bottom' : 'nav-item'"-->
    <!--        >-->
    <!--          <span-->
    <!--            v-if="item.route === '#'"-->
    <!--            class="nav-link d-inline-block disabled"-->
    <!--          >-->
    <!--            item.title-->
    <!--          </span>-->
    <!--          <router-link-->
    <!--            v-else-if="item.child.length === 0"-->
    <!--            event=""-->
    <!--            :to="{ name: item.route }"-->
    <!--            class="nav-link d-inline-block"-->
    <!--          >-->
    <!--            item.title-->
    <!--          </router-link>-->
    <!--          <span-->
    <!--            v-else-if="item.child.length > 0"-->
    <!--            class="nav-link d-inline-block item-menu-parent"-->
    <!--            @click="item.flagChild = !item.flagChild"-->
    <!--          >-->
    <!--            item.title-->
    <!--            <i v-if="!item.flagChild" class="el-icon-caret-bottom"></i>-->
    <!--            <i v-else class="el-icon-caret-top"></i>-->
    <!--          </span>-->
    <!--          <ul-->
    <!--            v-if="item.child.length > 0 && item.flagChild"-->
    <!--            class="nav flex-column ml-3"-->
    <!--          >-->
    <!--            <li v-for="(child, i) in item.child.length" :key="i" class="nav-item">-->
    <!--              <span-->
    <!--                v-if="child.route === '#'"-->
    <!--                class="nav-link d-inline-block disabled"-->
    <!--              >-->
    <!--                child.title-->
    <!--              </span>-->
    <!--              <router-link-->
    <!--                v-else-->
    <!--                event=""-->
    <!--                :to="{ name: child.route }"-->
    <!--                class="nav-link d-inline-block"-->
    <!--              >-->
    <!--                child.title-->
    <!--              </router-link>-->
    <!--            </li>-->
    <!--          </ul>-->
    <!--        </li>-->
    <!--      </ul>-->
    <!--    </div>-->
    <!--  </aside>-->
</template>

<script>
import LeftMenu from '../constant.json'
import {mapGetters} from 'vuex'

export default {
    data() {
        return {
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
