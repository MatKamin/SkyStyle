<template>
  <div>
    <q-parallax :height="500" :speed="0.5">
      <template v-slot:media>
        <img src="./assets/image.jpg">
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

import NavigationBar from './components/NavigationBar.vue';
import HeroSection from './components/HeroSection.vue';
import CarouselSection from './components/CarouselSection.vue';

/**
fetch('http://127.0.0.1:8000/api/weather')
.then(res => {
  if (!res.ok) {
    throw new Error('Network Response was not ok');
  }
  console.log("1");
  console.log(res);
  console.log("2");
  return res.json();
})
.then(data => {
  console.log(data);
})
.catch(err => {
  console.error('Error fetching weather data:', err);
})


fetch('/api/passwd')
.then(res => {
  if (!res.ok) {
    throw new Error('Network Response was not ok!');
  }
  console.log(res);
  return res.json();
})
.then(d => {
  console.log(d);
})
.catch(e => {
  console.error('Error fetching weather data:', e);
});*/

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