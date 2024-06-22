<template>
  <q-layout view="lHh Lpr lFf">
    <NavigationBar />
    <br /><br /><br /><br /><br /><br />
    <q-page-container>
      <q-page class="q-pa-md">
        <template v-if="coordinates.lat !== null && coordinates.lon !== null">
          <WeatherForecast :coordinates="coordinates" />
          <q-separator class="seperator" color="white" inset />
          <OutfitRecommendation :coordinates="coordinates" />
        </template>
        <template v-else>
          <p>Loading...</p>
        </template>
      </q-page>
    </q-page-container>

    <q-dialog v-model="dialog" persistent>
      <q-card>
        <q-card-section>
          <div class="text-h6">Enter your city</div>
        </q-card-section>
        <q-card-section>
          <q-input v-model="city" placeholder="City" />
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Submit" color="primary" @click="fetchCityCoordinates" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-layout>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import { QLayout, QPageContainer, QPage, QDialog, QInput, QBtn, QCard, QCardSection, QCardActions } from 'quasar';
import NavigationBar from './NavigationBar.vue';
import WeatherForecast from './WeatherForecast.vue';
import OutfitRecommendation from './OutfitRecommendation.vue';
import axios from '../axiosConfig';

const store = useStore();
const router = useRouter();

const coordinates = ref({ lat: null, lon: null });
const dialog = ref(false);
const city = ref('');

const logout = async () => {
  try {
    const token = store.state.authToken;
    if (token) {
      await axios.post('/logout', {}, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      store.commit('clearAuthToken');
      store.commit('clearUser');
      router.push('/');
    } else {
      console.error('No auth token found');
    }
  } catch (error) {
    console.error('Error during logout:', error);
  }
};

const fetchCoordinates = async () => {
  const user = store.state.user;
  if (user && user.location) {
    coordinates.value.lat = user.location.lat;
    coordinates.value.lon = user.location.lon;
    return;
  }

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      async (position) => {
        coordinates.value.lat = position.coords.latitude;
        coordinates.value.lon = position.coords.longitude;
        await store.dispatch('reverseGeocode', { lat: coordinates.value.lat, lon: coordinates.value.lon });
      },
      () => {
        dialog.value = true;
      }
    );
  } else {
    dialog.value = true;
  }
};

const fetchCityCoordinates = async () => {
  try {
    await store.dispatch('fetchCoordinates', city.value);
    dialog.value = false;
  } catch (error) {
    console.error('Error fetching city coordinates:', error);
  }
};

watch(() => store.state.user?.location, (newVal) => {
  if (newVal && newVal.lat && newVal.lon) {
    coordinates.value.lat = newVal.lat;
    coordinates.value.lon = newVal.lon;
    dialog.value = false;
  } else {
    dialog.value = true;
  }
}, { immediate: true });

onMounted(async () => {
  if (store.state.authToken) {
    await store.dispatch('fetchUser');
    const user = store.state.user;
    if (!user || !user.location || !user.location.lat || !user.location.lon) {
      fetchCoordinates();
    }
  } else {
    dialog.value = true;
  }
});
</script>

<style scoped>
.q-pa-md {
  padding: 16px;
}

.bg-primary {
  background-color: #007bff;
}

.seperator {
  margin-top: 3vh;
  margin-bottom: 3vh;
}
</style>
