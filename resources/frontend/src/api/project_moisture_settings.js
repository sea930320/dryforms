import axios from 'axios'

const moistureResource = '/api/project/moisture'

export default {
    index (data) {
        return axios.get(moistureResource, {params: data})
    },
    store (data) {
        return axios.post(moistureResource, data)
    },
    patch (id, data) {
        return axios.patch(moistureResource + '/' + id, data)
    },
    show(id) {
        return axios.get(moistureResource + '/' + id)
    },
    delete(id) {
        return axios.delete(moistureResource + '/' + id)
    }
}
