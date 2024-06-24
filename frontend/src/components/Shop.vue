<template>
    <q-layout view="lHh Lpr lFf">
      
      <NavigationBar />
      <br/><br/><br/><br/><br/><br/>
      <q-page-container>
        <q-page class="q-pa-md">
          <div class="shop">
            
            <div class="shop-grid">
              <q-card v-for="item in shopItems" :key="item.id" class="q-mb-md shop-item">
                <q-img :src="item.image" :alt="item.name" class="item-image" />
                <q-card-section>
                  <div class="item-details">
                    <h5>{{ item.name }}</h5>
                    <p>{{ item.description }}</p>
                    <q-btn label="Buy Now" color="primary" @click="buyItem(item.id)" />
                  </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
        </q-page>
      </q-page-container>
      
      <!-- Overlay for Coming Soon -->
      <div class="overlay">
        <div class="overlay-text">coming soon...</div>
      </div>
    </q-layout>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { QLayout, QHeader, QPageContainer, QPage, QBtn, QCard, QCardSection, QImg } from 'quasar';
  import NavigationBar from './NavigationBar.vue';
  
  const shopItems = ref([
    { id: 1, name: 'Winter Coat', description: 'Warm and cozy winter coat', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
    { id: 2, name: 'Summer T-Shirt', description: 'Cool and comfortable T-shirt', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
    { id: 3, name: 'Running Shoes', description: 'Durable and lightweight running shoes', image: 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png' },
    // Add more items as needed
  ]);
  
  const addItem = () => {
    // Logic to add a new item
    console.log('Add new item');
  };
  
  const buyItem = (itemId) => {
    // Logic to handle buying an item
    console.log(`Buy item with ID: ${itemId}`);
  };
  
  onMounted(() => {
    console.log('Shop Items:', shopItems.value);
  });
  </script>
  
  <style scoped>
  .shop {
    width: 90%;
    margin: auto;
  }
  
  .shop-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
  }
  
  .shop-item {
    border-radius: 15px;
    overflow: hidden;
  }
  
  .item-image {
    height: 200px;
    object-fit: cover;
  }
  
  .item-details {
    padding: 10px;
    text-align: center;
  }
  
  .q-header {
    padding: 20px;
  }
  
  .q-mb-md {
    margin-bottom: 16px;
  }
  
  .bg-primary {
    background-color: #007bff;
  }
  
  .text-white {
    color: white;
  }
  
  .overlay {
    position: fixed;
    top: 0px;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;
  }
  
  .overlay-text {
    color: white;
    font-size: 2rem;
    text-align: center;
  }
  </style>
  