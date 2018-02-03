import axios from 'axios'

const passwordRoute = '/api/account/password/change'
const emailRoute = '/api/account/email/change'
const userInfoRoute = '/api/account'
export default {
    changeEmail (data) {
        return axios.post(emailRoute, data)
    },
    changePassword(data) {
        return axios.post(passwordRoute, data)
    },
    userInformation() {
        return axios.get(userInfoRoute)
    }
}
