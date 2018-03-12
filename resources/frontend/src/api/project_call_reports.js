import axios from 'axios'

const projectCallReportsResource = '/api/project/call_reports'

export default {
    index (data) {
        return axios.get(projectCallReportsResource, {params: data})
    },
    store (data) {
        return axios.post(projectCallReportsResource, data)
    },
    patch (id, data) {
        return axios.patch(projectCallReportsResource + '/' + id, data)
    },
    show(id) {
        return axios.get(projectCallReportsResource + '/' + id)
    },
    delete(id) {
        return axios.delete(projectCallReportsResource + '/' + id)
    }
}
