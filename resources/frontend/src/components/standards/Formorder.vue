<template>
  <div class="Forms-Order">
    <div class="card text-center" v-if="isLoaded">
      <div class="card-header">
          <h5> {{ $route.meta.title }} </h5>
      </div>
      <div class="card-body text-left pt-3 pb-3">
        <b-container class="">
          <b-list-group>
            <draggable v-model="forms" :options="{group:'people'}" @update="updateOrder(forms)">
              <transition-group name="list-complete">           
                <b-list-group-item v-for="item in forms" :key="item.name" class="mb-2 list-complete-item text-center">{{ item.name }}</b-list-group-item>
              </transition-group>
            </draggable>
          </b-list-group>
        </b-container>
      </div>
    </div>
    <loading v-else></loading>
  </div>
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
  .Forms-Order {
    .list-group-item {
      border: 0px;
      border-radius: 3px;
      margin-bottom: 6px;
      padding-top: 10px;
      background: linear-gradient(180deg, #ececec 0, rgba(36, 36, 36, 0.08) 10%, rgba(36, 36, 36, 0.08) 90%, #a2a2a2);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#a6000000",endColorstr="#00000000",GradientType=0);
    }
  }
</style>