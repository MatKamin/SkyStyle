<template>
    <q-layout view="lHh Lpr lFf">
      
      <NavigationBar />
      <br/><br/><br/><br/><br/><br/>
  
      <q-page-container>
        <q-page class="q-pa-md">
          <q-card>
            <q-card-section>
              <div class="profile">
                
                <img :src="user.avatar" :alt="user.name" class="custom-image"/>
                
                <h2>{{ user.name }}</h2>
                <p>{{ user.email }}</p>
                <q-separator />
                <div class="profile-details">
                  <q-item v-for="(value, key) in user.details" :key="key" class="q-mb-md">
                    <q-item-section>
                      <q-item-label>{{ key }}</q-item-label>
                      <q-item-label caption>{{ value }}</q-item-label>
                    </q-item-section>
                  </q-item>
                </div>
              </div>
            </q-card-section>
          </q-card>
        </q-page>
      </q-page-container>
    </q-layout>
  </template>
  
  <script setup>
  import { computed } from 'vue';
  import { useStore } from 'vuex';
  import { QLayout, QHeader, QPageContainer, QPage, QCard, QCardSection, QAvatar, QSeparator, QItem, QItemSection, QItemLabel } from 'quasar';
  import NavigationBar from './NavigationBar.vue';
  import { format } from 'date-fns';  // Import date-fns for date formatting
  
  const store = useStore();
  
  const user = computed(() => ({
    name: store.state.user?.name || 'User Name', // %%% user.name from store
    email: store.state.user?.email || 'user@example.com', // %%% user.email from store
    avatar: store.state.user?.avatar || 'https://hwchamber.co.uk/wp-content/uploads/2022/04/avatar-placeholder.gif', // %%% user.avatar from store
    details: store.state.user?.details || {
      'Joined': format(new Date(store.state.user?.created_at), 'MMMM d, yyyy') || 'Date not available' // %%% user.created_at formatted
    }
  }));
  </script>
  
  <style scoped>
  .profile {
    text-align: center;
  }
  
  .q-avatar img {
    border-radius: 50%;
  }
  
  .profile-details {
    margin-top: 20px;
    text-align: left;
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
  
  .custom-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 90%;
  }
  
  h2 {
    font-size: 2rem;
  }
  </style>
  