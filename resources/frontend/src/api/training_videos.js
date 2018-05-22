import axios from 'axios'

const trainingVideosResource = '/api/training/videos'

export default {
    index (data) {
        return axios.get(trainingVideosResource, {params: data})
    }
}
