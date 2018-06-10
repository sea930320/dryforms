import axios from 'axios'

const ticketsResource = '/api/tickets'

export default {
    index (data) {
        return axios.get(ticketsResource, {params: data})
    },
    store (data) {
        return axios.post(ticketsResource, data)
    },
    patch (id, data) {
        return axios.patch(ticketsResource + '/' + id, data)
    },
    show(id) {
        return axios.get(ticketsResource + '/' + id)
    },
    delete(id) {
        return axios.delete(ticketsResource + '/' + id)
    },
    categories() {
        return axios.get('/api/ticket/categories')
    }
}
