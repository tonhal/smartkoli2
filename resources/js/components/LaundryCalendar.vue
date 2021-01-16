<template>
    <FullCalendar :options="calendarOptions" />
</template>
<script>
import FullCalendar from "@fullcalendar/vue";
import timeGridPlugin from "@fullcalendar/timegrid";
import huLocale from "@fullcalendar/core/locales/hu";
import bootstrapPlugin from "@fullcalendar/bootstrap";

export default {
    components: {
        FullCalendar,
    },

    props: ["calendarEvents"],

    data() {
        return {
            calendarOptions: {
                plugins: [timeGridPlugin, bootstrapPlugin],
                height: "auto",
                themeSystem: "bootstrap",
                initialView: "timeGridWeek",
                locale: huLocale,
                events: this.calendarEvents,
                slotMinTime: "07:00:00",
                slotMaxTime: "23:00:00",
                allDaySlot: false,
                nowIndicator: true,
                headerToolbar: {
                    start: "today",
                    center: "title",
                    end: "prev,next",
                },
                dayHeaderFormat: {
                    weekday: "long",
                    month: "numeric",
                    day: "numeric",
                    omitCommas: true,
                },
            },
        };
    },

    watch: {
        calendarEvents() {
            this.calendarOptions.events = [...this.calendarEvents];
        },
    },
};
</script>