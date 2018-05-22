<template>
  <div class="Forms-Order">
    <div class="card text-center" v-if="isLoaded">
      <div class="card-header">
          <h5> {{ $route.meta.title }} </h5>
      </div>
      <div class="card-body text-left pt-3 pb-3">
        <b-container class="">
            <div class="videolist">
                <section v-for="video in videoUrls" :key="video.id" class="video">
                     <youtube :video-id="video.url" player-width="500" player-height="350" :player-vars="{autoplay: 0}"></youtube>
                </section>
            </div>
        </b-container>
      </div>
    </div>
    <loading v-else></loading>
  </div>
</template>

<script type="text/babel">
  
  import {mapActions} from 'vuex'
  
  import Loading from '../layout/Loading'
  
  import ErrorHandler from '../../mixins/error-handler'

  export default {
      mixins: [ErrorHandler],
      name: 'Training',
      components: { Loading },
      data () {
          return {
          }
      },
      computed: {
          isLoaded: function() {
              return this.$store.state.TrainingVideo.trainingVideos.length !== 0
          },
          videoUrls: function() {
              return this.$store.state.TrainingVideo.trainingVideos
          }
      },
      created() {
          this.$store.state.TrainingVideo.category_id = -1
          this.fetchTrainingVideo()
      },
      methods: {
        ...mapActions([
            'fetchTrainingVideo'
        ])
      }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
  .videolist {
    width: 1200px;
  }
  .video{
      padding: 20px;
      float: left;
      text-align: center;
  }
</style>