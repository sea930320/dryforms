import axios from 'axios'

const projectStatusResource = '/api/project/status'

export default {
    index (data) {
        return axios.get(projectStatusResource, {params: data})
    },
    store (data) {
        return axios.post(projectStatusResource, data)
    },
    patch (id, data) {
        return axios.patch(projectStatusResource + '/' + id, data)
    },
    show(id) {
        return axios.get(projectStatusResource + '/' + id)
    },
    delete(id) {
        return axios.delete(projectStatusResource + '/' + id)
    }
}
