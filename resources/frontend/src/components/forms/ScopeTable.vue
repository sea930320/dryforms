<template>
	<b-row>
		<div v-for="(index, count) in tableCols" :key="index" :class="count == 0 ? 'col-md-6 pr-0': 'col-md-6 pl-0'">
			<table class="text-center">
				<tr>
					<th :class="count == 0 ? 'bg-grey w-10': 'w-10'">X</th>
					<th :class="count == 0 ? 'bg-grey w-60': 'w-60'">Service</th>
					<th :class="count == 0 ? 'bg-grey w-30': 'w-30'">Units/Hr</th>												
				</tr>
				<tr v-for="item in services">
					<td :class="count == 0 ? 'bg-grey w-10': 'w-10'"><input type="text"/></td>
					<td :class="count == 0 ? 'bg-grey w-60': 'w-60'"><input type="text"/></td>
					<td :class="count == 0 ? 'bg-grey w-30': 'w-30'"><input type="text"/></td>												
				</tr>
			</table>
		</div>
	</b-row>						
</template>

<script type="text/babel">
  export default {
    data () {
      return {
        tableCols: new Array(2),
        services: new Array(40)
      }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
	table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
		padding: 3px;
	}
	table {
		input {
			text-align:center;
			width: 100%;
			background-color: transparent;
			border: none;
		}
	}
	.w-60 {
		width: 60%
	}
	.w-20 {
		width: 20%
	}
	.w-10 {
		width: 10%
	}
	.bg-grey {
		background-color: #c3c3c3;
	}
</style>