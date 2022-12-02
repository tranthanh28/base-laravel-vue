import Home from './view/Home';
import About from './view/About';
import Register from './view/Register';
import Login from './view/Login';
import Dashboard from './view/Dashboard';
import NotFound from './view/NotFound';
import Settings from './view/settings/index';
import Profile from './view/settings/Profile';
import Password from './view/settings/Password';
import Ifollow from './view/admin/Ifollow';


export default {
    mode: 'history',
    linkActiveClass: 'font-semibold',
    routes: [
        {
            path: '*',
            component: NotFound,
        },
        {
            path: '/',
            component: Home,
            name: "Home",
            meta: {
                requiresAuth: true,
                layout: 'AuthLayout',
            }
        },
        {
            path: '/about',
            component: About,
            meta: {
                guest: true,
                layout: 'DefaultLayout',
            },
            name: 'About',
        },
        {
            path: '/register',
            component: Register,
            meta: {
                guest: true,
                layout: 'DefaultLayout',
            },
            name: 'Register'
        },
        {
            path: '/login',
            component: Login,
            meta: {
                guest: true,
                layout: 'DefaultLayout',
            },
            name: 'Login',
        },
        {
            path: "/dashboard",
            name: "Dashboard",
            component: Dashboard,
            meta: {
                requiresAuth: true,
                layout: 'AuthLayout',
            },
        },
        {
            path: "/settings",
            component: Settings,
            meta: {
                requiresAuth: true,
                layout: 'AuthLayout',
            },
            children: [
                {path: '', redirect: {name: 'settings.profile'}},
                {
                    path: "profile",
                    name: "settings.profile",
                    component: Profile,
                    meta: {
                        requiresAuth: true,
                        layout: 'AuthLayout',
                    },
                },
                {
                    path: "password",
                    name: "settings.password",
                    component: Password,
                    meta: {
                        requiresAuth: true,
                        layout: 'AuthLayout',
                    },
                }
            ]
        },
        {
            path: "/admin/ifollow",
            name: "admin.ifollow",
            component: Ifollow,
            meta: {
                requiresAuth: true,
                layout: 'AuthLayout',
            },
        },

    ]
}
