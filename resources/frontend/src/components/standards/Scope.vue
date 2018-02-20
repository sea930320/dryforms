<template>
  <div class="standards-scope">    
    <div class="card text-left" v-if="isLoaded">
      <div class="card-header text-center">
          <h5> {{form.name}} </h5>
      </div>
      <div class="card-body text-left pt-3 pb-3">
        <b-container class="content-container">
          <label>* Enter side menu name</label>
          <input type="text" class="form-control mb-3" v-model="form.name">
          <label>* Enter form title</label>
          <input type="text" class="form-control" v-model="form.title">
          <b-row class="mt-3 mb-3 ml-0 mr-0">
            <b-list-group class="col-md-5 draggable mr-3">
              <b-list-group-item class="list-complete-item row fr-box">
                <b-input-group size="sm">
                  <div class="header-x text-center grey">
                    X
                  </div>
                  <b-form-input :value="'Service'" class="grey text-center" disabled="disabled"></b-form-input>
                  <b-form-input :value="'Units/Hr'" class="grey text-center" disabled="disabled"></b-form-input>
                </b-input-group>
              </b-list-group-item>
              <draggable v-model="items1" :options="{group:'project'}" @start="dragging = true" @end="updateOrder()">
                <transition-group name="list-complete">           
                  <b-list-group-item v-for="(item, index) in items1" :key="index" class="list-complete-item row fr-box">
                    <div @mouseover="mouseOver(index,'left')" @mouseleave="mouseLeave(index, 'left')">
                      <div class="fr-quick-insert" :class="item.visibleHeader?'fr-visible':''">
                        <a class="fr-floating-btn" role="button" tabindex="-1" @click="setHeader(index,'left')">
                          <i class="fa fa-header" aria-hidden="true"></i>
                        </a>
                      </div>
                      <div v-if="items1.length + items2.length > defLen" class="fr-quick-insert fr-quick-right" :class="item.visibleHeader?'fr-visible':''">
                        <a class="fr-floating-btn" role="button" tabindex="-1" @click="removeItem(index,'left')">
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                      </div>
                      <b-input-group size="sm">
                        <b-form-checkbox v-model="item.selected" value="1" unchecked-value="0" v-if="!item.is_header"> </b-form-checkbox>
                        <div v-else class="header-x text-center grey">
                          X
                        </div>
                        <b-form-input v-model="item.service" :class="item.is_header?'grey text-center':''"></b-form-input>
                        <b-form-input v-model="item.units" :class="item.is_header?'grey text-center':''"></b-form-input>
                      </b-input-group>
                    </div>
                  </b-list-group-item>
                </transition-group>
              </draggable>
            </b-list-group>
            <b-list-group class="col-md-5 draggable ml-3 mr-3">
              <b-list-group-item class="list-complete-item row fr-box">
                <b-input-group size="sm">
                  <div class="header-x text-center grey">
                    X
                  </div>
                  <b-form-input :value="'Service'" class="grey text-center" disabled="disabled"></b-form-input>
                  <b-form-input :value="'Units/Hr'" class="grey text-center" disabled="disabled"></b-form-input>
                </b-input-group>
              </b-list-group-item>
              <draggable v-model="items2" :options="{group:'project'}" @start="dragging = true" @end="updateOrder()">
                <transition-group name="list-complete">
                  <b-list-group-item v-for="(item, index) in items2" :key="index" class="list-complete-item row fr-box">
                    <div @mouseover="mouseOver(index,'right')" @mouseleave="mouseLeave(index, 'right')">
                      <div class="fr-quick-insert" :class="item.visibleHeader?'fr-visible':''">
                        <a class="fr-floating-btn" role="button" tabindex="-1" @click="setHeader(index,'right')">
                          <i class="fa fa-header" aria-hidden="true"></i>
                        </a>
                      </div>
                      <div v-if="items1.length + items2.length > defLen" class="fr-quick-insert fr-quick-right" :class="item.visibleHeader?'fr-visible':''">
                        <a class="fr-floating-btn" role="button" tabindex="-1" @click="removeItem(index,'right')">
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                      </div>
                      <b-input-group size="sm">
                        <b-form-checkbox v-model="item.selected" value="1" unchecked-value="0" v-if="!item.is_header"> </b-form-checkbox>
                        <div v-else class="header-x text-center grey">
                          X
                        </div>
                        <b-form-input v-model="item.service" :class="item.is_header?'grey text-center':''"></b-form-input>
                        <b-form-input v-model="item.units" :class="item.is_header?'grey text-center':''"></b-form-input>
                      </b-input-group>
                    </div>
                  </b-list-group-item>
                </transition-group>
              </draggable>
            </b-list-group>
            <b-list-group class="col-md-1 draggable ml-3">
              <draggable class="pt-2" v-model="items3" :options="setttingOption" @end="endDraggingToNew()">
                <transition-group name="list-complete">           
                  <b-list-group-item v-for="(item, index) in items3" :key="index" class="list-complete-item">
                    <div class="card" style="background: #007bff; color: white" @click="newItem()">
                      <div class="card-body pl-0 pr-0 pt-1 pb-1 text-center">
                        New Item
                      </div>
                    </div>
                  </b-list-group-item>
                </transition-group>
              </draggable>
            </b-list-group>
          </b-row>
          <div class="mt-3">
              <b-form-checkbox v-model="addNotes" @change="setAndFilter('additional_notes_show', $event)">Addtional notes.(Select if you wish to have Additional notes text box)</b-form-checkbox>  
          </div>
          <div>
              <b-form-checkbox v-model="addFooter" @change="setAndFilter('footer_text_show', $event)">Footer Text.(Select if you wish to have a footer text)</b-form-checkbox> 
              <div v-if="form.footer_text_show">
                  <froala :tag="'textarea'" id="footerEditor" :config="config" v-model="form.footer_text" class="mb-3"></froala>
              </div>
          </div>
        </b-container>
      </div>
      <div class="card-footer"></div>
    </div>
    <loading v-else></loading>
  </div>
