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
        <label for="comment-input">Vendég adatok, megjegyzések</label>
        <b-form-input
            id="comment-input"
            v-model="form.comment"
            placeholder="Írd ide a vendég(ek) nevét..."
        ></b-form-input>
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
        },
    },

    mounted() {
        this.setDefaultInputs();
    },
};
</script>