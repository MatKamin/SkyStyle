import { createApp } from 'vue';
import { createStore } from 'vuex';
import { Quasar } from 'quasar';
import store from './store';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'quasar/src/css/index.sass';
import '@quasar/extras/material-icons/material-icons.css';
import '@quasar/extras/material-icons-round/material-icons-round.css';
import '@quasar/extras/fontawesome-v6/fontawesome-v6.css';
import '@quasar/extras/ionicons-v4/ionicons-v4.css';
import '@quasar/extras/themify/themify.css';
import '@quasar/extras/bootstrap-icons/bootstrap-icons.css';
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import BootstrapVueNext from 'bootstrap-vue-next';
import { BCard, BForm, BFormGroup, BFormInput, BButton } from 'bootstrap-vue-next';
import './style.css';
import App from './App.vue';
import router from './router';
import axios from './axiosConfig';

const app = createApp(App);

app.use(store);
app.use(Quasar, {
  plugins: {},
});
app.use(BootstrapVueNext);

// Use BootstrapVueNext components
app.component('BCard', BCard);
app.component('BForm', BForm);
app.component('BFormGroup', BFormGroup);
app.component('BFormInput', BFormInput);
app.component('BButton', BButton);

app.use(router);

app.mount('#app');
