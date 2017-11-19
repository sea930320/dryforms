// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import Vuex from 'vuex'
import axios from 'axios'
import VueSession from 'vue-session'
import App from './components/layout/Main'
import router from './router'

Vue.config.productionTip = false

Vue.use(BootstrapVue)
Vue.use(Vuex)
Vue.use(VueSession)

const bus = new Vue()
Vue.prototype.$bus = bus

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    template: '<App/>',
    components: {App},
    http: {
        root: '/root',
        headers: {
            Authorization: 'Basic YXBpOnBhc3N3b3Jk'
        }
    }
})

axios.interceptors.request.use(config => {
    config.headers['Authorization'] = 'Bearer ' + Vue.prototype.$session.get('apiToken')

    return config
}, error => {
    // Do something with request error
    return Promise.reject(error)
})
