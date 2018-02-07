import axios from 'axios'

const formOrdersResource = '/api/standard/form_orders'

export default {
    index (data) {
        return axios.get(formOrdersResource, {params: data})
    },
    store (data) {
        return axios.post(formOrdersResource, data)
    },
    patch (id, data) {
        return axios.patch(formOrdersResource + '/' + id, data)
    },
    show(id) {
        return axios.get(formOrdersResource + '/' + id)
    },
    delete(id) {
        return axios.delete(formOrdersResource + '/' + id)
    }
}
