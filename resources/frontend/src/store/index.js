import Vue from 'vue'
import Vuex from 'vuex'
import User from './modules/user'
import Category from './modules/Category'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    User,
    Category
  }
})
