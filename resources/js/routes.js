import Home from './components/Home';
import About from './components/About';
import Register from './components/Register';
import Login from './components/Login';
import Dashboard from './components/Dashboard';
import NotFound from './components/NotFound';


export default {
    mode: 'history',
    linkActiveClass: 'font-semibold',
    routes: [
        {
            path: '*',
            component: NotFound,
            meta: {guest: true}
        },
        {
            path: '/',
            component: Home,
            name: "Home",
            meta: {guest: true}
        },
        {
            path: '/about',
            component: About,
            meta: {guest: true}
        },
        {
            path: '/register',
            component: Register,
            meta: {guest: true}
        },
        {
            path: '/login',
            component: Login,
            name: 'Login',
            meta: {guest: true}
        },
        {
            path: "/dashboard",
            name: "Dashboard",
            component: Dashboard,
            meta: {requiresAuth: true}
        }

    ]
}
