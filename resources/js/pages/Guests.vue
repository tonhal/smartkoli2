<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-md-0 mb-3">
                <b-card header="Új vendég" header-tag="h4">
                    <GuestForm
                        @addNewGuest="addNewGuest"
                        ref="guestForm"
                    ></GuestForm>
                </b-card>
            </div>
            <div class="col-md-6"></div>
        </div>
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
import GuestForm from "../components/GuestForm";
import showToast from "../mixins/showToast";
export default {
    components: {
        GuestCalendar,
        GuestForm,
    },

    mixins: [showToast],

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
                        guestroom,
                        color: guestroom === 1 ? "#38c172" : null,
                    };
                }
            );

            this.eventsLoaded = true;
        },

        addNewGuest(formData) {
            axios
                .post("/guests", { ...formData })
                .then((response) => {
                    this.events.push(response.data);

                    this.showToast(
                        "success",
                        "Vendégéjszaka hozzáadva!",
                        "Köszönjük, hogy adminisztráltad az érkező vendégedet."
                    );

                    this.$refs.guestForm.setDefaultInputs();
                })
                .catch((error) => {
                    this.showToast(
                        "danger",
                        "Hiba a vendég hozzáadása közben!",
                        error.response.data.msg
                    );
                });
        },
    },

    mounted() {
        this.fetchGuests();
    },
};
</script>