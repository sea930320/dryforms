<template>
	<div class="card">
		<div class="card-header">
			{{ $route.meta.title }}
		</div>
		<div class="card-body">
			<b-row>
				<div class="col-md-6">
					<label>Manually added structures</label>
					<b-table :fields="manualAreasHeader" :items="manualAreas" class="text-center">
						<template slot="no" slot-scope="data">
							{{ data.index + 1 }}
						</template>
						<template slot="add_to_favorite" slot-scope="data">
							<i class="fa fa-trash text-danger" @click="deleteArea()"></i>							
							<i class="fa fa-star-o warning text-warning ml-4" v-if="addFavoriteFromManual.indexOf(data.index) < 0" @click="manualToFavorite(data.index)"></i>
							<i class="fa fa-star warning text-warning ml-4" v-else @click="favoriteToManual(data.index)"></i>
						</template>				
					</b-table>
					<label>Add structure:</label>
					<input type="text" class="form-control">
				</div>
				<div class="col-md-6">
					<label>Provided structures</label>
					<b-table :fields="manualAreasHeader" :items="providedAreas" class="text-center">
						<template slot="no" slot-scope="data">
							{{ data.index + 1 }}
						</template>
						<template slot="add_to_favorite" slot-scope="data">
							<i class="fa fa-star-o warning text-warning" v-if="addFavoriteFromProvide.indexOf(data.index) < 0" @click="provideToFavorite(data.index)"></i>
							<i class="fa fa-star warning text-warning" v-else @click="favoriteToProvide(data.index)"></i>
						</template>
					</b-table>
				</div>
			</b-row>			
		</div>
	</div>
</template>

<script type="text/babel">
  export default {
    data () {
      return {
        manualAreasHeader: [
          {
            text: 'No',
            sortable: false,
            key: 'no'
          },
          {
            text: 'Title',
            sortable: false,
            key: 'title'
          },
          {
            text: 'Add to Favorite',
            sortable: false,
            key: 'add_to_favorite'
          }
        ],
        manualAreas: [
          { title: 'Ashlyin Room' },
          { title: 'Ashlyin Room' },
          { title: 'Ashlyin Room' }
        ],
        providedAreas: [
          { title: 'Ashlyin Room' },
          { title: 'Ashlyin Room' },
          { title: 'Ashlyin Room' }
        ],
        addFavoriteFromManual: [],
        addFavoriteFromProvide: []
      }
    },
    methods: {
      deleteArea () {},
      manualToFavorite (index) {
        this.addFavoriteFromManual.push(index)
      },
      favoriteToManual (index) {
        const i = this.addFavoriteFromManual.indexOf(index)
        this.addFavoriteFromManual.splice(i, 1)
      },
      provideToFavorite (index) {
        this.addFavoriteFromProvide.push(index)
      },
      favoriteToProvide (index) {
        const i = this.addFavoriteFromProvide.indexOf(index)
        this.addFavoriteFromProvide.splice(i, 1)
      }
    }
  }
</script>