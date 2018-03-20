import axios from 'axios'

const footerResource = '/api/project/get-footer'

export default {
    index (data) {
        return axios.get(footerResource, {params: data})
    },
    store (data) {
        return axios.post(footerResource, data)
    },
    patch (id, data) {
        return axios.patch(footerResource + '/' + id, data)
    },
    show(id) {
        return axios.get(footerResource + '/' + id)
    },
    delete(id) {
        return axios.delete(footerResource + '/' + id)
    }
}
