<template>
    <div class="equipment-detail">
        <div v-if="isLoaded" class="card text-center">
            <div class="card-header">
                <h5> {{header_text}} </h5>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-container>
                  <b-row align-h="between" class="mr-0 ml-0">
                    <b-col cols="6">
                      <b-card bg-variant="light" class="mt-1 mb-1 pt-0">
                        <b-form-group vertical :label-cols="3" label-text-align="left" label="<b>Filter:</b>" :label-size="template_size" class="m-0 p-0">
                          <b-input-group :size="template_size">
                            <b-form-input v-model="filter" placeholder="Type text" :disabled="isBusy"/>
                            <b-input-group-button>
                              <b-btn :size="template_size" :disabled="!filter || isBusy" @click="filter = ''">Clear</b-btn>
                            </b-input-group-button>
                          </b-input-group>
                        </b-form-group>
                      </b-card>
                    </b-col>
                    <b-col cols="2">
                      <b-card bg-variant="light" class="mt-1 mb-1 pt-0">
                        <b-form-group vertical  :label-cols="3" label-text-align="left" label="<b>Page Size:</b>" :label-size="template_size" class="p-0 m-0">
                          <b-form-select :size="template_size" :disabled="isBusy" class="form-control" :options="pageSizeOption" v-model="perPage">
                          </b-form-select>
                        </b-form-group>
                      </b-card>
                    </b-col>
                  </b-row>
                </b-container>
                <b-table :busy.sync="isBusy" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :items="getEquipment" small striped hover foot-clone :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="fiter_debouncer" head-variant="">
                    <template slot="category_name" slot-scope="row">
                      {{row.item.model.category.name ? row.item.model.category.name : 'n/a'}}
                    </template>
                    <template slot="make_model" slot-scope="row">
                      {{row.item.model.name}}
                    </template>
                    <template slot="team" slot-scope="row">
                      {{row.item.team.name}}
                    </template>
                    <template slot="status" slot-scope="row">
                      {{row.item.status.name}}
                    </template>
                </b-table>
                <div class="justify-content-center row-margin-tweak row">
                  <b-pagination v-if="!isBusy" :size="template_size" :total-rows="count" :per-page="perPage" limit="5" v-model="currentPage" />
                  <div v-else>...</div>
                </div>
            </div>
            <div class="card-footer text-muted">

            </div>
        </div>
        <loading v-else></loading>
    </div>
</template>

<script type="text/babel">
    import Loading from '../layout/Loading'
    import apiEquipment from '../../api/equipment'
    import _ from 'lodash'

    export default {
        name: 'Settings',
        components: { Loading },
        data() {
            return {
                isLoaded: false,
                equipments: [],
                header_text: '',
                fields: {
                  category_name: {
                    label: 'Category',
                    'class': 'text-center field-cat',
                    variant: 'green'
                  },
                  make_model: {
                    label: 'Make/Model',
                    sortable: true,
                    'class': 'text-center field-mod'
                  },
                  serial: {
                    label: 'Equipment #',
                    sortable: true,
                    'class': 'text-center field-serial'
                  },
                  team: {
                    label: 'Crew/Team',
                    sortable: true,
                    'class': 'text-center field-team'
                  },
                  location: {
                    label: 'Location',
                    sortable: true,
                    'class': 'text-center field-location'
                  },
                  status: {
                    label: 'Status',
                    sortable: true,
                    'class': 'text-center field-stat'
                  }
                },
                isBusy: false,
                currentPage: 1,
                perPage: 2,
                count: 0,
                sortBy: '',
                sortDesc: false,
                filter: '',
                fiter_debouncer: '',
                pageSizeOption: [
                  {
                    text: 1,
                    value: 1
                  },
                  {
                    text: 2,
                    value: 2
                  },
                  {
                    text: 5,
                    value: 5
                  },
                  {
                    text: 10,
                    value: 10
                  }
                ]
            }
        },
        created() {
            this.$nextTick(() => {
                this.initData()
            })
        },
        watch: {
          filter: function (val) {
            this.debouncer()
          }
        },
        methods: {
            initData() {
                let data = {
                    category_id: this.$route.params.category_id || '',
                    model_id: this.$route.params.model_id || '',
                    status_id: this.$route.params.status_id || ''
                }
                if (this.$route.query.id_from) {
                  for (var field in this.fields) {
                      if (this.fields.hasOwnProperty(field)) {
                          this.fields[field].sortable = false
                      }
                  }
                }
                return apiEquipment.index(data)
                    .then(response => {
                        this.count = response.data.total
                        this.isLoaded = true
                        return response
                    })
            },
            getEquipment(ctx) {
              let data = {
                category_id: this.$route.params.category_id || '',
                model_id: this.$route.params.model_id || '',
                status_id: this.$route.params.status_id || '',
                page: ctx.currentPage,
                sort_by: ctx.sortBy || '',
                sort_type: (ctx.sortDesc ? 'desc' : 'asc'),
                per_page: ctx.perPage,
                filter: ctx.filter,
                id_from: this.$route.query.id_from || ''
              }
              return apiEquipment.index(data)
                .then(response => {
                    let items = response.data.data
                    items = items.map(item => {
                        item.model = item.model || {name: ''}
                        item.model.category = item.model.category || {name: ''}
                        item.status = item.status || {name: ''}
                        item.team = item.team || {name: ''}
                        return item
                    })
                    this.count = response.data.total
                    this.header_text = (response.data.data.length) ? response.data.data[0].model.category.name : ''
                    if (this.$route.params.model_id && response.data.data.length) {
                        this.header_text += ' / ' + response.data.data[0].model.name
                        this.fields.make_model.sortable = false
                        this.fields.make_model.variant = 'green'
                        if (this.$route.params.status_id) {
                            this.header_text += ' / ' + response.data.data[0].status.name
                            this.fields.status.sortable = false
                            this.fields.status.variant = 'green'
                        }
                    }
                    this.equipments = items || []
                    return (this.equipments)
                })
            },
            debouncer: _.debounce(function() {
                this.fiter_debouncer = this.filter
            }, 500)
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    .equipment-detail {
        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: .25rem;
        }
        .field-cat {
            width: 20%;
        }
        .field-mod {
            width: 20%;
        }
        .field-serial {
            width: 20%;
        }
        .field-team {
            width: 10%;
        }
        .field-location {
            width: 20%;
        }
        .field-status {
            width: 10%;
        }
        .table-green {
            background-color: rgba(0, 0, 0, 0.05) !important;
            color: inherit !important;
        }
    }
</style>
