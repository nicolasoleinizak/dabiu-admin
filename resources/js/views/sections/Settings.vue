<template>
  <h1>Ajustes</h1>
  <v-sheet 
  class="pa-5"
  elevation="2"
  >
    <WooCommerceCredentials />
  </v-sheet>
</template>

<script>
import WooCommerceCredentials from './settings/WooCommerceCredentials.vue';
export default{
  components: { WooCommerceCredentials }
}
</script>