<template>
  <div class="card">
    <div class="card-body text-center">
      <form-header></form-header>
      <h4 class="mb-2">{{ $route.meta.title }}</h4>
      <div class="dropdown-divider"></div>
      <form-banner></form-banner>
      <table class="text-xs-center">
        <tr><th colspan="2" class="bg-grey">Bedroom 1</th></tr>
        <tr>
          <td class="w-50 bg-grey">Overall Square Feet</td>
          <td class="w-50"><input type="text"/></td>
        </tr>
      </table>
      <scope-table class="mt-3"></scope-table>
    </div>
  </div>
</template>

<script type="text/babel">
  import FormHeader from './FormHeader'
  import FormBanner from './FormBanner'
  import ScopeTable from './ScopeTable'

  export default {
    components: { FormHeader, FormBanner, ScopeTable }
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
    input {
      text-align:center;
      width: 100%;
      background-color: transparent;
      border: none;
    }
  }
  .w-50 {
    width: 50%;
  }
  .bg-grey {
    background-color: #c3c3c3;
  }
</style>