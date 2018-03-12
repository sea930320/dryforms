import Vue from 'vue'
import Vuex from 'vuex'
import User from './modules/user'
import Category from './modules/Category'
import StandardForm from './modules/standard_form'
import ProjectForm from './modules/project_form'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    User,
    Category,
    StandardForm,
    ProjectForm
  }
})
