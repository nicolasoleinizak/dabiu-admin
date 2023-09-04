import * as VueRouter from 'vue-router';
import { createApp } from 'vue';
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import 'vuetify/styles';
import colors from 'vuetify/lib/util/colors';
import '@mdi/font/css/materialdesignicons.css';
import MainComponent from './MainComponent.vue';
import LoginForm from './views/LoginForm.vue';
import RegisterForm from './views/RegisterForm.vue';
import HomeView from './views/HomeView.vue';
import Catalog from './views/sections/Catalog.vue';
import Settings from './views/sections/Settings.vue';

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
          alert: colors.yellow.base,
        },
      },
    },
    variations: {
      colors: ['primary', 'secondary', 'neuter'],
      lighten: 4,
      darken: 4,
    },
  },
  components,
  directives,
});

const routes = [
  {
    path: '/login',
    component: LoginForm,
  },
  {
    path: '/register',
    component: RegisterForm,
  },
  {
    path: '/',
    component: HomeView,
    redirect: { name: 'catalog' },
    children: [
      {
        path: '/catalog',
        name: 'catalog',
        component: Catalog,
      },
      {
        path: '/settings',
        name: 'settings',
        component: Settings,
      },
    ],
  },
];

const router = VueRouter.createRouter({
  history: VueRouter.createWebHashHistory(),
  routes,
});

const app = createApp({});

app.component('dabiu-app', MainComponent);

app.use(vuetify).use(router).mount('#app');
