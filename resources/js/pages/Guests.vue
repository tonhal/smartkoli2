<template>
    <div class="container">
        <div class="row"></div>
        <div class="row mt-3">
            <div class="col-12">
                <b-overlay
                    :show="!eventsLoaded"
                    spinner-variant="primary"
                    rounded="sm"
                >
                    <b-card>
                        <GuestCalendar :calendarEvents="events"></GuestCalendar>
                    </b-card>
                </b-overlay>
            </div>
        </div>
    </div>
</template>
<script>
import GuestCalendar from "../components/GuestCalendar";
export default {
    components: {
        GuestCalendar,
    },

    data() {
        return {
            events: [],
            eventsLoaded: false,
        };
    },

    methods: {
        async fetchGuests() {
            const response = await axios.get("/guests");

            this.events = response.data.map(
                ({ id, arrival, departure, guestroom, user }) => {
                    return {
                        id,
                        start: arrival,
                        end: departure,
                        title: user.name,
                        userId: user.id,
                        color: guestroom === 1 ? "#38c172" : null,
                    };
                }
            );

            this.eventsLoaded = true;
        },
    },

    mounted() {
        this.fetchGuests();
    },
};
</script>