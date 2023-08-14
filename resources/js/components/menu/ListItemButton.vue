<template>
  <v-list-item
    :active="$route.name === destinyComponentName"
  >
    <v-hover>
      <template v-slot:default="{ isHovering, props }">
        <v-container
          fluid
          v-bind="props"
          :class="`${isHovering ? 'font-weight-bold' : ''}`"
          class="pa-0"
        >
          <router-link
            :to="{name: destinyComponentName}"
            class="text-decoration-none d-block pa-3"
          >
          <v-btn variant="plain">
            {{ text }}
          </v-btn>
          </router-link>
        </v-container>
      </template>
    </v-hover>
  </v-list-item>
</template>

<script>
  export default {
    name: 'ListItemButton',
    props: ['destinyComponentName', 'text'],
  }
</script>