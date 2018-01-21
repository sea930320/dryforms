import axios from 'axios'
import apiAuth from '../api/auth'
import errorHandler from './error-handler'

export default {
    mixins: [errorHandler],
    data() {
        return {}
    },
    methods: {
        logout() {
            apiAuth.logout()
            axios.defaults.headers.common['Authorization'] = null
            this.$session.destroy()
            this.$router.push('/login')
            location.reload()
        },
        login() {
            apiAuth.login(this.user)
                .then(response => {
                    this._setToken(response)
                })
                .catch(this.handleErrorResponse)
        },
        register() {
            apiAuth.register(this.user)
                .then(response => {
                    this._setToken(response)
                })
                .catch(this.handleErrorResponse)
        },
        _setToken(response) {
            this.$session.start()
            this.$session.set('apiToken', response.data.token)
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token
            if (this.$route.query.redirect) {
              this.$router.push(this.$route.query.redirect)
            } else {
              this.$router.push('/')
            }
        }
    }
}
