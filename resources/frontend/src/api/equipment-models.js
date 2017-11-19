import axios from 'axios'

const equipmentModelsRoute = '/api/models'

export default {
    index (data) {
        return axios.get(equipmentModelsRoute, data)
    }
}
