<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">
            I'm an example component.
            <b-button variant="danger"> Button </b-button>
            <b-spinner label="Spinning"></b-spinner>
          </div>
        </div>
      </div>
    </div>
    <Fullcalendar></Fullcalendar>
  </div>
</template>

<script>
import Fullcalendar from "./Fullcalendar";
export default {
  components: {
    Fullcalendar,
  },
};
</script>
