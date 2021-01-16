<template>
    <tr>
        <template v-if="!deleteConfirm">
            <td id="day-cell">{{ dayFormatted }}</td>
            <td>{{ guest.capita }}</td>
            <td>
                <i
                    v-if="guest.guestroom"
                    class="fas fa-check-circle"
                    :style="{ color: colors.positive }"
                ></i>
                <i
                    v-else
                    class="fas fa-times-circle"
                    :style="{ color: colors.negative }"
                ></i>
            </td>
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
export default {
    props: ["guest"],
    data() {
        return {
            deleteConfirm: false,
            colors: {
                positive: "#38c172",
                negative: "#e3342f",
            },
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
<style lang="sass" scoped>
#day-cell
    font-weight: bold
</style>