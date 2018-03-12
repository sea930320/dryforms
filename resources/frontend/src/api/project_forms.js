import axios from 'axios'

const projectFormsResource = '/api/project/forms'

export default {
    index (data) {
        return axios.get(projectFormsResource, {params: data})
    },
    store (data) {
        return axios.post(projectFormsResource, data)
    },
    patch (id, data) {
        return axios.patch(projectFormsResource + '/' + id, data)
    },
    show(id) {
        return axios.get(projectFormsResource + '/' + id)
    },
    delete(id) {
        return axios.delete(projectFormsResource + '/' + id)
    }
}
