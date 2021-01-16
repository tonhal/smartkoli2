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

    //props: ["calendarEvents"],

    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, bootstrapPlugin],
                height: "auto",
                themeSystem: "bootstrap",
                initialView: "dayGridMonth",
                locale: huLocale,
                events: [
                    {
                        title: "asdf",
                        start: "2020-12-12",
                        end: "2021-01-04",
                    },
                    {
                        title: "asdf",
                        start: "2021-01-14",
                        end: "2021-01-17",
                        color: "red",
                    },
                ],
                fixedWeekCount: false,
                // slotMinTime: "07:00:00",
                // slotMaxTime: "23:00:00",
                // allDaySlot: false,
                // nowIndicator: true,
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
};
</script>