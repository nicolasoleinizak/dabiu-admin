<script>
export default {
  methods: {
    handleLogout() {
      localStorage.removeItem('token');
      this.$router.push('/login');
    },
  },
  mounted() {
    if (!localStorage.token) {
      this.$router.push('/login');
    }
  },
};
</script>

<template>
  <v-app id="app">
    <v-main class="pa-0 bg-primary-lighten-3">
      <router-view v-on:logout="handleLogout"></router-view>
    </v-main>
  </v-app>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri&display=swap');

#app,
.v-overlay-container {
  font-family: "Hind Siliguri", sans-serif !important;
  font-size: 17px !important;
}
</style>
