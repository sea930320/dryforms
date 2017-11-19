import axios from 'axios'

const teamsRoute = '/api/teams'

export default {
    index (data) {
        return axios.get(teamsRoute, data)
    },
    store (data) {
        return axios.post(teamsRoute, data)
    },
    patch (id, data) {
        return axios.patch(teamsRoute + '/' + id, data)
    },
    show(id) {
        return axios.get(teamsRoute + '/' + id)
    }
}
