<template>
  <v-container fluid class="pa-2 pa-sm-5 pa-lg-10">
    <v-app-bar class="bg-primary-lighten-2">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer">
        <v-icon icon="mdi-menu" />
      </v-app-bar-nav-icon>
      <v-app-bar-title><Logo class="in-bar-logo pa-2 d-block"></Logo></v-app-bar-title>
    </v-app-bar>
    <v-main>
      <router-view>
      </router-view>
    </v-main>
    <v-navigation-drawer
        v-model="drawer"
        temporary
        class="bg-primary"
      >
        <v-list>
          <template
            v-for="link in links"
          >
            <ListItemButton
              :text="link.text"
              :destinyComponentName="link.destinyComponentName"
            />
          </template>
          <v-list-item>
            <v-btn id="logout-button" block variant="outlined" @click="$emit('logout')">Logout</v-btn>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
  </v-container>
</template>

<script>
  import Logo from '../components/Logo.vue';
  import ListItemButton from '../components/menu/ListItemButton.vue';

  export default{
    data() {
        return {
            drawer: false,
            links: [
              {
                destinyComponentName: 'catalog',
                text: 'Catálogo'
              },
              {
                destinyComponentName: 'settings',
                text: 'Ajustes'
              }
            ]
        };
    },
    components: {
      Logo,
      ListItemButton
    }
  }
</script>


<style>
  .in-bar-logo{
    max-width: 200px;
  }
</style>
