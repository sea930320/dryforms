import apiCompanies from '../../api/companies'
import axios from 'axios'

const state = {
    user: [],
    company: []
}

const getters = {
    CompanyId: state => {
        return state.company.id
    },
    UserId: state => {
        return state.user.id
    }
}

const actions = {
    fetchUser ({dispatch, commit}) {
        axios.get('/api/account').then(response => {
            commit('setUser', response.data.user)
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
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
