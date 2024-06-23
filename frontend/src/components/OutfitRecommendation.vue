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
            height="700px"
            class="carousels text-white shadow-1"
        >
            <q-carousel-slide
                :name="index"
                v-for="(recommendation, index) in outfitRecommendations"
                :key="recommendation.id"
                class="column no-wrap flex-center"
            >
                <div class="outfit-slide">
                    <div v-for="item in recommendation.items" :key="item.ClothID" class="q-mb-sm item-container">
                        <img :src="getFullImageUrl(item.Picture, item.TypeTitle)" :alt="item.Title" class="item-image" />
                        <div>{{ item.Title }}</div>
                    </div>
                    <div class="buttons-container">
                        <q-btn label="Use This Style" color="primary" @click="useRecommendation(recommendation)" class="q-mr-sm" />
                        <q-btn icon="refresh" color="primary" flat @click="refreshRecommendation" />
                    </div>
                </div>
            </q-carousel-slide>
        </q-carousel>
        <!-- Message for no wardrobes found -->
        <div v-if="noWardrobesFound" class="no-wardrobes-message">
            <p>No wardrobes found. Please add a wardrobe <router-link to="/wardrobes">here</router-link>.</p>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { QCarousel, QCarouselSlide, QBtn } from 'quasar';
import axios from 'axios';
import store from '../store';

const props = defineProps({
    coordinates: Object,
    wardrobeId: String
});

const activeRecommendation = ref(0);
const outfitRecommendations = ref([]);
const noWardrobesFound = ref(false); // State to handle no wardrobes found

const baseURL = 'http://127.0.0.1:8000/storage/clothes/';
const placeholderURL = 'http://127.0.0.1:8000/storage/placeholders/';

const getFullImageUrl = (path, typeTitle) => {
    if (path.includes('/placeholders/')) {
        return `${placeholderURL}${path.split('/').pop()}`;
    }
    return `${baseURL}${path.split('/').pop()}`;
};

const mapResponseToRecommendations = (data) => {
    const coreItems = data.core.map(item => ({
        ClothID: item.ClothID,
        Picture: getFullImageUrl(item.Picture, item.TypeTitle),
        Title: item.Title,
        TypeTitle: item.TypeTitle
    }));

    const extraItems = data.extras.map(item => ({
        ClothID: item.ClothID,
        Picture: getFullImageUrl(item.Picture, item.TypeTitle),
        Title: item.Title,
        TypeTitle: item.TypeTitle
    }));

    return [{
        id: Date.now(),  // Unique identifier for each recommendation
        items: coreItems.concat(extraItems)
    }];
};

const fetchOutfitRecommendations = async () => {
    try {
        console.log('store.state.user.location:', store.state.user.location);
        console.log('props:', props);

        const { currentTemperature, isRainy } = store.state.user.location || {};

        if (currentTemperature === undefined || isRainy === undefined) {
            console.error('Current temperature or rainy status is not defined.');
            return;
        }

        // Clear the current list before fetching new recommendations
        outfitRecommendations.value = [];

        const response = await axios.post(`/wardrobe/${props.wardrobeId}/outfit`, {
            temperature: currentTemperature, 
            isRainy: isRainy 
        }, {
            headers: {
                Authorization: `Bearer ${store.state.authToken}`
            }
        });

        outfitRecommendations.value = mapResponseToRecommendations(response.data);
        noWardrobesFound.value = false; // Reset the no wardrobes found state
    } catch (error) {
        console.error('Failed to fetch outfit recommendations:', error);
        if (error.response && error.response.status === 404) {
            noWardrobesFound.value = true; // Set the state to show no wardrobes message
        }
    }
};

onMounted(() => {
    fetchOutfitRecommendations();
});

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
