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
            <div class="col-md-6">
                <b-card
                    header="Közelgő vendégfogadásaim"
                    header-tag="h4"
                    class="h-100"
                >
                    <b-overlay
                        :show="!eventsLoaded"
                        spinner-variant="primary"
                        rounded="sm"
                    >
                        <GuestTable
                            :userGuests="userGuests"
                            @guestDelete="deleteGuest"
                        ></GuestTable>
                    </b-overlay>
                </b-card>
            </div>
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
import GuestTable from "../components/tables/GuestTable";
import showToast from "../mixins/showToast";
export default {
    components: {
        GuestTable,
        GuestCalendar,
        GuestForm,
    },

    mixins: [showToast],

    props: ["userId"],

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
                ({ id, arrival, departure, guestroom, user, capita }) => {
                    return {
                        id,
                        start: arrival,
                        end: departure,
                        title: user.name,
                        userId: user.id,
                        guestroom,
                        capita,
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

        deleteGuest(guestId) {
            axios
                .delete(`guests/${guestId}`)
                .then(() => {
                    this.events.splice(
                        this.events.findIndex((guest) => guest.id === guestId),
                        1
                    );

                    this.showToast(
                        "success",
                        "Vendégfogadás törölve!",
                        "A vendégfogadásod törlése sikeres volt."
                    );
                })
                .catch((error) => {
                    this.showToast(
                        "danger",
                        "Hiba a mosás törlése közben.",
                        error.response.data.msg
                    );
                });
        },
    },

    computed: {
        userGuests() {
            return this.events.filter(
                (guest) =>
                    guest.userId === this.userId &&
                    moment(guest.start).isSameOrAfter(moment(), "day")
            );
        },
    },

    mounted() {
        this.fetchGuests();
    },
};
</script>