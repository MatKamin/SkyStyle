<template>
    <section class="carousel">
      <q-carousel
        v-model="activeSlide"
        animated
        swipeable
        control-color="white"
        prev-icon="arrow_left"
        next-icon="arrow_right"
        navigation-icon="radio_button_unchecked"
        navigation
        padding
        arrows
        height="300px"
        class="carousels text-white shadow-1"
      >
        <q-carousel-slide
          :name="index"
          v-for="(forecast, index) in displayedWeatherForecasts"
          :key="index"
          class="column no-wrap flex-center"
        >
          <div class="weather-slide">
            <q-icon :name="forecast.icon" size="40px" />
            <div>{{ forecast.date }}</div>
            <div>{{ forecast.time }}</div>
            <div>{{ forecast.temperature }}°C</div>
            <div>{{ forecast.description }}</div>
          </div>
        </q-carousel-slide>
      </q-carousel>
    </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { QCarousel, QCarouselSlide, QIcon } from 'quasar';
import { useStore } from 'vuex';
import { useWindowSize } from '@vueuse/core';
import axios from 'axios';

const activeSlide = ref(0);
const weatherForecasts = ref([]);
const store = useStore();

const { width } = useWindowSize();

// Compute the number of items to display based on screen width
const displayedWeatherForecasts = computed(() => {
  const maxItems = width.value < 768 ? 3 : width.value < 1024 ? 5 : 10; // Adjust numbers as needed
  return weatherForecasts.value.slice(0, maxItems);
});

const getWeatherDescription = (temperature, humidity) => {
  if (humidity > 70) {
    if (temperature > 25) return { description: 'Hot and Humid', icon: 'wb_sunny' };
    if (temperature > 15) return { description: 'Warm and Humid', icon: 'cloud_queue' };
    return { description: 'Cool and Humid', icon: 'umbrella' };
  } else {
    if (temperature > 25) return { description: 'Hot and Dry', icon: 'wb_sunny' };
    if (temperature > 15) return { description: 'Warm and Dry', icon: 'wb_cloudy' };
    return { description: 'Cool and Dry', icon: 'ac_unit' };
  }
};

const fetchWeatherForecasts = async (latitude, longitude) => {
  try {
    const response = await axios.get('/weather', {
      params: {
        latitude,
        longitude,
      },
    });
    const data = response.data;

    console.log('Weather data:', data);

    if (data.hourly && data.hourly.time && data.hourly.temperature_2m && data.hourly.relative_humidity_2m) {
      const currentHour = new Date().getHours();
      const startIndex = data.hourly.time.findIndex(time => new Date(time).getHours() === currentHour);

      const currentTemperature = data.hourly.temperature_2m[startIndex];
      const currentHumidity = data.hourly.relative_humidity_2m[startIndex];
      const isRainy = currentHumidity > 70;

      // Save current weather info to the store
      store.commit('setCurrentWeather', { currentTemperature, isRainy });

      weatherForecasts.value = data.hourly.time.slice(startIndex, startIndex + 10).map((time, index) => {
        const temperature = data.hourly.temperature_2m[startIndex + index];
        const humidity = data.hourly.relative_humidity_2m[startIndex + index];
        const { description, icon } = getWeatherDescription(temperature, humidity);
        const date = new Date(time).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        const hour = new Date(time).toLocaleString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false });
        return {
          date,
          time: hour,
          temperature,
          description,
          icon,
        };
      });
    } else {
      console.error('Unexpected response structure:', data);
    }
  } catch (error) {
    console.error('Failed to fetch weather forecasts:', error);
  }
};

onMounted(() => {
  const { lat, lon } = store.state.user.location;
  fetchWeatherForecasts(lat, lon);
});
</script>

<style scoped>
.carousel {
  width: 70%;
  margin: auto;
}

.q-carousel, .q-panel-parent {
  border-radius: 25px;
}

.weather-slide {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.bg-dark {
  background-color: #343a40;
}

.text-white {
  color: white;
}

.carousels {
  background-color: #444444;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
}



</style>
