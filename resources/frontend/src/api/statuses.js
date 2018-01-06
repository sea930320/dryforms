import axios from 'axios'

const statusesResource = '/api/statuses'

export default {
    index (data) {
        return axios.get(statusesResource, data)
    }
}
