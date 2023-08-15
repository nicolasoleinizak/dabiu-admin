<template>
  <h2>Credenciales de Woocommerce</h2>
  <v-alert class="d-flex align-center" :type="alertType">
    <LoaderAndResult :state="credentialsSearchState"/>
    <span class="mx-4">{{ credentialsStateText[credentialsSearchState] }}</span>
  </v-alert>
  <v-form class="py-4">
    <v-text-field
      placeholder="URL del sitio"
      v-model="url"
    ></v-text-field>
    <v-text-field
      placeholder="Usuario / Api Key"
      v-model="username"
    ></v-text-field>
    <v-text-field
      placeholder="Clave / Api Token"
      v-model="password"
    ></v-text-field>
    <div class="d-flex justify-end">
      <v-btn variant="outlined" @click="deleteCredentials" class="mx-2" v-if="credentialsSearchState === 'success'">Borrar</v-btn>
      <v-btn variant="outlined" @click="createCredentials" class="mx-2">Guardar</v-btn>
    </div>
  </v-form>
</template>

<script>
import LoaderAndResult from '../../../components/LoaderAndResult.vue';
import { fetchStatusToAlertType } from '../../../helpers/fetchStatusToAlertType';
import { 
  checkCredentialsService,
  createCredentialsService,
  deleteCredentialsService,
} from '../../../services/credentialsService';

export default {
  data() {
    return {
      url: '',
      username: '',
      password: '',
      credentialsSearchState: 'ready',
      credentialsStateText: {
        loading: 'Buscando credenciales...',
        success: 'Credenciales encontradas',
        notFound: 'No se encontraron credenciales',
        error: 'Se ha producido un error al intentar obtener las credenciales'
      },
    }
  },
  mounted() {
    this.checkCredentials();
  },
  methods: {
    checkCredentials: function() {
      this.credentialsSearchState = 'loading';
      checkCredentialsService()
        .then((response) => {
          if (response.credentials) {
            this.credentialsSearchState = 'success';
            this.url = response.credentials.url;
            this.username = response.credentials.username;
            this.password = response.credentials.password;
          } else {
            this.credentialsSearchState = 'notFound';
          }
        })
        .catch(() => {
          this.credentialsSearchState = 'error';
        })
    },
    createCredentials: function() {
      createCredentialsService({
        url: this.url,
        username: this.username,
        password: this.password,
      }).then(() => this.checkCredentials());
    },
    deleteCredentials: function() {
      deleteCredentialsService().then(() => {
        this.clearForm();
        this.checkCredentials();
      });
    },
    clearForm: function() {
      this.url = '';
      this.username = '';
      this.password = '';
    }
  },
  computed: {
    alertType() {
      return fetchStatusToAlertType(this.credentialsSearchState);
    }
  },
  components: {
    LoaderAndResult
  }
}
</script>