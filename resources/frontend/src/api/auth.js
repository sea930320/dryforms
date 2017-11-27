import axios from 'axios'

const loginRoute = '/api/login'
const registerRoute = '/api/register'
const logoutRoute = '/api/logout'

export default {
    login (data) {
        return axios.post(loginRoute, data)
    },
    register(data) {
        return axios.post(registerRoute, data)
    },
    logout() {
        return axios.post(logoutRoute)
    }
}
