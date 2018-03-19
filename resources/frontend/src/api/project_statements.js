import axios from 'axios'

const projectStatementsResource = '/api/project/statement'

export default {
    index (data) {
        return axios.get(projectStatementsResource, {params: data})
    },
    store (data) {
        return axios.post(projectStatementsResource, data)
    },
    patch (id, data) {
        return axios.patch(projectStatementsResource + '/' + id, data)
    },
    show(id) {
        return axios.get(projectStatementsResource + '/' + id)
    },
    delete(id) {
        return axios.delete(projectStatementsResource + '/' + id)
    }
}
