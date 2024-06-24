<template>
  <div>
    <div class="hero-image">
      <img src="../assets/image.jpg" class="hero-image-img">
      <div class="hero-content">
        <NavigationBar></NavigationBar>
        <HeroSection></HeroSection>
      </div>
    </div>
    <CarouselSection id="features"></CarouselSection>
    <hr class="separator" />
    <AboutUs id="about-us"></AboutUs>
    <hr class="separator" />
    <CallToActionSection></CallToActionSection>
  </div>
</template>

<script setup>
import NavigationBar from './NavigationBar.vue';
import HeroSection from './HeroSection.vue';
import CarouselSection from './CarouselSection.vue';
import AboutUs from './AboutUs.vue';
import CallToActionSection from './CallToActionSection.vue';
</script>

<style scoped>
.hero-image {
  position: relative;
  height: 100%;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.hero-image-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  filter: brightness(0.4);
}

.hero-content {
  position: absolute;
  z-index: 1;
  color: white;
  text-align: center;
}

.separator {
  margin-top: 3vh;
}
</style>
