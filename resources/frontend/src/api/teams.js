import axios from 'axios'

const teamsResource = '/api/teams'

export default {
    index (data) {
        return axios.get(teamsResource, {params: data})
    },
    store (data) {
        return axios.post(teamsResource, data)
    },
    patch (id, data) {
        return axios.patch(teamsResource + '/' + id, data)
    },
    show(id) {
        return axios.get(teamsResource + '/' + id)
    },
    delete(id) {
        return axios.delete(teamsResource + '/' + id)
    }
}
