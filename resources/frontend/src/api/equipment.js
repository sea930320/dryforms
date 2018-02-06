import axios from 'axios'

const equipmentResource = '/api/equipment'

export default {
    index (data) {
        return axios.get(equipmentResource, {params: data})
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
    valdiateSerial(serial, categoryId) {
      if (categoryId) {
        return axios.get('/api/validate-serial/' + serial + '/category_id/' + categoryId)
      }
    }
}
