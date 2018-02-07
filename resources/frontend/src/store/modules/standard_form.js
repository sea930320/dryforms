import apiFormOrders from '../../api/form_orders'

const state = {
    formOrders: []
}

const getters = {
}

const actions = {
    fetchFormOrders ({dispatch, commit}) {
        apiFormOrders.index().then(response => {
            commit('setFormOrders', response.data)
        })
    }
}

const mutations = {
    setFormOrders (state, formOrders) {
        formOrders.forEach(form => {
            if (form.standard_form.length === 0) {
                form.standard_form.push({
                    id: null,
                    form_id: form.form_id,
                    company_id: form.company_id,
                    name: form.form.name,
                    title: form.form.name,
                    statement: ''
                })
            }
        })
        state.formOrders = formOrders
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
