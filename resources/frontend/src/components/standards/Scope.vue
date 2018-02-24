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
          <scope-list  class="mt-4 mb-3"
            v-for="(page_index) in _.range(curPageNum)" :key="page_index"
            :leftScope="leftScopes[page_index]" 
            :rightScope="rightScopes[page_index]"
            :pageIndex="page_index"
            :uoms="uoms"
            @changed="changed" @deletePage="deletePage">
          </scope-list>
          <infinite-loading @infinite="infiniteHandler" ref="infiniteLoading">
            <div slot="no-more">
              <div class="text-left">
                <b-row class="mt-3" align-h="center">
                  <b-col cols="6" class="text-center">
                    <b-button :size="template_size" variant="primary" @click="addNewPage">
                      Add New Page
                    </b-button>
                    <hr/>
                  </b-col>            
                </b-row>
                <scope-list class=""
                  :leftScope="leftMiscScopes" 
                  :rightScope="rightMiscScopes"
                  :pageIndex="'misc'"
                  :noteRowStart="noteRowStart"
                  :defLen="defLen"
                  :uoms="uoms"
                  @changed="changed">
                </scope-list>
                <div class="mt-3">
                    <b-form-checkbox v-model="addNotes" @change="setAndFilter('additional_notes_show', $event)">Addtional notes.(Select if you wish to have Additional notes text box)</b-form-checkbox>  
                </div>
                <div>
                    <b-form-checkbox v-model="addFooter" @change="setAndFilter('footer_text_show', $event)">Footer Text.(Select if you wish to have a footer text)</b-form-checkbox> 
                    <div v-if="form.footer_text_show">
                        <froala :tag="'textarea'" id="footerEditor" :config="config" v-model="form.footer_text" class="mb-3"></froala>
                    </div>
                </div>
              </div>
            </div>
          </infinite-loading>
        </b-container>
      </div>
      <div class="card-footer"></div>
    </div>
    <loading v-else></loading>
  </div>
</template>

