<template>
	<div class="standards-moisture">
		<div v-if="isLoaded" class="card text-center">
			<div class="card-header">
			    <h5>{{ $route.meta.title }}</h5>
			</div>
			<div class="card-body">
                <h6> Structure Dropdown Management </h6>
                <hr/>
                <b-row>
                    <div class="col-md-6">
                        <label>Manually added structures</label>
                        <b-table ref="manualStructuresTable" :items="manualStructures" small striped hover foot-clone :fields="manualHeader" head-variant="" align-v="center">
                            <template slot="no" slot-scope="data">
                                {{ data.index + 1 }}
                            </template>
                            <template slot="actions" slot-scope="row">
                                <i class="fa fa-trash text-danger" @click="deleteStructure(row.item.id)"></i>
                            </template>
                        </b-table>
                        <form data-vv-scope="form-structure">
                            <label>Add Structure:</label>
                            <b-input-group :size="template_size">
                                <input type="text" class="form-control form-control-sm" placeholder="Input title" v-model="newStructure" name="newStructure" :class="{'is-invalid': errors.has('newStructure')}" v-validate data-vv-rules="required">
                                <b-input-group-button>
                                    <b-btn :size="template_size" :variant="'primary'" @click='addStructure'>+</b-btn>
                                </b-input-group-button>
                            </b-input-group>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <label>Provided structures</label>
                        <b-table ref="providedStructuresTable" :items="providedStructures" small striped hover foot-clone :fields="providedHeader" head-variant="" align-v="center">
                            <template slot="no" slot-scope="data">
                                {{ data.index + 1 }}
                            </template>
                        </b-table>
                    </div>
                </b-row>
                <h6 class="mt-5"> Material Dropdown Management </h6>
                <hr/>
                <b-row>
                    <div class="col-md-6">
                        <label>Manually added materials</label>
                        <b-table ref="manualMaterialsTable" :items="manualMaterials" small striped hover foot-clone :fields="manualHeader" head-variant="" align-v="center">
                            <template slot="no" slot-scope="data">
                                {{ data.index + 1 }}
                            </template>
                            <template slot="actions" slot-scope="row">
                                <i class="fa fa-trash text-danger" @click="deleteMaterial(row.item.id)"></i>
                            </template>
                        </b-table>
                        <form data-vv-scope="form-material">
                            <label>Add Material:</label>
                            <b-input-group :size="template_size">
                                <input type="text" class="form-control form-control-sm" placeholder="Input title" v-model="newMaterial" name="newMaterial" :class="{'is-invalid': errors.has('newMaterial')}" v-validate data-vv-rules="required">
                                <b-input-group-button>
                                    <b-btn :size="template_size" :variant="'primary'" @click='addMaterial'>+</b-btn>
                                </b-input-group-button>
                            </b-input-group>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <label>Provided materials</label>
                        <b-table ref="providedMaterialsTable" :items="providedMaterials" small striped hover foot-clone :fields="providedHeader" head-variant="" align-v="center">
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
import apiStandardStructure from '../../api/standard_structures'
import apiStandardMaterials from '../../api/standard_materials'
import ErrorHandler from '../../mixins/error-handler'
import Loading from '../layout/Loading'

export default {
    mixins: [ErrorHandler],
    components: {
        Loading
    },
    data() {
        return {
            manualHeader: {
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
            providedHeader: [
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
            manualStructures: [],
            providedStructures: [],
            manualMaterials: [],
            providedMaterials: [],
            addFavoriteFromManual: [],
            addFavoriteFromProvide: [],
            isLoaded: false,
            newStructure: '',
            newMaterial: ''
        }
    },
    created() {
        let self = this
        const apis = [
            apiStandardStructure.index(),
            apiStandardMaterials.index()
        ]
        return Promise.all(apis)
            .then(response => {
                self.manualStructures = response[0].data.manual_structures
                self.providedStructures = response[0].data.provided_structures
                self.manualMaterials = response[1].data.manual_materials
                self.providedMaterials = response[1].data.provided_materials
                self.isLoaded = true
            })
            .catch(this.handleErrorResponse)
    },
    methods: {
        addStructure() {
            this.$validator.validateAll('form-structure')
            if (this.errors.has('newStructure')) {
                return
            }
            let self = this
            apiStandardStructure.store({
                title: this.newStructure,
                type: 'company'
            })
            .then(function(response) {
                self.manualStructures.push(response.data.structure)
                self.newStructure = ''
            })
            .catch(this.handleErrorResponse)
        },
        deleteStructure(id) {
            let self = this
            apiStandardStructure.delete(id)
            .then(function(response) {
                self.manualStructures.splice(self.manualStructures.findIndex(function(structure) {
                    return structure.id === id
                }), 1)
            })
            .catch(this.handleErrorResponse)
        },
        addMaterial() {
            this.$validator.validateAll('form-material')
            if (this.errors.has('newMaterial')) {
                return
            }
            let self = this
            apiStandardMaterials.store({
                title: this.newMaterial,
                type: 'company'
            })
            .then(function(response) {
                self.manualMaterials.push(response.data.material)
                self.newMaterial = ''
            })
            .catch(this.handleErrorResponse)
        },
        deleteMaterial(id) {
            let self = this
            apiStandardMaterials.delete(id)
            .then(function(response) {
                self.manualMaterials.splice(self.manualMaterials.findIndex(function(material) {
                    return material.id === id
                }), 1)
            })
            .catch(this.handleErrorResponse)
        }
    }
}
</script>
