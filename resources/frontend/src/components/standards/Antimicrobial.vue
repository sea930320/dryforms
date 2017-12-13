<template>
	<div class="card text-left">
		<div class="card-header">
			{{ $route.meta.title }}
		</div>
		<div class="card-body">
			<label>* Enter side menu name</label>
			<input type="text" class="form-control" v-model="sideMenuName">
			<label>* Enter form title</label>
			<input type="text" class="form-control" v-model="formTitle">
			<label class="mt-3">* Enter accept text</label>
			<vue-editor id="acceptEditor" v-model="acceptText"></vue-editor>
			<label class="mt-3">* Enter decline text</label>
			<vue-editor id="declineEditor" v-model="declineText"></vue-editor>
			<div class="mt-3">
				<b-form-checkbox v-model="addNotes">Addtional notes.(Select if you wish to have Additional notes text box)</b-form-checkbox>	
			</div>
			<div>
				<b-form-checkbox v-model="addFooter">Footer Text.(Select if you wish to have a footer text)</b-form-checkbox>	
				<vue-editor id="footerEditor" v-model="footerText" v-if="addFooter" class="mb-3"></vue-editor>
			</div>			
			<b-form-checkbox v-model="addSignature">Owner/Occupant and Company electric signature.(Select if you wich to have electric signature)</b-form-checkbox>
		</div>
		<div class="card-footer"></div>
	</div>
</template>

<script type="text/babel">
  import { VueEditor } from 'vue2-editor'
  export default {
    components: { VueEditor },
    data () {
      return {
        sideMenuName: 'Anti-Microbial Authorization',
        formTitle: 'Anti-Microbial Authorization',
        addNotes: false,
        addFooter: false,
        addSignature: false,
        acceptText: '<h1>accept content</h1>',
        declineText: '<h1>decline content</h1>',
        footerText: 'Please call in the event of an Emergency or if you have any questions. I have read and understand the information above.'
      }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">	
	#acceptEditor, #declineEditor {
		min-height: 300px;
	}
	#footerEditor {
		height: 150px;
	}
</style>