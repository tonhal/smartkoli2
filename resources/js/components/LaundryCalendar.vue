<template>
    <FullCalendar :options="calendarOptions" />
</template>
<script>
import FullCalendar from "@fullcalendar/vue";
import timeGridPlugin from "@fullcalendar/timegrid";
//import interactionPlugin from "@fullcalendar/interaction";

export default {
    components: {
        FullCalendar,
    },

    props: ["calendarEvents"],

    data() {
        return {
            calendarOptions: {
                plugins: [timeGridPlugin],
                initialView: "timeGridWeek",
                events: this.calendarEvents,
            },
        };
    },

    watch: {
        calendarEvents() {
            this.calendarOptions.events = this.calendarEvents;
        },
    },
};
</script>