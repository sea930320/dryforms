import Vue from 'vue'
import Vuex from 'vuex'
// import * as actions from './actions'
import User from './modules/user'
import Category from './modules/Category'

Vue.use(Vuex)

export default new Vuex.Store({
  // actions,
  modules: {
    User,
    Category
  }
})
