<template>
	<b-container>
		<b-row>
			<b-col cols="3" class="text-left">
				<select class="form-control" v-model="selectedYear">
          <option :value="null">-- Please select --</option>
          <option v-for="item in years" :value="item">{{ item }}</option>
        </select>
				<select class="form-control mt-2" v-model="selectedStatus">
          <option :value="null">-- Please select --</option>
          <option v-for="item in status" :value="item.value">{{ item.label }}</option>
        </select>
			</b-col>
			<b-col cols="6" class="text-center">
				<img src="" alt="Company Logo">
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
</template>

<script type="text/babel">
  export default {
    data () {
      return {
        selectedYear: null,
        selectedStatus: null,
        searchText: '',
        years: ['2015', '2016', '2017'],
        status: [
          { label: 'In-Progress', value: 1 },
          { label: 'Completed', value: 2 },
          { label: 'Deleted', value: 3 }
        ]
      }
    },
    watch: {
      selectedYear: function () {
        console.log(this.selectedYear)
      },
      selectedStatus: function () {
        console.log(this.selectedStatus)
      },
      searchText: function () {
        console.log(this.searchText)
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
        console.log('Get data from backend!')
      }
    }
  }
</script>