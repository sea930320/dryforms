<template>
  <b-modal id="selectForm" :title="$route.meta.title" v-model="showModal" v-if="isLoaded">
    <div class="form-group">
        <b-form-checkbox v-model="dailylogSetting.automatically_copy" value="1" unchecked-value="0">
            Copy all notes to daily log? 
        </b-form-checkbox>
    </div>
    <div slot="modal-footer" class="w-100">
      <b-btn variant="primary" class="float-right" @click="save()">Save</b-btn>
    </div>
  </b-modal>
  <loading v-else></loading>
</template>

<script type="text/babel">
  import Loading from '../layout/Loading'
  import apiStandardDailylogSettings from '../../api/standard_dailylog_settings'
  import ErrorHandler from '../../mixins/error-handler'

  export default {
    mixins: [ErrorHandler],
    components: {
      Loading
    },
    data () {
      return {
        showModal: true,
        dailylogSetting: {
            automatically_copy: 1
        },
        isLoaded: false
      }
    },
    methods: {
        init() {
            apiStandardDailylogSettings.index()
                .then(res => {
                    this.isLoaded = true
                    this.dailylogSetting = res.data.id ? res.data : this.dailylogSetting
                }).catch(this.handleErrorResponse)
        },
        save () {
            const api = this.dailylogSetting.id ? apiStandardDailylogSettings.patch(this.dailylogSetting.id, this.dailylogSetting) : apiStandardDailylogSettings.store(this.dailylogSetting)

            api.then(res => {
                this.showModal = false
            }).catch(this.handleErrorResponse)
        }
    },
    created() {
        this.init()
    },
    computed: {
    },
    watch: {
        showModal: function () {
            if (this.showModal) {
                this.init()
            }
            if (!this.showModal) this.$router.go(-1)
        }
    }
  }
</script>