<template>
    <div class="container text-light">
      <NavigationBar />
      <br /><br /><br /><br /><br /><br />
      <div class="row justify-content-center mt-5">
        <div class="col-md-8">
          <div class="input-group mb-3">
            <input type="text" class="form-control" v-model="location" placeholder="Enter Location" />
            <button class="btn btn-primary" @click="fetchCoordinates">Set Location</button>
          </div>
          <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
          <div class="weather-details" v-if="weatherData.length">
            <div v-for="(day, index) in weatherData" :key="index" class="card mb-3 bg-secondary text-light">
              <div class="card-body">
                <h5 class="card-title">{{ day.date }}</h5>
                <div class="weather-info d-flex align-items-center">
                  <i :class="day.icon" style="font-size: 40px;"></i>
                  <div class="ms-3">
                    <p>{{ day.description }}</p>
                    <p>Max Temperature: {{ day.temperature_max }}°C</p>
                    <p>Min Temperature: {{ day.temperature_min }}°C</p>
                    <p>Apparent Max Temperature: {{ day.apparent_temperature_max }}°C</p>
                    <p>Apparent Min Temperature: {{ day.apparent_temperature_min }}°C</p>
                    <p>Sunrise: {{ day.sunrise }}</p>
                    <p>Sunset: {{ day.sunset }}</p>
                    <p>Daylight Duration: {{ day.daylight_duration }} s</p>
                    <p>Sunshine Duration: {{ day.sunshine_duration }} s</p>
                    <p>UV Index Max: {{ day.uv_index_max }}</p>
                    <p>UV Index Clear Sky Max: {{ day.uv_index_clear_sky_max }}</p>
                    <p>Precipitation: {{ day.precipitation_sum }} mm</p>
                    <p>Rain: {{ day.rain_sum }} mm</p>
                    <p>Showers: {{ day.showers_sum }} mm</p>
                    <p>Snowfall: {{ day.snowfall_sum }} cm</p>
                    <p>Precipitation Hours: {{ day.precipitation_hours }} h</p>
                    <p>Precipitation Probability Max: {{ day.precipitation_probability_max }}%</p>
                    <p>Wind Speed Max: {{ day.wind_speed_max }} km/h</p>
                    <p>Wind Gusts Max: {{ day.wind_gusts_max }} km/h</p>
                    <p>Dominant Wind Direction: {{ day.wind_direction_dominant }}°</p>
                    <p>Shortwave Radiation Sum: {{ day.shortwave_radiation_sum }} MJ/m²</p>
                    <p>Evapotranspiration: {{ day.et0_fao_evapotranspiration }} mm</p>
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
  
  const location = ref(''); // Removed reference to Vuex store for location
  const weatherData = ref([]);
  const currentWeather = ref({});
  const errorMessage = ref('');
  
  const fetchCoordinates = async () => {
    if (!location.value) return;
    try {
      const response = await axios.get('/get-coords-for-city', {
        params: { city: location.value },
      });
      if (response.data && response.data.lat && response.data.lon) {
        fetchWeatherData(response.data.lat, response.data.lon);
        errorMessage.value = '';
      } else {
        errorMessage.value = 'City not found';
      }
    } catch (error) {
      console.error('Error fetching coordinates:', error);
      errorMessage.value = 'City not found';
    }
  };
  
  const fetchWeatherData = async (latitude, longitude) => {
    try {
      const response = await axios.get('https://api.open-meteo.com/v1/forecast', {
        params: {
          latitude,
          longitude,
          daily: 'weather_code,temperature_2m_max,temperature_2m_min,apparent_temperature_max,apparent_temperature_min,sunrise,sunset,daylight_duration,sunshine_duration,uv_index_max,uv_index_clear_sky_max,precipitation_sum,rain_sum,showers_sum,snowfall_sum,precipitation_hours,precipitation_probability_max,wind_speed_10m_max,wind_gusts_10m_max,wind_direction_10m_dominant,shortwave_radiation_sum,et0_fao_evapotranspiration',
          timezone: 'Europe/Vienna',
        },
      });
  
      if (response.data.daily) {
        const dailyData = response.data.daily;
        weatherData.value = dailyData.time.map((time, index) => ({
          date: time,
          weather_code: dailyData.weather_code[index],
          temperature_max: dailyData.temperature_2m_max[index],
          temperature_min: dailyData.temperature_2m_min[index],
          apparent_temperature_max: dailyData.apparent_temperature_max[index],
          apparent_temperature_min: dailyData.apparent_temperature_min[index],
          sunrise: dailyData.sunrise[index],
          sunset: dailyData.sunset[index],
          daylight_duration: dailyData.daylight_duration[index],
          sunshine_duration: dailyData.sunshine_duration[index],
          uv_index_max: dailyData.uv_index_max[index],
          uv_index_clear_sky_max: dailyData.uv_index_clear_sky_max[index],
          precipitation_sum: dailyData.precipitation_sum[index],
          rain_sum: dailyData.rain_sum[index],
          showers_sum: dailyData.showers_sum[index],
          snowfall_sum: dailyData.snowfall_sum[index],
          precipitation_hours: dailyData.precipitation_hours[index],
          precipitation_probability_max: dailyData.precipitation_probability_max[index],
          wind_speed_max: dailyData.wind_speed_10m_max[index],
          wind_gusts_max: dailyData.wind_gusts_10m_max[index],
          wind_direction_dominant: dailyData.wind_direction_10m_dominant[index],
          shortwave_radiation_sum: dailyData.shortwave_radiation_sum[index],
          et0_fao_evapotranspiration: dailyData.et0_fao_evapotranspiration[index]
        }));
      }
  
      currentWeather.value = response.data.current_weather || {};
    } catch (error) {
      console.error('Error fetching weather data:', error);
    }
  };
  
  onMounted(async () => {
    // No automatic fetch on mount since location is not preset
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
  