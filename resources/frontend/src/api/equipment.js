import axios from 'axios'

const equipmentResource = '/api/equipment'

export default {
    index (data) {
        var query = data ? Object.keys(data).map(k => `${encodeURIComponent(k)}=${encodeURIComponent(data[k])}`).join('&') : ''
        return axios.get(equipmentResource + '?' + query)
    },
    store (data) {
        return axios.post(equipmentResource, data)
    },
    patch (id, data) {
        return axios.patch(equipmentResource + '/' + id, data)
    },
    show(id) {
        return axios.get(equipmentResource + '/' + id)
    },
    delete(id) {
        return axios.delete(equipmentResource + '/' + id)
    },
    valdiateSerial(serial, modelId) {
      return axios.get('/api/validate-serial/' + serial + '/' + modelId)
    }
}
