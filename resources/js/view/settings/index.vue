<template>
  <div class="row justify-content-center">
    <div class="col-md-3 mb-3">
        <el-card class="box-card">
            <div slot="header">
                <span>Settings</span>
            </div>
            <ul class="nav flex-column nav-pills">
                <li v-for="tab in tabs" :key="tab.route" class="nav-item">
                    <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
                        <i :class="tab.icon"></i>
                        {{ tab.name }}
                    </router-link>
                </li>
            </ul>
        </el-card>
    </div>

    <div class="col-md-7">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
import password from "./Password";

export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'el-icon-user-solid',
          name: 'Profile',
          route: 'settings.profile'
        },
        {
          icon: 'el-icon-key',
          name: 'Password',
          route: 'settings.password'
        }
      ]
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
