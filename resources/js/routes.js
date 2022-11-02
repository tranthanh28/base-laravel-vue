import Home from './view/Home';
import About from './view/About';
import Register from './view/Register';
import Login from './view/Login';
import Dashboard from './view/Dashboard';
import NotFound from './view/NotFound';
import Settings from './view/settings/index';
import Profile from './view/settings/Profile';
import Password from './view/settings/Password';


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
            meta: { requiresAuth: true }
        },
        {
            path: '/about',
            component: About,
            meta: { guest: true }
        },
        {
            path: '/register',
            component: Register,
            meta: { guest: true },
        },
        {
            path: '/login',
            component: Login,
            meta: { guest: true },
            name: 'Login',
        },
        {
            path: "/dashboard",
            name: "Dashboard",
            component: Dashboard,
            meta: { requiresAuth: true },
        },
        {
            path: "/settings",
            component: Settings,
            meta: { requiresAuth: true },
            children: [
                { path: '', redirect: { name: 'settings.profile' } },
                {
                    path: "profile",
                    name: "settings.profile",
                    component: Profile,
                },
                {
                    path: "password",
                    name: "settings.password",
                    component: Password,
                }
            ]
        }

    ]
}
