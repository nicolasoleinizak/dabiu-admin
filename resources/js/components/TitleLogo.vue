<template>
  <v-container id="logo" class="d-flex justify-center">
    <Logo id="title-logo" class="w-100"/>
  </v-container>
</template>

<script>
  import Logo from './Logo.vue';
  export default {
    components: {
      Logo,
    },
  }
</script>

<style>
  #title-logo {
    max-width: 400px !important;
  }
</style>