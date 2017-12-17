<template>
	<div class="card">
		<div class="card-header">
	      {{ $route.meta.title }}
	  </div>
		<div class="card-body">
			<b-row align-h="around">
				<b-col cols="4"><b-form-checkbox v-model="favArea">Favorites areas</b-form-checkbox></b-col>
				<b-col cols="4"><b-form-checkbox v-model="provArea">Provided areas</b-form-checkbox></b-col>
			</b-row>
			<b-row align-h="around">
				<b-col cols="4" class="text-center">
					<h6>Selected affected areas</h6>
					<div class="wrapper">
						<b-list-group class="text-left">
							<b-list-group-item v-for="item in selectedAreas" :key="item.value" :active="!item.selected" @click="deselectArea(item.value)">{{ item.name }}</b-list-group-item>
						</b-list-group>
					</div>
					<div class="text-right mt-2">
						Romove <button @click="removeArea()"><i class="fa fa-arrow-right"></i></button>
					</div>
				</b-col>
				<b-col cols="4" class="text-center">
					<h6>Choose affected areas</h6>
					<div class="wrapper">
						<b-list-group class="text-left">
							<b-list-group-item v-for="item in areas" :key="item.value" :active="item.selected" @click="selectArea(item.value)">{{ item.name }}</b-list-group-item>
						</b-list-group>
					</div>
					<div class="text-left mt-2">
						<button @click="addArea()"><i class="fa fa-arrow-left"></i></button> Add
					</div>
				</b-col>
			</b-row>
			<div class="text-center">
				<h6> Add area to list</h6>
				<input type="text" v-model="newArea">
				<button @click="increaseArea()"><i class="fa fa-plus"></i></button>
			</div>
		</div>
		<div class="card-footer text-right">
			<b-button variant="primary">Save</b-button>
		</div>
	</div>
</template>

<script type="text/babel">
  export default {
    data () {
      return {
        favArea: true,
        provArea: false,
        selectedAreas: [],
        areas: [],
        favoriteAreas: [
          { name: 'Master Bedroom', value: 1, selected: false },
          { name: 'Master Bathroom', value: 2, selected: false }
        ],
        providedAreas: [
          { name: 'Bedroom 1', value: 1, selected: false },
          { name: 'Bathroom 2', value: 2, selected: false }
        ]
      }
    },
    watch: {
      favArea: function () {
        this.provArea = !this.favArea
        if (this.favArea) {
          this.areas = this.favoriteAreas
        } else {
          this.areas = this.providedAreas
        }
      },
      provArea: function () {
        this.favArea = !this.provArea
        if (this.provArea) {
          this.areas = this.providedAreas
        } else {
          this.areas = this.favoriteAreas
        }
      }
    },
    methods: {
      selectArea: function (index) {
        var arrIndex = this._.findIndex(this.areas, {value: index})
        this.areas[arrIndex].selected = !this.areas[arrIndex].selected
      },
      addArea: function () {
        this.selectedAreas.push(...this._.filter(this.areas, {selected: true}))
        this._.remove(this.areas, {selected: true})
      },
      deselectArea: function (index) {
        var arrIndex = this._.findIndex(this.selectedAreas, {value: index})
        this.selectedAreas[arrIndex].selected = !this.selectedAreas[arrIndex].selected
      },
      removeArea: function () {
        this.areas.push(...this._.filter(this.selectedAreas, {selected: false}))
        this._.remove(this.selectedAreas, {selected: false})
      },
      increaseArea: function () {
        alert(this.newArea)
      }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
	.wrapper {
		min-height: 400px;
		border: 1px solid black;
	}
	.list-group-item {
		padding: 5px;
		border: 0;
		cursor: pointer;
	}
</style>