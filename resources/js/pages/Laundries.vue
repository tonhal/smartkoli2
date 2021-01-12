<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-md-0 mb-3">
                <b-card header="Új mosás" header-tag="h4">
                    <LaundryForm
                        @addNewLaundry="addNewLaundry"
                        ref="laundryForm"
                    ></LaundryForm>
                </b-card>
            </div>
            <div class="col-md-6">
                <b-card header="Közelgő mosásaim" header-tag="h4" class="h-100">
                    <table
                        class="table table-hover table-centered table-striped"
                    >
                        <thead>
                            <tr>
                                <th scope="col">Nap</th>
                                <th scope="col">Eleje</th>
                                <th scope="col">Vége</th>
                                <th scope="col">Törlés</th>
                            </tr>
                        </thead>
                        <tbody>
                            <LaundryTableRow
                                v-for="laundry in userLaundries"
                                :key="laundry.id"
                                :laundry="laundry"
                                @laundryDelete="deleteLaundry"
                            ></LaundryTableRow>
                        </tbody>
                    </table>
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
                        <LaundryCalendar
                            :calendarEvents="events"
                        ></LaundryCalendar>
                    </b-card>
                </b-overlay>
            </div>
        </div>
    </div>
</template>
<script>
import LaundryCalendar from "../components/LaundryCalendar";
import LaundryTableRow from "../components/LaundryTableRow";
import LaundryForm from "../components/LaundryForm";
import showToast from "../mixins/showToast";

export default {
    components: {
        LaundryCalendar,
        LaundryTableRow,
        LaundryForm,
    },

    props: ["userId"],

    mixins: [showToast],

    data() {
        return {
            events: [],
            eventsLoaded: false,
        };
    },

    methods: {
        async fetchLaundries() {
            const response = await axios.get("/laundries");

            this.events = response.data.map(({ id, start, end, user }) => {
                return { id, start, end, title: user.name, userId: user.id };
            });
            this.eventsLoaded = true;
        },

        addNewLaundry(formData) {
            axios
                .post("/laundries", { ...formData })
                .then((response) => {
                    this.events.push(response.data);

                    this.showToast(
                        "success",
                        "Mosás hozzáadva!",
                        "A mosásod hozzáadása sikeres volt."
                    );

                    this.$refs.laundryForm.setDefaultTimes();
                })
                .catch((error) => {
                    this.showToast(
                        "danger",
                        "Hiba a mosás hozzáadása közben.",
                        error.response.data.msg
                    );
                });
        },

        async deleteLaundry(laundryId) {
            await axios.delete(`laundries/${laundryId}`);

            this.events.splice(
                this.events.findIndex((laundry) => laundry.id === laundryId),
                1
            );

            this.showToast(
                "success",
                "Mosás törölve!",
                "A mosásod törlése sikeres volt."
            );
        },
    },

    computed: {
        userLaundries() {
            return this.events.filter(
                (laundry) => laundry.userId === this.userId
            );
        },
    },

    mounted() {
        this.fetchLaundries();
    },
};
</script>
<style lang="sass">
.table td, .table th
    text-align: center
</style>