<template>
    <section class="carousel">
      <q-carousel
        v-model="activeRecommendation"
        animated
        swipeable
        control-color="white"
        prev-icon="arrow_left"
        next-icon="arrow_right"
        navigation-icon="radio_button_unchecked"
        navigation
        padding
        arrows
        height="700px"
        class="carousels text-white shadow-1"
      >
        <q-carousel-slide :name="index" v-for="(recommendation, index) in outfitRecommendations" :key="index" class="column no-wrap flex-center">
          <div class="outfit-slide">
            <div v-for="item in recommendation.items" :key="item.name" class="q-mb-sm item-container">
              <img :src="item.image" :alt="item.name" class="item-image" />
              <div>{{ item.name }}</div>
            </div>
            <div class="buttons-container">
              <q-btn label="Use This Style" color="primary" @click="useRecommendation(recommendation)" class="q-mr-sm" />
              <q-btn icon="refresh" color="primary" flat @click="refreshRecommendation" />
            </div>
          </div>
        </q-carousel-slide>
      </q-carousel>
    </section>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { QCarousel, QCarouselSlide, QBtn } from 'quasar';
  
  const activeRecommendation = ref(0);
  
  const outfitRecommendations = ref([
    {
      items: [
        { name: 'Hat', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
        { name: 'Scarf', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
        { name: 'Shirt', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
        { name: 'Pullover', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
        { name: 'Jacket', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
        { name: 'Pants', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
        { name: 'Socks', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
        { name: 'Shoes', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' }
      ]
    },
    { 
      items: [
        { name: 'Scarf', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
        { name: 'Jacket', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
        { name: 'Jeans', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
        { name: 'Boots', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' }
      ]
    }
  ]);
  
  onMounted(() => {
    console.log("Outfit Recommendations:", outfitRecommendations.value);
  });
  
  const refreshRecommendation = () => {
    // Logic to refresh recommendations can be added here
  };
  
  const useRecommendation = (recommendation) => {
    // Logic to handle the user using the recommended style
  };
  </script>
  
  <style scoped>
  .carousel {
    width: 90%;
    margin: auto;
  }
  
  .q-carousel, .q-panel-parent {
    border-radius: 25px;
    overflow: hidden; /* Hides the scrollbar */
  }
  
  .outfit-slide {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 20px 0px;
  }
  
  .item-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 10px;
  }
  
  .item-image {
    height: 150px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 5px;
  }
  
  .buttons-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    padding-bottom: 5em;
  }
  
  .bg-dark {
    background-color: #343a40;
  }
  
  .text-white {
    color: white;
  }

  .carousels {
        background-color: #444444;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
    }
  </style>
  