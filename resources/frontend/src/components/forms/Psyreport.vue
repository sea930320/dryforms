<template>
    <div class="card">
        <div v-if="isLoaded" class="card-body text-center">
            <form-header></form-header>
            <h4 class="mb-2">{{ $route.meta.title }}</h4>
            <div class="dropdown-divider"></div>
            <form-banner></form-banner>
            <div v-for="(time, index) in timedatas" :key="index" class="timefield">
            <b-row class="mt-3">
                <b-col>
                    <table>
                        <tr>
                            <th colspan="20" class="bg-grey">Inspection Date <date-picker v-model="time[0].current_time" type="date" format="yyyy-MM-dd" lang="en" input-class="date-field" @input="save(index,time[0].current_time)"></date-picker></th>
                        </tr>
                        <tr>
                            <td colspan="4" class="bg-grey">Outside</td>
                            <td colspan="4">Unaffected</th>
                            <td colspan="4" class="bg-grey">Affected</td>
                            <td colspan="4">Dehumidifier</th>
                            <td colspan="4" class="bg-grey">Hvac</td>
                        </tr>
                        <tr>
                            <td class="bg-grey">TEMP</td>
                            <td class="bg-grey">RH%</td>
                            <td class="bg-grey">GPP</td>
                            <td class="bg-grey">DEW</td>
                            <td>TEMP</td>
                            <td>RH%</td>
                            <td>GPP</td>
                            <td>DEW</td>
                            <td class="bg-grey">TEMP</td>
                            <td class="bg-grey">RH%</td>
                            <td class="bg-grey">GPP</td>
                            <td class="bg-grey">DEW</td>
                            <td>TEMP</td>
                            <td>RH%</td>
                            <td>GPP</td>
                            <td>DEW</td>
                            <td class="bg-grey">TEMP</td>
                            <td class="bg-grey">RH%</td>
                            <td class="bg-grey">GPP</td>
                            <td class="bg-grey">DEW</td>
                        </tr>
                    </table>
                </b-col>
            </b-row>
            <b-row class="mt-3">
                <b-col>
                    <psy-area v-for="(area, index) in time" :key="index" :title="areadatas[area.area_id]" :data="area" class="mt-3"></psy-area>
                </b-col>
            </b-row>
            </div>
            <notes class="mt-3"></notes>
        </div>
        <loading v-else></loading>
    </div>
</template>

<script type="text/babel">
    import FormHeader from './FormHeader'
    import FormBanner from './FormBanner'
    import PsyArea from './PsyArea'
    import Notes from './Notes'
    import apiProjectPsychometricDays from '../../api/project_psychometric_days'
    import Loading from '../layout/Loading'
    import DatePicker from 'vue2-datepicker'
    import _ from 'lodash'
    export default {
        components: {FormHeader, FormBanner, PsyArea, Notes, Loading, DatePicker},
        data() {
            return {
                areadatas: [],
                timedatas: [],
                newtime: [],
                project_id: null,
                isLoaded: false
            }
        },
        created() {
            this.init()
            this.$bus.$on('remove', () => {
                this.isLoaded = false
                this.init()
            })
            this.$bus.$on('add', () => {
                this.isLoaded = false
                this.init()
            })
        },
        methods: {
            init: function() {
                this.project_id = this.$route.params.project_id
                apiProjectPsychometricDays.index({
                    project_id: this.project_id
                }).then(res => {
                    this.areadatas = res.data.areadatas
                    if (this.areadatas.length === 0) {
                        this.$router.push({
                            name: 'Form Affected Areas',
                            params: {
                                project_id: this.project_id,
                                form_id: 12
                            }
                        })
                        return
                    }
                    this.timedatas = res.data.timedatas
                    for (var item in this.timedatas) {
                        this.newtime[item] = item
                    }
                    this.isLoaded = true
                }).catch(this.handleErrorResponse)
            },
            save: _.debounce(function (oldtime, newtime) {
                apiProjectPsychometricDays.updatetime({
                    project_id: this.project_id,
                    old_time: oldtime,
                    new_time: newtime
                }).then(res => {
                }).catch(this.handleErrorResponse)
            }, 500)
        }
    }
</script>

<style>
    .timefield {
        padding-bottom: 20px;
    }
    .date-field {
        text-align: left;
        width: 70%;
        border-width: 0px;
        background-color: transparent;
    }
    .mx-input-icon {
        display: none;
    }
</style>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 3px;
    }
    
    table {
        width: 100%;
        td {
            width: 5%;
        }
        input {
            text-align: center;
            width: 100%;
            background-color: transparent;
            border: none;
        }
    }

    .bg-grey {
        background-color: #c3c3c3;
    }
</style>