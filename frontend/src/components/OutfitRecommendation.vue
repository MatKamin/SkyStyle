<template>
    <section class="carousel">
        <q-carousel
            v-if="!noWardrobesFound"
            v-model="activeRecommendation"
            animated
            swipeable
            control-color="white"
            prev-icon="arrow_left"
            next-icon="arrow_right"
            navigation-icon="radio_button_unchecked"
            navigation
            padding
            arrows
            height="1000px"
            class="carousels text-white shadow-1"
        >
            <q-carousel-slide
                :name="index"
                v-for="(recommendation, index) in displayedOutfitRecommendations"
                :key="recommendation.id"
                class="column no-wrap flex-center"
            >
                <!-- Message for not enough core items -->
                <div v-if="notEnoughCoreItems[index] == 'invalid'" class="no-wardrobes-message">
                    <p>Not enough Core Items in Wardrobe.</p>
                </div>
                <div v-if="notEnoughCoreItems[index] == 'valid'" class="outfit-slide">
                    <div v-for="item in recommendation.items" :key="item.ClothID" class="q-mb-sm item-container">
                        <img :src="getFullImageUrl(item.Picture, item.TypeTitle)" :alt="item.Title" class="item-image" />
                        <div>{{ item.Title }}</div>
                    </div>
                    <div class="buttons-container">
                        <q-btn icon="refresh" color="primary" flat @click="refreshRecommendation" />
                    </div>
                </div>
            </q-carousel-slide>
        </q-carousel>
        <!-- Message for no wardrobes found -->
        <div v-if="noWardrobesFound" class="no-wardrobes-message">
            <p>No wardrobes and/or clothes found. <router-link to="/wardrobes">Add here</router-link>.</p>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import { useRoute } from 'vue-router';
import { QCarousel, QCarouselSlide, QBtn } from 'quasar';
import axios from 'axios';
import store from '../store';
import { useWindowSize } from '@vueuse/core';

const props = defineProps({
    coordinates: Object,
    wardrobeId: String
});

const activeRecommendation = ref(store.state.indexCarousel); // Initialize with the value from the store
const outfitRecommendations = ref([]);
const noWardrobesFound = ref(false);
const notEnoughCoreItems = ref([]); // Changed to an array

const baseURL = 'http://127.0.0.1:8000/storage/clothes/';
const placeholderURL = 'http://127.0.0.1:8000/storage/placeholders/';

const getFullImageUrl = (path, typeTitle) => {
    if (path.includes('/placeholders/')) {
        return `${placeholderURL}${path.split('/').pop()}`;
    }
    return `${baseURL}${path.split('/').pop()}`;
};

const { width } = useWindowSize();

const displayedOutfitRecommendations = computed(() => {
    const maxItems = width.value < 768 ? 3 : width.value < 1024 ? 5 : 10; // Adjust numbers as needed
    return outfitRecommendations.value.slice(0, maxItems);
});

const mapResponseToRecommendations = (data, index, notEnoughCoreItemsArray) => {
    const coreItems = data.core.map(item => ({
        ClothID: item.ClothID,
        Picture: getFullImageUrl(item.Picture, item.TypeTitle),
        Title: item.Title,
        TypeTitle: item.TypeTitle
    }));

    notEnoughCoreItemsArray[index] = coreItems.length < 3 ? 'invalid' : 'valid';

    if (notEnoughCoreItemsArray[index] === 'invalid') {
        return { id: Date.now(), items: [] };
    }

    const extraItems = data.extras.map(item => ({
        ClothID: item.ClothID,
        Picture: getFullImageUrl(item.Picture, item.TypeTitle),
        Title: item.Title,
        TypeTitle: item.TypeTitle
    }));

    return {
        id: Date.now(),  // Unique identifier for each recommendation
        items: coreItems.concat(extraItems)
    };
};

const fetchOutfitRecommendations = async () => {
    try {
        console.log('store.state.user.location:', store.state.user.location);
        console.log('props:', props);

        // Clear the current list before fetching new recommendations
        outfitRecommendations.value = [];
        let localNotEnoughCoreItems = []; // Local array to collect results

        const forecasts = store.state.weatherForecasts; // Get 10-day weather forecast from the store

        console.log('Forecasts:', forecasts);

        if (!Array.isArray(forecasts) || forecasts.length === 0) {
            throw new Error('Weather forecasts are not available or not an array');
        }

        for (const [index, forecast] of forecasts.entries()) {
            const { temperature, humidity } = forecast;
            const isRainy = humidity > 70; // Determine if it's rainy based on humidity

            const response = await axios.post(`/wardrobe/${props.wardrobeId}/outfit`, {
                temperature: temperature,
                isRainy: isRainy
            }, {
                headers: {
                    Authorization: `Bearer ${store.state.authToken}` //%%% Insert the authorization token
                }
            });

            const recommendations = mapResponseToRecommendations(response.data, index, localNotEnoughCoreItems);
            outfitRecommendations.value.push(recommendations);
        }

        // Update the reactive array once all data is processed
        notEnoughCoreItems.value = localNotEnoughCoreItems;

        noWardrobesFound.value = false; // Reset the no wardrobes found state
    } catch (error) {
        console.error('Failed to fetch outfit recommendations:', error);
        if (error.response && error.response.status === 404) {
            noWardrobesFound.value = true; // Set the state to show no wardrobes message
        }
    }
};

// Fetch recommendations when the component is mounted
onMounted(() => {
    // Watch for changes in the weather forecasts and fetch recommendations once they are available
    const unwatch = watch(
        () => store.state.weatherForecasts,
        (newForecasts) => {
            if (newForecasts && Array.isArray(newForecasts) && newForecasts.length > 0) {
                fetchOutfitRecommendations();
                unwatch(); // Stop watching once the data is fetched
            }
        },
        { immediate: true }
    );
});

// Watch for changes in activeRecommendation and update the store
watch(activeRecommendation, (newValue) => {
    store.commit('setIndexCarousel', newValue);
});

// Watch for changes in store's indexCarousel and update activeRecommendation
watch(() => store.state.indexCarousel, (newValue) => {
    activeRecommendation.value = newValue;
});

// Fetch recommendations when the wardrobe ID changes
watch(() => props.wardrobeId, (newWardrobeId) => {
    if (newWardrobeId) {
        fetchOutfitRecommendations();
    }
});

const refreshRecommendation = () => {
    fetchOutfitRecommendations();
};

const useRecommendation = (recommendation) => {
    // Logic to handle the user using the recommended style
};
</script>

<style scoped>
.carousel {
    width: 90%;
    margin: auto;
}

.q-carousel,
.q-panel-parent {
    border-radius: 25px;
    overflow: hidden; /* Hides the scrollbar */
}

.outfit-slide {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 20px 0px;
}

.item-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 10px;
}

.item-image {
    height: 150px;
    max-width: 150px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 5px;
}

.buttons-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    padding-bottom: 5em;
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

.no-wardrobes-message {
    text-align: center;
    margin-top: 20px;
    color: white;
}
</style>
