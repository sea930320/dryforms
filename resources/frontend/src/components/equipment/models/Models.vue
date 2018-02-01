<template>
    <div class="equipment-model">
        <div class="card text-center" v-if="isLoaded">
            <create-modal></create-modal>
            <delete-modal></delete-modal>
            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
                <button class="btn pull-right btn-create" @click="openCreateModal()"><i class="fa fa-plus"></i></button>
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
                <b-table ref="ModelTable" :busy.sync="isBusy" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :items="getList" small striped hover foot-clone :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="fiter_debouncer" head-variant="">
                  <template slot="category_name" slot-scope="row">
                    {{row.item.category ? row.item.category.name: 'n/a'}}
                  </template>
                  <template slot="make_model" slot-scope="row">
                    {{row.item.name}}
                  </template>
                  <template slot="action" slot-scope="row">
                    <button class="btn btn-xs btn-default" @click="openEditModal(row.item.id)">
                        <i class="fa fa-pencil"></i> Edit
                    </button>
                    <button class="btn btn-xs btn-danger" @click="openDeleteModal(row.item.id)">
                        <i class="fa fa-trash"></i> Delete
                    </button>
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
    import Loading from '../../layout/Loading'
    import apiModels from '../../../api/models'
    import CreateModal from './modals/CreateModal'
    import DeleteModal from './modals/DeleteModal'

    import _ from 'lodash'

    export default {
        name: 'Models',
        data() {
            return {
                isLoaded: false,
                models: [],
                modal: null,
                fields: {
                  make_model: {
                    label: 'Name',
                    sortable: true,
                    'class': 'text-center field-name',
                    variant: 'green'
                  },
                  category_name: {
                    label: 'Category',
                    sortable: true,
                    'class': 'text-center field-category'
                  },
                  action: {
                    label: 'Actions',
                    sortable: false,
                    'class': 'text-center field-act'
                  }
                },
                isBusy: false,
                currentPage: 1,
                perPage: 10,
                count: 0,
                sortBy: '',
                sortDesc: false,
                filter: '',
                fiter_debouncer: ''
            }
        },
        components: {CreateModal, DeleteModal, Loading},
        created() {
            this.$nextTick(() => {
                this.initData()
            })
            this.$on('reloadData', () => {
                this.initData()
                this.$refs.ModelTable.refresh()
            })
        },
        watch: {
          filter: function (val) {
            this.debouncer()
          }
        },
        methods: {
            initData() {
                return apiModels.index({page: 1})
                    .then(response => {
                        this.count = response.data.total
                        this.isLoaded = true
                        return response
                    })
            },
            getList(ctx) {
                let data = {
                  page: ctx.currentPage,
                  sort_by: ctx.sortBy || '',
                  sort_type: (ctx.sortDesc ? 'desc' : 'asc'),
                  per_page: ctx.perPage,
                  filter: ctx.filter
                }
                return apiModels.index(data)
                    .then(response => {
                        this.models = response.data.data || []
                        this.count = response.data.total
                        return this.models
                    })
            },
            debouncer: _.debounce(function() {
                this.fiter_debouncer = this.filter
            }, 500),
            openCreateModal() {
                this.$emit('openCreateModal')
            },
            openEditModal(id) {
                this.$emit('openEditModal', {
                    id: id
                })
            },
            openDeleteModal(id) {
                this.$emit('openDeleteModal', {
                    id: id
                })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    .equipment-model {
        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: .25rem;
        }
        .field-name {
            width: 40%;
        }
        .field-category {
            width: 40%;
        }
        .field-act {
            width: 20%;
        }
        .card-header {
            position: relative;
            .btn-create {
              position: absolute;
              top: 0px;
              bottom: 0px;
              right: 0px;
              font-size: 15px;
            }
        }
    }
</style>
