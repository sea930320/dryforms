<template>
  <b-row>
    <b-col>
      <table>
        <tr>
          <th colspan="20">
            <i class="fa fa-times text-danger" @click="removeArea()"></i> {{ title }} <i class="fa fa-plus text-primary" @click="addArea()"></i>
          </th>
          </tr>
        <tr>
          <td v-for="n in 4" :key="n" class="bg-grey">
            <input type="text" name="">
          </td>
            <td v-for="n in 4" :key="n">
          <input type="text" name="">
          </td>
            <td v-for="n in 4" :key="n" class="bg-grey">
          <input type="text" name="">
          </td>
          <td v-for="n in 4" :key="n">
            <input type="text" name="">
          </td>
          <td v-for="n in 4" :key="n" class="bg-grey">
            <input type="text" name="">
          </td>
        </tr>
      </table>
    </b-col>
  </b-row>
</template>

<script type="text/babel">
  export default {
    props: ['title'],
    data () {
      return {
      }
    },
    methods: {
      removeArea () {
        alert('Do you want to remove this area?')
      },
      addArea () {
        alert('Do you want to add this area?')
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