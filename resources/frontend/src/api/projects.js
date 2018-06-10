import axios from 'axios'

const projectsResource = '/api/projects'

export default {
    index (data) {
        return axios.get(projectsResource, {params: data})
    },
    store (data) {
        return axios.post(projectsResource, data)
    },
    patch (id, data) {
        return axios.patch(projectsResource + '/' + id, data)
    },
    show(id) {
        return axios.get(projectsResource + '/' + id)
    },
    delete(id) {
        return axios.delete(projectsResource + '/' + id)
    },
    restore(data) {
        return axios.post('/api/project/restore-status', data)
    },
    company(id) {
        return axios.get('/api/project/company', {
            params: {
                project_id: id
            }
        })
    }
}
