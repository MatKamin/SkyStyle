import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/Login.vue'
import Admin from '../components/Admin.vue'
import axios from 'axios'

const routes = [
  { path: '/', name: 'Login', component: Login },
  { path: '/admin', name: 'Admin', component: Admin, meta: { requiresAuth: true } }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    const token = localStorage.getItem('token')
    if (!token) {
      next({ name: 'Login' })
    } else {
      axios.get('http://127.0.0.1:8000/api/user', {
        headers: { 'Authorization': `Bearer ${token}` }
      }).then(response => {
        if (response.data.role >= 5) {
          next()
        } else {
          localStorage.removeItem('token')
          next({ name: 'Login' })
        }
      }).catch(() => {
        localStorage.removeItem('token')
        next({ name: 'Login' })
      })
    }
  } else {
    next()
  }
})

export default router
