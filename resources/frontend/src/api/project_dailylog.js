import axios from 'axios'

const dailylogResource = '/api/project/dailylog'

export default {
    index (data) {
        return axios.get(dailylogResource, {params: data})
    },
    store (data) {
        return axios.post(dailylogResource, data)
    },
    patch (id, data) {
        return axios.patch(dailylogResource + '/' + id, data)
    },
    show(id) {
        return axios.get(dailylogResource + '/' + id)
    },
    delete(id) {
        return axios.delete(dailylogResource + '/' + id)
    }
}
