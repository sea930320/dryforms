import axios from 'axios'

const psychometricResource = '/api/psychometric/calculate'

export default {
    index (data) {
        return axios.get(psychometricResource, {params: data})
    }
}
