<template>
    <tr>
        <template v-if="!deleteConfirm">
            <td id="day-cell">{{ dayFormatted }}</td>
            <td>{{ guest.capita }}</td>
            <td>{{ guest.guestroom }}</td>
            <td>
                <b-button
                    variant="danger"
                    size="sm"
                    @click="deleteConfirm = true"
                    >Törlés</b-button
                >
            </td>
        </template>
        <template v-else>
            <td colspan="2">Biztosan törölni akarod ezt a vendégfogadást?</td>
            <td colspan="2">
                <b-button variant="danger" size="sm" @click="confirmDelete"
                    >Törlés</b-button
                >
                <b-button size="sm" @click="deleteConfirm = false"
                    >Mégse</b-button
                >
            </td>
        </template>
    </tr>
</template>
<script>
import moment from "moment";
export default {
    props: ["guest"],
    data() {
        return {
            deleteConfirm: false,
        };
    },
    methods: {
        confirmDelete() {
            this.$emit("guestDelete", this.guest.id);
        },
    },

    computed: {
        dayFormatted() {
            return moment(this.guest.start)
                .locale("hu")
                .format("MMMM DD. dddd");
        },
    },
};
</script>