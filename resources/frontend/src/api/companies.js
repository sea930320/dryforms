import axios from 'axios'

const companiesResource = '/api/companies'

export default {
    store (data) {
        return axios.post(companiesResource, data)
    },
    patch (id, data) {
        return axios.patch(companiesResource + '/' + id, data)
    },
    show(id) {
        return axios.get(companiesResource + '/' + id)
    }
}
