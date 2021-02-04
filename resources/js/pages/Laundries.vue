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
                    <b-overlay
                        :show="!eventsLoaded"
                        spinner-variant="primary"
                        rounded="sm"
                    >
                        <LaundryTable
                            :userLaundries="userLaundries"
                            @laundryDelete="deleteLaundry"
                        ></LaundryTable>
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
import LaundryTable from "../components/tables/LaundryTable";
import LaundryForm from "../components/forms/LaundryForm";
import { getLaundries, postLaundry, deleteLaundry } from "../apis/laundries";
import showToast from "../mixins/showToast";

export default {
    components: {
        LaundryCalendar,
        LaundryTable,
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
            const response = await getLaundries();

            this.events = response.data.map(({ id, start, end, user }) => {
                return { id, start, end, title: user.name, userId: user.id };
            });
            this.eventsLoaded = true;
        },

        async addNewLaundry(formData) {
            try {
                const response = await postLaundry(formData);

                this.events.push(response.data);
                this.showToast(
                    "success",
                    "Mosás hozzáadva!",
                    "A mosásod hozzáadása sikeres volt."
                );
            } catch (error) {
                this.showToast(
                    "danger",
                    "Hiba a mosás hozzáadása közben.",
                    error.response.data.msg
                );
            }
        },

        async deleteLaundry(laundryId) {
            try {
                await deleteLaundry(laundryId);

                this.events.splice(
                    this.events.findIndex(
                        (laundry) => laundry.id === laundryId
                    ),
                    1
                );

                this.showToast(
                    "success",
                    "Mosás törölve!",
                    "A mosásod törlése sikeres volt."
                );
            } catch (error) {
                this.showToast(
                    "danger",
                    "Hiba a mosás törlése közben.",
                    error.response.data.msg
                );
            }
        },
    },

    computed: {
        userLaundries() {
            return this.events.filter(
                (laundry) =>
                    laundry.userId === this.userId &&
                    moment(laundry.start).isSameOrAfter(moment(), "day")
            );
        },
    },

    mounted() {
        this.fetchLaundries();
    },
};
</script>