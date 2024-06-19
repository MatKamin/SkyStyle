import { createApp } from 'vue'

import { Quasar } from 'quasar'
import 'bootstrap/dist/css/bootstrap.min.css';
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/material-icons-round/material-icons-round.css'
import '@quasar/extras/fontawesome-v6/fontawesome-v6.css'
import '@quasar/extras/ionicons-v4/ionicons-v4.css'
import '@quasar/extras/themify/themify.css'
import '@quasar/extras/bootstrap-icons/bootstrap-icons.css'
import 'quasar/src/css/index.sass'
import './style.css'

import App from './App.vue'

const myApp = createApp(App)

myApp.use(Quasar, {
    plugins: {},
  })

myApp.mount('#app')


fetch('/api/weather')
.then(res => {
  if (!res.ok) {
    throw new Error('Network Response was not ok');
  }
  console.log("1");
  console.log(res);
  console.log("2");
  return res.json();
})
.then(data => {
  console.log(data);
})
.catch(err => {
  console.error('Error fetching weather data:', err);
})


fetch('/passwd')
.then(res => {
  if (!res.ok) {
    throw new Error('Network Response was not ok!');
  }
  console.log(res);
  return res.json();
})
.then(d => {
  console.log(d);
})
.catch(e => {
  console.error('Error fetching weather data:', e);
});