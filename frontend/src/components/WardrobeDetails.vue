<template>
    <q-layout view="lHh Lpr lFf">
      <NavigationBar />
      <br /><br /><br /><br /><br /><br />
      <q-page-container>
        <q-page class="q-pa-md">
          <div class="wardrobe-details">
            <h2>{{ wardrobeName }}</h2>
            <div v-if="clothes.length === 0" class="centered-content">
              <p class="text-white">No clothes could be found.</p>
              <q-btn label="Add New Clothing" color="primary" @click="openAddDialog" class="q-mt-md" />
            </div>
            <div v-else>
              <q-card class="q-mb-md" v-for="clothing in clothes" :key="clothing.ClothID">
                <q-card-section>
                  <div class="row no-wrap items-center">
                    <div class="col-2">
                      <q-img :src="getFullImageUrl(clothing.Picture)" class="item-image" />
                    </div>
                    <div class="col-4">
                      <h4>{{ clothing.Title }}</h4>
                      <p v-if="clothing.type">{{ clothing.type.Title }}</p>
                      <p v-else>Unknown Type</p>
                    </div>
                    <div class="col-6 text-right">
                      <q-btn label="Edit" color="warning" @click="openEditDialog(clothing)" class="q-mr-sm" />
                      <q-btn label="Remove" color="negative" @click="removeClothing(clothing.ClothID)" />
                    </div>
                  </div>
                </q-card-section>
              </q-card>
              <q-btn label="Add New Clothing" color="primary" @click="openAddDialog" class="q-mt-md" />
            </div>
          </div>
        </q-page>
      </q-page-container>
  
      <q-dialog v-model="dialog" persistent>
        <q-card class="centered-card">
          <q-card-section>
            <div class="text-h6 text-center">{{ isEditMode ? 'Edit Clothing' : 'Add New Clothing' }}</div>
          </q-card-section>
  
          <q-card-section class="q-pa-lg custom-width centered-content">
            <q-input v-model="newClothing.title" label="Title" filled class="q-mb-md input-center" />
            <q-input v-model="newClothing.description" label="Description" filled type="textarea" class="input-center" />
            <q-file ref="fileInput" v-model="newClothing.picture" label="Picture" filled class="q-mb-md input-center" />
            <q-select v-model="newClothing.typeId" :options="types" option-value="TypeID" option-label="Title" label="Type" filled class="q-mb-md input-center" />
          </q-card-section>
  
          <q-card-actions align="right" class="q-pr-lg q-pb-lg q-pt-none">
            <q-btn flat label="Cancel" color="secondary" @click="closeDialog" />
            <q-btn flat class="large-btn" label="Submit" color="primary" @click="isEditMode ? updateClothing() : addClothing()" />
          </q-card-actions>
        </q-card>
      </q-dialog>
    </q-layout>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute } from 'vue-router';
  import { QLayout, QPageContainer, QPage, QBtn, QCard, QCardSection, QImg, QDialog, QInput, QCardActions, QSelect, QFile } from 'quasar';
  import NavigationBar from './NavigationBar.vue';
  import axios from 'axios';
  import store from '../store';
  
  const baseURL = 'http://127.0.0.1:8000/storage/clothes/';
  
  const route = useRoute();
  const wardrobeId = ref(route.params.wardrobeId);
  const wardrobeName = ref('Wardrobe Details');
  const clothes = ref([]);
  const dialog = ref(false);
  const isEditMode = ref(false);
  const currentClothingId = ref(null);
  const newClothing = ref({
    title: '',
    description: '',
    picture: null,
    linkToBuy: 'none',
    typeId: null
  });
  const types = ref([]);
  
  const getFullImageUrl = (path) => {
    return baseURL + path.split('/').pop();
  };
  
  const fetchClothes = async () => {
    try {
      const token = store.state.authToken;
      const response = await axios.get(`/wardrobe/${wardrobeId.value}/all-clothes`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      clothes.value = response.data.clothes;
      // Debug log for image paths
      clothes.value.forEach(clothing => {
        console.log('Image Path:', getFullImageUrl(clothing.Picture));
      });
    } catch (error) {
      console.error('Failed to fetch clothes:', error);
    }
  };
  
  const fetchTypes = async () => {
    try {
      const token = store.state.authToken;
      const response = await axios.get('/types', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      types.value = response.data.types;
    } catch (error) {
      console.error('Failed to fetch types:', error);
    }
  };
  
  const openAddDialog = () => {
    isEditMode.value = false;
    resetNewClothing();
    dialog.value = true;
  };
  
  const openEditDialog = (clothing) => {
    isEditMode.value = true;
    currentClothingId.value = clothing.ClothID;
    newClothing.value.title = clothing.Title;
    newClothing.value.description = clothing.Description;
    newClothing.value.picture = null; // Reset to null
    newClothing.value.linkToBuy = clothing.LinkToBuy;
    newClothing.value.typeId = clothing.TypeID;
    dialog.value = true;
  };
  
  const closeDialog = () => {
    resetNewClothing();
    dialog.value = false;
  };
  
  const resetNewClothing = () => {
    newClothing.value.title = '';
    newClothing.value.description = '';
    newClothing.value.picture = null;
    newClothing.value.linkToBuy = 'none';
    newClothing.value.typeId = null;
  
    // Reset file input
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
      fileInput.value = '';
    }
  };
  
  const addClothing = async () => {
    try {
      const token = store.state.authToken;
      const formData = new FormData();
      formData.append('Title', newClothing.value.title);
      formData.append('Description', newClothing.value.description);
      formData.append('Picture', newClothing.value.picture); // File object
      formData.append('LinkToBuy', 'none'); // Default value
      formData.append('TypeID', newClothing.value.typeId.TypeID);
      formData.append('WardrobeID', wardrobeId.value);
  
      const response = await axios.post('/clothes', formData, {
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-Type': 'multipart/form-data'
        }
      });
      clothes.value.push(response.data.cloth);
      closeDialog();
    } catch (error) {
      console.error('Failed to add clothing:', error);
    }
  };
  
  const updateClothing = async () => {
  try {
    const token = store.state.authToken;

    const formData = new FormData();
    formData.append('_method', 'PUT'); // Specify the HTTP method as PUT

    if (newClothing.value.title) {
      formData.append('Title', newClothing.value.title);
    }
    if (newClothing.value.description) {
      formData.append('Description', newClothing.value.description);
    }
    formData.append('LinkToBuy', newClothing.value.linkToBuy || 'none');
    if (newClothing.value.typeId.TypeID) {
      formData.append('TypeID', newClothing.value.typeId.TypeID);
    }
    if (newClothing.value.picture) {
      formData.append('Picture', newClothing.value.picture);
    }

    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'multipart/form-data'
      }
    };

    const response = await axios.post(`/clothes/${currentClothingId.value}`, formData, config);

    const index = clothes.value.findIndex(clothing => clothing.ClothID === currentClothingId.value);
    if (index !== -1) {
      clothes.value[index] = response.data.cloth; // Update the local state with new data
    }
    closeDialog(); // Close dialog after successful update
  } catch (error) {
    console.error('Failed to update clothing:', error);

    // Log detailed error response
    if (error.response && error.response.data) {
      console.error('Error response data:', error.response.data);
    }
  }
};







  
  const removeClothing = async (clothingId) => {
    try {
      const token = store.state.authToken;
      await axios.delete(`/clothes/${clothingId}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      clothes.value = clothes.value.filter(clothing => clothing.ClothID !== clothingId);
    } catch (error) {
      console.error('Failed to remove clothing:', error);
    }
  };
  
  onMounted(() => {
    fetchClothes();
    fetchTypes();
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
  
  .centered-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
  }
  
  .centered-card {
    width: 75vw;
    height: 50vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  
  .text-center {
    text-align: center;
  }
  
  .custom-width {
    width: 80%;
  }
  
  .input-center {
    width: 100%;
    margin-left: auto;
    margin-right: auto;
  }
  
  .large-btn {
    font-size: 1.2em;
    padding: 0.75em 1.5em;
  }
  </style>
  