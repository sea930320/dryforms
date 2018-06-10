import axios from 'axios'

const eventsResource = '/api/events'

export default {
    index (data) {
        return axios.get(eventsResource, {params: data})
    },
    store (data) {
        return axios.post(eventsResource, data)
    },
    patch (id, data) {
        return axios.patch(eventsResource + '/' + id, data)
    },
    show(id) {
        return axios.get(eventsResource + '/' + id)
    },
    delete(id) {
        return axios.delete(eventsResource + '/' + id)
    }
}
