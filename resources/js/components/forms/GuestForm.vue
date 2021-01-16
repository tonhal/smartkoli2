<template>
    <form @submit.prevent="formSubmitted()">
        <label for="arrival-date">Érkezés időpontja:</label>
        <b-form-datepicker
            id="arrival-date"
            v-model="form.arrival"
            :date-format-options="dateInputOptions"
            locale="hu"
            class="mb-2"
        ></b-form-datepicker>
        <label for="departure-date">Távozás időpontja:</label>
        <b-form-datepicker
            id="departure-date"
            v-model="form.departure"
            :date-format-options="dateInputOptions"
            locale="hu"
            class="mb-2"
        ></b-form-datepicker>
        <label for="capita-input">Elszállásoltak száma</label>
        <b-form-spinbutton
            id="capita-input"
            v-model="form.capita"
            min="1"
            max="10"
            class="mb-2"
        ></b-form-spinbutton>
        <b-form-checkbox switch size="md" v-model="form.guestroom" class="my-3"
            >Vendégszoba</b-form-checkbox
        >
        <label for="comment-input">Vendég adatai, megjegyzések:</label>
        <b-form-input
            id="comment-input"
            class="mb-3"
            v-model="form.comment"
            placeholder="Írd ide a vendég(ek) nevét..."
        ></b-form-input>
        <ValidationErrors :errors="validationErrors"></ValidationErrors>
        <b-button
            :disabled="validationErrors.length > 0"
            type="submit"
            block
            variant="primary mt-2"
        >
            <span class="icon"> <i class="fas fa-check"></i></span>
            <span>Hozzáadás</span>
        </b-button>
    </form>
</template>
<script>
import ValidationErrors from "./FormValidationErrors";
export default {
    components: {
        ValidationErrors,
    },

    data() {
        return {
            form: {
                arrival: null,
                departure: null,
                guestroom: true,
                capita: 1,
                comment: "",
            },
            dateInputOptions: {
                year: "numeric",
                month: "numeric",
                day: "numeric",
                weekday: "long",
            },
            defaultInputsSet: false,
        };
    },

    methods: {
        formSubmitted() {
            this.$emit("addNewGuest", this.form);
        },

        setDefaultInputs() {
            let form = this.form;
            form.arrival = moment().format("YYYY-MM-DD");
            form.departure = moment().add(1, "days").format("YYYY-MM-DD");
            form.guestroom = true;
            form.capita = 1;
            form.comment = "";

            this.defaultInputsSet = true;
        },

        hasFormatError(timeString) {
            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;

            if (timeString.match(dateRegex)) return false;
            else return true;
        },
    },

    computed: {
        validationErrors() {
            let errors = [];

            if (!this.defaultInputsSet) return errors;

            const { arrival, departure, comment } = this.form;

            if (this.hasFormatError(arrival))
                errors.push("Az érkezés időformátuma nem megfelelő.");
            if (this.hasFormatError(departure))
                errors.push("Az távozás időformátuma nem megfelelő.");
            if (moment(arrival).isSameOrAfter(departure))
                errors.push(
                    "A távozásnak későbbre kell esnie, mint az érkezésnek."
                );
            if (comment === null || comment === "")
                errors.push("Kötelező megadnod a vendég(ek) nevét.");

            return errors;
        },
    },

    mounted() {
        this.setDefaultInputs();
    },
};
</script>