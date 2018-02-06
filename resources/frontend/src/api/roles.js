import axios from 'axios'

const rolesResource = '/api/roles'

export default {
    index (data) {
        return axios.get(rolesResource, {params: data})
    }
}
