import axios from 'axios'

const projectFormSignatureResource = '/api/project/set-signature'

export default {
    store (data) {
        return axios.post(projectFormSignatureResource, data)
    }
}
