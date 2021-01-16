<template>
    <table class="table table-hover table-centered table-striped">
        <thead>
            <tr>
                <th scope="col">Nap</th>
                <th scope="col">Eleje</th>
                <th scope="col">Vége</th>
                <th scope="col">Törlés</th>
            </tr>
        </thead>
        <tbody>
            <template v-if="userLaundries.length > 0">
                <LaundryTableRow
                    v-for="laundry in userLaundries"
                    :key="laundry.id"
                    :laundry="laundry"
                    v-on="$listeners"
                ></LaundryTableRow>
            </template>
            <template v-else>
                <tr>
                    <td colspan="4">
                        Jelenleg nincs egyetlen közelgő mosásod sem.
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</template>
<script>
import LaundryTableRow from "./LaundryTableRow";
export default {
    components: {
        LaundryTableRow,
    },

    props: ["userLaundries"],
};
</script>
<style lang="sass">
.table td, .table th
    text-align: center
</style>