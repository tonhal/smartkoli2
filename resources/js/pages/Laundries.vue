<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-md-0 mb-3">
                <b-card header="Új mosás" header-tag="h5">
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
                <b-card header="Közelgő mosásaim" header-tag="h5"> asd </b-card>
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
import showToast from "../mixins/showToast";
export default {
    components: {
        LaundryCalendar,
    },

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
            id: 2,
        };
    },

    methods: {
        async fetchLaundries() {
            const response = await axios.get("/laundries");

            this.events = response.data;
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

        resetForm() {
            Object.keys(this.form).forEach(
                (field) => (this.form[field] = null)
            );
        },
    },

    mounted() {
        this.fetchLaundries();
    },
};
</script>