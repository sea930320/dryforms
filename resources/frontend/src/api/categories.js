import axios from 'axios'

const categoriesResource = '/api/categories'

export default {
    index (data) {
        return axios.get(categoriesResource, {params: data})
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
