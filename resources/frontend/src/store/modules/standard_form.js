import apiFormsOrder from '../../api/forms_order'

const state = {
    formsOrder: []
}

const getters = {
}

const actions = {
    fetchFormsOrder ({dispatch, commit}) {
        apiFormsOrder.index().then(response => {
            commit('setFormsOrder', response.data)
        })
    }
}

const mutations = {
    setFormsOrder (state, formsOrder) {
        formsOrder.forEach(form => {
            if (form.standard_form.length === 0) {
                form.standard_form.push({
                    id: null,
                    form_id: form.form_id,
                    company_id: form.company_id,
                    name: form.default_forms_data.name || form.form.name,
                    title: form.default_forms_data.title || form.form.name,
                    statement: form.default_forms_data.statement || ''
                })
            }
        })
        state.formsOrder = formsOrder
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
