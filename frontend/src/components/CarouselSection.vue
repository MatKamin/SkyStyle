<template>
    <section class="carousel">
        <q-carousel
        v-model="slide"
        transition-prev="jump-right"
        transition-next="jump-left"
        swipeable
        animated
        control-color="white"
        prev-icon="arrow_left"
        next-icon="arrow_right"
        navigation-icon="radio_button_unchecked"
        navigation
        padding
        arrows
        height="300px"
        class="bg-black text-white shadow-1"
      >
        <q-carousel-slide name="style" class="column no-wrap flex-center">
          <p>Test Page 1</p>
        </q-carousel-slide>
        <q-carousel-slide name="tv" class="column no-wrap flex-center">
            <p>Test Page 2</p>
        </q-carousel-slide>
        <q-carousel-slide name="layers" class="column no-wrap flex-center">
            <p>Test Page 3</p>
        </q-carousel-slide>
        <q-carousel-slide name="map" class="column no-wrap flex-center">
          <p>Test Page 4</p>
        </q-carousel-slide>
      </q-carousel>
    </section>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const slide = ref('style');
  </script>
  
  <style scoped>
.carousel {
  width: 50%;
  margin-left: auto;
  margin-right: auto;
}
  </style>
  