import axios from 'axios'

const psychometricResource = '/api/project/psychometric'
const psychometricUpdateTime = '/api/project/psychometric/updatetime'

export default {
    index (data) {
        return axios.get(psychometricResource, {params: data})
    },
    store (data) {
        return axios.post(psychometricResource, data)
    },
    patch (id, data) {
        return axios.patch(psychometricResource + '/' + id, data)
    },
    delete(id) {
        return axios.delete(psychometricResource + '/' + id)
    },
    updatetime(data) {
        return axios.post(psychometricUpdateTime, data)
    }
}
