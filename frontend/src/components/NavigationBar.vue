<template>
  <header class="p-3 text-white bg-primary">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand d-flex align-items-center" href="/">
          <img class="logo" src="../assets/Logo.svg" />
          <span class="ms-3">SkyStyle</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <template v-if="!isAuthenticated">
              <li class="nav-item"><router-link to="#features" class="nav-link">Features</router-link></li>
              <li class="nav-item"><router-link to="#about-us" class="nav-link">About Us</router-link></li>
            </template>
            <template v-else>
              <li class="nav-item"><router-link to="/dashboard" class="nav-link">Dashboard</router-link></li>
              <li class="nav-item"><router-link to="/wardrobes" class="nav-link">Your Wardrobes</router-link></li>
              <li class="nav-item"><router-link to="/shop" class="nav-link">Shop</router-link></li>
              <li class="nav-item"><router-link to="/weather" class="nav-link">Weather</router-link></li>
            </template>
          </ul>
          <div class="d-flex align-items-center align-right">
            <template v-if="!isAuthenticated">
              <span class="fs-6 me-4 d-inline-block align-middle text-link" @click="goToLogin">Log In</span>
              <button type="button" class="fs-6 btn btn-custom rounded-pill" @click="goToRegister">Sign Up</button>
            </template>
            <template v-else>
              <span class="ms-2 me-4 fs-6 text-link" @click="goToProfile">{{ userName }}</span>
              <button class="btn btn-link p-0" @click="logout">
                <i class="bi bi-box-arrow-right text-danger fs-4"></i>
              </button>
            </template>
          </div>
        </div>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();

const isAuthenticated = computed(() => !!store.state.authToken);
const userName = computed(() => store.state.user?.name || store.state.user?.email || 'Profile');

const goToRegister = () => {
  router.push('/register');
};

const goToLogin = () => {
  router.push('/login');
};

const goToProfile = () => {
  router.push('/profile');
};

const logout = async () => {
  try {
    const token = store.state.authToken;
    if (token) {
      await store.dispatch('logout');
      router.push('/');
    } else {
      console.error('No auth token found');
    }
  } catch (error) {
    console.error('Error during logout:', error);
  }
};
</script>

<style scoped>
header {
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  z-index: 3;
}

a.navbar-brand.d-flex.align-items-center {
  margin-right: 3rem;
}

h1 {
  line-height: 0 !important;
}

img.logo {
  height: 40px; /* Adjusted height for better responsiveness */
  width: auto;
  vertical-align: middle;
}

.align-right {
  justify-content: end;
}

.btn-custom {
  background-color: #23b6f5ac;
  border: none;
  color: white;
  padding: 0.5rem 1rem;
}

.text-end > span {
  margin-right: 1rem;
}

@media (max-width: 768px) {
  .logo {
    height: 30px; /* Smaller logo for smaller screens */
  }
  .text-end > span {
    margin-right: 0.5rem; /* Reduce margin on smaller screens */
  }
}
</style>
