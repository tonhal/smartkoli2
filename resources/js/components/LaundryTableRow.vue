<template>
    <tr>
        <template v-if="!deleteConfirm">
            <td>{{ laundry.start }}</td>
            <td>{{ laundry.end }}</td>
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
            <td colspan="2">Biztosan törölni akarod ezt a mosást?</td>
            <td>
                <b-button size="sm" @click="deleteConfirm = false"
                    >Cancel</b-button
                >
                <b-button variant="danger" size="sm" @click="confirmDelete"
                    >Törlés</b-button
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
    },
};
</script>