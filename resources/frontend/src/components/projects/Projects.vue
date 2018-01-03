<template>
  <div>
    <b-container v-if="isLoaded" class="pt-2">
      <b-row>
        <b-col cols="3" class="text-left">
          <b-form-select v-model="selectedYear" :options="years" id="select_year"></b-form-select>
          <b-form-select v-model="selectedStatus" :options="status" class="mt-2"></b-form-select>
        </b-col>
        <b-col cols="6" class="text-center">
          <img :src="companyLogo" alt="Company Logo">
        </b-col>
        <b-col cols="3" class="text-right">
          <input type="text" class="form-control" placeholder="Search..." v-model="searchText">
        </b-col>
      </b-row>
      <div class="card text-center mt-3">
        <div class="card-header">
        </div>
        <div class="card-body text-left p-0">
          <table class="table table-sm table-bordered table-striped table-hover no-margin text-center">
            <thead>
              <tr>
                <th>Owner/Insured</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in projects">
                <td>{{ item.owner }}</td>
                <td>{{ item.address }}</td>
                <td>{{ item.phone }}</td>
                <td>{{ item.assingedto }}</td>
                <td>{{ item.status }}</td>
                <td>{{ item.action }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-muted">
        </div>
      </div>
    </b-container>
    <loading v-else></loading>
  </div>
</template>

<script type="text/babel">
  import Loading from '../layout/Loading'

  export default {
    components: { Loading },
    data () {
      return {
        isLoaded: false,
        selectedYear: new Date().getFullYear(),
        selectedStatus: 1,
        searchText: '',
        companyLogo: require('../../assets/fallback-logo.jpg'),
        years: [
          { value: '2015', text: '2015' },
          { value: '2016', text: '2016' },
          { value: '2017', text: '2017' }
        ],
        status: [
          { text: 'In-Progress', value: 1 },
          { text: 'Completed', value: 2 },
          { text: 'Deleted', value: 3 }
        ],
        projects: []
      }
    },
    watch: {
      selectedYear: function () {
        this.loadData()
      },
      selectedStatus: function () {
        this.loadData()
      },
      searchText: function () {
        this.loadData()
      }
    },
    created () {
      this.$nextTick(() => {
        this.loadData()
      })
      this.$on('reloadData', () => {
        this.loadData()
      })
    },
    methods: {
      loadData () {
        setTimeout(() => {
          this.isLoaded = true
        }, 2000)
      }
    }
  }
</script>