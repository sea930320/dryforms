<template>
	<div class="card">
		<div class="card-body text-center">
			<form-header></form-header>
			<h4 class="mb-2">{{ $route.meta.title }}</h4>
			<div class="dropdown-divider"></div>
			<form-banner></form-banner>
			<b-row class="text-left">
				<b-col cols="5">Instrument Make: Flir 501</b-col>
				<b-col>Instrument Model: 5654319</b-col>
			</b-row>
			<b-row class="mt-3">
				<b-col>
					<table>
						<tr>
							<th colspan="4" class="bg-grey">Outside</th>
							<th colspan="4">Uneffected</th>
							<th colspan="4" class="bg-grey">Affected</th>
							<th colspan="4">Dehumidifier1</th>
							<th colspan="4" class="bg-grey">Dehumidifier2</th>
						</tr>
						<tr>
							<td class="bg-grey">TEMP</td>
							<td class="bg-grey">RH%</td>
							<td class="bg-grey">GPP</td>
							<td class="bg-grey">DEW</td>
							<td>TEMP</td>
							<td>RH%</td>
							<td>GPP</td>
							<td>DEW</td>
							<td class="bg-grey">TEMP</td>
							<td class="bg-grey">RH%</td>
							<td class="bg-grey">GPP</td>
							<td class="bg-grey">DEW</td>
							<td>TEMP</td>
							<td>RH%</td>
							<td>GPP</td>
							<td>DEW</td>
							<td class="bg-grey">TEMP</td>
							<td class="bg-grey">RH%</td>
							<td class="bg-grey">GPP</td>
							<td class="bg-grey"DEW</td>
						</tr>
					</table>
				</b-col>
			</b-row>
			<psy-area title="Master Bedroom" class="mt-3"></psy-area>
			<psy-area title="Master Bathroom" class="mt-3"></psy-area>
			<psy-area title="Bedroom 1 (containment 1)" class="mt-3"></psy-area>
			<psy-area title="Bedroom 1 (containment 2)" class="mt-3"></psy-area>
			<psy-area title="Hallway" class="mt-3"></psy-area>
			<notes class="mt-3"></notes>
		</div>
	</div>	
</template>

<script type="text/babel">
  import FormHeader from './FormHeader'
  import FormBanner from './FormBanner'
  import PsyArea from './PsyArea'
  import Notes from './Notes'

  export default {
    components: { FormHeader, FormBanner, PsyArea, Notes }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
  table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
		padding: 3px;
	}
	table {
		width: 100%;
		td {
			width: 5%;
		}
		input {
			text-align:center;
			width: 100%;
			background-color: transparent;
			border: none;
		}
	}
	.bg-grey {
		background-color: #c3c3c3;
	}
</style>