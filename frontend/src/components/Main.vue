<template>
    <div>
      <q-parallax :height="500" :speed="0.5">
        <template v-slot:media>
          <img src="../assets/image.jpg">
        </template>
        <template v-slot:content>
          <NavigationBar></NavigationBar>
          <HeroSection></HeroSection>
        </template>
      </q-parallax>
      <CarouselSection></CarouselSection>
    </div>
  </template>
  
  <script setup>
    import { ref, onMounted } from 'vue';

    import NavigationBar from './NavigationBar.vue';
    import HeroSection from './HeroSection.vue';
    import CarouselSection from './CarouselSection.vue';
    
    import axios from '../axiosConfig';
  
  </script>
  
  <style scoped>
  
  .q-parallax__content {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .q-parallax__media > img, .q-parallax__media > video {
    bottom: -90%;
  }
  
  .q-parallax__media > img {
    filter:brightness(0.4);
  }
  
  .hero-section {
    margin-bottom: 20px;
  }
  
  .carousel-section {
    margin-top: 20px;
  }
  
  </style>