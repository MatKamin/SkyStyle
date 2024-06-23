<template>
    <div>
      <h2 class="text-white subheader fs-1">About Us</h2>
  
      <!-- First Paragraph with Image on Right -->
      <div class="custom-margin">
        <b-container fluid class="margin-bottom containers">
          <b-row class="align-items-center">
            <b-col md="7">
              <p class="text-white fs-4 about-us-text">
                At SkyStyle, we believe in the perfect blend of <span class="highlight">fashion and functionality.</span> Our platform is designed to make your life easier by offering smart outfit recommendations tailored to the weather. Whether it's a sunny day, a rainy afternoon, or a chilly evening, SkyStyle ensures you're dressed appropriately and stylishly. No more guesswork – just stylish, weather-appropriate attire every day. With SkyStyle, embrace a <span class="highlight">hassle-free</span> way of staying fashionable, no matter what the forecast says.
              </p>
            </b-col>
            <b-col md="5" class="d-flex justify-content-center">
              <q-img 
                src="../assets/style_1.jpg" 
                alt="Fashion and Functionality"
                class="about-us-image"
              />
            </b-col>
          </b-row>
        </b-container>
  
        <!-- Second Paragraph with Image on Left -->
        <b-container fluid class="containers">
          <b-row class="align-items-center">
            <b-col md="5" class="d-flex justify-content-center">
              <q-img 
                src="../assets/style_2.jpg" 
                alt="Passionate Team"
                class="about-us-image"
              />
            </b-col>
            <b-col md="7" class="d-flex justify-content-end">
              <p class="text-white fs-4 about-us-text2">
                Our team is passionate about fashion and technology. We use <span class="highlight">cutting-edge AI</span> to analyze your wardrobe and the latest weather data to provide you with the best outfit suggestions. Our advanced algorithms take into account your personal style, the season, and upcoming trends to ensure you always look your best. Join us on this journey to revolutionize how you dress and experience the perfect <span class="highlight">fusion of technology and style.</span> With SkyStyle, transform your wardrobe and step out with confidence every day.
              </p>
            </b-col>
          </b-row>
        </b-container>
      </div>
    </div>
  </template>
  
  <script setup>
  import { BContainer, BRow, BCol } from 'bootstrap-vue-next';
  import { QImg } from 'quasar';
  </script>
  
  <style scoped>
  .subheader {
    margin-left: 5em;
    margin-top: 5em;
    margin-bottom: 1em;
  }
  
  .about-us-image {
    max-width: 100%;
    height: auto;
    max-height: 700px;
    border-radius: 10px;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
  }
  
  .about-us-text {
    max-width: 50%;
    margin-left: 5em;
  }
  
  .about-us-text2 {
    max-width: 50%;
    margin-right: 5em;
    text-align: right;
  }
  
  .custom-margin {
    margin-left: 10em;
    margin-right: 10em;
  }
  
  .margin-bottom {
    margin-bottom: 8em;
  }
  
  .highlight {
    color: #23b6f5ac;
  }
  
  .containers {
    background-color: hsla(0, 0%, 100%, 0.144);
    padding: 3em;
    border-radius: 25px;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
  }
  
  /* Media Queries for Responsiveness */
  @media (max-width: 1200px) {
    .subheader {
      margin-left: 3em;
      margin-right: 3em;
      text-align: center;
    }
  
    .about-us-text, .about-us-text2 {
      max-width: 100%;
      margin-left: 2em;
      margin-right: 2em;
    }
  
    .custom-margin {
      margin-left: 5em;
      margin-right: 5em;
    }
    
  }
  
  @media (max-width: 768px) {
    .subheader {
      margin-left: 2em;
      margin-right: 2em;
      text-align: center;
    }
  
    .about-us-text, .about-us-text2 {
      max-width: 100%;
      margin-left: 1em;
      margin-right: 1em;
    }
  
    .custom-margin {
      margin-left: 2em;
      margin-right: 2em;
    }
  
    .about-us-image {
      max-width: 100%;
    }
  }
  
  @media (max-width: 480px) {
    .subheader {
      margin-left: 1em;
      margin-right: 1em;
      text-align: center;
    }
  
    .about-us-text, .about-us-text2 {
      max-width: 100%;
      margin-left: 0.5em;
      margin-right: 0.5em;
    }
  
    .custom-margin {
      margin-left: 1em;
      margin-right: 1em;
    }
  
    .about-us-image {
      max-width: 100%;
    }
  }
  </style>
  