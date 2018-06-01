<template>
    <b-row>
        <b-col>
            <table>
                <tr>
                    <th colspan="20">
                        <i class="fa fa-times text-danger" @click="removeArea()"></i> {{ title }} <i v-if="containId === 0" class="fa fa-plus text-primary" @click="addArea()"></i>
                    </th>
                </tr>
                <tr>
                    <td class="bg-grey">
                        <input type="text" v-model="outside.temp" @change="calculate('outside')">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="outside.rh" @change="calculate('outside')">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="outside.gpp" @change="save()">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="outside.dew" @change="save()">
                    </td>
                    <td>
                        <input type="text" v-model="unaffected.temp" @change="calculate('unaffected')">
                    </td>
                    <td>
                        <input type="text" v-model="unaffected.rh" @change="calculate('unaffected')">
                    </td>
                    <td>
                        <input type="text" v-model="unaffected.gpp" @change="save()">
                    </td>
                    <td>
                        <input type="text" v-model="unaffected.dew" @change="save()">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="affected.temp" @change="calculate('affected')">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="affected.rh" @change="calculate('affected')">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="affected.gpp" @change="save()">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="affected.dew" @change="save()">
                    </td>
                    <td>
                        <input type="text" v-model="dehumidifier.temp" @change="calculate('dehumidifier')">
                    </td>
                    <td>
                        <input type="text" v-model="dehumidifier.rh" @change="calculate('dehumidifier')">
                    </td>
                    <td>
                        <input type="text" v-model="dehumidifier.gpp" @change="save()">
                    </td>
                    <td>
                        <input type="text" v-model="dehumidifier.dew" @change="save()">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="hvac.temp" @change="calculate('hvac')">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="hvac.rh" @change="calculate('hvac')">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="hvac.gpp" @change="save()">
                    </td>
                    <td class="bg-grey">
                        <input type="text" v-model="hvac.dew" @change="save()">
                    </td>
                </tr>
            </table>
        </b-col>
        <b-modal ref="addContainments" title="Add Containments" @ok="addContainments">
        <div class="form-group text-left">
            <label>Numbers of Containments:</label>
            <input type="text" name="title" class="form-control" v-model="numContainments" placeholder="Enter Number of Containments">
        </div>
        </b-modal>
    </b-row>
</template>

<script type="text/babel">
    import apiProjectPsychometricDays from '../../api/project_psychometric_days'
    import apiPsychometricCalculations from '../../api/psychometric_calculations'
    import _ from 'lodash'
    export default {
        props: ['title', 'data'],
        data() {
            return {
                outside: [],
                unaffected: [],
                affected: [],
                dehumidifier: [],
                hvac: [],
                timeId: null,
                areaId: null,
                containId: null,
                curdate: null,
                numContainments: null
            }
        },
        created() {
            this.init()
        },
        methods: {
            init() {
                this.timeId = this.data.id
                this.areaId = this.data.area_id
                this.containId = this.data.containment_id
                if (this.containId !== 0) {
                    this.title = this.title + ' (Containment ' + this.containId + ')'
                }
                this.curdate = this.data.current_time
                this.outside = JSON.parse(this.data.outside)
                this.unaffected = JSON.parse(this.data.unaffected)
                this.affected = JSON.parse(this.data.affected)
                this.dehumidifier = JSON.parse(this.data.dehumidifier)
                this.hvac = JSON.parse(this.data.hvac)
            },
            removeArea() {
                apiProjectPsychometricDays.delete(this.timeId).then(res => {
                    this.$bus.$emit('remove')
                }).catch(this.handleErrorResponse)
            },
            addArea() {
                this.$refs.addContainments.show()
            },
            addContainments() {
                apiProjectPsychometricDays.patch(this.timeId, {
                    area_id: this.areaId,
                    numContainments: this.numContainments,
                    outside: JSON.stringify(this.outside),
                    unaffected: JSON.stringify(this.unaffected),
                    affected: JSON.stringify(this.affected),
                    dehumidifier: JSON.stringify(this.dehumidifier),
                    hvac: JSON.stringify(this.hvac),
                    curdate: this.curdate
                }).then(res => {
                    this.$bus.$emit('add')
                }).catch(this.handleErrorResponse)
            },
            calculate: _.debounce(function (field) {
                if (field === 'outside') {
                    this.outside.temp = parseInt(this.outside.temp)
                    this.outside.rh = parseInt(this.outside.rh)
                    this.outside.dew = parseInt(this.outside.temp) + parseInt(this.outside.rh)
                    apiPsychometricCalculations.index({
                        temperature: this.outside.temp,
                        rh: this.outside.rh
                    }).then(res => {
                        this.outside.gpp = res.data.result
                    }).catch(this.handleErrorResponse)
                } else if (field === 'unaffected') {
                    this.unaffected.temp = parseInt(this.unaffected.temp)
                    this.unaffected.rh = parseInt(this.unaffected.rh)
                    this.unaffected.dew = parseInt(this.unaffected.temp) + parseInt(this.unaffected.rh)
                    apiPsychometricCalculations.index({
                        temperature: this.unaffected.temp,
                        rh: this.unaffected.rh
                    }).then(res => {
                        this.unaffected.gpp = res.data.result
                    }).catch(this.handleErrorResponse)
                } else if (field === 'affected') {
                    this.affected.temp = parseInt(this.affected.temp)
                    this.affected.rh = parseInt(this.affected.rh)
                    this.affected.dew = parseInt(this.affected.temp) + parseInt(this.affected.rh)
                    apiPsychometricCalculations.index({
                        temperature: this.affected.temp,
                        rh: this.affected.rh
                    }).then(res => {
                        this.affected.gpp = res.data.result
                    }).catch(this.handleErrorResponse)
                } else if (field === 'dehumidifier') {
                    this.dehumidifier.temp = parseInt(this.dehumidifier.temp)
                    this.dehumidifier.rh = parseInt(this.dehumidifier.rh)
                    this.dehumidifier.dew = parseInt(this.dehumidifier.temp) + parseInt(this.dehumidifier.rh)
                    apiPsychometricCalculations.index({
                        temperature: this.dehumidifier.temp,
                        rh: this.dehumidifier.rh
                    }).then(res => {
                        this.dehumidifier.gpp = res.data.result
                    }).catch(this.handleErrorResponse)
                } else if (field === 'hvac') {
                    this.hvac.temp = parseInt(this.hvac.temp)
                    this.hvac.rh = parseInt(this.hvac.rh)
                    this.hvac.dew = parseInt(this.hvac.temp) + parseInt(this.hvac.rh)
                    apiPsychometricCalculations.index({
                        temperature: this.hvac.temp,
                        rh: this.hvac.rh
                    }).then(res => {
                        this.hvac.gpp = res.data.result
                    }).catch(this.handleErrorResponse)
                }
                apiProjectPsychometricDays.store({
                    timeId: JSON.stringify(this.timeId),
                    outside: JSON.stringify(this.outside),
                    unaffected: JSON.stringify(this.unaffected),
                    affected: JSON.stringify(this.affected),
                    dehumidifier: JSON.stringify(this.dehumidifier),
                    hvac: JSON.stringify(this.hvac)
                }).then(res => {
                }).catch(this.handleErrorResponse)
            }, 500)
        }
    }
</script>

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
