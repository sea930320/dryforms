import axios from 'axios'

const scopesResource = '/api/project/scope'

export default {
    index (data) {
        return axios.get(scopesResource, {params: data})
    },
    store (data) {
        return axios.post(scopesResource, data)
    },
    patch (id, data) {
        return axios.patch(scopesResource + '/' + id, data)
    },
    show(id) {
        return axios.get(scopesResource + '/' + id)
    },
    delete(id) {
        return axios.delete(scopesResource + '/' + id)
    }
}
