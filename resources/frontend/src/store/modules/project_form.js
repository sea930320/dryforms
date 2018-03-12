const state = {
    projectForms: [],
    projectId: null
}

const getters = {
    projectFormPerID(state) {
        return function(formID) {
            return state.projectForms.filter(form => {
                return form.form_id === parseInt(formID)
            })
        }
    }
}

const actions = {
}

const mutations = {
}

export default {
    state,
    getters,
    mutations,
    actions
}
