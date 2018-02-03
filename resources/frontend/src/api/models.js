import axios from 'axios'

const modelsResource = '/api/models'

export default {
    index (data) {
        return axios.get(modelsResource, {params: data})
    },
    store (data) {
        return axios.post(modelsResource, data)
    },
    patch (id, data) {
        return axios.patch(modelsResource + '/' + id, data)
    },
    show(id) {
        return axios.get(modelsResource + '/' + id)
    },
    delete(id) {
        return axios.delete(modelsResource + '/' + id)
    }
}
