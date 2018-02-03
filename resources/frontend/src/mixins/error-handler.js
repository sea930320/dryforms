export default {
    data() {
        return {}
    },
    methods: {
        // TODO refactor with lodash
        handleErrorResponse(error) {
            let messages = ''
            if (error.data.message) {
                messages = error.data.message
            } else {
                for (let message in error.data) {
                    messages += error.data[message][0] + '<br>'
                }
            }
            this.$notify({
                type: 'error',
                title: error.statusText,
                text: messages
            })
        },
        errorSerialValidate(msg) {
            this.$notify({
                type: 'error',
                title: 'Invalid Serial Number',
                text: msg
            })
        }
    }
}
