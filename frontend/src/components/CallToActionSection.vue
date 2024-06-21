<template>
    <div class="cta-section">
      <h2 class="text-white subheader fs-1">Ready to Revamp Your Wardrobe?</h2>
      
      <b-container fluid>
        <b-row class="justify-content-center">
          <b-col md="8" class="text-center">
            <p class='text-white fs-4'>
              Sign up today and start experiencing the convenience of SkyStyle. Upload your clothes, get tailored outfit recommendations, and shop smartly. Dressing well has never been this easy!
            </p>
          </b-col>
        </b-row>
        <b-row class="justify-content-center mt-3">
          <b-col md="3" class="text-center">
            <b-button variant="primary" class="cta-button fs-5">Log In</b-button>
          </b-col>
          <b-col md="3" class="text-center">
            <b-button variant="success" class="cta-button fs-5">Sign Up</b-button>
          </b-col>
        </b-row>
      </b-container>
    </div>
  </template>
  
  <script setup>
  import { BContainer, BRow, BCol, BButton } from 'bootstrap-vue-next';
  </script>
  
  <style scoped>
  .subheader {
    margin: 5rem;
  }
  .cta-section {
    padding: 3rem 1rem;
  }
  .cta-button {
    width: 100%;
    margin-bottom: 1rem;
  }
  </style>
  