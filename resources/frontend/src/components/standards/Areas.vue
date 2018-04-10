<template>
	<div class="standards-affected-areas">
		<div v-if="isLoaded" class="card text-center">
			<div class="card-header">
			    <h5>{{ $route.meta.title }}</h5>
			</div>
			<div class="card-body">
                <b-row>
                    <div class="col-md-12">
                        <b-table ref="areasTable" :items="areas" small striped hover foot-clone :fields="areasHeader" head-variant="" align-v="center">
                            <template slot="no" slot-scope="data">
                                {{ data.index + 1 }}
                            </template>
                            <template slot="actions" slot-scope="row">
                                <i class="fa fa-trash text-danger" @click="deleteArea(row.item.id)"></i>
                            </template>
                        </b-table>
                    </div>
                    <div class="col-md-6">
                        <label>Add Area:</label>
                        <b-input-group :size="template_size">
                            <input type="text" class="form-control form-control-sm" placeholder="Input title" v-model="newArea" name="newArea" :class="{'is-invalid': errors.has('newArea')}" v-validate data-vv-rules="required">
                            <b-input-group-button>
                                <b-btn :size="template_size" :variant="'primary'" @click='addArea'>+</b-btn>
                            </b-input-group-button>
                        </b-input-group>
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
            areasHeader: {
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
            areas: [],
            isLoaded: false,
            newArea: ''
        }
    },
    created() {
        let self = this
        apiStandardArea.index()
        .then(function(response) {
            self.areas = response.data.areas
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
                title: this.newArea
            })
            .then(function(response) {
                self.areas.push(response.data.area)
                self.newArea = ''
                self.errors.clear()
            })
            .catch(this.handleErrorResponse)
        },
        deleteArea(id) {
            let self = this
            apiStandardArea.delete(id)
            .then(function(response) {
                self.areas.splice(self.areas.findIndex(function(area) {
                    return area.id === id
                }), 1)
            })
            .catch(this.handleErrorResponse)
        }
    }
}
</script>
