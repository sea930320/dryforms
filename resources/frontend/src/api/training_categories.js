import axios from 'axios'

const trainingCategoriesResource = '/api/training/categories'

export default {
    index (data) {
        return axios.get(trainingCategoriesResource, {params: data})
    }
}
