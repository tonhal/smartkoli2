<template>
    <tr>
        <template v-if="!deleteConfirm">
            <td id="day-cell">{{ formatDay(laundry.start) }}</td>
            <td>{{ formatTime(laundry.start) }}</td>
            <td>{{ formatTime(laundry.end) }}</td>
            <td>
                <b-button
                    variant="danger"
                    size="sm"
                    @click="deleteConfirm = true"
                >
                    <span class="icon">
                        <i class="fas fa-times"></i>
                    </span>
                    <span>Törlés</span>
                </b-button>
            </td>
        </template>
        <template v-else>
            <td colspan="2">Biztosan törölni akarod ezt a mosást?</td>
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
export default {
    props: ["laundry"],
    data() {
        return {
            deleteConfirm: false,
        };
    },
    methods: {
        confirmDelete() {
            this.$emit("laundryDelete", this.laundry.id);
        },

        formatDay(day) {
            return moment(day).locale("hu").format("MMMM DD. dddd");
        },

        formatTime(time) {
            return moment(time).format("HH:mm");
        },
    },
};
</script>
<style lang="sass" scoped>
#day-cell
    font-weight: bold
</style>