import axios from 'axios'

const formsResource = '/api/forms'

export default {
    index (data) {
        return axios.get(formsResource, {params: data})
    },
    store (data) {
        return axios.post(formsResource, data)
    }
}
