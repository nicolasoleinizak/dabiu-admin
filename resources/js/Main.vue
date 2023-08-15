<script>
  export default {
    methods: {
      handleLogout: function() {
        localStorage.removeItem('token');
        this.$router.push('/login');
      }
    },
    mounted() {
      if(!localStorage.token){
        this.$router.push('/login');
      }
    }
  }
</script>

<template>
  <v-app>
    <v-main class="pa-0">
      <router-view v-on:logout="handleLogout"></router-view>
    </v-main>
  </v-app>
</template>