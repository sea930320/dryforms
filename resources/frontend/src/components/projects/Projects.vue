<template>
  <div>
    <b-container v-if="isLoaded" class="pt-2">
      <delete-modal></delete-modal>
      <b-row>
        <b-col cols="3" class="text-left">
          <b-form-select v-model="selectedYear" :options="years" id="select_year"></b-form-select>
          <b-form-select v-model="selectedStatus" :options="statuses" class="mt-2"></b-form-select>
        </b-col>
        <b-col cols="6" class="text-center">
          <img v-if="company.logo" :src="company.logo" alt="Company Logo" height="90">
          <img v-else :src="companyLogo" alt="Company Logo" height="90">
        </b-col>
        <b-col cols="3" class="text-right">
          <input type="text" class="form-control" placeholder="Search..." v-model="filter" @input="filtering()">
        </b-col>
      </b-row>
      <div class="card text-center mt-3">
        <div class="card-header">
        </div>
        <div class="card-body text-left p-0">
          <b-table ref="projectTable" :busy.sync="isBusy" :items="getModel" small
                    striped hover foot-clone :fields="fields" :current-page="currentPage" :per-page="perPage"
                    :filter="filter" head-variant="">
              <template slot="insured" slot-scope="row">
                  {{ row.item.owner_name }}
              </template>
              <template slot="assigned" slot-scope="row">
                  {{ row.item.assignee ? row.item.assignee.name: ''}}
              </template>
              <template slot="status" slot-scope="row">
                  {{ row.item.status_info ? row.item.status_info.name: '' }}
              </template>
              <template slot="actions" slot-scope="row">
                <button class="btn btn-xs btn-default" @click='editProject(row.item.id)'>
                  <i class="fa fa-pencil"></i> Edit
                </button>
                <button class="btn btn-xs btn-danger" @click='removeProject(row.item.id)'>
                  <i class="fa fa-trash"></i> Remove
                </button>
              </template>
          </b-table>
          <div class="justify-content-center row-margin-tweak row">
              <b-pagination v-if="!isBusy" :size="template_size" :total-rows="count" :per-page="perPage" limit="5" v-model="currentPage"/>
              <div v-else>...</div>
          </div>
        </div>
        <div class="card-footer text-muted">
        </div>
      </div>
    </b-container>
    <loading v-else></loading>
  </div>
</template>

<script type="text/babel">
  import { mapActions } from 'vuex'
  import Loading from '../layout/Loading'
  import apiProjects from '../../api/projects'
  import apiProjectStatus from '../../api/project_status'
  import ErrorHandler from '../../mixins/error-handler'
  import DeleteModal from './modals/Remove'

  export default {
    mixins: [ErrorHandler],
    components: { Loading, DeleteModal },
    data () {
      return {
        selectedYear: new Date().getFullYear(),
        selectedStatus: null,
        companyLogo: require('../../assets/fallback-logo.jpg'),
        years: [],
        statuses: [],
        fields: {
          insured: {
            label: 'Owner/Insured',
            sortable: false,
            'class': 'text-center'
          },
          address: {
            label: 'Address',
            sortable: false,
            'class': 'text-center'
          },
          phone: {
            label: 'Phone',
            sortable: false,
            'class': 'text-center'
          },
          assigned: {
            label: 'Assigned To',
            sortable: false,
            'class': 'text-center'
          },
          status: {
            label: 'Status',
            sortable: false,
            'class': 'text-center'
          },
          actions: {
            label: 'Action',
            sortable: false,
            'class': 'text-center'
          }
        },
        filter: '',
        isBusy: false,
        currentPage: 1,
        perPage: 20,
        count: 0,
        projects: null
      }
    },
    watch: {
      selectedYear: function () {
        this.$refs.projectTable.refresh()
      },
      selectedStatus: function () {
        this.$refs.projectTable.refresh()
      }
    },
    created () {
      this.$nextTick(() => {
        this.initData()
      })
      this.$on('reloadData', () => {
        this.initData()
        this.$refs.projectTable.refresh()
      })
    },
    methods: {
      ...mapActions([
          'fetchUser'
      ]),
      initData() {
        this.fetchUser()
        this.years = []
        for (let year = new Date().getFullYear(); year >= 2015; year--) {
          this.years.push({
            value: year,
            text: year
          })
        }
        const apis = [
          apiProjects.index(),
          apiProjectStatus.index()
        ]
        Promise.all(apis)
          .then(response => {
            this.projects = response[0].data.data || []
            this.count = response[0].data.total
            let statuses = response[1].data.statuses
            this.statuses = [{
              text: '----Select Status----',
              value: null
            }]
            statuses.forEach(status => {
              this.statuses.push({
                text: status.name,
                value: status.id
              })
            })
          }).catch(this.handleErrorResponse)
      },
      getModel(ctx) {
        let data = {
            page: ctx.currentPage,
            filter: ctx.filter,
            per_page: ctx.perPage,
            status: this.selectedStatus,
            year: this.selectedYear
        }
        return apiProjects.index(data)
          .then(response => {
            let items = response.data.data
            this.count = response.data.total
            this.projects = items || []
            return (this.projects)
          })
      },
      editProject(projectId) {
        this.$router.push({
          name: 'Form Call Report',
          params: {
            project_id: projectId,
            form_id: 1
          }
        })
      },
      removeProject(projectId) {
        this.$emit('openRemoveModal', {
            id: projectId
        })
      }
    },
    computed: {
      company: function() {
        return this.$store.state.User.company
      },
      isLoaded: function() {
        return this.company.length !== 0 && Array.isArray(this.projects)
      }
    }
  }
</script>