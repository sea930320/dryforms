<template>
    <b-modal v-model="show" :title="modalTitle" class="cancel-subscription"
            header-bg-variant="danger"
            header-text-variant="light"
            body-bg-variant="light"
            body-text-variant="dark"
            footer-bg-variant="light"
            footer-text-variant="light">
        <p class="float-center mb-1">
            Confirmation of this statement will cancel your subscription what will lead to unavailability to use our service. All employees of your company will remain valid till the end of their payed period.
        </p>
        <label class="feedback-label">Please tell us why you decided to cancel your subscription</label>
        <textarea class="feedback" v-model="feedback"></textarea>
        <div slot="modal-footer">
            <b-btn :size="template_size" class="float-right" variant="warning" @click="continueCancel">
                Submit
            </b-btn>
            <b-btn  :size="template_size" class="float-right mr-3" variant="secondary" @click="declineCancel">
                Decline
            </b-btn>
        </div>
    </b-modal>

</template>

<script type="text/babel">
    export default {
        name: 'cancel-subscription-modal',
        data() {
            return {
                show: false,
                modalTitle: 'Warning',
                feedback: ''
            }
        },
        created() {
            this.$parent.$on('openCancelSubscriptionModal', () => {
                this.show = true
            })
        },
        watch: {
            show: function(val) {
                this.feedback = ''
            }
        },
        methods: {
            continueCancel() {
                this.$parent.$emit('continueCancel', {
                    feedback: this.feedback
                })
                this.show = false
            },
            declineCancel() {
                this.show = false
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
.cancel-subscription {
    .feedback {
        width: 80%;
        height: 100px;
        resize: none;
        overflow-y: hidden;
        overflow-x: auto;
        border: 1px solid lightgrey;
        border-radius: 5px;
    }
    .feedback-label {
        font-size: 12px;
        font-weight: 400;
    }
}
</style>