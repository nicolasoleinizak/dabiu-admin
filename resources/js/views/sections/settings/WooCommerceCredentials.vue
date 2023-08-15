<template>
  <h2>Credenciales de Woocommerce</h2>
  <div><p>{{ credentialsState }}</p></div>
  <v-form>
    <v-text-field
      placeholder="URL del sitio"
    ></v-text-field>
    <v-text-field
      placeholder="Usuario / Api Key"
    ></v-text-field>
    <v-text-field
      placeholder="Clave / Api Token"
    ></v-text-field>
    <div class="d-flex justify-end">
      <v-btn variant="outlined">Guardar</v-btn>
    </div>
  </v-form>
</template>

<script>
export default {
  
}
</script>