</template>

<script type="text/babel">
  import draggable from 'vuedraggable'
  import Loading from '../layout/Loading'
  import ErrorHandler from '../../mixins/error-handler'
  import '../../../node_modules/froala-editor/js/froala_editor.pkgd.min'

  import apiStandardForm from '../../api/standard_form'
  import apiStandardScope from '../../api/standard_scope'

  export default {
    mixins: [ErrorHandler],
    components: { Loading, draggable },
    data () {
      return {
        addNotes: false,
        addFooter: false,
        items1: [],
        items2: [],
        items3: [
          {
            service: '',
            units: ''
          }
        ],
        form: null,
        isLoaded: false,
        dragging: false,
        setttingOption: {group: 'project'},
        isbusy: false,
        defLen: 20
      }
    },
    created() {
      this.$bus.$on('standards_save', this.save)
    },
    beforeDestroy () {
      this.$bus.$off('standards_save', this.save)
    },
    methods: {
      setAndFilter(field, value) {
        this.form[field] = (value ? 1 : 0)
        if (field === 'footer_text_show' && !value) this.form.footer_text = null
      },
      save() {
        if (this.isbusy) return
        this.isbusy = true
        let items = this.items1.concat(this.items2)
        if (this.form.id) {
            const apis = [
                apiStandardScope.store({
                  scopes: items
                }),
                apiStandardForm.patch(this.form.id, this.form)
            ]
            Promise.all(apis)
            .then(response => {
                this.$notify({
                    type: 'success',
                    title: 'Success',
                    text: 'Successfully saved'
                })
                this.setForm(2)
                this.isbusy = false
            }).catch(this.handleErrorResponse)
        } else {
            const apis = [
                apiStandardScope.store({
                  scopes: items
                }),
                apiStandardForm.store(this.form)
            ]
            Promise.all(apis)
            .then(response => {
                this.form.id = response.data.form.id
                this.$notify({
                    type: 'success',
                    title: 'Success',
                    text: 'Successfully saved'
                })
                this.setForm(2)
                this.isbusy = false
            }).catch(this.handleErrorResponse)
        }
      },
      setForm(formID) {
        let formPerID = this.$store.getters.formPerID(formID)
        if (formPerID.length !== 0) {
            this.form = formPerID[0].standard_form[0]
            this.addNotes = (this.form.additional_notes_show === 1)
            this.addFooter = (this.form.footer_text_show === 1)

            apiStandardScope.index()
                .then(response => {
                  this.items1 = response.data.scopes
                  this.items2 = []
                  this.updateOrder()
                  this.isLoaded = true
                })
        } else {
            this.form = null
        }
      },
      updateOrder() {
        let items = this.items1.concat(this.items2)
        let length = items.length
        if (length < this.defLen) {
          for (let i = 0; i < this.defLen - length; i++) {
            items.push({
              service: '',
              units: ''
            })
          }
        }
        length = items.length
        let self = this
        this.items1 = []
        this.items2 = []
        items.forEach(function(item, index) {
          if (index < length / 2) {
            self.items1.push(item)
          } else {
            self.items2.push(item)
          }
        })
        this.dragging = false
      },
      mouseOver(index, side) {
        if (side === 'left') {
          if (this.dragging) {
            this.$set(this.items1[index], 'visibleHeader', false)
          } else {
            if (this.items1.length > index) {
              this.$set(this.items1[index], 'visibleHeader', true)
            }
          }
        } else {
          if (this.dragging) {
            this.$set(this.items2[index], 'visibleHeader', false)
          } else {
            if (this.items2.length > index) {
              this.$set(this.items2[index], 'visibleHeader', true)
            }
          }
        }
      },
      mouseLeave(index, side) {
        if (side === 'left') {
          if (this.items1.length > index) {
            this.$set(this.items1[index], 'visibleHeader', false)
          }
        } else {
          if (this.items2.length > index) {
            this.$set(this.items2[index], 'visibleHeader', false)
          }
        }
      },
      setHeader(index, side) {
        if (side === 'left') {
          if (this.items1[index].is_header) {
            this.$set(this.items1[index], 'is_header', 0)
          } else {
            this.$set(this.items1[index], 'is_header', 1)
            this.$set(this.items1[index], 'selected', 0)
          }
        } else {
          if (this.items2[index].is_header) {
            this.$set(this.items2[index], 'is_header', 0)
          } else {
            this.$set(this.items2[index], 'is_header', 1)
            this.$set(this.items1[index], 'selected', 0)
          }
        }
      },
      endDraggingToNew () {
        this.items3 = [
          {
            service: '',
            units: ''
          }
        ]
        this.updateOrder()
      },
      removeItem(index, side) {
        if (side === 'left') {
          this.items1.splice(index, 1)
          this.updateOrder()
        } else {
          this.items2.splice(index, 1)
          this.updateOrder()
        }
      },
      newItem() {
        this.items2.push({
          service: '',
          units: ''
        })
        this.updateOrder()
      }
    },
    watch: {
        '$store.state.StandardForm.formsOrder': function() {
            this.isLoaded = false
            this.setForm(2)
        },
        dragging: function(val) {
          if (val) {
            this.setttingOption = {group: 'non-project'}
          } else {
            this.setttingOption = {group: 'project'}
          }
        }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
  @import 'froala-editor/css/froala_editor.pkgd.min.css';
  @import 'froala-editor/css/froala_style.min.css';
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 5px;
  }
  table {
    input {
      text-align:center;
      width: 100%;
      background-color: transparent;
      border: none;
    }
  }
  .w-60 {
    width: 60%;
  }
  .w-30 {
    width: 30%;
  }
  .w-10 {
    width: 10%;
  }
  .bg-grey {
    background-color: #c3c3c3;
  }
  .list-complete-item {
    transition: all 1s;
    cursor: pointer;
  }
  .list-complete-enter, .list-complete-leave-active {
    opacity: 0;
  }
  .standards-scope {
    .list-group-item {
      border: 0px;
      border-radius: 0px;
      padding: 0px !important;
      margin: 0px !important;
    }
  }
  .draggable {
    .fr-quick-insert {
      margin-left: -27px;
      padding: 0px !important;
      width: 27px;
      height: 31px;
    }
    .fr-quick-right {
      right: -10px;
      a {
        color: #e5321e !important;
      }
    }
    padding: 0px !important;
    label.custom-checkbox {
      width: 31px !important;
      height: 31px !important;
      padding: 0px !important;
      margin: 0px !important;
      .custom-control-indicator {
        width: 31px !important;
        height: 31px !important;
        top: 0px !important;
        border-radius: 0px !important;
        border: 1px #ced4da solid;
        background-color:white;
      }
    }
    .fr-box a.fr-floating-btn {
      line-height: 26px;
      height: 26px;
      width: 26px;
      text-decoration: none;
      i {
        line-height: 26px;
      }
    }
    .custom-control .custom-control-input:checked ~ .custom-control-indicator {
        background-size: 40% !important;
        background-position-x: 50% !important;
        background-position-y: 50% !important;
        background-repeat: no-repeat !important;
        background-color: #2196F3;
    }
    .header-x {
      width: 31px;
      height: 31px;
      line-height: 31px;
      font-weight: bold;
    }
    .grey {
      background: #cccccc;
      font-weight: bold;
    }
  }
  
  .fr-box.fr-basic.fr-top .fr-wrapper {
      height: 400px;
      overflow: auto;
  }
  table, th, td {
      border: 0px;
  }
</style>