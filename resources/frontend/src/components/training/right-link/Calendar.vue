<template>
    <div class="standards-calendar">
        <div class="card text-center" v-if="isLoaded">
            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
            </div>
            <div class="card-body text-left">
                <button @click="refreshEvents">Refresh</button>
                <button v-if="selected.id" @click="removeEvent">Remove</button>
                <pre>{{ selected.id }}</pre>
                <create-event></create-event>
                <delete-event></delete-event>
                <full-calendar ref="calendar" :event-sources="eventSources" @event-selected="eventSelected" @event-created="eventCreated" :config="config" @event-drop="eventChanged" @event-resize="eventChanged"></full-calendar>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
        <loading v-else></loading>
    </div>
</template>

<script>
    import Loading from '../../layout/Loading'
    import CreateEvent from './modals/CreateEvent'
    import DeleteEvent from './modals/DeleteEvent'
    
    export default {
        name: 'Calendar',
        data() {
            return {
                isLoaded: false,
                events: [
                    {
                        title: 'event1',
                        start: '2018-06-09'
                    },
                    {
                        title: 'event2',
                        start: '2018-06-12',
                        end: '2018-06-15'
                    }
                ],
                selected: {
                    id: null,
                    title: '',
                    start: '',
                    end: '',
                    allDay: '',
                    color: ''
                },
                config: {
                    eventColor: '#bce8f1',
                    eventTextColor: 'white'
                }
            }
        },
        components: { Loading, CreateEvent, DeleteEvent },
        created() {
            // get events from remote and set to local
            this.isLoaded = true
            this.$on('createEvent', (event) => {
                this.refreshEvents()
                this.$refs.calendar.$emit('render-event', event)
                this.events = this.$refs.calendar.fireMethod('clientEvents')
            })
            this.$on('refreshCalendar', () => {
                this.refreshEvents()
            })
            this.$on('deleteEvent', () => {
                this.removeEvent()
            })
        },
        methods: {
            refreshEvents() {
                this.$refs.calendar.$emit('refetch-events')
            },
            removeEvent() {
                this.$refs.calendar.$emit('remove-event', this.selected.id)
                this.events = this.$refs.calendar.fireMethod('clientEvents')
                this.selected.id = null
            },
            eventSelected(event) {
                this.selected = {
                    id: event._id
                }
                this.$emit('openDeleteEventModal', event)
            },
            eventCreated(event) {
                this.$refs.calendar.$emit('render-event', event)
                this.$emit('openCreateEventModal', event)
            },
            eventChanged(event) {
                this.events = this.$refs.calendar.fireMethod('clientEvents')
            }
        },
        computed: {
            eventSources() {
                const self = this
                return [
                    {
                        events(start, end, timezone, callback) {
                            callback(self.events)
                        }
                    }
                ]
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
.standards-calendar {
    @import 'fullcalendar/dist/fullcalendar.min.css';
    .card-body {
        background: #f4f4f4;
    }
    .fc-center {
        color: #2196f3;
        text-shadow: 2px 2px 10px hsla(0,24%,71%,.9);
        h2 {
            font-size: 1.5em;
        }
    }
    .fc-view-container {
        background: white;
    }
}
</style>