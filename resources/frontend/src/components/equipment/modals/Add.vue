<template>
    <div class="equipment-add">
        <div v-if="isLoaded" class="card text-center">
          <div class="card-header">
              <h5>{{ $route.meta.title }}</h5>
          </div>
          <div class="card-body text-left pt-3 pb-3">
            <b-container class="">
              <b-row>
                  <div class="form-group col-md-6">
                      <label>Category</label>
                      <select class="form-control" v-model="data.category_id">
                          <option :value="null">-- Please select --</option>
                          <option v-for="item in categories" :value="item.id">{{ item.name }}</option>
                      </select>
                  </div>
                  <div class="form-group col-md-6">
                      <label>Add New Category</label>
                      <form data-vv-scope="form-category">
                          <b-row>
                              <b-col cols="8">
                                  <input type="text" name="category" class="form-control" :class="{'is-invalid': errors.has('category') && !data.category_id}" v-validate data-vv-rules="required" v-model="newCategory" :disabled="data.category_id" placeholder="Category">
                              </b-col>
                              <b-col cols="4">
                                  <input type="text" name="prefix" class="form-control" :class="{'is-invalid': errors.has('prefix') && !data.category_id}" v-validate data-vv-rules="required" v-model="newPrefix" :disabled="data.category_id" placeholder="Prefix">
                              </b-col>
                          </b-row>
                      </form>
                  </div>
              </b-row>
              <b-row>
                  <div class="form-group col-md-6">
                      <label>Make/Model</label>
                      <select class="form-control" v-model="data.model_id">
                          <option :value="null">-- Please select --</option>
                          <option v-for="item in models" :value="item.id">{{ item.name }}</option>
                      </select>
                  </div>
                  <div class="form-group col-md-6">
                      <label>Add New Make/Model</label>
                      <form data-vv-scope="form-model">
                        <input type="text" name="model" class="form-control" :class="{'is-invalid': errors.has('model') && !data.model_id}" v-validate data-vv-rules="required" v-model="newModel" :disabled="data.model_id" placeholder="Make/Model">
                      </form>
                  </div>
              </b-row>
              <b-row>
                  <div class="form-group col-md-6">
                      <label>Crew/Team</label>
                      <select class="form-control" v-model="data.team_id">
                          <option :value="null">-- Please select --</option>
                          <option v-for="item in teams" :value="item.id">{{ item.name }}</option>
                      </select>
                  </div>
                  <div class="form-group col-md-6">
                      <label>Statuses</label>
                      <select class="form-control" v-model="data.status_id">
                          <option :value="null">-- Please select --</option>
                          <option v-for="item in statuses" :value="item.id">{{ item.name }}</option>
                      </select>
                  </div>
              </b-row>
              <b-card bg-variant="light" class="mt-1 mb-1 pt-0">
                  <b-row>
                    <b-col cols="3">
                        <b-form-group id="fieldsetHorizontal"
                                      horizontal
                                      :label-cols="4"
                                      :label-size="template_size"
                                      label="Quantity"
                                      label-for="inputQuantity"
                                      class="m-0">
                          <b-form-input id="inputQuantity" type="number" placeholder="Enter the quantity" :size="template_size" v-model="data.quantity" min=1 ></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col cols="8">
                      <b-form-checkbox v-model="data.autoAssign" value="yes" unchecked-value="no" :size="template_size" class="m-0">
                        Assign Equipment Numbers Automatically?
                      </b-form-checkbox>
                    </b-col>
                  </b-row>
                  <b-row v-if="data.autoAssign === 'no' && data.quantity > 0">
                    <b-col cols="12">
                      <hr>
                      <b-row>
                        <b-col cols="8">
                          <label>Equipment #</label>
                        </b-col>
                        <b-col cols="4" class="pt-2 mb-1">
                          <b-form-group horizontal  :label-cols="4" label-text-align="right" label="<b>Page Size:</b>" :label-size="template_size" class="p-0 m-0">
                            <b-input-group :size="template_size">
                              <b-form-input type="number" placeholder="Row" min="1" v-model="perRow" :disabled="isBusy"></b-form-input>
                              <b-input-group-addon>×</b-input-group-addon>
                              <b-form-input type="number" placeholder="Column" min="1" v-model="perCol" :disabled="isBusy"></b-form-input>
                            </b-input-group>
                          </b-form-group>
                        </b-col>
                      </b-row>
                    </b-col>
                    <b-col cols="12">
                      <b-table ref="serialsTable" :busy.sync="isBusy" :items="getCurEquipmentNumbers" small striped hover :fields="fields" :current-page="currentPage" :per-page="perPage" head-variant="">
                        <template v-for="field in fields" :slot="field" slot-scope="row">
                          <input type="text" v-model="row.item.value">
                        </template>
                      </b-table>
                      <div class="justify-content-center row-margin-tweak row">
                        <b-pagination v-if="!isBusy" :size="template_size" :total-rows="count" :per-page="perPage" limit="5" v-model="currentPage" />
                        <div v-else>...</div>
                      </div>
                    </b-col>
                  </b-row>
              </b-card>
              <b-btn class="float-right" :size="template_size" variant="primary" @click="addEquip()">Add</b-btn>
              <b-btn class="float-right mr-3" variant="" :size="template_size" @click="clear()">Clear</b-btn>
            </b-container>
          </div>
          <div class="card-footer text-muted">
          </div>
        </div>
        <loading v-else></loading>
    </div>
