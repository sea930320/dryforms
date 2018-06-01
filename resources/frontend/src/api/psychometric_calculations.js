import axios from 'axios'

const psychometricResource = '/api/psychometric/calculate'
const dewResource = '/api/psychometric/dew'

export default {
  index(data) {
    return axios.get(psychometricResource, {params: data})
  },
  calculateDew(data) {
    return axios.get(dewResource, {params: data})
  }
}
