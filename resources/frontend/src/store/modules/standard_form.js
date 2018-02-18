import apiFormsOrder from '../../api/forms_order'

const state = {
    formsOrder: []
}

const getters = {
    formPerID(state) {
        return function(formID) {
            return state.formsOrder.filter(form => {
                return form.form_id === parseInt(formID)
            })
        }
    }
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
                let standardForm = {
                    id: null,
                    form_id: form.form_id,
                    company_id: form.company_id,
                    name: form.default_forms_data.name || form.form.name,
                    title: form.default_forms_data.title || form.form.name,
                    additional_notes_show: form.default_forms_data.additional_notes_show,
                    footer_text_show: form.default_forms_data.footer_text_show,
                    footer_text: form.default_forms_data.footer_text,
                    insured_signature: form.default_forms_data.insured_signature,
                    company_signature: form.default_forms_data.company_signature
                }
                form.standard_form.push(standardForm)
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
