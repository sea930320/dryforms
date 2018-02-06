<template>
    <b-modal id="edit-user-modal" :title="modalName" class="text-left" @ok.prevent="update()" v-model="show">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" class="form-control" placeholder="Input first name" v-model="user.first_name" name="firstName" :class="{'is-invalid': errors.has('firstName')}" v-validate data-vv-rules="required">
        </div>
        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" class="form-control" placeholder="Input last name" v-model="user.last_name" name="lastName" :class="{'is-invalid': errors.has('lastName')}" v-validate data-vv-rules="required">
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="text" class="form-control" placeholder="Input Email Address" v-model="user.email" name="email" :class="{'is-invalid': errors.has('email')}" v-validate data-vv-rules="required|email">
        </div>
        <div class="form-group">
            <label>Type:</label>
            <select class="form-control form-control-sm" v-model="user.role_id" name="role" :class="{'is-invalid': errors.has('role')}" v-validate data-vv-rules="required">
                <option value="">-- Please select --</option>
                <option v-for="item in roles" v-bind:key="item.value" :value="item.value">{{ item.text }}</option>
            </select>
        </div>
        <div class="form-group">
            <label>Team:</label>
            <b-form-select v-model="user.team_id" :options="teams">
            </b-form-select>
        </div>
    </b-modal>

</template>

<script type="text/babel">
    import apiUsers from '../../../api/users'
    import ErrorHandler from '../../../mixins/error-handler'

    export default {
        mixins: [ErrorHandler],
        name: 'edit-user-modal',
        props: [
            'roles', 'teams'
        ],
        data() {
            return {
                show: false,
                id: null,
                user: {
                    id: null,
                    first_name: '',
                    last_name: '',
                    email: '',
                    role_id: null,
                    team_id: null
                }
            }
        },
        created() {
            this.$parent.$on('openEditModal', (payload) => {
                this.user.id = payload.id
                this.initData()
                this.show = true
                this.errors.clear()
            })
        },
        computed: {
            modalName() {
                return 'Edit User'
            }
        },
        methods: {
            initData() {
                let self = this
                apiUsers.show(this.user.id)
                    .then(response => {
                        self.user = response.data
                        self.user.team_id = (self.user.teams.length) ? self.user.teams[0].id : null
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            update() {
                this.$validator.validateAll()
                if (!this.errors.any()) {
                    apiUsers.patch(this.user.id, this.user)
                        .then(response => {
                            this.show = false
                            this.$parent.$emit('reloadData')
                        })
                        .catch(this.handleErrorResponse)
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
