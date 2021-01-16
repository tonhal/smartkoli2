<template>
    <table class="table table-hover table-centered table-striped">
        <thead>
            <tr>
                <th scope="col">Érkezés</th>
                <th scope="col">Fő</th>
                <th scope="col">Vendégszoba</th>
                <th scope="col">Törlés</th>
            </tr>
        </thead>
        <tbody>
            <template v-if="userGuests.length > 0">
                <GuestTableRow
                    v-for="guest in userGuests"
                    :key="guest.id"
                    :guest="guest"
                    v-on="$listeners"
                ></GuestTableRow>
            </template>
            <template v-else>
                <tr>
                    <td colspan="4">
                        Jelenleg nincs egyetlen közelgő vendégfogadásod sem.
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</template>
<script>
import GuestTableRow from "./GuestTableRow";
export default {
    components: {
        GuestTableRow,
    },

    props: ["userGuests"],
};
</script>
<style lang="sass">
.table td, .table th
    text-align: center
</style>