<template>
  <div class="card text-left">
    <div class="card-header">
      {{ $route.meta.title }}
    </div>
    <div class="card-body">
      <label>* Enter side menu name</label>
      <input type="text" class="form-control" v-model="formInfo.name">
      <label>* Enter form title</label>
      <input type="text" class="form-control" v-model="formInfo.title">
      <b-row class="mt-5 mb-5">
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
      <b-form-checkbox v-model="addNotes">Addtional notes.(Select if you wish to have Additional notes text box)</b-form-checkbox>
    </div>
    <div class="card-footer"></div>
  </div>
</template>

<script type="text/babel">
  export default {
    data () {
      return {
        addNotes: false,
        tableCols: new Array(2),
        services: new Array(20)
      }
    },
    created() {

    },
    computed: {
        formInfo: function() {
            if (this.$store.state.StandardForm.formOrders.length !== 0) {
                let form = this.$store.state.StandardForm.formOrders.filter(function(formOrder) {
                    return formOrder.form.name === 'Project Scope'
                })
                return form[0].standard_form[0]
            }
            return ''
        }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 5px;
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
    width: 60%;
  }
  .w-30 {
    width: 30%;
  }
  .w-10 {
    width: 10%;
  }
  .bg-grey {
    background-color: #c3c3c3;
  } 
</style>