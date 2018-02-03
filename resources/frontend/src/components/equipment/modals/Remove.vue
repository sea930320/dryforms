<template>

    <b-modal id="removeEquipment" :title="modalName" class="text-left" @ok="remove()" v-model="show" :ok-title="'Confirm'" :ok-variant="'danger'">
        <h5>Are you sure?</h5>
    </b-modal>

</template>

<script type="text/babel">
    import apiEquipments from '../../../api/equipment'

    export default {
        name: 'remove-equipment-modal',
        created() {
            this.$parent.$on('openRemoveModal', (payload) => {
                this.equipment.id = payload.id
                this.show = true
            })
        },
        data() {
            return {
                show: false,
                equipment: {
                    id: null
                }
            }
        },
        computed: {
            modalName() {
                return 'Delete Equipment Confirmation'
            }
        },
        methods: {
            remove() {
                if (this.equipment.id) {
                    apiEquipments.delete(this.equipment.id)
                        .then(response => {
                            this.$parent.$emit('reloadData')
                        })
                        .catch(error => {
                            console.log(error.data)
                        })
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