<script type="text/babel">
  import draggable from 'vuedraggable'
  import InfiniteLoading from 'vue-infinite-loading'

  import Loading from '../layout/Loading'
  import ErrorHandler from '../../mixins/error-handler'
  import '../../../node_modules/froala-editor/js/froala_editor.pkgd.min'
  import ScopeList from './ScopeList'
  import apiStandardForm from '../../api/standard_form'
  import apiStandardScope from '../../api/standard_scope'
  import apiUom from '../../api/uom'

  export default {
    name: 'standards-project-scope',
    mixins: [ErrorHandler],
    components: { Loading, draggable, ScopeList, InfiniteLoading },
    data () {
      return {
        addNotes: false,
        addFooter: false,
        leftScopes: [],
        rightScopes: [],
        leftMiscScopes: [],
        rightMiscScopes: [],
        form: null,
        isLoaded: false,
        isbusy: false,
        defLen: 40,
        noteRowStart: this.defLen,
        curPageNum: 0,
        pageCount: 0,
        uoms: []
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
        if (field === 'additional_notes_show') {
          if (value) {
            this.noteRowStart = this.defLen * 3 / 4
          } else {
            this.noteRowStart = this.defLen
          }
        }
      },
      save() {
        if (this.isbusy) return
        this.isbusy = true
        let scopes = []
        this.leftScopes.forEach((leftScope, pageIndex) => {
          let no = 0
          leftScope.forEach((scope, index) => {
            scope.page = pageIndex + 1
            scope.no = ++no
            scopes.push(scope)
          })
        })
        this.rightScopes.forEach((rightScope, pageIndex) => {
          let no = this.leftScopes[pageIndex].length
          rightScope.forEach((scope, index) => {
            scope.page = pageIndex + 1
            scope.no = ++no
            scopes.push(scope)
          })
        })
        let miscno = 0
        this.leftMiscScopes.forEach((scope, index) => {
          scope.page = 0
          scope.no = ++miscno
          scopes.push(scope)
        })
        this.rightMiscScopes.forEach((scope, index) => {
          scope.page = 0
          scope.no = ++miscno
          scopes.push(scope)
        })
        if (this.form.id) {
            const apis = [
                apiStandardScope.store({
                  scopes: scopes
                }),
                apiStandardForm.patch(this.form.id, this.form)
            ]
            Promise.all(apis)
            .then(response => {
                this.initScopes()
                this.$notify({
                    type: 'success',
                    title: 'Success',
                    text: 'Successfully saved'
                })
            }).catch(this.handleErrorResponse)
        } else {
            const apis = [
                apiStandardScope.store({
                  scopes: scopes
                }),
                apiStandardForm.store(this.form)
            ]
            Promise.all(apis)
            .then(response => {
                this.form.id = response[1].data.form.id
                this.initScopes()
                this.$notify({
                    type: 'success',
                    title: 'Success',
                    text: 'Successfully saved'
                })
            }).catch(this.handleErrorResponse)
        }
      },
      initScopes() {
        const apis = []
        for (let i = 1; i < this.pageCount + 2; i++) {
          apis.push(apiStandardScope.index({curPageNum: i}))
        }
        this.curPageNum = 0
        Promise.all(apis)
          .then(responses => {
            responses.forEach((response, index) => {
              let curPageScopes = response.data.curPageScopes
              if (response.data.from === 'default') {
                let length = curPageScopes.length
                for (let i = 0; i < this.defLen - length; i++) {
                  curPageScopes.push({
                    page: this.curPageNum + 1,
                    service: '',
                    units: '',
                    uom: 0
                  })
                }
              }
              this.addLoadedScopes(curPageScopes, true)
            })
            this.isbusy = false
          }).catch(this.handleErrorResponse)
      },
      setForm(formID) {
        let formPerID = this.$store.getters.formPerID(formID)
        if (formPerID.length !== 0) {
            this.form = formPerID[0].standard_form[0]
            this.addNotes = (this.form.additional_notes_show === 1)
            this.addFooter = (this.form.footer_text_show === 1)
            return apiStandardScope.index({curPageNum: this.curPageNum + 1})
              .then(response => {
                this.pageCount = response.data.maxPage
                let curPageScopes = response.data.curPageScopes
                if (response.data.from === 'default') {
                  let length = curPageScopes.length
                  for (let i = 0; i < this.defLen - length; i++) {
                    curPageScopes.push({
                      page: this.curPageNum + 1,
                      service: '',
                      units: '',
                      uom: 0
                    })
                  }
                }
                this.addLoadedScopes(curPageScopes)
                this.isLoaded = true
                this.isbusy = false
              })
        } else {
            this.form = null
        }
      },
      addLoadedScopes(curPageScopes, fromInit = false) {
        if (this.curPageNum + 1 > this.pageCount) {
          this.curPageNum = this.pageCount
          return apiStandardScope.index({curPageNum: 0})
            .then(response => {
              this.pageCount = response.data.maxPage
              let curPageScopes = response.data.curPageScopes
              if (response.data.from === 'default') {
                let length = curPageScopes.length
                for (let i = 0; i < this.defLen - length; i++) {
                  curPageScopes.push({
                    page: 0,
                    service: '',
                    units: '',
                    uom: 0
                  })
                }
              }
              this.loadingCompleted(curPageScopes)
              if (!fromInit) this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete')
            }).catch(this.handleErrorResponse)
        }
        if (this.curPageNum === 0) {
          this.leftScopes = []
          this.rightScopes = []
        }
        let length = curPageScopes.length
        let leftPageScopes = []
        let rightPageScopes = []
        // for (let i = 0; i < this.defLen - length; i++) {
        //   curPageScopes.push({
        //     page: this.curPageNum + 1,
        //     service: '',
        //     units: '',
        //     uom: 0
        //   })
        // }
        // length = curPageScopes.length
        for (let i = 0; i < length / 2; i++) {
          curPageScopes[i].uom = curPageScopes[i].uom ? curPageScopes[i].uom : 0
          leftPageScopes.push(curPageScopes[i])
        }
        for (let i = Math.ceil(length / 2); i < length; i++) {
          curPageScopes[i].uom = curPageScopes[i].uom ? curPageScopes[i].uom : 0
          rightPageScopes.push(curPageScopes[i])
        }
        this.leftScopes.push(leftPageScopes)
        this.rightScopes.push(rightPageScopes)
        this.curPageNum++
        if (!fromInit) this.$refs.infiniteLoading.$emit('$InfiniteLoading:loaded')
      },
      loadingCompleted(miscPageScopes) {
        this.noteRowStart = this.form.additional_notes_show === 1 ? this.defLen * 3 / 4 : this.defLen
        this.leftMiscScopes = []
        this.rightMiscScopes = []
        let length = miscPageScopes.length
        // for (let i = 0; i < this.defLen - length; i++) {
        //   miscPageScopes.push({
        //     page: 0,
        //     service: '',
        //     units: '',
        //     uom: 0
        //   })
        // }
        // length = miscPageScopes.length
        for (let i = 0; i < length / 2; i++) {
          miscPageScopes[i].uom = miscPageScopes[i].uom ? miscPageScopes[i].uom : 0
          this.leftMiscScopes.push(miscPageScopes[i])
        }
        for (let i = Math.ceil(length / 2); i < length; i++) {
          miscPageScopes[i].uom = miscPageScopes[i].uom ? miscPageScopes[i].uom : 0
          this.rightMiscScopes.push(miscPageScopes[i])
        }
      },
      infiniteHandler($state) {
        this.setForm(2)
      },
      addNewPage() {
        let leftPageScopes = []
        let rightPageScopes = []
        for (let i = 0; i < this.defLen / 2; i++) {
          leftPageScopes.push({
            page: this.pageCount,
            service: '',
            units: '',
            uom: 0
          })
          rightPageScopes.push({
            page: this.pageCount,
            service: '',
            units: '',
            uom: 0
          })
        }
        this.$set(this.leftScopes, this.pageCount, leftPageScopes)
        this.$set(this.rightScopes, this.pageCount, rightPageScopes)
        this.pageCount++
        this.curPageNum = this.pageCount
      },
      deletePage(payload) {
        let pageIndex = payload.pageIndex
        this.pageCount--
        this.curPageNum = this.pageCount
        this.leftScopes.splice(pageIndex, 1)
        this.rightScopes.splice(pageIndex, 1)
      },
      changed(payload) {
        if (payload.pageIndex !== 'misc') {
          this.leftScopes[payload.pageIndex] = payload.leftPageScopes
          this.rightScopes[payload.pageIndex] = payload.rightPageScopes
        } else {
          this.leftMiscScopes = payload.leftPageScopes
          this.rightMiscScopes = payload.rightPageScopes
        }
      }
    },
    watch: {
      '$store.state.StandardForm.formsOrder': function() {
        this.isLoaded = false
        apiUom.index().then(response => {
          let uoms = response.data.uoms
          this.uoms = ['----']
          uoms.forEach((uom) => {
            this.uoms[uom.id] = uom.title
          })
          let formPerID = this.$store.getters.formPerID(2)
          if (formPerID.length !== 0) {
            this.form = formPerID[0].standard_form[0]
            this.addNotes = (this.form.additional_notes_show === 1)
            this.addFooter = (this.form.footer_text_show === 1)
            this.isLoaded = true
          } else {
            this.form = null
          }
        })
      }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
  @import 'froala-editor/css/froala_editor.pkgd.min.css';
  @import 'froala-editor/css/froala_style.min.css';
  @import './scss/Scope.scss';
</style>