import axios from 'axios'

const uomsResource = '/api/uoms'

export default {
    index (data) {
        return axios.get(uomsResource, {params: data})
    },
    store (data) {
        return axios.post(uomsResource, data)
    },
    patch (id, data) {
        return axios.patch(uomsResource + '/' + id, data)
    },
    show(id) {
        return axios.get(uomsResource + '/' + id)
    },
    delete(id) {
        return axios.delete(uomsResource + '/' + id)
    }
}
