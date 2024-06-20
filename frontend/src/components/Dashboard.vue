<template>
    <div>
      <h1>WOHOOO Registered or Logged in</h1>
      <button @click="logout">Logout</button>
    </div>
  </template>
  
  <script setup>
  import { useStore } from 'vuex';
  import axios from '../axiosConfig';
  import { useRouter } from 'vue-router';
  
  const store = useStore();
  const router = useRouter();
  
  const logout = async () => {
    try {
      const token = store.state.authToken; // Get token from Vuex store
      if (token) {
        await axios.post('/logout', {}, {
          headers: {
            Authorization: `Bearer ${token}` // Include token in request headers
          }
        });
        store.commit('clearAuthToken'); // Clear token from store
        router.push('/'); // Redirect to home or login page
      } else {
        console.error('No auth token found');
      }
    } catch (error) {
      console.error('Error during logout:', error);
    }
  };
  </script>
  
  <style scoped>
  button {
    padding: 10px 20px;
    background-color: #f44;
    color: white;
    border: none;
    cursor: pointer;
  }
  </style>
  