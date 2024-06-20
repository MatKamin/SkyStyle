import { createRouter, createWebHistory } from 'vue-router';
import Register from '../components/Register.vue';
import Main from '../components/Main.vue';
import Dashboard from '../components/Dashboard.vue';
import store from '../store';

const routes = [
  { path: '/', component: Main },
  { path: '/register', component: Register },
  { path: '/dashboard', name: 'Dashboard', component: Dashboard },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const token = store.state.authToken;

  if (to.path === '/register' && token) {
    next({ name: 'Dashboard' });
  } else {
    next();
  }
});

export default router;
