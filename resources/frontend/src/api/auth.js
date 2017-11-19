import axios from 'axios'

const loginRoute = '/api/login'
const logoutRoute = '/api/logout'
// const registerRoute = '/api/register'

export default {
    login (data) {
        return axios.post(loginRoute, data)
    },
    logout() {
        return axios.post(logoutRoute)
    }
}
