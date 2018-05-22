import apiTrainingVideos from '../../api/training_videos'

const state = {
    trainingVideos: [],
    category_id: null
}

const getters = {
    trainingVideoPerID(state) {
        return function(categoryID) {
            return state.trainingCategories.filter(video => {
                return video.category_id === parseInt(categoryID)
            })
        }
    }
}

const actions = {

    fetchTrainingVideo ({dispatch, commit}) {
        apiTrainingVideos.index({
            category_id: this.state.TrainingVideo.category_id
        }).then((response) => {
            if (response.data.length > 0) {
                commit('setTrainingVideos', response.data)
            }
        })
    }
}

const mutations = {
    setTrainingVideos (state, trainingVideos) {
        state.trainingVideos = trainingVideos
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
