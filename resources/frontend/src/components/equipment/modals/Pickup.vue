<template>
  <b-modal id="pickupEquip" :title="$route.meta.title" class="text-left" v-model="show" size="lg">
    <b-row>
      <div class="form-group col-md-6">
        <label>Description</label>
        <select class="form-control">
          <option :value="null">-- Please select --</option>
          <option v-for="item in desciptions" :value="item.name">{{ item.name }}</option>
        </select>
      </div>
    </b-row>
    <b-row>
      <div class="form-group col-md-6">
        <label>Make/Model</label>
        <select class="form-control">
          <option :value="null">-- Please select --</option>
          <option v-for="item in desciptions" :value="item.name">{{ item.name }}</option>
        </select>
      </div>
    </b-row>
    <b-row>
      <div class="form-group col-md-6">
        <label>Equipment #</label>
        <select class="form-control">
          <option :value="null">-- Please select --</option>
          <option v-for="item in desciptions" :value="item.name">{{ item.name }}</option>
        </select>
      </div>
    </b-row>
    <div slot="modal-footer" class="w-100">
      <b-btn class="float-left" variant="primary" @click="pickupEquip()">Pick Up</b-btn>
      <b-btn class="float-right" @click="enterEquip()">Enter</b-btn>
    </div>
  </b-modal>
</template>

<script type="text/babel">
  export default {
    name: 'add-equip-modal',
    data () {
      return {
        show: true,
        desciptions: [
          {
            name: 'Air Mover'
          }
        ]
      }
    },
    created() {
      this.$refs.addEquip.show()
    },
    watch: {
      show: function () {
        if (this.show === false) this.$router.push('/equipment')
      }
    },
    methods: {
      pickupEquip () {
        this.$router.push('/equipment')
      },
      enterEquip () {
        this.$router.push('/equipment')
      }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>