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
            <b-button variant="primary" @click="openAddDialog" class="q-mt-md">Add New Clothing</b-button>
          </div>
          <div v-else>
            <b-button variant="primary" @click="openAddDialog" class="q-mb-md custom-btn-width">Add New Clothing</b-button>
            <q-card class="q-mb-md" v-for="clothing in clothes" :key="clothing.ClothID">
              <q-card-section>
                <div class="row no-wrap items-center clothing-item">
                  <div class="col-2 item-image-wrapper">
                    <q-img :src="getFullImageUrl(clothing.Picture, clothing.type.Title)" class="item-image" />
                  </div>
                  <div class="col-4 item-details">
                    <h4>{{ clothing.Title }}</h4>
                    <p v-if="clothing.type">{{ clothing.type.Title }}</p>
                  </div>
                  <div class="col-6 text-right item-buttons">
                    <b-button variant="warning" @click="openEditDialog(clothing)" class="q-mr-sm button-responsive">Edit</b-button>
                    <b-button variant="danger" @click="removeClothing(clothing.ClothID)" class="button-responsive">Remove</b-button>
                  </div>
                </div>
              </q-card-section>
            </q-card>
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
          <b-form @submit.stop.prevent="isEditMode ? updateClothing() : addClothing()">
            <b-form-group label="Title" :state="!$v.newClothing.title.$error" class="q-mb-md input-center custom-margin">
              <b-form-input v-model="newClothing.title" :state="!$v.newClothing.title.$error"></b-form-input>
              <b-form-invalid-feedback v-if="$v.newClothing.title.$error">Title is required</b-form-invalid-feedback>
            </b-form-group>

            <b-form-group label="Description" :state="!$v.newClothing.description.$error" class="input-center">
              <b-form-textarea v-model="newClothing.description" :state="!$v.newClothing.description.$error"></b-form-textarea>
              <b-form-invalid-feedback v-if="$v.newClothing.description.$error">Description is required</b-form-invalid-feedback>
            </b-form-group>

            <b-form-group label="Type" :state="!$v.newClothing.typeId.$error" class="input-center">
              <b-form-select v-model="newClothing.typeId" :options="formattedTypes" :state="!$v.newClothing.typeId.$error"></b-form-select>
              <b-form-invalid-feedback v-if="$v.newClothing.typeId.$error">Type is required</b-form-invalid-feedback>
            </b-form-group>

            <b-form-group label="Picture" class="q-mb-md input-center">
              <b-form-file v-model="newClothing.picture" class="q-mb-md input-center"></b-form-file>
            </b-form-group>

            <div v-if="serverErrors" class="text-danger">{{ serverErrors }}</div>

            <q-card-actions align="right" class="q-pr-lg q-pb-lg q-pt-none">
              <b-button class="custom-margin" variant="secondary" @click="closeDialog">Cancel</b-button>
              <b-button class="custom-margin" variant="primary" type="submit">Submit</b-button>
            </q-card-actions>
          </b-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-layout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';  // Import computed from vue
import { useRoute } from 'vue-router';
import { useVuelidate } from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import { QLayout, QPageContainer, QPage, QCard, QCardSection, QImg, QDialog, QCardActions } from 'quasar';
import NavigationBar from './NavigationBar.vue';
import axios from 'axios';
import store from '../store';

const baseURL = 'http://127.0.0.1:8000/storage/clothes/';
const placeholderURL = 'http://127.0.0.1:8000/storage/placeholders/';

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
const serverErrors = ref(null);

const rules = {
  newClothing: {
    title: { required },
    description: { required },
    typeId: { required }
  }
};

const $v = useVuelidate(rules, { newClothing });

const getFullImageUrl = (path, typeTitle) => {
  if (!path) {
    return `${placeholderURL}${typeTitle.toLowerCase()}.jpg`;
  } else if (path.includes('/placeholders/')) {
    return placeholderURL + path.split('/').pop();
  } else {
    return baseURL + path.split('/').pop();
  }
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

const formattedTypes = computed(() => {
  return types.value.map(type => ({
    value: type.TypeID,
    text: type.Title
  }));
});

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

  const fileInput = document.querySelector('input[type="file"]');
  if (fileInput) {
    fileInput.value = '';
  }
};

const addClothing = async () => {
  await $v.value.$touch();
  if ($v.value.$invalid) {
    return;
  }
  try {
    const token = store.state.authToken;
    const formData = new FormData();
    formData.append('Title', newClothing.value.title);
    formData.append('Description', newClothing.value.description);
    if (newClothing.value.picture) {
      formData.append('Picture', newClothing.value.picture); // File object
    }
    formData.append('LinkToBuy', 'none'); // Default value
    formData.append('TypeID', newClothing.value.typeId);
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
    serverErrors.value = error.response?.data?.message || 'Failed to add clothing';
    console.error('Failed to add clothing:', error);
  }
};

const updateClothing = async () => {
  await $v.value.$touch();
  if ($v.value.$invalid) {
    return;
  }
  try {
    const token = store.state.authToken;
    const formData = new FormData();
    //formData.append('_method', 'PUT'); // Specify the HTTP method as PUT

    if (newClothing.value.title) {
      formData.append('Title', newClothing.value.title);
    }
    if (newClothing.value.description) {
      formData.append('Description', newClothing.value.description);
    }
    formData.append('LinkToBuy', newClothing.value.linkToBuy || 'none');
    if (newClothing.value.typeId) {
      formData.append('TypeID', newClothing.value.typeId);
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

    const response = await axios.post(`/clothes/${currentClothingId.value}`, formData, config); // Keep using POST method

    const index = clothes.value.findIndex(clothing => clothing.ClothID === currentClothingId.value);
    if (index !== -1) {
      clothes.value[index] = response.data.cloth; // Update the local state with new data
    }
    closeDialog(); // Close dialog after successful update
  } catch (error) {
    serverErrors.value = error.response?.data?.message || 'Failed to update clothing';
    console.error('Failed to update clothing:', error);
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

.centered-card::-webkit-scrollbar {
  display: none;
}

.centered-card {
  width: 75vw;
  height: 50vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  overflow: scroll;
  padding-top: 3rem;
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.text-h6 {
  margin-bottom: 3rem;
  font-weight: bold;
}


.text-center {
  text-align: center;
}

.custom-width {
  width: 80%;
}

.custom-btn-width {
  width: 100%;
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

.custom-margin {
  margin-top: 5px;
}

@media (max-width: 1065px) {
  .clothing-item {
    flex-direction: column;
    align-items: center;
  }

  .item-image-wrapper,
  .item-details,
  .item-buttons {
    width: 100%;
    text-align: center;
  }

  .item-details h4,
  .item-details p {
    margin: 0;
    margin-top: 15px;
    margin-bottom: 15px;
  }

  .item-buttons {
    display: flex;
    justify-content: center;
  }

  .button-responsive {
    width: 100px;
  }

  .item-details p {
    display: none;
  }
}
</style>
