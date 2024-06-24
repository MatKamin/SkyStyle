<template>
    <q-layout view="lHh Lpr lFf">
      <NavigationBar />
      <br /><br /><br /><br /><br /><br />
      <q-page-container>
        <q-page class="q-pa-md">
          <div class="wardrobes">
            <div v-if="wardrobes.length === 0" class="centered-content">
              <p class="text-white">No wardrobes could be found.</p>
              <b-button variant="primary" @click="openAddDialog" class="q-mt-md">Create New Wardrobe</b-button>
            </div>
            <div v-else>
              <b-button variant="primary" @click="openAddDialog" class="q-mb-md custom-btn-width">Create New Wardrobe</b-button>
              <q-card class="q-mb-md" v-for="wardrobe in wardrobes" :key="wardrobe.WardrobeID">
                <q-card-section>
                  <div class="row no-wrap items-center">
                    <div class="col-6">
                      <h4>{{ wardrobe.Title }}</h4>
                      <p>{{ wardrobe.clothes_count }} clothes</p>
                    </div>
                    <div class="col-6 text-right button-container">
                      <b-button variant="primary" @click="openWardrobe(wardrobe.WardrobeID, wardrobe.Title)" class="q-mr-sm button-fixed-width">Open</b-button>
                      <b-button variant="warning" @click="openEditDialog(wardrobe)" class="q-mr-sm button-fixed-width">Edit</b-button>
                      <b-button variant="danger" @click="removeWardrobe(wardrobe.WardrobeID)" class="q-mr-sm button-fixed-width">Remove</b-button>
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
            <div class="text-h6 text-center">{{ isEditMode ? 'Edit Wardrobe' : 'Create New Wardrobe' }}</div>
          </q-card-section>
  
          <q-card-section class="q-pa-lg custom-width centered-content">
            <b-form @submit.stop.prevent="isEditMode ? updateWardrobe() : addWardrobe()">
              <b-form-group label="Title" :state="!$v.newWardrobe.title.$error" class="q-mb-md input-center">
                <b-form-input v-model="newWardrobe.title" :state="!$v.newWardrobe.title.$error"></b-form-input>
                <b-form-invalid-feedback v-if="$v.newWardrobe.title.$error">Title is required</b-form-invalid-feedback>
              </b-form-group>
  
              <b-form-group label="Description" :state="!$v.newWardrobe.description.$error" class="input-center">
                <b-form-textarea v-model="newWardrobe.description" :state="!$v.newWardrobe.description.$error"></b-form-textarea>
                <b-form-invalid-feedback v-if="$v.newWardrobe.description.$error">Description is required</b-form-invalid-feedback>
              </b-form-group>
  
              <div v-if="serverErrors" class="text-danger">{{ serverErrors }}</div>
  
              <q-card-actions align="right" class="q-pr-lg q-pb-lg q-pt-none">
                <b-button variant="secondary" @click="dialog = false">Cancel</b-button>
                <b-button variant="primary" type="submit">Submit</b-button>
              </q-card-actions>
            </b-form>
          </q-card-section>
        </q-card>
      </q-dialog>
    </q-layout>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  import { useVuelidate } from '@vuelidate/core';
  import { required } from '@vuelidate/validators';
  import { QLayout, QPageContainer, QPage, QCard, QCardSection, QDialog, QCardActions } from 'quasar';
  import NavigationBar from './NavigationBar.vue';
  import axios from 'axios';
  import store from '../store';
  
  const wardrobes = ref([]);
  const dialog = ref(false);
  const isEditMode = ref(false);
  const currentWardrobeId = ref(null);
  const newWardrobe = ref({
    title: '',
    description: ''
  });
  const router = useRouter();
  const serverErrors = ref(null);
  
  const rules = {
    newWardrobe: {
      title: { required },
      description: { required }
    }
  };
  
  const $v = useVuelidate(rules, { newWardrobe });
  
  const fetchWardrobes = async () => {
    try {
      const token = store.state.authToken;
      const response = await axios.get('/wardrobes', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      wardrobes.value = response.data.wardrobes;
    } catch (error) {
      console.error('Failed to fetch wardrobes:', error);
    }
  };
  
  const openWardrobe = (wardrobeId, wardrobeTitle) => {
    router.push({ name: 'WardrobeDetails', params: { wardrobeId } });
  };
  
  const removeWardrobe = async (wardrobeId) => {
    try {
      const token = store.state.authToken;
      console.log(`Removing wardrobe with ID: ${wardrobeId}`);
      await axios.delete(`/wardrobe/${wardrobeId}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      wardrobes.value = wardrobes.value.filter(wardrobe => wardrobe.WardrobeID !== wardrobeId);
    } catch (error) {
      console.error('Failed to remove wardrobe:', error);
    }
  };
  
  const addWardrobe = async () => {
    await $v.value.$touch();
    if ($v.value.$invalid) {
      return;
    }
    try {
      const token = store.state.authToken;
      const response = await axios.post('/wardrobe', {
        Title: newWardrobe.value.title,
        Description: newWardrobe.value.description
      }, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      wardrobes.value.push(response.data.wardrobe);
      dialog.value = false;
      newWardrobe.value.title = '';
      newWardrobe.value.description = '';
    } catch (error) {
      serverErrors.value = error.response?.data?.message || 'Failed to add wardrobe';
      console.error('Failed to add wardrobe:', error);
    }
  };
  
  const openAddDialog = () => {
    isEditMode.value = false;
    newWardrobe.value.title = '';
    newWardrobe.value.description = '';
    dialog.value = true;
  };
  
  const openEditDialog = (wardrobe) => {
    isEditMode.value = true;
    currentWardrobeId.value = wardrobe.WardrobeID;
    newWardrobe.value.title = wardrobe.Title;
    newWardrobe.value.description = wardrobe.Description;
    dialog.value = true;
  };
  
  const updateWardrobe = async () => {
    await $v.value.$touch();
    if ($v.value.$invalid) {
      return;
    }
    try {
      const token = store.state.authToken;
      const response = await axios.put(`/wardrobe/${currentWardrobeId.value}`, {
        Title: newWardrobe.value.title,
        Description: newWardrobe.value.description
      }, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      const index = wardrobes.value.findIndex(wardrobe => wardrobe.WardrobeID === currentWardrobeId.value);
      if (index !== -1) {
        wardrobes.value[index] = response.data.wardrobe;
      }
      dialog.value = false;
      newWardrobe.value.title = '';
      newWardrobe.value.description = '';
    } catch (error) {
      serverErrors.value = error.response?.data?.message || 'Failed to update wardrobe';
      console.error('Failed to update wardrobe:', error);
    }
  };
  
  const getErrorMessage = (field) => {
    if (!field.$dirty) return '';
    if (!field.required) return 'This field is required';
    return '';
  };
  
  onMounted(() => {
    fetchWardrobes();
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
  
  .button-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }
  
  .button-fixed-width {
    min-width: 100px;
    max-width: 100px;
  }
  
  .col-6 {
    overflow: hidden;
  }
  
  h4 {
    font-weight: bold;
    line-height: normal;
  }
  
  @media (max-width: 1200px) {
    h4 {
      font-size: 2rem; /* Medium screen font size */
    }
  }
  
  @media (max-width: 768px) {
    .h4 {
      font-size: 2rem;
    }
  }
  
  @media (max-width: 480px) {
    h4 {
      font-size: 1.3rem;
    }
  }
  </style>
  