<template>
    <b-container>
        <b-row>
            <b-col cols="3" class="text-left pt-4">
                <h6>Owner/Insured:</h6>
                <p>{{ ownerName }}</p>
            </b-col>
            <b-col cols="6">
                <b-row>
                    <b-col cols="2" class="text-right">
                        <i class="fa fa-times" @click="clearOwner"></i>
                    </b-col>
                    <b-col cols="8">
                        <vueSignature ref="ownerSignature" :h="'80px'" :sigOption="onwerSignOption" class="signature" @onEnd='drawup()'></vueSignature>
                    </b-col>
                </b-row>
            </b-col>
            <b-col cols="3" class="text-right pt-4">
                <h6>Date: {{ date }}</h6>
                <p>{{ time }}</p>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols="3" class="text-left pt-4">
                <h6>Company:</h6>
                <p>{{ companyName }}</p>
            </b-col>
            <b-col cols="6">
                <b-row>
                    <b-col cols="2" class="text-right">
                        <i class="fa fa-times" @click="clearCompany"></i>
                    </b-col>
                    <b-col cols="8">
                        <vueSignature ref="companySignature" :h="'80px'" :sigOption="companySignOption" class="signature"></vueSignature>
                    </b-col>
                </b-row>
            </b-col>
            <b-col cols="3" class="text-right pt-4">
                <h6>Date: {{ date }}</h6>
                <p>{{ time }}</p>
            </b-col>
        </b-row>
    </b-container>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                date: '12/12/2017',
                time: '0:00:00',
                ownerSignaturePng: '',
                companySignaturePng: '',
                onwerSignOption: {
                    penColor: 'rgb(255, 0, 0)',
                    onEnd: this.saveOwnerSignature
                },
                companySignOption: {
                    penColor: 'rgb(255, 0, 0)',
                    onEnd: this.saveCompanySignature
                }
            }
        },
        methods: {
            saveOwnerSignature() {
                this.ownerSignaturePng = this.$refs.ownerSignature.save()
            },
            saveCompanySignature() {
                this.companySignaturePng = this.$refs.companySignature.save()
            },
            clearOwner() {
                var _this = this
                _this.$refs.ownerSignature.clear()
            },
            clearCompany() {
                var _this = this
                _this.$refs.companySignature.clear()
            },
            drawup() {
                debugger
            }
        },
        computed: {
            ownerName: function() {
                return this.$store.state.ProjectForm.callReport ? this.$store.state.ProjectForm.callReport.insured_name : ''
            },
            companyName: function() {
                return this.$store.state.User.company.length !== 0 ? this.$store.state.User.company.name : ''
            },
            isLoaded: function() {
                return this.$store.state.User.company.length !== 0 && this.$store.state.ProjectForm.callReport
            }
        },
        watch: {
            ownerSignaturePng: function(newVal, oldVal) {
                debugger
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .signature {
        border-bottom: 1px solid black;
    }
</style>