import axios from 'axios'

const equipmentModelsRoute = '/api/models'

export default {
    index (data) {
        var query = Object.keys(data).map(k => `${encodeURIComponent(k)}=${encodeURIComponent(data[k])}`).join('&')
        return axios.get(equipmentModelsRoute + '?' + query, data)
    }
}
