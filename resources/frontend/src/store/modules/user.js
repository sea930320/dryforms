import apiCompanies from '../../api/companies'
import axios from 'axios'

const state = {
    user: [],
    company: [],
    isSubscribed: false,
    isGracePeriod: false
}

const getters = {
    companyId: state => {
        return state.company.id
    },
    userId: state => {
        return state.user.id
    }
}

const actions = {
    fetchUser ({dispatch, commit}) {
        axios.get('/api/account').then(response => {
            commit('setUser', response.data.user)
            commit('setSubscription', {
                isSubscribed: response.data.isSubscribed,
                isGracePeriod: response.data.isGracePeriod
            })
            apiCompanies.show(response.data.user.id).then(response => {
                commit('setCompany', response.data)
            })
        })
    }
}

const mutations = {
    setCompany (state, company) {
        state.company = company
    },
    setUser (state, user) {
        state.user = user
    },
    setSubscription(state, data) {
        state.isSubscribed = data.isSubscribed
        state.isGracePeriod = data.isGracePeriod
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
