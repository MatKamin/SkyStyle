import { createRouter, createWebHistory } from 'vue-router';
import Register from '../components/Register.vue';
import Main from '../components/Main.vue';
import Dashboard from '../components/Dashboard.vue';
import Login from '../components/Login.vue';
import Wardrobes from '../components/Wardrobes.vue';
import Shop from '../components/Shop.vue';
import Weather from '../components/Weather.vue';
import Profile from '../components/Profile.vue';
import WardrobeDetails from '../components/WardrobeDetails.vue';
import store from '../store';

const routes = [
  { path: '/', component: Main },
  { path: '/register', component: Register },
  { path: '/dashboard', name: 'Dashboard', component: Dashboard },
  { path: '/login', name: 'Login', component: Login },
  { path: '/wardrobes', name: 'Wardrobes', component: Wardrobes },
  { path: '/shop', name: 'Shop', component: Shop },
  { path: '/weather', name: 'Weather', component: Weather },
  { path: '/profile', name: 'Profile', component: Profile },
  { path: '/wardrobe/:wardrobeId', name: 'WardrobeDetails', component: WardrobeDetails },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const token = store.state.authToken;
  const protectedRoutes = ['Dashboard', 'Wardrobes', 'Shop', 'Weather', 'Profile', 'WardrobeDetails'];

  if (protectedRoutes.includes(to.name) && !token) {
    next({ name: 'Login' });
  } else if ((to.path === '/register' || to.path === '/login') && token) {
    next({ name: 'Dashboard' });
  } else {
    next();
  }
});

export default router;
