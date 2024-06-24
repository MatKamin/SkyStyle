<template>
    <div class="container text-light">
      <NavigationBar />
      <br/><br/><br/><br/><br/><br/>
      <div class="row justify-content-center mt-5">
        <div class="col-md-8">
          <div class="input-group mb-3">
            <input type="text" class="form-control" v-model="location" placeholder="Enter Location" @keydown.enter="fetchWeatherData" />
            <button class="btn btn-primary" @click="fetchWeatherData">Set Location</button>
          </div>
          <div class="weather-details" v-if="weatherData.daily && weatherData.daily.length">
            <div v-for="(day, index) in weatherData.daily" :key="index" class="card mb-3 bg-secondary text-light">
              <div class="card-body">
                <h5 class="card-title">{{ day.date }}</h5>
                <div class="weather-info d-flex align-items-center">
                  <i :class="day.icon" style="font-size: 40px;"></i>
                  <div class="ms-3">
                    <p>{{ day.description }}</p>
                    <p>Temperature: {{ day.temperature }}°C</p>
                    <p>Humidity: {{ day.humidity }}%</p>
                    <p>Wind Speed: {{ day.windSpeed }} km/h</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="current-weather mt-5" v-if="currentWeather.temperature_2m">
            <h4>Current Weather</h4>
            <div class="card bg-secondary text-light">
              <div class="card-body">
                <p>Temperature: {{ currentWeather.temperature_2m }}°C</p>
                <p>Wind Speed: {{ currentWeather.wind_speed_10m }} km/h</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import NavigationBar from './NavigationBar.vue';
  import { useStore } from 'vuex';
  
  const store = useStore();
  const location = ref(store.state.user.location.city); // Prefill with actual location from store %%% store.state.user.location.city %%%
  const weatherData = ref({});
  const currentWeather = ref({});
  const selectedDay = ref(0);
  
  const fetchWeatherData = async () => {
    try {
      const response = await axios.get('/weather', {
        params: { city: location.value },
      });
      weatherData.value = response.data.daily ? response.data : { daily: [] };
      currentWeather.value = response.data.current || {};
      store.commit('setLocation', location.value); // Update store value %%% store.commit('setLocation', location.value) %%%
    } catch (error) {
      console.error('Error fetching weather data:', error);
    }
  };
  
  onMounted(async () => {
    try {
      const response = await axios.get('/weather', {
        params: { city: location.value },
      });
      weatherData.value = response.data.daily ? response.data : { daily: [] };
      currentWeather.value = response.data.current || {};
    } catch (error) {
      console.error('Error fetching weather data:', error);
    }
  });
  </script>
  
  <style scoped>
  .weather-info {
    display: flex;
    align-items: center;
  }
  
  .weather-info div {
    margin-left: 10px;
  }
  
  .mt-5 {
    margin-top: 3rem !important;
  }
  
  .mb-3 {
    margin-bottom: 1rem !important;
  }
  
  .form-control {
    color: white;
  }
  </style>
  