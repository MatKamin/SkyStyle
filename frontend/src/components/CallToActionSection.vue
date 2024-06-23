<template>
  <div class="cta-section">
    <h2 class="text-white subheader fs-1">Ready to Revamp Your Wardrobe?</h2>
    
    <b-container fluid>
      <b-row class="justify-content-center">
        <b-col md="8" class="text-center">
          <p class="text-white fs-4">
            Sign up today and start experiencing the convenience of SkyStyle. Upload your clothes, get tailored outfit recommendations, and shop smartly. Dressing well has never been this easy!
          </p>
        </b-col>
      </b-row>
      <b-row class="justify-content-center mt-3">
        <b-col xs="12" md="3" class="text-center">
          <b-button variant="primary" class="cta-button fs-5 btn-login">Log In</b-button>
        </b-col>
        <b-col xs="12" md="3" class="text-center">
          <b-button variant="success" class="cta-button fs-5 btn-signup">Sign Up</b-button>
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
    text-align: center;
  }
  
  .cta-section {
    padding: 3rem 1rem;
    background-color: #222;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  .cta-button {
    width: 100%;
    margin-bottom: 1rem;
    font-size: 1.25rem;
    padding: 0.75rem;
  }
  
  .btn-login {
    background-color: #23b6f5ac; 
    border-color: #23b6f5ac; 
  }
  
  .btn-login:hover {
    background-color: hsla(198, 91%, 55%, 0.461);
    border-color: hsla(198, 91%, 55%, 0.461);
  }
  
  .btn-signup {
    background-color: hsla(0, 0%, 100%, 0.144);
    border-color: hsla(0, 0%, 100%, 0.144);
  }
  
  .btn-signup:hover {
    background-color: hwb(0 100% 0% / 0.029);
    border-color: hwb(0 100% 0% / 0.029);
  }
  
  /* Media Queries for Responsiveness */
  @media (max-width: 1200px) {
    .subheader {
      margin: 3rem;
    }
  
    .cta-button {
      font-size: 1.125rem;
      padding: 0.65rem;
    }
  }
  
  @media (max-width: 768px) {
    .subheader {
      margin: 2rem;
    }
  
    .cta-button {
      font-size: 1rem;
      padding: 0.5rem;
    }
  }
  
  @media (max-width: 480px) {
    .subheader {
      margin: 1rem;
    }
  
    .cta-button {
      font-size: 0.875rem;
      padding: 0.5rem;
    }
  }
  </style>
  
  