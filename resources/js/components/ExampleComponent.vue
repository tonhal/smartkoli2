<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                        <b-button
                            variant="success"
                            @click="makeToast()"
                            class="mb-2"
                        >
                            Success
                        </b-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        makeToast() {
            this.$bvToast.toast("text", {
                title: "title",
                solid: true,
                variant: "success",
                toaster: "b-toaster-top-right",
                autoHideDelay: 5000,
                append: true,
            });
        },
    },
};
</script>
