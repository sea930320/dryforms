<template>
  <b-modal id="selectForm" :title="$route.meta.title" v-model="showModal" v-if="isLoaded">
    <div v-for="form in forms" :key="form.form_id" v-if="form.form_id != 1">
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
  import apiProjects from '../../api/projects'
  import apiProjectForms from '../../api/project_forms'
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
        'fetchFormsOrder',
        'fetchUser'
      ]),
      saveForm () {
        let isSel = false
        let projectForms = [{
          form_id: 1,
          company_id: this.user.company_id,
          project_id: null
        }]
        this.forms.forEach((form) => {
          if (form.selected === '1') {
            isSel = true
            projectForms.push({
              form_id: form.form_id,
              company_id: form.company_id,
              project_id: null
            })
          }
          if (form.form_id === 1) {
            form.selected = '1'
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
        apiProjects.store({
          company_id: this.user.company_id,
          owner_id: this.user.id
        }).then((res) => {
          let projectId = res.data.project.id
          projectForms.forEach((projectForm) => {
            projectForm.project_id = projectId
          })
          apiProjectForms.store({
            project_forms: projectForms
          }).then(() => {
            this.$router.push({
              name: 'Form Call Report',
              params: {
                project_id: projectId
              }
            })
          })
        }).catch(this.handleErrorResponse)
      }
    },
    created() {
      this.fetchFormsOrder()
      this.fetchUser()
    },
    computed: {
      forms: function() {
          return this.$store.state.StandardForm.formsOrder
      },
      user: function() {
        return this.$store.state.User.user
      },
      isLoaded: function() {
        return this.forms.length && this.user.length !== 0
      }
    },
    watch: {
      showModal: function () {
        if (!this.showModal) this.$router.push('/projects')
      }
    }
  }
</script>