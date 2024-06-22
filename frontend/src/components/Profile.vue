<template>
    <q-layout view="lHh Lpr lFf">
      
      <NavigationBar />
      <br/><br/><br/><br/><br/><br/>
  
      <q-page-container>
        <q-page class="q-pa-md">
          <q-card>
            <q-card-section>
              <div class="profile">
                <q-avatar size="100px" class="q-mb-md">
                  <img :src="user.avatar" :alt="user.name" />
                </q-avatar>
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
  
  const store = useStore();
  
  const user = computed(() => ({
    name: store.state.user?.name || 'User Name',
    email: store.state.user?.email || 'user@example.com',
    avatar: store.state.user?.avatar || 'https://www.wemove.at/wp-content/uploads/2022/06/placeholder.png',
    details: store.state.user?.details || {
      'Joined': 'January 1, 2020',
      'Last Login': 'Today'
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
  </style>
  