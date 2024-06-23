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
      class="text-white shadow-1 carousels"
    >
      <q-carousel-slide name="style" class="column no-wrap flex-center">
        <h3 class="carousel-title">Intelligent Wardrobe Management</h3>
        <p class="carousel-text">Upload your wardrobe effortlessly and let our AI categorize your clothes for you. Shirts, pants, jackets – you name it, we’ll recognize it!</p>
      </q-carousel-slide>
      <q-carousel-slide name="tv" class="column no-wrap flex-center">
        <h3 class="carousel-title">Weather-Based Recommendations</h3>
        <p class="carousel-text">Receive outfit suggestions based on the current weather and forecasts. Whether it’s sunny or rainy, SkyStyle ensures you’re always dressed appropriately.</p>
      </q-carousel-slide>
      <q-carousel-slide name="layers" class="column no-wrap flex-center">
        <h3 class="carousel-title">Shopping Suggestions</h3>
        <p class="carousel-text">Get personalized shopping recommendations to complete your wardrobe. Our platform suggests items that match your style and the weather conditions.</p>
      </q-carousel-slide>
      <q-carousel-slide name="map" class="column no-wrap flex-center">
        <h3 class="carousel-title">User-Friendly Customization</h3>
        <p class="carousel-text">Easily update and customize your wardrobe parameters. Our intuitive interface lets you adjust clothing details to your liking.</p>
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
    width: 80%;
    max-width: 800px;
    margin: -30px auto 0 auto;
    transition: width 0.3s ease;
  }
  
  .q-carousel, .q-panel-parent {
    border-radius: 25px;
  }
  
  .carousels {
    background-color: #444444;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
  }
  
  .carousel-title {
    font-size: 1.5rem;
    text-align: center;
    margin: 0.5rem 0;
    font-weight: bold;
  }
  
  .carousel-text {
    font-size: 1rem;
    text-align: center;
    padding: 0 1rem;
  }
  
  @media (max-width: 1200px) {
    .carousel {
      width: 90%;
    }
  
    .carousel-title {
      font-size: 1.25rem;
    }
  
    .carousel-text {
      font-size: 0.9rem;
    }
  }
  
  @media (max-width: 768px) {
    .carousel {
      width: 100%;
    }
  
    .carousel-title {
      font-size: 1rem;
    }
  
    .carousel-text {
      font-size: 0.8rem;
    }
  }
  
  @media (max-width: 480px) {
    .carousel {
      width: 100%;
    }
  
    .carousel-title {
      font-size: 0.875rem;
    }
  
    .carousel-text {
      font-size: 0.75rem;
    }
  }
  </style>
  
  