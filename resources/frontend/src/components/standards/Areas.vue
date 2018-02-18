<template>
	<div class="standards-affected-areas">
		<div v-if="isLoaded" class="card text-left">
			<div class="card-header">
			{{ $route.meta.title }}
			</div>
			<div class="card-body">
			<b-row>
				<div class="col-md-6">
                    <label>Manually added areas</label>
                    <b-table ref="manualAreasTable" :items="manualAreas" small striped hover foot-clone :fields="manualAreasHeader" head-variant="" align-v="center">
                        <template slot="no" slot-scope="data">
                            {{ data.index + 1 }}
                        </template>
                        <template slot="actions" slot-scope="row">
                            <i class="fa fa-trash text-danger" @click="deleteArea(row.item.id)"></i>
                        </template>
                    </b-table>
                    <label>Add Area:</label>
                    <b-input-group :size="template_size">
                        <input type="text" class="form-control form-control-sm" placeholder="Input title" v-model="newArea" name="newArea" :class="{'is-invalid': errors.has('newArea')}" v-validate data-vv-rules="required">
                        <b-input-group-button>
                            <b-btn :size="template_size" :variant="'primary'" @click='addArea'>+</b-btn>
                        </b-input-group-button>
                    </b-input-group>
				</div>
				<div class="col-md-6">
                    <label>Provided areas</label>
                    <b-table ref="providedAreasTable" :items="providedAreas" small striped hover foot-clone :fields="providedAreasHeader" head-variant="" align-v="center">
                        <template slot="no" slot-scope="data">
                        {{ data.index + 1 }}
                        </template>
                    </b-table>
				</div>
			</b-row>      
			</div>
		</div>
        <loading v-else></loading>
	</div>
</template>

<script type="text/babel">
import apiStandardArea from '../../api/standard_area'
import ErrorHandler from '../../mixins/error-handler'
import Loading from '../layout/Loading'

export default {
    mixins: [ErrorHandler],
    components: {
        Loading
    },
    data() {
        return {
            manualAreasHeader: {
                no: {
                    label: 'No',
                    'class': 'text-center',
                    sortable: false
                },
                title: {
                    label: 'Title',
                    sortable: false,
                    'class': 'text-center'
                },
                actions: {
                    label: 'Actions',
                    sortable: false,
                    'class': 'text-center'
                }
            },
            providedAreasHeader: [
                {
                    text: 'No',
                    sortable: false,
                    key: 'no'
                },
                {
                    text: 'Title',
                    sortable: false,
                    key: 'title'
                }
            ],
            manualAreas: [],
            providedAreas: [],
            addFavoriteFromManual: [],
            addFavoriteFromProvide: [],
            isLoaded: false,
            newArea: ''
        }
    },
    created() {
        let self = this
        apiStandardArea.index()
        .then(function(response) {
            self.manualAreas = response.data.manual_areas
            self.providedAreas = response.data.provided_areas
            self.isLoaded = true
        })
        .catch(this.handleErrorResponse)
    },
    computed: {
    },
    methods: {
        addArea() {
            this.$validator.validateAll()
            if (this.errors.any()) {
                return
            }
            let self = this
            apiStandardArea.store({
                title: this.newArea,
                type: 'company'
            })
            .then(function(response) {
                self.manualAreas.push(response.data.area)
                self.newArea = ''
                self.errors.clear()
            })
            .catch(this.handleErrorResponse)
        },
        deleteArea(id) {
            let self = this
            apiStandardArea.delete(id)
            .then(function(response) {
                self.manualAreas.splice(self.manualAreas.findIndex(function(area) {
                    return area.id === id
                }), 1)
            })
            .catch(this.handleErrorResponse)
        }
    }
}
</script>
