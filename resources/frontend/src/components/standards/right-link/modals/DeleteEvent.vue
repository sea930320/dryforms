<template>
    <b-modal id="create-event-modal" :title="modalName" v-model="show"
        header-bg-variant="danger">
        <p>
            <i style="color:#dc3545" class="fa fa-exclamation-triangle"></i>
            Are you sure you want to remove this event?
        </p>
        <div slot="modal-footer">            
            <b-btn :size="template_size" class="float-right" variant="secondary" @click="show = false">
                No
            </b-btn>
            <b-btn :size="template_size" class="float-right mr-3" variant="warning" @click="deleteEvent">
                Yes
            </b-btn>
        </div>
    </b-modal>

</template>

<script type="text/babel">
    export default {
        name: 'delete-event-modal',
        data() {
            return {
                show: false,
                event: {}
            }
        },
        created() {
            this.$parent.$on('openDeleteEventModal', () => {
                this.show = true
            })
        },
        computed: {
            modalName() {
                return 'Delete Event'
            }
        },
        methods: {
            deleteEvent() {
                this.$parent.$emit('deleteEvent')
                this.show = false
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    #delete-event-modal {
        .footer {
            margin-top: 20px;
            text-align: center;
        }
        .modal-footer {
            background-color: #f8f8f8 !important;
        }
        .btn {
            font-weight: 600;
        }
    }
</style>