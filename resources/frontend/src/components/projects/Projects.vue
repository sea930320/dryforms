<template>
	<b-container>
		<b-row>
			<div class="col-md-4 text-left">
				<select class="form-control">
          <option :value="null">-- Please select --</option>
          <option v-for="item in years" :value="item.value">{{ item.value }}</option>
        </select>
				<select class="form-control mt-2">
          <option :value="null">-- Please select --</option>
          <option v-for="item in years" :value="item.value">{{ item.value }}</option>
        </select>
			</div>
			<div class="col-md-4 text-center">
				<img src="" alt="Company Logo">
			</div>
			<div class="col-md-4 text-right">
				<input type="text" class="form-control">
			</div>
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
        years: [
          {
            value: '2016'
          },
          {
            value: '2017'
          }
        ]
      }
    }
  }
</script>