import axios from 'axios'

const projectAreasResource = '/api/project/area'

export default {
    index (data) {
        return axios.get(projectAreasResource, {params: data})
    },
    store (data) {
        return axios.post(projectAreasResource, data)
    },
    patch (id, data) {
        return axios.patch(projectAreasResource + '/' + id, data)
    },
    show(id) {
        return axios.get(projectAreasResource + '/' + id)
    },
    delete(id) {
        return axios.delete(projectAreasResource + '/' + id)
    }
}
