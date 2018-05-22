import Vue from 'vue'
import Vuex from 'vuex'
import User from './modules/user'
import Category from './modules/Category'
import StandardForm from './modules/standard_form'
import ProjectForm from './modules/project_form'
import TrainingCategory from './modules/training_category'
import TrainingVideo from './modules/training_video'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    User,
    Category,
    StandardForm,
    ProjectForm,
    TrainingCategory,
    TrainingVideo
  }
})
