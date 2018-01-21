import apiCategories from '../../api/equipment-categories'

const state = {
    categories: []
}

const getters = {
    Categories: state => {
        return state.categories
    }
}

const actions = {
    getCategories ({dispatch, commit}) {
        apiCategories.index().then(response => {
            console.log(response)
            commit('setCategories', response.data)
        })
    }
}

const mutations = {
    setCompany (state, company) {
        state.company = company
    },
    setUser (state, user) {
        state.user_id = user
        console.log('user id')
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
