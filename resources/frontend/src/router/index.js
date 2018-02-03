import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from '@/components/main/Dashboard'
import Login from '@/components/auth/Login'
import Register from '@/components/auth/Register'

import settings from './settings'
import equipment from './equipment'
import projects from './projects'
import standards from './standards'
import forms from './forms'

Vue.use(VueRouter)

const router = new VueRouter({
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
        ...projects(),
        ...settings(),
        ...equipment(),
        ...standards(),
        ...forms()
    ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    var sess = router.app.$session

    if (sess.exists() && sess.get('apiToken')) {
      next()
    } else {
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      })
    }
  } else {
    next()
  }
})

export default router
