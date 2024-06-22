<template>
  <header class="p-3 text-white">
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-between">
        <!-- Logo Section -->
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <img class="logo" src="../assets/Logo.svg" />
          <span class="mr-6">SkyStyle</span>
        </a>

        <!-- Navigation Links -->
        <ul class="nav me-auto mb-2 justify-content-center mb-md-0">
          <template v-if="!isAuthenticated">
            <li><a href="#" class="nav-link px-3 text-white fs-5 d-inline-block align-middle">Features</a></li>
            <li><a href="#" class="nav-link px-3 text-white fs-5 d-inline-block align-middle">About Us</a></li>
          </template>
          <template v-else>
            <li><a href="/dashboard" class="nav-link px-3 text-white fs-5 d-inline-block align-middle">Dashboard</a></li>
            <li><a href="/wardrobes" class="nav-link px-3 text-white fs-5 d-inline-block align-middle">Your Wardrobes</a></li>
            <li><a href="/shop" class="nav-link px-3 text-white fs-5 d-inline-block align-middle">Shop</a></li>
            <li><a href="/weather" class="nav-link px-3 text-white fs-5 d-inline-block align-middle">Weather</a></li>
          </template>
        </ul>

        <!-- Right-side Icons and Buttons -->
        <div class="text-end d-flex align-items-center">
          <template v-if="!isAuthenticated">
            <span class="fs-5 me-4 d-inline-block align-middle text-link" @click="goToLogin">Log In</span>
            <button type="button" class="fs-5 btn btn-custom rounded-pill" @click="goToRegister">Sign Up</button>
          </template>
          <template v-else>
            <span class="ms-2 me-4 fs-5 text-link" @click="goToProfile">{{ userName }}</span>
            <button class="btn btn-link p-0" @click="logout">
              <i class="bi bi-box-arrow-right text-danger fs-4"></i>
            </button>
          </template>
        </div>
      </div>
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
}

a.d-flex.align-items-center {
  margin-right: 3rem;
}

img.logo {
  height: 60px;
  width: auto;
  vertical-align: middle;
}

.btn-custom {
  background-color: #23b6f5ac;
  border: none;
  color: white;
  padding-right: 1vw;
  padding-left: 1vw;
}

.nav-link {
  padding-left: 1rem;
  padding-right: 1rem;
}

.text-end > span {
  margin-right: 2rem;
}

</style>
