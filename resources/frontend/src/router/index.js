import Vue from 'vue'
import Router from 'vue-router'
import Dashboard from '@/components/main/Dashboard'
import Login from '@/components/auth/Login'
import Register from '@/components/auth/Register'

import settings from './settings'
import equipment from './equipment'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'Dashboard',
            component: Dashboard
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/register',
            name: 'Register',
            component: Register
        },
        ...settings(),
        ...equipment()
    ]
})
