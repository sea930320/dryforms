import axios from 'axios'

const passwordRoute = '/api/account/password/change'
const emailRoute = '/api/account/email/change'
const userInfoRoute = '/api/account'
const subscribeRoute = '/api/account/subscribe'
const cancelSubscribeRoute = '/api/account/cancel-subscribe'
const resumeSubscribeRoute = '/api/account/resume-subscribe'
const getInvoicesRoute = '/api/account/get-invoices'

export default {
    changeEmail (data) {
        return axios.post(emailRoute, data)
    },
    changePassword(data) {
        return axios.post(passwordRoute, data)
    },
    userInformation() {
        return axios.get(userInfoRoute)
    },
    subscribe(data) {
        return axios.post(subscribeRoute, data)
    },
    cancelSubscribe(data) {
        return axios.get(cancelSubscribeRoute, {params: data})
    },
    resumeSubscribe(data) {
        return axios.get(resumeSubscribeRoute, {params: data})
    },
    getInvoices(data) {
        return axios.get(getInvoicesRoute, {params: data})
    }
}
