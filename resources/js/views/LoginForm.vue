<script>
import { formRules } from '../helpers/formRules';
import AuthForm from '../components/AuthForm.vue';
import { loginService } from '../services/authService';

export default {
  data: () => ({
    email: '',
    password: '',
    emailRules: [
      formRules.email,
    ],
    attemptingToLog: false,
    attemptFailed: false,
    error: '',
  }),
  methods: {
    async login() {
      this.attemptingToLog = true;
      this.attemptFailed = false;
      try {
        await loginService({ email: this.email, password: this.password });
        this.$router.push('/');
      } catch (error) {
        this.attemptFailed = true;
        this.error = error.message;
      }
      this.attemptingToLog = false;
    },
  },
  components: {
    AuthForm,
  },
};
</script>

<template>
  <AuthForm title='Login'>
    <v-form class='w-100 align-center'>
      <v-text-field label='Email' type='email' v-model='email' :rules='emailRules' autocomplete />
      <v-text-field label='Password' type='password' v-model='password' />
      <v-alert closable type='error' v-if='attemptFailed'>{{ this.error }}</v-alert>
      <v-container class='d-flex flex-wrap justify-center'>
        <v-btn variant='flat' color='primary' class='ma-3 px-15' @click='this.login'>
          <p v-if='!attemptingToLog'>Log In</p>
          <v-progress-circular v-if='attemptingToLog' indeterminate></v-progress-circular>
        </v-btn>
        <router-link to='/register'>
          <v-btn variant='outlined' color='primary' class='ma-3'>Create account</v-btn>
        </router-link>
      </v-container>
    </v-form>
  </AuthForm>
</template>
