<template>
    <div class="container">
        <LaundryCalendar :calendarEvents="events"></LaundryCalendar>
    </div>
</template>
<script>
import LaundryCalendar from "../components/LaundryCalendar";
export default {
    components: {
        LaundryCalendar,
    },

    data() {
        return {
            events: [],
        };
    },

    methods: {
        async fetchLaundries() {
            const response = await axios.get("/laundries");

            this.events = response.data;
        },
    },

    mounted() {
        this.fetchLaundries();
    },
};
</script>