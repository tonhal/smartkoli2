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
        <ValidationErrors :errors="validationErrors"></ValidationErrors>
        <b-button
            :disabled="validationErrors.length > 0"
            type="submit"
            block
            variant="primary mt-2"
        >
            Hozzáadás
        </b-button>
    </form>
</template>
<script>
import moment from "moment";
import ValidationErrors from "./FormValidationErrors";
export default {
    components: {
        ValidationErrors,
    },

    data() {
        return {
            form: {
                date: null,
                start: null,
                end: null,
            },
            defaultTimesSet: false,
        };
    },

    methods: {
        formSubmitted() {
            if (this.validationErrors.length === 0) {
                this.$emit("addNewLaundry", this.form);
            }
        },

        setDefaultTimes() {
            const now = moment();
            this.form.date = now.format("YYYY-MM-DD");
            this.form.start = `${now
                .clone()
                .add(1, "hours")
                .format("HH")}:00:00`;
            this.form.end = `${now.clone().add(2, "hours").format("HH")}:00:00`;

            this.defaultTimesSet = true;
        },

        hasFormatError(timeString, isDate) {
            const timeRegex = /^(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/;
            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (isDate) {
                if (timeString.match(dateRegex)) return false;
                else return true;
            } else {
                if (timeString.match(timeRegex)) return false;
                else return true;
            }
        },
    },

    computed: {
        validationErrors() {
            let errors = [];
            if (!this.defaultTimesSet) return errors;

            if (
                Object.values(this.form).filter((value) => value === null)
                    .length === 0
            ) {
                let start = moment(`${this.form.date}T${this.form.start}`);
                let end = moment(`${this.form.date}T${this.form.end}`);

                if (this.hasFormatError(this.form.start, false))
                    errors.push(
                        "A mosás kezdésének időformátuma nem megfelelő."
                    );
                if (this.hasFormatError(this.form.end, false))
                    errors.push("A mosás végének időformátuma nem megfelelő.");
                if (this.hasFormatError(this.form.date, true))
                    errors.push("A dátum időformátuma nem megfelelő.");
                if (start.hours() < 7)
                    errors.push("A mosás kezdési időpont túl korai.");
                if (end.hours() > 22 && this.form.end !== "23:00:00")
                    errors.push("A mosás végének időpontja túl későn van.");
                if (start >= end)
                    errors.push(
                        "A mosás végének későbbre kell esnie, mint a kezdésnek."
                    );
            } else {
                Object.keys(this.form).forEach((field) => {
                    if (this.form[field] === null)
                        errors.push(`A ${field} mező nem lehet üres.`);
                });
            }

            return errors;
        },
    },

    mounted() {
        this.setDefaultTimes();
    },
};
</script>