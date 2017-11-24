import axios from 'axios'

const passwordRoute = '/api/account/email/change'
const emailRoute = '/api/account/password/change'

export default {
    changeEmail (data) {
        return axios.post(emailRoute, data)
    },
    changePassword(data) {
        return axios.post(passwordRoute, data)
    }
}
