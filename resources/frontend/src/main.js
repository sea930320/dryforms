// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import VueConfig from 'vue-configuration'
import BootstrapVue from 'bootstrap-vue'
import axios from 'axios'
import VueSession from 'vue-session'
import Notifications from 'vue-notification'
import vueSignature from 'vue-signature'
import lodash from 'lodash'
import VueLodash from 'vue-lodash'
import App from './components/layout/Main'
import router from './router'
import store from './store'
import VeeValidate from 'vee-validate'
import globalMixin from './mixins/global-mixin'
import appConfig from './config/app'
import FullCalendar from 'vue-full-calendar'
// import moment from 'moment'
// import VueMomentJS from 'vue-momentjs'

Vue.config.productionTip = false
Vue.config.devtools = true

Vue.use(VueConfig, {
  config: appConfig
})
Vue.use(BootstrapVue)
Vue.use(VueSession)
Vue.use(Notifications)
Vue.use(vueSignature)
Vue.use(VueLodash, lodash)
Vue.use(VeeValidate)
Vue.use(FullCalendar)
// Vue.use(VueMomentJS, moment)

const bus = new Vue()
Vue.prototype.$bus = bus
Vue.mixin(globalMixin)

/* eslint-disable no-new */
const vue = new Vue({
    el: '#app',
    router,
    store,
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
    return Promise.reject(error)
})

axios.interceptors.response.use(response => {
    return response
}, error => {
    // if (!Vue.prototype.$session.get('apiToken')) {
    //     vue.$router.push('/logout')
    // }
    if (error.response.data.message === 'Token has expired' && Vue.prototype.$session.get('apiToken')) {
        axios.get('/api/refresh')
            .then(response => {
                Vue.prototype.$session.remove('apiToken')
                Vue.prototype.$session.set('apiToken', response.data.token)
            })
            .catch(() => {
                Vue.prototype.$session.remove('apiToken')
                vue.$router.push('/logout')
            })
    }
    if (error.response.data.message === 'The token has been blacklisted') {
        Vue.prototype.$session.remove('apiToken')
        vue.$router.push('/logout')
    }

    return Promise.reject(error.response)
})
