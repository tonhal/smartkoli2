<template>
    <b-alert :show="errors.length > 0" variant="danger">
        <p v-for="error in errors" :key="error" class="mb-0">
            {{ error }}
        </p>
    </b-alert>
</template>
<script>
export default {
    props: ["errors"],
};
</script>