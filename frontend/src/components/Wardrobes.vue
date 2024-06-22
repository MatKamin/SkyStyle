<template>
    <q-layout view="lHh Lpr lFf">
      <NavigationBar />
      <br /><br /><br /><br /><br /><br />
      <q-page-container>
        <q-page class="q-pa-md">
          <div class="wardrobes">
            <q-card class="q-mb-md" v-for="wardrobe in wardrobes" :key="wardrobe.id">
              <q-card-section>
                <div class="row no-wrap items-center">
                  <div class="col-6">
                    <h4>{{ wardrobe.name }}</h4>
                    <p>{{ wardrobe.clothes.length }} clothes</p>
                  </div>
                  <div class="col-6 text-right">
                    <q-btn label="Open" color="primary" @click="openWardrobe(wardrobe.name)" class="q-mr-sm" />
                    <q-btn label="Edit" color="warning" @click="editWardrobe(wardrobe.id)" class="q-mr-sm" />
                    <q-btn label="Remove" color="negative" @click="removeWardrobe(wardrobe.id)" />
                  </div>
                </div>
              </q-card-section>
            </q-card>
            <q-btn label="Create New Wardrobe" color="primary" @click="createWardrobe" class="q-mt-md" />
          </div>
        </q-page>
      </q-page-container>
    </q-layout>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  import { QLayout, QHeader, QPageContainer, QPage, QBtn, QCard, QCardSection } from 'quasar';
  import NavigationBar from './NavigationBar.vue';
  
  const wardrobes = ref([
    { id: 1, name: 'Winter Wardrobe', clothes: ['Coat', 'Scarf', 'Gloves'] },
    { id: 2, name: 'Summer Wardrobe', clothes: ['T-Shirt', 'Shorts', 'Sandals'] },
  ]);
  
  const router = useRouter();
  
  const openWardrobe = (wardrobeName) => {
    router.push(`/wardrobe/${wardrobeName}`);
  };
  
  const addClothes = (wardrobeId) => {
    // Logic to add clothes to the specified wardrobe
    console.log(`Add clothes to wardrobe with ID: ${wardrobeId}`);
  };
  
  const editWardrobe = (wardrobeId) => {
    // Logic to edit the specified wardrobe
    console.log(`Edit wardrobe with ID: ${wardrobeId}`);
  };
  
  const removeWardrobe = (wardrobeId) => {
    // Logic to remove the specified wardrobe
    console.log(`Remove wardrobe with ID: ${wardrobeId}`);
  };
  
  const createWardrobe = () => {
    // Logic to create a new wardrobe
    console.log('Create a new wardrobe');
  };
  
  onMounted(() => {
    console.log('Wardrobes:', wardrobes.value);
  });
  </script>
  
  <style scoped>
  .wardrobes {
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
  
  .bg-primary {
    background-color: #007bff;
  }
  
  .text-white {
    color: white;
  }
  </style>
  