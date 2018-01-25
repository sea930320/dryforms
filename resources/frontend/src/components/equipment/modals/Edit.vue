<template>
    <b-modal class="equipment-edit text-left" :title="modalName" v-model="show">
      <div slot="modal-footer">
        <b-btn :size="template_size" class="float-right" variant="" @click="show=false">
          Cancel
        </b-btn>
        <b-btn :size="template_size" class="float-right mr-3" variant="primary" @click="update">
          Save
        </b-btn>
      </div>
      <form data-vv-scope="form-edit" v-if="isLoaded">
        <b-row>
          <div class="form-group col-md-6">
              <label>Category</label>
              <select class="form-control" v-model="equipment.category_id" name="category" :class="{'is-invalid': errors.has('category')}" v-validate data-vv-rules="required">
                  <option v-for="item in categories" v-bind:key="item.id" :value="item.id">{{ item.name }}</option>
              </select>
          </div>
          <div class="form-group col-md-6">
              <label>Make/Model</label>
              <select class="form-control" v-model="equipment.model_id" name="model" :class="{'is-invalid': errors.has('model')}" v-validate data-vv-rules="required">
                  <option :value="null">-- Please select --</option>
                  <option v-for="item in models" v-bind:key="item.id" :value="item.id">{{ item.name }}</option>
              </select>
          </div>
        </b-row>
        <b-row>
          <div class="form-group col-md-6">
              <label>Crew/Team</label>
              <select class="form-control" v-model="equipment.team_id">
                  <option :value="null">-- Please select --</option>
                  <option v-for="item in teams" v-if="item.id" v-bind:key="item.id" :value="item.id">{{ item.name }}</option>
              </select>
          </div>
        </b-row>
        <b-row>
          <div class="form-group col-md-12">
              <label>Equipment #</label>
              <b-input-group :size="template_size">
                <label class="serial-label m-0 pl-1 pr-1">
                  {{equipment.serial.prefix}}
                </label>
                <b-form-input type="number" v-model="equipment.serial.number" :size="template_size" min=0 @input="validateSerialNumber" :class="{'is-invalid': !equipment.serial.validate}"></b-form-input>
                <label v-if="!equipment.serial.validate" class="serial-label m-0 pl-1 pr-1">
                  <i style="color:#dc3545" class="fa fa-exclamation-triangle"></i>
                </label>
              </b-input-group>
          </div>
        </b-row>
        <b-row>
          <div class="form-group col-md-6">
              <label>Status</label>
              <select class="form-control" v-model="equipment.status_id" name="status" :class="{'is-invalid': errors.has('status')}" v-validate data-vv-rules="required">
                  <option :value="null">-- Please select --</option>
                  <option v-for="item in statuses" v-bind:key="item.id" :value="item.id">{{ item.name }}</option>
              </select>
          </div>
          <div class="form-group col-md-6">
              <label>Location</label>
              <input type="text" class="form-control" v-model="equipment.location">
          </div>
        </b-row>
      </form>
      <loading v-else></loading>
    </b-modal>
</template>

<script type="text/babel">
    import Loading from '../../layout/Loading'
    import apiCategories from '../../../api/categories'
    import apiModels from '../../../api/models'
    import apiEquipments from '../../../api/equipment'
    import ErrorHandler from '../../../mixins/error-handler'
    import _ from 'lodash'
    
    export default {
        mixins: [ErrorHandler],
        components: { Loading },
        name: 'edit-modal',
        props: ['statuses', 'teams'],
        created() {
            this.$parent.$on('openEditModal', (payload) => {
                this.equipment.id = payload.id
                this.equipment.category_id = payload.category_id
                this.initData()
                this.show = true
                this.errors.clear()
            })
        },
        data() {
            return {
                show: false,
                isLoaded: false,
                equipment: {
                  id: null,
                  category_id: null,
                  model_id: null,
                  team_id: null,
                  status_id: null,
                  company_id: null,
                  serial: {
                    original: '',
                    prefix: '',
                    number: '',
                    validate: true
                  },
                  location: ''
                },
                categories: null,
                models: null
            }
        },
        computed: {
            modalName() {
                return 'Edit Equipment'
            }
        },
        watch: {
          'equipment.category_id': function(val, prevVal) {
              if (prevVal === null) return
              if (!val) {
                this.equipment.model_id = null
                this.models = []
              } else {
                let category = this.categories.filter(function(obj) {
                  return obj.id === val
                })
                this.equipment.serial.prefix = category[0].prefix
                this.validateSerialNumber()
                apiModels.index({category_id: val})
                  .then(response => {
                      this.models = response.data.data
                      this.equipment.model_id = null
                  })
              }
            }
        },
        methods: {
            update() {
                this.$validator.validateAll('form-edit')
                if (this.errors.any() || !this.equipment.serial.validate) {
                    return false
                }
                let data = {
                    category_id: this.equipment.category_id,
                    model_id: this.equipment.model_id,
                    id: this.equipment.id,
                    status_id: this.equipment.status_id,
                    team_id: this.equipment.team_id,
                    company_id: this.equipment.company_id
                }
                if (this.equipment.serial.original !== this.equipment.serial.prefix + ' ' + this.equipment.serial.number) {
                  data.serial = this.equipment.serial.number.replace(new RegExp('^[0]+'), '')
                }
                apiEquipments.patch(this.equipment.id, data)
                    .then(response => {
                        this.$parent.$emit('reloadData')
                        this.show = false
                    })
                    .catch(this.handleErrorResponse)
            },
            initData() {
                const data = [
                    apiCategories.index(),
                    apiEquipments.show(this.equipment.id),
                    apiModels.index({category_id: this.equipment.category_id})
                ]
                return Promise.all(data)
                    .then(response => {
                        this.categories = response[0].data.data
                        let number = response[1].data.serial.replace(response[1].data.model.category.prefix + ' ', '')
                        this.equipment = {
                          id: response[1].data.id,
                          category_id: response[1].data.model.category_id,
                          model_id: response[1].data.model_id,
                          team_id: response[1].data.team_id,
                          status_id: response[1].data.status_id,
                          serial: {
                            original: response[1].data.serial,
                            prefix: response[1].data.model.category.prefix,
                            number: number,
                            validate: true
                          },
                          company_id: response[1].data.company_id,
                          location: response[1].data.location
                        }
                        this.models = response[2].data.data
                        this.isLoaded = true
                        return response
                    })
                    .catch(this.handleErrorResponse)
            },
            validateSerialNumber: _.debounce(function() {
              if (!this.equipment.serial.number) {
                this.equipment.serial.validate = false
                return false
              }
              var pad = '0000000000'
              this.equipment.serial.number = this.equipment.serial.number.replace(new RegExp('^[0]+'), '')
              this.equipment.serial.number = this.equipment.serial.number.slice(0, 10)
              this.equipment.serial.number = pad.substring(0, pad.length - this.equipment.serial.number.length) + this.equipment.serial.number
              if (this.equipment.serial.original === this.equipment.serial.prefix + ' ' + this.equipment.serial.number) {
                this.equipment.serial.validate = true
                return true
              }
              let serial = this.equipment.serial.number
              return apiEquipments.valdiateSerial(serial, this.equipment.category_id)
                  .then(response => {
                    if (response.data.message === 'nonexistence') {
                      this.equipment.serial.validate = true
                      return true
                    }
                    this.equipment.serial.validate = false
                    return false
                  }).catch(err => {
                    if (err) {
                      this.equipment.serial.validate = false
                      return false
                    }
                  })
            }, 500)
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
