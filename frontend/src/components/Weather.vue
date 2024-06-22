<template>
    <q-layout view="lHh Lpr lFf">

      <NavigationBar />
      <br/><br/><br/><br/><br/><br/>
  
      <q-page-container>
        <q-page class="q-pa-md">
          <div class="weather">
            <q-input v-model="location" placeholder="Enter Location" @keydown.enter="fetchWeatherData" />
            <q-btn label="Set Location" color="primary" @click="fetchWeatherData" class="q-mt-md" />
  
            <div class="weather-details">
              <q-tab-panels v-model="selectedDay" animated>
                <q-tab-panel v-for="(day, index) in weatherData.daily" :key="index" :name="index">
                  <q-card>
                    <q-card-section>
                      <h3>{{ day.date }}</h3>
                      <div class="weather-info">
                        <q-icon :name="day.icon" size="40px" />
                        <div>
                          <p>{{ day.description }}</p>
                          <p>Temperature: {{ day.temperature }}°C</p>
                          <p>Humidity: {{ day.humidity }}%</p>
                          <p>Wind Speed: {{ day.windSpeed }} km/h</p>
                        </div>
                      </div>
                    </q-card-section>
                  </q-card>
                </q-tab-panel>
              </q-tab-panels>
  
              <q-tabs
                v-model="selectedDay"
                align="left"
                dense
                active-color="primary"
                class="q-mt-md"
              >
                <q-tab v-for="(day, index) in weatherData.daily" :key="index" :name="index" :label="day.date" />
              </q-tabs>
            </div>
          </div>
        </q-page>
      </q-page-container>
    </q-layout>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { QLayout, QHeader, QPageContainer, QPage, QBtn, QCard, QCardSection, QTabPanels, QTabPanel, QTabs, QTab, QInput, QIcon } from 'quasar';
  import NavigationBar from './NavigationBar.vue';
  import axios from 'axios';
  
  const location = ref('New York'); // Default location
  const weatherData = ref({
    daily: [
      {
        date: 'Monday',
        icon: 'wb_sunny',
        description: 'Sunny',
        temperature: 25,
        humidity: 50,
        windSpeed: 10
      },
      // Add more days as needed
    ]
  });
  const selectedDay = ref(0);
  
  const fetchWeatherData = async () => {
    // Replace with actual API call
    console.log(`Fetching weather data for location: ${location.value}`);
    // Example API call using axios
    // const response = await axios.get(`API_URL`, { params: { location: location.value } });
    // weatherData.value = response.data;
  };
  
  onMounted(() => {
    fetchWeatherData();
  });
  </script>
  
  <style scoped>
  .weather {
    width: 90%;
    margin: auto;
  }
  
  .weather-details {
    margin-top: 20px;
  }
  
  .weather-info {
    display: flex;
    align-items: center;
  }
  
  .weather-info div {
    margin-left: 10px;
  }
  
  .q-header {
    padding: 20px;
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
  