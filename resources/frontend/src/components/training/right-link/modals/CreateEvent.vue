<template>
    <b-modal id="create-event-modal" :title="modalName" v-model="show">
        <b-form-group horizontal  :label-cols="3" label-text-align="right" label="<b>Title:</b>" :label-size="template_size" class="p-0 m-0 mb-3 mt-2">
            <input type="text" class="form-control form-control-sm" name="title" placeholder="Input Event Title" :size="template_size" :class="{'is-invalid': errors.has('title')}" v-validate data-vv-rules="required" v-model="newEvent.title">
        </b-form-group>
        <b-form-group horizontal  :label-cols="3" label-text-align="right" label="<b>Font color:</b>" :label-size="template_size" class="p-0 m-0 mb-2">
            <b-input-group :size="template_size" ref="colorpicker">
                <input type="text" class="form-control form-control-sm" style="background: white" v-model="colorValue" @focus="showPicker()" @input="updateFromInput" readonly>
                <b-input-group-addon class="color-picker-container">
                    <span class="current-color" :style="'background-color: ' + colorValue" @click="togglePicker()"></span>
                    <compact-picker v-model="colors" @input="updateFromPicker" v-if="displayPicker" />
                </b-input-group-addon>
            </b-input-group>
        </b-form-group>
        <div slot="modal-footer">
            <b-btn :size="template_size" class="float-right" variant="secondary" @click="show = false">
                Discard
            </b-btn>
            <b-btn :size="template_size" class="float-right mr-3" :variant="newEvent.title?'success':'invalid'" @click="create">
                Save
            </b-btn>
        </div>
    </b-modal>

</template>

<script type="text/babel">
    import { Compact } from 'vue-color'

    export default {
        name: 'create-event-modal',
        components: {
            'compact-picker': Compact
        },
        data() {
            return {
                show: false,
                colors: {
                    hex: '#0078D7'
                },
                colorValue: '',
                displayPicker: false,
                color: '#0078D7',
                newEvent: {}
            }
        },
        created() {
            this.$parent.$on('openCreateEventModal', (event) => {
                this.newEvent = event
                this.show = true
            })
        },
        mounted() {
            this.setColor(this.color || '#0078D7')
        },
        computed: {
            modalName() {
                return 'Create Event'
            }
        },
        watch: {
            show: function(val) {
                if (!val) this.$parent.$emit('refreshCalendar')
                else this.errors.clear()
                this.hidePicker()
            }
        },
        methods: {
            setColor(color) {
                this.updateColors(color)
                this.colorValue = color
            },
            updateColors(color) {
                if (color.slice(0, 1) === '#') {
                    this.colors = {
                        hex: color
                    }
                } else if (color.slice(0, 4) === 'rgba') {
                    let rgba = color.replace(/^rgba?\(|\s+|\)$/g, '').split(',')
                    let hex = '#' + ((1 << 24) + (parseInt(rgba[0]) << 16) + (parseInt(rgba[1]) << 8) + parseInt(rgba[2])).toString(16).slice(1)
                    this.colors = {
                        hex: hex,
                        a: rgba[3]
                    }
                }
            },
            showPicker() {
                this.$el.querySelector('.modal-content').addEventListener('click', this.modalClick)
                this.displayPicker = true
            },
            hidePicker() {
                this.$el.querySelector('.modal-content').removeEventListener('click', this.modalClick)
                this.displayPicker = false
            },
            togglePicker() {
                this.displayPicker ? this.hidePicker() : this.showPicker()
            },
            updateFromInput() {
                this.updateColors(this.colorValue)
            },
            updateFromPicker(color) {
                this.colors = color
                if (color.rgba.a === 1) {
                    this.colorValue = color.hex
                } else {
                    this.colorValue = 'rgba(' + color.rgba.r + ', ' + color.rgba.g + ', ' + color.rgba.b + ', ' + color.rgba.a + ')'
                }
            },
            modalClick(e) {
                let el = this.$refs.colorpicker
                let target = e.target
                if (el !== target && !el.contains(target)) {
                    this.hidePicker()
                }
            },
            create() {
                this.$validator.validateAll()
                if (this.errors.any()) {
                    return
                }
                this.newEvent.color = this.colorValue
                this.$parent.$emit('createEvent', this.newEvent)
                this.show = false
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    #create-event-modal {
        h1 {
            height: 120px;
            line-height: 120px;
            text-align: center;
        }
        .vc-chrome {
            position: absolute;
            top: 35px;
            right: 0;
            z-index: 9;
        }
        .current-color {
            display: inline-block;
            width: 16px;
            height: 16px;
            background-color: #000;
            cursor: pointer;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
        }
        .modal-header {
            background-color: rgb(0, 120, 215);
            color: white;
            text-shadow: 3px -1px 0 #737373;
            .close {
                text-shadow: 3px -1px 0 #000;
                color: white;
            }
        }
        .modal-footer {
            background-color: #f8f8f8 !important;
        }
        .input-group-addon {
            width: 31px;
            height: 31px;
            border: 1px solid #0078d7;
            span {
                width: 29px;
                height: 29px;
            }
        }
        .btn {
            font-weight: 600;
        }
        .btn-invalid {
            color: rgb(166, 166, 166);
            background-color: rgb(234, 234, 234);            
        }
    }
</style>