</template>

<script type="text/babel">
    import {mapActions, mapGetters} from 'vuex'
    import Loading from '../../layout/Loading'

    import apiCategories from '../../../api/categories'
    import apiModels from '../../../api/models'
    import apiTeams from '../../../api/teams'
    import apiStatuses from '../../../api/statuses'
    import apiEquipment from '../../../api/equipment'
    import ErrorHandler from '../../../mixins/error-handler'

    export default {
        mixins: [ErrorHandler],
        name: 'add-equip-modal',
        components: { Loading },
        data () {
            return {
                isLoaded: false,
                categories: [],
                models: [],
                statuses: [],
                teams: [],
                data: {
                    model_id: null,
                    category_id: null,
                    team_id: null,
                    status_id: null,
                    quantity: 1,
                    autoAssign: 'yes',
                    serials: [{value: ''}]
                },
                newModel: '',
                newCategory: '',
                newPrefix: '',
                isBusy: false,
                currentPage: 1,
                perRow: 1,
                perCol: 3,
                count: 0
            }
        },
        mounted() {
            this.fetchUser()
        },
        created() {
            this.$nextTick(() => {
                this.getList()
            })
            this.$on('reloadData', () => {
                this.getList()
            })
        },
        computed: {
            ...mapGetters({
                company_id: 'companyId',
                user_id: 'userId'
            }),
            fields: function() {
              let fields = []
              for (let i = 0; i < this.perRow; i++) {
                fields.push('col-' + i)
              }
              return fields
            },
            perPage: function() {
              return this.perRow * this.perCol
            }
        },
        watch: {
            'data.quantity': function(val) {
              this.data.serials = []
              for (let i = 0; i < val; i++) {
                this.data.serials.push({value: ''})
              }
              this.count = val
              if (this.data.autoAssign === 'no' && this.data.quantity > 0) {
                this.$refs.serialsTable.refresh()
              }
            },
            'data.category_id': function(val) {
              this.errors.clear('form-category')
              if (val !== null) {
                this.newCategory = ''
                this.newPrefix = ''
              }
            },
            'data.model_id': function(val) {
              this.errors.clear('form-model')
              if (val !== null) {
                this.newModel = ''
              }
            }
        },
        methods: {
            ...mapActions([
                'getCompany',
                'fetchUser'
            ]),
            getList() {
                const data = [
                    apiModels.index(),
                    apiCategories.index(),
                    apiStatuses.index(),
                    apiTeams.index()
                ]

                return Promise.all(data)
                    .then(response => {
                        this.models = response[0].data.data
                        this.categories = response[1].data.data
                        this.statuses = response[2].data.data
                        this.teams = response[3].data.data
                        this.isLoaded = true
                        return response
                    })
            },
            getCurEquipmentNumbers (ctx) {
                this.count = this.data.quantity
                let serials = (ctx.currentPage * ctx.perPage > this.count) ? this.data.serials.slice(ctx.perPage * (ctx.currentPage - 1)) : this.data.serials.slice(ctx.perPage * (ctx.currentPage - 1), ctx.perPage * ctx.currentPage)
                let serialGroup = []
                let groupIndex = 0
                let self = this
                debugger
                serials.forEach(function(serial, index) {
                  serialGroup[index / self.perRow][index % self.perRow] = serial
                })
                return serials
            },
            addEquip () {
                if (!this.data.category_id || !this.data.model_id) {
                  if (this.data.category_id) {
                    this.$validator.validateAll('form-model')
                  } else if (this.data.model_id) {
                    this.$validator.validateAll('form-category')
                  } else {
                    this.$validator.validateAll()
                  }
                    if (this.errors.any()) {
                        return
                    }
                }
                this.data.company_id = this.company_id
                let self = this

                var saveEquipment = function() {
                  return apiEquipment.store(self.data)
                      .then(response => {
                      }).catch(self.handleErrorResponse)
                }
                var saveModel = function() {
                  return apiModels.store({
                      name: self.newModel,
                      category_id: self.data.category_id,
                      company_id: self.company_id
                  }).then(response => {
                      if (response.data.message) {
                        self.data.model_id = response.data.model.id
                      }
                      return saveEquipment()
                  }).catch(self.handleErrorResponse)
                }

                if (!this.data.category_id) {
                    return apiCategories.store({
                        name: this.newCategory,
                        prefix: this.newPrefix,
                        company_id: this.company_id
                    }).then(response => {
                        self.data.category_id = response.data.category.id
                        if (!self.data.model_id) {
                            return saveModel()
                        }
                        return saveEquipment()
                    }).catch(self.handleErrorResponse)
                }
                if (!self.data.model_id) {
                    return saveModel()
                }
                return saveEquipment()
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
  .equipment-add {
    .custom-control .custom-control-indicator {
      top: .45rem !important;
    }
  }
  .input-group-addon {
    font-size: 1rem;
    line-height: 2rem;
  }
</style>
