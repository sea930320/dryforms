import axios from 'axios'

const modelsResource = '/api/statuses'

export default {
    index (data) {
        return axios.get(modelsResource, data)
    }
}
