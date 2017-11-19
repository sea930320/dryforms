import axios from 'axios'

const equipmentCategoriesRoute = '/api/categories'

export default {
    index (data) {
        return axios.get(equipmentCategoriesRoute, data)
    }
}
