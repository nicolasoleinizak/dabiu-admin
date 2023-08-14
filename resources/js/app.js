//import './bootstrap';
import * as VueRouter from 'vue-router';
import { createApp } from 'vue';
import Main from './Main.vue';
import Login from './views/Login.vue';
import Register from './views/Register.vue';
import Home from './views/Home.vue';
import Catalog from './views/sections/Catalog.vue';
import Settings from './views/sections/Settings.vue';
import colors from 'vuetify/lib/util/colors'
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css'
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    },
  },
  theme: {
    themes: {
      light: {
        dark: false,
        colors: {
          primary: '#998aa5',
          secondary: colors.blue.darken2,
          neuter: '#A4A68B',
        }
      }
    },
    variations: {
      colors: ['primary', 'secondary'],
      lighten: 2,
      darken: 2,
    }
  },
  components,
  directives,
})

const routes = [
  {
    path: '/login',
    component: Login
  },
  {
    path: '/register',
    component: Register
  },
  {
    path: '/',
    component: Home,
    children: [
      {
        path: '/catalog',
        name: 'catalog',
        component: Catalog
      },
      {
        path: '/settings',
        name: 'settings',
        component: Settings
      }
    ]
  }
];

const router = VueRouter.createRouter({
  history: VueRouter.createWebHashHistory(),
  routes,
})

const app = createApp({});

app.component('dabiu-app', Main);

app.use(vuetify).use(router).mount("#app");