<script>
import TitleLogo from './TitleLogo.vue';
  export default {
    props: ['title'],
    components: {
      TitleLogo,
    }
  }
</script>

<template>
  <v-container class="bg-primary fill-height justify-center" fluid>
        <v-card fluid class="pa-6 rounded-lg w-100 h-100" id="auth-form" >
          <v-container fluid class="fill-height" id="form-container">
            <TitleLogo />
            <p class="text-h4 w-100 text-center my-5">{{ title }}</p>
            <slot></slot>
          </v-container>
        </v-card>
  </v-container>
</template>

<style>
  #auth-form{
    max-width: 600px;
  }
  #form-container{
    overflow: auto;
  }
</style>