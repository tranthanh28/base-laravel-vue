/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import consola from "consola";

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import routes from './routes';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import store from './store';
import mixin from './mixins/mixin';

require('./plugins/mdivue');
require('./plugins/slimscroll');

//wavesEffect
import Waves from 'vue-waves-effect';
import 'vue-waves-effect/dist/vueWavesEffect.css';

Vue.use(Waves);


/* import the fontawesome core */
import {library} from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'

/* import specific icons */
import {fas} from '@fortawesome/free-solid-svg-icons'

/* add icons to the library */
library.add(fas)

/* add font awesome icon component */
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.mixin(mixin);

Vue.config.productionTip = false
Vue.use(VueRouter);
const router = new VueRouter(routes)

function loggedIn() {
    return localStorage.getItem('token')
}

// check middleware
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!loggedIn()) {
            next({
                path: '/login',
                query: {redirect: to.fullPath}
            })
        } else {
            let data = localStorage.getItem('vuex')
            let user = JSON.parse(data)?.auth?.user
            //lay dc permissions cua user=> luu vao localstorage.
            //=> trong man left menu cung check lai permission
            // => trong app js check xem khi vao trang co meta.permissions(ex: check_url)
            // kiem tra permissions cua user: user.permissions == to.meta.permissions
            // => neu dung thi hien thi
            // con không đúng thì không hiển thị


            if (user?.status === 0) {
                next({
                    path: '/error/403'
                })
            } else if ((to.meta.role == 'admin' && !user.is_role_admin) || (to.meta.permission && !user?.permissions.includes(to.meta.permission))) {
                next({
                    path: '/'
                })
            } else {
                next()
            }
        }
    }
        // else if (to.matched.some(record => record.meta.guest)) {
        //     if (loggedIn()) {
        //         next({
        //             path: '/',
        //             query: { redirect: to.fullPath }
        //         })
        //     } else {
        //     next()
        //     }
    // }
    else {
        next() // make sure to always call next()!
    }
})

Vue.use(ElementUI);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app', require('./components/App.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    router
});
