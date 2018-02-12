<template>
    <b-list-group class="text-left p-0" v-if="isStandards === false">
        <b-list-group-item v-for="link in leftLinks" :key="link.name" :class="link.mb ? 'bg-blue mb-2' : 'bg-side-left'">
            <router-link :to="link.path" :class="link.mb ? 'pointer text-black' : 'pointer text-white'">
                <p class="m-0"><img v-if="link.icon != ''" :src="link.icon"> {{ link.name }}</p>
            </router-link>
        </b-list-group-item>        
    </b-list-group>
    <b-list-group v-else-if="isStandards === true && isLoaded" class="text-left p-0">
        <b-list-group-item class="bg-blue mb-2 list-complete-item">
            <router-link :to="{name: 'Forms Order'}" class="pointer text-white">
                <p class="m-0"><img v-if="leftLinksIcon['Forms Order'] != ''" :src="leftLinksIcon['Forms Order']"> Forms Order</p>
            </router-link>
        </b-list-group-item> 
        <b-list-group-item v-for="link in formsOrder" :key="link.id" class="list-complete-item" :class="link.mb ? 'bg-blue mb-2' : 'bg-side-left'">
            <router-link :to="{name: 'Standards Form', params: {form_id: link.form_id}}" :class="link.mb ? 'pointer text-white' : 'pointer text-white'">
                <p class="m-0">
                    <!-- <img v-if="leftLinksIcon[link.form.name] != ''" :src="leftLinksIcon[link.form.name]" class="leftLinkImg"> -->
                <input type="text" v-model="link.standard_form[0].name" class="leftLinkInput" @input="updateFormName(link.standard_form[0])">
                </p>
            </router-link>
        </b-list-group-item>
    </b-list-group>
    <loading v-else></loading>
</template>

<script type="text/babel">
    import {mapActions} from 'vuex'
    import Loading from './Loading'
    import apiStandardForm from '../../api/standard_form'

    import _ from 'lodash'
    import ErrorHandler from '../../mixins/error-handler'

    export default {
        mixins: [ErrorHandler],
        components: {
          Loading
        },
        computed: {
            formsOrder: function() {
                return this.$store.state.StandardForm.formsOrder
            },
            isLoaded: function() {
                return this.isStandards === true && this.formsOrder.length !== 0
            }
        },
        created() {
            this.leftLinksIcon = this.$config.get('leftLinksIcon')
            if (this.$route.path.indexOf('standards') !== -1) {
                this.isStandards = true
            } else {
                this.leftLinks = this.$route.meta.leftLinks
                this.isStandards = false
            }
            this.fetchFormsOrder()
        },
        data() {
            return {
                leftLinks: [],
                isStandards: null,
                leftLinksIcon: {}
            }
        },
        methods: {
            ...mapActions([
                'fetchFormsOrder'
            ]),
            updateFormName: _.debounce(function (standardForm) {
                if (standardForm.id) {
                    apiStandardForm.patch(standardForm.id, {
                        id: standardForm.id,
                        name: standardForm.name
                    }).then(response => {
                    }).catch(this.handleErrorResponse)
                } else {
                    apiStandardForm.store(standardForm)
                    .then(response => {
                        standardForm.id = response.data.form.id
                    }).catch(this.handleErrorResponse)
                }
            }, 500)
        },
        watch: {
            '$route' (to, from) {
                if (to.path.indexOf('standards') !== -1) {
                    this.isStandards = true
                } else {
                    this.leftLinks = this.$route.meta.leftLinks
                    this.isStandards = false
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .list-group {
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.3);
    }
    .list-group-item {
        border-radius: unset;
        padding: 0.5rem 1.25rem;
    }
    .bg-blue {
        background-color: #046ac3;
    }
    .bg-grey {
        background-color: #c8c8c8;
    }
    .bg-side-left {
        background-color: rgba(187, 187, 187, 0.2);
        border-radius: 50px;
        box-shadow: inset 0px 0px 20px 2px rgba(230, 219, 219, 0.18), 0px 0px 0px 0px rgba(228, 219, 219, 0.15);
        margin: 15px 15px 0px 15px;
        border: 0px;
    }
    .text-black {
        color: black;
    }
    .leftLinkImg {
        float: left;
    }
    .leftLinkInput {
        text-align: left;
        background-color: transparent;
        border: none;
        width: calc(100% - 39px);
        float: left;
        margin-left: 7px;
        cursor: pointer;
        color: white;
    }
</style>