<template>
  <div class="card text-center" v-if="isLoaded">
    <div class="card-header">
        {{ $route.meta.title }}
    </div>
    <div class="card-body">
      <b-list-group>
        <draggable v-model="forms" :options="{group:'people'}" @update="updateOrder(forms)">
          <transition-group name="list-complete">           
            <b-list-group-item v-for="item in forms" :key="item.name" class="mb-3 list-complete-item">{{ item.name }}</b-list-group-item>           
          </transition-group>
        </draggable>
      </b-list-group>      
    </div>
  </div>
  <loading v-else></loading>
</template>

<script type="text/babel">
  import draggable from 'vuedraggable'
  import _ from 'lodash'

  import {mapActions} from 'vuex'
  import Loading from '../layout/Loading'
  import apiFormsOrder from '../../api/forms_order'
  
  import ErrorHandler from '../../mixins/error-handler'

  export default {
      mixins: [ErrorHandler],
      name: 'Forms Order',
      components: { draggable, Loading },
      data () {
          return {
              forms: []
          }
      },
      computed: {
          isLoaded: function() {
              return this.forms.length !== 0
          }
      },
      created() {
          if (this.$store.state.StandardForm.formsOrder.length !== 0) {
              this.forms = this.$store.state.StandardForm.formsOrder.map(formOrder => {
                  return formOrder.standard_form[0]
              })
          }
      },
      methods: {
        ...mapActions([
            'fetchFormsOrder'
        ]),
        updateOrder: _.debounce(function (forms) {
            let formsOrder = this.$store.state.StandardForm.formsOrder
            let formsWithFormID = forms.map(function(form) {
                return form.form_id
            })
            formsOrder.sort(function(formA, formB) {
                let formAIndex = formsWithFormID.indexOf(formA.form_id)
                let formBIndex = formsWithFormID.indexOf(formB.form_id)
                return formAIndex - formBIndex
            })
            apiFormsOrder.store({
              formsOrder: formsOrder
            }).then(response => {
            }).catch(this.handleErrorResponse)
        }, 500)
      },
      watch: {
          '$store.state.StandardForm.formsOrder' (newVal, oldVal) {
              this.forms = newVal.map(formOrder => {
                  return formOrder.standard_form[0]
              })
          }
      }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
  .list-complete-item {
    transition: all 1s;
    cursor: pointer;
  }
  .list-complete-enter, .list-complete-leave-active {
    opacity: 0;
  }
</style>