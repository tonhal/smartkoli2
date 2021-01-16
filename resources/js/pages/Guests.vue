<template>
    <div class="container">
        <div class="row"></div>
        <div class="row mt-3">
            <div class="col-12">
                <b-card>
                    <GuestCalendar></GuestCalendar>
                </b-card>
            </div>
        </div>
    </div>
</template>
<script>
import GuestCalendar from "../components/GuestCalendar";
export default {
    components: {
        GuestCalendar,
    },
};
</script>