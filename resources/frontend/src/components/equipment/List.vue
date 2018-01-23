<template>
    <div class="equipment-list">
        <div v-if="isLoaded" class="card text-center">
            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-container class="">
                  <b-row align-h="between">
                    <b-col cols="8">
                      <b-card bg-variant="light" class="mt-1 mb-1 pt-0">
                        <b-form-group vertical :label-cols="3" label-text-align="left" label="<b>Filter:</b>" :label-size="template_size" class="m-0 p-0">
                          <b-input-group :size="template_size">
                            <b-form-input v-model="filter_category" placeholder="Category" :disabled="isBusy"/>
                            <b-input-group-button class="mr-2">
                              <b-btn :size="template_size" :disabled="!filter_category || isBusy" @click="filter_category = ''">Clear</b-btn>
                            </b-input-group-button>
                            <b-form-input v-model="filter_model" placeholder="Make/Model" :disabled="isBusy"/>
                            <b-input-group-button>
                              <b-btn :size="template_size" :disabled="!filter_model || isBusy" @click="filter_model = ''">Clear</b-btn>
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
                <b-table :busy.sync="isBusy" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :items="getModel" small striped hover foot-clone :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" head-variant="">
                  <template slot="category_name" slot-scope="row">
                      <router-link :to="'/equipment/detail/cat/' + row.item.category_id + '/mod/stat'" class="pointer text-default">{{row.item.category ? row.item.category.name : 'n/a'}}</router-link>
                  </template>
                  <template slot="make_model" slot-scope="row">
                      <router-link :to="'/equipment/detail/cat/' + row.item.category_id + '/mod/' + row.item.id + '/stat'" class="pointer text-default">{{row.item.name}}</router-link>
                  </template>
                  <template slot="total" slot-scope="row">
                      {{ countPerStatus(row.item) }}
                  </template>
                  <template slot="status" slot-scope="row">
                      <b-input-group>
                        <b-form-select v-model="row.item.status" :options="statuses" :size="template_size" :disabled="isBusy">
                        </b-form-select>
                        <b-btn :size="template_size" @click="viewDetail(row.item)" :disabled="isBusy">View</b-btn>
                      </b-input-group>
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
    import apiModels from '../../api/models'
    import apiStatuses from '../../api/statuses'
    import _ from 'lodash'

    export default {
        name: 'Settings',
        components: { Loading },
        data() {
            return {
                isLoaded: false,
                models: [],
                statuses: [],
                fields: {
                  category_name: {
                    label: 'Category',
                    sortable: true,
                    'class': 'text-center field-cat'
                  },
                  make_model: {
                    label: 'Make/Model',
                    sortable: true,
                    'class': 'text-center field-mod'
                  },
                  status: {
                    label: 'Status',
                    sortable: false,
                    'class': 'text-center field-stat'
                  },
                  total: {
                    label: 'Total',
                    sortable: false,
                    'class': 'text-center field-cnt'
                  }
                },
                isBusy: false,
                currentPage: 1,
                perPage: 2,
                count: 0,
                sortBy: 'category_name',
                sortDesc: false,
                filter_category: '',
                filter_model: '',
                filter: '',
                pageSizeOption: [
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
          filter_category: function (val) {
            this.debouncer()
          },
          filter_model: function (val) {
            this.debouncer()
          }
        },
        methods: {
            initData() {
                const apis = [
                    apiModels.index({page: 1}),
                    apiStatuses.index()
                ]
                return Promise.all(apis)
                    .then(response => {
                        this.count = response[0].data.total
                        let statuses = response[1].data.data
                        this.statuses = [{ value: null, text: 'All Status' }]
                        for (let status of statuses) {
                          this.statuses.push({
                            value: status.id,
                            text: status.name
                          })
                        }
                        this.isLoaded = true

                        return response
                    })
            },
            getModel(ctx) {
              let data = {
                page: ctx.currentPage,
                sort_by: ctx.sortBy || '',
                sort_type: (ctx.sortDesc ? 'desc' : 'asc'),
                category_name: this.filter_category || '',
                model_name: this.filter_model || '',
                per_page: ctx.perPage
              }
              return apiModels.index(data)
                .then(response => {
                  let items = response.data.data
                  items = items.map(item => {
                    item.status = null
                    return item
                  })
                  this.count = response.data.total
                  this.models = items || []
                  return (this.models)
                })
            },
            debouncer: _.debounce(function() {
                this.filter = this.filter_category + '||' + this.filter_model
            }, 500),
            countPerStatus(item) {
              if (!item.status) {
                return item.total
              }
              let count = item['status_' + item.status + '_count']
              return count
            },
            viewDetail(item) {
              this.$router.push({
                name: 'Equipment Detail',
                params: {
                  category_id: item.category_id,
                  model_id: item.id,
                  status_id: item.status
                }
              })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
  .equipment-list {
      .text-default {
          color: #212529;
      }
      .text-default:hover {
          color: #212529 !important;
          text-decoration: none !important;
      }
      .field-cat {
          width: 20%
      }
      .field-mod {
          width: 40%
      }
      .field-stat {
          width: 30%
      }
      .field-cnt {
          width: 10%
      }
      .card-body {
          -webkit-box-flex: 1;
          -ms-flex: 1 1 auto;
          flex: 1 1 auto;
          padding: .25rem;
      }
  }
</style>
