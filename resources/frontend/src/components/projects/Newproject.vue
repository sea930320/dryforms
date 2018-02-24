<template>
  <b-modal id="selectForm" :title="$route.meta.title" v-model="showModal" v-if="isLoaded">
    <div v-for="form in forms" :key="form.form_id">
      <b-form-checkbox v-model="form.selected" value="1" unchecked-value="0">
        {{form.standard_form[0].name}}
      </b-form-checkbox>
    </div>
    <div slot="modal-footer" class="w-100">
      <b-btn variant="primary" class="float-right" @click="saveForm()">Save</b-btn>
    </div>
  </b-modal>
  <loading v-else></loading>
</template>

<script type="text/babel">
  import {mapActions} from 'vuex'
  import Loading from '../layout/Loading'
  import ErrorHandler from '../../mixins/error-handler'

  export default {
    mixins: [ErrorHandler],
    components: {
      Loading
    },
    data () {
      return {
        showModal: true,
        selelctedForm: []
      }
    },
    methods: {
      ...mapActions([
        'fetchFormsOrder'
      ]),
      saveForm () {
        let isSel = false
        this.forms.forEach((form) => {
          if (form.selected) {
            isSel = true
          }
        })
        if (!isSel) {
          this.$notify({
              type: 'error',
              title: 'Error',
              text: 'Please select forms'
          })
          return
        }
        this.$router.push('/forms/callreport')
      }
    },
    created() {
      this.fetchFormsOrder()
    },
    computed: {
      forms: function() {
          return this.$store.state.StandardForm.formsOrder
      },
      isLoaded: function() {
          return this.forms.length
      }
    },
    watch: {
      showModal: function () {
        if (!this.showModal) this.$router.push('/projects')
      }
    }
  }
</script>