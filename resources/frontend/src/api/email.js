import axios from 'axios'

const projectEmailSend = '/api/project/email'

export default {
    index (data) {
        return axios.get(projectEmailSend, {params: data})
    }
}
