<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-md-0 mb-3">
                <b-card header="Új mosás" header-tag="h4">
                    <form @submit.prevent="addNewLaundry()">
                        <label for="laundry-date">Állítsd be a dátumot:</label>
                        <b-form-datepicker
                            id="laundry-date"
                            v-model="form.date"
                            :date-format-options="{
                                year: 'numeric',
                                month: 'numeric',
                                day: 'numeric',
                                weekday: 'long',
                            }"
                            locale="hu"
                            class="mb-2"
                        ></b-form-datepicker>
                        <div class="form-row mt-3">
                            <div
                                class="form-group col-sm-6 mb-2 mb-sm-0 text-center"
                            >
                                <label for="laundry-start">Mosás kezdete:</label
                                ><br />
                                <b-time
                                    class="border rounded p-2"
                                    id="laundry-start"
                                    v-model="form.start"
                                    locale="hu"
                                    minutes-step="15"
                                ></b-time>
                            </div>
                            <div class="form-group col-sm-6 text-center">
                                <label for="laundry-end">Mosás vége:</label
                                ><br />
                                <b-time
                                    class="border rounded p-2"
                                    id="laundry-end"
                                    v-model="form.end"
                                    locale="hu"
                                    minutes-step="15"
                                ></b-time>
                            </div>
                        </div>
                        <b-button type="submit" block variant="primary mt-2">
                            Hozzáadás
                        </b-button>
                    </form>
                </b-card>
            </div>
            <div class="col-md-6">
                <b-card header="Közelgő mosásaim" header-tag="h4">
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
import showToast from "../mixins/showToast";
import moment from "moment";

export default {
    components: {
        LaundryCalendar,
        LaundryTableRow,
    },

    props: ["userId"],

    mixins: [showToast],

    data() {
        return {
            events: [],
            eventsLoaded: false,
            form: {
                date: null,
                start: null,
                end: null,
            },
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

        addNewLaundry() {
            axios
                .post("/laundries", { ...this.form })
                .then((response) => {
                    this.events.push(response.data);

                    this.showToast(
                        "success",
                        "Mosás hozzáadva!",
                        "A mosásod hozzáadása sikeres volt."
                    );

                    this.resetForm();
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

        setDefaultTimes() {
            const now = moment();
            this.form.date = now.format("YYYY-MM-DD");
            this.form.start = `${now.clone().add(1, "hours").format("HH")}:00`;
            this.form.end = `${now.clone().add(2, "hours").format("HH")}:00`;
        },

        resetForm() {
            Object.keys(this.form).forEach(
                (field) => (this.form[field] = null)
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
        this.setDefaultTimes();
    },
};
</script>
<style lang="sass">
.table td, .table th
    text-align: center
</style>