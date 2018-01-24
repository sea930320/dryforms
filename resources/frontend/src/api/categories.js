import axios from 'axios'

const categoriesResource = '/api/categories'

export default {
    index (data) {
        var query = data ? Object.keys(data).map(k => `${encodeURIComponent(k)}=${encodeURIComponent(data[k])}`).join('&') : ''
        return axios.get(categoriesResource + '?' + query, data)
    },
    store (data) {
        return axios.post(categoriesResource, data)
    },
    patch (id, data) {
        return axios.patch(categoriesResource + '/' + id, data)
    },
    show(id) {
        return axios.get(categoriesResource + '/' + id)
    },
    delete(id) {
        return axios.delete(categoriesResource + '/' + id)
    }
}
