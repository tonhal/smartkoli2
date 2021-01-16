<template>
    <FullCalendar :options="calendarOptions" />
</template>
<script>
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
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
                plugins: [dayGridPlugin, bootstrapPlugin],
                height: "auto",
                themeSystem: "bootstrap",
                initialView: "dayGridMonth",
                locale: huLocale,
                events: [...this.calendarEvents],
                fixedWeekCount: false,
                headerToolbar: {
                    start: "today",
                    center: "title",
                    end: "prev,next",
                },
                // dayHeaderFormat: {
                //     weekday: "long",
                //     month: "numeric",
                //     day: "numeric",
                //     omitCommas: true,
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