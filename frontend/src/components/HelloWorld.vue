<template>
  <div>
    <h1>API Response</h1>
    <p>{{ apiResponse }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const apiResponse = ref('Loading...');

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/example');
    apiResponse.value = response.data;
  } catch (error) {
    apiResponse.value = 'Failed to fetch data';
    console.error('There was an error!', error);
  }
});
</script>