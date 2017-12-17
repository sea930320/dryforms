<template>
  <div class="card text-center">
    <div class="card-header">
        {{ $route.meta.title }}
    </div>
    <div class="card-body">
      <b-list-group>
        <draggable v-model="forms" :options="{group:'people'}" @update="updateOrder()">
          <transition-group name="list-complete">           
            <b-list-group-item v-for="item in forms" :key="item.name" class="mb-3 list-complete-item">{{ item.name }}</b-list-group-item>           
          </transition-group>
        </draggable>
      </b-list-group>
    </div>
  </div>  
</template>

<script type="text/babel">
  import draggable from 'vuedraggable'

  export default {
    components: { draggable },
    data () {
      return {
        forms: [
          { name: 'Call Report', icon: '' },
          { name: 'Project Scope', icon: 'fa-newspaper-o' },
          { name: 'Daily Log', icon: '' },
          { name: 'Work Authorization', icon: 'fa-pencil' },
          { name: 'Anti-Microbial', icon: 'fa-certificate' },
          { name: 'Customer Responsibility', icon: 'fa-hand-grab-o' },
          { name: 'Moisture Map', icon: '' },
          { name: 'Psychometric Report', icon: '' },
          { name: 'Release from Liability', icon: 'fa-chain-broken' },
          { name: 'Work Stoppage', icon: 'fa-hand-paper-o' },
          { name: 'Certificate of Completion', icon: 'fa-trophy' }
        ]
      }
    },
    methods: {
      updateOrder: function () {
        console.log(this.forms)
      }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
  .list-complete-item {
    transition: all 1s;
    cursor: pointer;
  }
  .list-complete-enter, .list-complete-leave-active {
    opacity: 0;
  }
</style>