<template>
  <div>
    <NavigationBar></NavigationBar>
    <HeroSection></HeroSection>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

import NavigationBar from './components/NavigationBar.vue';
import HeroSection from './components/HeroSection.vue';
import FeatureCards from './components/FeatureCards.vue';

</script>
