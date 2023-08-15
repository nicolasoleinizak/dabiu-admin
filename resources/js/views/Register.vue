<script>
  import { formRules } from '../helpers/formRules';
  import AuthForm from '../components/AuthForm.vue';
import { registerService } from '../services/authService';

  export default{
    data: function () {
      return {
        company: "",
        email: "",
        password: "",
        passwordConfirmation: "",
        emailRules: [
          formRules.email,
        ],
        passwordRules: [
          formRules.password,
        ],
        confirmationPasswordRules: [
          value => value === this.password || 'Passwords must match.',
        ],
        attemptingToRegister: false,
        attemptFailed: false,
        error: "",
      }
    },
    methods: {
      async register () {
        this.attemptingToRegister = true;
        this.attemptFailed = false;
        try {
          await registerService({
            company: this.company,
            email: this.email,
            password: this.password,
            confirmation_password: this.confirmation_password,
          })
          this.$router.push('/login')
        } catch (error) {
          this.attemptFailed = true;
          this.error = error.message;
        }
        this.attemptingToRegister = false;
      },
    },
    components: {
      AuthForm
    }
  }
</script>

<template>
  <AuthForm title="Register">
    <v-form class="w-100 align-center">
      <v-text-field label="Company" type="company" v-model="company"/>
      <v-text-field label="Email" type="email" v-model="email" :rules="emailRules"/>
      <v-text-field label="Password" type="password" v-model="password" :rules="passwordRules"/>
      <v-text-field label="Password confirmation" type="password" v-model="passwordConfirmation" :rules="confirmationPasswordRules"/>
      <v-alert closable type="error" v-if="attemptFailed">{{ this.error }}</v-alert>
      <v-container class="d-flex flex-wrap justify-center">
        <v-btn variant="flat" color="primary" class="ma-3 px-15" @click="this.register">
          <p v-if="!attemptingToRegister">Register</p>
          <v-progress-circular v-if="attemptingToRegister" indeterminate></v-progress-circular>
        </v-btn>
        <router-link to="/login"><v-btn variant="outlined" color="primary" class="ma-3">Login</v-btn></router-link>
      </v-container>
    </v-form>
  </AuthForm>
</template>