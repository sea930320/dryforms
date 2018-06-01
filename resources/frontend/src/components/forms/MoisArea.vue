<template>
    <b-row>
        <b-col>
            <table>
                <tr>
                    <th class="bg-grey" colspan="8">{{ title }}</th>
                </tr>
                <tr>
                    <td class="bg-grey">
                        <b-form-select :options="structures" @change="save()" v-model="areaModel[0].structure"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="structures" @change="save()" v-model="areaModel[1].structure"></b-form-select>
                    </td>
                    <td class="bg-grey">
                        <b-form-select :options="structures" @change="save()" v-model="areaModel[2].structure"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="structures" @change="save()" v-model="areaModel[3].structure"></b-form-select>
                    </td>
                    <td class="bg-grey">
                        <b-form-select :options="structures" @change="save()" v-model="areaModel[4].structure"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="structures" @change="save()" v-model="areaModel[5].structure"></b-form-select>
                    </td>
                    <td class="bg-grey">
                        <b-form-select :options="structures" @change="save()" v-model="areaModel[6].structure"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="structures" @change="save()" v-model="areaModel[7].structure"></b-form-select>
                    </td>
                </tr>
                <tr>
                    <td class="bg-grey">
                        <b-form-select :options="materials" @change="save()" v-model="areaModel[0].matarial"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="materials" @change="save()" v-model="areaModel[1].matarial"></b-form-select>
                    </td>
                    <td class="bg-grey">
                        <b-form-select :options="materials" @change="save()" v-model="areaModel[2].matarial"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="materials" @change="save()" v-model="areaModel[3].matarial"></b-form-select>
                    </td>
                    <td class="bg-grey">
                        <b-form-select :options="materials" @change="save()" v-model="areaModel[4].matarial"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="materials" @change="save()" v-model="areaModel[5].matarial"></b-form-select>
                    </td>
                    <td class="bg-grey">
                        <b-form-select :options="materials" @change="save()" v-model="areaModel[6].matarial"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="materials" @input="save()" v-model="areaModel[7].matarial"></b-form-select>
                    </td>
                </tr>
                
            </table>
            <table :id="datetimefieldId+section[0].id" v-for="section in amountModel" :key="section.value">
                <tr>
                    <td colspan="8">
                        <div class="row-border p-1">
                            <i class="fa fa-times text-danger" @click="deleteTimeField(section[0].id, section[0].current_time)"></i>
                            Inspection Date <date-picker v-model="section[0].current_time" type="date" format="yyyy-MM-dd" lang="en" input-class="date-field" @input="saveAmount()"></date-picker>
                            <vue-timepicker format="hh:mm A" style="font-size:12px"></vue-timepicker>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td v-for="item in section" :key="item.id"><input type="text" v-model="item.amount" @input="saveAmount()"></td>
                </tr>
            </table>
        </b-col>
    </b-row>
</template>

<script type="text/babel">
    import apiStandardStructure from '../../api/standard_structures'
    import apiStandardMaterials from '../../api/standard_materials'
    import apiProjectMoistureSettings from '../../api/project_moisture_settings'
    import apiProjectMoistureDays from '../../api/project_moisture_days'
    import DatePicker from 'vue2-datepicker'
    import VueTimepicker from 'vue2-timepicker'
    import _ from 'lodash'
    export default {
        components: {DatePicker, VueTimepicker},
        props: ['title', 'areaid'],
        data() {
            return {
                structures: [{value: null, text: 'n/a'}],
                materials: [{value: null, text: 'n/a'}],
                areaModel: [
                    {structure: null, matarial: null},
                    {structure: null, matarial: null},
                    {structure: null, matarial: null},
                    {structure: null, matarial: null},
                    {structure: null, matarial: null},
                    {structure: null, matarial: null},
                    {structure: null, matarial: null},
                    {structure: null, matarial: null}
                ],
                amountModel: [],
                settingflag: false,
                dayflag: false,
                datetimefieldId: null,
                valuefieldId: null,
                datevalue: '2017-07-10'
            }
        },
        created() {
            this.datetimefieldId = 'datetimefield'
            const apis = [
                apiStandardStructure.index(),
                apiStandardMaterials.index(),
                apiProjectMoistureSettings.index({
                    area_id: this.areaid
                }),
                apiProjectMoistureDays.index({
                    area_id: this.areaid
                })
            ]
            return Promise.all(apis)
                .then(response => {
                    let structures = response[0].data.structures
                    structures = response[0].data.structures
                    structures.forEach(structure => {
                        structure.text = structure.title
                        structure.value = structure.id
                        this.structures.push(structure)
                    })
                    let materials = response[1].data.materials
                    materials = response[1].data.materials
                    materials.forEach(material => {
                        material.text = material.title
                        material.value = material.id
                        this.materials.push(material)
                    })
                    console.log(response[2].data)
                    if (response[2].data.length === 0) {
                        return
                    }
                    this.settingflag = true
                    let settings = response[2].data
                    let areaModeln = []
                    settings.forEach(setting => {
                        areaModeln.push({structure: setting.structure_id, matarial: setting.matarial_id})
                    })
                    this.areaModel = areaModeln
                    if (response[3].data.length === 0) {
                        return
                    }
                    this.dayflag = true
                    this.amountModel = response[3].data
                })
                .catch(this.handleErrorResponse)
        },
        methods: {
            save: _.debounce(function () {
                if (this.settingflag === false) {
                    apiProjectMoistureSettings.store({
                        areaModel: this.areaModel,
                        area_id: this.areaid
                    })
                    .then(function(response) {
                    })
                    .catch(this.handleErrorResponse)
                    this.settingflag = true
                } else {
                    apiProjectMoistureSettings.patch(this.areaid, {
                        areaModel: this.areaModel
                    }).then((res) => {
                    }).catch(this.handleErrorResponse)
                }
            }, 500),
            saveAmount: _.debounce(function () {
                apiProjectMoistureDays.patch(this.areaid, {
                    amountModel: this.amountModel
                }).then((res) => {
                }).catch(this.handleErrorResponse)
            }, 500),
            deleteTimeField (tid, curtime) {
                document.getElementById(this.datetimefieldId + tid).remove()
                apiProjectMoistureDays.delete(this.areaid, {
                    current_time: curtime
                }).then((res) => {
                }).catch(this.handleErrorResponse)
            }
        }
    }
</script>
<style>
    .date-field {
        width: 40%;
        border-width: 0px;
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
            width: 12.5%;
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

    .custom-select {
        background-color: transparent;
        border: none;
        padding: 0;
    }

    select.form-control:not([size]):not([multiple]) {
        height: 24px;
        padding-left: 2em;
    }
</style>