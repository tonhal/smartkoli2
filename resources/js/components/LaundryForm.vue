<template>
    <form @submit.prevent="formSubmitted()">
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
            <div class="form-group col-sm-6 mb-2 mb-sm-0 text-center">
                <label for="laundry-start">Mosás kezdete:</label><br />
                <b-time
                    class="border rounded p-2"
                    id="laundry-start"
                    v-model="form.start"
                    locale="hu"
                    minutes-step="15"
                ></b-time>
            </div>
            <div class="form-group col-sm-6 text-center">
                <label for="laundry-end">Mosás vége:</label><br />
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
</template>
<script>
import moment from "moment";
export default {
    data() {
        return {
            form: {
                date: null,
                start: null,
                end: null,
            },
        };
    },

    methods: {
        formSubmitted() {
            this.$emit("addNewLaundry", this.form);
        },

        setDefaultTimes() {
            const now = moment();
            this.form.date = now.format("YYYY-MM-DD");
            this.form.start = `${now.clone().add(1, "hours").format("HH")}:00`;
            this.form.end = `${now.clone().add(2, "hours").format("HH")}:00`;
        },
    },

    mounted() {
        this.setDefaultTimes();
    },
};
</script>