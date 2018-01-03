<template>
  <b-modal id="loanReturnEquip" :title="$route.meta.title" class="text-left" v-model="show" size="lg">
    <b-row>
      <div class="form-group col-md-6">
        <label>Description</label>
        <select class="form-control">
          <option :value="null">-- Please select --</option>
          <option v-for="item in categories" :value="item.name">{{ item.name }}</option>
        </select>
      </div>
    </b-row>
    <b-row>
      <div class="form-group col-md-6">
        <label>Make/Model</label>
        <select class="form-control">
          <option :value="null">-- Please select --</option>
          <option v-for="item in models" :value="item.name">{{ item.name }}</option>
        </select>
      </div>
    </b-row>
    <b-row>
      <div class="form-group col-md-6">
        <label>Equipment #</label>
        <select class="form-control">
          <option :value="null">-- Please select --</option>
          <option v-for="item in equipments" :value="item.name">{{ item.name }}</option>
        </select>
      </div>
    </b-row>
    <b-row>
      <div class="form-group col-md-6">
        <label>Location</label>
        <select class="form-control">
          <option :value="null">-- Please select --</option>
          <option v-for="item in locations" :value="item.name">{{ item.name }}</option>
        </select>
      </div>
    </b-row>
    <div slot="modal-footer" class="w-100">
      <b-btn class="float-left" variant="primary" @click="loanReturnEquip()">Return</b-btn>
      <b-btn class="float-right" @click="enterEquip()">Enter</b-btn>
    </div>
  </b-modal>
</template>

<script type="text/babel">
  import apiCategories from '../../../api/categories'
  import apiModels from '../../../api/models'
  import apiTeams from '../../../api/teams'

  export default {
    name: 'add-equip-modal',
    data () {
      return {
        show: true,
        categories: [],
        models: [],
        equipments: [],
        locations: []
      }
    },
    created() {
      this.$nextTick(() => {
        this.getList()
      })
      this.$on('reloadData', () => {
        this.getList()
      })
    },
    watch: {
      show: function () {
        if (this.show === false) this.$router.go(-1)
      }
    },
    methods: {
      getList() {
        apiModels.index()
          .then(response => {
            this.models = response.data.data
          })
        apiCategories.index()
          .then(response => {
            this.categories = response.data.data
          })
        apiTeams.index()
          .then(response => {
            this.locations = response.data.data
          })
      },
      loanReturnEquip () {
        this.$router.go(-1)
      },
      enterEquip () {
        this.$router.go(-1)
      }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>