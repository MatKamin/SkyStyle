<template>
    <q-layout view="lHh Lpr lFf">
      <NavigationBar />
      <br /><br /><br /><br /><br /><br />
      <q-page-container>
        <q-page class="q-pa-md">
          <div class="wardrobe-details">
            <h2>{{ wardrobeName }}</h2>
            <q-card class="q-mb-md" v-for="clothing in clothes" :key="clothing.id">
              <q-card-section>
                <div class="row no-wrap items-center">
                  <div class="col-2">
                    <q-img src="https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png" class="item-image" />
                  </div>
                  <div class="col-4">
                    <h4>{{ clothing.name }}</h4>
                    <p>{{ clothing.type }}</p>
                  </div>
                  <div class="col-6 text-right">
                    <q-btn label="Edit" color="warning" @click="editClothing(clothing.id)" class="q-mr-sm" />
                    <q-btn label="Remove" color="negative" @click="removeClothing(clothing.id)" />
                  </div>
                </div>
              </q-card-section>
            </q-card>
            <q-btn label="Add New Clothing" color="primary" @click="addClothing" class="q-mt-md" />
          </div>
        </q-page>
      </q-page-container>
    </q-layout>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute } from 'vue-router';
  import { QLayout, QHeader, QPageContainer, QPage, QBtn, QCard, QCardSection, QImg } from 'quasar';
  import NavigationBar from './NavigationBar.vue';
  
  const route = useRoute();
  const wardrobeName = ref(route.params.wardrobeName);
  
  const clothes = ref([
    { id: 1, name: 'Coat', type: 'Outerwear' },
    { id: 2, name: 'Scarf', type: 'Accessory' },
    { id: 3, name: 'Gloves', type: 'Accessory' },
  ]);
  
  const addClothing = () => {
    // Logic to add new clothing
    console.log('Add new clothing');
  };
  
  const editClothing = (clothingId) => {
    // Logic to edit the specified clothing
    console.log(`Edit clothing with ID: ${clothingId}`);
  };
  
  const removeClothing = (clothingId) => {
    // Logic to remove the specified clothing
    console.log(`Remove clothing with ID: ${clothingId}`);
  };
  
  onMounted(() => {
    console.log('Clothes in wardrobe:', wardrobeName.value, clothes.value);
  });
  </script>
  
  <style scoped>
  .wardrobe-details {
    width: 70%;
    margin: auto;
  }
  
  .q-card {
    border-radius: 15px;
    overflow: hidden;
  }
  
  .q-header {
    padding: 20px;
  }
  
  .q-mb-md {
    margin-bottom: 16px;
  }
  
  .q-mt-md {
    margin-top: 16px;
  }
  
  .item-image {
    height: 100px;
    width: 100px;
    object-fit: cover;
    border-radius: 8px;
  }
  
  .bg-primary {
    background-color: #007bff;
  }
  
  .text-white {
    color: white;
  }
  </style>
  